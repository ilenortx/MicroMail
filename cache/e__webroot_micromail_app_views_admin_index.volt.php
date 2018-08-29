<!DOCTYPE HTML>
<html>
    <head>
		<meta charset="utf-8">
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link rel="Bookmark" href="/favicon.ico">
        <link rel="Shortcut Icon" href="/favicon.ico" />
        <!--[if lt IE 9]>
            <script type="text/javascript" src="lib/html5shiv.js"></script>
            <script type="text/javascript" src="lib/respond.min.js"></script>
        <![endif]-->
        
        <?= $this->assets->outputCss('css1') ?>
        <link rel="stylesheet" type="text/css" href="../css/static/h-ui.admin/skin/default/skin.css" id="skin">
        <?= $this->assets->outputCss('css2') ?>
        
        <!--[if IE 6]>
            <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js"></script>
            <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
        <title>微商城后台管理系统</title>
	</head>
    
    <body>
        <header class="navbar-wrapper">
            <div class="navbar navbar-fixed-top">
                <div class="container-fluid cl">
                    <a class="logo navbar-logo f-l mr-10 hidden-xs" href="#">微商城后台管理系统</a>
                    <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
                    <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                        <ul class="cl">
                            <li>超级管理员</li>
                            <li class="dropDown dropDown_hover">
                                <a href="#" class="dropDown_A">admin
                                    <i class="Hui-iconfont">&#xe6d5;</i>
								</a>
                                <ul class="dropDown-menu menu radius box-shadow">
                                    <li>
                                        <a href="javascript:;" onClick="myselfinfo()">个人信息</a>
									</li>
                                    <li>
                                        <a href="#">切换账户</a>
									</li>
                                    <li>
                                        <a href="../AdminLogin/logout">退出</a>
									</li>
                                </ul>
                            </li>
                            <!-- <li id="Hui-msg">
                                <a href="#" title="消息">
                                    <span class="badge badge-danger">1</span>
                                    <i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i>
								</a>
                            </li> -->
                            <li id="Hui-skin" class="dropDown right dropDown_hover">
                                <a href="javascript:;" class="dropDown_A" title="换肤">
                                    <i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i>
								</a>
                                <ul class="dropDown-menu menu radius box-shadow">
                                    <li>
                                        <a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a>
									</li>
                                    <li>
                                        <a href="javascript:;" data-val="blue" title="蓝色">蓝色</a>
									</li>
                                    <li>
                                        <a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
                                    <li>
                                        <a href="javascript:;" data-val="red" title="红色">红色</a>
									</li>
                                    <li>
                                        <a href="javascript:;" data-val="yellow" title="黄色">黄色</a>
									</li>
                                    <li>
                                        <a href="javascript:;" data-val="orange" title="橙色">橙色</a>
									</li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <aside class="Hui-aside">
            <div class="menu_dropdown bk_2">
                <dl id="menu-article"><!-- 综合 -->
                    <dt>
                        <i class="Hui-iconfont">&#xe616;</i>&nbsp;综合管理
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
					</dt>
                    <dd>
                        <ul>
                            <li>
                                <a data-href="article-list.html" data-title="资讯管理" href="javascript:void(0)">资讯管理</a>
							</li>
                        </ul>
                    </dd>
                </dl>
                <dl id="menu-product"><!-- 产品 -->
                    <dt>
                        <i class="Hui-iconfont">&#xe613;</i>&nbsp;产品管理
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
					</dt>
                    <dd>
                        <ul>
                            <li>
                                <a data-href="../Product/paPage" data-title="添加产品" href="javascript:void(0)">添加产品</a>
							</li>
                            <li>
                                <a data-href="../Product/plPage" data-title="产品管理" href="javascript:void(0)">产品管理</a>
							</li>
                        </ul>
                    </dd>
                </dl>
                <dl id="menu-product-brand"><!-- 品牌 -->
                    <dt>
                        <i class="Hui-iconfont">&#xe620;</i>&nbsp;品牌管理
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
					</dt>
                    <dd>
                        <ul>
                            <li>
                                <a data-href="../Brand/index" data-title="全部品牌" href="javascript:void(0)">全部品牌</a>
							</li>
                            <li>
                                <a data-href="../Brand/addBrandPage" data-title="添加品牌" href="javascript:void(0)">添加品牌</a>
							</li>
                        </ul>
                    </dd>
                </dl>
                <dl id="menu-category"><!-- 分类 -->
                    <dt>
                        <i class="Hui-iconfont">&#xe62e;</i>&nbsp;分类管理
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
					</dt>
                    <dd>
                        <ul>
                            <li>
                                <a data-href="../Category/cgLPage" data-title="分类列表" href="javascript:;">分类列表</a>
							</li>
                            <li>
                                <a data-href="../Category/cgAPage" data-title="新增分类" href="javascript:void(0)">新增分类</a>
							</li>
                        </ul>
                    </dd>
                </dl>
                <dl id="menu-member"><!-- 会员 -->
                    <dt>
                        <i class="Hui-iconfont">&#xe60d;</i>&nbsp;会员管理
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
					</dt>
                    <dd>
                        <ul>
                            <li>
                                <a data-href="member-list.html" data-title="会员列表" href="javascript:;">会员列表</a>
							</li>
                            <li>
                                <a data-href="member-del.html" data-title="删除的会员" href="javascript:;">删除的会员</a>
							</li>
                            <li>
                                <a data-href="member-level.html" data-title="等级管理" href="javascript:;">等级管理</a>
							</li>
                            <li>
                                <a data-href="member-scoreoperation.html" data-title="积分管理" href="javascript:;">积分管理</a>
							</li>
                            <li>
                                <a data-href="member-record-browse.html" data-title="浏览记录" href="javascript:void(0)">浏览记录</a>
							</li>
                            <li>
                                <a data-href="member-record-download.html" data-title="下载记录" href="javascript:void(0)">下载记录</a>
							</li>
                            <li>
                                <a data-href="member-record-share.html" data-title="分享记录" href="javascript:void(0)">分享记录</a>
							</li>
                        </ul>
                    </dd>
                </dl>
                <dl id="menu-admin"><!-- 管理员 -->
                    <dt>
                        <i class="Hui-iconfont">&#xe62d;</i>&nbsp;管理员管理
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
					</dt>
                    <dd>
                        <ul>
                            <li>
                                <a data-href="../AdminUsers/adminUserList" data-title="管理员列表" href="javascript:void(0)">管理员列表</a>
							</li>
                        </ul>
                    </dd>
                </dl>
                <dl id="menu-order"><!-- 订单 -->
                    <dt>
                        <i class="Hui-iconfont">&#xe61a;</i>&nbsp;订单管理
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
                    <dd>
                        <ul>
                            <li>
                                <a data-href="../Order/index" data-title="全部订单" href="javascript:void(0)">全部订单</a>
							</li>
                        </ul>
                    </dd>
                </dl>
                <dl id="menu-coupon"><!-- 优惠券 -->
                    <dt>
                        <i class="Hui-iconfont">&#xe61a;</i>&nbsp;优惠券管理
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
					</dt>
                    <dd>
                        <ul>
                            <li>
                                <a data-href="../Voucher/index" data-title="优惠券列表" href="javascript:void(0)">优惠券列表</a>
							</li>
                            <li>
                                <a data-href="../Voucher/addPage" data-title="添加优惠券" href="javascript:void(0)">添加优惠券</a>
							</li>
                        </ul>
                    </dd>
                </dl>
                <dl id="menu-ad"><!-- 广告 -->
                    <dt>
                        <i class="Hui-iconfont">&#xe61a;</i>&nbsp;广告管理
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
					</dt>
                    <dd>
                        <ul>
                            <li>
                                <a data-href="../Guanggao/index" data-title="广告列表" href="javascript:void(0)">广告列表</a>
							</li>
                            <li>
                                <a data-href="../Guanggao/addPage" data-title="添加广告" href="javascript:void(0)">添加广告</a>
							</li>
                        </ul>
                    </dd>
                </dl>
            </div>
        </aside>

        <div class="dislpayArrow hidden-xs">
            <a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a>
        </div>

        <section class="Hui-article-box">
            <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
                <div class="Hui-tabNav-wp">
                    <ul id="min_title_list" class="acrossTab cl">
                        <li class="active">
                            <span title="我的桌面" data-href="../Admin/loadHome">我的桌面</span>
                            <em></em>
                        </li>
                    </ul>
                </div>
                <div class="Hui-tabNav-more btn-group">
                    <a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;">
                        <i class="Hui-iconfont">&#xe6d4;</i>
					</a>
                    <a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;">
                        <i class="Hui-iconfont">&#xe6d7;</i>
					</a>
                </div>
            </div>
            <div id="iframe_box" class="Hui-article">
                <div class="show_iframe">
                    <div style="display:none" class="loading"></div>
                    <iframe scrolling="yes" frameborder="0" src="../Admin/loadHome"></iframe>
                </div>
            </div>
        </section>

        <div class="contextMenu" id="Huiadminmenu">
            <ul>
                <li id="closethis">关闭当前</li>
                <li id="closeall">关闭全部</li>
			</ul>
        </div>
        
        
        <?= $this->assets->outputJs('js') ?>
		<script>
			$(function() {
				
			});
			/*个人信息*/
			function myselfinfo() {
				layer.open({
					type: 1,
					area: ['300px', '200px'],
					fix: false,
					maxmin: true,
					shade: 0.4,
					title: '查看信息',
					content: '<div>管理员信息</div>'
				});
			}
		
			/*资讯-添加*/
			function article_add(title, url) {
				var index = layer.open({
					type: 2,
					title: title,
					content: url
				});
				layer.full(index);
			}
			/*图片-添加*/
			function picture_add(title, url) {
				var index = layer.open({
					type: 2,
					title: title,
					content: url
				});
				layer.full(index);
			}
			/*产品-添加*/
			function product_add(title, url) {
				var index = layer.open({
					type: 2,
					title: title,
					content: url
				});
				layer.full(index);
			}
			/*用户-添加*/
			function member_add(title, url, w, h) {
				layer_show(title, url, w, h);
			}
		</script>
	</body>
</html>

