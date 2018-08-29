<div class="mui-content ofauto">
	<div class="head-div">
		<div class="userinfo">
			<img class="userinfo-avatar" src="../img/wapApp/user-avatar.png" />
			<text style="font-size:12px;">
				<span class="username"></span>发现一件好货，帮Ta砍到对低价吧
			</text>
		</div>

		<a class="proinfo-div">
			<div class="pro-div">
				<img class="info-img" />
				<div class="info-div">
					<div class="pro-name">雷米高新澳丽得猫粮海洋鱼味英国短毛折耳猫猫粮去毛球幼猫粮500g</div>
					<div class="countdown-div">距离活动结束仅剩<span class="djs-span">0:00:00</span></div>
					<div class="pro-price">
						<text class="proyj">原价￥13.00</text>
						<div class="prolowj" style="color:#c60000;font-size:13.5px;">最低价￥17</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	<div class="sjx"></div>

	<!-- 进度条 -->
	<div class="jd-div">
		<text class="proyj1">￥</text>
		<div class="progress-div">
			<div class="pgi-div">
				<div class="kdjg"></div>
				<div class="sjx1"></div>
			</div>
			<div class="progress"></div>
		</div>
		<text class="prolowj1">￥</text>
	</div>

	<div class="discript">已有<text class="kjhys">0</text>位好友帮Ta砍价了，共砍掉：￥<text class="all-cp"></text></div>

	<div class="kj-btn-div">
		<div id="yqgm">
			<div onclick="ifcutPrice();" class="yqhykj">邀请好友砍价</div>
			<div onclick="buyNow()" class="ljgm">立即购买</div>
		</div>

		<div id="jycg" class="ljgm1">交易成功</div>
		<div onclick="buyNow()" id="ljgm" class="ljgm1">立即购买</div>
		<div onclick="helpCutPrice()" id="btkyd" class="btkyd">帮Ta砍一刀</div>
	</div>

	<div class="kjjl-div">
		<div class="kjtitle">
			<div class="ktline"></div>
			<text class="kjjl">砍价记录</text>
			<div class="ktline"></div>
		</div>

		<div id="cpfriends"></div>
		<!--<div class="kjhy-div">
			<img class="hy-img" src="../img/wapApp/user-avatar.png"/>
			<div class="kjinfo">
				<div class="hyname">小伙伴</div>
				<div class="kjtime">2018-08-15 11:14:20</div>
			</div>
			<div class="kdje">帮砍￥-2.00</div>
		</div>-->
	</div>
</div>
<div id="cpsuc" class="box mui-popover mui-popover-action mui-popover-bottom">
	<div class="cp-success-div">
		<img class="cpsd-img" src="../img/wapApp/kjcg.png" />
		<div class="cpInfo-div">
			<div style="font-size:12px;">您一出手就帮好友砍掉
				<text class="scpp-text">-2</text>元
			</div>
			<button id="yqhykj" class="cjbtn">邀请好友砍价</button>
			<a id="wyykj" class="cjbtn">我也要砍价</a>
		</div>
		<div onclick="closeCpsuc()" class="close-cps-div">×</div>
	</div>
</div>
<!-- 提示右上角分享 -->
<div id="ysjfx" class="box mui-popover mui-popover-action mui-popover-bottom">
	<div class="fxts-div">
		<img src="../img/wapApp/ysjfx.png" />
		<div onclick="hideYsjfx('ysjfx')" class="wzdl-btn"></div>
	</div>
</div>
<!-- 提示是哟微信浏览器打开 -->
<div id="wxbfx" class="box mui-popover mui-popover-action mui-popover-bottom">
	<div class="fxts-div">
		请使用微信浏览打开
	</div>
</div>