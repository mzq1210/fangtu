<?php
use yii\helpers\Url;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">区域编辑</h4>
</div>
<div class="modal-body">
    <div class="form-group" style="padding: 0 50px">
        <label class="control-label" style="width: 70px">区域名称: </label>
        <input type="text" class="ipt form-control" name="name" value="<?= $model->name;?>" style="width: 180px" size="30">
    </div>
    <div class="form-group" style="padding: 0 50px">
        <label class="control-label" style="width: 70px">备注: </label>
        <input type="text" class="ipt form-control" name="remark" value="<?= $model->remark;?>" style="width: 180px" size="30">
    </div>
    <input type="hidden" name="id" value="<?= $model->id;?>">
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
    <button type="button" class="btn btn-primary draw-edit">提交</button>
</div>
<script type="text/javascript">
$(function () {
    //新增图层
    $('.draw-edit').on('click', function(){
        var id = $('input[name=id]').val();
        var url="<?=Url::toRoute('/basics/draw/edit')?>?id="+id;
        var name = $('input[name=name]').val();
        var remark = $('input[name=remark]').val();
        $.post(url,{'name':name,'remark':remark},function(data){
            var info = JSON.parse(data);
            if(info.code == 200){
                toastr.success("修改成功");
                $('#editArea').modal('hide');
                setInterval("window.location.reload()",1000);
            }else{
                toastr.error("修改失败");
            }
        });
    });
});
</script>