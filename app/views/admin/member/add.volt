<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <!--[if lt IE 9]>
            <script type="text/javascript" src="lib/html5shiv.js"></script>
            <script type="text/javascript" src="lib/respond.min.js"></script>
        <![endif]-->

        {{ assets.outputCss() }}
        {{ assets.outputJs() }}

        <!--[if IE 6]>
            <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js"></script>
            <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
    </head>

    <body style="min-height:auto">
        <nav class="navb">
            <div class="breadcrumb">
                <i class="Hui-iconfont">&#xe67f;</i>首页
                <span class="c-gray en">&gt;</span>会员管理
                <span class="c-gray en">&gt;</span>
                <a href="javascript:void(0);" onclick="history.go(-1);">会员列表</a>
                <span class="c-gray en">&gt;</span>会员编辑
                <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新">
                    <i class="Hui-iconfont">&#xe68f;</i>
                </a>
            </div>
        </nav>

        <article class="page-container">
            <form class="layui-form" action="" enctype="multipart/form-data" method="post">
                {% if userId > 0 %}
                <div class="layui-form-item">
                    <label class="layui-form-label">用户昵称：</label>
                    <div class="layui-input-block">
                        <input type="text" class="input-text disabled" placeholder="用户昵称" value="{{userInfo['uname']}}" readonly="readonly">
                        <input type="hidden" name="user_id" value="{{userId}}">
                    </div>
                </div>
                {% else %}
                <div class="layui-form-item">
                    <label class="layui-form-label"><span class="c-red">*</span>用户名：</label>
                    <div class="layui-input-block">
                        <input type="text" class="input-text" placeholder="用户名" name="name" value="">
                    </div>
                </div>
                {% endif %}
                {% set source = userInfo['source'] | default('') %}
                {% if source == '' %}
                <div class="layui-form-item">
                    <label class="layui-form-label"><span class="c-red">*</span>密码：</label>
                    <div class="layui-input-block">
                        <input type="text" class="input-text" placeholder="输入密码" name="pwd" value="">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span class="c-red">*</span>确认密码：</label>
                    <div class="layui-input-block">
                        <input type="text" class="input-text" placeholder="再次输入密码" name="c_pwd" value="">
                    </div>
                </div>
                {% endif %}
                <div class="layui-form-item">
                    <label class="layui-form-label"><span class="c-red">*</span>手机号码：</label>
                    <div class="layui-input-block">
                        <input type="text" class="input-text" placeholder="手机号码" name="tel" value="{{userInfo['tel']|default('')}}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">电子邮箱：</label>
                    <div class="layui-input-block">
                        <input type="text" class="input-text" placeholder="电子邮箱" name="email" value="{{userInfo['email']|default('')}}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span class="c-red">*</span>会员所在店铺等级：</label>
                    <div class="layui-input-block">
                        <select name="shop_lv" lay-filter="shop_lv">
                            {% for lv in shopConf['lv_info'] %}
                            <option value="{{lv['lv']}}" {% if lv['lv'] == userInfo['user_lv'] %}selected="selected"{% endif %}>{{lv['name']}}</option>
                            {% endfor %}
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><span class="c-red">*</span>积分变动：</label>
                    <div class="layui-input-block">
                        <input type="text" class="input-text" placeholder="输入积分变动数量" name="jifen" value="{{userInfo['jifen']|default('0')}}">
                    </div>
                </div>
                <div class="layui-btn layui-btn-normal save_btn">保存</div>
            </form>
        </article>
    </body>
</html>