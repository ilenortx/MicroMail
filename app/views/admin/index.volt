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
        
        {{ assets.outputCss('css1') }}
        <link rel="stylesheet" type="text/css" href="../css/static/h-ui.admin/skin/default/skin.css" id="skin">
        {{ assets.outputCss('css2') }}
        
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
                        <i class="Hui-iconfont">&#xe66a;</i>&nbsp;商城
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
					</dt>
                    <dd>
                        <ul>
                            {% if scType=='ST0' %}
                            <li>
                                <a data-href="../ShopManagement/index" data-title="店铺列表" href="javascript:void(0)">店铺列表</a>
                                <a data-href="../ShopManagement/shopShPage" data-title="审核列表" href="javascript:void(0)">审核列表</a>
                            	<a data-href="../Distribution/sqListPage" data-title="申请列表" href="javascript:void(0)">申请列表</a>
                                <a data-href="../Distribution/allfxsPage" data-title="分销商列表" href="javascript:void(0)">分销商列表</a>
                                <a data-href="../Distribution/withdrawDeposit" data-title="分销提现" href="javascript:void(0)">分销提现</a>
							</li>
							{% endif %}
                            <li>
                                <a data-href="../ShopManagement/shopInfoPage" data-title="店铺信息" href="javascript:void(0)">店铺信息</a>
								<a data-href="../ShopManagement/withdrawDeposit" data-title="提现管理" href="javascript:void(0)">提现管理</a>
							</li>
                        </ul>
                    </dd>
                </dl>
                <dl id="menu-product"><!-- 产品 -->
                    <dt>
                        <i class="Hui-iconfont">&#xe613;</i>&nbsp;产品
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
					</dt>
                    <dd>
                        <ul>
                            <li>
                                <a data-href="../Product/paPage" data-title="添加商品" href="javascript:void(0)">添加商品</a>
                                <a data-href="../Product/plPage?isDown=0" data-title="在售商品管理" href="javascript:void(0)">在售商品管理</a>
                                <a data-href="../Product/plPage?isDown=1" data-title="待售商品管理" href="javascript:void(0)">待售商品管理</a>
							</li>
							{% if scType=='ST0' %}
							<li>
                                <a data-href="../Category/cgLPage" data-title="分类列表" href="javascript:;">分类列表</a>
                                <a data-href="../Category/cgAPage" data-title="新增分类" href="javascript:void(0)">新增分类</a>
                                <a data-href="../ProductAttr/proAttrPage" data-title="产品属性" href="javascript:void(0)">产品属性</a>

                                <a data-href="../ProductParm/allParmPage" data-title="参数类型" href="javascript:void(0);">参数类型</a>
							</li>
							{% endif %}
                            <li>
                                <a data-href="../Product/proCxPage" data-title="促销产品" href="javascript:void(0)">促销产品</a>
                                <a data-href="../Product/prosnPage" data-title="服务说明" href="javascript:void(0)">服务说明</a>
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
								<a data-href="../Brand/addBrandPage" data-title="添加品牌" href="javascript:void(0)">添加品牌</a>
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
								<a data-href="member-del.html" data-title="删除的会员" href="javascript:;">删除的会员</a>
								<a data-href="member-level.html" data-title="等级管理" href="javascript:;">等级管理</a>
							</li>
                            <li>
                                <a data-href="member-scoreoperation.html" data-title="积分管理" href="javascript:;">积分管理</a>
								<a data-href="member-record-browse.html" data-title="浏览记录" href="javascript:void(0)">浏览记录</a>
							</li>
                            <li>
                                <a data-href="member-record-download.html" data-title="下载记录" href="javascript:void(0)">下载记录</a>
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
                        <i class="Hui-iconfont">&#xe61a;</i>&nbsp;订单
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
                    <dd>
                        <ul>
                            <li>
                                <a data-href="../Order/index" data-title="订单管理" href="javascript:void(0)">订单管理</a>
							</li>
                        </ul>
                    </dd>
                </dl>
                
                <dl id="menu-marketing"><!-- 营销 -->
                    <dt>
                        <i class="Hui-iconfont">&#xe6bb;</i>&nbsp;营销
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
					</dt>
                    <dd>
                        <ul>
                            <li>
                                <a data-href="../Aaconf/index" data-title="活动专区配置" href="javascript:void(0)">活动专区配置</a>
								<a data-href="../ShopPageConf/hotselltjPage" data-title="首页热卖推荐配置" href="javascript:void(0)">首页热卖推荐配置</a>
								<a data-href="../Promotion/index" data-title="限时促销" href="javascript:void(0)">限时促销</a>
								<a data-href="../GroupBooking/index" data-title="多人团购" href="javascript:void(0)">多人团购</a>
								<a data-href="../CutPriceSprites/index" data-title="砍价活动" href="javascript:void(0)">砍价活动</a>
								<a data-href="../Voucher/index" data-title="优惠券列表" href="javascript:void(0)">优惠券列表</a>
								<a data-href="../Voucher/addPage" data-title="添加优惠券" href="javascript:void(0)">添加优惠券</a>
							</li>
							
							{% if scType=='ST0' %}
							<li><!-- 疑难问题 -->
                                <a data-href="../ServiceCenter/index" data-title="疑难问题" href="javascript:void(0)">疑难问题</a>
							</li>
							{% endif %}
                        </ul>
                    </dd>
                </dl>
                
                <dl id="menu-marketing"><!-- 我的配送 -->
                    <dt>
                        <i class="Hui-iconfont">&#xe669;</i>&nbsp;我的配送
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
					</dt>
                    <dd>
                        <ul>
                            <li>
                                <a data-href="../AMyDelivery/wlmanagePage" data-title="物流管理" href="javascript:void(0)">物流管理</a>
								<a data-href="../AMyDelivery/wlgsListPage" data-title="物流公司" href="javascript:void(0)">物流公司</a>
								<a data-href="../AMyDelivery/shipAddressPage" data-title="发货地址" href="javascript:void(0)">发货地址</a>
							</li>
                        </ul>
                    </dd>
                </dl>
                
                {% if scType=='ST0' %}
                <dl id="menu-ad"><!-- 广告 -->
                    <dt>
                        <i class="Hui-iconfont">&#xe61a;</i>&nbsp;广告管理
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
					</dt>
                    <dd>
                        <ul>
                            <li>
                                <a data-href="../Guanggao/index" data-title="广告列表" href="javascript:void(0)">广告列表</a>
								<a data-href="../Guanggao/addPage" data-title="添加广告" href="javascript:void(0)">添加广告</a>
								<a data-href="../Guanggao/noticePage" data-title="公告列表" href="javascript:void(0)">公告列表</a>
								<a data-href="../Guanggao/addNoticePage" data-title="添加公告" href="javascript:void(0)">添加公告</a>
								<a data-href="../Guanggao/noticeConfigPage" data-title="公告设置" href="javascript:void(0)">公告设置</a>
							</li>
                        </ul>
                    </dd>
                </dl>
            	{% endif %}
            	<dl id="menu-ad"><!-- 任务管理 -->
                    <dt>
                        <i class="Hui-iconfont">&#xe637;</i>&nbsp;任务管理
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
					</dt>
                    <dd>
                        <ul>
                            <li>
                                <a data-href="../ATaskQueue/index" data-title="任务列表" href="javascript:void(0)">任务列表</a>
                                <a data-href="../ATaskQueue/tqRecycleBin" data-title="任务回收站" href="javascript:void(0)">任务回收站</a>
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
        
        
        {{ assets.outputJs('js') }}
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

