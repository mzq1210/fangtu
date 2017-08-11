<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        &times;
    </button>
    <h4 class="modal-title" id="myModalLabel">
        分享
    </h4>
</div>
<div class="modal-body form-horizontal">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group col-sm-10">
                <span style="line-height: 45px;">复制地图链接，发送给好友  <span style="color: #E9880E;float: right;font-size: 12px;cursor: pointer;" onclick="copyLink()">复制链接</span></span>
                <input type="text" id="mapShareUrl" value="<?php echo $url; ?>" class="form-control" id="name" placeholder="请输入名称">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group col-sm-10">
                <span style="line-height: 45px;">复制JS代码嵌入到网站  <span style="color: #E9880E;float: right;font-size: 12px;cursor: pointer;" onclick="copyCode()">复制链接</span></span>
                <input type="text" id="mapShareCode" value="<iframe  width='600' height='400' frameBorder='0' src='<?php echo $url; ?>'></iframe>" class="form-control" id="name" placeholder="请输入名称">
            </div>
        </div>
        <!--<div class="col-md-12">
            <div class="form-group col-sm-10">
                <span style="text-align: center">扫一扫，微信中浏览并分享地图：</span>
                <span style="text-align: center" ><img alt="Scan me!" src="/qrcode/<?php /*echo md5($id); */?>.png"></span>
            </div>
        </div>-->
    </div>
</div>
</div>

<script>
function copyLink(){
    $("#mapShareUrl")[0].select();
    document.execCommand("Copy");
}
function copyCode(){
    $("#mapShareCode")[0].select();
    document.execCommand("Copy");
}
</script>
