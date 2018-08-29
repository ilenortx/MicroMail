mui.ready(function() {
	page.initWinWH();
	page.loadVoucher();
	
	$(window).resize(function() { $('body').height(page.data.winHeight); });
});

var page = {
	data: {
		winWidth: 0,
		winHeight: 0,
		varr: [],

	},

	initWinWH: function() {
		this.data.winWidth = $(window).width();
		this.data.winHeight = $(window).height();
	},
	loadVoucher: function() {
		var _this = this;
		var xx = app.ls.get("uid");
		mui.post(app.d.hostUrl + 'ApiVoucher/unGetVoucher', {
			uid: app.ls.get("uid")
		}, function(data) {
			var data = app.json.decode(data);
			if(data.status == 1) {
				_this.data.varr = data.varr;

				var mc = $('.mui-content'); mc.html('');

				function cdom(obj) {
					var vid = $('<div class="voucher-item-div"></div>');

					var vtd = $('<div class="vi-top-div"></div>');
					var vtld = $('<div class="vit-left-div"></div>');
					var vtlt1 = $('<text class="vit-t1">￥</text>');
					var vtlt2 = $('<text class="vit-t2">'+ obj.amount +'</text>');
					vtld.append(vtlt1);
					vtld.append(vtlt2);
					var vtrd = $('<div class="vit-right-div"></div>');
					var vtrt1 = $('<text>满'+ obj.full_money +'可用</text>');
					var vtrt2 = $('<text>'+ obj.start_time +'-'+ obj.end_time +'</text>');
					vtrd.append(vtrt1);
					vtrd.append(vtrt2);
					var djlq = $('<div class="djlq" vid="'+ obj.id +'" onclick="getVoucher(this);">立即领取</div>');
					vtd.append(vtld);
					vtd.append(vtrd);
					vtd.append(djlq);

					var vbd = $('<div class="vi-bottom-div"></div>');
					var vbt1 = $('<text class="vib-left">'+ obj.title +'</text>');
					var vbt2 = $('<text class="vib-right">积分数:'+ obj.point +'</text>');
					vbd.append(vbt1);
					vbd.append(vbt2);

					vid.append(vtd);
					vid.append(vbd);

					return vid;
				}

				for(var i = 0; i < data.varr.length; ++i) {
					mc.append(cdom(data.varr[i]));
				}

			} else alert(data.err);
		});
	},

}

function getVoucher(obj) {
	var _this = this;
	var vid = $(obj).attr('vid');
	var uid = app.ls.get("uid");

	if (uid){
		mui.post(app.d.hostUrl + 'ApiVoucher/getCoupon', {
			uid: uid, vid: vid
		}, function(data) {
			var data = app.json.decode(data);
			if(data.status == 1) {
				page.loadVoucher();
	
			} else alert(data.err);
		});
	}else window.location.replace('../WPages/loginPage');
}