<div class="mui-content">
	<ul class="mui-table-view">
	    <li class="mui-table-view-cell">订单编号：<span id="orderno"></li>
	    <li class="mui-table-view-cell">订单金额：<span id="payMoney"></span></li>
	</ul>
	
	<div class="payway">微信支付</div>
	
	<div class="gotoPay" onclick="gotoPay()">去付款</div>
</div>

<script>
	page.data.oid = "{{oid}}";
</script>