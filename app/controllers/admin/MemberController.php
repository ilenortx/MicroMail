<?php

class MemberController extends AdminBase{

    // public function indexAction(){
    //     $this->assets
    //          ->addCss("css/static/h-ui/H-ui.min.css")
    //          ->addCss("css/static/h-ui.admin/H-ui.admin.css")
    //          ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
    //          ->addCss("css/layui/layui.css")
    //          ->addCss("css/pages/admin/public.css")
    //          ->addCss("css/pages/admin/order/order.css")
    //          ->addJs("lib/jquery/1.9.1/jquery.min.js")
    //          ->addJs("lib/layer/layer.js")
    //          ->addJs("lib/layui/layui.js")
    //          ->addJs("js/pages/admin/pageOpe.js")
    //          ->addJs("js/pages/admin/logistics/logistics.js");

    //     $sid = $this->session->get('sid');

    //     // 快递方式
    //     $lcs = LogisticsShop::shopAllWl($sid);
    //     // 发货信息
    //     $shipping = ShipAddress::getSAs('sid', $sid, array(
    //             'conditions'=>"shop_id=$sid and status='S1'",
    //             'order'     => 'sort desc'
    //     ));

    //     $availableNum = 0;
    //     foreach ($lcs as $key => $value) {
    //         if($value['default']=='D1'){
    //             $availableNum = $this->changeLogAction(array(
    //                 'shipperCode'=>$value['code'],
    //                 'customerName'=>$value['customer_name'],
    //                 'customerPwd'=>$value['customer_pwd'],
    //                 'stationCode'=>$value['station_code'],
    //                 'stationName'=>$value['station_name'],
    //             ));
    //         }
    //     }

    //     $this->view->availableNum = $availableNum;
    //     $this->view->logistics = $lcs;
    //     $this->view->shipping = $shipping;
    //     $this->view->pick("admin/logistics/index");
    // }

    public function listAction(){
        $this->assets
             ->addCss("css/static/h-ui/H-ui.min.css")
             ->addCss("css/static/h-ui.admin/H-ui.admin.css")
             ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
             ->addCss("css/layui/layui.css")
             ->addCss("css/pages/admin/public.css")
             ->addJs("lib/jquery/1.9.1/jquery.min.js")
             ->addJs("lib/layer/layer.js")
             ->addJs("lib/layui/layui.js")
             ->addJs("js/pages/admin/pageOpe.js")
             ->addJs("js/pages/admin/member/list.js");

        $this->view->pick("admin/member/list");
    }

    public function addpageAction(){
        $this->assets
             ->addCss("css/static/h-ui/H-ui.min.css")
             ->addCss("css/static/h-ui.admin/H-ui.admin.css")
             ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
             ->addCss("css/layui/layui.css")
             ->addCss("css/pages/admin/public.css")
             ->addCss("css/pages/admin/member/add.css")
             ->addJs("lib/jquery/1.9.1/jquery.min.js")
             ->addJs("lib/layer/layer.js")
             ->addJs("lib/layui/layui.js")
             ->addJs("js/pages/admin/pageOpe.js")
             ->addJs("js/pages/admin/member/add.js");

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $shopId = $this->session->get('sid');

        $this->view->userInfo = User::getUserInfo($id,$shopId);
        $shop_conf = ShopConfig::getShopConf($shopId);

        $this->view->shopConf = $shop_conf;
        $this->view->userId = $id;
        $this->view->shopId = $shopId;

        $this->view->pick("admin/member/add");
    }

    public function getListAction(){
        if ($this->request->isGet()){
            //获取页面参数
            $page = (isset($_GET['page'])&&intval($_GET['page'])) ? intval($_GET['page']) : 0;
            $limit = (isset($_GET['limit'])&&intval($_GET['limit'])) ? intval($_GET['limit']) : 0;

            $user_list = User::getAllUser($limit, $page);

            $this->tableData1($user_list['count'], $user_list['data'], 0, '加载成功!');
        }else{
            echo json_encode(array('status'=>0, 'msg'=>"请求方式错误"));
            exit();
        }
    }

