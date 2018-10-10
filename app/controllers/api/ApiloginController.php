<?php

/**
 * 用户登陆
 * @author xiao
 *
 */
class ApiloginController extends ApiBase{

    public function indexAction(){
    }
    
    //***************************
    //  授权登录接口
    //***************************
    public function authloginAction(){
    	$openid = $_POST['openid'];
    	if (!$openid) {
    		echo json_encode(array('status'=>0,'err'=>'授权失败！'.__LINE__));
    		exit();
    	}
    	$con = array();
    	$con['openid'] = trim($openid);
    	
    	$userinfo = User::findFirstByOpenid($openid);
    	if ($userinfo) {
    		$userinfo->openid = $openid; $userinfo->save();
    		$userinfo = $userinfo->toArray();
    		if (intval($userinfo['del'])==1) {
    			echo json_encode(array('status'=>0,'err'=>'账号状态异常！'));
    			exit();
    		}
    		$err = array();
    		$err['ID'] = intval($userinfo['id']);
    		$err['NickName'] = $_POST['NickName'];
    		$err['HeadUrl'] = $_POST['HeadUrl'];
    		echo json_encode(array('status'=>1,'arr'=>$err));
    		exit();
    	}else{
    		$user = new User();
    		$user->name		= $_POST['NickName'];
    		$user->uname 	= $_POST['NickName'];
    		$user->pwd		= '123456';
    		$user->photo	= $_POST['HeadUrl'];
    		$user->sex		= $_POST['gender'];
    		$user->openid	= $openid;
    		$user->source	= "wx";
    		$user->addtime	= time();
    		if ($user->save()) {
    			$err = array();
    			$err['ID'] = intval($user->id);
    			$err['NickName'] = $user->name;
    			$err['HeadUrl'] = $user->photo;
    			echo json_encode(array('status'=>1,'arr'=>$err));
    			exit();
    		}else{
    			echo json_encode(array('status'=>0,'err'=>'保存失败！'.__LINE__));
    			exit();
    		}
    	}
    }
    
    //***************************
    //  获取sessionkey 接口
    //***************************
    public function getsessionkeyAction(){
    	//$config = $this->getConfig();
    	//$wx_config = $config->weixin;
    	
    	$wx_config = IniFileOpe::getIniFile( WECHAT.'/config.ini', $this->esbEcode().'-xcx');
    	$appid = $wx_config['appid'];
    	$secret = $wx_config['secret'];
    	
    	$code = isset($_POST['code']) ? trim($_POST['code']) : '';
    	if (!$code) {
    		echo json_encode(array('status'=>0,'err'=>'非法操作！'));
    		exit();
    	}
    	
    	if (!$appid || !$secret) {
    		echo json_encode(array('status'=>0,'err'=>'非法操作！'.__LINE__));
    		exit();
    	}
    	
    	$this_header = array(
    			"content-type: application/x-www-form-urlencoded;charset=UTF-8"
    	);
    	
    	$get_token_url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
    	curl_setopt($ch, CURLOPT_URL, $get_token_url);
    	//curl_setopt($ch, CURLOPT_HEADER, 0);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    	$res = curl_exec($ch);
    	curl_close($ch);
    	
    	//模拟数据
    	//$res= json_encode(array('session_key'=>$res->session_key,'openid'=>$res->openid));
    	
    	echo $res;
    	exit();
    }

}

