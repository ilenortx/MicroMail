mui.ready(function() {
	//var cpinfo = app.ls.get('cpinfo');
	var dotype = app.getUrlParam('dotype');
	
	if (dotype == 'add') {
		var hdId = app.getUrlParam('hdId'), proId = app.getUrlParam('proId'), skuid = app.getUrlParam('skuid');
		if(!dotype || !hdId || !proId) {alert('数据异常!'); return;}
		
		var cpinfo = {'dotype':dotype, 'hdId':hdId, 'proId':proId, 'skuid':skuid};
		page.data.cpinfo = cpinfo;
		
		cpinfo.dotype = '';
		app.ls.save('cpinfo', app.json.encode(page.data.cpinfo));
		page.data.skuid = cpinfo.skuid;
		page.addCutPrice(cpinfo.hdId, cpinfo.proId);
	}else {
		var ucpId = app.getUrlParam('ucpId'), skuid = app.getUrlParam('skuid');
		if(!dotype || !ucpId) {alert('数据异常!'); return;}
		
		var cpinfo = {'dotype':dotype, 'ucpId':ucpId, 'skuid':skuid};
		page.data.cpinfo = cpinfo;
		
		page.data.ucpId = cpinfo.ucpId;
		page.data.skuid = cpinfo.skuid;
		page.loadDetail();
	}
});