    public function addAction(){
        if ($this->request->isPost()){
            //获取页面参数
            $post_data = $_POST;
            $post_data['user_id'] = isset($post_data['user_id'])? $post_data['user_id']:0;

            $error_msg = '';

            if(!$post_data['tel']){
                $error_msg = '请填写手机号码';
            }else if(!$post_data['jifen']){
                $error_msg = '请填写积分变动详细';
            }

            $shopId = $this->session->get('sid');
            if($post_data['user_id']){
                $user_shop_info = ShopUsers::findFirst(array(
                    'conditions'=> "shop_id = ?1 and user_id = ?2",
                    'bind'=>array(1=>$shopId, 2=>$post_data['user_id']),
                ));
                $shop_config = ShopConfig::getShopConf($shopId);
                $user_info = User::findFirstById($post_data['user_id']);

                $user_info->tel = $post_data['tel'];
                $user_info->email = $post_data['email'];

                if(!$user_info->source){
                    if(!trim($post_data['pwd']) || !trim($post_data['c_pwd'])){
                        $error_msg = "密码输入不能为空";
                    }else if($post_data['pwd'] !== $post_data['c_pwd']){
                        $error_msg = '密码和确认密码不一致';
                    }
                }else{
                    if(!$user_info->source){
                        $user_info->pwd = MD5($post_data['pwd']);
                    }

                    if($user_shop_info){
                        if($user_shop_info->user_lv != $post_data['shop_lv']){
                            $user_shop_info->user_lv = $post_data['shop_lv'];
                            $user_shop_info->exp = $shop_config['lv_info'][$post_data['shop_lv']]['need_exp'] | 0;
                        }
                        $user_shop_info->point = $user_shop_info->point + $post_data['jifen'] > 0? $user_shop_info->point + $post_data['jifen']:0;

                        if(!$user_shop_info->save() || !$user_info->save()){
                            $error_msg = "保存失败";
                        }

                    }else{
                        $shop_user_obj = new ShopUsers();
                        $shop_user_obj->shop_id = $shopId;
                        $shop_user_obj->user_id = $post_data['user_id'];
                        $shop_user_obj->user_lv = $post_data['shop_lv'];
                        $shop_user_obj->exp = $shop_config['lv_info'][$post_data['shop_lv']]['need_exp'];
                        $shop_user_obj->point = $post_data['jifen'];
                        if(!$shop_user_obj->save() || !$user_info->save()){
                            $error_msg = "保存失败";
                        }
                    }
                }

            }else if(!$post_data['user_id']){
                if(!trim($post_data['pwd']) || !trim($post_data['c_pwd'])){
                    $error_msg = '请填写密码';
                }else if($post_data['pwd'] !== $post_data['c_pwd']){
                    $error_msg = '密码和确认密码不一致';
                }else{
                    $post_data['jifen'] = $post_data['jifen'] >= 0? $post_data['jifen']:0;

                    $add_data = array(
                        'name'=>$post_data['name'],
                        'pwd'=>$post_data['pwd'],
                        'tel'=>$post_data['tel'],
                        'email'=>$post_data['email'],
                    );

                    $user_result = User::addUser($add_data);
                    if(!is_string($user_result)){
                        $user_result = $user_result->toArray();

                        $shop_config = ShopConfig::getShopConf($shopId);

                        $shop_user_obj = new ShopUsers();
                        $shop_user_obj->shop_id = $shopId;
                        $shop_user_obj->user_id = $user_result['id'];
                        $shop_user_obj->user_lv = $post_data['shop_lv'];
                        $shop_user_obj->exp = $shop_config['lv_info'][$post_data['shop_lv']]['need_exp'];
                        $shop_user_obj->point = $post_data['jifen'];
                        if(!$shop_user_obj->save()){
                            $error_msg = "保存失败";
                        }
                    }else if($user_result == 'NAME_EXIST'){
                        $error_msg = "用户名重复不能创建";
                    }else{
                        $error_msg = "保存失败";
                    }
                }
            }

            if($error_msg == ''){
                echo json_encode(array('status'=>1, 'msg'=>"保存成功"));
                exit();
            }else{
                echo json_encode(array('status'=>0, 'msg'=>$error_msg));
                exit();
            }
        }else{
            echo json_encode(array('status'=>0, 'msg'=>"请求方式错误"));
            exit();
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

            $return_data = array();
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

                    $order_data = $v->toArray();
                    $order_data['address'] = explode(',', $order_data['address']);

                    $logistics_data = array(
                        'order'=>$order_data,
                        'shipAddress'=>$ship_res->toArray(),
                        'area'=>explode(' ', $area_res),
                        'products'=>$v->OrderProduct->toArray(),
                        'logisticsShop'=>$logShop_res->toArray(),
                    );

                    $api_result = $log_obj->doLogAction('kdniao', $logistics_data);   // 调用快递接口
                    if($api_result['status'] == 0){
                        echo json_encode($api_result);
                        exit();
                    }
                }
            }

            echo json_encode(array('status'=>1, 'msg'=>"success", "data"=>$return_data));
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

            $res_object = Order::find("order_sn in ($orders_text)");
            $orders = array();

            foreach ($res_object as $k => $v) {
                if($v->status >= 20 && $v->status <= 30){

                    $order_product = $v->OrderProduct->toArray();
                    foreach ($order_product as $key => &$value) {
                        $product_data = Product::findFirst("id = ".$value['pid'])->toArray();
                        $attr_data = ProductAttrValue::find("id in (".$value['skuid'].")")->toArray();
                        $attr = array_column($attr_data, 'name', 'pname');
                        $attr_text = '';
                        foreach ($attr as $a_k => $a_v) {
                            $attr_text .= $a_k.':'.$a_v.'/';
                        }

                        $value['pro_number'] = $product_data['pro_number'];
                        $value['pro_attr'] = substr($attr_text, 0, -1);
                    }

                    $order_data = $v->toArray();
                    $order_data['address'] = str_replace(',','', $order_data['address']) | '';
                    $order_data['remark'] = $order_data['remark'] | '';
                    $order_data['note'] = $order_data['note']? $order_data['note']:'';

                    $push_data = array(
                        'order'=>$order_data,
                        'product'=>$order_product,
                    );

                    array_push($orders, $push_data);
                }
            }

            echo json_encode(array('status'=>1, 'msg'=>"success", "data"=>$orders));
            exit();
        }else{
            echo json_encode(array('status'=>0, 'msg'=>"请求方式错误"));
            exit();
        }
    }
}