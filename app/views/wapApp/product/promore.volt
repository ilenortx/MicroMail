<div class="px-top-div">
	<ul class="px-ul">
		<li px="0" onclick="pxquery(this);" class="on">综合</li>
		<li px="1" onclick="pxquery(this);">最新</li>
		<li px="3" onclick="pxquery(this);" class="price">价格<img id="jg-px" src="../img/wapApp/sort1.png" /></li>
		<li px="4" onclick="pxquery(this);">销量</li>
	</ul>
</div>
<div id="pullRefresh" class="mui-content mui-scroll-wrapper">
	<div class="mui-scroll">
		<div class="pro-list-div"></div>
	</div>
</div>
<script>
	page.data.cid = "{{cid}}";
	
	app.pullRefresh.up('#pullRefresh', loadMore);
	mui('body').on('tap', 'a', function() {
		window.top.location.href = this.href;
	});
</script>