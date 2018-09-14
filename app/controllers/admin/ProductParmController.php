<?php

/**
 * 产品参数
 * @author xiao
 *
 */
class ProductParmController extends AdminBase{

    public function indexAction(){

    }

    /**
     * 参数类型列表页
     */
    public function allParmPageAction(){
        $this->assets
             ->addCss("css/static/h-ui/H-ui.min.css")
             ->addCss("css/static/h-ui.admin/H-ui.admin.css")
             ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
             ->addCss("css/static/h-ui.admin/style.css")
             ->addCss("css/layui/layui.css")
             ->addCss("css/pages/admin/public.css")
             ->addJs("lib/jquery/1.9.1/jquery.min.js")
             ->addJs("lib/layer/layer.js")
             ->addJs("lib/layui/layui.js")
             ->addJs("js/static/h-ui/H-ui.min.js")
             ->addJs("js/static/h-ui.admin/H-ui.admin.js")
             ->addJs("js/pages/admin/product/proParm.js");

        // $this->view->proAttrs = $this->proAttrs();

        $this->view->pick("admin/product/proParm");
    }

    /**
     * 获取列表数据
     */
    public function getAllParmAction(){
        $allparm = ProductParm::find(array('conditions'=> "disabled=0"));
        $parm_list = $allparm->toArray();

        //return json_encode(array('code'=>'1', 'msg'=>'','data'=>$parm_list));
        $this->tableData($parm_list);
    }

    /**
     * 删除参数类型
     */
    public function proParmDelAction(){
        if ($this->request->isPost()){
            $ids = is_array($_POST['ids'])? $_POST['ids']:array();
            if(empty($ids)){
                echo json_encode(array('status'=>0, 'msg'=>'请求参数错误'));
                exit;
            }

            $ids = implode(',', $ids);
            $del_data = ProductParm::find("id in ({$ids})");

            if ($del_data){
                foreach ($del_data as $k=>$v){
                    if (!$v->delete()) {
                        echo json_encode(array('status'=>0, 'msg'=>'数据错误'));
                        exit();
                    }
                }

                echo json_encode(array('status'=>1, 'msg'=>'删除成功'));
                exit();
            }else{
                echo json_encode(array('status'=>0, 'msg'=>'未找到对应记录'));
                exit();
            }
        }else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }

    /**
     * 产品属性编辑
     */
    public function proParmAddPageAction(){
        $this->assets
             ->addCss("css/static/h-ui/H-ui.min.css")
             ->addCss("css/static/h-ui.admin/H-ui.admin.css")
             ->addCss("lib/Hui-iconfont/1.0.8/iconfont.css")
             ->addCss("css/static/h-ui.admin/style.css")
             ->addCss("css/pages/admin/product/proParmAdd.css")
             ->addJs("lib/jquery/1.9.1/jquery.min.js")
             ->addJs("js/squire-raw.js")
             ->addJs("lib/layer/layer.js")
             ->addJs("js/static/h-ui/H-ui.min.js")
             ->addJs("js/static/h-ui.admin/H-ui.admin.js")
             ->addJs("lib/datatables/1.10.0/jquery.dataTables.min.js")
             ->addJs("js/pages/admin/product/proParmAdd.js");

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $this->view->parmInfo = $this->proParmInfoAction($id);

        $this->view->pick("admin/product/proParmAdd");
    }
    /**
     * 获取产品属性详情
     */
    private function proParmInfoAction($id){
        $info = array(
            'id'=>'', 't_name'=>'', 'vid'=>'',
            'values'=>array(
            ),
        );

        $parm = ProductParm::findFirstById($id);
        if ($parm){
            $info = $parm->toArray();

            $conditions = array(
                'conditions'=> "id in ({$info['vid']})",
            );
            $value_res = ProductParmValue::find($conditions);
            $value_data = $value_res->toArray();
            $values = array_column($value_data, 'id');

            $arr_order = explode(',', $info['vid']);
            $new_value_array = array();
            foreach($arr_order as $o_k=>$o_v){
                $key = array_search($o_v, $values);
                array_push($new_value_array, $value_data[$key]);
            }
            $info['values'] = $new_value_array;

            foreach($info['values'] as $k=>&$v){
                if(isset($v['value']) && $v['value']){
                    $v['value'] = implode('|', json_decode($v['value'], true));
                }
            }

        }

        return $info;
    }

