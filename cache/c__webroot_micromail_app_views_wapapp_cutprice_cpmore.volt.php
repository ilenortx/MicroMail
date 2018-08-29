<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>砍价专区</title>

		<?= $this->assets->outputCss() ?> <?= $this->assets->outputJs() ?>

	</head>
	<script type="text/javascript" charset="utf-8">
		mui.init();
	</script>

	<body>
		<div class="flitems-div">
			<!--<div class="fl-item flitem-on">发射点</div>-->
		</div>
		<div id="pullRefresh" class="mui-content mui-scroll-wrapper">
			<div class="mui-scroll">
				<div class="pro-items-div">
					<!--<a href="http://www.baidu.com" class="goods-item">
						<img src="../img/coustom/video-icon.jpg" />
						<text class="title">as啊手动阀和军事对抗还是觉得发贺卡收到和按时鉴定会</text>
						<div class="price">￥123.00</div>
					</a>-->
				</div>
			</div>
		</div>

		
	</body>

</html>
<script type="text/javascript">
	app.pullRefresh.up('#pullRefresh', loadPros);
	mui('body').on('tap','a',function(){
	    window.top.location.href = this.href;
	});
</script>