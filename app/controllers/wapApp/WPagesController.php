<?php

/**
 * h5首页
 * @author xiao
 *
 */
class WPagesController extends ControllerBase{

	public function initialize(){
		$_url = $_GET['_url'];
		if (!strpos($_url,'WPages/loginPage') && !strpos($_url,'WPages/registerPage')){
			$urlArr = explode('?', $this->request->getURI());
			if (count($urlArr)==2) $_url .= '?'.$urlArr[1];
			$this->cookies->set('_url', $_url);
		}

		$this->view->setVar("title", "专致优货");
		$this->view->setVar("isBasePage", false);
		$this->view->setTemplateAfter('wapApp');
	}
	public function afterExecuteRoute($dispatcher){//Action加载完成时执行
		$this->assets->addCss("css/wapApp/common.css");
	}

	/**
	 * 首页
	 */
    public function indexPageAction(){
        $this->view->setVar("isBasePage", true);

    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/index/index.css")
	    	 ->addCss("css/wapApp/swiper.min.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/swiper.min.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/index/index.js");

		$this->view->pick("wapApp/index/index");
    }

    /**
     * 分类页面
     */
    public function cateGoryPageAction(){
    	$this->view->title = "分类";
        $this->view->setVar("isBasePage", true);

    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/category/category.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/category/category.js");

    	$this->view->pick("wapApp/category/category");
    }
    /**
     * 分类产品页面
     */
    public function categoryProsPagesAction(){
    	$this->view->title = "分类商品";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/category/categoryPros.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/mui/mui.js")
             ->addJs("js/wapApp/template.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/category/categoryPros.js");

	    	 $this->view->cgid = $_GET['cgid'];

    	$this->view->pick("wapApp/category/categoryPros");
    }

    /**
     * 购物车页面
     */
    public function cartPageAction(){
    	$this->view->title = "购物车";
        $this->view->setVar("isBasePage", true);

    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/cart/cart.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/cart/cart.js");

    	$wu = new WuserController();
    	if ($wu->loginVerify()) $this->view->pick("wapApp/cart/cart");
    	else $this->dispatcher->forward(array("controller"=>"WPages", "action"=>"loginPage"));
    }

    /**
     * 商品详情页
     */
    public function proDetailPageAction(){
    	$this->view->title = "商品详情";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/product/proDetail.css")
	    	 ->addCss("css/wapApp/swiper.min.css")
	    	 ->addCss("css/wapApp/video-js.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/swiper.min.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/product/proDetail.js");

	    $productId = isset($_GET['productId']) ? intval($_GET['productId']) : 0;
	    $this->view->productId = $productId;

	    $pro = Product::findFirstById($productId);
	    $this->view->proInfo = $pro->toArray();

    	$this->view->pick("wapApp/product/proDetail");
    }

    /**
     * 商品促销页
     */
    public function productCxPageAction(){
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/product/productCx.css")
	    	 ->addCss("css/wapApp/video-js.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/product/productCx.js");

	    $cxid= isset($_GET['cxid']) ? intval($_GET['cxid']) : 0;
	    $this->view->cxid = $cxid;

    	$this->view->pick("wapApp/product/productCx");
    }
    /**
     * 商品说明
     */
    public function serviceNotePageAction(){
    	$this->view->title = "服务说明";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/product/serviceNote.css")
	    	 ->addCss("css/wapApp/video-js.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/product/serviceNote.js");

	    $proid= isset($_GET['proid']) ? intval($_GET['proid']) : 0;
	    $this->view->proid= $proid;

    	$this->view->pick("wapApp/product/serviceNote");
    }

    /**
     * 搜索页面
     */
    public function searchPageAction(){
    	$this->view->title = "搜索";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/product/search.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/product/search.js");

    	$productId = isset($_GET['productId']) ? intval($_GET['productId']) : 0;
    	$this->view->productId = $productId;

    	$this->view->pick("wapApp/product/search");
    }

