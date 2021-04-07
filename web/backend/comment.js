
// 请求
function http(par){
    var admin = layui.$;
    var layer = layui.layer
    var type = 'POST';

    if(par['type']){
        type = par['type'];
    }
    var index = layer.load(2, {time: false}); //又换了种风格，并且设定最长等待10秒

    admin.ajax({
            url:  par.url,
            type:type
            ,data: par.data
            ,success: function(res){
            layer.close(index);
            if(res.error_code == 0){
                par.scallback && par.scallback(res);
            }else{
                console.log(res.msg);
                layer.msg(res.msg, {icon: 5});
            }
        }
    });
}
//成功执行
function resultTip(res) {

    if(res.error_code == 0){
        layer.msg(res.msg,{
            time: 500
        }, function(){
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);//关闭当前弹窗页面
        });
    }
}
//打开页面 endCallback 关闭页面后执行
function openPage(url,endCallback,where,area) {
    var openarea = ['90%', '90%'];
    if(area){
        openarea = area;
    }
    if(where){
        url =  url+'?'+where;
    }
    layer.open({
        type: 2
        ,title: '操作数据'
        ,content:url
        ,area:openarea
        ,shade: false
        ,maxmin: true
        ,end: function(index, layero){
            endCallback && endCallback(index, layero);
        }
    });
}
//刷新表格
function reloadTable(tableid) {
    var table = layui.table
    table.reload(tableid);
}
//检查权限
function checkAuth(event,layEvent="lay-event") {

    var $ = layui.$;
    disabled = false;

    $('.layui-btn-disabled').each(function(){
        var that = $(this).attr(layEvent);
        if(that){
            if(that == event){
                disabled = true;
            }
        }

    });

    return disabled;

}
//提示
function tip(msg) {
    layer.msg(msg);
}