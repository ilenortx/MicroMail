mui.ready(function() {
	mui.post(app.d.hostUrl + 'ApiShop/shopInfo', {
		shop_id: 1
	}, function(data) {
		if(data.status == 1) {
			page.data.shopInfo = data;
			$('#concent').html(data.shopInfo.content);
			$('#concent').css({'background':'#fff', 'padding':'55px 10px 10px 10px'});
		} else {
			mui.toast("网络错误");
		}
	}, 'json');
});

var page = {
	data: {
		shopInfo: []
	},

}