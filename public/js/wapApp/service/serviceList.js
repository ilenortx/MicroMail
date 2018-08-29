mui.ready(function() {
	
	page.loadService();

});

var page = {
	data: {

	},
	loadService: function () {
        var _this = this;
        mui.post(app.d.hostUrl + 'ApiUser/serviceCenter', {}, function(data) {
			var data = app.json.decode(data);
			
			var scs = data.scs;
			var mc = $('.mui-content');
			for(var i=0; i<scs.length; ++i){
				var sd = $('<a href="../WPages/serviceDetailPage?scid='+ scs[i].id +'" class="sitem-div"></a>');
				var text = $('<text>'+ scs[i].name +'</text>');
				var img = $('<img src="../img/wapApp/right_arrows.png" />');
				sd.append(text); sd.append(img);
				mc.append(sd);
			}
        });
    },
}