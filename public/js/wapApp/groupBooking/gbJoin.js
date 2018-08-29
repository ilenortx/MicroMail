mui.ready(function() {
    page.initWinWH();

    page.initCgs();

    page.bindAction();
});

var page = {
    data: {
        winWidth: 0,
        winHeight: 0,
        gblid: app.getUrlParam("gblid"),
        uid: app.ls.get("uid"),
        pageData: {},
        buyCount: 1,
        selAttr: {},
        stopCount: false,
    },
    initWinWH: function() {
        this.data.winWidth = $(window).width();
        this.data.winHeight = $(window).height();
    },
    initCgs: function() {
        var _this = this;

        mui.post(app.d.hostUrl + 'ApiGroupBooking/joinGbInfo', {
            gblid: _this.data.gblid,
            uid: _this.data.uid,
        }, function(data) {
            var data = app.json.decode(data);

            page.data.pageData = data;

            _this.cprodom();
        });
    },
    joinGroup: function() {
        mui.post(app.d.hostUrl + 'ApiGroupBooking/joinGbInfo', {
            gblid: _this.data.gblid,
            uid: _this.data.uid,
        }, function(data) {
            var data = app.json.decode(data);

            page.data.pageData = data;

            _this.cprodom();
        });
    },
    cprodom: function() {
        var _this = this;
        var data = {
            data: _this.data.pageData,
            uid: page.data.uid,
            imgSrc: app.d.hostImg,
        };
        var html = template("gbJoin-template", data);
        $('.template-content').html(html);

        if(_this.data.stopCount===false){
            _this.pCountDown();
        }
    },
    pCountDown: function() { //团购倒计时
        var _this = this;
        var systime = _this.timeFormat(_this.data.pageData.gblinfo.etime);
        if(systime===false){
            _this.pCountDownOff();
            return;
        }
        this.data.pageData.gblinfo.systime = systime;
        $('.gbJoin-countDown').text(systime);
        setTimeout(function() {
            _this.pCountDown();
        }, 1000);
    },
    pCountDownOff: function(){
        var _this = this;
        page.data.pageData.gblinfo.status = "S3";
        page.data.stopCount = true;
        _this.cprodom();

        mui.toast('活动已结束');
    },
    timeFormat: function(t) { //活动结束时间
        var time = t - parseInt(Number(new Date()) / 1000);
        if(time <= 0) return false;

        var day = parseInt(time / 86400);
        var h = parseInt((time - day * 86400) / 3600);
        var m = parseInt((time - day * 86400 - h * 3600) / 60);
        var s = time - day * 86400 - h * 3600 - m * 60;
        m = m < 10 ? '0' + m : m;
        s = s < 10 ? '0' + s : s;

        var ftime = day == 0 ? '' : day + '天';
        if(h > 0) ftime += h + ':';
        if(m >= 0) ftime += m + ':';
        if(s >= 0) ftime += s;

        return ftime;
    },

    bindAction: function(){
        $('.mui-content').on('tap','.gbJoin-invite',function(){
            if($('#drawer_attr_content').length == 0){
                var data = {
                    data: page.data.pageData,
                    imgSrc: app.d.hostImg,
                    buyCount: page.data.buyCount,
                };
                var html = template("dialog-template", data);
                $('body').append(html);
            }
            mui("#drawer_attr_content").popover('show');
        });

        $('body').on('tap','.close_icon',function(){
            mui("#drawer_attr_content").popover('hide');
        }).on('tap','.downNum',function(){            // 数量减
            page.data.buyCount = page.data.buyCount - 1 > 0? page.data.buyCount - 1:1;
            $('.nownum').text(page.data.buyCount);
        }).on('tap','.upNum',function(){              // 数量加
            page.data.buyCount = page.data.buyCount + 1 > page.data.pageData.proinfo.num? page.data.pageData.proinfo.num: page.data.buyCount + 1;
            $('.nownum').text(page.data.buyCount);
        }).on('tap','.pro-attrs .value',function(){   //选择规格
            if(!$(this).hasClass('value-choose')){
                $(this).addClass('value-choose').siblings('.value').removeClass('value-choose');

                var group = $(this).parent().attr('data-group');
                var value = $(this).attr('data-value');
                page.data.pageData.proAttr[group].cval = value;
            }
        }).on('tap','.buyOpe',function(){             // 发起参团
            var skuid = '';
            if(skuid = verifyGb()){
                var orderInfo = {
                    pid: page.data.pageData.proinfo.id,
                    num: page.data.buyCount,
                    hdId: page.data.pageData.proinfo.hd_id,
                    type: 'gb',
                    skuid: skuid.slice(0,-1),
                };

                app.ls.save('orderInfo', JSON.stringify(orderInfo));
                window.location.href = '../WPages/orderPayPage';
            }
        });
    },
}
function verifyGb(){
    var attr_data = page.data.pageData.proAttr;
    var sku = '';
    for(var i in attr_data){
        if(!attr_data[i].cval){
            mui.toast("请选择" + attr_data[i].name);
            return false;
        }
        sku += attr_data[i].cval + ',';
    }
    if(page.data.buyCount > page.data.pageData.proinfo.num){
        mui.toast("库存不足");
        return false;
    }

    return sku;
}