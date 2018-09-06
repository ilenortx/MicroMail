<div class="mui-content">
    <div id="tabs">
    </div>
    <div id="appraise-box">
    </div>
</div>
<script type="text/template" id="appraise-template">
    <div class="appraise_type">
        <a href="javascript:void(0);" data-type="0" class="<% if(type==0){ %>current<% } %>">全部<em><%=tabData.qb %>+</em></a>
        <a href="javascript:void(0);" data-type="1" class="<% if(type==1){ %>current<% } %>">好评<em><%=tabData.hp %>+</em></a>
        <a href="javascript:void(0);" data-type="2" class="<% if(type==2){ %>current<% } %>">中评<em><%=tabData.zp %>+</em></a>
        <a href="javascript:void(0);" data-type="3" class="<% if(type==3){ %>current<% } %>">差评<em><%=tabData.cp %>+</em></a>
        <a href="javascript:void(0);" data-type="4" class="<% if(type==4){ %>current<% } %>">晒单<em><%=tabData.sd %>+</em></a>
    </div>
</script>
<script type="text/template" id="apList-template">
    <% if(list.length > 0){ %>
    <% for(var i in list){ %>
    <% var log_item = list[i]; %>
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
            <% var img_array = log_item.show_photos.split(","); %>
            <% for(var k in img_array){ %>
            <img src="<%=img_array[k] %>" />
            <% } %>
        </div>
        <div class="extra_info"><%=log_item.sku %></div>
    </div>
    <% } %>
    <% } %>
</script>