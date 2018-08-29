<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="__PUBLIC__/admin/lib/html5shiv.js"></script>
    <script type="text/javascript" src="__PUBLIC__/admin/lib/respond.min.js"></script>
    <![endif]-->

    <?= $this->assets->outputCss('css1') ?>
    <link rel="stylesheet" type="text/css" href="../css/static/h-ui.admin/skin/default/skin.css" id="skin">
    <?= $this->assets->outputCss('css2') ?>

    <!--[if IE 6]>
    <script type="text/javascript" src="__PUBLIC__/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->

    <title>全部订单</title>
</head>

<body style="min-height:auto">
    <nav class="navb"><div class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 订单管理 <span class="c-gray en">&gt;</span> <a href="../Order/index">全部订单</a> <span class="c-gray en">&gt;</span> 订单详情 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a></div></nav>
    <div class="page-container">
        <table class="table table-border table-bordered table-bg">
            <thead>
                <tr class="text-c">
                    <th width="150">产品名称</th>
                    <th width="40">产品价格</th>
                    <th width="40">数量</th>
                    <th width="40">总价</th>
                    <th width="60">产品属性</th>
                </tr>
            </thead>

            <?php foreach ($prolist as $list) { ?>
            <tr id="concent_tr_<?= $list['id'] ?>" class="text-c">
                <td><?= $list['name'] ?></td>
                <td>￥ <?= $list['price'] ?></td>
                <td><?= $list['num'] ?></td>
                <td><font style="color:#c00;">￥ <?= $list['price'] * $list['num'] ?></font>
                </td>
                <td><?= $list['attrs'] ?></td>
            </tr>
            <?php } ?>
        </table>

        <br>

        <div style="border-bottom:1px solid #b9c9d6;">
            <ul style="margin-top:15px;  padding-bottom:5px; width:500px; float:left;">
                <li style="font-size:15px; color:#000;">收货地址信息：</li>
                <li style="padding-top:5px;">
                    <div>收货人：<?= $orderInfo['address']['name'] ?></div>
                    <div>联系电话：<?= $orderInfo['tel'] ?></div>
                    <div>邮政编码：<?= $orderInfo['code'] ?></div>
                    <div>收货地址：<?= $orderInfo['address_xq'] ?></div>
                </li>
            </ul>
            <ul style="margin-top:15px; padding-bottom:5px; width:300px; float:left;">
                <li style="font-size:15px; color:#000;">买家留言：</li>
                <li style="padding:5px 0 0 0; padding-top:5px; color:#090; font-size:14px;">
                    <?php if ($orderInfo['remark']) { ?> <?= $orderInfo['remark'] ?> <?php } else { ?> &nbsp; <?php } ?>
                </li>
                <li style="font-size:15px; color:#000;">邮费信息：</li>
                <li style="padding:5px 0 0 0; color:#090; font-size:14px;">
				<?php if ($postInfo) { ?>
					<?= $postInfo['name'] ?> ￥ <?= $postInfo['price'] ?> <br />
 					<?= $orderInfo['remark'] ?>
				<?php } else { ?>
					卖家包邮
				<?php } ?>
                </li>
            </ul>
            <ul style="margin-top:15px; padding-bottom:5px; width:300px; float:left;">
                <li style="font-size:15px; color:#000;">物流信息：</li>
                <li>暂无</li>
            </ul>
        </div>

        <div>
            <div class="ord_show_5">

                <br>
                <div style="color:#c00; line-height:20px;font-size: 14px">发送待收货短信通知，要求订单状态必须为“待收货”,表示卖家已经发货。</div>
				发货快递：
                <input id="kuaidi_name" value="<?= $orderInfo['kuaidi_name'] ?>" />
                <br>
				快递单号：
                <input id="kuaidi_num" value="<?= $orderInfo['kuaidi_num'] ?>" />

                <br>
				状态修改：
                <select id="zt_order_update">
                    <option value="">全部状态</option>
                    <?php foreach ($order_status as $key=>$val) { ?>
                    <option value="<?= $key ?>" <?php if ($orderInfo['status'] == $key) { ?> selected="selected" <?php } ?>>- <?= $val ?></option>
                    <?php } ?>
                </select>
                <br>
                <font>订单价格(提成前):</font> ￥ <?= $orderInfo['price_h'] ?><br>
				<font>分销商提成:</font> ￥ <?= $orderInfo['fxtc'] ?><br>
				<font>订单价格(提成后):</font> ￥ <?= $orderInfo['price_h'] - $orderInfo['fxtc'] ?>
                <br><br>
				备注：<textarea id="note" name="note" style="resize:none;width:80%;height:100px;"><?= $orderInfo['note'] ?></textarea>
                <br><br>
                <input type="button" value="提交" style="" onclick="sms_message()" class="btn btn-success" />
                <br>
                <input type="hidden" value="<?= $orderInfo['status'] ?>" name="o_status" id="o_status">
            </div>
        </div>



        <?php if ($orderInfo['back'] > 0) { ?>
        <div class="ord_show_1">
            <div class="ord_show_6" style="float:left;margin-top:10px">
                退款原因：<span style="color:#c00;"><?= $orderInfo['back_remark'] ?></span>
            </div>
        </div>
        <?php } ?>


    </div>
    <!--_footer 作为公共模版分离出去-->
    <?= $this->assets->outputJs('js1') ?>
    <!--/_footer 作为公共模版分离出去-->
    <!--请在下方写此页面业务相关的脚本-->
    <?= $this->assets->outputJs('js2') ?>
    <script>
        $('#orderList').DataTable({
            bSort: true,
            /*是否排序*/
            bPaginate: true,
            /*是否分页*/
            bFilter: true,
            /*是否查询*/
            bInfo: true,
            /*是否显示基本信息*/
            iDisplayLength: 25,
        });
        
        /*订单状态字体颜色设置*/
        $('.font_color').each(function (index, element) {
            var obj = $(this);
            switch (obj.html()) {
            case '待发货':
            case '交易完成':
            case '待收货':
                obj.css('color', '#090');
                break;
            case '交易关闭':
            case '已退款':
                obj.css('color', '#900');
                break;
            case '申请退款':
                obj.css('color', '#f00');
            default:
                obj.css('color', '#063559');
                break;
            }
        });

        function sms_message(){
        	/*if(!confirm('确定发送订单发货短信吗？')) return;*/
            var o_status = $('#o_status').val();
            var order_status = $('#zt_order_update').val();
            /* 选择状态不能比当前状态小，已付款的订单不能变成未付款 */
            /* if (order_status && order_status!=40 && order_status<o_status) {return;}; */
            /* 获取快递名称 */
            var kuaidi_name = $('#kuaidi_name').val();
            if(kuaidi_name.length<1 && order_status==30) throw ('快递名称不能为空！');
            /* 获取快递单号 */
            var kuaidi_num = $('#kuaidi_num').val();
            if(kuaidi_num.length<1 && order_status==30) throw ('运单号不能为空！');

            if (!order_status && kuaidi_num.length<1 && kuaidi_name.length<1) {
                throw ('请输入快递信息或选择订单状态！');
            };

            $.post('../Order/saveOrder', {'order_status':order_status,'kuaidi_name':kuaidi_name,'kuaidi_num':kuaidi_num,'oid':<?= $orderInfo['id'] ?>, 'note':$('#note').val()}, function(data){
            	var data = jQuery.parseJSON(data);
            	if (data.status == 1){
            		layer.msg('操作成功!', { icon: 6,time: 1000 });
            		window.reload();
            	}else {
            		layer.msg(data.msg, { icon: 5,time: 1000 });
            	}
            });
        }
    </script>

</body>

</html>