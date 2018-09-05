mui.ready(function(){
    page.loadPros();

    page.bindAction();
});

var page = {
    data: {
        uid: app.ls.get('uid')? app.ls.get('uid'):app.getUrlParam('uid'),
        order_sn: app.getUrlParam('sn'),
        bind_obj: {},
        count: 1,
    },
    loadPros: function() {
        mui.post(app.d.hostUrl + 'ApiProEvaluate/orderEvaluateInfo', {
            uid: page.data.uid,
            orderSn: page.data.order_sn,
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
                        var img_object = $('.upload-photo').eq(0).clone();
                    }else{
                        var img_object = $('<img />');
                        img_object.addClass('upload-photo');
                    }

                    img_object.attr('src', img_array[i]);
                    if($('.upload-photo').length > 0){
                        $('.upload-photo').last().after(img_object);
                    }else{
                        $('.appraise-image-content').prepend(img_object);
                    }
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

        $('.mui-content').on('click','.uploadImg',function(){
            $(this).next().click();
        });

        $('.mui-content').on('change', '.uploadAction',function(){
            var files = this.files;
            if (files && files.length) {
                var file = files[0]
                if (/^image\/\w+$/.test(file.type)) {

                    if($('.upload-photo').length > 0){
                        var img_object = $('.upload-photo').eq(0).clone();
                    }else if($('.uploadAction').length > 10){
                        mui.toast("上传图片数量不能大于10");
                        return;
                    }else{
                        var img_object = $('<div class="upload-photo"><em class="delAction">-</em></div>');
                    }
                    img_object.css('background-image', 'url('+URL.createObjectURL(file)+')').data('index', page.data.count);
                    page.data.bind_obj[page.data.count] = $(this);

                    if($('.uploadAction').length < 10){
                        $('.appraise-image-content').append($('.uploadImg').eq(0).clone());
                        var file_obj = $('.uploadAction').eq(0).clone().val('');
                        $('.appraise-image-content').append(file_obj);

                    }
                    $(this).prev().remove();
                    if($('.upload-photo').length > 0){
                        $('.upload-photo').last().after(img_object);
                    }else{
                        $('.appraise-image-content').prepend(img_object);
                    }
                    page.data.count++;
                }
            }
        });

        $('.mui-content').on('click', '.delAction',function(){
            if($('.uploadAction').length >= 10){
                $('.appraise-image-content').append($('<i class="mui-icon mui-icon-image uploadImg"><em>+</em></i>'));
                $('.appraise-image-content').append($('<input type="file" name="image[]" class="uploadAction" accept="image/*">'));
            }
            var index = $(this).parent().data('index');
            page.data.bind_obj[index].remove();
            $(this).parent().remove();
            delete page.data.bind_obj[index];
        });

        $('.appraise-submit').click(function(){
            var form_data = new FormData($('#form')[0]);
            form_data.append('uid',page.data.uid);
            form_data.append('orderSn',page.data.order_sn);

            $.ajax({
                type: 'post',
                url: app.d.hostUrl + 'ApiProEvaluate/addOrderEvaluate',
                data: form_data,
                processData: false,
                contentType: false,
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