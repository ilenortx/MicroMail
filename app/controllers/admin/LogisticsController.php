<?php

class LogisticsController extends AdminBase{

    public function indexAction(){
        $this->assets
             ->addCss("css/static/h-ui/H-ui.min.css")
             ->addCss("css/static/h-ui.admin/H-ui.admin.css")
             ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
             ->addCss("css/layui/layui.css")
             ->addCss("css/pages/admin/public.css")
             ->addCss("css/pages/admin/order/order.css")
             ->addJs("lib/jquery/1.9.1/jquery.min.js")
             ->addJs("lib/layer/layer.js")
             ->addJs("lib/layui/layui.js")
             ->addJs("js/pages/admin/pageOpe.js")
             ->addJs("js/pages/admin/logistics/logistics.js");

        $sid = $this->session->get('sid');

        // 快递方式
        $lcs = LogisticsShop::shopAllWl($sid);
        // 发货信息
        $shipping = ShipAddress::getSAs('sid', $sid, array(
                'conditions'=>"shop_id=$sid and status='S1'",
                'order'     => 'sort desc'
        ));

        $availableNum = 0;
        foreach ($lcs as $key => $value) {
            if($value['default']=='D1'){
                $availableNum = $this->changeLogAction(array(
                    'shipperCode'=>$value['code'],
                    'customerName'=>$value['customer_name'],
                    'customerPwd'=>$value['customer_pwd'],
                    'stationCode'=>$value['station_code'],
                    'stationName'=>$value['station_name'],
                ));
            }
        }

        $this->view->availableNum = $availableNum;
        $this->view->logistics = $lcs;
        $this->view->shipping = $shipping;
        $this->view->pick("admin/logistics/index");
    }

    public function printPageAction(){
        $this->assets
             ->addCss("css/static/h-ui/H-ui.min.css")
             ->addCss("css/static/h-ui.admin/H-ui.admin.css")
             ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
             ->addCss("css/layui/layui.css")
             ->addCss("css/pages/admin/public.css")
             ->addJs("lib/jquery/1.9.1/jquery.min.js")
             ->addJs("lib/layer/layer.js")
             ->addJs("lib/layui/layui.js")
             ->addJs("js/pages/admin/pageOpe.js");

        $this->view->pick("admin/logistics/print");
    }

    public function getDataAction(){
        if ($this->request->isGet()){
            //获取页面参数
            $page = (isset($_GET['page'])&&intval($_GET['page'])) ? intval($_GET['page']) : 0;
            $limit = (isset($_GET['limit'])&&intval($_GET['limit'])) ? intval($_GET['limit']) : 0;
            $order_nums = isset($_GET['order_sn'])? implode(',', $_GET['order_sn']):'';

            $sid = $this->session->get('sid');
            $conditions = array(
                'conditions'=> "shop_id=$sid and del=0 and status in(20,30) and order_sn in ($order_nums)",
                'order'     => "addtime desc",
                'limit'     => array("number" => $limit, "offset" => $limit*($page-1))
            );
            $count = Order::getCount("shop_id=$sid and del=0 and status in(20,30) and order_sn in ($order_nums)");

            $orderArr = Order::find($conditions);

            $logistics_data = array();
            foreach ($orderArr as $key => $value) {
                $new_array = array();

                $res = $value->OrderLogistics;
                if($res){
                    $new_array['logistics_num'] = $res->logistics_num;
                    $new_array['template'] = $res->template;
                    $new_array['addtime'] = date('Y-m-d H:i:s', $res->addtime);
                }

                $new_array['order_sn'] = $value->order_sn;
                $new_array['price_h'] = $value->price_h;
                $new_array['remark'] = $value->remark;
                $new_array['status'] = $value->status;
                array_push($logistics_data, $new_array);
            }

            $this->tableData1($count, $logistics_data, 0, '加载成功!');
        }
    }

    public function changeLogAction($data = array()){
        if($this->request->isPost()){
            $ship_id = isset($_POST['shipId'])? $_POST['shipId']:0;

            if(!$ship_id){
                $this->err('缺少参数');
                exit();
            }
            $ship_info = LogisticsShop::findFirstById($ship_id);

            $data = array(
                'shipperCode'=>$ship_info->code,
                'customerName'=>$ship_info->customer_name,
                'customerPwd'=>$ship_info->customer_pwd,
                'stationCode'=>$ship_info->station_code,
                'stationName'=>$ship_info->station_name,
            );
        }

        $log_obj = new LogisticsConf();
        $availableNum = $log_obj->getNetPointSurplus('kdniao', $data) | 0;

        if($this->request->isPost()){
            echo json_encode(array('status'=>1, 'data'=>array('num'=>$availableNum), 'msg'=>"success"));
            exit();
        }else{
            return $availableNum;
        }
    }

    public function createWebLogisticsAction(){
        if ($this->request->isPost()){
            if(!isset($_POST['ship_id'])){
                echo json_encode(array('statis'=>0, 'msg'=>'缺少参数'));
                exit();
            }
            if(!isset($_POST['add_id'])){
                echo json_encode(array('status'=>0, 'msg'=>'缺少参数'));
                exit();
            }
            if(!isset($_POST['data']) || count($_POST['data']) == 0){
                echo json_encode(array('status'=>0, 'msg'=>'请选择订单'));
                exit();
            }

            $orders_array = $_POST['data'];
            $orders_text = implode(',', $orders_array);

            $res_object = Order::find("order_sn in ($orders_text)");
            $log_obj = new LogisticsConf();

            $api_result = false;
            foreach ($res_object as $k => $v) {
                $order_log = $v->OrderLogistics;

                if($order_log && $order_log->logistics_num){
                    continue;
                }else{
                    $logShop_res = LogisticsShop::findFirstById($_POST['ship_id']);
                    $ship_res = ShipAddress::findFirstById($_POST['add_id']);
                    $area_res = Area::getNamesByIds($ship_res->area_ids, ' ');

                    if(!$order_log){
                        $order_log = new OrderLogistics();
                    }

                    $order_log->order_sn = $v->order_sn;
                    $order_log->shipper = $ship_res->fhname;
                    $order_log->address = $area_res.$ship_res->address;
                    $order_log->mobile = $ship_res->tel;
                    $order_log->save();

                    $logistics_data = array(
                        'order'=>$v->toArray(),
                        'shipAddress'=>$ship_res->toArray(),
                        'area'=>explode(' ', $area_res),
                        'products'=>$v->OrderProduct->toArray(),
                        'logisticsShop'=>$logShop_res->toArray(),
                    );
                    // $api_result =
                    $log_obj->doLogAction('kdniao', $logistics_data);   // 调用快递接口
                }
            }

            echo json_encode(array('status'=>1, 'msg'=>"success", "data"=>$api_result));
            exit();
        }else{
            echo json_encode(array('status'=>0, 'msg'=>"请求方式错误"));
            exit();
        }
    }

    public function printAction(){
        if ($this->request->isPost()){
            if(!isset($_POST['data']) || count($_POST['data']) == 0){
                echo json_encode(array('status'=>0, 'msg'=>'请选择订单'));
                exit();
            }

            $orders_array = $_POST['data'];
            $orders_text = implode(',', $orders_array);

            $res_object = Order::find("order_sn in ($order_text)");
            $orders = array();
            foreach ($res_object as $k => $v) {
                if($v->status >= 20 && $v->status <= 30){
                    $push_data = array(
                        'order'=>$v->toArray(),
                        'product'=>$v->OrderProduct->toArray(),
                    );

                }
            }
        }
    }
}