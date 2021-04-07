

<?php
use \app\modules\backend\services\ViewService;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>表单</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <?php echo $this->renderFile(ViewService::css()) ?>
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">操作内容</div>
        <div class="layui-card-body" style="padding: 15px;">
            <form class="layui-form" action="" lay-filter="component-form-group">
                <div class="layui-form-item">
                    <label class="layui-form-label">角色名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name"  value="<?php echo $data['name'] ?>" lay-verify="title" autocomplete="off" placeholder="角色名称" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">备注</label>
                    <div class="layui-input-block">
                       <textarea class="layui-input" name="remarks" style="height: 150px"><?php echo $data['remarks'] ?></textarea>
                    </div>
                </div>


                <div class="layui-form-item layui-layout-admin">
                    <div class="layui-input-block">
                        <div class="layui-footer" style="left: 0;">
                            <button class="layui-btn" lay-submit="" lay-filter="component-form-demo1">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="<?php echo $data['id'] ?>" name="id">
            </form>
        </div>
    </div>
</div>


<?php echo $this->renderFile(ViewService::js()) ?>
<script>
    layui.config({
        base:"<?php echo $this->renderFile(ViewService::assets()) ?>" //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form', 'laydate'], function(){
        var $ = layui.$
            ,admin = layui.admin
            ,element = layui.element
            ,layer = layui.layer
            ,laydate = layui.laydate
            ,form = layui.form;

        form.render(null, 'component-form-group');

        laydate.render({
            elem: '#LAY-component-form-group-date'
        });



        /* 监听提交 */
        form.on('submit(component-form-demo1)', function(data){

            http({
                url:"<?php echo ViewService::self() ?>",
                data: data.field,
                scallback:(res)=>{
                    resultTip(res);
                }
            })

            return false;
        });
    });
</script>
</body>
</html>
