<?php

/**
 * 获取物流配置
 *
 */
class LogisticsConf{

    public function getConf($logName){
        $config = IniFileOpe::getIniFile(APP_PATH.'/library/logistics/config.ini', $logName);
        return $config;
    }

    public function getNetPointSurplus($logName, $data = array()){
        $class_name = $this->getLogClass($logName);
        $method_name = $this->requestMethod('balance');

        $log_class = new $class_name;
        return $log_class->$method_name($data);
    }

    public function doLogAction($logName, $data = array(), $callback = null){
        $class_name = $this->getLogClass($logName);
        $method_name = $this->requestMethod('create');

        $log_class = new $class_name;
        $result = $log_class->$method_name($data, $callback? $callback:$this);
        return $result;
    }

    public function doCallback($result){
        $order_sn = $result->Order->OrderCode;      // 平台订单编号
        $ship_code = $result->Order->ShipperCode;   // 快递公司编码
        $log_code = $result->Order->LogisticCode;   // 物流单号
        $template = $result->PrintTemplate;

        $obj = OrderLogistics::findFirst("order_sn = $order_sn");

        if(count($obj)){
            $obj->logistics_num = $log_code;
            $obj->code = $ship_code;
            $obj->template = $template;
            $obj->addtime = time();
            $obj->save();
        }
    }

    private function requestMethod($method){
        switch ($method) {
            case 'create':
                $method = 'createWebLogistics';
                break;

            case 'balance':
                $method = 'checkBalance';
                break;

            case 'quick':
                $method = 'quickLogistics';
                break;
        }

        return $method;
    }

    private function getLogClass($logName){
        $class_name = '';
        switch ($logName) {
            case 'kdniao':
                $class_name = 'KDLogistics';
                break;

            // case '':
            //     $class_name = '';
            //     break;

            default:
                $class_name = 'KDLogistics';
                break;
        }

        return $class_name;
    }
}