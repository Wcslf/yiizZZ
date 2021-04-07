<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>权限树</title>
    <?php echo $this->renderFile('@app/modules/backend/views/layouts/css.php') ?>

    <script type="text/javascript" src="/backend/layuiadmin/tree/layui/layui.js"></script>

</head>
<body>
<div class="layui-container">
    <div class="layui-row">

        <div class="layui-col-md6 layui-col-md-offset1">
            <fieldset class="layui-elem-field layui-field-title">
                <legend>权限树</legend>
            </fieldset>

            <!-- 此扩展能递归渲染一个权限树，点击深层次节点，父级节点中没有被选中的节点会被自动选中，单独点击父节点，子节点会全部 选中/去选中 -->
            <form class="layui-form">

                <div class="layui-form-item">
                    <label class="layui-form-label">选择权限</label>
                    <div class="layui-input-block">
                        <div id="LAY-auth-tree-index"></div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" type="submit" lay-submit lay-filter="LAY-auth-tree-submit">提交</button>
                        <button class="layui-btn layui-btn-primary" type="reset">重置</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>

<script>
    layui.config({
        base: '/backend/layuiadmin/tree/layui_exts/',
    }).extend({
        authtree: 'authtree',
    });

    layui.use(['jquery', 'authtree', 'form', 'layer'], function(){
        var $ = layui.jquery;
        var authtree = layui.authtree;
        var form = layui.form;
        var layer = layui.layer;
        // 初始化
        $.ajax({
            url: '<?php echo \yii\helpers\Url::toRoute(['menu/tree','id'=>$id]) ?>',
            dataType: 'json',
            success: function(data){
                // 渲染时传入渲染目标ID，树形结构数据（具体结构看样例，checked表示默认选中），以及input表单的名字
                authtree.render('#LAY-auth-tree-index', data.data.trees, {
                    inputname: 'ids[]'
                    ,layfilter: 'lay-check-auth'
                    ,openall: true
                    ,'theme': 'auth-skin-default'
                    ,autowidth: true
                });
                authtree.on('change(lay-check-auth)', function(data) {
                    console.log('监听 authtree 触发事件数据', data);
                    // 获取所有节点
                    var all = authtree.getAll('#LAY-auth-tree-index');
                    // 获取所有已选中节点
                    var checked = authtree.getChecked('#LAY-auth-tree-index');
                    // 获取所有未选中节点
                    var notchecked = authtree.getNotChecked('#LAY-auth-tree-index');
                    // 获取选中的叶子节点
                    var leaf = authtree.getLeaf('#LAY-auth-tree-index');
                    // 获取最新选中
                    var lastChecked = authtree.getLastChecked('#LAY-auth-tree-index');
                    // 获取最新取消
                    var lastNotChecked = authtree.getLastNotChecked('#LAY-auth-tree-index');
                    console.log(
                        'all', all,"\n",
                        'checked', checked,"\n",
                        'notchecked', notchecked,"\n",
                        'leaf', leaf,"\n",
                        'lastChecked', lastChecked,"\n",
                        'lastNotChecked', lastNotChecked,"\n"
                    );
                });
                authtree.on('deptChange(lay-check-auth)', function(data) {
                    console.log('监听到显示层数改变',data);
                });
                authtree.on('dblclick(lay-check-auth)', function(data) {
                    console.log('监听到双击事件',data);
                });
            },
            error: function(xml, errstr, err) {
                layer.alert(errstr+'，获取样例数据失败，请检查是否部署在本地服务器中！111');
            }
        });
        // 表单提交样例
        form.on('submit(LAY-auth-tree-submit)', function(obj){
            var authids = authtree.getChecked('#LAY-auth-tree-index');
            var par = {};
            par['authids'] = authids;
            par['id'] = '<?php echo $user_id ?>';

           $.ajax({
                url: '<?php echo \yii\helpers\Url::toRoute('roles/auth-edit') ?>',
                dataType: 'json',
                data: par,
                success: function(res){
                    layer.alert('提交成功！',(res)=>{
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);//关闭当前弹窗页面
                    });


                }
            });
           return false;
        });
    });

</script>
</html>
