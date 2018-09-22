<div class="mui-content ofauto">
	<!-- 轮播图 -->
	<div class="video-div">
		<video id="video" class="video-js" controls preload="auto" poster="" data-setup="{}">
			<source src="http://vjs.zencdn.net/v/oceans.mp4" type="video/mp4">
			<!-- <p class="vjs-no-js"></p> -->
		</video>
		<div class="quitPlay">退出播放</div>
	</div>
	<div class="pro-swiper swiper-container">
	</div>

	<!-- 促销信息 -->
	{% if proInfo['hd_type']==1 %}
	<div class="promotion-info-div">
		<text class="pprice"></text>
		<text class="yprice"></text>
		<div class="djs-div">
			<div style="font-size:10px;">距结束仅剩</div>
			<div id="pCountDown">00:00:00</div>
		</div>
	</div>
	{% endif %}

	<div class="title"></div>
	<div class="gmxx">
		<div class="intro"></div>
		{% if proInfo['hd_type']!=1 %}
		<div class="pro-info-div">
			<span class="yjiage"></span>
			<span class="jiage"></span>
			<span class="xiaoliang"></span>
			<span class="tkc" style='color:#ccc'></span>
		</div>
		{% endif %}
	</div>

	<!-- 参团 -->
	{% if proInfo['hd_type']!='3' %}
	<div>
		<div style='height:10px;background:#efeff4;'></div>
		<div class="gb-more-div">
			<text class="caption_text"><text id="pdzrs">1</text>人在拼单，可直接参与</text>
			<div class="more" onclick="mui('#more-gbm').popover('show');">
				查看更多
				<img src="../img/wapApp/right_arrows.png" />
			</div>
		</div>
		<div id="gbList">
			<!--<div class="gbl-list-div">
				<div style="display:flex;width:55%;align-items:center;">
					<img class="uavatar" src="../img/wapApp/user-avatar.png"/>
					<text class="unick">老板娘，请来半斤美女￡</text>
				</div>
				<div style="display:flex;width:45%;align-items:center;justify-content:flex-end;">
					<div class="gb-mt-info">
						<div>还差<text>5人</text>拼成</div>
						<div>剩余1:42:31</div>
					</div>
				</div>
				<div class="gtgb-tbn">去拼单</div>
			</div>-->
		</div>
	</div>
	{% endif %}


	<!-- 产品说明 -->
	<a href="../WPages/serviceNotePage?proid={{productId}}" class="prosns">
		<div class="prosn-items-div">
			<!--<div class="prosn-item">
				<div style="display:flex;align-items:center;">
					<img src="../img/wapApp/prosn-ok.png" />的身份
				</div>
			</div>-->
		</div>
		<img class="rjt" src="../img/wapApp/x_right.png" />
	</a>

	<!-- 推荐 -->
	<div id="tjdiv">
		<div style='height:10px;background:#efeff4;'></div>
		<a id="tja">
			<img id="tjimg" src="" />
		</a>
	</div>

	<div style='height:10px;background:#efeff4;'></div>

	<div class="detail">
		<div class="swiper-tab">
			<div class="bre swiper-tab-list on" cw='1' onclick="chooseDetail(this);">图文详情</div>
			<div class="bre swiper-tab-list" cw='2' onclick="chooseDetail(this);">产品参数</div>
			<div class="swiper-tab-list" cw='3' onclick="chooseDetail(this);">评价</div>
		</div>
		<div class="pro-detail-div prodetail">
			<div class="pro-detail"></div>

			<div id="rxtj">
				<div style='height:10px;background:#efeff4;'></div>
				<div class="tjtitle">
					<div class="tjline"></div>
					<text>热卖推荐</text>
					<div class="tjline"></div>
				</div>
				<div style='height:5px;background:#efeff4;'></div>
				<div class="tjpro-div">
					<div class="tjpro-swipers swiper-container1">
						<!--<div class="swiper-wrapper">
							<div class="swiper-slide">
								<a class="single-goods">
									<img class="prophoto" src="../img/wapApp/yhqbg2.png" />
									<text class="proname">撒旦发射点发生</text>
									<div class="summary">
										<text class="price">123</text>
									</div>
								</a>
							</div>
						</div>-->

					</div>
				</div>
				<div class="dots-view">
					<div class="swiper-pagination1"></div>
				</div>
			</div>
		</div>
		<div class="pro-attrs-div prodetail">
		</div>
		<div class="pro-evaluate-div prodetail">

		</div>
	</div>

	<div class="footer">
		<div class="f-left-div">
			<div onclick="gotoHome()" class="home">
				<img src="../img/wapApp/home.png" />
				<text>首页</text>
			</div>
			<div class="kf">
				<img src="../img/wapApp/kefu.png" />
				<text>客服</text>
			</div>
			<div onclick="addFavorites()" class="sc">
				<img id="scImg" src="../img/wapApp/shc.png" />
				<text>收藏</text>
			</div>
		</div>
		<div class="f-right-div">
			{% if proInfo['hd_type']==0 %}<!-- 普通 -->
			<div onclick="showDAC(this, 2)" class="w-50 addcart">加入购物车</div>
			<div onclick="showDAC(this, 1)" class="w-50 buynow">立即购买</div>
			{% elseif proInfo['hd_type']==1 %}<!-- 秒杀 -->
			<div onclick="showDAC(this, 2)" class="w-50 addcart">加入购物车</div>
			<div onclick="showDAC(this, 1)" class="w-50 buynow">立即购买</div>
			{% elseif proInfo['hd_type']==2 %}<!-- 团购 -->
			<div onclick="showDAC(this, 1);" class="w-50 btn-price" style="background:#f85">
				￥{{proInfo['price_yh']}}<br/>单独购买
			</div>
			<div id="tgprice" onclick="showDAC(this, 3)" class="w-50 btn-price" style="background:#f00"></div>
			{% elseif proInfo['hd_type']==3 %}<!-- 砍价 -->
			<div onclick="showDAC(this, 4)" hdid="{{proInfo['hd_id']}}" class="w-100 buynow">我要砍价</div>
			{% endif %}
		</div>
	</div>
