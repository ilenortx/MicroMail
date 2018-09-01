mui.ready(function() {
	page.initWinWH();
	$('.cart-items-div').css({
		'height': page.data.winHeight - 90
	});

	page.loadProductData();

});

var page = {
	data: {
		winWidth: 0,
		winHeight: 0,
		page: 1,
		carts: [],
	},

	initWinWH: function() {
		this.data.winWidth = $(window).width();
		this.data.winHeight = $(window).height();
	},

	loadProductData: function() {
		$('.cart-items-div').html('');
		var _this = this;

		function cnode(obj) {
			var cartDiv = $('<div class="cart-div"></div>');
			var hi = app.d.hostImg;

			//店铺
			var siDiv = $('<div class="shop-info-div mui-input-row mui-checkbox mui-left"></div>');
			var siLabel = $('<label>' + obj.shop_name + '</label>');
			var siIpt = $('<input onclick="selectShop(this,' + obj.shop_id + ')" name="" value="1" type="checkbox" />');
			siDiv.append(siLabel);
			siDiv.append(siIpt);
			cartDiv.append(siDiv);

			//商品列表
			var sps = obj.shop_pros;
			for(var i = 0; i < sps.length; ++i) {
				var ciDiv = $('<div class="cart-item-div mui-input-row mui-checkbox mui-left"></div>');

				var pi = $('<div class="pro-info" style="width:'+(_this.data.winWidth-60)+'px"></div>');
				var pimg = $('<img class="pro-img" src="' + hi + sps[i].photo_x + '" />');
				var prdiv = $('<div class="pir-div" style="width:'+(_this.data.winWidth-140)+'px"></div>');
				pi.append(pimg);
				pi.append(prdiv);
				/***右边***/
				/***右边顶部***/
				var prtdiv = $('<div class="pirt-div"></div>');
				var pn = $('<text class="pro-name">' + sps[i].pro_name + '</text>');
				var dc = $('<div onclick="removeShopCard(' + sps[i].id + ')" class="del-cart">×</div>');
				prtdiv.append(pn);
				prtdiv.append(dc);
				/***右边底部***/
				var prbdiv = $('<div class="pirb-div"></div>');
				var prbldiv = $('<div class="pirbl-div" style="width:'+(_this.data.winWidth-260)+'px"></div>');
				var av = $('<text class="attr-view">' + sps[i].attrs + '</text>');
				var price = $('<text class="price">￥' + sps[i].price + '</text>');
				prbldiv.append(av);
				prbldiv.append(price);
				var mn = $('<div class="mui-numbox" data-numbox-step="1" data-numbox-min="0"></div>');
				var skuid = sps[i].skuid ? sps[i].skuid : 0;
				var pd = $('<button onclick="proNumOpe(this,' + obj.shop_id + ',' + i + ',\'d\',\'' + skuid + '\',' + sps[i].id + ')" class="mui-btn mui-numbox-btn-minus" type="button">-</button>');
				var pnum = $('<input class="mui-numbox-input pnum' + obj.shop_id + '-' + i + '" value="' + sps[i].num + '" type="number" readOnly="readOnly" />');
				var pu = $('<button onclick="proNumOpe(this,' + obj.shop_id + ',' + i + ',\'u\',\'' + skuid + '\',' + sps[i].id + ')" class="mui-btn mui-numbox-btn-plus" type="button">+</button>');
				mn.append(pd);
				mn.append(pnum);
				mn.append(pu);
				prbdiv.append(prbldiv);
				prbdiv.append(mn);
				prdiv.append(prtdiv);
				prdiv.append(prbdiv);

				var cii = $('<input onclick="selectPro(this,' + obj.shop_id + ',' + i + ')" class="cii cii' + obj.shop_id + ' cart-item-ipt" name="" value="1" type="checkbox" />');
				ciDiv.append(cii);
				ciDiv.append(pi);

				cartDiv.append(ciDiv);
			}

			$('.cart-items-div').append(cartDiv);
		}

		mui.post(app.d.hostUrl + 'ApiShopping/index', {
			user_id: app.ls.get('uid')
		}, function(data) {
			var data = app.json.decode(data);
			if(data.status == 1) {
				_this.data.carts = data.cart;

				var keys = Object.keys(data.cart);
				if(keys.length) {
					for(var i in data.cart) {
						cnode(data.cart[i]);
					}
					$('.cart-null-div').hide();
					$('.cart-items-div').show();
					$('.cart-ope-div').css('visibility', 'visible');
				}
			} else {
				alert(data.err);
			}
		});
	},
	doPay: function(gids, shop_id){
		mui.post(app.d.hostUrl + 'ApiShopping/isSingleShop', {
			cids: gids,
	    }, function(data) {
	    	data = app.json.decode(data);
	    	if(data.status == 1){
	    		var orderInfo = { cart_id: gids, type: 'buyCart' };
		    	app.ls.save('orderInfo', app.json.encode(orderInfo));
		    	location.href = '../WPages/orderPayPage';
	    	}else{
	    		if(!data.isSingleShop) mui.toast('多个店铺的商品不能同时结算');
	    		else if(data.cartStock.length > 0){
	    			for(var i in data.cartStock){
	    				var overStore_item = data.cartStock[i];
	    				var fullStore = overStore_item.rstock;

	    				$('.store' + shop_id + '-'+ i).val(fullStore);
	    			}
	    			mui.toast("部分商品已超出库存,现已调整购物车商品数量");
	    		}

	    	}
	    });
	},

	sumTotalPrice: function() { //计算总金额
		var tp = 0;
		var carts = this.data.carts;
		for(var c in carts) {
			var pro = carts[c].shop_pros;
			for(var i = 0; i < carts[c].shop_pros.length; i++) {
				if(pro[i].selected) {
					tp += pro[i].num * pro[i].price;
				}
			}
		}

		$('.total-price').text('￥' + tp);
	}

}

