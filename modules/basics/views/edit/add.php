<?php
use yii\helpers\Url;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">添加标注</h4>
</div>
<form role="form" method="post" action="" style="padding: 10px 0">
    <div class="form-group" style="padding: 0 50px">
        <label class="control-label" style="width: 92px">所属图层:</label>
        <select class="ipt form-control select-layer" style="width: 180px" name="layerid" id="">
            <option value="0">--请选择--</option>
            <?php if(!empty($layer) && is_array($layer)):?>
                <?php foreach ($layer as $value):?>
                    <option value="<?= $value['id'];?>"><?= $value['name'];?></option>
                <?php endforeach;?>
            <?php endif;?>
        </select>
    </div>
    <div class="fields"></div>
    <div class="form-group" style="padding: 0 50px">
        <label class="control-label" style="width: 92px">经度:</label>
        <input type="text" class="ipt form-control" value="<?= $lng;?>" style="width: 180px" size="30" name="lng" readonly>
    </div>
    <div class="form-group" style="padding: 0 50px">
        <label class="control-label" style="width: 92px">纬度:</label>
        <input type="text" class="ipt form-control" value="<?= $lat;?>" style="width: 180px" size="30" name="lat" readonly>
    </div>
    <input type="hidden" name="layoutid" value="<?= $layoutid;?>">
    <div class="modal-footer dt-none">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-primary">提交</button>
    </div>
</form>
<script>
    $(function () {
        $('.select-layer').change(function() {
            var layerid = $(this).val();
            if(layerid != 0){
                $('.modal-footer').removeClass('dt-none');
                $.post('/basics/edit/getfield', {'layerid': layerid}, function (data) {
                    var info = JSON.parse(data);
                    if (info.code == 200) {
                        var str = ''; var is_set = '';
                        $.each(info.data,function(key,value){
                            str += '<div class="form-group" style="padding: 0 50px">'+
                                '<label class="control-label" style="width: 95px">';
                            if(key == 1 || key ==2){
                                str += '<span class="glyphicon glyphicon-asterisk" style="color: red;"></span>&nbsp;&nbsp;';
                            }
                            str += value.name+':</label><input type="text" class="ipt form-control" value="" style="width: 180px" size="30" name="'+value.field+'"> </div>';
                        });
                        $('.fields').html(str);
                    } else {
                        toastr.error("添加失败!");
                    }
                });
            }else{
                $('.modal-footer').addClass('dt-none');
                $('.fields').html('');
            }
            return false;
        });

        $('form').on('blur', 'input[name=name], input[name=address]', function () {
            if($(this).val() != ''){
                $(this).parent().removeClass('has-error').addClass('has-success');
            }else{
                $(this).parent().addClass('has-error');
                toastr.error("该项不能为空!");
            }
        });

        $('form').submit(function() {
            if($('input[name=name]').val() == ''){
                $('input[name=name]').parent().addClass('has-error');
                toastr.error("名称不能为空!");return false;
            }else{
                $('input[name=name]').parent().removeClass('has-error');
            }
            if($('input[name=address]').val() == ''){
                $('input[name=address]').parent().addClass('has-error');
                toastr.error("地址不能为空!");return false;
            }else{
                $('input[name=address]').parent().removeClass('has-error');
            }

            var layoutid = $('input[name=layoutid]').val();
            var params =$(this).serializeArray();
            $.post('/basics/edit/addmarker?layoutid='+layoutid, {'params': params}, function (data) {
                var info = JSON.parse(data);
                var lng = $('input[name=lng]').val();
                var lat = $('input[name=lat]').val();
                var name = $('input[name=name]').val();
                if (info.code == 200) {
                    toastr.success("添加成功!");
                    $('#addMarker').modal("hide");
                    createMarker.init(info.data);
                    var ss = '<li class="select_marker dt-truncate Slist layer-store'+info.data.layerid+'" index="'+info.data.id+'"><img class="select_marker" src="/icons/default/'+info.data.ico+'"> <span class="select_marker marker-title dt-f12 storeList" index="'+info.data.id+'" title="'+name+'">'+ name +'</span></li>';
                    $('#layerid'+info.data.layerid).append(ss);
                    var num = parseInt($('#layerStoreNum'+info.data.layerid).html());
                    $('#layerStoreNum'+info.data.layerid).html(num+1);
                } else {
                    toastr.error("设置失败!");
                }
            });
            return false;
        });
    });
</script>