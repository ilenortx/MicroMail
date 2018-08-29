<div style="position:fixed;z-index:100;width:100%;top:44px;">
	<!-- 搜索 -->
	<div class="search-div">
		<a href="../WPages/searchPage" class="search">
			<img src="../img/wapApp/search.png" />搜索
		</a>
		<img type='1' class="showType" src="../img/wapApp/dllist.png" />
	</div>

	<!-- 排序 -->
	<div class="px-top-div">
		<ul class="px-ul">
			<li px="0" onclick="pxquery(this);" class="on">综合</li>
			<li px="1" onclick="pxquery(this);">最新</li>
			<li px="3" onclick="pxquery(this);" class="price">价格<img id="jg-px" src="../img/wapApp/sort1.png" /></li>
			<li px="4" onclick="pxquery(this);">销量</li>
		</ul>
	</div>
</div>

<div id="pullRefresh" class="mui-content  mui-scroll-wrapper">
	<div class="mui-scroll">
		<div class="pro-list-div">
			<!--<a class="pro-item1">
				<img src="../img/wapApp/yhqbg2.png" />
				<div class="pi-right">
					<div class="proname">dfasdfa啊科技时代发贺卡函数的积分哈吉快点回家ask就发哈数啊手动阀贺卡收到复活节卡号是打开就哈桑大家复活节卡是据库的和</div>
					<div style="display:flex;align-content:center;font-size:14px;justify-content:space-between;color:#000;">
						<text>新品</text>
						<text>库存：78</text>
					</div>
					<div style="display:flex;align-content:center;font-size:14px;margin-top:5px;">
						<text style="color:red;min-width:80px;">￥ 123</text>
						<text style="text-align:left;min-width:80px;margin-right:10rpx;text-decoration:line-through;color:#999;">￥878</text>
					</div>
				</div>
			</a>-->

			<!--<a href="http://www.baidu.com" class="goods-item">
				<img src="../img/coustom/video-icon.jpg" />
				<text class="title">as啊手动阀和军事对抗还是觉得发贺卡收到和按时鉴定会</text>
				<div class="price">￥123.00</div>
			</a>-->
		</div>
	</div>
</div>
<script type="text/javascript">
	page.data.cgid = "{{cgid}}";
	app.pullRefresh.up('#pullRefresh', loadPros);
	mui('body').on('tap', 'a', function() {
		window.top.location.href = this.href;
	});
</script>