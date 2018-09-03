<div class="mui-content mb-50 ofauto">
	<div class="user-info-div">
		<div class="avatar"></div>
		<text class="uname"></text>
		<div class="uMenu">
			<div class="grset">设置</div>
			<div class="menu-box">
				<!-- <a>编辑资料</a> -->
				<a onclick="page.editAvatar()" href="javascript:void(0);">更换头像</a>
				<a id="uLogout" onclick="page.loginOut()" href="javascript:void(0);">退出登陆</a>
			</div>
		</div>
	</div>

	<!-- 订单 -->
	<div class="order-div">
		<div class="order-top-div">
			<text class="otd-left">全部订单</text>
			<a href="../WPages/orderPage?oitem=0" class="otd-right-div">查看全部订单&nbsp;＞</a>
		</div>
		<div class="order-bottom-div">
			<a href="../WPages/orderPage?oitem=0" class="qo-item">
				<img src="../img/wapApp/my_order/dfk.png" />
				<text>待付款<span class="kc0">(0)</span>)</text>
			</a>
			<a href="../WPages/orderPage?oitem=1" class="qo-item">
				<img src="../img/wapApp/my_order/dfh.png" />
				<text>待发货<span class="kc1">(0)</span></text>
			</a>
			<a href="../WPages/orderPage?oitem=2" class="qo-item">
				<img src="../img/wapApp/my_order/dpl.png" />
				<text>待收货<span class="kc2">(0)</span></text>
			</a>
			<a href="../WPages/orderPage?oitem=3" class="qo-item">
				<img src="../img/wapApp/my_order/dsh.png" />
				<text>已完成<span class="kc3">(0)</span></text>
			</a>
			<a href="../WPages/orderPage?oitem=4" class="qo-item">
				<img src="../img/wapApp/my_order/tksh.png" />
				<text>退款/售后<span class="kc4">(0)</span></text>
			</a>
		</div>
	</div>

	<!-- 功能列表 -->
	<div class="app-list-div">
		<a href="../WPages/myCutPricePage" class="app-item-div">
			<img src="../img/wapApp/cutPrice_icon.png" />
			<text>我的砍价</text>
		</a>

		<a href="../WPages/myGroupBookingPage" class="app-item-div">
			<img src="../img/wapApp/groupBooking_icon.png" />
			<text>我的团购</text>
		</a>

		<a href="../WPages/myVoucherPage" class="app-item-div">
			<img src="../img/wapApp/yhq.png" />
			<text>我的优惠券</text>
		</a>

		<a href="../WPages/collectPage" class="app-item-div">
			<img src="../img/wapApp/shced.png" />
			<text>我的收藏</text>
		</a>
		<a href="../WPages/myAddressPage" class="app-item-div">
			<img src="../img/wapApp/map.png" />
			<text>地址管理</text>
		</a>
		<a href="../WPages/voucherPage" class="app-item-div">
			<img src="../img/wapApp/zq.png" />
			<text>领券中心</text>
		</a>
		<a href="tel://18716510437;" class="app-item-div">
			<img src="../img/wapApp/kefu.png" />
			<text>联系我们</text>
		</a>
		<a href="../WPages/serviceListPage" class="app-item-div">
			<img src="../img/wapApp/fwzx.png" />
			<text>服务中心</text>
		</a>
		<a href="../WPages/aboutUsPage" class="app-item-div">
			<img src="../img/wapApp/aboutus.png" />
			<text>关于我们</text>
		</a>

		<div style="clear:both;"></div>
	</div>
</div>