<div class="mui-content">
	<div id="pagePay">
		<!-- 收货地址 -->
		<div class="adr-div">
			<!-- 选择地址 -->
			<div onclick="chooseAddress()" class="chooseAddress">
				<div class="df">请选择收货地址</div>
				<img class="x_right" src="../img/wapApp/x_right.png" />
			</div>
			<div onclick="chooseAddress()" class="address-info">
				<div class="address-info-left">
					<div class="uinfo">
						<text id="shr"></text>
						<text id="tel"></text>
					</div>
					<div id="addressXq" class="addinfo"></div>
				</div>

				<img class="x_right" src="../img/wapApp/x_right.png" />
			</div>
			<img style="width:100%;height:5px;:" src="../img/wapApp/adr_bottom.png" />
		</div>
		<div class="scroll-div">
			<div class="psyways">
				<div class="way">
					<div onclick="choosePayType(2)" class="mui-input-row mui-radio mui-left">
						<input class="payway-ipt" name="payway" type="radio">
						<label>货到付款</label>
					</div>
				</div>
				<div class="way">
					<div onclick="choosePayType(1)" class="mui-input-row mui-radio mui-left">
						<input class="payway-ipt" name="payway" type="radio" checked>
						<label>微信支付</label>
					</div>
				</div>
			</div>
			<div id="pros" style="background:#fff;">
				<!--<div class="shop_info">北京大帝都高级旗舰店</div>
				<div class="pro-item">
					<img class="cp_photo" src="../img/wapApp/yhqbg2.png" />
					<div class="df_1">
						<div class="ovh1">案件款到发货卡还是饥渴的和福建安徽四大皆空</div>
						<div style="height:17px;"></div>
						<div class="sljg">
							<text class="gm_ovh_1h">×1</text>
							<text class="gm_ovh_1h" style="color:red;">￥39.00</text>
						</div>
					</div>
				</div>

				<div class="bzview">
					<text>运费</text>
					<span style="display:flex;align-items:center;">
						<text style="color:red;">￥0</text>
						<img src="../img/wapApp/x_right.png" style="width:12px;height:15px;margin-left:10px;" />
					</span>

				</div>
				<div class="bzview">
					<text style="width:70px;">买家留言</text>
					<input class="mjbz" type="text" placeholder="请填写备注" />
				</div>-->
			</div>
		</div>

		<div class="pay_sub">
			<div class="zhifu-div">
				应共支付：<span class="zhifu">￥0.00</span>
			</div>
			<div onclick="createProductOrder()" class="wx_pay_submit">支付</div>
		</div>
	</div>

	<div id="pageAddress">
		<div class="adds-div"></div>

		<a href="../WPages/addressEditPage" class="add-new-add">添加新地址</a>
	</div>
</div>

<!-- 运费列表 -->
<div id="chooseYf" class="box mui-popover mui-popover-action mui-popover-bottom">
	<div id="shopFfList">
		<!--<div class="mui-input-row mui-radio">
				<label>radio</label>
				<input name="yfitem" type="radio">
			</div>-->
	</div>
</div>

<!-- 优惠券列表 -->
<div id="chooseVou" class="box mui-popover mui-popover-action mui-popover-bottom">
	<div id="shopVouList">
		<!--<div class="mui-input-row mui-radio">
				<label>radio</label>
				<input name="yfitem" type="radio">
			</div>-->
	</div>
</div>
</div>

<div id="notice">正在提交订单...</div>
<script>
	/*初始化参数*/
	page.data.orderInfo = '{{orderInfo}}';

	window.addEventListener('hashchange', function() {
		var hashLocation = location.hash;

		if(!hashLocation) {
			$('#pagePay').show();
			$('#pageAddress').hide();
		} else {
			$('#pagePay').hide();
			$('#pageAddress').show();
			location.href = "#pageAddress";
		}
	});
</script>