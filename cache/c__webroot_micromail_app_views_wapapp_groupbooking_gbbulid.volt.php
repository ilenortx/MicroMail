<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
        <title>团购详情</title>

        <?= $this->assets->outputCss() ?> <?= $this->assets->outputJs() ?>

    </head>
    <script type="text/javascript" charset="utf-8">
        mui.init();
    </script>

    <body>
        <div class="mui-content ofauto">
        </div>
    </body>

</html>
<script type="text/template" id="gbBulid-template">
    <div class="gbBulid-title">
        <p><i></i><%=gbStatus(data.gblinfo.status) %></p>
    </div>
    <div class="gbBulid-page-bg">
        <div class="gbBulid-info">
            <div class="gbBulid-info-item">
                <text>订单编号</text><span><%=data.oinfo.order_sn %></span>
            </div>
            <div class="gbBulid-info-item">
                <text>订单金额</text><span>￥ <%=data.oinfo.price_h%></span>
            </div>
            <div class="gbBulid-info-item">
                <text>交易时间</text><span><%=data.oinfo.paytime %></span>
            </div>
            <div class="gbBulid-info-item">
                <text>支付方式</text><span>微信</span>
            </div>
        </div>
    </div>
    <div class="gbBulid-page-bg">
        <div class="gbBulid-member">
            <ul class="gbBulid-member-list">
                <% for(var i in data.gbmans){ %>
                <% var item = data.gbmans[i]; %>
                <li class="gbBulid-members">
                    <img src="<%=item.uphoto %>" alt="" />
                    <% if(item.type==1){ %>
                    <em>团长</em>
                    <% } %>
                </li>
                <% } %>
                <% for(var n=1;n <= data.gbinfo.mannum - data.gbmans.length ;n++){ %>
                <li class="gbBulid-unset"><i></i></li>
                <% } %>
            </ul>
            <div class="gbBulid-count">
                <% if(data.gblinfo.status=='S2'){ %>
                仅剩<em><%=data.gbinfo.mannum - data.gbmans.length %></em>个名额，<em class="gbBulid-countDown"><%=data.gblinfo.etime %></em>后结束
                <% }else if(data.gblinfo.status=='S3'){ %>
                <span>活动结束</span>
                <% }else if(data.gblinfo.status=='S4'){ %>
                <span>拼团失败</span>
                <% }else if(data.gblinfo.status=='S5'){ %>
                <span>拼团成功</span>
                <% } %>
            </div>
            <% if(data.gblinfo.status=='S2' && (data.gbinfo.mannum - data.gbmans.length > 0) ){ %>
            <div class="gbBulid-invite">
                邀请好友参加
            </div>
            <% } %>
            <div class="gbBulid-invite">
                邀请好友参加
            </div>
        </div>
    </div>
</script>
<script>
    template.helper("gbStatus", function(state){
        var text;
        switch(state){
            case 'S2':
                text = "恭喜你，开团成功";
                break;
            case 'S3':
                text = "活动结束";
                break;
            case 'S4':
                text = "拼团失败";
                break;
            case 'S5':
                text = "拼团成功";
                break;
        }
        return text;
    });
</script>