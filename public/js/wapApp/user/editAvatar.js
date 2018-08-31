mui.ready(function(){
    page.loadPage();

    page.bindAction();
});

var page = {
    crop_options: {
        aspectRatio: 1, // 纵横比
        viewMode: 2,
    },
    file_obj: false,
    img_obj: false,
    uploadedImageURL: '',
    saveImageURL: '',
    loadPage: function(){
        var my_icon = app.ls.get('avatar'); //头像
        $('#user-avatar').attr('src', my_icon);

        page.saveImageURL = my_icon;
        page.file_obj = $('#file_obj');
        page.img_obj = $('#user-avatar');
    },
    uploadAvatar: function(img, f){
        var form_data = new FormData();
        form_data.append("imgBase64",encodeURIComponent(img));
        form_data.append("fileFileName","avatar");

        mui.ajax(app.d.hostUrl + 'Wuser/avatarUpload', {
            data: form_data,
            type: 'post',
            dataType: 'json',
            contentType: false,
            processData: false,
            success:function(data){
                if(data.status==1){
                    page.img_obj.attr('src', img).cropper('destroy');
                    app.ls.save('avatar', img);
                    $('.mui-content').removeClass('ready-crop');
                }else{
                    mui.toast(data.msg);
                }
            },
        });
    },
    bindAction: function(){
        $("form").submit(function(e){
            e.preventDefault();
        });

        mui(".mui-content").on("tap", '#user-avatar', function(){
            page.file_obj = $(this).next();
            page.file_obj.click();
        });

        mui(".mui-content").on("tap", ".submit-crop", function(){
            var img_url = page.img_obj.cropper('getCroppedCanvas',{
                width:300, // 裁剪后的长宽
                height:300
            }).toDataURL('image/png');

            page.uploadAvatar(img_url, function(){
                page.saveImageURL = img_url;
                page.img_obj.attr('src', img_url).cropper('destroy');
                $('.mui-content').removeClass('ready-crop');
            });

        });

        mui(".mui-content").on("tap", ".cancel-crop", function(){
            page.img_obj.cropper('destroy').attr('src', page.saveImageURL);
            $('.mui-content').removeClass('ready-crop');
        });

        page.file_obj.change(function () {
            var files = this.files;
            var file;

            if (files && files.length) {
                file = files[0];
                // 判断是否是图像文件
                if (/^image\/\w+$/.test(file.type)) {
                    // 如果URL已存在就先释放
                    if (page.uploadedImageURL) {
                        URL.revokeObjectURL(page.uploadedImageURL);
                    }
                    page.uploadedImageURL = URL.createObjectURL(file);

                    page.img_obj.attr('src', page.uploadedImageURL).cropper(page.crop_options);
                    $('.mui-content').addClass('ready-crop');
                    page.file_obj.val('');
                } else {
                    mui.toast("请选择一张图片做头像");
                }
            }
        });
    },
};