    /**
     * 更多商品页面
     */
    public function promorePageAction(){
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/product/promore.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/product/promore.js");

    	$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
    	$this->view->cid = $cid;

    	$this->view->pick("wapApp/product/promore");
    }


    /**
     * 我的界面
     */
    public function mypageAction(){
    	$this->view->title = "我的";
        $this->view->setVar("isBasePage", true);

    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/user/user.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/user/user.js");

    	if (WuserController::loginVerify()) $this->view->pick("wapApp/user/user");
    }
    /**
     * 登陆界面
     */
    public function loginPageAction(){
    	$this->view->title = "登陆";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/user/login.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/user/login.js");

	    $this->view->pick("wapApp/user/login");
    }
    /**
     * 用户注册界面
     */
    public function registerPageAction(){
    	$this->view->title = "注册";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/user/register.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/user/register.js");

    	$this->view->pick("wapApp/user/register");
    }

    /**
     * 地址列表界面
     */
    public function myAddressPageAction(){
    	$this->view->title = "我的地址";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/address/myAddress.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/address/myAddress.js");

	    $orderInfo = '';
	    if ($this->cookies->has('orderInfo') && !empty($this->cookies->get('orderInfo'))){
	    	$orderInfo = $this->cookies->get('orderInfo')->getValue();
	    }
	    $this->view->orderInfo = $orderInfo;

    	if (WuserController::loginVerify()) $this->view->pick("wapApp/address/myAddress");
    }
    public function myAddressPage1Action(){
    	$this->view->title = "我的地址";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/address/myAddress.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/address/myAddress.js");

    	$orderInfo = '';
    	if (isset($_POST['orderInfo']) && !empty($_POST['orderInfo'])){
    		$this->cookies->set('orderInfo', json_encode(json_decode($_POST['orderInfo'])));
    		$orderInfo = $_POST['orderInfo'];
    	}else if ($this->cookies->has('orderInfo') && !empty($this->cookies->get('orderInfo'))){
    		$orderInfo = $this->cookies->get('orderInfo')->getValue();
    	}
    	$this->view->orderInfo = $orderInfo;

    	if (WuserController::loginVerify()) $this->view->pick("wapApp/address/myAddress");
    }
    /**
     * 地址编辑界面
     */
    public function addressEditPageAction(){
    	$this->view->title = "地址编辑";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/chooseCity/layout.min.css")
	    	 ->addCss("css/wapApp/chooseCity/scs.min.css")
	    	 ->addCss("css/wapApp/address/addressEdit.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/jquery.scs.min.js")
	    	 ->addJs("js/wapApp/CNAddrArr.min.js")
	    	 ->addJs("js/wapApp/address/addressEdit.js");

	    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	    $aArr = array('id'=>'', 'name'=>'', 'address'=>'', 'address_xq'=>'', 'tel'=>'');
	    if ($id){
	    	$ainfo = Address::findFirstById($id);
	    	if ($ainfo) $aArr = $ainfo->toArray();
	    }
	    $this->view->ainfo = $aArr;
    	$this->view->pick("wapApp/address/addressEdit");
    }

