<?php
use yii\helpers\Url;

?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0,user-scalable=0">
    <title><?php echo $layoutName; ?>-房图</title>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=jo2N0X0PdOeZVPURz2bXvpcO"></script>
    <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
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
    <script src="/js/map.marker.js"></script>
    <script src="/js/map.Tools.js"></script>
    <script src="/js/toastr.min.js"></script>
    <!--测距工具-->
    <script type="text/javascript" src="http://api.map.baidu.com/library/DistanceTool/1.2/src/DistanceTool_min.js"></script>
    <!--计算区域工具-->
    <script type="text/javascript" src="http://api.map.baidu.com/library/GeoUtils/1.2/src/GeoUtils_min.js"></script>
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
    <input type="hidden" id="layoutid" name="layoutid" value="<?php echo $_GET['layoutid'] ?>">
    <div class="dt-w100per dt-h48 dt-bg-blue3A dt-pos-a dt-z10">
        <div class="dt-w380 dt-h48 pull-left dt-pad16x dt-pos-r">
            <a href="/main">
                <img class="dt-mar12t" title="返回到首页" src="/images/logo60X24.png" width="60" height="24">
            </a>
        </div>
        <div class="pull-left edit-title">
            <div id="map-title-bar" class="pull-left white dt-line-48h dt-f16 dt-truncate" style="max-width: 550px;">
                <?php echo $layoutName; ?>
            </div>
      <span class="edit-title-icon" onclick="editLayoutInfo('<?php echo $_GET['layoutid'] ?>')">
        <span id="editMapInfo" class="glyphicon glyphicon-pencil"></span>
        <span class="edit-title-hover"></span>
      </span>
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
                        <span class="black dt-super dt-f14 dt-line-32h"><span
                                id="layerSize"><?php echo $layer_num; ?></span>个图层
                            <span id="featureCount"><?php echo $store_num; ?></span>条记录</span>
                        <span class="new-layers" onclick="addLayer()">
                            <img id="select_layer_type" class="pull-right dt-pos-r dt-pointer" title="新建图层"
                                 src="/images/add_layers.png" width="22" height="18">
                        </span>
                        <span class="drag-layers" onclick="editLayer(<?= $layout_id; ?>)">
                            <span class="glyphicon glyphicon-sort dt-pointer"></span>
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
                    <?php if (!empty($layer_info)): ?>
                    <?php foreach ($layer_info as $key => $layer): ?>
                    <div id="layerContainer" class="layer-sort pull-left layer<?= $layer['id'] ?> layer-store<?= $layer['id'] ?>"
                         data-id="<?php echo $layer['id'] ?>" style="width: 325px;">
                    <div class="layer dt-pos-r">
                        <div
                            class="mlayer dt-pos-a dt-h100per dt-pos-t0 <?php if ($key == 0): ?>active-layer<?php endif; ?>"></div>
                        <div class="dt-h30 dt-pad4x dt-mar4y layer-top" is_show="<?= $layer['is_show'] ?>"
                             layer-id="<?= $layer['id'] ?>">
                            <span
                                class="glyphicon display_layer pull-left dt-mar6r dt-mar8t mklayer dt-mar8t <?php if ($layer['is_show']): ?>glyphicon-eye-open font-green<?php else: ?>glyphicon-eye-close font-red<?php endif; ?>"></span>
                            <div title="<?= $layer['name'] ?>"
                                 class="dt-w200 dt-truncate pull-left layer_title dt-mar6t"
                                 id="layerNameId<?= $layer['id'] ?>"><?= $layer['name'] ?>
                            </div>
                            <div title="标注图层1"
                                 class="dt-w140 edit-layer-title dt-truncate pull-left dt-mar6t dt-none">
                                <input value="标注图层1" class="form-control edit-layer-title-input dt-h20" type="text">
                            </div>
                            <div class="layer_action numIcon" id="icon_<?= $layer['id'] ?>"
                                 style="background-image: url('/icons/default/<?php if (!empty($layer['ico'])): ?><?= $layer['ico'] ?><?php else: ?>ff0000-s-null.png<?php endif; ?>');<?php if(strstr($layer['ico'] , '_marker')){ echo "background-size:18px 18px";}?>">
                                <span
                                    id="layerStoreNum<?= $layer['id'] ?>"><?php echo $layer['layerStoreNum']; ?></span>
                            </div>
                            <!--<span class="pull-right glyphicon glyphicon-pencil edit-title dt-pointer dt-line-30h dt-pad32r dt-none" style="display: "></span>-->
                        </div>
                        <div class="layer-panel-status dt-none">

                            <div class="dt-hidden">
                                <div class="dt-pointer dt-pad20x dt-h20 box" layer-id="<?= $layer['id'] ?>">

                                    <span class="glyphicon  glyphicon-globe color66 dt-super dt-f12 marker-layer-style"
                                          onclick="setLayerStyle(<?= $layer['id'] ?>)"
                                          data-layerid="<?= $layer['id'] ?>"><span
                                            class="dt-pad4x dt-f14">样式设置</span></span>
                                            <span data-placement="bottom" data-container="body"
                                                  layer-id="<?= $layer['id']; ?>" layer-name="<?= $layer['name'] ?>"
                                                  class="glyphicon dt-mar22l dt-pad12x dt-f12 color66 glyphicon-th-list dt-super dt-mar6l data-marker-list dataviewspan"><span

                                                    class="dt-pad4x data-marker-list dt-f14">数据视图</span></span>
                                            <span
                                                class="glyphicon glyphicon-circle-arrow-down more more-icon dt-mar24l dt-f12 dt-super color66 dt-mar6l dt-marker-layer"><span
                                                    class="dt-pad4x more-icon dt-f14">更多</span></span>
                                    <div class="text-center dt-pos-a dt-bg-white dt-z10 dt-panel more-list dt-none"
                                         style="position:absolute; top:35px; left:220px ;box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                        <div class="dt-hidden close-list" style="border-bottom: 1px solid #eee;">
                                            <span class="close-btn">x</span></div>
                                        <ul>
                                            <li class=" dt-w100 dt-h28 dt-line-24h dt-hover-gray dt-pointer">
                                                        <span
                                                            class="black dt-show dt-line-28h dt-sub dt-child title_settings titles"
                                                            data-target="#setTitle" data-toggle="modal">
                                                            设置标题
                                                        </span>
                                            </li>
                                            <li class=" dt-w100 dt-h28 dt-line-24h dt-hover-gray dt-pointer"><span
                                                    class="black dt-show dt-line-28h dt-sub dt-child data_token titles"
                                                    data-target="#setOrder" data-toggle="modal">
                                                            设置排序
                                                        </span>
                                            </li>
                                            <li class=" dt-w100 dt-h28 dt-line-24h dt-hover-gray dt-pointer"><span
                                                    class="black dt-show dt-line-28h dt-sub dt-child data_token titles"
                                                    data-target="#addItem" data-toggle="modal">
                                                            添加数据
                                                        </span>
                                            </li>
                                            <li class=" dt-w100 dt-h28 dt-line-24h dt-hover-gray dt-pointer"><span
                                                    class="black dt-show dt-line-28h dt-sub dt-child data_token titles"
                                                    onclick="setMsgBox(<?= $layer['id']; ?>)">
                                                            信息框提示
                                                        </span>
                                            </li>
                                            <li class=" dt-w100 dt-h28 dt-line-24h dt-hover-gray dt-pointer"><span
                                                    class="black dt-show dt-line-28h dt-sub dt-child data_token titles"
                                                    onclick="exportExcel(<?= $layer['id']; ?>)">
                                                            数据下载
                                                        </span>
                                            </li>
                                            <li class=" dt-w100 dt-h28 dt-line-24h dt-hover-gray dt-pointer"><span
                                                    class="black dt-show dt-line-28h dt-sub dt-child token_import titles"
                                                    onclick="renameLayer(<?= $layer['id']; ?>)">
                                                            重命名图层
                                                        </span>
                                            </li>
                                            <li class=" dt-w100 dt-h28 dt-line-24h dt-hover-gray dt-pointer"><span
                                                    class="black dt-show dt-line-28h dt-sub dt-child token_import titles"
                                                    onclick="clearStore(<?= $layer['id']; ?>)">
                                                            清除数据
                                                        </span>
                                            </li>
                                            <li class=" dt-w100 dt-h28 dt-line-24h dt-hover-gray dt-pointer"><span
                                                    class="black dt-show dt-line-28h dt-sub dt-child token_import titles"
                                                    onclick="delLayer(<?= $layer['id']; ?>)">
                                                            删除图层
                                                        </span>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>

                            <div id="heatmap_layer_contain_303520" class="dt-pad16x dt-pad12y dt-truncate dt-none">
                                <div id="heatmap_style_303520" class="dt-mar5 pull-left"
                                     style="height: 14px;width: 20px;background: -webkit-linear-gradient(left, rgb(0,0,255) 45%,rgb(0,255,255) 55%,rgb(0,255,0) 65%,yellow 95%,rgb(255,0,0) 100%);-moz-linear-gradient(left, rgb(0,0,255) 45%,rgb(0,255,255) 55%,rgb(0,255,0) 65%,yellow 95%,rgb(255,0,0) 100%);"></div>
                            </div>
                            <ul class="list-unstyled dt-pad20x dt-pad12y" style="display:block"
                                id="layerid<?php echo $layer['id']; ?>">
                                <?php if (!empty($layer['store']) && is_array($layer['store'])): ?>
                                    <?php $storeNums = count($layer['store']); ?>
                                    <?php foreach ($layer['store'] as $store): ?>
                                        <li class="select_marker dt-truncate Slist layer-store<?= $layer['id'] ?> store<?= $store['id'] ?>"
                                            index="<?= $store['id'] ?>">
                                            <img class="select_marker"
                                                 src="/icons/default/<?php if (!empty($store['icon'])): ?><?= $store['icon'] ?><?php else: ?><?= $layer['ico'] ?><?php endif; ?>">
                                            <span layout_id="<?= isset($_GET['layoutid']) ? $_GET['layoutid'] : ''; ?>"
                                                  class="select_marker marker-title dt-f12 storeList"
                                                  index="<?= $store['id'] ?>"
                                                  title="<?= $store['name'] ?>"><?= $layer['title'] == 1 ? $store['name'] : ($layer['title'] == 2 ? $store['address'] : $store['v' . $layer['title']]) ?> </span>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                            <?php if ($layer['layerStoreNum'] > LAYER_NUM): ?>
                                <p id="loadLayerStore<?php echo $layer['id']; ?>"
                                   class="text-center dt-pointer color2e9 load-more dt-mar12b dt-f12"
                                   onclick="loadLayerStoreSend(<?php echo $layer['id']; ?>)">
                                    <span class="glyphicon glyphicon-chevron-down"></span>
                                    加载更多
                                </p>
                            <?php endif; ?>
                            <p id="closeMore<?php echo $layer['id']; ?>"
                               class="text-center dt-pointer color2e9 retract-more dt-mar12b dt-f12 dt-none"
                               onclick="closeMore(<?php echo $layer['id']; ?>)">
                                <span class="glyphicon glyphicon-chevron-up"></span>收起列表 </p>

                            <?php if (empty($layer['store'])): ?>
                                <p class="text-center dt-pointer color2e9 retract-more dt-mar12b dt-f12 box"
                                   layer-id="<?php echo $layer['id']; ?>">
                                    <span class="glyphicon glyphicon-upload newtitles" data-target="#addItem"
                                          data-toggle="modal">批量添加数据</span>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div id="filterInfoWrapper" class="dt-none"><p class="dt-hiddeh dt-pad8x dt-pad8y">总共筛选<span class="filter-count dt-f14">2</span>条结果<a href="javascript:void(0)" class="pull-right close-filter-panel">关闭</a></p>
        <hr class="dt-mar0">
        <div class="filter-overlay-panel dt-pad8x dt-pad8y dt-auto" style="height: 557px;">
            <div class="dt-hidden">
                <ul class="list-unstyled" style="display:block">
                </ul>
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
    <!--
    <a class="glyphicon glyphicon-question-sign color99 dt-f18 dt-pos-f" style="color:#aaa;right:12px;top:56px"
       title="帮助"></a>
    <span class="glyphicon dt-pointer glyphicon-exclamation-sign dt-f18 dt-pos-f" style="color:#aaa;right:44px;top:56px"
          title="查看引导"></span>
    -->
    <div class="map-nav-bar">
        <div class="dt-z10 dt-hidden dt-h32 city-list" id="dtwyCityList"></div>
        <div id="drawingToolbar" style="left:30px;width: 100px;top:3px">
            <input id="overt" name="overt" type="checkbox" <?php if ($isShowArea == '1'): echo 'checked'; endif; ?> class="overt chk_4" value="<?= $isShowArea; ?>">
            <label for="overt" class="dt-middle"></label>
        </div>
        <div id="drawingToolbar">
            <div id="panBtn" class="icons" title="移动地图" onclick="toolsClose()"></div>
            <div style="width: 32px;height: 31px;top: 0;line-height: 31px;" id="pullBoxPanel"
                 class="glyphicon glyphicon-screenshot" title="框选标注"></div>
            <div class="pull-box-control dt-none">
                <div id="pullBoxSearch" onclick="polygonSelect()" class="glyphicon glyphicon-fullscreen"></div>
                <div id="pullBoxCircle" onclick="circleSelect()" class="glyphicon glyphicon-record"></div>
            </div>
            <div class="line-right"></div>
            <div id="addMarkerBtn" onclick="addMarker()" class="icons draw-btn" title=" 添加标注"></div>
            <div class="line-right"></div>
            <!--<div id="searchBtn" index="0" class="glyphicon glyphicon-search" title="获取省、市区域轮廓">
                <span class="glyphicon glyphicon-remove dt-pos-a dt-none dt-f16 dt-z10"
                      style="right: 12px;top:8px;"></span>
                <div id="searchControl" class="pull-right" style="display: block;">
                    <input id="search_input" class="dt-form-control dt-f12" placeholder="获取省、市区域轮廓" type="text">
                </div>
            </div>
            <div class="line-right"></div>-->
        </div>

        <div id="fendanToolbar" class="dt-none">
            <div id="fendanPanBtn" class="icons" data-toggle="tooltip" data-placement="bottom" data-container="body"
                 title="" data-original-title="平移地图"></div>
            <div id="fendanAddMarkerBtn" class="icons" data-toggle="tooltip" data-placement="bottom"
                 data-container="body" title="" data-original-title="添加关键词"></div>
            <div class="line-right"></div>
            <div id="fendanSearchControl" class="input-group pull-right dt-mar12l">
                <input class="form-control dtwy-search-input input-sm pull-left" placeholder="搜索名称、地址" type="text">
                    <span class="input-group-btn">
                        <button class="btn dtwy-search-btn btn-primary" type="button">搜索</button>
                    </span>
            </div>
        </div>
        <div id="mapContainer" style="z-index: 0; height: 837px; width: 1540px; position: relative;"></div>
    </div>
