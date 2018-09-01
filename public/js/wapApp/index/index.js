mui.ready(function() {
	page.initWinWH();

	var share = {title:'专致优货',desc:'注重品质，追求卓越，专致优货。',link:app.d.hostUrl+'WPages/indexPage',imgUrl:imgPath+'common/zzyh-logo.png',success:function(){alert('分享成功!')}};
	app.wxShare(share);

	//$('.cgimg').css({'width':(page.data.winWidth-20)/5-12,'height':(page.data.winWidth-20)/5-10})

	$('.av-left-div').css({'width':(page.data.winWidth-20)/2-5,'height':page.data.winWidth/1.8,'margin-right':5})
	$('.av-right-div').css({'width':(page.data.winWidth-20)/2-5,'height':page.data.winWidth/1.8,'margin-left':5})
	$('.avr-top-div').css({'height':page.data.winWidth/3.6-5})
	$('.avr-bottom-div').css({'height':page.data.winWidth/3.6-5,'margin-top':10})

	//加载数据
	mui.post(app.d.hostUrl + 'ApiIndex/index', {
		shop_id: app.d.shopId
	}, function(data) {
		var data =  app.json.decode(data);
		page.data.nattrs = data.nchead;
		page.data.headNotice = data.notice;
		page.data.bannerList = data.ads;
		page.data.syflList = data.syflList;
		page.data.aaci = data.aaci;
		//page.data.gbArr = data.gbps;
		page.data.goods = data.pros.prolist;

		page.syflList(); page.activity(); page.notice(); page.banner(); //page.groupBooking();
		page.goods();
	});

	page.loadVoucher();
});

