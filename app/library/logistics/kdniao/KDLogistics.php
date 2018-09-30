<?php

/**
 * 快递鸟物流跟踪
 *
 */
class KDLogistics extends LogisticsConf{

    private $appkey;

    private $businessID;

    public function __construct(){
        $config = $this->getConf('kdniao');     // 获取第三方物流账号配置
        if(!$config){
            return false;
        }
        $this->appkey = $config['appkey'];
        $this->businessID = $config['businessID'];
    }

    public function createWebLogistics($data, $callback){   // 创建电子面单
        // $post_url = 'http://sandboxapi.kdniao.cc:8080/kdniaosandbox/gateway/exterfaceInvoke.json';  // 沙盒测试地址
        $post_url = 'http://testapi.kdniao.cc:8081/api/Eorderservice';  // 测试地址
        // $post_url = 'https://api.kdniao.com/api/EOrderService';  // 正式地址

        $requestArray = $this->getCreateRequestData($data); // 获得组合数据
        $requestData = json_encode($requestArray, JSON_UNESCAPED_UNICODE);      // 转json字符串

        $datas = array(
            'RequestData' => urlencode($requestData) ,
            'EBusinessID' => $this->businessID,
            'RequestType' => '1007',
            'DataType' => '2',
        );
        $datas['DataSign'] = $this->sign($requestData, $this->appkey);

        $result = $this->sendPost($post_url, $datas);
        $result = json_decode($result);

        if($result->Success){
            if(method_exists($callback, 'doCallback')){
                $callback->doCallback($result);
            }
            return $result;
        }else{
            return false;
        }
    }

    public function quickLogistics($data, $callback){   // 即时查询
        $post_url = 'http://sandboxapi.kdniao.cc:8080/kdniaosandbox/gateway/exterfaceInvoke.json';

        $requestArray = $this->getQuickRequestData($data);   // 获得组合数据
        $requestData = json_encode($requestArray, JSON_UNESCAPED_UNICODE);      // 转json字符串

        $datas = array(
            'RequestData' => urlencode($requestData),
            'EBusinessID' => $this->businessID,
            'RequestType' => '1002',
            'DataType' => '2',
        );
        $datas['DataSign'] = $this->sign($requestData, $this->appkey);

        $result = $this->sendPost($post_url, $datas);
        $result = json_decode($result);

        if($result->Success==true){
            return $result;
        }else{
            return false;
        }
    }

    // public function orderLogistics($data, $callback){   // 物流跟踪订阅
    //     $post_url = 'http://sandboxapi.kdniao.cc:8080/kdniaosandbox/gateway/exterfaceInvoke.json';

    //     $requestArray = $this->getOrderRequestData($data);    // 获取组合数据
    //     $requestData = json_encode($requestArray, JSON_UNESCAPED_UNICODE);       // 转json字符串

    //     $datas = array(
    //         'RequestData' => urlencode($requestData),
    //         'EBusinessID' => $this->businessID,
    //         'RequestType' => '1008',
    //         'DataType' => '2',
    //     );
    //     $datas['DataSign'] = $this->sign($requestData, $this->appkey);

    //     $result = $this->sendPost($post_url, $datas);
    //     $result = json_decode($result);

    //     if($result->Success==true){
    //         if($callback){
    //             $callback($result);
    //         }
    //     }else{

    //     }
    // }

    public function checkBalance($data){        // 查询客户号单号余量
        $post_url = 'http://sandboxapi.kdniao.cc:8080/kdniaosandbox/gateway/exterfaceInvoke.json';

        $requestArray = array(          // 获得组合数据
            "ShipperCode"=>$data['shipperCode'],
            "CustomerName"=>$data['customerName'],
            "CustomerPwd"=>$data['customerPwd'],
            "StationCode"=>$data['stationCode'],
            "StationName"=>$data['stationName'],
        );
        $requestData = json_encode($requestArray, JSON_UNESCAPED_UNICODE);      // 转json字符串

        $datas = array(
            'RequestData' => urlencode($requestData) ,
            'EBusinessID' => $this->businessID,
            'RequestType' => '1127',
            'DataType' => '2',
        );
        $datas['DataSign'] = $this->sign($requestData, $this->appkey);

        $result = $this->sendPost($post_url, $datas);
        $result = json_decode($result);

        if($result->Success!='false'){
            return $result->AvailableNum;
        }else{
            return false;
        }
    }

