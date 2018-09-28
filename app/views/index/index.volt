{{ assets.outputCss() }}
{{ assets.outputJs() }}
<select name="" id="test">
</select>
<div onclick="xxxx();">打印</div>
<script src="http://192.168.1.101:8000/CLodopfuncs.js"></script>
<script>
	print.init({ip:"{{ip}}"});
	print.driverSelectList($('#test')[0]);
	
	function xxxx(){
		print.print();

	}
</script>
