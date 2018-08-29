mui.ready(function() {
    page.initWinWH();

    // page.initCgs();

    app.pullRefresh.up('#myCp-CpList', page.loadPros());

    // $(window).scroll(function() {　　
    //     var scrollTop = $(this).scrollTop();　　
    //     var scrollHeight = $(document).height();　　
    //     var windowHeight = $(this).height();　　
    //     if(scrollTop + windowHeight == (scrollHeight)) {
    //         page.loadPros();
    //     }
    // });

    page.bindAction();
});

var page = {
    data: {
        winWidth: 0,
        winHeight: 0,
        page: {'T1':0,'T2':0,'T3':0},
        type: 'T1',
        cpList: {'T1':[],'T2':[],'T3':[]},
        disabled: {'T1':false,'T2':false,'T3':false},
        uid: app.ls.get("uid"),
        isLoading: false,
    },
    initWinWH: function() {
        this.data.winWidth = $(window).width();
        this.data.winHeight = $(window).height();
    },
    // initCgs: function() {
    //     var _this = this;
    //     mui.post(app.d.hostUrl + 'ApiCutPrice/cpList', {
    //         uid: _this.data.uid,
    //         type: _this.data.type,
    //     }, function(data) {
    //         var data = app.json.decode(data);

    //         page.data.page[_this.data.type] += 1;
    //         page.data.cpList[_this.data.type] = _this.data.cpList[_this.data.type].concat(data.ucps);
    //         _this.cprodom();
    //     });
    // },
    loadPros: function() {
        var _this = this;
        if(_this.data.disabled[_this.data.type]===true || _this.data.isLoading===true){
            _this.cprodom();
        }else{
            page.data.isLoading = true;

            mui.post(app.d.hostUrl + 'ApiCutPrice/cpList', {
                uid: _this.data.uid, type: _this.data.type, page: _this.data.page[_this.data.type],
            }, function(data) {
                var data = app.json.decode(data);
                page.data.isLoading = false;
                if(data.ucps.length == 0) page.data.disabled[_this.data.type] = true;

                page.data.page[_this.data.type] += 1;
                page.data.cpList[_this.data.type] = _this.data.cpList[_this.data.type].concat(data.ucps);
                if(_this.data.type != page.data.type) return;

                _this.cprodom();
            });
        }
    },
    cprodom: function() {
        var _this = this;

        var data = {
            list: _this.data.cpList[_this.data.type],
            imgSrc: app.d.hostImg,
        };
        var html = template('cpList-template', data);
        $('.myCp-CpList').html(html);
    },

    bindAction: function(){
        $('.myCp-tabs').on('click','.myCp-tab',function(){
            $(this).addClass('current').siblings().removeClass('current');
            page.data.type = $(this).attr('data-tag');

            page.loadPros();
        });
    }

}