var page = {
	data: {
		winWidth: 0,
		winHeight: 0,
		shopId: 'all',
		nattrs: [],
		headNotice: [],
		bannerList: [],
        syflList: [],//首页分类
        choosedCg: 0,
        aaci: [],//活动专区
        vouchers: [],//优惠券

        gbArr: [],
        goods: [],
	},
	initWinWH: function() {
		this.data.winWidth = $(window).width();
		this.data.winHeight = $(window).height();
	},

	notice: function() { //提示
		var nattrs = this.data.nattrs;
		var nd = $('.notice-dive');
		nd.css({'background':nattrs.bgcolor, 'color':nattrs.color});

		var notice = this.data.headNotice;
		var nstr = "";
		for(var i=0; i<notice.length; ++i){
			nstr += notice[i].content + "&nbsp;&nbsp;&nbsp;&nbsp;";
		}

		var marquee = $('.marquee');
		marquee.html(nstr);
	},
	banner: function() { //创建轮播图
		if(this.data.bannerList && this.data.bannerList.length) {
			var bl = this.data.bannerList;
			var banner = $('#banner');

			for(var i = 0; i < bl.length; ++i) {
				var img = $('<img  src="' + app.d.hostImg + bl[i].photo + '" class="swiper-slide" />');
				banner.append(img);
			}

			var swiper = new Swiper('.swiper-container', {
				slidesPerView: 1,
				loop: true,
				centeredSlides: true,
				autoplay: {
					delay: 2500,
					disableOnInteraction: false,
				},
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
				},
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
			});
		}
	},

	syflList: function(){
		var width = this.data.winWidth;
		var syflList = this.data.syflList;

		var choosedCg = 0;
		$('.flitems-div').html('');
		for (var i in syflList){
			if (syflList[i].postatus == '1') {
				this.data.choosedCg = i; choosedCg = i;
				var fl = $('<div class="fl-item flitem-on">'+syflList[i].name+'</div>');
			}
			else var fl = $('<div onclick="cutCg('+i+')" class="fl-item">'+syflList[i].name+'</div>');
			$('.flitems-div').append(fl);
		}

		var fllist = syflList[choosedCg];
		var hi = app.d.hostImg;
		$('.lxitems-div').html('');
		if (fllist.ctype == 'hst'){
			var hst = $('<div id="hst" style="display:flex;"></div>');

			var ald = $('<a href="../WPages/proDetailPage?productId='+ fllist.zproid +'" class="av-left-div" ></a>');
			ald.append('<img src="'+hi+fllist.zphoto+'" />');
			ald.css({'width':(page.data.winWidth-20)/2-5,'height':page.data.winWidth/1.8,'margin-right':5});

			var ard = $('<div class="av-right-div"></div>');
			ard.css({'width':(page.data.winWidth-20)/2-5,'height':page.data.winWidth/1.8,'margin-left':5});
			var artd = $('<a href="../WPages/proDetailPage?productId='+ fllist.rtproid +'" class="avr-top-div"></a>');
			artd.append('<img src="'+hi+fllist.rtphoto+'" />');
			artd.css({'height':page.data.winWidth/3.6-5});

			var arbd = $('<a href="../WPages/proDetailPage?productId='+ fllist.rbproid +'" class="avr-bottom-div"></div>');
			arbd.append('<img src="'+hi+fllist.rbphoto+'" />');
			arbd.css({'height':page.data.winWidth/3.6-5,'margin-top':10});

			ard.append(artd); ard.append(arbd);
			hst.append(ald); hst.append(ard);
			$('.lxitems-div').append(hst);
		}else {
			for(var i in fllist.childs){
				var lxItem = $('<a href="../WPages/categoryProsPages?cgid='+fllist.childs[i].id+'" class="lx-item"></a>');
				var img = $('<img class="cgimg" src="'+hi+fllist.childs[i].bz_1+'" />');
				img.css({'width':(page.data.winWidth-20)/5-12,'height':(page.data.winWidth-20)/5-10});
				var text = $('<text>'+fllist.childs[i].name+'</text>');
				lxItem.append(img); lxItem.append(text);
				$('.lxitems-div').append(lxItem);
			}
		}
	},
	activity:function(){//活动专区

		var aaci = this.data.aaci;
		if (aaci.id){
			var url = {'1':'../WPages/gbMorePage','2':'../WPages/promotionMorePage','3':'../WPages/cpMorePage'};
			var hi = app.d.hostImg;
			$('.activity-div').show();
			$('.hdzq-text').text(aaci.zqname);
			$('.hdtitle-text').text(aaci.btname);

			$('#aldImg').attr({'src':hi+aaci.zphoto});
			$('#aldImg').parent('a').attr('href',url[aaci.ztype]);

			$('#artdImg').attr({'src':hi+aaci.rtphoto});
			$('#artdImg').parent('a').attr('href',url[aaci.rttype]);

			$('#arbdImg').attr({'src':hi+aaci.rbphoto});
			$('#arbdImg').parent('a').attr('href',url[aaci.rbtype]);
		}
	},

	groupBooking: function(){//团购
		var gbList = $('.gb-list-div');
		function cdom(obj){
			var gbItem = $('<div class="gb-item-div"></div>');
			var proImg = $('<img class="gb-pro-img" src="'+ app.d.hostImg+obj.proInfo.photo_x +'" />');

			var gbInfo = $('<div class="gb-info-div"></div>');
			var gbNum = $('<divv class="gb-nums">'+ obj.mannum +'人拼</div>');
			var gbprice = $('<text class="gbprice">￥'+ obj.gbprice +'</text>');
			gbInfo.append(gbNum); gbInfo.append(gbprice);

			var yprice = $('<div class="yprice">￥'+ obj.proInfo.price_yh +'</div>');
			gbItem.append(proImg); gbItem.append(gbInfo); gbItem.append(yprice);

			return gbItem;
		}

		var gbArr = this.data.gbArr;
		for(var i=0; i<gbArr.length; ++i){
			gbList.append(cdom(gbArr[i]));
		}
	},
	loadVoucher: function(){//加载优惠券
		$('.voucher-items-div').html('');
		var _this = this;
		function cdom(obj){
			var voucherItem = $('<div class="voucher-item-div"></div>');
			var vtop = $('<div class="vtop"></div>');
			var fl = $('<text class="font-left">￥</text>');
			var fr = $('<text class="font-right">'+obj.amount+'</text>');
			var vbottom = $('<div class="vbottom">满'+obj.full_money+'可使用</div>');

			vtop.append(fl); vtop.append(fr);
			voucherItem.append(vtop); voucherItem.append(vbottom);

			//return voucherItem;
			voucherItem.click(function(){ getVou(obj.id); });
			$('.voucher-items-div').append(voucherItem);
		}
		mui.post(app.d.hostUrl + 'ApiVoucher/unGetVoucher', {
			uid: app.ls.get("uid")
		}, function(data) {
			var data =  app.json.decode(data);
			if (data.status == 1){
				_this.data.vouchers = data.varr;

				if (data.varr.length){
					for (var i in data.varr){
						cdom(data.varr[i]);
					}
					$('.voucher-div').show();
				}else $('.voucher-div').hide();
			}else alert(data.err);
		});
	},
	goods: function(){
		var width = this.data.winWidth;
		var goods = $('.goods');
		var proImgWH = width*0.28;
		function cdom(obj){
			var goodsDiv = $('<div class="goods-div"></div>');

			var moreDiv = $('<a href="../WPages/promorePage?cid='+ obj.id +'" class="more-div" style="height:'+width/2.5+'px;margin:5px 0"></a>');
			/*var caption = $('<div class="caption-div"></div>');
			var hx = $('<img src="../img/wapApp/hx.png" />');
			caption.append(hx); caption.append(obj.container); caption.append(hx);
			var moreRight = $('<a href="../WPages/promorePage?cid='+ obj.id +'" class="more-right"></a>');
			moreRight.append("更多"); moreRight.append('<img src="../img/wapApp/right_arrows.png" />');
			moreDiv.append(caption); moreDiv.append(moreRight);*/
			var moreImg = $('<img style="width:100%;height:100%;" src="'+app.d.hostImg+obj.cgicon+'" />');
			moreDiv.append(moreImg);

			var goodsList = $('<div class="goods-list-div"></div>');
			var gl = obj.goods_list;
			for (var i=0; i<gl.length; ++i){
				var goodsItem = $('<a href="../WPages/proDetailPage?productId='+ gl[i].id +'" class="goods-item"></a>');
				var gimg = $('<img src="'+ app.d.hostImg+gl[i].img +'" style="height:'+proImgWH+'px;width:'+proImgWH+'px;" />');
				var title = $('<text class="title">'+ gl[i].name +'</text>');
				var price = $('<div class="price">￥'+ gl[i].price_yh +'</div>');
				goodsItem.append(gimg); goodsItem.append(title); goodsItem.append(price);
				goodsList.append(goodsItem);
			}

			goodsDiv.append(moreDiv); goodsDiv.append(goodsList);
			return goodsDiv;
		}

		var goodsData = this.data.goods;
		for(var i=0; i<goodsData.length; ++i){
			goods.append(cdom(goodsData[i]));
		}
	}
}

function cutCg(cgnum){//切换分类
	page.data.choosedCg = cgnum;
	for (var i in page.data.syflList){
		 page.data.syflList[i].postatus = '0';
	}
	page.data.syflList[cgnum].postatus = '1';

	page.syflList();
}

function getVou(vid){
	if (!app.ls.get("uid")) {
		window.location.replace('../WPages/loginPage'); return;
	}
	var _this = this;
	mui.post(app.d.hostUrl + 'ApiVoucher/getCoupon', {
		uid: app.ls.get("uid"), vid: vid
	}, function(data) {
		var data = app.json.decode(data);
		if (data.status == 1){
			page.loadVoucher();
			mui("#vou-get-success").popover('show');
		}else alert(data.err);
	});
}
	