</div>
</div>

<div id="dialogContent"></div>

<div class="modal fade" id="setOrder" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" style="width:500px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    设置排序
                </h4>
            </div>
            <form action="http://test.fangtu.com/basics/edit" method="post">

                <div class="modal-body">
                    <div class="dt-hidden dt-w168" style="margin:0 auto;">
                        <div class="dt-mar4t" style="width:200px;">
                            <input id="default" type="radio" checked="" name="sortRadio" class="dt-pointer radio_btn"
                                   style="margin-left:2px;margin-right:2px;" onclick="sortHidden()" value="default">
                            <label for="default" class="dt-pointer dt-line-30h dt-normal">默认 </label>
                            <input id="asc" type="radio" name="sortRadio" class="dt-pointer radio_btn"
                                   onclick="sortShow(this.value)" value="asc">
                            <label for="asc" class="dt-pointer dt-line-30h dt-normal">升序</label>
                            <input id="desc" type="radio" name="sortRadio" class="dt-pointer radio_btn"
                                   onclick="sortShow(this.value)" value="desc">
                            <label for="desc" class="dt-pointer dt-line-30h dt-normal">降序</label>
                        </div>
                        <div id="data_sort_fields" style="display: none;">
                            <span class="dt-line-30h pull-left dt-f14"></span>
                            <select class="dt-select-label pull-left form-control dt-w168"
                                    onchange="sortSel(this.value)" name="sortSelect" id="setOrder-select">
                                <option value="2">成交量</option>
                                <option value="1" selected>带看量</option>
                            </select>
                        </div>
                        <input type="hidden" id="sortRadio" value="default">
                        <input type="hidden" id="sortSelect" value="1">
                    </div>
                </div>
                <input type="hidden" name="layerid" value="" id="setOrder-layerid">
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addItem" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" style="width:600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    添加数据
                </h4>
            </div>
            <form id="form_data_addItem">
                <div class="modal-body">
                    <div class="text-center">
                        <div class="tab-content">
                            <div id="localUpload" class="tab-pane active" role="tabpanel">
                                <div id="file_upload_desc">
                                    <div class="uploadifive-button btn btn-primary dt-mar12t"
                                         style="height: 36px; overflow: hidden; position: relative; text-align: center; width: 120px;">
                                        选择数据
                                        <input id="file"
                                               style="font-size: 36px; opacity: 0; position: absolute; right: -3px; top: -3px; z-index: 999;"
                                               type="file"></div>
                                    <div class="uploadifive-queue"></div>
                                    <div style="color:blue;display:none;" id="file_upload_desc_tip">已经选择数据</div>
                                </div>
                                <div class="dt-mar10t text-left dt-f12">
                                    <p class="dt-mar4t">
                                        <b>格式说明</b>：支持Excel或CSV，字段不超过7个，文件行数不超过 <?php echo $maxExcelRow; ?> 行。</p>
                                    <p class="dt-mar4t"><b>定位字段</b>：必须有地址字段或经纬度字段，以便在地图上自动定位。</p>
                                    <p class="dt-mar4t">
                                        <b>模板下载</b>：<a href="<?php echo Url::toRoute('/basics/edit/download')?>">下载模板</a>
                                    </p>
                                </div>
                            </div>

                            <div id="progress_addItem" style="display: none">
                                <div style="width: 100%;height: 90px;">
                                    <div style="padding: 10px 123px;">
                                        <img id="show_img" style="float: left" src="/images/loading.gif" alt="">
                                        <span style="line-height: 70px;font-size: 21px;" class="tip">数据解析处理中...</span>
                                    </div>
                                </div>
                                <div class="progress" id="show_progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0"
                                         aria-valuemax="100" style="width: 100%;">
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
                <input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeStatus()">关闭
                    </button>
                    <button type="button" onclick="sendFile()" class="btn btn-primary" id="submitUpload">提交</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="setTitle" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" style="width:400px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">设置标题</h4>
            </div>
            <form id="form_data">
                <div class="modal-body">
                    <label style="line-height: 34px" class="col-sm-3 control-label">请选择:</label>
                    <select class="ipt form-control" style="width: 180px" name="info[title]" onchange="searchData(this)"
                            id="setTitle-select">

                    </select>
                </div>
                <input type="hidden" name="layerid" value="" id="setTitle-layerid">
            </form>
        </div>
    </div>
