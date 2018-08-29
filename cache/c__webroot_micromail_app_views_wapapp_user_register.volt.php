<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>用户登陆</title>

		<?= $this->assets->outputCss() ?> <?= $this->assets->outputJs() ?>

	</head>
	<script type="text/javascript" charset="utf-8">
		mui.init();
	</script>

	<body>
		<div class="mui-content">
			<form class="mui-input-group">
				<img id="avatar" src="../img/wapApp/user-avatar.png" />
				<div class="mui-input-row login-border">
					<label>账号</label>
					<input id='account' type="text" class="mui-input-clear mui-input" placeholder="请输入账号">
				</div>
				<div class="mui-input-row login-border">
					<label>密码</label>
					<input id='password' type="password" class="mui-input-clear mui-input" placeholder="请输入密码">
				</div>
				<div class="mui-input-row login-border">
					<label>确认</label>
					<input id='password_confirm' type="password" class="mui-input-clear mui-input" placeholder="请确认密码">
				</div>
				<div class="mui-input-row login-border">
					<label>姓名</label>
					<input id='uname' type="text" class="mui-input-clear mui-input" placeholder="请输入姓名">
				</div>
				<div class="mui-input-row login-border">
					<label>邮箱</label>
					<input id='email' type="email" class="mui-input-clear mui-input" placeholder="请输入邮箱">
				</div>
				<div class="mui-input-row login-border">
					<label>手机</label>
					<input id='tel' type="number" class="mui-input-clear mui-input" placeholder="请输入手机号">
				</div>
					
				<div class="mui-content-padded">
					<!--<button id='reg' class="mui-btn mui-btn-block mui-btn-primary">注册</button>-->
					<input type="button" id='reg' class="mui-btn mui-btn-block mui-btn-primary" value="注册" />
				</div>
			</form>
			
			<div id="footer">
				Don't Have an account?<span style="color:#000;font-size:14px;">Create one!</span>
			</div>
		</div>
	</body>
</html>
<script>
	
	
</script>