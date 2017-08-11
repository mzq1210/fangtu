<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">用户登录</h4>
</div>
<form id="form_data_renameLayer">
    <div class="modal-body">
        <div class="modal-body">
            <label class="col-sm-3 control-label" style="line-height: 34px;width: 80px;">用户名: </label>
            <input type="text" class="ipt form-control" style="width: 180px"  name="username" id="username" />
        </div>
        <div class="modal-body">
            <label style="line-height: 34px;width: 80px;" class="col-sm-3 control-label">密&nbsp;&nbsp;&nbsp;&nbsp;码: </label>
            <input type="password" class="ipt form-control" style="width: 180px"  name="password" id="password" />
        </div>
        <div style="margin-left: 30px; color: #ff0000;" id="show_info"></div>
        <div class="modal-body">
            <button type="button" class="btn btn-info btn-sm" style="width:250px; margin-left: 16px; height: 36px; font-size: 16px;" >立即登录</button>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(function(){
        //点击立即登陆事件
        $('.btn-info').on('click',function(){
            var username = $('#username').val();
            var password = $('#password').val();
            if(!username || !password){
                $('#show_info').html('用户名和密码为必填');
            }else{
                $('.btn-info').html('登录中…').attr('disabled',true);
                var url = '<?php echo \yii\helpers\Url::toRoute('/default/login_ajax')?>';
                $.post(url, {'username':username, 'password':password}, function(data){

                    var userInfo = JSON.parse(data);
                    console.log(userInfo);
                    if(userInfo.code != 200){
                        $('.btn-info').html('立即登陆');
                        $('.btn-info').attr('disabled',false);
                        $('#show_info').html(userInfo.msg);
                    }else{
                        window.location.reload();
                    }
                });
            }
        });
    })
    $(document).keyup(function(event){
        if(event.keyCode ==13){
            $(".btn-info").click();
        }
    });
</script>

