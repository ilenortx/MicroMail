$(document).ready(function(){
    layui.use('table', function(){
        var table = layui.table;

        table.render({
            elem: '#userListDataTables',
            url: '../Member/getList',
            toolbar: '#proTableToolbar',
            defaultToolbar: [],
            title: '用户数据表',
            height:'full-70',
            cols: [[
                {field:'id', title:'ID', width:80, unresize: true, sort: true},
                {field:'name', title:'用户昵称', unresize: true,},
                {field:'jifen', title:'积分', unresize: true,},
                // {field:'lv', title:'会员等级', unresize: true,},
                {field:'source', title:'用户来源', unresize: true,},
                {field:'tel', title:'手机号码', unresize: true,},
                {field:'control', title:'操作', unresize: true,}
            ]],
            page: true,
            parseData: function(res){
                for (var i = 0; i < res.data.length; i++) {
                    res.data[i].control = '<a title="编辑" href="../Member/addpage?id='+ res.data[i].id +'" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a><a title="删除" href="javascript:;" onclick="user_del(this,'+ res.data[i].id +')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';
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