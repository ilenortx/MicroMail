mui.ready(function() {
    app.pullRefresh.up('.appraise-box', page.initCgs());

    page.bindAction();
});

var page = {
    data: {
        pid: app.getUrlParam('pid'),
        type: '',
        page: {},
        disabled: {},
        list: {},
        tabData: {},
        isLoading: false,
        firstLoading: true,
    },
    initCgs: function() {
        var hash = location.hash;
        var hash_arr = hash.split('type=');
        var type = page.data.type = hash_arr[1]? hash_arr[1]:0;
        if(!page.data.page[type]){
            page.data.page[type] = 0;
        }
        if(!page.data.list[type]){
            page.data.list[type] = [];
        }

        if(page.data.disabled[type] === true || page.data.isLoading === true){
            page.cprodom();
        }else{
            page.data.isLoading = true;

            mui.post(app.d.hostUrl + 'ApiProEvaluate/proEvaluates', {
                type: type,
                pid: page.data.pid,
                offset: page.data.page[type],
            }, function(data) {
                if(data.status == 1) {
                    page.data.isLoading = false;

                    page.data.tabData = data.datas.typeNum;

                    if(data.datas.peInfo.length == 0) page.data.disabled[type] = true;

                    page.data.page[type] += 1;
                    page.data.list[type] = page.data.list[type].concat(data.datas.peInfo);

                    if(type != page.data.type) return;
                    page.cprodom();
                } else {
                    mui.toast("网络错误");
                }
            },'json');
        }
    },
    cprodom: function() {
        var tem_data = {
            list: page.data.list[page.data.type],
            tabData: page.data.tabData,
            type: page.data.type,
        };

        if(page.data.firstLoading===true){
            page.data.firstLoading = false;

            var html = template("appraise-template", tem_data);
            $('#tabs').html(html);

            var html = template("apList-template", tem_data);
            $('#appraise-box').html(html);
        }else{
            var html = template("apList-template", tem_data);
            $('#appraise-box').html(html);
        }
    },

    bindAction: function(){
        $('.mui-content').on('click','.appraise_type a',function(){
            if(!$(this).hasClass('current')){
                $(this).addClass('current').siblings().removeClass('current');
                location.replace('#type='+$(this).data('type'));
            }
        });

        window.onhashchange = function(){
            page.initCgs();
        };
    },
}