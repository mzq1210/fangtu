<?php
use yii\helpers\Url;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">编辑</h4>
</div>
<form role="form" method="post" action="" style="padding: 10px 0">
    <div class="form-group" style="padding: 0 50px">
        <label class="control-label" style="width: 70px">经度：</label>
        <input type="text" class="ipt form-control" value="<?php echo $model['lat'];?>" style="width: 180px" size="30" name="lat">
    </div>
    <div class="form-group" style="padding: 0 50px">
        <label class="control-label" style="width: 70px">纬度：</label>
        <input type="text" class="ipt form-control" value="<?php echo $model['lng'];?>" style="width: 180px" size="30" name="lng">
    </div>
    <?php if(!empty($model['show_field'])):?>
        <?php foreach($model['show_field'] as $key => $value):?>
            <div class="form-group" style="padding: 0 50px">
                <label class="control-label" style="width: 70px"><?=$value['name']?>：</label>
                <input type="text" class="ipt form-control" value="<?=$value['value']?>" style="width: 180px" size="30" name="<?=$value['field']?>">
            </div>
        <?php endforeach;?>
    <?php endif;?>
    <input type="hidden" name="id" value="<?=$model['id']?>">
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-primary">提交</button>
    </div>
</form>
<script>
    $(function () {
        $('form').submit(function() {
            var id = $('input[name=id]').val();
            var params =$(this).serializeArray();
            $.post('/basics/edit/edit?id='+id, {'params': params}, function (data) {
                var info = JSON.parse(data);
                if (info.code == 200) {
                    $('#editStore').modal("hide");
                    var json = info.data;
                    if(infoBoxTemp){
                        infoBoxTemp.close();
                    }
                    var allOverlay = map.getOverlays();
                    for (var i = 0; i < allOverlay.length; i++){
                        if(json.id == allOverlay[i].marker_id){
                            allOverlay[i].remove();
                        }
                    }
                    toastr.success(info.msg);
                    createMarker.init(json);
                } else {
                    toastr.error("设置失败!");
                }
            });
            return false;
        });
    });
</script>