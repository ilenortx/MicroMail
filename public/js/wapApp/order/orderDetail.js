mui.ready(function() {

	page.loadOrderDetail();

});

var page = {
	data: {
        orderId: 0,
        orderInfo: {},
        pros: [],
        vouInfo: {},
        postInfo: {},
        address: {}
	},

	loadOrderDetail: function(){
		var _this = this;
		mui.post(app.d.hostUrl + 'ApiOrder/getOrderInfo', {
			order_id: _this.data.orderId
		}, function(data) {
			var data =  app.json.decode(data);

			if (data.status == 1){
				_this.data.pros = data.pros;
               	_this.data.orderInfo = data.orderInfo;
                _this.data.vouInfo = data.vouInfo;
                _this.data.postInfo = data.postInfo;
                _this.data.address = data.address;

                _this.initPage();
			}else {
				alert(data.err);
			}
		});
	},

	initPage: function(){
		var d = this.data;
		//购买状态
		if (d.orderInfo.status==10) $('#ord-statu').text('等待卖家付款');
		else if (d.orderInfo.status==20&&d.orderInfo.back==0) $('#ord-statu').text('买家已付款');
		else if (d.orderInfo.status==20&&d.orderInfo.back==1) $('#ord-statu').text('买家申请退款');
		else if (d.orderInfo.status==20&&d.orderInfo.back==2) $('#ord-statu').text('退款成功');
		else if (d.orderInfo.status==30&&d.orderInfo.back==0) $('#ord-statu').text('卖家已发货');
		else if (d.orderInfo.status==30&&d.orderInfo.back==1) $('#ord-statu').text('买家申请退款');
		else if (d.orderInfo.status==30&&d.orderInfo.back==2) $('#ord-statu').text('退款成功');
		else if (d.orderInfo.status==50||d.orderInfo.status==51) $('#ord-statu').text('交易完成');

		//地址信息
		$('#shr').text(d.address.name);
		$('#tel').text(d.address.tel);
		$('#addressXq').text(d.address.address_xq);

		//产品信息
		var hi = app.d.hostImg;
		for(var i in d.pros){
			var proInfo = $('<a href="../WPages/proDetailPage?productId='+ d.pros[i].id +'" class="pro-info"></a>');
			var img = $('<img src="'+hi+d.pros[i].photo_x+'" />');
			var piRight = $('<div class="pi-right"></div>');
			var title = $('<div class="title">'+d.pros[i].name+'</div>');
			var attrs = $('<div class="attrs">'+d.pros[i].attrs+'</div>');
			var jqsl = $('<div class="jgsl"></div>');
			jqsl.append('<text>数量：×'+d.pros[i].num+'</text>');
			jqsl.append('<text>单价：￥'+d.pros[i].price+'</text>');
			piRight.append(title); piRight.append(attrs); piRight.append(jqsl);

			proInfo.append(img); proInfo.append(piRight);
			$('.pros').append(proInfo);
		}

		//是否退款
		if (d.orderInfo.status==20||d.orderInfo.status==30) $('#istk').css({'dispaly':'flex'});

		//金钱信息
		$('#proTotalPrice').text('￥'+d.orderInfo.proZj);
		$('#yf').text('￥'+d.postInfo.price);
		if (d.vouInfo.length > 0) {
			$('vou').show();
			$('#vouInfo').text('￥'+d.vouInfo.amount);
		}
		$('#payTotal').text('￥'+d.orderInfo.price_h);

		//
		if (d.orderInfo.status=='10' || d.orderInfo.status=='30') $('.bottom-div').css({'display':'flex'});
		if (d.orderInfo.status=='10') {$('#qxdd').show(); $('#fk').show();}
		else if (d.orderInfo.status=='30') $('#qrsh').show();
	}

}

function cancelOrder(){//取消订单
	var btnArray = ['否', '是'];
	var _this = this;
	mui.confirm('你确定要取消订单吗?', '提示', btnArray, function(e) {
		if(e.index == 1) {
			mui.post(app.d.hostUrl + 'ApiOrder/ordersEdit', {
				id: page.data.orderId, type: 'cancel'
			}, function(data) {
				var data = app.json.decode(data);
				if(data.status == 1) {
					javascript:history.go(-1);location.reload();
				} else {
					alert(data.err);
				}
			});
		}
	});
}

function recOrder(){//确认收货
	var btnArray = ['否', '是'];
	mui.confirm('你确定已收到宝贝吗?', '提示', btnArray, function(e) {
		if(e.index == 1) {
			mui.post(app.d.hostUrl + 'ApiOrder/ordersEdit', {
				id: page.data.orderId, type: 'receive'
			}, function(data) {
				var data = app.json.decode(data);
				if(data.status == 1) {
					javascript:history.go(-1);location.reload();
				} else {
					alert(data.err);
				}
			});
		}
	});
}
