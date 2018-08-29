<?php

/**
 * h5首页
 * @author xiao
 *
 */
class WuserController extends ControllerBase{

	/**
	 * 判断用户是否登陆
	 */
	public function loginVerifyAction(){
		if ($this->request->isPost()){
			$uid = isset($_POST['uid']) ? intval($_POST['uid']) : 0;
			$suid = $this->session->get('waUid');

			if (!$uid || $uid!=$suid){
				echo json_encode(array('status'=>0, 'err'=>'未登录')); exit();
			}

			$user = User::findFirstById($uid);
			if ($user && count($user)){
				echo json_encode(array('status'=>1, 'msg'=>'success')); exit();
			}else echo json_encode(array('status'=>0, 'err'=>'用户不存在')); exit();
		}
	}
	public function loginVerify(){
		$loginResult = false;
		$uid = $this->session->get('waUid');
		if ($uid){
			$user = User::findFirstById($uid);
			if (!$user || !count($user)) $loginResult = false;
			else $loginResult = true;
		}else $loginResult = false;
		if (!$loginResult) $this->redirect('WPages/loginPage');
		return $loginResult;
	}

	/**
	 * 用户登陆
	 */
	public function loginAction(){
		if ($this->request->isPost()){
			$account = isset($_POST['account']) ? $_POST['account'] : '';
			$password = isset($_POST['password']) ? $_POST['password'] : '';
			if (!$account || !$password){
				echo json_encode(array('status'=>0, 'err'=>'数据错误')); exit();
			}

			$user = User::findFirstByName($account);
			if (!$user|| !count($user)){
				echo json_encode(array('status'=>0, 'err'=>'账号不存在1')); exit();
			}

			if ($user->pwd == md5($password)){
				$this->session->set('waUid', $user->id);
				echo json_encode(array('status'=>1, 'uid'=>$user->id, '_url'=>$this->cookies->get('_url')->getValue())); exit();
			}else echo json_encode(array('status'=>0, 'err'=>'密码错误')); exit();

		}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误')); exit();
	}

	/**
	 * 用户注册
	 */
	public function registerAction(){
		if ($this->request->isPost()){
			$account = isset($_POST['account']) ? $_POST['account'] : '';
			$password = isset($_POST['password']) ? $_POST['password'] : '';
			$uname = isset($_POST['uname']) ? $_POST['uname'] : '';
			$email = isset($_POST['email']) ? $_POST['email'] : '';
			$tel = isset($_POST['tel']) ? $_POST['tel'] : '';

			if (!$account || !$password || !$tel){
				echo json_encode(array('status'=>0, 'err'=>'数据错误')); exit();
			}

			$uie = User::findFirstByName($account);
			if ($uie && count($uie)){
				echo json_encode(array('status'=>0, 'err'=>'账号已存在')); exit();
			}

			$user = new User();
			$user->name = $account;
			$user->uname = $uname;
			$user->pwd = md5($password);
			$user->addtime = time();
			$user->del = 0;
			$user->tel = $tel;
			$user->email = $email;
			if ($user->save()) echo json_encode(array('status'=>1, 'msg'=>'success'));
			else echo json_encode(array('status'=>0, 'err'=>'注册失败')); exit();
		}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误')); exit();
	}

	/**
	 * 获取用户信息
	 */
	public function userInfoAction(){
		if ($this->request->isPost()){
			$uid = isset($_POST['uid']) ? intval($_POST['uid']) : 0;
			if (!$uid){
				echo json_encode(array('status'=>0, 'err'=>'用户信息错误')); exit();
			}

			$user = User::findFirstById($uid);
			if ($user && count($user)) echo json_encode(array('status'=>1, 'infos'=>$user->toArray()));
			else echo json_encode(array('status'=>0, 'err'=>'用户不存在')); exit();
		}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误')); exit();
	}

	/**
	 * 微信登陆
	 */
	public function wxLoginAction(){
		$this->view->disable();
		// 回调地址
		//$url = urlencode("http://x.viphk.ngrok.org/MicroMail/Wuser/xlgetUserInfo");
		$url = urlencode("https://wx.yingyuncn.com/Wuser/xlgetUserInfo");
		$appid = 'wxaa31ca9ad5395e09';
		$appsecret = 'f50db5476d83b1b78813815cab32aead';
		return $this->response->redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$url.'&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect');
	}
	public function xlgetUserInfoAction(){
		$appid = 'wxaa31ca9ad5395e09';
		$appsecret = 'f50db5476d83b1b78813815cab32aead';

		// 依据code码去获取openid和access_token，自己的后台服务器直接向微信服务器申请即可
		if (isset($_GET['code'])){
			$_SESSION['code'] = $_GET['code'];

			$url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$_GET['code']."&grant_type=authorization_code";
			$res = $this->httpsRequest($url);
			$res = json_decode($res, true);
			$_SESSION['token'] = $res;
		}

		// 依据申请到的access_token和openid，申请Userinfo信息。
		if (isset($_SESSION['token']['access_token'])){
			$url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$_SESSION['token']['access_token']."&openid=".$_SESSION['token']['openid']."&lang=zh_CN";
			$res = $this->httpsRequest($url);
			$res = json_decode($res, true);

			$user = User::findFirstByOpenid($res['openid']);

			if (!$user || !count($user)){//判断用户是否存在
				$user = new User();
				$user->pwd = '';
				$user->addtime = time();
				$user->del = 0;
				$user->tel = '';
				$user->email = '';
				$user->openid = $res['openid'];
				$user->photo = $res['headimgurl'];
			}
			$user->name = $res['nickname'];
			$user->uname = $res['nickname'];

			$this->assets->addCss('css/mui/mui.css')->addJs("lib/jquery/1.9.1/jquery.min.js")->addJs("js/mui/mui.js")->addJs("js/wapApp/app.js");
			
			$this->view->setVar("title", "专致优货");
			$this->view->setVar("isBasePage", false);
			$this->view->setTemplateAfter('wapApp');
			
			$uid = $user->save() ? $user->id : 0;
			$this->session->set('waUid', $uid);
			$this->view->_url = $this->cookies->get('_url')->getValue();
			$this->view->uid = $uid;
			$this->view->pick("wapApp/user/otherLogin");
		}
	}

	/**
	 * 分享获取链接
	 */
	public function wxShareConfAction(){
		require_once PAYMENT."/wechat/lib/WxPay.Config.php";
		WxPayConfig::initPayInfo('zzyh-gzh');

		$jssdk = new JSSDK(WxPayConfig::$appid, WxPayConfig::$secret);
		$signPackage = $jssdk->getSignPackage();

		echo json_encode($signPackage, true); exit();
	}


	/**
	 * 用户登出
	 */
	public function logoutAction(){
		if ($this->request->isPost()){
			$this->session->destroy('uid');
			echo json_encode(array('status'=>1, 'msg'=>'登出成功')); exit();
		}else echo json_encode(array('status'=>0, 'err'=>'请求方式错误')); exit();
	}
}

