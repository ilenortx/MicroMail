mui.ready(function(){
    page.loadPros();

    page.bindAction();
});

var page = {
    data: {

    },
    loadPros: function() {

    },
    cprodom: function() {

    },

    bindAction: function(){
        $('.mui-content').on('click','.appraise-point .mui-icon',function(){
            $('.appraise-point .mui-icon').removeClass('current');
            $(this).addClass('current').prevAll('i').addClass('current');
        });
    }
}