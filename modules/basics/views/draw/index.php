<?php
use yii\helpers\Url;

?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0,user-scalable=0">
    <title>区域图-房图</title>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=jo2N0X0PdOeZVPURz2bXvpcO"></script>
    <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <!--<script src="http://cdn.bootcss.com/bootstrap/3.2.0/js/tooltip.js"></script>-->
    <script src="/js/tooltip.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" media="all" href="/css/application.css">
    <link rel="stylesheet" media="all" href="/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" media="screen" href="/css/map_edit.css">
    <link rel="stylesheet" media="screen" href="/css/colpick.css">
    <link rel="stylesheet" media="all" href="/css/toastr.min.css"/>
    <link rel="stylesheet" media="screen" href="/css/style.css">
    <script type="text/javascript" src="/js/colpick.js"></script>
    <script src="/js/dialog.js"></script>
    <script src="/js/map.Tools.js"></script>
    <!--<script src="http://cdn.bootcss.com/toastr.js/2.1.1/toastr.min.js"></script>-->
    <script src="/js/toastr.min.js"></script>
    <!--计算区域工具-->
    <script type="text/javascript" src="http://api.map.baidu.com/library/GeoUtils/1.2/src/GeoUtils_min.js"></script>
    <!--测距工具-->
    <script type="text/javascript"
            src="http://api.map.baidu.com/library/DistanceTool/1.2/src/DistanceTool_min.js"></script>
    <!--绘制工具-->
    <script type="text/javascript"
            src="http://api.map.baidu.com/library/DrawingManager/1.4/src/DrawingManager_min.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/library/InfoBox/1.2/src/InfoBox.js"></script>
    <script type="text/javascript">
        //提示框居中
        $(function () {
            toastr.options = {
                closeButton: false,
                debug: true,
                progressBar: false,
                positionClass: "toast-top-center",
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            };
        })
    </script>
