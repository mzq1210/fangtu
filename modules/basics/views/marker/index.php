<?php

use yii\helpers\Url;
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
        <meta name="renderer" content="webkit">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0,user-scalable=0">
        <title><?php echo $layoutName; ?>-房图</title>
        <meta name="keywords" content="">
        <meta name="description" content="">
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=jo2N0X0PdOeZVPURz2bXvpcO"></script>
        <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="/js/map.marker.js"></script>
        <script src="/js/map.Tools.js"></script>
        <script src="/js/dialog.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/toastr.min.js"></script>
        <!--测距工具-->
        <script type="text/javascript" src="http://api.map.baidu.com/library/DistanceTool/1.2/src/DistanceTool_min.js"></script>
        <!--绘制工具-->
        <script type="text/javascript" src="http://api.map.baidu.com/library/DrawingManager/1.4/src/DrawingManager_min.js"></script>
        <!--计算区域工具-->
        <script type="text/javascript" src="http://api.map.baidu.com/library/GeoUtils/1.2/src/GeoUtils_min.js"></script>
        <script type="text/javascript" src="http://api.map.baidu.com/library/InfoBox/1.2/src/InfoBox.js"></script>
        <link rel="stylesheet" media="all" href="/css/application.css">
        <link rel="stylesheet" media="screen" href="/css/map_viewer.css">
        <link rel="stylesheet" media="screen" href="/css/style.css">
        <link rel="stylesheet" media="all" href="/css/toastr.min.css"/>
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
    <body data-role="none">
        <div id="content">
            <div class="viewer-header dt-h32 dt-pos-a dt-z10 dt-border-1b dt-border-1r" <?php if(!is_numeric($_GET['layoutid'])):?>style="left:-326;"<?php endif;?>>
                <div class="pull-left dt-pad8x">
                    <a href="/">
                        <img class="dt-mar4t" src="/images/blue_logo.png" alt="Blue logo" width="15" height="21">
                    </a>
                </div>
                <div class="pull-left edit-title">
                    <div id="map-title-bar" class="pull-left dt-line-32h dt-f16 dt-truncate" style="max-width: 274px;"><?php echo $layoutName; ?>
                    </div>
                </div>
                <div class="pull-right dt-mar12r">
                    <span class="glyphicon glyphicon-info-sign dt-pointer pull-right dt-mar8t colorcc" id="mapInfo"></span>
                </div>
            </div>
            <!-- Share Modal -->
            <div class="modal" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true" class="dt-f22">×</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">分享/嵌入</h4>
                        </div>
                        <div class="modal-body">
                            <ul class="nav nav-tabs" role="tablist" id="shareTab">
                                <li role="presentation" class="active"><a href="#mapLink" role="tab" data-toggle="tab">分享</a>
                                </li>
                                <li role="presentation"><a href="#embedLink" role="tab" data-toggle="tab">嵌入</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="mapLink">
                                    <span class="dt-show">地图分享链接，以方便他人直接查看地图</span>
                                    <input id="shareUrl" class="form-control dt-w500 dt-h30 pull-left" value="" type="text">
                                    <a id="copyLink" style="position: relative" class="btn btn-default btn-sm dt-mar12l">复制
                                        <span class="copy_success" style="width: 65px; top: -20px; display: none;">复制成功</span>
                                    </a>
                                    <div class="text-center dt-mar24x dt-mar24y" style="min-height: 140px">
                                        <img src="" width="120">
                                        <p>该网页二维码</p>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="embedLink">
                                    <span class="dt-show">地图嵌入链接，复制JS代码将地图嵌入网站</span>
                                    <input id="embedUrl" class="form-control dt-w500 dt-h30 pull-left" value="&lt;iframe  width='100%' height='100%' frameBorder='0' src='https://www.dituwuyou.com/map/3g7Jg2ex3IMtwwCfJRpr-w/embed?base_map=normal&amp;center=119.839992%2C32.106413&amp;level=10'&gt; &lt;/iframe&gt;" type="text">
                                    <a id="copyLink1" style="position: relative" class="btn btn-default btn-sm dt-mar12l">复制
                                        <span class="copy_success" style="width: 65px; top: -20px; display: none;">复制成功</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">确定</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Print Modal -->
            <div class="modal" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true" class="dt-f22">×</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">打印</h4>
                        </div>
                        <div class="modal-body" style="text-align: center;">
                            <h3>打印需要付费，请联系客服QQ:
                                <a class="contact-us-qq" target="_blank"
                                   href="http://wpa.qq.com/msgrd?v=3&amp;uin=2085164991&amp;site=qq&amp;menu=yes"
                                   title="联系在线客服">
                                    2085164991
                                </a>
                            </h3>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="print">确定</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade bs-example-modal-sm" id="mapInfoModal" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">地图信息</h4>
                        </div>
                        <div class="modal-body">
                            <p class="dt-f14">名称：&nbsp;我的第一幅地图</p>
                            <p class="dt-f14 dt-mar4t">描述：&nbsp;</p>
                            <p class="dt-mar4t"><span class="dt-f14">创建人：&nbsp;咔咔瓦</span></p>
                            <p class="dt-mar4t"><span class="dt-f14">创建时间：&nbsp;2016-12-26 09:20</span></p>
                            <p class="dt-mar4t"><span class="dt-f14">图层和记录数：&nbsp;3个图层361条记录</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="map-info" <?php if(!is_numeric($_GET['layoutid'])):?>style="left: -326px;"<?php endif;?>>
                <div id="mapInfoWrapper">
                    <div id="featureListPanel">
                        <div class="dt-pad10x count">
                            <div class="dt-hidden" style="height: 31px;">
                                <div class="pull-left dt-line-32h">
                                    <span class="glyphicon glyphicon glyphicon-list dt-mar6r"></span>
                                    <?php echo $layer_num; ?>个图层<span id="featureCount"><?php echo $store_num; ?></span>条记录
                                </div>
                            </div>
                        </div>
                        <div id="featureListPanelBorder" style="overflow-y: auto">
                            <?php if (!empty($layer_info)): ?>
                                <?php foreach ($layer_info as $key => $layer): ?>

                                    <div id="layerContainer">
                                        <div class="marker_layer dt-pos-r" data-layer-label="null" data-marker-title="名称" data-show-fields="名称,地址,电话">
                                            <div class="dt-h30 layer-top" layer-id="<?= $layer['id'] ?>" is_show="<?= $layer['is_show'] ?>" >
                                                <div class="layer_action numIcon" id="layerStoreNum<?= $layer['id'] ?>" style="background-image: url('/icons/default/<?php if (!empty($layer['ico'])): ?><?= $layer['ico'] ?><?php else: ?>ff0000-s-null.png<?php endif; ?>');<?php if(strstr($layer['ico'] , '_marker')){ echo "background-size:18px 18px";}?>">
                                                    <span><?php echo $layer['layerStoreNum']; ?></span>
                                                </div>
                                                <span class="glyphicon display_layer pull-left dt-mar6r dt-mar8t mklayer dt-mar8t <?php if ($layer['is_show']): ?>glyphicon-eye-open font-green<?php else: ?>glyphicon-eye-close font-red<?php endif; ?>" maker="maker"></span>
                                                <div class="dt-truncate pull-left dt-pointer layer_title dt-mar6t" style="width: 170px"><?php echo $layer['name']; ?></div>
                                            </div>
                                            <div class="layer-panel-status dt-none">
                                                <ul class="list-unstyled dt-pad12x dt-pad12y"  id="layerid<?php echo $layer['id']; ?>">
                                                    <?php if (!empty($layer['store']) && is_array($layer['store'])): ?>
                                                        <?php $storeNums = count($layer['store']); ?>
                                                        <?php foreach ($layer['store'] as $store): ?>
                                                            <li class="select_marker dt-truncate Slist layer-store<?= $layer['id'] ?> store<?= $store['id'] ?>" index="<?= $store['id'] ?>">
                                                                <img class="select_marker" src="/icons/default/<?php if (!empty($store['icon'])): ?><?= $store['icon'] ?><?php else: ?><?= $layer['ico'] ?><?php endif; ?>">
                                                                <span layout_id="<?= isset($_GET['layoutid']) ? $_GET['layoutid'] : ''; ?>" class="select_marker marker-title dt-f12 storeList" index="<?= $store['id'] ?>" title="<?= $store['name'] ?>"><?= $layer['title'] == 1 ? $store['name'] : ($layer['title'] == 2 ? $store['address'] : $store['v' . $layer['title']]) ?></span>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </ul>
                                                <?php if ($layer['layerStoreNum'] > LAYER_NUM): ?>
                                                    <p id="loadLayerStore<?php echo $layer['id']; ?>" class="text-center dt-pointer color2e9 load-more dt-mar12b dt-f12" onclick="loadLayerStoreSend(<?php echo $layer['id']; ?>)">
                                                        <span class="glyphicon glyphicon-chevron-down"></span>
                                                        加载更多
                                                    </p>
                                                <?php endif; ?>
                                                <p id="closeMore<?php echo $layer['id']; ?>" class="text-center dt-pointer color2e9 retract-more dt-mar12b dt-f12 dt-none" onclick="closeMore(<?php echo $layer['id']; ?>)">
                                                    <span class="glyphicon glyphicon-chevron-up"></span>收起列表 </p>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

                <div class="pull-box-filter-panel" style="display: none">
                    <div class="dt-pad10x">
                        <div class="dt-hidden" style="height: 31px;">
                            <div class="pull-left dt-line-32h">
                                <span class="glyphicon glyphicon glyphicon-list dt-mar6r"></span>
                                符合条件的记录
                                <span id="filterCount">0</span>条
                            </div>
                            <a href="javascript:void(0)" class="clear-search-all dt-line-32h pull-right">清除</a>
                        </div>
                    </div>
                    <div id="filterListPanelBorder" style="max-height: 422px;">
                        <ul class="list-unstyled dt-pad12x dt-pad12y">

                        </ul>
                    </div>
                </div>

                <div class="map-info-tab">
                    <div class="mapinfo-but-con2">
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="map-show" <?php if(!is_numeric($_GET['layoutid'])):?>style="margin-left: 0px;"<?php endif;?>>
                <div id="mapContainer" style="height: 900px; width: 1594px; position: relative;"></div>
            </div>
            <div id="select_downloadmarker_container"></div>
            <div id="search-results" class="search-data dt-pos-a dt-z10 dt-none dt-bg-white">
                <div class="search-title dt-line-32h">
                    <strong>搜索结果</strong>
                    <span id="closeRD" class="pull-right">关闭</span>
                </div>
                <div id="localResults" style="overflow:auto;border-right:1px solid #ccc;"></div>
            </div>
            <div class="filter-container dt-none">
                <div class="fixed-filter"></div>
            </div>
            <div class="dt-bg-white dt-pos-f dt-f16 text-center dt-pointer dt-border-cc" id="search_control" data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="搜索">
                <span class="glyphicon glyphicon-search dt-mar6t"></span>
            </div>
            <div class="search-panel dt-none search-one">
                <div class="input-group">
                    <span id="clearSearchRes" title="清除搜索结果" class="glyphicon glyphicon-remove dt-pos-a dt-none dt-z10" style="right:48px;top:8px;"></span>
                    <input class="form-control input-sm" id="searchInput" placeholder="搜索名称" type="text">
                    <span class="input-group-btn">
                        <a href="javascript:void(0)" id="submitSearch" class="btn btn-primary btn-sm pull-right">确定</a>
                    </span>
                </div>
            </div>
            <?php if(is_numeric($_GET['layoutid'])):?>
            <div class="dt-bg-white dt-pos-f glyphicon glyphicon-share dt-pad6x dt-pad6y dt-line-14h dt-f16 dt-pointer dt-border-cc" id="shareMap">

            </div>
            <?php endif;?>
            <div  class="dt-pos-f glyphicon glyphicon-screenshot dt-border-cc dt-pointer" id="pullbox" onclick="polygonSelect()">
            </div>
            <div  class="dt-pos-f glyphicon glyphicon-th dt-border-cc dt-pointer set-mapstyle" id="pullstyle">
            </div>
            <div class="dt-pos-f map_style dt-none" style="top:47px;right: 52px;">
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
            <div class="line-right"></div>
            <div class="dt-bg-white dt-pos-f icons dt-border-cc" onclick="Tools.distanceTool.open()" id="distanceBtn"></div>
            <div class="user-info dt-pos-f" style="right:6px;top:10px;z-index: 401">
                <a id="user_nav" class="dropdown-toggle white" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" href="javascript:void(0)">
                    <div class="user-avater dt-none">
                        <img class="img-circle dt-mar4t" alt="咔咔瓦" title="咔咔瓦" src="/images/ka.png" width="48" height="48">
                    </div>
                </a>
                <ul class="dropdown-menu  text-center">
                    <a id="user_nav" class="dropdown-toggle white" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" href="javascript:void(0)">
                        <li class="text-left dt-pad12x dt-pad12y dt-pos-r dt-hidden">
                            <img class="img-circle pull-left" src="/images/ka.png" width="60" height="60">
                            <div class="pull-left dt-line-30h">
                                <h4 class="black dt-mar0 dt-pad12x dt-pad6t dt-mar12l">咔咔瓦</h4>
                                <span class="black dt-f14 dt-mar12l">17310717756</span>
                            </div>
                        </li>
                        <li class="divider"></li>
                    </a>
                    <li class="dt-h36 text-left">
                        <a id="user_nav" class="dropdown-toggle white" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" href="javascript:void(0)"></a>
                        <a href="https://www.dituwuyou.com/map/edit?mid=3g7Jg2ex3IMtwwCfJRpr-w" class="dt-team">
                            <i class="icon-qrcode"></i>&nbsp;<span class="dt-f12">编辑地图</span>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <div class="dt-pad12x dt-pad12y dt-hidden">
                        <a rel="nofollow" class="btn btn-danger btn-sm pull-right" data-method="delete" href="https://www.dituwuyou.com/users/sign_out">退出</a>
                    </div>
                </ul>
            </div>
            <!--<div class="dt-bg-white dt-pos-f dt-f16 text-center dt-pointer dt-border-cc" id="search_area" data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="搜索">
                <span class="glyphicon glyphicon-copyright-mark dt-mar6t" style="color: #919191;"></span>
            </div>
            <div class="search-panel dt-none search-two" style="top: 10px;">
                <div class="input-group">
                    <span id="clearSearchRes" title="清除搜索结果" class="glyphicon glyphicon-remove dt-pos-a dt-none dt-z10" style="right:48px;top:8px;"></span>
                    <input class="form-control input-sm" id="searchArea" placeholder="搜索省市区域" type="text">
                    <span class="input-group-btn">
                        <a href="javascript:void(0)" id="searchAreaButton" class="btn btn-primary btn-sm pull-right">确定</a>
                    </span>
                </div>
            </div>-->

        </div>
        <input type="hidden" id="layoutid" name="layoutid" value="<?php echo $layoutid ?>">
        <input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>">
        <div id="dialogContent"></div>
        <script type="text/javascript">
            var sServer = 'ws://<?php echo HOST ?>:<?php echo PORT ?>';
            var isedit = false; var issearch = true;
            var map = new BMap.Map("mapContainer", {enableMapClick: false});    // 创建Map实例
            (function (cityName) {
                map.centerAndZoom(cityName, 12);  // 初始化地图,设置中心点坐标和地图级别
                map.enableScrollWheelZoom();
                map.setMinZoom(6);
                map.setMaxZoom(16);
                Tools.init(map, cityName);

                var layoutid = $('#layoutid').val();
                $.post('/basics/draw/getall', {layoutid:layoutid}, function (data) {
                    for (var i = 0; i < data.length; i++) {
                        var json = data[i]; var obj = {};
                        if (json.type == circleType) {
                            obj = Tools.addCircle(json);
                        } else if (json.type == polylineType) {
                            obj = Tools.addLine(json);
                        } else if (json.type == polygonType) {
                            obj = Tools.addPolygon(json);
                        }
                        var isShowArea = <?=$isShowArea?>;
                        if(isShowArea == 1){
                            obj.show();
                        }else{
                            obj.hide();
                        }
                        Event.click(obj, json);
                    }
                },'json');

            })('<?= $cityName ?>');

            resize();
            function resize() {
                document.body.clientHeight - 96 < 8 ? $("#featureListPanelBorder,#filterListPanelBorder").css("max-height", 8) : $("#featureListPanelBorder,#filterListPanelBorder").css("max-height", document.body.clientHeight - 83);
                $('#mapContainer').css('width',window.innerWidth);
            }
            $(function () {
                $(".mapinfo-but-con2").click(function () {
                    0 !== parseInt($(".map-info").css("left")) ? ($(".map-info").animate({
                        left: "0"
                    }, "fast"), $(".map-show").animate({
                        "margin-left": "326px"
                    }, "fast", function () {
                        $(".reply-panel").removeClass("hide-data-list").removeAttr("style")
                    }), $("#mapContainer").animate({
                        width: window.innerWidth - 326
                    }, "fast"), $(".viewer-header").animate({
                        left: "0"
                    }, "fast"), $(this).find("span").removeAttr("style")) : ($(".reply-panel").addClass("hide-data-list").removeAttr("style"), $(".map-info").animate({
                        left: "-326px"
                    }, "fast"), $(".map-show").animate({
                        "margin-left": "0"
                    }, "fast"), $("#mapContainer").animate({
                        width: window.innerWidth
                    }, "fast"), $(".viewer-header").animate({
                        left: "-326"
                    }, "fast"), $(this).find("span").css("background-position", "-139px -167px"));
                });

                //点击门店打开弹窗
                $("#featureListPanelBorder, .pull-box-filter-panel").on("click", ".Slist", function () {
                    var storeid = $(this).attr("index");
                    $.post("<?= Url::toRoute('/basics/marker/getinfo_ajax') ?>", {storeid: storeid}, function (data) {
                        createMarker.openInfobox(data.data);
                    },'json');
                });

                $("#shareMap").bind().click(function () {
                    var url = "<?php echo Url::toRoute(['/basics/marker/share', 'id' => $_GET['layoutid']]) ?>";
                    $.dialog('setLayerStyle', url, 600);
                });
            })
        </script>
        <script src="/js/map.js"></script>
    </body>
</html>
