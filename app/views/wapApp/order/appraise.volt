<div class="mui-content">
    <form id="form" action="" enctype="multipart/form-data" method="post">
        <div class="appraise-box">
            <!-- <div class="appraise-head">
                <img id="product_img" src="" alt="">
                <div class="appraise-point">
                    <text>商品评分</text>
                    <i class="mui-icon"></i><i class="mui-icon"></i><i class="mui-icon"></i><i class="mui-icon"></i><i class="mui-icon"></i>
                    <input type="hidden" name="grade">
                </div>
            </div>
            <div class="appraise-text">
                <textarea name="evaluate" placeholder="宝贝满足您的期待吗？说说您的使用心理，分享给想买的他们吧"></textarea>
            </div>
            <div class="appraise-image">
                <div class="appraise-image-title">添加图片(最多10个)</div>
                <div class="appraise-image-content">
                    <i class="mui-icon mui-icon-image uploadImg"><em>+</em></i>
                    <input type="file" name="image[]" class="uploadAction" accept="image/*">
                </div>
            </div> -->
        </div>
        <div class="appraise-submit">提交</div>
    </form>
</div>
<script type="text/template" id="orderAppraise-template">
    <% if(proInfo){ %>
    <% for(var i in proInfo){ %>
    <% var pro_item = proInfo[i]; %>
    <div class="appraise-head">
        <img id="product_img" src="<%=imgUrl %><%=pro_item.photo %>" alt="">
        <div class="appraise-point" data-id="<%=i %>">
            <text>商品评分</text>
            <% for(var j=1;j<=5;j++){ %>
            <% if(oeInfo[i] && typeof(oeInfo[i].grade)!=undefined){ %>
            <i class="mui-icon <% if(j <= oeInfo[i].grade){ %>current<% } %>"></i>
            <% }else{ %>
            <i class="mui-icon"></i>
            <% } %>
            <% } %>
            <input type="hidden" name="grade[<%=i %>]" value="<% if(oeInfo[i] && typeof(oeInfo[i].grade)!=undefined){ %><%=oeInfo[i].grade %><% } %>" />
        </div>
    </div>
    <div class="appraise-text">
        <% if(oeInfo[i] && typeof(oeInfo[i].evaluate)!=undefined){ %>
        <textarea name="evaluate[<%=i %>]" placeholder="宝贝满足您的期待吗？说说您的使用心理，分享给想买的他们吧" readonly="readonly"><%=oeInfo[i].evaluate %></textarea>
        <% }else{ %>
        <textarea name="evaluate[<%=i %>]" placeholder="宝贝满足您的期待吗？说说您的使用心理，分享给想买的他们吧"></textarea>
        <% } %>
    </div>
    <div class="appraise-image">
        <div class="appraise-image-title">添加图片(最多10个)</div>
        <div class="appraise-image-content" data-id="<%=i %>">
            <% if(oeInfo[i] && typeof(oeInfo[i].show_photos)!=undefined){ %>
            <% for(var k in oeInfo[i].show_photos){ %>
            <img class="upload-photo" src="<%=imgUrl %><%=oeInfo[i].show_photos[k] %>" alt="">
            <% } %>
            <% }else{ %>
            <i class="mui-icon mui-icon-image uploadImg"><em>+</em></i>
            <input type="file" name="image[<%=i %>][]" class="uploadAction" accept="image/*">
            <% } %>
        </div>
    </div>
    <% } %>
    <% } %>
</script>