</head>
<body>
<div id="content">
    <div class="dt-w100per dt-h48 dt-bg-blue3A dt-pos-a dt-z10">
        <div class="dt-w380 dt-h48 pull-left dt-pad16x dt-pos-r">
            <a href="/main">
                <img class="dt-mar12t" title="返回到首页" src="/images/logo60X24.png" width="60" height="24">
            </a>
        </div>
    </div>
    <div class="map-info">
        <div class="left-slider">
            <div class="nav-slider-bg"></div>
            <ul class="plug-list">
                <li class="map-layers slider-active" data-select="map-layers">
                    <span class="glyphicon glyphicon-th-list"></span>
                    <span>图层</span>
                </li>
            </ul>
        </div>
        <div class="drag-panel">
            <div class="drag-title dt-h30 dt-pad6x">
                <span class="glyphicon glyphicon-sort"></span>
                <p>图层排序</p>
            </div>
            <div class="drag-features">

            </div>
            <div class="dt-pos-a style-btn-group">
                <a href="###" class="btn btn-primary pull-right dt-w80 submit-layer-sorts">应用</a>
                <a href="###" class="btn btn-default pull-left dt-w80 drag-back">返回</a>
            </div>
        </div>


        <div id="mapInfoWrapper">
            <div id="featureListPanel" class="slider-bar">
                <div class="dt-pad6x count">
                    <div id="map-desc-bar" class="color66 dt-none"></div>
                    <div style="height: 31px">
                        <span
                            class="glyphicon glyphicon-chevron-down all-layer-status dt-mar6r dt-super dt-pointer"></span>
                        <span class="black dt-super dt-f14 dt-line-32h">
                            <span id="featureCount"><?php echo count($data);?>个省市区域</span>
                        </span>
                    </div>
                </div>

                <script>
                    $(".all-layer-status").click(function (t) {
                        if ($(t.target).hasClass("glyphicon-chevron-up")) {
                            $("#featureListPanelBorder").find(".layer-panel-status").addClass('dt-none');
                            $(t.target).removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");
                        } else {
                            $("#featureListPanelBorder").find(".layer-panel-status").removeClass('dt-none');
                            $(t.target).removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up")
                        }
                    });
                </script>
                <div id="featureListPanelBorder">
                    <?php if (!empty($data)): ?>
                        <?php foreach ($data as $key => $city): ?>
                            <div id="layerContainer" class="pull-left cityid<?= $city['id'] ?>" style="width: 325px;">
                                <div class="layer dt-pos-r">
                                    <div class="mlayer dt-pos-a dt-h100per dt-pos-t0"></div>
                                    <div class="dt-h30 dt-pad4x dt-mar4y layer-top">
                                        <span
                                            class="glyphicon display_layer pull-left dt-mar6r dt-mar8t mklayer dt-mar8t"></span>
                                        <div class="dt-w140 dt-truncate pull-left layer_title dt-mar6t"
                                             id="<?= $city['city_id'] ?>" lng="<?= $city['lng'] ?>" lat="<?= $city['lat'] ?>"><?= $city['name'] ?>
                                        </div>
                                        <div title="标注图层1"
                                             class="dt-w140 edit-layer-title dt-truncate pull-left dt-mar6t dt-none">
                                            <input value="标注图层1" class="form-control edit-layer-title-input dt-h20"
                                                   type="text">
                                        </div>
                                        <div class="layer_action numIcon">
                                            <span><?php echo count($city->area);?></span>
                                        </div>
                                    </div>
                                    <div class="layer-panel-status dt-none">
                                        <ul class="list-unstyled dt-pad20x dt-pad12y area<?=$city['id']?>">
                                            <?php if(!empty($city->area)):?>
                                                <?php foreach ($city->area as $area):?>
                                                    <li class="dt-truncate Slist select_marker" index="<?=$area->id;?>">
                                                        <?php if($area->type == 2):?>
                                                            <div class="dt-mar5y dt-mar8x pull-left" style="width: 14px;height: 14px;border:1px solid #ff0000;background-color:rgba(255, 0, 0, 0.2);border-radius:7px;"></div>
                                                        <?php elseif($area->type == 3):?>
                                                            <div class="dt-mar5 pull-left" style="height: 14px;border:4px solid #1087bf;background-color:rgba(16,135,191,0.8)"></div>
                                                        <?php else:?>
                                                            <div class="dt-mar5 pull-left" style="width: 20px;height: 14px;border:1px solid #ff0000;background-color:rgba(255, 0, 0, 0.2);"></div>
                                                        <?php endif;?>
                                                        <span class="marker-title dt-f12" ><?=$area->name;?></span>
                                                    </li>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="map-info-tab">
        <div class="mapinfo-but-con">
            <span></span>
        </div>
    </div>
    <div class="map-show">
        <a class="glyphicon glyphicon-th color99 dt-f18 dt-pos-f set-mapstyle"
           style="cursor: pointer; color:#aaa;right:6px;top:56px" title="帮助"></a>
        <div class="dt-pos-f map_style dt-none">
            <a href="javascript:changeMapStyle('normal')" class="style-img1"><span>默认样式</span></a>
            <a href="javascript:changeMapStyle('light')" class="style-img2"><span>清新蓝</span></a>
            <a href="javascript:changeMapStyle('dark')" class="style-img3"><span>黑夜</span></a>
            <a href="javascript:changeMapStyle('redalert')" class="style-img4"><span>红色警戒</span></a>
            <a href="javascript:changeMapStyle('googlelite')" class="style-img5"><span>精简</span></a>
            <a href="javascript:changeMapStyle('grassgreen')" class="style-img6"><span>自然绿</span></a>
            <a href="javascript:changeMapStyle('midnight')" class="style-img7"><span>午夜蓝</span></a>
            <a href="javascript:changeMapType('hybrid')" class="style-img8"><span>卫星图</span></a>
            <a href="javascript:changeMapStyle('bluish')" class="style-img9"><span>清新蓝绿</span></a>
        </div>
        <div class="map-nav-bar">
            <div class="dt-z10 dt-hidden dt-h32 city-list" id="dtwyCityList"></div>
            <div id="drawingToolbar">
                <div id="panBtn" class="icons" onclick="toolsClose()"></div>
                <div id="distanceBtn" onclick="Tools.distanceTool.open()" class="icons"></div>
                <div class="line-right"></div>
                <div id="addLineBtn" onclick="addLine()" class="icons draw-btn"></div>
                <div id="addRegionBtn" onclick="addRegion()" class="icons draw-btn"></div>
                <div id="addCircleBtn" onclick="addCircle()" class="icons draw-btn"></div>
                <div class="line-right"></div>
            </div>

            <div id="mapContainer" style="z-index: 0; height: 837px; width: 1540px; position: relative;"></div>
        </div>
    </div>