    /**
     * 订单
     */
    public function orderPageAction(){
    	$this->view->title = "订单";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/order/order.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/order/order.js");

	    $oitem = isset($_GET['oitem']) ? $_GET['oitem'] : 0;
	    $this->view->oitem = $oitem;
	    if (WuserController::loginVerify()) $this->view->pick("wapApp/order/order");
    }
    public function paymentPageAction(){
    	$this->view->title = "订单支付";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/order/payment.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/order/payment.js");
	    if (WuserController::loginVerify()) {
	    	$user = User::findFirst($this->session->get('waUid'));

	    	if (empty($user->openid)){
	    		require_once PAYMENT."/wechat/lib/WxPay.Config.php";
	    		WxPayConfig::initPayInfo('zzyh-gzh');
	    		$tools = new WxJsApi();
	    		$openid = $tools->GetOpenid();
	    		$user->openid = $openid; $user->save();
	    	}
	    	$oid= isset($_GET['oid']) ? $_GET['oid'] : 0;
	    	$this->view->oid= $oid;

	    	$this->view->pick("wapApp/order/payment");
	    }
    }
    public function orderDetailPageAction(){
    	$this->view->title = "订单详情";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/order/orderDetail.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/order/orderDetail.js");

	    $orderId= isset($_GET['orderId']) ? $_GET['orderId'] : 0;
	    $this->view->orderId= $orderId;
	    if (WuserController::loginVerify()) $this->view->pick("wapApp/order/orderDetail");
    }
    public function orderPayPageAction(){
    	$this->view->title = "支付";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/order/orderPay.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/order/orderPay.js");

// 	    $orderInfo = '';
// 	    if (isset($_POST['orderInfo']) && !empty($_POST['orderInfo'])){
// 	    	$this->cookies->set('orderInfo', json_encode(json_decode($_POST['orderInfo'])));
// 	    	$orderInfo = $_POST['orderInfo'];
// 	    }else if ($this->cookies->has('orderInfo') && !empty($this->cookies->get('orderInfo'))){
// 	    	$orderInfo = $this->cookies->get('orderInfo')->getValue();
// 	    }
// 	    $this->view->orderInfo = $orderInfo;
	    if (WuserController::loginVerify()) $this->view->pick("wapApp/order/orderPay");
    }

    /**
     * 领券中心
     */
    public function voucherPageAction(){
    	$this->view->title = "领取中心";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/voucher/voucher.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/voucher/voucher.js");

    	$this->view->pick("wapApp/voucher/voucher");
    }

    /**
     * 我的优惠券
     */
    public function myVoucherPageAction(){
    	$this->view->title = "我的优惠券";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/voucher/myVoucher.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/voucher/myVoucher.js");

	    if (WuserController::loginVerify()) $this->view->pick("wapApp/voucher/myVoucher");
    }

    /**
     * 收藏
     */
    public function collectPageAction(){
    	$this->view->title = "收藏";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/collect/collect.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/collect/collect.js");

	    if (WuserController::loginVerify()) $this->view->pick("wapApp/collect/collect");
    }

    /**
     * 服务中心
     */
    public function serviceListPageAction(){
    	$this->view->title = "服务中心";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/service/serviceList.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/service/serviceList.js");

    	$this->view->pick("wapApp/service/serviceList");
    }
    public function serviceDetailPageAction(){
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/service/serviceList.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/service/serviceDetail.js");

	    $scid = isset($_GET['scid']) ? $_GET['scid'] : 0;
	    $this->view->scid = $scid;
    	$this->view->pick("wapApp/service/serviceDetail");
    }

    /**
     * 关于我们
     */
    public function aboutUsPageAction(){
    	$this->view->title = "关于我们";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/user/aboutUs.js");


    	$this->view->pick("wapApp/user/aboutUs");
    }

    /**
     * 拼团专区(更多拼团)
     */
    public function gbMorePageAction(){
    	$this->view->title = "拼团专区";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/groupBooking/gbMore.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/groupBooking/gbMore.js");

    	$this->view->pick("wapApp/groupBooking/gbMore");
    }



    /**
     * 秒杀专区
     */
    public function promotionMorePageAction(){
    	$this->view->title = "秒杀专区";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/promotion/skMore.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/promotion/skMore.js");

    	$this->view->pick("wapApp/promotion/skMore");
    }


    /**
     * 砍价专区
     */
    public function cpMorePageAction(){
    	$this->view->title = "砍价专区";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/cutPrice/cpMore.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/cutPrice/cpMore.js");

    	$this->view->pick("wapApp/cutPrice/cpMore");
    }
    /**
     * 砍价详情
     */
    public function cpDetailPageAction(){
    	$this->view->title = "砍价详情";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/cutPrice/cpDetail.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/wapApp/video.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/cutPrice/cpDetail.js");

	    if (WuserController::loginVerify()) $this->view->pick("wapApp/cutPrice/cpDetail");
    }


