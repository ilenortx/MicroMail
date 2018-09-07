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
    
    {{ assets.outputCss() }}
    {{ assets.outputJs() }}

    <!--[if IE 6]>
    <script type="text/javascript" src="__PUBLIC__/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    
    <title></title>
</head>
<body style="min-height:auto">
	<form class="pei-form" enctype="multipart/form-data" method="post">
		<div class="daoru">文件：
		   <input type="text" class="ef_text" id="textfield" autocomplete="off" readonly  > 
		   <input id="cfBtn" type="button" class="cf_sub" value="浏览..." > 
		   <input id="efile" type="file"   class="e_file" name="efile" contenteditable="false"  onchange="document.getElementById('textfield').value=this.value" accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
		</div>
		<div class="file_type">
			格式：
			<span class="ft_select_box">
		  		<select class="f_type" name="eftype">
		    		<option value="1">.cvs</option>
		    		<option value="2">.xls</option>
		    		<option value="3">.xlsx</option>
		  		</select>
			</span>
		</div>
		
		<div class="sub_btn" onclick="subProExcel()">提交</div>
		
	</form>
<script>
	
</script>
</body>
</html>