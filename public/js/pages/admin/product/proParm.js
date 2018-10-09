$(document).ready(function(){
    layui.use('table', function(){
        var table = layui.table;

        table.render({
            elem: '#userListDataTables',
            url: '../ProductParm/getAllParm',
            toolbar: true,
            defaultToolbar: [],
            title: '用户数据表',
            height:'full-70',
            cols: [[
                {field:'id', title:'ID', width:80, unresize: true, sort: true},
                {field:'t_name', title:'类型名称', unresize: true,},
                {field:'control', title:'操作', unresize: true,}
            ]],
            page: true,
            parseData: function(res){
                for (var i = 0; i < res.data.length; i++) {
                    res.data[i].control = '<a title="编辑" href="../ProductParm/proParmAddPage?id='+ res.data[i].id +'" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont"></i></a><a title="删除" href="javascript:;" onclick="admin_del(this,'+ res.data[i].id +')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont"></i></a>';
                };

                return {
                    "code": res.code,
                    "msg": res.msg,
                    "count": res.total,
                    "data": res.data,
                };
            }
        });
    });
});