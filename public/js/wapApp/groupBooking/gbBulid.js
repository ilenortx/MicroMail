mui.ready(function() {
    page.initWinWH();

    page.initCgs();

    page.bindAction();
});

var page = {
    data: {
        winWidth: 0,
        winHeight: 0,
        orderId: app.getUrlParam("orderId"),
        uid: app.ls.get("uid"),
        pageData: {},
        stopCount: false,
    },
    initWinWH: function() {
        this.data.winWidth = $(window).width();
        this.data.winHeight = $(window).height();
    },
    initCgs: function() {
        var _this = this;

        mui.post(app.d.hostUrl + 'ApiGroupBooking/gbOrderInfo', {
            orderId: _this.data.orderId,
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
        };
        var html = template("gbBulid-template", data);
        $('.mui-content').html(html);

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
        $('.gbBulid-countDown').text(systime);
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
        $('.mui-content').on('click','.gbBulid-invite',function(){
            var share_data = {
                title: "专致优货",
                desc: page.data.pageData.oinfo.proname,
                link: app.d.hostUrl + 'WPages/gbJoinPage?gblid=' + page.data.pageData.gblinfo.id,
                imgUrl: app.d.hostImg + page.data.pageData.oinfo.prophoto,
                success: function(){             //  分享成功
                    mui.toast("分享成功");
                },
                fail: function(){             //  分享失败
                    mui.toast("分享失败");
                },
                cancel: function(){
                    mui.toast("分享取消");
                }
            }

            app.wxShare(share_data);
        });
    },
}