</div>

<div id="drawer_attr_content" class="box mui-popover mui-popover-action mui-popover-bottom">
	<div class="drawer_attr_box mui-table-view">
		<div class="dac-head-div">
			<img id="proPhoto" src="" />
			<div class="mingcheng">
				<div id="skuprice">￥ 0.00</div>
				<div id="skustock">库存：0</div>
			</div>
			<div onclick="hideDAC()" class="close_icon">×</div>
		</div>
		<div class="attrs-div">
			<div id="attrs-list" style="width:100%;border-bottom:1px solid #dedede;">
				<!--<div class="pro-attrs">
					<div class="attr">颜色</div>
					<div class="value value-choose">红色</div>
					<div class="value">红色</div>
					<div class="value">红色</div>
				</div>-->
			</div>
			<div class="buynum-div">
				<text>购买数量</text>
				<div class="buynum-opd-div">
					<text onclick="buyNum('d')" class="downNum">-</text>
					<div class="nownum">1</div>
					<text onclick="buyNum('u')" class="upNum">+</text>
				</div>
			</div>
		</div>
		<div onclick="" class="buyOpe"></div>
	</div>
</div>
<!-- 弹出框 -->
<div id="more-gbm" class="box mui-popover mui-popover-action mui-popover-bottom">
	<div class="gb-list-div">
		<div class="more-gb-close" onclick="mui('#more-gbm').popover('hide');">×</div>
		<div class="gb-list-title">正在拼单</div>
		<div class="gb-list-scroll">
			<!--<div class="gbl-list-div">
				<div style="display:flex;width:70%;">
					<img class="uavatar" src="../img/wapApp/user-avatar.png"/>
					<div style="margin-left:10px;font-size:12px;line-height:20px;">
						<div style="display:flex;">
							<div class="uname1">老板娘，请来半斤美女￡</div>
							还差<text>5人</text>
						</div>
						<div>剩余1:09:51 </div>
					</div>
				</div>
				<div class="gtgb-tbn">去拼单</div>
			</div>-->
		</div>
		<div class="gb-list-bottom">仅显示10个正在拼单的人</div>
	</div>
</div>
<script>
	/*初始化参数*/
	page.data.productId = "{{productId}}";
</script>
<script type="text/template" id="appraise-template">
	<div class="appraise_type">
		<a href="../WPages/proPeListPage?pid=<%=pid %>#type=0">全部 <%=data.typeNum.qb %></a><a href="../WPages/proPeListPage?pid=<%=pid %>#type=1">好评 <%=data.typeNum.hp %></a><a href="../WPages/proPeListPage?pid=<%=pid %>#type=2">中评 <%=data.typeNum.zp %></a><a href="../WPages/proPeListPage?pid=<%=pid %>#type=3">差评 <%=data.typeNum.cp %></a><a href="../WPages/proPeListPage?pid=<%=pid %>#type=4">晒单 <%=data.typeNum.sd %></a>
	</div>

	<% if(data.peInfo){ %>
	<% for(var i in data.peInfo){ %>
	<% var log_item = data.peInfo[i]; %>
	<div class="pe-item-div">
		<div class="top-div">
			<div class="head-left">
				<text><%=log_item.uname %></text>
				<span class="icons">
					<% for(var j=1;j<=5;j++){ %>
					<i data-index="<%=j %>" class="mui-icon <% if(j<=log_item.grade){ %>mui-icon-star-filled<% }else{ %>mui-icon-star<% } %>"></i>
					<% } %>
				</span>
			</div>
			<text><%=log_item.time %></text>
		</div>
		<div class="evaluate-cont"><%=log_item.evaluate %></div>
		<div class="pe-img-div">
			<% for(var k in log_item.show_photos){ %>
			<img src="<%=log_item.show_photos[k] %>" />
			<% } %>
		</div>
	</div>
	<% } %>
	<% } %>
	<div class="ckqb-div">
		<a class="ckqb-btn" href="../WPages/proPeListPage?pid=<%=pid %>">查看全部评价</a>
	</div>
</script>