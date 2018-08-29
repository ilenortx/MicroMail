<div class="mui-content">
	<?php if ($uid != 0) { ?>授权登陆成功！<?php } else { ?>授权登陆失败<?php } ?>
</div>
<script>
	var uid = "<?= $uid ?>";
	if (uid!='0'){
		app.ls.save("uid", uid);
		window.location.replace('..<?= $_url ?>');
	}else {
		window.location.replace('../WPages/loginPage');
	}
</script>