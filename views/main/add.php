<div class="modal-header bg-primary">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        &times;
    </button>
    <h4 class="modal-title">
        <i class="icon-pencil"></i>
        <span id="lblAddTitle" style="font-weight:bold">新建地图</span>
    </h4>
</div>
    <div class="modal-body form-horizontal">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">城市</label>
                    <div class="col-md-10">
                        <select class="ipt form-control" style="width: 180px" name="cityId" id="cityId">
                            <?php foreach ($city as $val):?>
                                <option <?php if($cityid == $val['city_id']) echo 'selected';?> value="<?php echo $val['city_id']?>"><?php echo $val['name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">名称</label>
                    <div class="col-md-10">
                        <input class="ipt form-control" style="width: 180px" placeholder="填写创建地图的名称" size="30" name="layoutdName" id="layoutdName" type="text">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary dosubmit-add">提交</button>
    </div>
</div>



<script type="text/javascript">
    $(function(){
        $('.dosubmit-add').on('click', function(){
            $('#addLayout').modal('hide');
            $.post('/main/add_ajax',{'cityid':$('#cityId').val(),'name':$('#layoutdName').val()}, function(data){
                var info = JSON.parse(data);
                if(info.code == 200){
                    toastr.success("添加成功");
                    setInterval("window.location.reload()",1000);
                }else{
                    toastr.error("添加失败");
                }
            });
        });
        $("#myModal").on("hidden.bs.modal", function() {
            $(this).removeData("bs.modal");
        });
    });

</script>