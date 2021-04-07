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
                    <label class="layui-form-label">权限名</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" placeholder="权限名"   value="<?php echo $data['name'] ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">分类</label>
                    <div class="layui-input-block">
                        <select name="parent_id" >
                            <option value="0" <?php echo  0==$data['parent_id']?'selected=selected':''; ?> >顶级分类</option>
                            <?php foreach ($parent as $k => $v): ?>
                                <option <?php echo  $v['id']==$data['parent_id']?'selected=selected':''; ?> value="<?php echo $v['id']; ?>"><?php  for($i=0;$i<$v['le'];$i++): echo '&nbsp'; endfor; ?><?php echo $v['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">排序</label>
                    <div class="layui-input-block">
                        <input type="number" name="sort" placeholder="排序"   value="<?php echo $data['sort'] ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">是否显示</label>
                    <div class="layui-input-block">
                        <input type="checkbox"   lay-filter="switch2"  <?php if($data['is_show']==1): ?>checked<?php endif; ?> value="1" lay-skin="switch" lay-text="开启|关闭">
                        <input type="hidden" name="is_show" value="<?php echo $data['is_show']?$data['is_show']:0; ?>" class="is_show" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">控制器</label>
                    <div class="layui-input-block">
                        <select lay-filter="select2">
                            <option value="0" >选择控制器</option>
                            <?php foreach ($controller as $k => $v): ?>
                                <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">方法</label>
                    <div class="layui-input-block">
                        <select  lay-filter="select3" id="action"></select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">规则表达式</label>
                    <div class="layui-input-block">
                        <input type="text" name="rules" id="rulesid" value="<?php echo $data['rules'] ?>" lay-verify="title" autocomplete="off" placeholder="规则表达式" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-layout-admin" >
                    <div class="layui-input-block">
                        <div class="layui-footer" style="left: 0;z-index: 101">
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
    }).use(['index', 'form', 'laydate', 'upload','colorpicker'], function(){
        var $ = layui.$
            ,admin = layui.admin
            ,element = layui.element
            ,layer = layui.layer
            ,laydate = layui.laydate
            ,upload = layui.upload
            ,colorpicker = layui.colorpicker
            ,form = layui.form;

        form.render(null, 'component-form-group');

        laydate.render({
            elem: '#LAY-component-form-group-date'
        });




        form.on('switch(switch2)', function(data){

            if(data.elem.checked){
                $('.is_show').val(1);
            }else{
                $('.is_show').val(0);
            }

        });
        form.on('select(select2)', function(data){

            http({
                url:"<?php echo ViewService::toUrl('get-action'); ?>",
                data:{
                    controller:data.value
                },
                scallback:(res)=>{
                    $('#action').html(res.data)
                    $val = $('#action').val();
                    $('#rulesid').val($val);
                    form.render();
                }
            })


        });
        form.on('select(select3)', function(data){

            $val = $('#action').val();
            $('#rulesid').val($val);


        });



        /* 监听提交 */
        form.on('submit(component-form-demo1)', function(data){

            http({
                url:"<?php echo ViewService::self(); ?>",
                data: data.field,
                scallback:(res)=>{
                    resultTip(res);
                }
            })

            return false;
        });


        $('.layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
</body>
</html>
