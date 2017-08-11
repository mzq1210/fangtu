<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">信息框提示</h4>
</div>
<form id="form_data_setmsgbox">
    <div class="modal-body layer-infowindow-setting">
        <?php if(!empty($defined)):?>
            <?php foreach ($defined as $k=>$v):?>
                    <span class="dt-show dt-mar4b">
                         <input class="dt-checkbox" type="checkbox" data-name="名称"  <?php if ($k==1 or $k==2){echo 'checked="" onclick="return false"';}?>
                         <?php foreach ($msgbox as $key=>$value):?>  <?php if ($key==$k){ echo 'checked';}?><?php endforeach;?> name="<?=$k?>" value="<?=$v?>" style="margin-right:4px;margin-left:4px;">
                         <span class="dt-f14"><?=$v?></span>
                         <?php if ($k==1 or $k==2){ echo '<span class="dt-f12 color99">（该字段为必选字段，不能被隐藏）</span>';}?>
                    </span>

            <?php endforeach;?>
        <?php endif;?>
    </div>
    <input type="hidden" name="layerid" value="<?php echo $layerid;?>">
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" onclick="sendSet()" class="btn btn-primary">提交</button>
    </div>
</form>
<script>
    function sendSet() {
        $.ajax({
            type: "POST",
            url:"/basics/layer/setmsgbox_ajax",
            data:$('#form_data_setmsgbox').serialize(),// 序列化表单值  
            async: false,
            error: function(request) {
                alert("Connection error");
            },
            success: function(data) {
                var data = JSON.parse(data);
                if(data.code==200){
                    updateInfoboxFiled(data.data.layerid);
                    $('#editStore').modal('hide');
                    toastr.success(data.msg);
                }else{
                    $('#editStore').modal('hide');
                    toastr.error("设置失败");
                }
            }
        }); 
    }
    
</script>