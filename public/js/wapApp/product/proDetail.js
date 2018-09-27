var videoObj, swiper, payVideoDiv;
mui.ready(function() {
	page.initWinWH();
	$('.pro-swiper').height($('.pro-swiper').width());
	$('.video-div').height($('.pro-swiper').width());
	$('#tja').height(page.data.winWidth / 3 * 2);

	$('#syg').click(function() {
		swiper.slidePrev();
	});
	
	videoObj = videojs('video');
	videojs("video").ready(function() {
		var videoObj = this;
	});
	$('.quitPlay').click(function(){
		videoObj.pause();
		$('.video-div').hide();
	});

	//加载数据
	mui.post(app.d.hostUrl + 'ApiProduct/index', {
		pro_id: page.data.productId,
		uid: app.ls.get("uid")
	}, function(data) {
		var data = app.json.decode(data);

		if(data.status == 1) {
			var bannerItem = data.pro.img_arr;
			for(var k in bannerItem) {
				bannerItem[k] = app.d.hostImg + bannerItem[k];
			}
			page.data.prosn = data.prosn;
			page.data.itemData = data.pro;
			page.data.proAttrs = data.porAttr;
			page.data.bannerItem = bannerItem;
			page.data.isSc = data.is_sc;
			page.data.proParms = data.parm;

			scStatus(data.is_sc); //收藏图片
			if(data.pro.tjpro) page.loadTjpro();

			page.initBanner();
			page.proInfo();
			page.procx();
			page.prosn();
		} else {
			alert(data.err);
		}
	});

});

