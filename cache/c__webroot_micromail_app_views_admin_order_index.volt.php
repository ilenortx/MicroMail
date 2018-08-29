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
<nav class="navb"><div class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 订单管理 <span class="c-gray en">&gt;</span> 全部订单 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></div></nav>
<div class="page-container">
    <!--<div>-->
        <!--<div class="aaa_pts_4"><a href="{:U('order_count')}?shop_id={$shop_id}" class="btn btn-success">销售统计</a></div>-->

    <!--</div>-->
    <!--<br>-->
    <!--<div style="border-bottom:1px solid #333;"></div>-->
    <!--<br>-->
    <!-- <form name='form' action="{:U('index')}" method='get'>
        <div class="pro_4 bord_1">
            <div class="pro_5">
                支付类型：
                <select class="inp_1 inp_6" name="pay_type" id="type">
                    <option value="">全部类型</option>
                    <option value="weixin" <?php echo $pay_type=='weixin' ? 'selected="selected"' : NULL ?>>微信支付</option>
                    <option value="cash" <?php echo $pay_type=='cash' ? 'selected="selected"' : NULL ?>>现金支付</option>
                </select>
            </div>

            <div class="pro_5">
                订单状态：
                <select class="inp_1 inp_6" name="pay_status" id="status">
                    <option value="">全部状态</option>
                    <?php foreach ($order_status as $key => $val) { ?>
                    <option value="<?php echo $key; ?>" <?php if ($pay_status==$key) { ?>selected="selected"<?php } ?> ><?php echo $val; ?></option>
                    <?php } ?>
                    <option value="1" <?php if ($pay_status==1) { ?>selected="selected"<?php } ?> >退款中</option>
                    <option value="2" <?php if ($pay_status==2) { ?>selected="selected"<?php } ?> >已退款</option>
                </select>
            </div>

            <div class="pro_5">
                购买时间：
                <input class="inp_1 inp_6" id="start_time" name="start_time" value="<?php echo $start_time ?>" onfocus="MyCalendar.SetDate(this)">
                <input class="inp_1 inp_6" id="end_time" name="end_time" value="<?php echo $end_time ?>" onfocus="MyCalendar.SetDate(this)">
                <input class="btn btn-success" type="button"  value="搜 索" style="margin-left: 20px;" onclick="product_option();">
            </div>
            <div class="pro_6">


            </div>
        </div>
    </form>
    <br>
-->
    
    
    <table id="orderList" class="table table-border table-bordered table-bg">
        <thead>
	        <tr class="text-c">
	            <th width="40">订单ID</th>
	            <th width="100">买家</th>
	            <th width="130">订单号</th>
	            <th width="60">总金额(提成前)</th>
	            <th width="60">分销商提成</th>
	            <th width="60">总金额(提成后)</th>
	            <th width="40">支付类型</th>
	            <th width="40">订单状态</th>
	            <th width="100">订单时间</th>
	            <th width="100">备注</th>
	            <th width="60">操作</th>
	        </tr>
        </thead>

        <?php foreach ($orderlist as $list) { ?>
            <tr data-id="<?= $list['id'] ?>" data-name="<?= $list['name'] ?>" class="text-c">
                <td><?= $list['id'] ?></td>
                <td><?= $list['name'] ?></td>
                <td><?= $list['order'] ?></td>
                <td><?= $list['price_h'] ?></td>
                <td><?= $list['fxtc'] ?></td>
                <td><?= $list['price_h'] - $list['fxtc'] ?></td>
                <td><?php if ($list['type'] == 'alipay') { ?>支付宝<?php } elseif ($list['type'] == 'weixin') { ?>微信支付<?php } else { ?>货到付款<?php } ?></td>
                <td class="status">
                    <?php if ($list['back'] == 1) { ?>
                    	<font style="color:red">申请退款</font>
                    <?php } elseif ($list['back'] == 2) { ?>
                    	<font style="color:#900">已退款</font>
                    <?php } else { ?>
                        <font class='font_color'><?= $order_status[$list['status']] ?></font>
                    <?php } ?>
                </td>
                <td><?= $list['addtime'] ?></td>
                <td><?= $list['note'] ?></td>
                <td>
                    <a href="../Order/showPage?oid=<?= $list['id'] ?>">查看</a>
                    <!--  | <a onclick="del_id_url(<?= $list['id'] ?>)">删除</a> -->
                    <?php if ($list['back'] == 1) { ?> | <a href="{:U('back')}?oid=<?= $list['id'] ?>">确认退款</a><?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<!--_footer 作为公共模版分离出去-->
<?= $this->assets->outputJs('js1') ?>
<!--/_footer 作为公共模版分离出去-->
<!--请在下方写此页面业务相关的脚本-->
<?= $this->assets->outputJs('js2') ?>
<script>
	$('#orderList').DataTable({
	    bSort: true,      /*是否排序*/
	    bPaginate: true,  /*是否分页*/
	    bFilter: true,    /*是否查询*/
	    bInfo: true,      /*是否显示基本信息*/ 
	    iDisplayLength: 25,
	    "order": [[ 0, 'desc' ]]
	});
    /*搜索按钮点击事件*/
    function product_option(){
        $('form').submit();
    }

    function openDialog(){
        location="{:U('Inout/expOrder')}";
    }

    function openDialog2(){
        var shop_id = $('#shop_id').val();
        var type = $('#type').val();
        var status = $('#status').val();
        var start_time = $('#start_time').val();
        var end_time = $('#end_time').val();
        location="{:U('Inout/expOrder')}?shop_id="+shop_id+"&type="+type+"&status="+status+"&start_time="+start_time+'&end_time='+end_time;
    }

    /*订单状态字体颜色设置*/
    $('.font_color').each(function(index, element) {
        var obj = $(this);
        switch(obj.html()){
            case '待发货':
            case '交易完成':
            case '待收货':
                obj.css('color','#090');
                break;
            case '交易关闭':
            case '已退款':
                obj.css('color','#900');
                break;
            case '申请退款':
                obj.css('color','#f00');
            default:
                obj.css('color','#063559');
                break;
        }
    });

    /*选择商家按钮事件*/
    function win_open(url,width,height){

        height==null ? height=600 : height;
        width==null ?  width=800 : width;
        var myDate=new Date();
        window.open(url,'newwindow'+myDate.getSeconds(),'height='+height+',width='+width);
    }

    /*订单删除方法*/
    function del_id_url(id){
        if(confirm("确认删除吗？"))
        {
            location='{:U("del")}?did='+id;
        }
    }
</script>

</body>
</html>