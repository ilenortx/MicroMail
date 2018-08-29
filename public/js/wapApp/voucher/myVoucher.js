mui.ready(function() {

	page.loadVoucher();
});

var page = {
	data: {
		varr: [],

	},

    loadVoucher: function () {
        var _this = this;
        var xx = app.ls.get("uid");
        mui.post(app.d.hostUrl + 'ApiVoucher/myVoucher', {uid: app.ls.get("uid")}, function(data){
        	var data = app.json.decode(data);
			if(data.status == 1) {
				_this.data.varr = data.varr;
				
				var mc = $('.mui-content');
				function cdom(obj){
					var vid = $('<div class="voucher-item-div"></div>');
				
					var vtd = $('<div class="vi-top-div"></div>');
					var vtld = $('<div class="vit-left-div"></div>');
					var vtlt1 = $('<text class="vit-t1">￥</text>');
					var vtlt2 = $('<text class="vit-t2">124</text>');
					vtld.append(vtlt1); vtld.append(vtlt2);
					var vtrd = $('<div class="vit-right-div"></div>');
					var vtrt1 = $('<text>满100.00可用</text>');
					var vtrt2 = $('<text>2017-08-12-2018-09-12</text>');
					vtrd.append(vtrt1); vtrd.append(vtrt2);
					vtd.append(vtld); vtd.append(vtrd);
					
					var vbd = $('<div class="vi-bottom-div"></div>');
					var vbt1 = $('<text class="vib-left">端午优惠，先到就先得</text>');
					var vbt2 = $('<text class="vib-right">积分数:0</text>');
					vbd.append(vbt1); vbd.append(vbt2);
					
					vid.append(vtd); vid.append(vbd);
					
					return vid;
				}
				
				for (var i=0; i<data.varr.length; ++i){
					mc.append(cdom(data.varr[i]));
				}
				
			}else alert(data.err);
       });
    },


}