var page = {
	data: {
		winWidth: 0,
		winHeight: 0,
		productId: 0,
		bannerItem: [],
		itemData: {},
		proAttrs: [],
		prosn: [],
		tjpros: [],
		isSc: 0, //是否收藏
		proPrice: 0, //商品价格， 可根据不同属性改变
		proStock: 0, //商品库存， 可根据不同属性改变
		skuid: '',
		isPriceYh: true,
		gblid: 0,//参团对象id
		proParms: [],
	},
	initWinWH: function() {
		this.data.winWidth = $(window).width();
		this.data.winHeight = $(window).height();
	},

	initBanner: function() { //初始化轮播图
		var bi = this.data.bannerItem;

		var sc = $('.pro-swiper');
		var sw = $('<div class="swiper-wrapper"></div>');
		var sp = $('<div class="swiper-pagination"></div>');
		//视频
		if (this.data.itemData.video && bi.length>0){
			videoObj.src(app.d.hostVideo+this.data.itemData.video);

			var div = $('<div class="swiper-slide"></div>');
			var img = $('<img src="' + bi[0] + '" />');
			payVideoDiv = $('<div class="pay-video-div"></div>');
			payVideoDiv.append('<text class="play-sjx"></text>')
			div.append(img);
			div.append(payVideoDiv);
			sw.append(div);
			
			payVideoDiv.on('click', function(){
				$('.video-div').show();videoObj.play();
			});
			$('.video-div').on('touchstart', function (e) {
				e = e || window.event;
			    var $tb = $(this);
			    var startX = e.originalEvent.changedTouches[0].pageX, pullDeltaX = 0;
			    $tb.on('touchend', function (e) {
					e = e || window.event;
			        $tb.off('touchmove touchend');
			        videoObj.pause();
			        $('.video-div').hide();

			        pullDeltaX = e.originalEvent.changedTouches[0].pageX-startX;
			        if (pullDeltaX > 30){//右滑，往前翻所执行的代码
			        	if (bi.length>1) swiper.slideTo(1, 1000, false);
			        }else if (pullDeltaX < -30){//左滑，往后翻所执行的代码
			        	if (bi.length>1) swiper.slideTo(2, 1000, false);
			        }
			    });
			});
		}

		for(var i = 0; i < bi.length; ++i) {
			var div = $('<div class="swiper-slide"></div>');
			var img = $('<img src="' + bi[i] + '" />');
			div.append(img);
			sw.append(div);
		}
		sc.append(sw);
		sc.append(sp);

		swiper = new Swiper('.swiper-container', {
			slidesPerView: 1,
			spaceBetween: 0,
			loop: true,
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
		});
	},
	proInfo: function() {
		var hi = app.d.hostImg;
		var proInfo = this.data.itemData;
		$('.intro').html(proInfo.intro);
		$('.title').html(proInfo.name);
		if(proInfo.hd_type == 1) {
			$('.pprice').text(proInfo.skinfo.pprice);
			$('.yprice').text(proInfo.price_yh);

			this.pCountDown();
			$('#skuprice').text('￥ ' + proInfo.skinfo.pprice);
			this.data.proPrice = proInfo.skinfo.pprice;
		} else {
			$('.yjiage').html('¥ ' + proInfo.price_yh);
			$('.jiage').html('¥ ' + proInfo.price);
			$('.xiaoliang').html('销量: ' + proInfo.shiyong);
			$('.tkc').html('库存: ' + proInfo.num);
			$('.pro-detail').html(proInfo.content);

			$('#skuprice').text('￥ ' + proInfo.price_yh);
			this.data.proPrice = proInfo.price_yh;
		}

		if (proInfo.hd_type == 2){
			$('#tgprice').html('￥'+proInfo.gbInfo.gbprice+"<br/>我要开团");
			this.initJGBL();
		}

		// $('.proname').html(proInfo.name);
		// $('.procode').html(proInfo.pro_number);
		// $('.protype').html('');

		//商品属性()
		$('#proPhoto').attr('src', hi + proInfo.photo_x);
		$('#skustock').text('库存：' + proInfo.num).data("stock", proInfo.num);
		this.data.proStock = proInfo.num;
		var proAttrs = this.data.proAttrs;
		for(var i in proAttrs) {
			var proAttr = $('<div class="pro-attrs"></div>');
			var attr = $('<div class="attr">' + proAttrs[i].name + '</div>');
			proAttr.append(attr);
			for(var j in proAttrs[i].values) {
				var value = $('<div onclick="chooseAttr(this, ' + proAttrs[i].id + ',' + proAttrs[i].values[j].id + ')" class="value value' + proAttrs[i].id + '">' + proAttrs[i].values[j].name + '</div>');
				proAttr.append(value);
			}

			$('#attrs-list').append(proAttr);
		}

		// 产品参数
		var parms = this.data.proParms;
		var parms_html = '';
		for (var i = 0; i < parms.length; i++) {
			parms_html += '<div class="canshu df">';
			parms_html += '<div class="name">'+ parms[i].name +'：</div>';
			parms_html += '<div class="df_1 c3">'+ parms[i].value +'</div>';
			parms_html += '</div>';
		};
		$('.pro-attrs-div').html(parms_html);
	},

	procx: function() { //促销地址
		var hi = app.d.hostImg;
		var proInfo = this.data.itemData;
		if(proInfo.procxid) {
			$('#tja').attr({
				'href': '../WPages/productCxPage?cxid=' + proInfo.procx.cxid
			});
			$('#tjimg').attr({
				'src': hi + proInfo.procx.photo
			});
			$('#tjdiv').show();
		}
	},
	prosn: function() { //产品说明
		var prosn = this.data.prosn;
		if(prosn.length) {
			for(var i in prosn) {
				var prosnItem = $('<div class="prosn-item">');
				var ddd = $('<div style="display:flex;align-items:center;">');
				ddd.append('<img src="../img/wapApp/prosn-ok.png" />' + prosn[i].title);
				prosnItem.append(ddd);

				$('.prosn-items-div').append(prosnItem);
			}

			$('.prosns').css('display', 'block');
		}
	},

	loadTjpro: function() {
		var _this = this;
		mui.post(app.d.hostUrl + 'ApiProduct/tjproList', {
			pro_id: _this.data.productId
		}, function(data) {
			var data = app.json.decode(data);

			if(data.status == 1) {
				page.data.tjpros = data.tjpros;
				_this.tjproSwipers();
			} else {
				alert(data.err);
			}
		});
	},
	tjproSwipers: function() { //初始化轮播图
		var tjpros = this.data.tjpros;
		var hi = app.d.hostImg;

		var tjpro = $('.tjpro-swipers');
		var sw = $('<div class="swiper-wrapper"></div>');

		for(var i = 0; i < tjpros.length; ++i) {
			var swiperSlide = $('<div class="swiper-slide"></div>');
			for(var j in tjpros[i]) {
				var sg = $('<a href="../WPages/proDetailPage?productId=' + tjpros[i][j].id + '" class="single-goods"></a>');
				sg.append('<img class="prophoto" src="' + hi + tjpros[i][j].photo_x + '" />');
				sg.append('<text class="proname">' + tjpros[i][j].name + '</text>');
				var summary = $('<div class="summary"></div>');
				summary.append('<text class="price">￥ ' + tjpros[i][j].price_yh + '</text>');
				sg.append(summary);

				swiperSlide.append(sg);
			}
			sw.append(swiperSlide);
		}
		tjpro.append(sw);

		var swiper = new Swiper('.swiper-container1', {
			slidesPerView: 1,
			spaceBetween: 0,
			loop: false,
			pagination: {
				el: '.swiper-pagination1',
				clickable: true,
			},
		});

		$('#rxtj').show();
	},
	buyVerify: function() { //购买其验证
		var proAttrs = this.data.proAttrs;
		var skuid = '';
		for(var i in proAttrs) {
			if(!proAttrs[i].cval) {
				alert('请选择' + proAttrs[i]['name']);
				return false;
			}
			skuid += proAttrs[i].cval + ',';
		}
		this.data.skuid = skuid;
		var buynum = parseInt($('.nownum').text());
		if(buynum > parseInt(this.data.proStock)) {
			alert('库存不足');
			return false;
		}
		return true;
	},

	pCountDown: function() { //秒杀倒计时
		var _this = this;
		var itemData = this.data.itemData;
		itemData.skinfo['sytime'] = this.timeFormat(itemData.skinfo.etime);
		this.data.itemData = itemData;
		$('#pCountDown').text(itemData.skinfo['sytime']);
		setTimeout(function() {
			_this.pCountDown();
		}, 1000);
	},
	timeFormat: function(t) { //活动结束时间
		var time = t - parseInt(Number(new Date()) / 1000);
		var day = parseInt(time / 86400);
		var h = parseInt((time - day * 86400) / 3600);
		var m = parseInt((time - day * 86400 - h * 3600) / 60);
		var s = time - day * 86400 - h * 3600 - m * 60;
		m = m < 10 ? '0' + m : m;
		s = s < 10 ? '0' + s : s;

		var ftime = day == 0 ? '' : day + '天';
		if(h > 0) ftime += h + ':';
		if(m >= 0) ftime += m + ':';
		if(s >= 0) ftime += s;

		return ftime;
	},

	initJGBL: function(){
		var gbList = this.data.itemData.gbList;
        var gbList2 = this.data.itemData.gbList2;

        for (var i in gbList){
			var gld = $('<div class="gbl-list-div"></div>');

			var d1 = $('<div style="display:flex;width:55%;align-items:center;"></div>');
			if (gbList[i].uphoto) d1.append('<img class="uavatar" src="'+gbList[i].uphoto+'"/>');
			else d1.append('<img class="uavatar" src="../img/wapApp/user-avatar.png"/>');
			d1.append('<text class="unick">'+gbList[i].uname+'</text>');

			var d2 = $('<div style="display:flex;width:45%;align-items:center;justify-content:flex-end;"></div>');
			var gmi = $('<div class="gb-mt-info"></div>');
			gmi.append('<div>还差<text>'+gbList[i].ungbnums+'人</text>拼成</div>');
			gmi.append('<div>剩余<span class="gbdjs-'+gbList[i].id+'">0:00:00</span></div>');
			d2.append(gmi);

			gld.append(d1); gld.append(d2);
			gld.append('<div gblid="'+gbList[i].id+'" onclick="showDAC(this, 3)" class="gtgb-tbn">去拼单</div>');

			$('#gbList').append(gld);
        }

        for (var i in gbList2){
			var gld = $('<div class="gbl-list-div"></div>');

			var d1 = $('<div style="display:flex;width:70%;"></div>');
			if (gbList2[i].uphoto) d1.append('<img class="uavatar" src="'+gbList2[i].uphoto+'"/>');
			else d1.append('<img class="uavatar" src="../img/wapApp/user-avatar.png"/>');

			var d2 = $('<div style="margin-left:10px;font-size:12px;line-height:20px;"></div>');
			var d3 = $('<div style="display:flex;"></div>');
			d3.append('<div class="uname1">'+gbList2[i].uname+'</div>');
			d3.append('还差<text>'+gbList2[i].ungbnums+'人</text>');
			d2.append(d3); d2.append('<div>剩余<span class="gbdjs-'+gbList2[i].id+'">0:00:00</span></div>');
			d1.append(d2);

			gld.append(d1); gld.append('<div gblid="'+gbList2[i].id+'" onclick="showDAC(this, 3)" class="gtgb-tbn">去拼单</div>');

			$('.gb-list-scroll').append(gld);
        }

        $('#pdzrs').text(app.getObjLength(this.data.itemData.gbList2));

        //倒计时
        setInterval(function(){
        	for (var i in gbList2){
        		$('.gbdjs-'+gbList2[i].id).text(app.timeFormat(gbList2[i].etime));
        	}
        },1000);
	},

	getEvaluate: function(){
		mui.post(app.d.hostUrl + 'ApiProEvaluate/proEvaluates', {
			type: -1,
			pid: page.data.productId,
		}, function(data) {
			if(data.status == 1) {
				var tem_data = {
					data: data.datas,
					pid: page.data.productId,
				};
				var html = template("appraise-template", tem_data);
		        $('.pro-evaluate-div').html(html);
			} else {
				mui.toast("网络错误");
			}
		},'json');
	},
}

