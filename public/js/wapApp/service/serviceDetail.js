mui.ready(function() {
	
	page.loadServiceDetail();

});

var page = {
	data: {
		scid: 0
	},
	loadServiceDetail: function () {
        var _this = this;
        mui.post(app.d.hostUrl + 'ApiUser/scDetail', { scid:_this.data.scid }, function(data) {
			var data = app.json.decode(data);
			
			var mc = $('.mui-content');
			if (data.status == 1) {
				mc.html(data.content);
			}
        });
    },
}