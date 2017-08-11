<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">重命名图层</h4>
</div>
<form id="form_data_renameLayer">
    <div class="modal-body">
        <div class="modal-body">
            <label style="line-height: 34px" class="col-sm-3 control-label">图层名: </label>
            <input type="text" class="ipt form-control" style="width: 180px"  name="layername" value="<?php echo $name;?>" placeholder="<?php echo $name;?>" id="layerNameId"/>
            <span id="info-show"></span>
        </div>
        <input type="text" style="display:none">
    </div>
    <input type="hidden" name="layerid" id="renameLayerId" value="<?php echo $layerid;?>">
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" onclick="renameLayerTrue()" class="btn btn-primary">提交</button>
    </div>
</form>
<script>
    function renameLayerTrue() {
        $.ajax({
            type: "POST",
            url:"/basics/layer/renamelayer",
            data:$('#form_data_renameLayer').serialize(),// 序列化表单值
            async: false,
            error: function(request) {
                toastr.error("重命名失败");
            },
            success: function(data) {
                var data = JSON.parse(data);
                if(data.code==200){
                    $("#layerNameId"+data.data.id).html(data.data.name);
                    $('#renameLayer').modal('hide');
                    toastr.success("重命名成功");
                }else{
                    $('#renameLayer').modal('hide');
                    toastr.error("重命名失败");
                }
            }
        });
    }

</script>