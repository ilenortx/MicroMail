mui.ready(function() {
	page.initWinWH();
	$('#footer').width(page.data.winWidth-80);
	$('#reg').click(function() {
		var account = $('#account').val();
		var password = $('#password').val();
		var password_confirm = $('#password_confirm').val();
		var uname = $('#uname').val();
		var email = $('#email').val();
		var tel = $('#tel').val();

		if(!account) alert('请输入用户名！');
		else if(!password) alert('请输入密码！');
		else if(!password_confirm) alert('请输入确认密码！');
		else if(!uname) alert('请输入用户名！');
		else if(password != password_confirm) alert('两次密码不同！');
		else if(!tel) alert('请输入手机号！');
		else {
			mui.post(app.d.hostUrl + 'Wuser/register', {
				account: account,
				password: password,
				uname: uname,
				email: email,
				tel: tel
			}, function(data) {
				var data = app.json.decode(data);

				if(data.status == 1) {
					var li = [account, password];
					app.ls.save("loginInfo", app.json.encode(li));
					//alert("注册成功!");
					//mui.openWindow({ url: '../WPages/loginPage' });
					window.location.replace('../WPages/loginPage');
				} else alert(data.err);
			});
		}
	});

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