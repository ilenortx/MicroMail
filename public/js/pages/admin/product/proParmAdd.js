function addValItem(){
    var tr = $('<tr></tr>');
    var td = $('<td width="40%"><input type="text" class="input-text val-name" name="name" value="" /><input type="hidden" name="id" value=""></td><td class="val-del" width="20%"><select name="type" onchange="selChange(this)"><option value="text">输入文本</option><option value="select">下拉框</option></select></td><td width="25%" class="option_text"><input type="hidden" name="value" value=""></td><td class="val-del" width="15%"><a onClick="delValItem(this)">删除</a><i class="Hui-iconfont downBtn" onclick="downAction(this)">&#xe674;</i><i class="Hui-iconfont upBtn" onclick="upAction(this)">&#xe679;</i></td>');
    tr.append(td);
    $('#val-tab').append(tr);
}

function addOptionItem(){
    var tr = $('<tr class="val-tr"></tr>');
    var td = $('<td width="500px"><input class="input-text val-name" name="ov" value="" type="text" /></td><td class="val-del" width="100px"><a onClick="delValItem(this)">删除</a></td>');
    tr.append(td);
    $('#option-tab').append(tr);
}

function editOption(e){
    var option = $(e).data('option').toString().split('|');
    var html_text = '';

    for (var i in option) {
        if(option[i]){
            html_text += '<tr class="val-tr"><td width="500px"><input class="input-text val-name" name="ov" value="'+ option[i] +'" type="text" /></td><td class="val-del" width="100px"><a onClick="delValItem(this)">删除</a></td></tr>';
        }
    };
    $('#option-tab').html(html_text);

    layer.open({
        type: 1,
        area: ['700px', '450px'],
        fixed: false,
        maxmin: true,
        title: "设置选项",
        content: $('#option_colum'),
    });

    $('#option_colum').data('obj', $(e));
}

function delValItem(obj){
    $(obj).parents("tr").remove();
}

function upAction(e){
    if($(e).parents("tr").prev().length > 0){
        $(e).parents("tr").prev().before($(e).parents("tr"));
    }
}

function downAction(e){
    if($(e).parents("tr").next().length > 0){
        $(e).parents("tr").next().after($(e).parents("tr"));
    }
}

function dataSub(){
    var post_data = {
        name: $('[name="t_name"]').val(),
        id: $('[name="t_id"]').val(),
        option: [],
    };

    $('#val-tab tr').each(function(){
        if($(this).find('[name="name"]').val().trim() == ''){
            layer.msg("参数名不能为空!", {time: 2000});
            return;
        }

        post_data.option.push({
            id: $(this).find('[name="id"]').val(),
            name: $(this).find('[name="name"]').val(),
            type: $(this).find('[name="type"]').val(),
            value: $(this).find('[name="value"]').val(),
        });
    });

    $.ajax({
        url: '../ProductParm/savePramAttr',
        type: 'POST',
        dataType: 'json',
        data: post_data,
        success: function(data){
            if (data.status == 1){
                layer.msg('成功!', { icon: 6,time: 2000 }, function(){
                    window.history.go(-1);
                });
            }else layer.msg(data.msg, { icon: 5, time: 1000 });
        },
        error: function(){

        },
    });
}

function optionSubmit(){
    var form_data = $('#option_colum form').serialize();

    var str = form_data.replace(/ov=/g,'');
    var final_text = decodeURI(str.replace(/&/g, '|'));

    var e = $('#option_colum').data('obj');
    e.data('option', final_text).next().text(final_text).next().val(final_text);

    layer.closeAll();
    layer.msg('保存成功', {time: 1000});
}

function selChange(e){
    var sel_val = $(e).val();
    var obj = $(e).parents('tr').find('.option_text');

    if(sel_val == 'text'){
        obj.children().hide();
        obj.find('.option_show').html('').next().val('');
    }else if(sel_val == 'select'){
        var option_text = '<span class="edit_option" onclick="editOption(this)" data-option="">编辑选项</span><text class="option_show"></text><input type="hidden" name="value" value="">';
        if(obj.find('.edit_option').length > 0){
            var option_value = obj.find('.edit_option').data('option');
            obj.children().show();
            obj.find('.option_show').html(option_value).next().val(option_value);
        }else{
            obj.html(option_text);
        }
    }
}