</div>
<input type="hidden" name="cityid" id="cityId" value="<?php echo $cityId;?>">
<input type="hidden" name="layoutid" id="layoutid" value="0">
<input type="hidden" name="userid" id="userid" value="<?php echo $userid;?>">
<div id="dialogContent"></div>

<script type="text/javascript">
    var sServer = 'ws://<?php echo HOST?>:<?php echo PORT ?>';
    var isedit = true; var issearch = false;
    var map = new BMap.Map("mapContainer", {enableMapClick: false});    // 创建Map实例
    (function (cityName) {
        map.centerAndZoom(cityName, 12);  // 初始化地图,设置中心点坐标和地图级别
        map.enableScrollWheelZoom();
        map.enableDoubleClickZoom(); //禁用双击放大。
        map.setMinZoom(6);
        map.setMaxZoom(16);
        Tools.init(map, cityName);
    })('<?=$cityName?>');

    (function () {
        $.ajax({
            type: 'post',
            url: '/basics/draw/getall',
            data: {},
            dataType: 'json',
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    var json = data[i]; var obj = {};
                    if (json.type == circleType) {
                        obj = Tools.addCircle(json);
                    } else if (json.type == polylineType) {
                        obj = Tools.addLine(json);
                    } else if (json.type == polygonType) {
                        obj = Tools.addPolygon(json);
                    }
                    Event.click(obj, json);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('网络错误！请重试……');
            }
        });
    })();

    $(".layer-top").click(function () {
        var cityid = $(this).find('.layer_title').attr('id');
        $('input[name=cityid]').val(cityid);
        var lng = $(this).find('.layer_title').attr('lng');
        var lat = $(this).find('.layer_title').attr('lat');
        map.panTo(new BMap.Point(lng, lat), 2000);
        $(".mlayer").removeClass('active-layer');
        $(this).prev().addClass('active-layer');
        if ($(this).next().hasClass('dt-none')) {
            $(this).next().removeClass('dt-none');
        }else{
            $(this).next().addClass('dt-none');
        }
        //控制图层全部显隐时倒三角的变化
        var i = 0;
        var layerEles = $("#featureListPanelBorder").find(".layer-panel-status");
        layerEles.each(function(index, domEle){
            if(!$(domEle).hasClass('dt-none')){ i++; }
        });
        if(i == layerEles.length){
            $(".all-layer-status").removeClass("glyphicon-chevron-down");
            $(".all-layer-status").addClass("glyphicon-chevron-up");
        }else{
            $(".all-layer-status").removeClass("glyphicon-chevron-up");
            $(".all-layer-status").addClass("glyphicon-chevron-down");
        }
    });

    //点击区域打开弹窗
    $("#featureListPanelBorder").on("click",".Slist",function(){
        var id = $(this).attr("index");
        $.ajax({
            "type":"POST",
            "url":"<?=Url::toRoute('/basics/draw/getinfo_ajax')?>",
            "dataType":"json",
            "data":{id:id},
            "success":function(data){
                Tools.openInfo(data.data);
            }
        });
    });
</script>
<script src="/js/map.js"></script>
</body>
</html>
