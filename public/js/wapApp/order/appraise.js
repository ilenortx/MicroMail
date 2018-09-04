mui.ready(function(){
    page.loadPros();

    page.bindAction();
});

var page = {
    data: {

    },
    loadPros: function() {
        mui.post(app.d.hostUrl + 'ApiProEvaluate/orderEvaluateInfo', {
            uid: app.ls.get('uid')? app.ls.get('uid'):app.getUrlParam('uid'),
            orderSn: app.getUrlParam('sn'),
        }, function(data) {
            if(data.status==1){
                var order_info = data.proInfo;
                var appraise_info = data.oeInfo;

                $('#product_img').attr('src', order_info.photo);
                $('.appraise-point').children()[appraise_info.grade].addClass('current').prevAll('i').addClass('current');
                $('[name="evaluate"]').val(appraise_info.evaluate);

                var img_array = appraise_info.show_photos.split(",");

                for (var i in img_array) {
                    if($('.upload-photo').length > 0){
                        var img_object = $('.upload-photo').clone();
                    }else{
                        var img_object = $('<img />');
                        img_object.addClass('upload-photo');
                    }

                    img_object.attr('src', img_array[i]);
                    $('.appraise-image-content').prepend(img_object);
                };
            }else{
                mui.toast("请求失败");
            }
        },'json');
    },
    cprodom: function() {

    },

    bindAction: function(){
        $('.mui-content').on('click','.appraise-point .mui-icon',function(){
            $('.appraise-point .mui-icon').removeClass('current');
            $(this).addClass('current').prevAll('i').addClass('current');
            var index = $(this).index();
            $('[name="grade"]').val(index);
        });

        $('.uploadImg').click(function(){
            $(this).next().click();
        });

        $('[name="image[]"]').change(function(){
            var files = this.files;

            if (files && files.length) {
                for (var i in files) {
                    var file = files[i];
                    if (/^image\/\w+$/.test(file.type)) {
                        if($('.upload-photo').length > 0){
                            var img_object = $('.upload-photo').clone();
                        }else{
                            var img_object = $('<img />');
                            img_object.addClass('upload-photo');
                        }
                        img_object.attr('src',URL.createObjectURL(file));
                        $('.appraise-image-content').prepend(img_object);
                    }
                };

            }
        });

        $('.appraise-submit').click(function(){
            $.ajax({
                type: 'post',
                url: app.d.hostUrl + 'ApiProEvaluate/addOrderEvaluate?XDEBUG_SESSION_START=ECLIPSE_DBGP&KEY=15266949870761',
                data: new FormData($('#form')[0]),
                processData: false,
                success: function(data){

                },
                error: function(xhr,type,errorThrown){
                    mui.toast(type);
                },
                dataType: 'json',
            });
        });
    }
}