mui.ready(function() {

	$('.oitem').eq(page.data.oitem).addClass('active');
	$('#orderItem'+page.data.oitem).show();

	page.loadOrderList();

});

var page = {
	data: {
		oitem: 0,
        page0: 0,
        page1: 0,
        page2: 0,
        page3: 0,
        page4: 0,
        orderList0: [],
        orderList1: [],
        orderList2: [],
        orderList3: [],
        orderList4: [],
	},

	loadOrderList: function(callback){
		var _this = this;
		var oitem = parseInt(this.data.oitem);

		var url = oitem==4?'ApiOrder/orderRefund':'ApiOrder/index';
		var pages = oitem==0?this.data.page0:(oitem==1?this.data.page1:(oitem==2?this.data.page2:(oitem==3?this.data.page3:this.data.page4)));
		status = oitem==0 ? 'pay' : oitem==1 ? 'deliver' : oitem==2 ? 'receive' : oitem==3 ? 'finish' : '';

		mui.post(app.d.hostUrl + url, {
			uid:app.ls.get("uid"), order_type: status, page: pages
		}, function(data) {
			var data =  app.json.decode(data);

			var ords = data.ord;
			if (ords.length) _this.cdom(ords);
			switch(oitem){
				case 0:
					for (var i in ords){
						_this.data.orderList0.push(ords[i]);
					}
					if (_this.data.orderList0.length==0) $('.order-null').css("display","flex");
					else _this.data.page0 += 1;
					break;
				case 1:
					for (var i in ords){
						_this.data.orderList1.push(ords[i]);
					}
					if (_this.data.orderList1.length==0) $('.order-null').css("display","flex");
					else _this.data.page1 += 1;
					break;
				case 2:
					for (var i in ords){
						_this.data.orderList2.push(ords[i]);
					}
					if (_this.data.orderList2.length==0) $('.order-null').css("display","flex");
					else _this.data.page2 += 1;
					break;
				case 3:
					for (var i in ords){
						_this.data.orderList3.push(ords[i]);
					}
					if (_this.data.orderList3.length==0) $('.order-null').css("display","flex");
					else _this.data.page3 += 1;
					break;
				case 4:
					for (var i in ords){
						_this.data.orderList4.push(ords[i]);
					}
					if (_this.data.orderList4.length==0) $('.order-null').css("display","flex");
					else _this.data.page4 += 1;
					break;
			}

			if (typeof(callback)!='undefined') callback(data.status==0 || ords.length==0);
		});
	},

	cdom: function(ords){
		var oitem = parseInt(this.data.oitem);
		$('#orderItem'+oitem).show();
		var hi = app.d.hostImg;
		for(var i in ords){

			function cproinfo(obj){
				var proInfo = $('<div class="pro-info"></div>');
				var img = $('<img src="'+hi+obj.photo_x+'" />');

				var piRight = $('<div class="pi-right"></div>');
				var title = $('<div class="title">'+obj.name+'</div>');
				var attrs = $('<div class="attrs">'+obj.attrs+'</div>');
				var jqsl = $('<div class="jgsl"></div>');
				var sl = $('<text>数量：×'+obj.product_num+'</text>');
				var jg = $('<text>单价：￥'+obj.price+'</text>');
				jqsl.append(sl); jqsl.append(jg);
				piRight.append(title); piRight.append(attrs); piRight.append(jqsl);

				proInfo.append(img); proInfo.append(piRight);

				return proInfo;
			}

			var orderItem = $('<div class="order-item"></div>');

			var pros = $('<div class="pros"></div>');
			for (var j in ords[i].pro){
				pros.append(cproinfo(ords[i].pro[j]));
			}

			var opesDiv = $('<div class="opes-div"></div>');
			var heprice = $('<text class="heprice">合计：￥'+ords[i].price_h+'</text>');
			var opeRight = $('<div class="ope-right"></div>');
			var qx = $('<div onclick="cancelOrder(this,'+ords[i].id+')" class="ope-item ope-gray">取消</div>');
			var xq = $('<a href="../WPages/orderDetailPage?orderId='+ords[i].id+'" class="ope-item ope-gray">详情</a>');
			var fk = $('<a href="../WPages/paymentPage?oid='+ords[i].id+'" class="ope-item ope-red">付款</a>');
			var sh = $('<div onclick="recOrder(this,'+ords[i].id+')" class="ope-item ope-red">确认收货</div>');
			var pj = $('<a href="../WPages/appraisePage?sn=' + ords[i].order_sn + '" class="ope-item ope-gray">评价</a>');
			if (oitem==0) opeRight.append(qx);
			if (oitem==3) opeRight.append(pj);
			opeRight.append(xq);
			if (oitem==0) opeRight.append(fk);
			if (oitem==2) opeRight.append(sh);

			opesDiv.append(heprice); opesDiv.append(opeRight);

			orderItem.append(pros); orderItem.append(opesDiv);

			$('#orderItem'+oitem).append(orderItem);
		}
	}

}

function changeOitem(obj, item){
	$('.oitem').removeClass('active');
	$(obj).addClass('active');
	$('.coi').hide();
	$('#orderItem'+item).show();

	$('.order-null').css("display","none");
	page.data.oitem = item;

	var pages = item==0?page.data.page0:(item==1?page.data.page1:(item==2?page.data.page2:(item==3?page.data.page3:page.data.page4)));

	if (pages==0) page.loadOrderList();

	var oitem = parseInt(page.data.oitem);
}

function cancelOrder(obj, oid){//取消订单
	var btnArray = ['否', '是'];
	mui.confirm('你确定要取消订单吗?', '提示', btnArray, function(e) {
		if(e.index == 1) {
			mui.post(app.d.hostUrl + 'ApiOrder/ordersEdit', {
				id: oid, type: 'cancel'
			}, function(data) {
				var data = app.json.decode(data);
				if(data.status == 1) {
					$($(obj).parents(".order-item")).remove();
					if ($('#orderItem0').children().length==0) {
						page.data.page0 = 0;
						page.data.orderList0 = [];
					}
				} else {
					alert(data.err);
				}
			});
		}
	});
}

function recOrder(obj, oid){//确认收货
	var btnArray = ['否', '是'];
	mui.confirm('你确定已收到宝贝吗?', '提示', btnArray, function(e) {
		if(e.index == 1) {
			mui.post(app.d.hostUrl + 'ApiOrder/ordersEdit', {
				id: oid, type: 'receive'
			}, function(data) {
				var data = app.json.decode(data);
				if(data.status == 1) {
					$($(obj).parents(".order-item")).remove();
					$('#orderItem3').html('');
					page.data.page3 = 0;
					page.data.oitem = 3;
					page.data.orderList3 = [];

					if ($('#orderItem2').children().length==0) {
						page.data.page2 = 0;
						page.data.orderList2 = [];
					}

					$('.oitem').removeClass('active');
					$('.oitem').eq(3).addClass('active');
					$('.coi').hide();
					$('#orderItem3').show();

					$('.order-null').css("display","none");
					page.loadOrderList();
				} else {
					alert(data.err);
				}
			});
		}
	});
}

function loadMore(callback){
	page.loadOrderList(callback);
}
