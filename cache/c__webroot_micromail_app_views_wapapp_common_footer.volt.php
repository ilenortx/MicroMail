<?php if ($isBasePage) { ?>
<nav class="mui-bar mui-bar-tab">
    <a class="mui-tab-item" href="../WPages/indexPage">
        <span class="mui-icon iconfont icon-shouye"></span>
        <span class="mui-tab-label">首页</span>
    </a>
    <a class="mui-tab-item" href="../WPages/cateGoryPage">
        <span class="mui-icon iconfont icon-fenlei"></span>
        <span class="mui-tab-label">分类</span>
    </a>
    <a class="mui-tab-item" href="../WPages/cartPage">
        <span class="mui-icon iconfont icon-gouwuche"></span>
        <span class="mui-tab-label">购物车</span>
    </a>
    <a class="mui-tab-item" href="../WPages/myPage">
        <span class="mui-icon mui-icon-person"></span>
        <span class="mui-tab-label">我的</span>
    </a>
</nav>
<script type="text/javascript">
    $('.mui-tab-item').each(function(){
        var href = $(this).attr("href").substring(3);
        if (location.href.indexOf(href) >= 0) {
            $(this).addClass('mui-active');
        };
    });

    mui('.mui-bar-tab').on('tap', 'a', function(e) {
        var targetTab = this.getAttribute('href');
        var uid = app.ls.get("uid") || 0;
        targetTab += ("?uid=" + uid);
        if(targetTab) {
            window.location.replace(targetTab);
        }
    });
</script>
<?php } else { ?>
<div id="popover" class="mui-popover">
    <ul class="mui-table-view">
        <li class="mui-table-view-cell"><a href="../WPages/indexPage"><i class="mui-icon iconfont icon-shouye"></i><em>首页</em></a></li>
        <li class="mui-table-view-cell"><a href="../WPages/searchPage"><i class="mui-icon mui-icon-search"></i><em>搜索</em></a></li>
        <li class="mui-table-view-cell"><a href="../WPages/cateGoryPage"><i class="mui-icon iconfont icon-fenlei"></i><em>分类</em></a></li>
        <li class="mui-table-view-cell"><a href="../WPages/cartPage"><i class="mui-icon iconfont icon-gouwuche"></i><em>购物车</em></a></li>
        <li class="mui-table-view-cell"><a href="../WPages/myPage"><i class="mui-icon mui-icon-person"></i><em>我的</em></a></li>
    </ul>
</div>
<?php } ?>