    private function getCreateRequestData($data){    // 电子面单数组
        $return_data = array(
            "MemberID"=>"",
            "CustomerName"=>isset($data['logisticsShop']['customer_name'])? $data['logisticsShop']['customer_name']:'',
            "CustomerPwd"=>isset($data['logisticsShop']['customer_pwd'])? $data['logisticsShop']['customer_pwd']:'',
            "MonthCode"=>"",
            "ShipperCode"=>isset($data['logisticsShop']['code'])? $data['logisticsShop']['code']:'',
            "LogisticCode"=>"",
            "ThrOrderCode"=>"",
            "OrderCode"=>$data['order']['order_sn'],
            "PayType"=>"1",
            "ExpType"=>"1",
            "IsReturnSignBill"=>0,
            "OperateRequire"=>"",
            "Cost"=>0,
            "OtherCost"=>0,
            "Receiver"=>array(
                "Company"=>"",
                "Name"=>$data['order']['receiver'],
                "Tel"=>"",
                "Mobile"=>$data['order']['tel'],
                "PostCode"=>"",
                "ProvinceName"=>"广东省",
                "CityName"=>"深圳市",
                "ExpAreaName"=>"福田区",
                "Address"=>"深南大道2009号",
            ),
            "Sender"=>array(
                "Company"=>"",
                "Name"=>$data['shipAddress']['fhname'],
                "Tel"=>"",
                "Mobile"=>$data['shipAddress']['tel'],
                "PostCode"=>"",
                "ProvinceName"=>$data['area'][0],
                "CityName"=>$data['area'][1],
                "ExpAreaName"=>$data['area'][2]? $data['area'][2]:'',
                "Address"=>$data['area'][3]? $data['area'][3] + $data['shipAddress']['address']:$data['shipAddress']['address'],
            ),
            "IsNotice"=>1,
            "StartDate"=>"",
            "EndDate"=>"",
            "Weight"=>0,
            "Quantity"=>0,
            "Volume"=>0,
            "Remark"=>$data['order']['remark'],
            // "AddService"=>array(
            //     array(
            //         "Name"=>"",
            //         "Value"=>"",
            //         "CustomerID"=>"",
            //     ),
            //     array(
            //         "Name"=>"",
            //         "Value"=>"",
            //         "CustomerID"=>"",
            //     ),
            //     array(
            //         "Name"=>"",
            //         "Value"=>"",
            //     ),
            // ),
            "Commodity"=>array(),
            "IsReturnPrintTemplate"=>1,
            "IsSendMessage"=>0,
            // "TemplateSize"=>"180",
        );

        if(isset($data['logisticsShop']['station_code'])){
            $data["SendSite"] = $data['logisticsShop']['station_code'];
        }else if(isset($data['logisticsShop']['station_name'])){
            $data["SendSite"] = $data['logisticsShop']['station_name'];
        }else{
            $data["SendSite"] = "";
        }

        foreach ($data['products'] as $key => $value) {
            array_push($return_data['Commodity'], array(
                "GoodsName"=>$value['name'],
                // "GoodsCode"=>"",
                // "Goodsquantity"=>$value['num'],
                // "GoodsPrice"=>$value['price'],
                // "GoodsWeight"=>"",
                // "GoodsVol"=>"",
                // "GoodsDesc"=>"",
            ));
        }

        return $return_data;
    }

    private function getQuickRequestData($data){    // 即时查询数组
        $return_data = array(
            "OrderCode"=>"",
            "ShipperCode"=>"YTO",
            "LogisticCode"=>"12345678",
        );

        return $return_data;
    }

    // private function getOrderRequestData($data){    // 物流追踪数组
    //     $return_data = array(
    //         "CallBack"=>"",
    //         "MemberID"=>"",
    //         "WareHouseID"=>"",
    //         "CustomerName"=>"",
    //         "CustomerPwd"=>"",
    //         "SendSite"=>"",
    //         "ShipperCode"=>"ZTO",
    //         "LogisticCode"=>"1234561",
    //         "OrderCode"=>"",
    //         "MonthCode"=>"",
    //         "PayType"=>"1",
    //         "ExpType"=>"1",
    //         "Cost"=>"",
    //         "OtherCost"=>"",
    //         "Sender"=>array(
    //             "Company"=>"",
    //             "Name"=>"1255760",
    //             "Tel"=>"0755-0907283",
    //             "Mobile"=>"13700000000",
    //             "PostCode"=>"435100",
    //             "ProvinceName"=>"广东省",
    //             "CityName"=>"深圳市",
    //             "ExpAreaName"=>"福田区",
    //             "Address"=>"测试地址",
    //         ),
    //         "Receiver"=>array(
    //             "Company"=>"",
    //             "Name"=>"1255760",
    //             "Tel"=>"0755-11111111",
    //             "Mobile"=>"13800000123",
    //             "PostCode"=>"435100",
    //             "ProvinceName"=>"广东省",
    //             "CityName"=>"深圳市",
    //             "ExpAreaName"=>"龙华新区",
    //             "Address"=>"测试地址2",
    //         ),
    //         "StartDate"=>"",
    //         "EndDate"=>"",
    //         "Weight"=>"",
    //         "Quantity"=>"",
    //         "Volume"=>"",
    //         "Remark"=>"",
    //         "IsNotice"=>"1",
    //         "IsSendMessage"=>"0",
    //         "AddService"=>array(
    //             array(
    //                 "Name"=>"",
    //                 "Value"=>"",
    //                 "CustomerID"=>"",
    //             ),
    //             array(
    //                 "Name"=>"",
    //                 "Value"=>"",
    //                 "CustomerID"=>"",
    //             ),
    //             array(
    //                 "Name"=>"",
    //                 "Value"=>"",
    //             ),
    //         ),
    //         "Commodity"=>array(
    //             array(
    //                 "GoodsName"=>"书本",
    //                 "Goodsquantity"=>"",
    //                 "GoodsWeight"=>"",
    //             ),
    //         ),
    //         "RequestType"=>"1008",
    //         "DataType"=>"2",
    //     );

    //     return $return_data;
    // }

    private function sendPost($url, $datas) {       // 发起请求
        $temps = array();
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);
        }
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        if(empty($url_info['port']))
        {
            $url_info['port']=80;
        }
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader.= "Host:" . $url_info['host'] . "\r\n";
        $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader.= "Connection:close\r\n\r\n";
        $httpheader.= $post_data;
        $fd = fsockopen($url_info['host'], $url_info['port']);
        fwrite($fd, $httpheader);
        $gets = "";
        $headerFlag = true;
        while (!feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }
        while (!feof($fd)) {
            $gets.= fread($fd, 128);
        }
        fclose($fd);

        return $gets;
    }

    private function sign($data, $appkey) {
        return urlencode(base64_encode(md5($data.$appkey)));
    }

}