    /**
     * 选择产品页面
     */
    public function chooseProPageAction(){
        $this->assets
        ->addCss("css/main.css")
        ->addJs("lib/jquery/1.9.1/jquery.min.js");

        $choosed = isset($_GET['proId']) ? intval($_GET['proId']) : '';

        $this->view->prolists = json_encode(self::shopProListAction(), true);
        $this->view->choosed = $choosed;

        $this->view->pick("admin/groupBooking/choosePro");
    }
    /**
     * 获取店铺商品列表
     */
    private function shopProListAction(){
        $proArr = array(); $num = 0;
        $shopId = $this->session->get('sid');

        $conditions = array(
                'conditions'=> "shop_id=?1 and del=?2",
                'bind'      => array(1=>$shopId, 2=>0)
        );
        $count = Product::find($conditions);

        $pros = Product::find($conditions);

        if ($pros) $proArr = $pros->toArray();

        return $proArr;
    }
    /**
     * 保存产品属性
     */
    public function savePramAttrAction(){
        if ($this->request->isPost()){
            $post_data = $_POST;

            $err_msg = '';
            if(!isset($post_data['name']) && trim($post_data['name'])==""){
                $err_msg = "类型名称不能为空";
            }

            if($err_msg){
                echo json_encode(array('status'=>0, 'msg'=>$err_msg));
                exit();
            }else{
                $type_obj = new ProductParm();
                $parm_obj = new ProductParmValue();

                if(!$post_data['id']){
                    $new_type_obj = clone $type_obj;
                    $new_type_obj->t_name = $post_data['name'];
                    if(!$new_type_obj->save()){
                        echo json_encode(array('status'=>0, 'msg'=>'新建类型保存错误'));
                        exit();
                    }
                    $post_data['id'] = $new_type_obj->id;
                }

                foreach($post_data['option'] as $k=>&$v){
                    if(isset($v['value']) && $v['value']){
                        $v['value'] = json_encode((object) explode('|', $v['value']));
                    }

                    if($v['id']){
                        $new_obj = clone $parm_obj;
                        $res = $new_obj::findFirstById($v['id']);
                        $res->name = $v['name'];
                        $res->type = $v['type'];
                        $res->value = $v['value'];
                    }else{
                        $res = clone $parm_obj;
                        $res->name = $v['name'];
                        $res->type = $v['type'];
                        $res->value = $v['value'];
                    }

                    if(!$res->save()){
                        echo json_encode(array('status'=>0, 'msg'=>'选项参数保存失败'));
                        exit();
                    }
                    $v['id'] = $res->id;
                }

                $id_array = array_column($post_data['option'], 'id');

                $type_res = $type_obj::findFirstById($post_data['id']);
                $type_res->t_name = $post_data['name'];
                $type_res->vid = implode(",", $id_array);
                if($type_res->save()){
                    echo json_encode(array('status'=>1, 'msg'=>'success'));
                    exit();
                }else{
                    echo json_encode(array('status'=>0, 'msg'=>'类型保存失败'));
                    exit();
                }
            }
        }else echo json_encode(array('status'=>0, 'msg'=>'请求方式错误'));
    }
    /**
     * 删除属性值
     */
    private function delAttrValues($datas){
        if ($datas && count($datas)){
            foreach ($datas as $k=>$v){
                $val = ProductAttrValue::findFirstById($v['id']);
                if ($val && $val->pid==$v['pid']) $val->delete();
            }

            //删除产品中sku
        }
    }
    /**
     * 保存属性值
     */
    private function saveAttrValues($datas, $pid){
        foreach ($datas as $k=>$v){
            if ($v['id']){
                $val = ProductAttrValue::findFirstById($v['id']);
                if (!$val || !($val->pid==$pid)) break;
            }else $val = new ProductAttrValue();
            $val->name = $v['name'];
            $val->pid = $pid;
            $val->pname = $v['pname'];
            $val->save();
        }
    }


}

