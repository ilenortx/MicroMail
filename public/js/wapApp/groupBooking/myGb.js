mui.ready(function() {
    page.initWinWH();

    // page.initCgs();

    app.pullRefresh.up('#myGb-gbList', page.loadPros());

    page.bindAction();
});

var page = {
    data: {
        winWidth: 0,
        winHeight: 0,
        page: {'1':0,'2':0},
        type: '1',
        gbList: {'1':[],'2':[]},
        disabled: {'1':false,'2':false},
        uid: app.ls.get("uid"),
        isLoading: false,
    },
    initWinWH: function() {
        this.data.winWidth = $(window).width();
        this.data.winHeight = $(window).height();
    },
    // initCgs: function() {
    //     var _this = this;

    //     page.data.isLoading = true;
    //     mui.post(app.d.hostUrl + 'ApiGroupBooking/joinGbList', {
    //         uid: _this.data.uid,
    //         type: _this.data.type,
    //     }, function(data) {
    //         var data = app.json.decode(data);
    //         page.data.isLoading = false;

    //         page.data.page[_this.data.type] += 1;
    //         page.data.gbList[_this.data.type] = _this.data.gbList[_this.data.type].concat(data.gblist);
    //         _this.cprodom();
    //     });
    // },
    loadPros: function() {
        var _this = this;
        if(_this.data.disabled[_this.data.type]===true || _this.data.isLoading===true){
            _this.cprodom();
        }else{
            page.data.isLoading = true;

            mui.post(app.d.hostUrl + 'ApiGroupBooking/joinGbList', {
                uid: _this.data.uid, type: _this.data.type, page: _this.data.page[_this.data.type],
            }, function(data) {
                var data = app.json.decode(data);
                page.data.isLoading = false;
                if(data.gblist.length == 0) page.data.disabled[_this.data.type] = true;

                page.data.page[_this.data.type] += 1;
                page.data.gbList[_this.data.type] = _this.data.gbList[_this.data.type].concat(data.gblist);
                if(_this.data.type != page.data.type) return;

                _this.cprodom();
            });
        }
    },
    cprodom: function() {
        var _this = this;

        var data = {
            list: _this.data.gbList[_this.data.type],
            type: _this.data.type,
            imgSrc: app.d.hostImg,
        };
        var html = template('gbList-template', data);
        $('.myGb-gbList').html(html);
    },

    bindAction: function(){
        $('.myGb-tabs').on('click','.myGb-tab',function(){
            $(this).addClass('current').siblings().removeClass('current');
            page.data.type = $(this).attr('data-tag');

            page.loadPros();
        });
    }

}