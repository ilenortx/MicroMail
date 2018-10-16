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
                            <li>欢迎回来！</li>
                            <li class="dropDown dropDown_hover">
                                <a href="#" class="dropDown_A">{{minfo['uname']}}
                                    <i class="Hui-iconfont">&#xe6d5;</i>
								</a>
                                <ul class="dropDown-menu menu radius box-shadow">
                                    <li>
                                        <a href="javascript:;" onClick="myselfinfo()">个人信息</a>
									</li>
                                    <li>
                                        <a href="javascript:;" onClick="resetPwd()">重置密码</a>
									</li>
                                    <li>
                                        <a href="#">切换账户</a>
									</li>
                                    <li>
                                        <a href="../Adminlogin/logout">退出</a>
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
            
            <!-- 个人信息 -->
            <div class="layui-row" id="auinfo" style="display:none;">
				<div class="layui-form" style="margin-top:20px;">
					<div class="layui-form-item">
					    <label class="layui-form-label">账号</label>
					    <div style="line-height:38px;">{{minfo['name']}}</div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">用户名</label>
					    <div class="layui-input-inline">
					    	<input type="text" name="uname" lay-verify="required" autocomplete="off" placeholder="用户名" value="{{minfo['uname']}}" class="layui-input uname">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">手机号</label>
					    <div class="layui-input-inline">
					    	<input type="text" name="phone" lay-verify="phone" autocomplete="off" placeholder="手机号" value="{{minfo['phone']}}" class="layui-input phone">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">邮箱</label>
					    <div class="layui-input-inline">
					    	<input type="text" name="email" lay-verify="email" autocomplete="off" placeholder="邮箱" value="{{minfo['email']}}" class="layui-input email">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">添加时间</label>
					    <div style="line-height:38px;">{{ minfo['addtime'] }}</div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">状态</label>
					    <div style="line-height:38px;">
					    	{% if minfo['status']=='S0' %}
					    	<span class="label label-default radius">已禁用</span>
					    	{% else %}
					    	<span class="label label-success radius">启用</span>
					    	{% endif %}
					    </div>
					</div>
				  	<div class="layui-input-block">
				      	<button class="layui-btn layui-btn-sm" onclick="subReAuinfo()">立即提交</button>
					</div>
				</div>
			</div>
            <!-- 重置密码 -->
            <div class="layui-row" id="resetPwd" style="display:none;">
				<div class="layui-form" style="margin-top:20px;">
					<div class="layui-form-item">
					    <label class="layui-form-label">旧密码</label>
					    <div class="layui-input-inline">
					    	<input type="password" name="opwd" lay-verify="required" autocomplete="off" placeholder="旧密码" class="layui-input opwd">
					    </div>
					</div>
					<div class="layui-form-item">
					    <label class="layui-form-label">新密码</label>
					    <div class="layui-input-inline">
					    	<input type="password" name="pwd" lay-verify="required" autocomplete="off" placeholder="新密码" class="layui-input pwd">
					    </div>
					</div>
				  	<div class="layui-form-item">
				    	<label class="layui-form-label">确认密码</label>
				    	<div class="layui-input-inline">
				      		<input type="password" name="repwd" lay-verify="required" placeholder="确认密码" autocomplete="off" class="layui-input repwd">
				    	</div>
				  	</div>
				  	<div class="layui-input-block">
				      	<button class="layui-btn layui-btn-sm" onclick="subResetPwd()">立即提交</button>
					</div>
				</div>
			</div>
        </header>

        <aside class="Hui-aside">
            <div class="menu_dropdown bk_2">
            	{% for app in apps %}
                <dl>
                    <dt>
                        <i class="Hui-iconfont">{{app['icon']}}</i>&nbsp;{{app['name']}}
                        <i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
					</dt>
                    <dd>
                        <ul>
                        	{% for c in app['child'] %}
                            <li>
                            	
                                <a data-href="{{c['path']}}" data-title="{{c['name']}}" href="javascript:void(0)">
                                	<!-- <i class="Hui-iconfont">{{c['icon']}}</i>&nbsp; -->{{c['name']}}
                                </a>
							</li>
							{% endfor %}
                        </ul>
                    </dd>
                </dl>
                {% endfor %}
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
			layui.use(['form'], function(){
				var form = layui.form;
			});
			/*个人信息*/
			function myselfinfo() {
				openEdit('个人信息', $('#auinfo').html(), 500, 450, 1);
			}
			function subReAuinfo(){
				var uname = $('.uname').eq(1).val();
				var phone = $('.phone').eq(1).val();
				var email = $('.email').eq(1).val();
				
				if (!uname){ 
					layer.msg('请正确填写!', function(){ });
				}else {
					$.post('../Admin/reAuinfo', {uname:uname, phone:phone, email:email}, function(data){
						var data = JSON.parse(data);
						
						if (data.status == 1){
							layer.msg('修改成功', { icon: 6, time: 1000 });
							setTimeout(function(){
								location.reload();
							}, 1000);
						}else layer.msg(data.msg, { icon: 5, time: 1000 });
					});
				}
			}
			/*重置密码*/
			function resetPwd(){
				openEdit('重置密码', $('#resetPwd').html(), 400, 300, 1);
			}
			function subResetPwd(){
				var opwd = $('.opwd').eq(1).val();
				var pwd = $('.pwd').eq(1).val();
				var repwd = $('.repwd').eq(1).val();
				
				if (!opwd || !pwd || !repwd){ 
					layer.msg('请正确填写!', function(){ });
				}else if (pwd != repwd){
					layer.msg('两次密码不一致!', function(){ });
				}else {
					$.post('../Admin/resetPwd', {opwd:opwd, pwd:pwd, repwd:repwd}, function(data){
						var data = JSON.parse(data);
						
						if (data.status == 1){
							layer.msg('修改该成功！需重新登陆。', { icon: 6, time: 3000 });
							setTimeout(function(){
								window.location.href = "../Adminlogin/logout";
							}, 2000);
						}else layer.msg(data.msg, { icon: 5, time: 1000 });
					});
				}
			}
		</script>
	</body>
</html>

