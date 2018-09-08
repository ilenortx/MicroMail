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
        pageData: {},
    },
    loadPros: function() {
        mui.post(app.d.hostUrl + 'ApiProEvaluate/orderEvaluateInfo', {
            uid: page.data.uid,
            orderSn: page.data.order_sn,
        }, function(data) {
            if(data.status==2 || data.status==1){
                page.data.pageData = data.datas;

                page.cprodom();
            }else if (data.status==0){
                mui.toast("请求失败");
            }
        },'json');
    },
    cprodom: function() {
        var data = {
            proInfo: page.data.pageData.proInfo,
            oeInfo: page.data.pageData.oeInfo? page.data.pageData.oeInfo:{},
            imgUrl: app.d.hostImg,
        };
        var html = template('orderAppraise-template', data);
        $('.appraise-box').html(html);

        // var order_info = page.data.pageData.proInfo;
        // var appraise_info = page.data.pageData.oeInfo;

        // $($('.appraise-point').children()[appraise_info.grade]).addClass('current').prevAll('i').addClass('current');
        // $('[name="evaluate"]').val(appraise_info.evaluate);

        // var img_array = appraise_info.show_photos.split(",");

        // for (var i in img_array) {
        //     if($('.upload-photo').length > 0){
        //         var img_object = $('.upload-photo').eq(0).clone();
        //     }else{
        //         var img_object = $('<img />');
        //         img_object.addClass('upload-photo');
        //     }

        //     img_object.attr('src', app.d.hostImg+img_array[i]);
        //     if($('.upload-photo').length > 0){
        //         $('.upload-photo').last().after(img_object);
        //     }else{
        //         $('.appraise-image-content').prepend(img_object);
        //     }
        // };
    },

    bindAction: function(){
        $('.mui-content').on('click','.appraise-point .mui-icon',function(){
            var parent_obj = $(this).parents('.appraise-point');
            var pid = parent_obj.data('id');
            if(!page.data.pageData.oeInfo || !page.data.pageData.oeInfo[pid] || !page.data.pageData.oeInfo[pid].grade){
                parent_obj.find('.mui-icon').removeClass('current');
                $(this).addClass('current').prevAll('i').addClass('current');
                var index = $(this).index();
                $('[name="grade['+ pid +']"]').val(index);
            }
        });

        $('.mui-content').on('click','.uploadImg',function(){
            $(this).next().click();
        });

        $('.mui-content').on('change', '.uploadAction',function(){
            var files = this.files;
            if (files && files.length) {
                var file = files[0]
                if (/^image\/\w+$/.test(file.type)) {
                    var parent_obj = $(this).parents('.appraise-image-content');

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
                        parent_obj.append(parent_obj.find('.uploadImg').eq(0).clone());
                        var file_obj = parent_obj.find('.uploadAction').eq(0).clone().val('');
                        parent_obj.append(file_obj);

                    }
                    $(this).prev().remove();
                    if(parent_obj.find('.upload-photo').length > 0){
                        parent_obj.find('.upload-photo').last().after(img_object);
                    }else{
                        parent_obj.prepend(img_object);
                    }
                    page.data.count++;
                }
            }
        });

        $('.mui-content').on('click', '.delAction',function(){
            if($('.uploadAction').length >= 10){
                var parent_obj = $(this).parents('.appraise-image-content');
                var pid = parent_obj.data('pid');
                parent_obj.append($('<i class="mui-icon mui-icon-image uploadImg"><em>+</em></i>'));
                parent_obj.append($('<input type="file" name="image['+ pid +'][]" class="uploadAction" accept="image/*">'));
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
                    if(data.status==1){
                        mui.toast("提交成功");
                        setTimeout(function(){
                            app.pageGoBack(-1, true);
                        },3000);
                    }else{
                        mui.toast("提交失败");
                    }
                },
                error: function(xhr,type,errorThrown){
                    mui.toast(type);
                },
                dataType: 'json',
            });
        });
    }
}