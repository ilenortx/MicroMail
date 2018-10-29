<div class="mui-content mb-40 ofauto">
	<div class="head-status">
		<div class="head-left">
			<text id="ord-statu">等待卖家付款 </text>
		</div>
		<div class="head-right"></div>
	</div>

	<div class="address-info">
		<div class="uinfo">
			<text id="shr">叶</text>
			<text id="tel">12345678909</text>
		</div>

		<div id="addressXq" class="addinfo">广东省广州市番禺区市桥街道</div>
	</div>

	<div class="pro-div">
		<div class="pros">
			<!--<div class="pro-info">
				<img src="../img/wapApp/yhqbg2.png" />
				<div class="pi-right">
					<div class="title">啊JFK拉军事打击大家分厘卡机圣诞快乐房价卡塑料袋放进篮筐世界的风口浪尖ask的力量凯撒舰队防空拦截啊圣诞快乐</div>
					<div class="attrs">颜色：红色</div>
					<div class="jgsl">
						<text>数量：×2</text>
						<text>单价：￥132</text>
					</div>
				</div>
			</div>-->
		</div>
		<div id="istk" style="border-top:1px solid #eee;display:none;align-items:center;height:40px;justify-content:flex-end;">
			<div style="display:inline-block;float:right;">
				<div class="sqtk">退款</div>
			</div>
		</div>
	</div>

	<div class="order-info-view">
		<div class="info-div">
			<text class="info-left">商品价格</text>
			<text id="proTotalPrice" class="info-right">￥88</text>
		</div>
		<div class="info-div">
			<text class="info-left">运费(快递)</text>
			<text id="yf" class="info-right">￥0</text>
		</div>
		<div id="vou" class="info-div" style="display:none;">
			<text class="info-left">优惠券</text>
			<text id="vouInfo" class="info-right">￥0</text>
		</div>
	</div>

	<div class="pay-money-div">
		<div class="info-div">
			<div id="payTotal" class="pay-right">￥88</div>
			<div class="jt"></div>
			<div class="pay-left">需付款</div>
		</div>
	</div>

	<div class='oi-div'>
		<div class='oi-item-div'>订单编码：<text id="orderId"></text></div>
		<div class='oi-item-div'>结算时间：<text id="orderSn"></text></div>
	</div>
</div>

<div class="bottom-div">
	<div id="qxdd" class="btn1" style="display:none;" onclick="cancelOrder()">取消订单</div>
	<div id="fk" class="btn2" style="display:none;" onclick="payOrder()">付款</div>
	<div id="qrsh" class="btn2" style="display:none;" onclick="recOrder()">确认收货</div>
</div>
<script type="text/javascript">
	page.data.orderId = "{{orderId}}";
</script>