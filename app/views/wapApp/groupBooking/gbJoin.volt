<div class="mui-content ofauto">
	<div class="template-content">
	</div>
	<div class="gbJoin-page-bg">
		<div class="gbJoin-text">
			<div class="gbJoin-text-title">
				<text>拼团怎么玩</text>
			</div>
			<div class="gbJoin-play">
				<div class="gbJoin-play-item">
					<i>1</i>选择商品
				</div>
				<div class="gbJoin-play-item">
					<i>2</i>支付开团/参团
				</div>
				<div class="gbJoin-play-item">
					<i>3</i>邀请参团
				</div>
				<div class="gbJoin-play-item">
					<i>4</i>人满拼团成功
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/template" id="gbJoin-template">
	<div class="gbJoin-product pro-item">
		<img class="cp_photo" src="<%=imgSrc %><%=data.proinfo.photo_x %>">
		<div class="df_1">
			<div class="ovh1">
				<%=data.proinfo.name %>
			</div>
			<div style="height:17px;"></div>
			<div class="sljg">
				<div class="gm_ovh_1h">
					<text style="color:red;">￥<%=data.gbinfo.gbprice %></text>
					<text class="gbJoin-product-buyCount">已团购<em><%=data.gbinfo.gbnum %></em>件</text>
				</div>
				<text class="gm_ovh_1h">×1</text>
			</div>
		</div>
		<% if(data.gblinfo.status=='S3' || data.gblinfo.status=='S4'){ %>
		<i class="activeFail-icon"></i>
		<% } %>
	</div>
	<div class="gbJoin-page-bg">
		<div class="gbJoin-member">
			<ul class="gbJoin-member-list">
				<% for(var i in data.gbmans){ %>
				<% var item = data.gbmans[i]; %>
				<li class="gbJoin-members">
					<img src="<%=item.uphoto %>" alt="" />
					<% if(item.type==1){ %>
					<em>团长</em>
					<% } %>
				</li>
				<% } %>
				<% for(var n=1;n <= data.gbinfo.mannum - data.gbmans.length ;n++){ %>
				<li class="gbJoin-unset"><i></i></li>
				<% } %>
			</ul>
			<div class="gbJoin-count">
				<% if(data.gblinfo.status=='S2' || data.gblinfo.status=='S5'){ %> 仅剩
				<em><%=data.gbinfo.mannum - data.gbmans.length %></em>个名额，<em class="gbJoin-countDown"><%=data.gblinfo.etime %></em>后结束
				<% if(!data.gblinfo.isjoin){ %>
				<div class="gbJoin-invite">立即参团</div>
				<% } %>
				<% }else if(data.gblinfo.status=='S3'){ %>
				<span>活动结束</span>
				<% }else if(data.gblinfo.status=='S4'){ %>
				<span>拼团失败</span>
				<% } %>
			</div>
			<% if( data.gblinfo.isjoin && (data.gblinfo.status=='S2' || data.gblinfo.status=='S5')){ %>
			<div class="gbJoin-join-succ">
				<!-- <i class="succ-icon"></i> -->
				参团成功
			</div>
			<% }else{ %>
			<div class="gbJoin-space"></div>
			<% } %>
		</div>
	</div>
</script>
<script type="text/template" id="dialog-template">
	<div id="drawer_attr_content" class="box mui-popover mui-popover-action mui-popover-bottom">
		<div class="drawer_attr_box mui-table-view">
			<div class="dac-head-div">
				<img id="proPhoto" src="<%=imgSrc %><%=data.proinfo.photo_x %>" />
				<div class="mingcheng">
					<div id="skuprice">￥
						<%=data.gbinfo.gbprice * buyCount %>
					</div>
					<div id="skustock">库存：
						<%=data.proinfo.num %>
					</div>
				</div>
				<div class="close_icon">×</div>
			</div>
			<div class="attrs-div">
				<div id="attrs-list" style="width:100%;border-bottom:1px solid #dedede;">
					<% for(var attr in data.proAttr ){ %>
					<% var attrItem = data.proAttr[attr] %>
					<div class="pro-attrs" data-group="<%=attrItem.id %>">
						<div class="attr">
							<%=attrItem.name %>
						</div>
						<% for(var pro in attrItem.values){ %>
						<% var proItem = attrItem.values[pro] %>
						<div class="value" data-value="<%=proItem.id %>">
							<%=proItem.name %>
						</div>
						<% } %>
					</div>
					<% } %>
				</div>
				<div class="buynum-div">
					<text>购买数量</text>
					<div class="buynum-opd-div">
						<text class="downNum">-</text>
						<div class="nownum">1</div>
						<text class="upNum">+</text>
					</div>
				</div>
			</div>
			<div class="buyOpe" style="background: #f00;">确定</div>
		</div>
	</div>
</script>