<?php
use yii\helpers\Url;

?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0,user-scalable=0">
    <title>房图</title>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=jo2N0X0PdOeZVPURz2bXvpcO"></script>
    <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" media="all" href="/css/application.css">
    <link rel="stylesheet" media="screen" href="/css/map_edit.css">
    <link rel="stylesheet" media="screen" href="/css/style.css">
    <script src="http://cdn.bootcss.com/echarts/3.4.0/echarts.min.js"></script>
</head>
<body>
<div id="content">
    <div class="dt-w100per dt-h48 dt-bg-blue3A dt-pos-a dt-z10">
        <div class="dt-w380 dt-h48 pull-left dt-pad16x dt-pos-r">
            <a href="/main">
                <img class="dt-mar12t" title="返回到首页" src="/images/logo60X24.png" width="60" height="24">
            </a>
        </div>
        <div class="pull-left edit-title">
            <div id="map-title-bar" class="pull-left white dt-line-48h dt-f16 dt-truncate" style="max-width: 550px;">
                测试
            </div>
      <span class="edit-title-icon">
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
                        <span class="glyphicon glyphicon-chevron-down all-layer-status dt-mar6r dt-super dt-pointer"></span>
                        <span class="black dt-super dt-f14 dt-line-32h"><span id="layerSize">10</span>个图层
                            <span id="featureCount">10</span>条记录</span>
                        <span class="new-layers">
                            <img id="select_layer_type" class="pull-right dt-pos-r dt-pointer" title="新建图层"
                                 src="/images/add_layers.png" width="22" height="18">
                        </span>
                        <span class="drag-layers">
                            <span class="glyphicon glyphicon-sort dt-pointer"></span>
                        </span>
                    </div>
                </div>
                <div id="featureListPanelBorder">

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
        <div id="mapContainer" style="z-index: 0; height: 837px; width: 1540px; position: relative;"></div>
    </div>
</div>

<div id="dialogContent"></div>


<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('mapContainer'));

    var color =  ['#C23531', '#2F4554', '#61A0A8', '#D48265', '#91C7AE'];

    // 指定图表的配置项和数据
    var option = {
        title: {
            text: '折线图堆叠'
        },
        tooltip: {
            trigger: 'axis',
            formatter: function(params, ticket, callback) {
                console.log(params);
                var res = params[0].name+'<br/>';
                for (var i = 0, l = params.length; i < l; i++) {
                    res += '<span style="color:'+ color[i] +';">' + params[i].seriesName + ':' + params[i].value + '</span>' + '<br/>';
                }
                return res;
            }
        },
        legend: {
            data:['邮件营销','联盟广告','视频广告','直接访问','搜索引擎']
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        toolbox: {
            feature: {
                saveAsImage: {}
            }
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: ['周一','周二','周三','周四','周五','周六','周日']
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                name:'邮件营销',
                type:'line',
                stack: '总量',
                data:[120, 132, 101, 134, 90, 230, 210]
            },
            {
                name:'联盟广告',
                type:'line',
                stack: '总量',
                data:[220, 182, 191, 234, 290, 330, 310]
            },
            {
                name:'视频广告',
                type:'line',
                stack: '总量',
                data:[150, 232, 201, 154, 190, 330, 410]
            },
            {
                name:'直接访问',
                type:'line',
                stack: '总量',
                data:[320, 332, 301, 334, 390, 330, 320]
            },
            {
                name:'搜索引擎',
                type:'line',
                stack: '总量',
                itemStyle: {
                    normal: {
                        lineStyle: {
                            width: 20
                        }
                    }
                },
                data:[820, 932, 901, 934, 1290, 1330, 1320]
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);

    $(function () {
        //左侧图层面板显隐状态切换
        $(".mapinfo-but-con").click(function () {
            0 !== parseInt($(".map-info").css("left")) ? ($(".map-info").animate({
                left: "0"
            }, "fast"), $(".map-show").animate({
                "margin-left": "380px"
            }, "fast", function () {
                $(".reply-panel").removeClass("hide-data-list").removeAttr("style")
            }), $("#mapContainer").animate({
                width: window.innerWidth - 380
            }, "fast"), $(".map-info-tab").animate({
                left: "380"
            }, "fast"), $(this).find("span").removeAttr("style")) : ($(".reply-panel").addClass("hide-data-list").removeAttr("style"), $(".map-info").animate({
                left: "-380px"
            }, "fast"), $(".map-show").animate({
                "margin-left": "0"
            }, "fast"), $("#mapContainer").animate({
                width: window.innerWidth
            }, "fast"), $(".map-info-tab").animate({
                left: "0"
            }, "fast"), $(this).find("span").css("background-position", "-139px -167px"));
        });
    });




</script>

</body>
</html>
