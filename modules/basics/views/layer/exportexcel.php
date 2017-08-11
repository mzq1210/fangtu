<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        &times;
    </button>
    <h4 class="modal-title" id="myModalLabel">
        导出图层数据到excel表格
    </h4>
</div>
<form id="form_data_addItem">
    <div class="modal-body">
        <div class="text-center">
            <div class="tab-content">
                <div id="localUpload" class="tab-pane active" role="tabpanel">
                    <div id="file_upload_desc">
                        <div class="uploadifive-button btn btn-primary dt-mar12t" style="height: 36px; overflow: hidden; position: relative; text-align: center; width: 120px;">
                            选择数据
                            <input id="file" style="font-size: 36px; opacity: 0; position: absolute; right: -3px; top: -3px; z-index: 999;" type="file"></div>
                        <div class="uploadifive-queue"></div>
                        <div style="color:blue;display:none;" id="file_upload_desc_tip">已经选择数据</div>
                    </div>
                    <div class="dt-mar10t text-left dt-f12">
                        <p class="dt-mar4t"><b>格式说明</b>：支持Excel或CSV，字段不超过7个，文件行数不超过 行。</p>
                        <p class="dt-mar4t"><b>定位字段</b>：必须有地址字段或经纬度字段，以便在地图上自动定位。</p>
                        <p class="dt-mar4t">
                            <b>模板下载</b>：<a href="/data/Import_Format.xlsx">下载模板</a>
                        </p>
                    </div>
                </div>

                <div  id="progress_addItem" style="display: none">
                    <div style="width: 100%;height: 90px;">
                        <div style="padding: 10px 123px;">
                            <img style="float: left" src="/images/loading.gif" alt="">
                            <span style="line-height: 70px;font-size: 21px;" class="tip">数据解析处理中...</span>
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                            <span class="sr-only"> 100%</span>
                        </div>
                    </div>
                    <div style="width: 100%;height: 30px;line-height: 30px;text-align: center">
                        <span style="line-height: 70px;font-size: 14px;" id="addStoreStatus">共有0条数据记录，处理完成0条，请稍后</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <input type="hidden" name="layerid" id="layerFile" value="">
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeStatus()">关闭</button>
        <button type="button" onclick="sendFile()" class="btn btn-primary" id="submitUpload">提交</button>
    </div>
</form>