</div>


<!--数据视图div-->
<div id="dataView" class="dt-pos-a dt-bg-white dt-z10 dt-data-list"
     style=" box-shadow: 0 1px 3px rgba(0,0,0,.25)!important;border-radius:2px;overflow: hidden;left: 56px;top:50px;z-index:240;max-width:1000px;min-width:600px;display:none;">
    <p class="dt-data-list-title dt-h40 dt-pad10x dt-pad10y dt-bb-cc dt-mar6b dt-pos-f"
       style="width: 635px;z-index:9999">
        <span class="pull-left dt-f16" id="dataViewName">标注图层1</span>

        <span class="pull-left dt-mar4l data-search-control dt-pointer" data-show="true" data-container="body"
              data-placement="bottom" data-toggle="tooltip" title="" data-original-title="搜索">
            <span class="dt-f14 dt-middle pull-left dt-w24 dt-h24" style="display: block; width: 208px;">
                <span
                    class="dt-f14 dt-middle glyphicon glyphicon-search dt-mar2t data-search pull-left dt-mar6l coloraa"
                    style="display: none;"></span>
                <span class="search-data-list-layout dt-mar6l dt-pos-r pull-left" style="display:block">
                    <span class="glyphicon glyphicon-search dt-pos-a coloraa" style="left:6px;top:3px;"></span>
                    <input id="searchDataList" class="form-control dt-w268 dt-h30 pull-left"
                           style="padding:0 24px;margin-top:-6px;" placeholder="请输入搜索内容">
                    <!--                    <span id="refreshDataList" class="close-search-layout glyphicon glyphicon-remove dt-pointer dt-pos-a coloraa" style="right:6px;top:3px;"></span>-->
                </span>
            </span>
            <span class="coloraa dt-f12 dt-search dt-line-24h dt-mar4l dt-normal dt-none">搜索</span>
        </span>
        <span id="dataListClose" class="pull-right dt-gray dt-pointer glyphicon glyphicon-remove dt-mar6l"
              data-toggle="tooltip" data-placement="bottom" data-container="body" title=""
              data-original-title="关闭"></span>
        <span id="dataStatus" class="pull-right glyphicon glyphicon-minus dt-mar6r dt-gray dt-pointer"
              data-toggle="tooltip" data-placement="bottom" data-container="body" title="" data-original-title="最小化"
              style="display:none;"></span>
    </p>
    <div id="gbox_dataList" class="ui-jqgrid " dir="ltr" style="width: 635px;">
        <div id="gview_dataList" class="ui-jqgrid-view table-responsive" role="grid" style="width: 635px;">
            <div class="ui-jqgrid-bdiv" style="height: 360px; width: 635px; overflow-x:auto;margin-top:40px;">
                <div style="position:relative;">
                    <div></div>
                    <table id="dataList" class="table-striped ui-jqgrid-btable ui-common-table table table-bordered"
                           style="margin-top: 30px; width: 970px;" tabindex="0" role="presentation"
                           aria-multiselectable="true" aria-labelledby="gbox_dataList">
                        <thead id="dataViewThead">

                        </thead>
                        <tbody id="dataViewTbody">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="jqGridPager" class="ui-jqgrid-pager" style="width: 635px;" dir="ltr">
            <div id="pg_jqGridPager" class="ui-pager-control" role="group">
                <table class="ui-pg-table ui-common-table ui-pager-table">
                    <tbody>
                    <tr>
                        <td id="jqGridPager_center" style=" width: 288px;" align="center">
                            <table class="ui-pg-table ui-common-table ui-paging-pager">
                                <tbody>
                                <tr>
                                    <td id="first_jqGridPager" class="ui-pg-button" title="第一页"
                                        style="cursor: default;">
                                        <span class="glyphicon glyphicon-step-backward"></span>
                                    </td>
                                    <td id="prev_jqGridPager" class="ui-pg-button" title="上一页" style="cursor: default;">
                                        <span class="glyphicon glyphicon-backward"></span>
                                    </td>
                                    <td class="ui-pg-button ui-disabled" style="cursor: default;">
                                        <span class="ui-separator"></span>
                                    </td>
                                    <td id="input_jqGridPager" dir="ltr">
                                        <input class="ui-pg-input form-control" size="2" maxlength="7" value="0"
                                               role="textbox" type="text" name="dataviewpage">
                                        共
                                        <span id="sp_1_jqGridPager">15</span>
                                        页
                                    </td>
                                    <td class="ui-pg-button ui-disabled" style="cursor: default;">
                                        <span class="ui-separator"></span>
                                    </td>
                                    <td id="next_jqGridPager" class="ui-pg-button" title="下一页" style="cursor: default;">
                                        <span class="glyphicon glyphicon-forward"></span>
                                    </td>
                                    <td id="last_jqGridPager" class="ui-pg-button" title="最后一页"
                                        style="cursor: default;">
                                        <span class="glyphicon glyphicon-step-forward"></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td id="jqGridPager_right" align="right">
                            <div class="ui-paging-info" dir="ltr" style="text-align:right">共 300 条</div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <input type="hidden" value="" name="" id="dataViewLayerid">
