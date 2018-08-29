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
        
		<?= $this->assets->outputCss() ?>
        
        <!--[if IE 6]>
            <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js"></script>
            <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
        <title>后台登录</title>
    
    <body>
        <input type="hidden" id="TenantId" name="TenantId" value="" />
        <div class="loginWraper">
            <div id="loginform" class="loginBox">
                <form id="login_form" class="form form-horizontal" action="../AdminLogin/login" method="post">
                    <div class="row cl">
                        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                        <div class="formControls col-xs-8">
                            <input id="name" name="name" type="text" placeholder="用户名" class="input-text size-L">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-3">
                            <i class="Hui-iconfont">&#xe60e;</i></label>
                        <div class="formControls col-xs-8">
                            <input id="pwd" name="pwd" type="password" placeholder="密码" class="input-text size-L">
                        </div>
                    </div>
                    <!-- <div class="row cl">
                        <div class="formControls col-xs-8 col-xs-offset-3">
                            <input class="input-text size-L" type="text" placeholder="验证码" onblur="if(this.value==''){this.value='验证码:'}" onclick="if(this.value=='验证码:'){this.value='';}" value="验证码:" style="width:150px;">
                            <img src="">
                            <a id="kanbuq" href="javascript:;">看不清，换一张</a></div>
                    </div> -->
                    <div class="row cl">
                        <div class="formControls col-xs-8 col-xs-offset-3">
                            <label for="online">
                                <input type="checkbox" name="online" id="online" value="">使我保持登录状态
                            </label>
                        </div>
                    </div>
                    <div class="row cl">
                        <div class="formControls col-xs-8 col-xs-offset-3">
                            <input id="login_submit" name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
                            <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        
        <?= $this->assets->outputJs() ?>
        <script type="text/javascript">
	        $(function(){     
	            var options = { 
	                type: 'POST',  
	                url: '../adminLogin/login',
	                beforeSubmit: validateRegist, 
	                success: showResponse,    
	                dataType: 'json',  
	                error: function(xhr, status, err) { 
	                    alert("操作失败");  
	                }  
	            };   
	            $("#login_form").submit(function(){
	                $(this).ajaxSubmit(options);   
	                return false;
	            });  
	    	});  
	      	
		    function showResponse(responseText, statusText, xhr, $form){
		        if(responseText.status == "1"){
		        	window.location.href='../Admin/index'; 
		        } else {  
		            alert(responseText.msg);  
		        }     
		    }
		    /*登陆验证*/
		    function validateRegist(){
		    	if (!$('#name').val()) { alert('用户名不能为空!'); return false; }
		    	if (!$('#pwd').val()) { alert('密码不能为空!'); return false; }
		    	return true;
		    }
        </script>
	</body>
</html>