{% if (!isBasePage and !isWxMiniProgram) %}
<header class="mui-bar mui-bar-nav mui-bar-nav-bg">
    <a id="back-menu" class="mui-icon mui-icon-left-nav mui-pull-left"></a>
    <a href="#popover" id="openPopover" class="mui-icon mui-icon-more mui-pull-right mui-a-color"></a>
    <h1 class="mui-title">{{ title }}</h1>
</header>
<script>
	if (app.isMobile()) $('#back-menu').on('tap', function(){ mui.back(); return false; });
	if (!app.isMobile()) $('#back-menu').on('click', function(){ mui.back(); return false; });
</script>
{% endif %}