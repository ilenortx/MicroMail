$(document).ready(function(){
    layui.use('element', function(){
        var $ = layui.jquery, element = layui.element;
    });

    layui.use(['form', 'table'], function(){
        form = layui.form; table = layui.table;
    });

    $(document).on('click','.save_btn',function(event) {
        var form_data = $('form').serializeArray();

        var post_data = {};
        for (var i in form_data) {
            post_data[form_data[i]['name']] = form_data[i]['value'];
        };

        $.post('../Member/add', post_data,function(data) {
            if(data.status==1){
                layer.msg('保存成功', {icon: 6});
            }else{
                layer.msg(data.msg, {icon: 5});
            }
        },'json');
    });
});