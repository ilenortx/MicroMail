<div class="mui-content ofauto">
	<ul class="myCp-tabs">
		<li class="myCp-tab current" data-tag="T1">全部</li>
		<li class="myCp-tab" data-tag="T2">进行中</li>
		<li class="myCp-tab" data-tag="T3">已结束</li>
	</ul>
	<div class="myCp-CpList">
	</div>
</div>
<script type="text/template" id="cpList-template">
	<% if (list.length > 0){ %>
		<% for(var k in list){ %>
		<% var item = list[k] %>
		<a href="../WPages/cpDetailPage?dotype=detail&ucpId=<%=item.cpInfo.id %>&skuId=<%=item.cpInfo.skuid %>" class="pro-item">
			<img class="cp_photo" src="<%=imgSrc %><%=item.proInfo.photo_x %>">
			<div class="df_1">
				<div class="ovh1">
					<%=item.proInfo.name %>
				</div>
				<div class="cutPrice-percent">
					<em class="cutPrice-percent-surplus" style="width:<%=item.cpInfo.progress %>%;"></em>
				</div>
				<p class="cutPrice-percent-info">已砍价至<em>¥<%=item.cpInfo.now_price %></em></p>
				<div class="sljg">
					<div class="gm_ovh_1h">
						<text>底价:<em>¥<%=item.cpInfo.low_price %></em></text>
					</div>
				</div>
			</div>
		</a>
		<% } %>
	<% }else{ %>
		<div class="noData-text"><i class="noSearch-icon"></i>没有砍价记录/(ㄒoㄒ)/~~</div>
	<% } %>
</script>