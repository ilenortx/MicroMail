mui.ready(function() {
	page.data.orderInfo = app.ls.get('orderInfo');
	page.loadProductDetail();
	page.initWinWH();
});

var page = {
	data: {
		winWidth: 0,
		winHeight: 0,
		paytype: 1,
		orderInfo: '',
		address: [],
		addrId: 0, //收货地址//
		productData: [],
		total: 0,
		vprice: 0,
		vidarr: [],
		yfarr: [],
		yunfeis: [],
		vouarr: [],
		remarkarr: [],
		cyfsid: 0, //选择运费店铺id
		fxsId: 0, //分销商id

		address: [], //地址列表

	},
	initWinWH: function() {
		this.data.winWidth = $(window).width();
		this.data.winHeight = $(window).height();
	},

	loadProductDetail: function() {
		var _this = this;
		mui.post(app.d.hostUrl + 'ApiPayment/getProInfo', {
			order_info: _this.data.orderInfo,
			uid: app.ls.get("uid"),
			addr_id: _this.data.addrId
		}, function(data) {
			var data = app.json.decode(data);

			if(data.status == 1) {
				var adds = data.adds;
				if(adds && data.addemt == 0) {
					var addrId = adds.id
					_this.data.address = adds;
					_this.data.addrId = addrId;
				}

				_this.data.productData = data.orderInfo;
				_this.data.total = data.price;
				_this.data.vprice = data.price;
				_this.data.remarkarr = data.remarkarr,
				_this.data.vidarr = data.vidarr;
				_this.data.yfarr = data.yfarr;

				var yunfeis = Array();
				for(var s in data.orderInfo) {
					yunfeis[s] = data.orderInfo[s].yunfei;
					_this.data.vouarr[s] = data.orderInfo[s].shop_vous
				}
				_this.data.yunfeis = yunfeis;

				_this.initAddress();
				_this.initPros();
				_this.initTotal(data.price);
			} else {
				alert(data.err);
			}
		});
	},

	initAddress: function() { //初始化地址
		if(this.data.addrId == 0) {
			/*$('.chooseAddress').show();*/
			$('.chooseAddress').css({'display':'flex'});
			$('.address-info').hide();
			return;
		}

		var address = this.data.address;
		$('#shr').text(address.name);
		$('#tel').text(address.tel);
		$('#addressXq').text(address.address_xq);
	},

	initPros: function() { //初始化产品
		var _this = this;
		var pros = this.data.productData;
		var hi = app.d.hostImg;

		function cdom(obj) {
			var pros = $('#pros');

			var shopInfo = $('<div class="shop_info">' + obj.shop_name + '</div>');
			pros.append(shopInfo);

			for(var i in obj.shop_pros) {
				var sp = obj.shop_pros[i];
				var proItem = $('<div class="pro-item"></div>');
				var cpPhoto = $('<img class="cp_photo" src="' + hi + sp.photo_x + '" />');
				var df1 = $('<div class="df_1"></div>');
				var ovh1 = $('<div class="ovh1">' + sp.name + '</div>');
				var sljg = $('<div class="sljg"></div>');
				sljg.append('<text class="gm_ovh_1h">×' + sp.num + '</text>');
				sljg.append('<text class="gm_ovh_1h" style="color:red;">￥' + sp.price_yh + '</text>');
				df1.append(ovh1);
				df1.append('<div style="height:17px;"></div>');
				df1.append(sljg);
				proItem.append(cpPhoto);
				proItem.append(df1);

				pros.append(proItem);
			}

			var vouarr = _this.data.vouarr[obj.shop_id];
			var vou = $('<div onclick="openChooseVou(this,' + obj.shop_id + ')" class="bzview"></div>');
			vou.append('<text>优惠券</text>');
			var vspan = $('<span style="display:flex;align-items:center;"></span>');
			if(Object.keys(vouarr).length) vspan.append('<text class="vou-' + obj.shop_id + '">请选择优惠券</text>');
			else vspan.append('<text class="vou-' + obj.shop_id + '">暂无可用优惠券</text>');
			vspan.append('<img src="../img/wapApp/x_right.png" style="width:12px;height:15px;margin-left:10px;" />');
			vou.append(vspan);

			var yfb = $('<div onclick="openChooseYf(this,' + obj.shop_id + ')" class="bzview"></div>');
			yfb.append('<text>运费</text>');
			var yspan = $('<span style="display:flex;align-items:center;"></span>');
			yspan.append('<text class="yf-' + obj.shop_id + '" style="color:red;">￥0</text>');
			yspan.append('<img src="../img/wapApp/x_right.png" style="width:12px;height:15px;margin-left:10px;" />');
			yfb.append(yspan);

			var mjly = $('<div class="bzview"></div>');
			mjly.append('<text style="width:70px;">买家留言</text>');
			mjly.append('<input oninput="editRemark(this,' + obj.shop_id + ')" class="mjbz" type="text" placeholder="请填写备注" />');

			pros.append(vou);
			pros.append(yfb);
			pros.append(mjly);
		}

		for(var i in pros) {
			cdom(pros[i]);
		}
	},

	initTotal: function(total) {
		$('.zhifu').text('￥' + total);
	},

	loadAddress: function() {
		var _this = this;

		function cdom(obj) {
			var addDiv = $('<div class="add-div"></div>');
			var uinfo = $('<div class="uinfo"></div>');
			var nat = $('<div></div>');
			nat.append('<text>' + obj.name + '</text>');
			nat.append('<text style="margin-left:20px">' + obj.tel + '</text>');
			uinfo.append(nat);
			var sydz = $('<text onclick="useAddress(' + obj.id + ')">选用地址</text>');
			uinfo.append(sydz);
			var addinfo = $('<div class="addinfo">' + obj.address + '&nbsp;' + obj.address_xq + '</div>');
			var addopes = $('<div class="addopes"></div>');
			addDiv.append(uinfo);
			addDiv.append(addinfo);
			addDiv.append(addopes);

			if(obj.is_default == '1') {
				var mrdzDiv = $('<div class="mrdz-div mui-input-row mui-checkbox mui-left"></div>');
				mrdzDiv.append('<input name="" value="" type="checkbox" checked disabled />');
			} else {
				var mrdzDiv = $('<div onclick="setDefault(' + obj.id + ')" class="mrdz-div mui-input-row mui-checkbox mui-left"></div>');
				mrdzDiv.append('<input name="" value="" type="checkbox" />');
			}
			mrdzDiv.append('<label>默认地址</label>');
			var opeRight = $('<div class="ope-right"></div>');
			var ed = $('<div onclick="editAddress(' + obj.id + ')" class="edit-div"></div>');
			ed.append('<img src="../img/wapApp/edit1.png" />编辑');
			var dd = $('<div class="del-div"></div>');
			if(obj.is_default != '1') dd.append('<img onclick="delAddress(' + obj.id + ')" src="../img/wapApp/dleicon.png" />删除');
			opeRight.append(ed);
			opeRight.append(dd);
			addopes.append(mrdzDiv);
			addopes.append(opeRight);

			$('.adds-div').append(addDiv);
		}

		mui.post(app.d.hostUrl + 'ApiUser/getAdds', {
			user_id: app.ls.get("uid")
		}, function(data) {
			var data = app.json.decode(data);

			if(data.status == 1) {
				_this.data.address = data.adds;
				for(var i in data.adds) {
					cdom(data.adds[i]);
				}
			} else {
				alert(data.err);
			}
		});
	},

	wxpay: function(order) { //调用支付
		var _this = this;
		var uid = app.ls.get("uid");
		mui.post(app.d.hostUrl + 'ApiPayment/wxpay', {
			uid: app.ls.get("uid"), order_id: order.order_id,order_sn: order.order_sn, platform: 'zzyh-gzh'
		}, function(data) {
			alert(data);
			var data = app.json.decode(data);
			
			if (data.status == 1){
				var oi = JSON.parse(_this.data.orderInfo);
				WeixinJSBridge.invoke(
					'getBrandWCPayRequest', {
						"appId": data.arr.appId, //公众号名称，由商户传入
						"timeStamp": data.arr.timeStamp, //时间戳，自1970年以来的秒数
						"nonceStr": data.arr.nonceStr, //随机串
						"package": data.arr.package,
						"signType": "MD5", //微信签名方式
						"paySign": data.arr.paySign //微信签名
					},function(res) {
					if(res.err_msg == "get_brand_wcpay_request:ok") {
						alert("微信支付成功!");
						if(oi.type == 'gb') { //团购
							if(oi.gblid == '0') {
								window.location.replace('../WPages/gbBuildPage?orderId='+order.order_id);
							} else {
								window.location.replace('../WPages/gbJoinPage?gblid='+oi.gblid);
							}
						} else {
							window.location.href = "../WPages/orderPage?oitem=1";
						}
					} else if(res.err_msg == "get_brand_wcpay_request:cancel") {
						window.location.replace('../WPages/orderPage?oitem=0');
					} else {
						alert("支付失败!");
					}
				});
			}else alert(data.err);
		});
	}
}

