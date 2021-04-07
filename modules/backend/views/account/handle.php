

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>表单</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <?php echo $this->renderFile('@app/modules/backend/views/layouts/css.php') ?>


</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">操作内容</div>
        <div class="layui-card-body" style="padding: 15px;">
            <form class="layui-form" action="" lay-filter="component-form-group">
                <div class="layui-form-item">
                    <label class="layui-form-label">使用人</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" placeholder="使用人"   value="<?php echo $data['name'] ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">登录账号</label>
                    <div class="layui-input-block">
                        <input type="text" name="account" placeholder="登录账号(唯一)"   value="<?php echo $data['account'] ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-form-item">
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-block">
                        <input type="text" name="password" placeholder="登录密码"   autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">角色</label>
                    <div class="layui-input-block">
                        <select name="roles_id" >
                            <?php foreach ($roles as $k => $v): ?>
                                <option <?php echo  $v['id']==$data['roles_id']?'selected=selected':''; ?> value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>




                <div class="layui-form-item">
                    <label class="layui-form-label"> 是否禁用</label>
                    <div class="layui-input-block">
                        <input type="checkbox"   lay-filter="switch"  <?php if($data['is_prohibit']==1): ?>checked<?php endif; ?> value="1" lay-skin="switch" lay-text="开启|关闭">
                        <input type="hidden" value="<?php echo $data['is_prohibit']? $data['is_prohibit']:0; ?>" name="is_prohibit" class="is_prohibit" >
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


<?php echo $this->renderFile('@app/modules/backend/views/layouts/js.php') ?>
<script>
    layui.config({
        base:"<?php echo $this->renderFile('@app/modules/backend/views/layouts/assets.php') ?>" //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form', 'laydate', 'upload'], function(){
        var $ = layui.$
            ,admin = layui.admin
            ,element = layui.element
            ,layer = layui.layer
            ,laydate = layui.laydate
            ,upload = layui.upload
            ,form = layui.form;

        form.render(null, 'component-form-group');

        laydate.render({
            elem: '#LAY-component-form-group-date'
        });







        var active = {
            delimg: function(){


            }
        };

        form.on('switch(switch)', function(data){

            if(data.elem.checked){
                $('.is_prohibit').val(1);
            }else{
                $('.is_prohibit').val(0);
            }

        });




        /* 监听提交 */
        form.on('submit(component-form-demo1)', function(data){

            http({
                url:"<?php echo \app\lib\services\RequestService::self() ?>",
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