function cartEdit(ope) { //购物车编辑
	if(ope == 1) {
		$('.ope1-div').hide();
		$('.ope2-div').show();
	} else {
		$('.ope2-div').hide();
		$('.ope1-div').show();
	}
}

function selectAll() { //全选
	$('.cii').each(function(i, ipt) {
		$(ipt).prop('checked', $('.chooseAll').prop('checked')); //修改设置为选中状态
	});

	var carts = page.data.carts;
	for(var c in carts) {
		for(var i = 0; i < carts[c].shop_pros.length; i++) {
			carts[c].shop_pros[i].selected = $('.chooseAll').prop('checked');
		}
	}
	page.sumTotalPrice();
}

function selectPro(obj, indexp, index) {
	page.data.carts[indexp].shop_pros[index].selected = $(obj).prop('checked');
	page.sumTotalPrice();
}

function selectShop(obj, indexp) {
	var pros = page.data.carts[indexp].shop_pros;
	for(var i = 0; i < pros.length; ++i) {
		pros[i].selected = $(obj).prop('checked');
	}
	$('.cii' + indexp).prop('checked', $(obj).prop('checked'));
	page.sumTotalPrice();
}

function proNumOpe(obj, indexp, index, ope, skuid, cartId) {
	var val = parseInt($('.pnum' + indexp + '-' + index).val());
	var num = ope == 'd' ? val - 1 : val + 1;
	if(num == 0) return false;
	skuid = (skuid && skuid != null) ? skuid : '';

	mui.post(app.d.hostUrl + 'ApiShopping/upCart', {
		user_id: app.ls.get('uid'),
		num: num,
		cart_id: cartId,
		skuid: skuid
	}, function(data) {
		var data = app.json.decode(data);
		if(data.status == 1) {
			page.data.carts[indexp].shop_pros[index].num = num;
			$('.pnum' + indexp + '-' + index).val(num);
			page.sumTotalPrice();
		} else {
			alert(data.err);
		}
	});
}

function removeShopCard(cartId) { //单个商品删除
	var btnArray = ['否', '是'];
	mui.confirm('你确认移除吗?', '提示', btnArray, function(e) {
		if(e.index == 1) {
			mui.post(app.d.hostUrl + 'ApiShopping/delete', {
				cart_id: cartId
			}, function(data) {
				var data = app.json.decode(data);
				if(data.status == 1) {
					page.loadProductData();
				} else {
					alert(data.err);
				}
			});
		}
	})
}

function batchDel() { //批量删除
	var btnArray = ['否', '是'];
	var carts = page.data.carts;
	var delIds = '';
	for(var c in carts) {
		for(var i = 0; i < carts[c].shop_pros.length; i++) {
			if(carts[c].shop_pros[i].selected) delIds += carts[c].shop_pros[i].id + ',';
		}
	}

	if(delIds.length > 0) {
		mui.confirm('你确认移除吗?', '提示', btnArray, function(e) {
			if(e.index == 1) {
				mui.post(app.d.hostUrl + 'ApiShopping/delete', {
					cart_id: delIds
				}, function(data) {
					var data = app.json.decode(data);
					if(data.status == 1) {
						page.loadProductData();
					} else {
						alert(data.err);
					}
				});
			}
		});
	} else {
		alert('请选择删除商品！');
	}
}

function cartPay(){
	var shop_sel = {};
	var goods_sel = '';

	var cart_data =  page.data.carts;
	for (var shop in cart_data) {
		var shop_item = cart_data[shop];
		for (var good in shop_item.shop_pros ){
			var good_item = shop_item.shop_pros[good];
			if(good_item.selected==true){
				shop_sel[shop] = true;
				goods_sel += good_item.id + ',';
			}
		}
	};

	if(app.getObjLength(shop_sel) == 0 || goods_sel == ''){ mui.toast("请选择商品结算");return; }
	if(app.getObjLength(shop_sel) > 1){ mui.toast("多个店铺的商品不能同时结算");return;}

	var shop_id;
	for(var i in shop_sel){
		shop_id = i;
		break;
	}
	page.doPay(goods_sel.substring(0,goods_sel.length-1), shop_id);
	// page.data.carts[indexp].shop_pros[i].selected;
}