function editRemark(obj, sid) {
	page.data.remarkarr[sid] = $(obj).val();
}

function openChooseYf(obj, sid) { //打开运费列表
	var yunfeis = page.data.yunfeis[sid];
	$('#shopFfList').html('');
	for(var i in yunfeis) {
		var div = $('<div onclick="cooseYf(' + sid + ',' + yunfeis[i].id + ')" class="mui-input-row mui-radio"></div>');
		div.append('<label>' + yunfeis[i].name + '&nbsp; ￥' + yunfeis[i].price + '</label>');
		if(page.data.yfarr[sid] == yunfeis[i].id) div.append('<input name="yfitem" type="radio" checked />');
		else div.append('<input name="yfitem" type="radio" />');

		$('#shopFfList').append(div);
	}
	mui("#chooseYf").popover('show');
}

function cooseYf(sid, id) { //选择运费
	var yfid = page.data.yfarr[sid];
	var yunfeis = page.data.yunfeis[sid];
	page.data.yfarr[sid] = id;

	var total = page.data.total;
	total = total - parseInt(yunfeis[yfid].price) + parseInt(yunfeis[id].price);
	page.data.total = total;
	$('.zhifu').text('￥' + total);

	$('.yf-' + sid).text('￥' + yunfeis[id].price);
	mui("#chooseYf").popover('hide');
}

