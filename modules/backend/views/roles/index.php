
<?php
use \app\modules\backend\services\ViewService;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>列表</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <?php echo $this->renderFile(ViewService::css()) ?>
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">标题</label>
                    <div class="layui-input-inline">
                        <input type="text" name="title" placeholder="请输入" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-list" lay-submit lay-filter="LAY-app-contlist-search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
<!--                <button class="layui-btn layuiadmin-btn-list" data-type="batchdel">删除</button>-->
                <button class="layui-btn layuiadmin-btn-list" data-type="add">添加</button>
            </div>
            <table id="LAY-app-content-list" lay-filter="LAY-app-content-list"></table>
            <script type="text/html" id="buttonTpl">
                {{#  if(d.status){ }}
                <button class="layui-btn layui-btn-xs">已发布</button>
                {{#  } else { }}
                <button class="layui-btn layui-btn-primary layui-btn-xs">待修改</button>
                {{#  } }}
            </script>
            <script type="text/html" id="table-content-list">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>

            </script>

            <script type="text/html" id="auth">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="auth"><i class="layui-icon layui-icon-edit"></i>权限管理</a>
            </script>
        </div>
    </div>
</div>

<?php echo $this->renderFile(ViewService::js()) ?>
<script>
    layui.config({
        base: '<?php echo $this->renderFile(ViewService::assets()) ?>' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'contlist', 'table'], function(){
        var table = layui.table
            ,form = layui.form;
        tableid = 'LAY-app-content-list';
        table.render({
            elem: '#'+tableid
            ,limit:10
            ,url: '<?php echo ViewService::toUrl('get-data') ?>' //数据接口
            ,page: true //开启分页
            ,cols: [[ //表头
                {checkbox: true},
                {field: 'name', title: '角色'}
                ,{field: 'remarks', title: '备注'}
                ,{fixed: 'right', title: '权限列表', align:'center', toolbar: '#auth'}
                ,{fixed: 'right', align:'center', toolbar: '#table-content-list'}
            ]]
        })


        //监听搜索
        form.on('submit(LAY-app-contlist-search)', function(data){
            var field = data.field;

            //执行重载
            table.reload(tableid, {
                where: field
            });
        });

        table.on('tool('+tableid+')', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"

            var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
            var data = obj.data;


            //编辑
            if(layEvent === 'edit'){


                //打开页面
                openPage("<?php echo ViewService::toUrl('edit') ?>",(res)=>{

                    reloadTable(tableid)
                    return false;
                },"id="+data.id)


            }

            if(layEvent === 'auth'){


                //打开页面
                openPage("<?php echo ViewService::toUrl('distribution') ?>",(res)=>{

                    reloadTable(tableid)
                    return false;
                },"id="+data.id)


            }







            //删除
            if(layEvent === 'del'){
                layer.confirm('确定删除吗？', function(index) {
                    http({
                        url:"<?php echo ViewService::toUrl('del') ?>",
                        data: {
                            id:data.id
                        },
                        scallback:(res)=>{
                            resultTip(res);
                            reloadTable(tableid)
                        }
                    })

                });

            }


        });


        var $ = layui.$, active = {
            batchdel: function(){
                var checkStatus = table.checkStatus(tableid)
                    ,checkData = checkStatus.data; //得到选中的数据


                if(checkData.length === 0){
                    return layer.msg('请选择数据');
                }



                layer.confirm('确定删除吗？', function(index) {
                    var id = [];
                    for(var i in checkData){
                        id.push(checkData[i]['id']);
                    }


                    http({
                        url:"<?php echo ViewService::toUrl('del') ?>",
                        data: {
                            id:id
                        },
                        scallback:(res)=>{
                            resultTip(res);
                            reloadTable(tableid)
                        }
                    })

                });
            },
            add: function(){

                console.log($(this).attr('data-id'));
                //打开页面
                openPage("<?php echo ViewService::toUrl('add') ?>",(res)=>{

                    window.location.reload();
                    return false;
                })
            }
        };

        $('.layui-btn.layuiadmin-btn-list').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });

    });
</script>
</body>
</html>
