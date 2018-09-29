<div class="mui-content">
	<div class="info-div">
		<div class="left">姓名</div>
		<input id="name" class="input" value="{{ainfo['name']}}" type="text" placeholder="姓名(必填)" />
	</div>
	<div class="info-div">
		<div class="left">省/市/区</div>
		<input id="ssq" class="input" value="{{ainfo['address']}}" type="text" placeholder="------" data-key="1-36-37" readonly />
	</div>
	<div class="info-div">
		<div class="left">详细地址</div>
		<input id="xxdz" class="input" type="text" value="{{ainfo['address_xq']}}" placeholder="详细地址(必填)" />
	</div>
	<div class="info-div">
		<div class="left">手机</div>
		<input id="tel" class="input" type="number" value="{{ainfo['tel']}}" placeholder="手机(必填)" />
	</div>

	<input id="id" value="{{ainfo['id']}}" type="hidden" />
	<div onclick="formSubmit()" class="add-new-add">保存</div>
</div>

<script>
	
</script>