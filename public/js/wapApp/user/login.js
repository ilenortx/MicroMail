mui.ready(function() {
	page.initWinWH();
	$('#footer').width(page.data.winWidth-80);
	var loginInfo = app.ls.get("loginInfo");
	if (loginInfo){
		loginInfo = app.json.decode(loginInfo);
		$('#account').val(loginInfo[0]);
		$('#password').val(loginInfo[1]);
	}
	
	if (app.isWxBrowser()) $('#wx-login').show();
	
	$('#login').click(function(){
		var account = $('#account').val();
		var password = $('#password').val();
		var password_confirm = $('#password_confirm').val();
		var uname = $('#uname').val();
		var email = $('#email').val();
		var tel = $('#tel').val();

		if(!account) alert('请输入用户名！');
		else if(!password) alert('请输入密码！');
		else {
			mui.post(app.d.hostUrl + 'Wuser/login', {
				account: account, password: password
			}, function(data) {
				var data = app.json.decode(data);

				if(data.status == 1) {
					var li = [account, password];
					app.ls.save("loginInfo", app.json.encode(li));
					app.ls.save("uid", data.uid);
					
					app.d.userId = data.uid;
					//mui.openWindow({ url: '../WPages/indexPage' });
					window.location.replace('..'+data._url);
				} else alert(data.err);
			});
		}
	});
	$(window).resize(function() { $('body').height(page.data.winHeight); });

});

var page = {
	data: {
		winWidth: 0,
		winHeight: 0,

	},
	initWinWH: function() {
		this.data.winWidth = $(window).width();
		this.data.winHeight = $(window).height();
	},
}

function ologin(type){
	if (type == 1){
		var url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxd55afa782060d185&redirect_uri=http%3A%2F%2Fx.viphk.ngrok.org%2FMicroMail%2FWuser%2FxlgetUserInfo&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect';
		//mui.post(app.d.hostUrl + 'Wuser/wxLogin', { }, function(data) {
		mui.post(url, { }, function(data) {
			var data = app.json.decode(data);

			if(data.status == 1) {
				var li = [account, password];
				app.ls.save("loginInfo", app.json.encode(li));
				app.ls.save("uid", data.uid);
					
				app.d.userId = data.uid;
				//mui.openWindow({ url: '../WPages/indexPage' });
				window.location.replace('../WPages/indexPage');
			} else alert(data.err);
		});
	}
}
