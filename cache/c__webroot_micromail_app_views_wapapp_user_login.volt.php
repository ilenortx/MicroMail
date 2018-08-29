<div class="mui-content">
	<div style="background: linear-gradient(to right,#b6e86f,#33b0e6);-webkit-background-clip:text;color:transparent;font-size:40px;text-align:center;line-height:80px;">
		suiweigou
	</div>
	<form id='login-form' action="" class="mui-input-group">
		<div class="mui-input-row login-border">
			<label>账号</label>
			<input id='account' type="text" class="mui-input-clear mui-input" placeholder="请输入账号">
		</div>
		<div class="mui-input-row login-border">
			<label>密码</label>
			<input id='password' type="password" class="mui-input-clear mui-input" placeholder="请输入密码">
		</div>

		<div class="mui-content-padded">
			<input type="button" id='login' class="mui-btn mui-btn-block mui-btn-primary" value="登录"/>
			<div class="link-area">
				<a href="../WPages/registerPage" id='reg'>注册账号</a>
				 <span class="spliter">|</span>
				<a id='forgetPassword'>忘记密码</a>
			</div>
		</div>

		<div class="ologin">
			<!--<img onclick="ologin(1)" id="wx-login" src="../img/wapApp/wx-icon1.png"/>-->
			<a href="../Wuser/wxLogin"><img id="wx-login" src="../img/wapApp/wx-icon1.png"/></a>
		</div>
	</form>

	<div id="footer">
		Don't Have an account?<span style="color:#000;font-size:14px;">Create one!</span>
	</div>
</div>