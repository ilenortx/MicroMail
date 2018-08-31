mui.ready(function() {
	var zz = app.ls.get("uid");

	if (app.ls.get("uid")) { page.loadUserInfo(); page.loadOrderStatus(); }

	page.bindAction();
});

var page = {
	data: {
		userInfo: [],
		orderInfo: [],

	},

	loadUserInfo: function() {
		var _this = this;
		mui.post(app.d.hostUrl + 'Wuser/userInfo', {
			uid: app.ls.get("uid")
		}, function(data) {
			var data = app.json.decode(data);
			if(data.status == 1) {
				_this.data.userInfo = data.infos;

				$('.uname').text(data.infos.uname);
				if (data.infos.photo) $('.avatar').css({'background':'url('+data.infos.photo+')','background-size':'100% 100%'});

                app.ls.save("avatar", data.infos.photo? data.infos.photo:'../img/wapApp/user-avatar.png');
			} else {
				alert(data.err);
			}
		});
	},
	loadOrderStatus: function () {
        //获取用户订单数据
        var _this = this;
        mui.post(app.d.hostUrl + 'ApiUser/getorder', {
			userId: app.ls.get("uid")
		}, function(data) {
			var data = app.json.decode(data);
			if(data.status == 1) {
				var oi = data.orderInfo;
				_this.data.orderInfo = oi;

				$('.kc0').text("("+ oi.pay_num +")");
				$('.kc1').text("("+ oi.deliver_num +")");
				$('.kc2').text("("+ oi.rec_num +")");
				$('.kc3').text("("+ oi.finish_num +")");
				$('.kc4').text("("+ oi.refund_num +")");
			} else {
				alert(data.err);
			}
        });
    },

    loginOut: function(){
		mui.post(app.d.hostUrl + 'Wuser/logout', {
		}, function(data) {
			app.ls.save('uid', '');
			app.goLogin();
        });
    },

    editAvatar: function(){
        location.href = "../WPages/editAvatarPage";
    },

    bindAction: function(){
    	mui('.user-info-div').on('tap', '.grset', function(e){
	        $('.uMenu').toggleClass('current');
	    });
    }
}