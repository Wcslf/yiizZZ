
<?php
use \app\modules\backend\services\ViewService;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>内容列表</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <?php echo $this->renderFile(ViewService::css()) ?>
    <style>
        .layui-upload-img1{width: 120px; height: 70px; margin: 0 10px 10px 0;}
    </style>
    <style type="text/css">

        .layui-table-cell{

            text-align:center;

            height: auto;

            white-space: normal;

        }

    </style>
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">

        </div>

        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <button class="layui-btn layuiadmin-btn-list" data-type="add">添加</button>
            </div>
            <table id="LAY-app-content-list1" class="layui-table" lay-filter="LAY-app-content-list1" lay-size="lg">

                    <thead>
                    <tr>
                        <th>权限名称</th>
                        <th>规则表达式</th>
                        <th>是否显示</th>
                        <th>操作</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($parent as $k => $v): ?>
                    <tr>
                        <td><?php  for($i=0;$i<$v['le'];$i++): echo '&nbsp'; endfor; ?> <?php echo $v['name'] ?></td>

                        <td>
                            <?php echo $v['rules'] ?>
                        </td>

                        <td>
                            <form class="layui-form">

                                    <input  <?php echo $v['is_show']?'checked':''; ?> lay-filter="test" type="checkbox" id="<?php echo $v['id'] ?>" lay-skin="switch" lay-text="启用|不启用">

                            </form>
                        </td>



                        <td>

                            <a  class="layui-btn layui-btn-normal layui-btn-xs layuiadmin-btn-list" data-id="<?php echo $v['id'] ?>" data-type="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>

                            <a class="layui-btn layui-btn-danger layui-btn-xs layuiadmin-btn-list" data-id="<?php echo $v['id'] ?>" data-type="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
            </table>


        </div>
    </div>
</div>
<?php echo $this->renderFile(ViewService::js()) ?>
<script>


    layui.config({
        base: "<?php echo $this->renderFile(ViewService::assets()) ?>" //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'contlist', 'table'], function(){
        var table = layui.table
            ,form = layui.form;

        var tableid = 'LAY-app-content-list1'; //表ID


        //监听搜索
        form.on('submit(LAY-app-contlist-search)', function(data){
            var field = data.field;

            //执行重载
            table.reload(tableid, {
                where: field
            });
        });

        form.on('switch(test)', function(data){
            var id = $(data.elem).attr('id');

            http({
                url:"<?php echo ViewService::toUrl('sw') ?>",
                data: {
                    id:id,
                    checked:data.elem.checked,
                }
            })

        });


        var $ = layui.$, active = {
            del:function () {
                var id = $(this).attr('data-id');
                layer.confirm('确定删除吗？', function(index) {

                    http({
                        url:"<?php echo ViewService::toUrl('del') ?>",
                        data: {
                            id:id
                        },
                        scallback:(res)=>{
                            window.location.reload();
                        }
                    })

                });
            },
            edit: function(){

                console.log($(this).attr('data-id'));
                //打开页面
                openPage("<?php echo ViewService::toUrl('edit') ?>",(res)=>{

                    window.location.reload();
                    return false;
                },"id="+$(this).attr('data-id'))

            },

            add: function(){

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