function openChooseVou(obj, sid) { //打开优惠券列表
	var vouarr = page.data.vouarr[sid];
	var vidarr = page.data.vidarr[sid];
	$('#shopVouList').html('');
	if(Object.keys(vouarr).length) {
		for(var i in vouarr) {
			if (!isNaN(i)){
				var div = $('<div onclick="cooseVou(' + sid + ',' + vouarr[i].id + ')" class="mui-input-row mui-radio"></div>');
				div.append('<label>满' + vouarr[i].full_money + '立减' + vouarr[i].amount + '元</label>');
				if(vidarr == vouarr[i].uvid) div.append('<input name="vouitem" type="radio" checked />');
				else div.append('<input name="vouitem" type="radio" />');
	
				$('#shopVouList').append(div);
			}
		}
		var div = $('<div onclick="cooseVou(' + sid + ',0)" class="mui-input-row mui-radio"></div>');
		div.append('<label>不适用优惠券</label>');
		if('' == vidarr) div.append('<input name="vouitem" type="radio" checked />');
		else div.append('<input name="vouitem" type="radio" />');

		$('#shopVouList').append(div);
		mui("#chooseVou").popover('show');
	}
}

function cooseVou(sid, id) { //选择优惠券
	var vid = page.data.vouarr[sid].lid;
	var vouarr = page.data.vouarr[sid];
	page.data.vouarr[sid].lid = id;
	page.data.vidarr[sid] = id ? page.data.vouarr[sid][id].uvid : '';

	var yj = vid ? parseInt(vouarr[vid].amount) : 0;
	var hj = id ? parseInt(vouarr[id].amount) : 0;

	var total = page.data.total;
	total = total + yj - hj;
	page.data.total = total;
	$('.zhifu').text('￥' + total);

	if(id) $('.vou-' + sid).text('满' + vouarr[id].full_money + '立减' + vouarr[id].amount + '元');
	else $('.vou-' + sid).text('请选择优惠券');
	mui("#chooseVou").popover('hide');
}