var page = {
	data: {
		cpinfo: {},
		ucpId: 0,
		buyer: {},
		pro: {},
		ucp: {},
		cp: {},
		cpf: {},
		cpr: 1,
		skuid: '',
		cutPrice: 0,
		cjStatus: 0,
	},

	addCutPrice: function(hdid, proid) {
		var _this = this;
		var uid = app.ls.get('uid');
		mui.post(app.d.hostUrl + 'ApiCutPrice/addCutPrice', {
			uid: uid,
			hdId: hdid,
			proId: proid,
			skuid: _this.data.skuid
		}, function(data) {
			var data = app.json.decode(data);

			if(data.status == 1) {
				var cpinfo = {
					'ucpId': data.ucpId,
					'skuid': _this.data.skuid
				}
				app.ls.save('cpinfo', app.json.encode(cpinfo));
				_this.data.ucpId = data.ucpId;
				_this.data.cjStatus = data.addtype == 'new' ? true : false;

				//砍价成功(自己)

				_this.loadDetail();
			} else {
				alert(data.err);
			}
		});
	},

	loadDetail: function() {
		var _this = this;
		var uid = app.ls.get('uid');

		mui.post(app.d.hostUrl + 'ApiCutPrice/cpDetail', {
			uid: uid,
			ucpId: _this.data.ucpId
		}, function(data) {
			var data = app.json.decode(data);

			if(data.status == 1) {
				var cutPrice = Math.floor((data.pro.price_yh - data.cp.low_price) / data.cp.friends * data.ucp.cpnum * 100) / 100;
				if(data.buyer.photo) $('.userinfo-avatar').attr('src', data.buyer.photo);
				$('.username').text(data.buyer.uname);
				
				$('.proinfo-div').attr('href','../WPages/proDetailPage?productId='+data.pro.id);
				$('.info-img').attr('src', app.d.hostImg + data.pro.photo_x);
				$('.pro-name').text(data.pro.name);
				$('.proyj').text('原价￥' + data.pro.price_yh);
				$('.prolowj').text('最低价￥' + data.cp.low_price);

				$('.proyj1').text('￥' + data.pro.price_yh);
				$('.prolowj1').text('￥' + data.cp.low_price);
				$('.kdjg').text('￥' + cutPrice);
				$('.progress').css({
					'width': data.ucp.cpnum / data.cp.friends * 100 + '%'
				});
				$('.pgi-div').css({
					'left': 'calc(' + data.ucp.cpnum / data.cp.friends * 100 + '% - 15px'
				});
				$('.all-cp').text(cutPrice);
				$('.kjhys').text(data.ucp.cpnum);

				if(data.dotype == 1 && data.ucp.cp_result == '1') {
					$('#yqgm').css('display', 'flex');
					
					/*var share = {title:'我发现一件好货，来一起砍价',desc:'data.pro.name',
								link:app.d.hostUrl+'WPages/cpDetailPage?dotype=detail&ucpId='+_this.data.ucpId,
								imgUrl:app.d.hostImg+data.pro.photo_x,success:function(){alert('分享成功');}};*/
					var share = {title:'专致优货',desc:'sssdfas',link:app.d.hostUrl+'WPages/cpDetailPage',imgUrl:'https://wx.yingyuncn.com/img/wapApp/user-avatar.png',success:function(){alert(123342323)}};
					app.wxShare(share);
				}
				if(data.ucp.cp_result == '4') $('#jycg').css('display', 'flex');
				if(data.ucp.cp_result == '3') $('#ljgm').css('display', 'flex');
				if(data.dotype == 2 && data.ucp.cp_result == '1') $('#btkyd').css('display', 'flex');

				if(_this.data.cjStatus) mui("#cpsuc").popover('show');
				if(data.dotype == 1) $('#yqhykj').show();
				else if(data.dotype == 2) {
					$('#wyykj').attr('href','../WPages/proDetailPage?productId='+data.pro.id);
					$('#wyykj').show();
				}

				_this.data.buyer = data.buyer;
				_this.data.pro = data.pro;
				_this.data.ucp = data.ucp;
				_this.data.cp = data.cp;
				_this.data.cpf = data.cpf;
				_this.data.cpr = data.cpr;
				_this.data.cutPrice = cutPrice;

				_this.cdomcf();

				if(data.ucp.cp_result == '1') _this.countDown();
			} else {
				alert(data.err);
			}
		});
	},

	loadCpfriends: function() { //加载砍价朋友
		var _this = this;

		mui.post(app.d.hostUrl + 'ApiCutPrice/cpfriends', {
			ucpId: _this.data.ucpId
		}, function(data) {
			var data = app.json.decode(data);
			_this.cdomcf();
			if(data.status == 1) {
				_this.data.cpf = data.cpf;
			} else {
				alert(data.err);
			}
		});
	},

	cdomcf: function() {
		$('#cpfriends').html('');
		var cutPrice = Math.floor((this.data.pro.price_yh - this.data.cp.low_price) / this.data.cp.friends * this.data.ucp.cpnum * 100) / 100;
		for(var i in this.data.cpf) {
			var cpf = this.data.cpf[i];

			var kjhyDiv = $('<div class="kjhy-div"></div>');
			if(cpf.avatar) var kdImg = $('<img class="hy-img" src="' + cpf.avatar + '"/>');
			else var kdImg = $('<img class="hy-img" src="../img/wapApp/user-avatar.png"/>');

			var kjinfo = $('<div class="kjinfo"></div>');
			kjinfo.append('<div class="hyname">' + cpf.fname + '</div>');
			kjinfo.append('<div class="kjtime">' + cpf.time + '</div>');

			kjhyDiv.append(kdImg);
			kjhyDiv.append(kjinfo);
			kjhyDiv.append('<div class="kdje">帮砍￥' + cutPrice / this.data.ucp.cpnum + '</div>');
			$('#cpfriends').append(kjhyDiv);
		}
	},

	countDown: function() { //倒计时
		var _this = this;
		setInterval(function() {
			$('.djs-span').text(app.timeFormat(page.data.cp.etime));
		}, 1000);
	}
}

function closeCpsuc() {
	mui("#cpsuc").popover('hide');
}

function buyNow() { //立即购买
	if(page.data.cp.cptype == 2) {
		var orderInfo = {
			pid: page.data.ucp.pro_id,
			num: page.data.ucp.bnum,
			type: 'cutPrice',
			cpId: page.data.ucpId,
			skuid: page.data.skuid
		};

		app.ls.save('orderInfo', JSON.stringify(orderInfo));
		window.location.replace('../WPages/orderPayPage');
	} else {
		alert('需砍价到底！');
	}
}

function helpCutPrice() { //帮Ta坎一🔪
	var _this = this;

	mui.post(app.d.hostUrl + 'ApiCutPrice/helpCutPrice', {
		openid: '',
		ucpId: page.data.ucpId
	}, function(data) {
		var data = app.json.decode(data);

		if(data.status == 1) {
			mui("#cpsuc").popover('show');
			$('#wyykj').show();
		} else {
			alert(data.err);
		}
	});
}


function ifcutPrice(){//邀请好友砍价
	if (app.isWxBrowser()){//判断是否事微信
		mui("#ysjfx").popover('show');
	}else {
		mui("#wxbfx").popover('show');
	}
}

function hideYsjfx(id){
	mui("#"+id).popover('hide');
}