function chooseDetail(obj) { //图文详情/产品参数切换
	$('.prodetail').hide();
	$('.swiper-tab-list').removeClass('on');
	$(obj).addClass('on');

	var cw = $(obj).attr('cw');
	if(cw == '1') $('.pro-detail-div').show();
	else if(cw == '2') $('.pro-attrs-div').show();
	else if(cw == '3') {
		$('.pro-evaluate-div').show();
		page.getEvaluate();
	}
}

function gotoHome() { //返回首页
	window.location.replace('../WPages/indexPage');
}

function addFavorites() { //收藏
	var uid = app.ls.get("uid");
	if(uid) {
		var _this = this;
		mui.post(app.d.hostUrl + 'ApiProduct/col', {
			uid: uid,
			pid: page.data.productId
		}, function(data) {
			var data = app.json.decode(data);

			if(data.status == 1) {
				var isSc = page.data.isSc;
				isSc = isSc == 1 ? 0 : 1;
				page.data.isSc = isSc;
				scStatus(isSc);
				var nc = isSc == 0 ? '成功取消' : '收藏成功!';
				mui.toast(nc);
			} else {
				alert(data.err);
			}
		});
	} else app.goLogin();
}

function scStatus(status) { //收藏状态
	if(status == 1) $('#scImg').attr('src', '../img/wapApp/shced.png');
	else $('#scImg').attr('src', '../img/wapApp/shc.png');
}

