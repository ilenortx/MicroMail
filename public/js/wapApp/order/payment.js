mui.ready(function() {
	page.data.orderInfo = app.ls.get('orderInfo');
	page.loadOrder();
});

var page = {
	data: {
		orderInfo: '',
		oid: 0,
		oinfo: ''
	},

	loadOrder: function() {
		var _this = this;
		mui.post(app.d.hostUrl + 'ApiPayment/orderInfo', {
			uid: app.ls.get("uid"),
			oid: _this.data.oid
		}, function(data) {
			var data = app.json.decode(data);

			if(data.status == 1) {
				_this.data.oinfo = data.oinfo;

				$('#orderno').text(data.oinfo.order_sn);
				$('#payMoney').text('￥' + data.oinfo.price_h);
				if(data.oinfo.type == 'weixin') $('.payway').text('微信支付');
			} else {
				alert(data.err);
			}
		});
	},

}

function gotoPay() {
	if(app.isWxBrowser()) {
		wxpay(page.data.oinfo);
	} else alert("请使用微信浏览器打开当前地址!");
}

function wxpay(order) { //调用支付
	var _this = this;
	var uid = app.ls.get("uid");
	mui.post(app.d.hostUrl + 'ApiPayment/wxpay', {
		uid: app.ls.get("uid"),
		order_id: order.id,
		order_sn: order.order_sn,
		platform: 'zzyh-gzh'
	}, function(data) {
		var data = app.json.decode(data);

		if(data.status == 1) {
			var oi = JSON.parse(page.data.orderInfo);
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest', {
					"appId": data.arr.appId, //公众号名称，由商户传入
					"timeStamp": data.arr.timeStamp, //时间戳，自1970年以来的秒数
					"nonceStr": data.arr.nonceStr, //随机串
					"package": data.arr.package,
					"signType": "MD5", //微信签名方式
					"paySign": data.arr.paySign //微信签名
				},
				function(res) {
					if(res.err_msg == "get_brand_wcpay_request:ok") {
						alert("微信支付成功!");
						if(oi.type == 'gb') { //团购
							if(oi.gblid == '0') {
								window.location.replace('../WPages/gbBuildPage?orderId=' + order.id);
							} else {
								window.location.replace('../WPages/gbJoinPage?gblid=' + oi.gblid);
							}
						} else {
							window.location.replace("../WPages/orderPage?oitem=1");
						}
					} else if(res.err_msg == "get_brand_wcpay_request:cancel") {
						window.location.replace('../WPages/orderPage?oitem=0');
					} else {
						alert("支付失败!");
					}
				});
		} else alert(data.err);
	});
}