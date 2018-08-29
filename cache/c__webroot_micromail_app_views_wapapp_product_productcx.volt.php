<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>商品促销</title>

		<?= $this->assets->outputCss() ?> <?= $this->assets->outputJs() ?>

	</head>
	<script type="text/javascript" charset="utf-8">
		mui.init();
	</script>

	<body>
		<div class="mui-content ofauto">
			<img id="adimg" src="" />
			
			<div id="proList">
				<!--<img class="proImg1" src="../img/wapApp/yhqbg2.png" />
				
				
				<img class="proImg2" src="../img/wapApp/yhqbg2.png" />-->
			</div>
		</div>
	</body>

</html>
<script>
	/*初始化参数*/
	page.data.cxid = "<?= $cxid ?>";

</script>