function showDAC(obj, ot) {
	if(ot == 1) {
		$('.buyOpe').css({
			'background': '#dd2727'
		});
		$('.buyOpe').attr({
			'onclick': 'orderPay('+ot+')'
		});
		if (page.data.itemData.hd_type=='1') {$('#skuprice').text('￥ ' + page.data.itemData.hd_price);page.data.isPriceYh=false;}
		else {$('#skuprice').text('￥ ' + page.data.itemData.price_yh); page.data.isPriceYh=true;}
		$('.buyOpe').text('立即购买');
		mui("#drawer_attr_content").popover('show');

	} else if(ot == 2) {
		$('.buyOpe').css({
			'background': '#f85'
		});
		$('.buyOpe').attr({
			'onclick': 'addShopCart()'
		});
		$('.buyOpe').text('加入购物车');
		mui("#drawer_attr_content").popover('show');
		page.data.isPriceYh=true;
	} else if(ot == 3) {
		if (page.data.itemData.hstatus){
			window.location.replace('../WPages/myGroupBookingPage');
		}else {
			$('.buyOpe').css({
				'background': '#f00'
			});
			$('#skuprice').text('￥ ' + page.data.itemData.hd_price);
			$('.buyOpe').text('确定');

			$('.buyOpe').attr({
				'onclick': 'orderPay('+ot+')'
			});
			mui("#drawer_attr_content").popover('show');
			page.data.gblid = 0;
			page.data.isPriceYh=false;
			if (typeof($(obj).attr("gblid"))!="undefined")page.data.gblid = $(obj).attr("gblid");
		}
	} else if(ot == 4) {
		var hdId = $(obj).attr('hdid');
		if (page.data.itemData.hstatus){
			var cpInfo = {'dotype':'add', 'hdId':hdId, 'proId':page.data.productId, 'skuid':page.data.skuid};
			//app.ls.save('cpinfo', app.json.encode(cpInfo));
			window.location.replace('../WPages/cpDetailPage?dotype=add&hdId='+hdId+'&proId='+page.data.productId+'&skuid='+page.data.skuid);
		}else {
			$('.buyOpe').css({
				'background': '#f00'
			});
			$('.buyOpe').attr({
				'onclick': 'wykj('+hdId+')'
			});
			$('.buyOpe').text('我要砍价');
			mui("#drawer_attr_content").popover('show');
			page.data.isPriceYh=true;
		}
	}
}

