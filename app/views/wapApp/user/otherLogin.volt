<div class="mui-content">
	{% if uid!=0 %}授权登陆成功！{% else %}授权登陆失败{% endif %}
</div>
<script>
	var uid = "{{uid}}";
	if (uid!='0'){
		app.ls.save("uid", uid);
		window.location.replace('..{{_url}}');
	}else {
		window.location.replace('../WPages/loginPage');
	}
</script>