<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">添加图层</h4>
</div>
<div class="modal-body">
    <label style="line-height: 34px" class="col-sm-3 control-label">图层名称: </label>
    <input type="text" class="form-control" style="width: 180px" id="layername" name="layername" value="" placeholder="标注图层"/>
    <span id="info-show"></span>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
    <button type="button" class="btn btn-primary create-layer">提交</button>
</div>
<script type="text/javascript">
$(function () {
    //新增图层
    $('.create-layer').on('click', function(){
        var url = '/basics/layer/createlayer_ajax';
        var layername = $('#layername').val();
        var layoutid = $('#layoutid').val();
        if(!layername){
            $('#info-show').html('名称不能为空');
            return false;
        }
        $.post(url,{'name':layername,'layoutid':layoutid},function(data){

            var info = JSON.parse(data);
            $('#setLayerStyle').modal('hide');
            if(info.code == 200){
                toastr.success("添加成功");
                setInterval("window.location.reload()",1000);
            }else{
                toastr.error("添加失败");
            }
        });
        $('#create-layer').modal('hide');
    });
});
</script>