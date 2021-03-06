<div class="mui-content ofauto">
	<ul class="myGb-tabs">
		<li class="myGb-tab current" data-tag="1">组团</li>
		<li class="myGb-tab" data-tag="2">参团</li>
	</ul>
	<div class="myGb-gbList">
	</div>
</div>
<script type="text/template" id="gbList-template">
	<% if (list.length > 0){ %>
	<% for(var k in list){ %>
	<% var item = list[k] %>
	<a href="<% if(type=='1'){ %>../WPages/gbBuildPage?orderId=<%=item.orderId %><% }else if(type=='2'){ %>../WPages/gbJoinPage?gblid=<%=item.gblid %><% } %>" class="pro-item <%=getStateText(item.gblstatus,'class') %>">
		<img class="cp_photo" src="<%=imgSrc %><%=item.prophoto %>">
		<div class="df_1">
			<div class="ovh1">
				<%=item.proname %>
			</div>
			<div style="height:17px;"></div>
			<div class="sljg">
				<div class="gm_ovh_1h">
					<text class="myGb-product-buyCount"><em><%=item.gbmans %></em>人团</text>
					<text class="myGb-product-buyPrice" style="color:red;">¥<%=item.gbprice %></text>
				</div>
				<text class="gm_ovh_1h" style="color:red;"><%=getStateText(item.gblstatus,'text') %></text>
			</div>
		</div>
	</a>
	<% } %>
	<% }else{ %>
	<div class="noData-text"><i class="noSearch-icon"></i>没有组团记录/(ㄒoㄒ)/~~</div>
	<% } %>
</script>
<script>
	template.helper('getStateText', function(state, type) {
		var text, class_name;
		switch(state) {
			case 'S1':
				text = "未付款";
				class_name = "";
				break;
			case 'S2':
				text = "拼团中";
				class_name = "";
				break;
			case 'S3':
				text = "活动结束";
				class_name = "gbFail-bg";
				break;
			case 'S4':
				text = "拼团失败";
				class_name = "gbFail-bg";
				break;
			case 'S5':
				text = "拼团成功";
				class_name = "gbSuccess-bg";
				break;
		};
		if(type=='text') return text;
		else if(type=='class') return class_name;
	});
</script>