</div>

<script type="text/javascript">
    var sServer = 'ws://<?php echo HOST?>:<?php echo PORT ?>';
    var isedit = true; var issearch = true;
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

    })('<?=$cityName?>');

    resize();
    function resize() {
        document.body.clientHeight - 96 < 8 ? $("#featureListPanelBorder,#filterListPanelBorder").css("max-height", 8) : $("#featureListPanelBorder,#filterListPanelBorder").css("max-height", document.body.clientHeight - 83);
    }

    function _displayRow(obj) {
        if ($(obj).hasClass("glyphicon-eye-open")) {
            $(obj).removeClass("glyphicon-eye-open").addClass("glyphicon-eye-close");
        } else if ($(obj).hasClass("glyphicon-eye-close")) {
            $(obj).removeClass("glyphicon-eye-close").addClass("glyphicon-eye-open");
        }
        toastr.success("操作成功");
    }

    //点击门店打开弹窗
    $("#featureListPanelBorder, #filterInfoWrapper").on("click", ".Slist", function () {
        var storeid = $(this).attr("index");
        $.post("<?=Url::toRoute('/basics/edit/getinfo_ajax')?>",　{storeid: storeid}, function (data) {
            var json = eval(data.data);
            setTimeout("map.panTo(new BMap.Point("+json.lng+","+ json.lat+"))", 50);
            createMarker.openInfobox(json);
        },'json');
    });

    //删除门店模态框
    function delStore(storeid) {
        var url = "<?php echo Url::toRoute('/basics/edit/del')?>?id=" + storeid;
        $.alert('delStore', url, '删除门店', '确定删除门店信息吗？', 400, function (info) {
            var json = info.data;
            var allOverlay = map.getOverlays();
            for (var i = 0; i < allOverlay.length; i++) {
                if (json.id == allOverlay[i].marker_id) {
                    allOverlay[i].remove();
                }
            }
            $(".store" + json.id).remove();
            var count = $("#layerStoreNum" + json.layerid).html();
            count = parseInt(count) - 1;
            $("#layerStoreNum" + json.layerid).html(count);
        });
    }

    //删除图层模态框
    function delLayer(layerid) {
        var url = "<?php echo Url::toRoute('/basics/layer/del')?>?id=" + layerid;
        $.alert('delLayer', url, '删除图层', '删除图层后数据将不可恢复，确定将此图层信息删除？', 400, function () {
            setInterval("window.location.reload()", 1000);
        });
    }

    //清除数据模态框
    function clearStore(layerid) {
        var url = "<?php echo Url::toRoute('/basics/layer/clear')?>?id=" + layerid;
        $.alert('clearStore', url, '清除数据', '清除数据后数据将不可恢复，确定清除数据吗？', 400, function () {
            setInterval("window.location.reload()", 1000);
        });
    }

    //导出图层excel
    function exportExcel(layerid) {
        var url = "<?php echo Url::toRoute('/basics/layer/exportexcel')?>?id=" + layerid;
        window.location.href = url;
    }

    //添加图层模态框
    function addLayer() {
        var url = "<?php echo Url::toRoute('/basics/layer/add')?>";
        $.dialog('setLayerStyle', url, 400);
    }

    //图层设置样式模态框
    function setLayerStyle(layerid) {
        var url = "<?php echo Url::toRoute('/basics/layer/style')?>?id=" + layerid;
        $.dialog('setLayerStyle', url, 600);
    }

    //图层重命名模态框
    function renameLayer(layerid) {
        var url = "<?=Url::toRoute('/basics/layer/rename')?>?id=" + layerid;
        $.dialog('renameLayer', url, 400);
    }

    //门店样式模态框
    function storeStyle(storeid) {
        var url = "<?=Url::toRoute('/basics/edit/style')?>?id=" + storeid;
        $.dialog('storeStyleModal', url, 610);
    }

    //标注自定义样式恢复
    function storeResetStyle(storeid) {
        var url = "<?=Url::toRoute('/basics/edit/resetstyle')?>?id=" + storeid;
        $.alert('storeResetStyle', url, '样式恢复', '确定恢复标注样式吗？', 400, function () {
            var allOverlay = map.getOverlays();
            for (var i = 0; i < allOverlay.length; i++) {
                if (allOverlay[i].marker_id == storeid) {
                    allOverlay[i].remove();
                }
            }//此处遇到了class类名重叠问题
            $.post("<?=Url::toRoute('/basics/edit/getinfo_ajax')?>", {storeid: storeid}, function (data) {
                $(".store" + storeid + " img").attr('src', '/icons/default/' + data.data.ico);
                createMarker.init(data.data);
            },'json');
        });
    }

    //门店修改模态框
    function editStore(storeid) {
        var url = "<?=Url::toRoute('/basics/edit/edit')?>?id=" + storeid;
        $.dialog('editStore', url, 400);
    }

    //图层编辑模态框
    function editLayer(layoutid) {
        var url = "<?=Url::toRoute('/basics/edit/layeredit')?>?layoutid=" + layoutid;
        $.dialog('editLayer', url, 800,function(){
            window.location.reload();
        });
    }
    //设置标题
    $('#setTitle').on('shown.bs.modal', function () {
        var layer = $("#setTitle-layerid").val();
        $.ajax({
            url: "/basics/layer/gettitle_ajax",
            type: "post",
            dataType: "json",
            data: {layerid: layer},
            success: function (res) {
                var html = "";
                var defined = JSON.parse(res.data.defined);
                $.each(defined, function (key, value) {
                    html += '<option value="' + key + '" ' + (res.data.title == key ? 'selected' : '') + '>' + value + '</option>';
                });
                $("#setTitle-select").html(html);
            }
        });
    });

    $('#setTitle').on("hidden.bs.modal", function () {//解决模态框只加载一次问题
        $(this).removeData("bs.modal");
    });

    //设置排序
    $('#setOrder').on('shown.bs.modal', function () {
        var layer = $("#setOrder-layerid").val();
        $.ajax({
            url: "/basics/layer/gettitle_ajax",
            type: "post",
            dataType: "json",
            data: {layerid: layer},
            success: function (res) {
                var html = "";
                var defined = JSON.parse(res.data.defined);
                if (res.data.sort != "0") {
                    document.getElementById('data_sort_fields').style.display = "";
                    if (res.data.updown == "asc") {
                        $("input[name=sortRadio]").get(1).checked = true;
                    } else {
                        $("input[name=sortRadio]").get(2).checked = true;
                    }
                } else {
                    document.getElementById('data_sort_fields').style.display = "none";
                    $("input[name=sortRadio]").get(0).checked = true;
                }
                var sort = res.data.sort == 0 ? 1 : res.data.sort;
                $.each(defined, function (key, value) {
                    html += '<option value="' + key + '" ' + (sort == key ? 'selected' : '') + '>' + value + '</option>';
                });
                $("#setOrder-select").html(html);
                $("#sortSelect").val(sort);
            }
        });
    });

    $('#setOrder').on("hidden.bs.modal", function () {//解决模态框只加载一次问题
        $(this).removeData("bs.modal");
    });
    $('#addItem').on("show.bs.modal", function () {//解决模态框只加载一次问题
        $("#file_upload_desc_tip").hide();
    });

    //layout信息修改模态框
    function editLayoutInfo(layoutId) {
        var url = "<?=Url::toRoute('/main/edit')?>?id=" + layoutId;
        $.dialog('editLayoutInfo', url, 400);
    }

    $("#drawingToolbar").on("click", "#overt", function () {
        var checked = $(this).val(); var status = 0;
        var allOverlay = map.getOverlays();
        for (var i = 0; i < allOverlay.length; i++) {
            if (allOverlay[i].type_id > 1) {
                if(checked == 0) {
                    allOverlay[i].show();
                }else{
                    allOverlay[i].hide();
                }
            }
        }
        status = (checked == 0)? 1 : 0;
        $(this).val(status);
        var layoutid = $('#layoutid').val();
        $.post("<?=Url::toRoute('/main/setarea_ajax')?>",　{layoutid:layoutid,status: status}, function (data) {
            var info = JSON.parse(data);
            if (info.code == 200) {
                toastr.success("设置成功");
            } else {
                toastr.error("设置失败");
            }
        });
    });
</script>
<script src="/js/map.js"></script>
</body>
</html>