    /**
     * 团购详情
     */
    public function gbBuildPageAction(){
    	$this->view->title = "团购详情";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/order/orderPay.css")
	    	 ->addCss("css/wapApp/groupBooking/gbBulid.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
             ->addJs("js/mui/mui.js")
             ->addJs("js/wapApp/template.js")
             ->addJs("js/wapApp/app.js")
             ->addJs("js/wapApp/groupBooking/gbBulid.js");

    	if (WuserController::loginVerify()) $this->view->pick("wapApp/groupBooking/gbBulid");
    }

    /**
     * 参加团购
     */
    public function gbJoinPageAction(){
    	$this->view->title = "团购";
        $this->assets
             ->addCss("css/mui/mui.css")
             ->addCss("css/mui/icon.css")
             ->addCss("css/wapApp/order/orderPay.css")
             ->addCss("css/wapApp/product/proDetail.css")
             ->addCss("css/wapApp/groupBooking/gbJoin.css")
             ->addJs("lib/jquery/1.9.1/jquery.min.js")
             ->addJs("js/mui/mui.js")
             ->addJs("js/wapApp/template.js")
             ->addJs("js/wapApp/app.js")
             ->addJs("js/wapApp/groupBooking/gbJoin.js");

        if (WuserController::loginVerify()) $this->view->pick("wapApp/groupBooking/gbJoin");
    }

    /**
     * 我的团购
     */
    public function myGroupBookingPageAction(){
    	$this->view->title = "团购";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/order/orderPay.css")
	    	 ->addCss("css/wapApp/groupBooking/myGb.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/template.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/groupBooking/myGb.js");

    	if (WuserController::loginVerify()) $this->view->pick("wapApp/groupBooking/myGb");
    }

    /**
     * 我的砍价
     */
    public function myCutPricePageAction(){
    	$this->view->title = "我的砍价";
    	$this->assets
	    	 ->addCss("css/mui/mui.css")
	    	 ->addCss("css/mui/icon.css")
	    	 ->addCss("css/wapApp/order/orderPay.css")
	    	 ->addCss("css/wapApp/cutPrice/myCP.css")
	    	 ->addJs("lib/jquery/1.9.1/jquery.min.js")
	    	 ->addJs("js/mui/mui.js")
	    	 ->addJs("js/wapApp/template.js")
	    	 ->addJs("js/wapApp/app.js")
	    	 ->addJs("js/wapApp/cutPrice/myCP.js");

    	if (WuserController::loginVerify()) $this->view->pick("wapApp/cutPrice/myCP");
    }

    /**
     * 编辑头像
     */
    public function editAvatarPageAction(){
        $this->view->title = "编辑头像";
        $this->assets
             ->addCss("css/mui/mui.css")
             ->addCss("css/mui/icon.css")
             ->addCss("css/wapApp/cropper.min.css")
             ->addCss("css/wapApp/user/editAvatar.css")
             ->addJs("lib/jquery/1.9.1/jquery.min.js")
             ->addJs("js/mui/mui.js")
             ->addJs("js/wapApp/cropper.min.js")
             ->addJs("js/wapApp/app.js")
             ->addJs("js/wapApp/user/editAvatar.js");

        if (WuserController::loginVerify()) $this->view->pick("wapApp/user/editAvatar");
    }

    /**
     * 订单评价
     */
    public function appraisePageAction(){
        $this->view->title = "订单评价";
        $this->assets
             ->addCss("css/mui/mui.css")
             ->addCss("css/mui/icon.css")
             ->addCss("css/wapApp/cropper.min.css")
             ->addCss("css/wapApp/order/appraise.css")
             ->addJs("lib/jquery/1.9.1/jquery.min.js")
             ->addJs("js/mui/mui.js")
             ->addJs("js/wapApp/cropper.min.js")
             ->addJs("js/wapApp/app.js")
             ->addJs("js/wapApp/order/appraise.js");

        if (WuserController::loginVerify()) $this->view->pick("wapApp/order/appraise");
    }

}

