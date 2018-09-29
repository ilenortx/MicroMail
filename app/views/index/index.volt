{{ assets.outputCss() }}
{{ assets.outputJs() }}
<select name="" id="test">
</select>
<div onclick="xxxx();">打印</div>
<div id="content">
	dsafhjkhsdf<hr />asdfasjkdfhas <br />
	<text>sadfasdfasd</text>
	<h1>sdfasdfasd</h1>
</div>
<!-- <script src="//192.168.1.101:8000/CLodopfuncs.js"></script> -->
<!-- <script src="https://localhost:8443/CLodopfuncs.js"></script> -->
<script>
	print.init({printersId:$('#test')[0]});
	/* print.driverSelectList(); */
	
	function xxxx(){
		print.print($('#content').html(), function(TaskID,Value){ alert("打印结果:"+Value); });

	}
</script>