function hideDAC() {
	mui("#drawer_attr_content").popover('hide');
}

function chooseAttr(obj, aid, id) { //选择属性
	var proAttrs = page.data.proAttrs;
	proAttrs[aid].cval = id;
	page.data.proAttrs = proAttrs;

	$('.value' + aid).removeClass('value-choose');
	$(obj).addClass('value-choose');

	skuToData();
}

function skuToData() {//sku获取库存和价格
	var sku = '';
	var proAttrs = page.data.proAttrs;
	for(var i in proAttrs) {
		if(!proAttrs[i].cval) return;
		sku += proAttrs[i].cval + ',';
	}
	mui.post(app.d.hostUrl + 'ApiProduct/skuToProInfo', {
		sku: sku,
		pid: page.data.productId
	}, function(data) {
		var data = app.json.decode(data);

		if(data.status == 1) {
			if (page.data.isPriceYh){
				$('#skuprice').text('￥ ' + data.sku.price);
				page.data.proPrice = data.sku.price;
			}
			$('#skustock').text('库存：' + data.sku.stock).data("stock", data.sku.stock);
			page.data.proStock = data.sku.stock;
		} else {
			alert(data.err);
		}
	});
}

function buyNum(ope) {
	var nownum = parseInt($('.nownum').text());
	if(ope == 'd') {
		if(nownum == 1){ mui.toast("购买数量不能低于1"); return;}
		$('.nownum').text(--nownum);
	}else {
		if(nownum == $('#skustock').data("stock")){ mui.toast("购买数量不能大于库存量"); return;}
		$('.nownum').text(++nownum);
	}
}

function orderPay(ope) {
	if(page.buyVerify()) {
		var buynum = parseInt($('.nownum').text());
		if (page.data.itemData.hd_type=='0') var orderInfo = {pid: page.data.productId, num: buynum, type: 'buyNow', skuid: page.data.skuid };
		else if (page.data.itemData.hd_type=='1') var orderInfo = {pid: page.data.productId, num: buynum, hdId: page.data.itemData.hd_id, type: 'promotion', skuid: page.data.skuid };
		else if (page.data.itemData.hd_type=='2') var orderInfo = {pid: page.data.productId, num: buynum, hdId: page.data.itemData.hd_id, type: 'gb', skuid: page.data.skuid, gblid: page.data.gblid };

		app.ls.save('orderInfo', JSON.stringify(orderInfo));
		window.location.href = '../WPages/orderPayPage';
	}
}
function wykj(hdId){
	if(page.buyVerify()) {
		var buynum = parseInt($('.nownum').text());
		//window.location.href = '../WPages/orderPayPage?orderInfo='+JSON.stringify(orderInfo)+'&fxsId=0';

		//app.post('../WPages/orderPayPage', datas);

		var cpInfo = {'dotype':'add', 'hdId':hdId, 'proId':page.data.productId, 'skuid':page.data.skuid};
		//app.ls.save('cpinfo', app.json.encode(cpInfo));
		window.location.replace('../WPages/cpDetailPage?dotype=add&hdId='+hdId+'&proId='+page.data.productId+'&skuid='+page.data.skuid);
	}
}


function addShopCart() { //加入购物车
	var uid = app.ls.get("uid");
	if(uid) {
		if(page.buyVerify()) {
			var buynum = parseInt($('.nownum').text());
			mui.post(app.d.hostUrl + 'ApiShopping/add', {
				uid: uid,
				pid: page.data.productId,
				num: buynum,
				skuid: page.data.skuid
			}, function(data) {
				var data = app.json.decode(data);

				if(data.status == 1) {
					mui.toast('加入成功');
					window.location.replace('../WPages/cartPage');
				} else {
					alert(data.err);
				}
			});
		}
	}else window.location.replace('../WPages/loginPage');
}