function chooseAddress() {
	//window.location.href = '../WPages/myAddressPage';
	//var datas = {orderInfo:page.data.orderInfo, fxsId:0};
	//app.post('../WPages/myAddressPage1', datas);
	$('#pagePay').hide();
	$('#pageAddress').show();
	location.href = "#pageAddress";

	$('.adds-div').html('');
	page.loadAddress();
}

function choosePayType(type) { //选择支付类型
	page.data.paytype = type;
}

function useAddress(aid) {
	var _this = this;
	mui.post(app.d.hostUrl + 'ApiUser/aidAddress', {
		uid: app.ls.get("uid"),
		aid: aid
	}, function(data) {
		var data = app.json.decode(data);

		if(data.status == 1) {
			addrInfo = data.addrInfo;
			page.data.addrId = addrInfo.id;

			$('#shr').text(addrInfo.name);
			$('#tel').text(addrInfo.tel);
			$('#addressXq').text(addrInfo.address_xq);

			app.pageGoBack();
		} else {
			alert(data.err);
		}

	});
}

/**
 * 提交订单
 */
function createProductOrder() {
	if(!page.data.addrId || page.data.addrId == 0) {
		alert('请选择收货地址!');
		return false;
	}
	
	if (app.isWxBrowser() || page.data.paytype==2){
		$('#notice').show();
		mui.post(app.d.hostUrl + 'ApiPayment/payment', {
			uid: app.ls.get("uid"),
			order_info: page.data.orderInfo,
			type: page.data.paytype == 1 ? 'weixin' : 'cash',
			aid: page.data.addrId, //地址的id
			remarkarr: JSON.stringify(page.data.remarkarr), //用户备注
			price: page.data.total, //总价
			vidarr: JSON.stringify(page.data.vidarr), //优惠券ID
			yfarr: JSON.stringify(page.data.yfarr),
			fxs_id: page.data.fxsId
		}, function(data) {
			var data = app.json.decode(data);
			$('#notice').hide();
	
			if(data.status == 1) {
				if(app.isWxBrowser()) {
					window.location.replace("../WPages/paymentPage?oid="+data.arr.order_id);
					//page.wxpay(data.arr);
				} else { //非微信浏览器
					if(data.arr.pay_type == 'cash') { //现金
						var oi = JSON.parse(page.data.orderInfo);
						if(oi.type == 'gb') { //团购
							if(oi.gblid == '0') {
								window.location.replace('../WPages/gbBuildPage?orderId='+data.arr.order_id);
							} else {
								window.location.replace('../WPages/gbJoinPage?gblid='+oi.gblid);
							}
						} else {
							window.location.replace("../WPages/orderPage?oitem=1");
						}
						return false;
					} else if(data.arr.pay_type == 'weixin') { //微信支付
						mui.toast('使用微信支付购买商品请在微信端打开网站');
						window.location.href = "../WPages/orderPage?oitem=0";
					}
				}
			} else {
				alert(data.err);
			}
		});
	}else alert("请使用微信浏览器打开当前地址!");
}

//地址管理
function setDefault(addrId) {
	mui.post(app.d.hostUrl + 'ApiUser/setAddsDefault', {
		uid: app.ls.get("uid"),
		addr_id: addrId
	}, function(data) {
		var data = app.json.decode(data);

		if(data.status == 1) {
			$('.adds-div').html('');
			page.loadAddress();
		} else {
			alert(data.err);
		}
	});
}

function delAddress(addrId) {
	mui.post(app.d.hostUrl + 'ApiUser/delAdds', {
		user_id: app.ls.get("uid"),
		addr_id: addrId
	}, function(data) {
		var data = app.json.decode(data);

		if(data.status == 1) {
			$('.adds-div').html('');
			page.loadAddress();
		} else {
			alert(data.err);
		}
	});
}

function editAddress(id) {
	var body = $(document.body),
		form = $("<form method='post'></form>"),
		input;
	form.attr({
		"action": '../WPages/addressEditPage'
	});
	input = $("<input type='hidden'>");
	input.attr({
		"name": 'id'
	});
	input.val(id);
	form.append(input);
	form.appendTo(document.body);
	form.submit();
	document.body.removeChild(form[0]);

}