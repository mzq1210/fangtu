var circleType = 2;
var polylineType = 3;
var polygonType = 4;

var Tools = {
    map: '',
    drawingManager: '',
    /**
     * @desc 默认样式(圆,多边形)
     */
    default_style: {
        strokeColor: "#F284B6", 　//边线颜色。
        fillColor: "#F4D9E2",  　　//填充颜色。当参数为空时，圆形将没有填充效果。
        strokeWeight: 3,        //边线的宽度，以像素为单位。
        fillOpacity: 0.6,       //填充的透明度，取值范围0 - 1。
        strokeStyle: 'dashed'  　//边线的样式，solid或dashed。
    },

    /**
     * @desc 默认样式(圆,多边形)
     */
    line_default_style: {
        strokeColor: "#00f",
        strokeWeight: 3,
        strokeOpacity: 0,
        strokeStyle: 'solid'
    },

    /**
     * 实例化
     */
    init: function(mapObj, cityName){
        this.status = true;
        this.map = mapObj;
        var map = this.map;
        map.centerAndZoom(cityName, 12);
        //实例化鼠标绘制工具
        this.drawingManager = new BMapLib.DrawingManager(map, {
            isOpen: false, //是否开启绘制模式
            enableDrawingTool: true, //是否显示工具栏
            drawingToolOptions: {
                anchor: BMAP_ANCHOR_TOP_RIGHT, //位置
                offset: new BMap.Size(5, 5), //偏离值
                scale: 0.8 //工具栏缩放比例
            },
            circleOptions: this.default_style,          //圆的样式
            polylineOptions: this.line_default_style,   //线的样式
            polygonOptions: this.default_style          //多边形的样式
        });
        this.distanceTool = new BMapLib.DistanceTool(mapObj);
    },

    /**
     * @desc 添加Marker对象
     * @param json {json} json对象
     */
    addMarker: function (json) {
        var iconImg = {};
        if (json.style == null) {
            iconImg = new BMap.Icon('/images/thumb/f86767-s-null.png', new BMap.Size(20, 30));
        } else {
            //坐标偏移量
            if (json.style.linewidth == 's') {
                size = new BMap.Size(20, 30);
            } else if (json.style.linewidth == 'm') {
                size = new BMap.Size(30, 50);
            } else if (json.style.linewidth == 'l') {
                size = new BMap.Size(35, 58);
            } else {
                size = new BMap.Size(20, 30);
            }
            iconImg = new BMap.Icon(json['icons_tyle'], size);
        }

        var point = new BMap.Point(json.lng, json.lat);
        var marker = new BMap.Marker(point, {icon: iconImg});
        marker.overlay_id = json.id;
        marker.type_id = json.type;
        map.addOverlay(marker);
        marker.hide();
        return marker;
    },

    /**
     * @desc 添加圆
     * @param json {json} json对象
     */
    addCircle: function (json) {
        if (json.style == null) {
            var default_style = this.default_style;
        } else {
            var style = {
                strokeColor: json.style.linecolor ? '#' + json.style.linecolor : 'red',
                fillColor: json.style.fillcolor ? '#' + json.style.fillcolor : "#F7C3C1",
                strokeWeight: json.style.linewidth ? json.style.linewidth : 1,
                fillOpacity: json.style.fillalpha ? json.style.fillalpha : 0.6,
                strokeOpacity: json.style.linealpha ? json.style.linealpha : 0
            };
        }
        var point = new BMap.Point(json.lng, json.lat);
        var circle = new BMap.Circle(point, json.radius, style || default_style);
        circle.overlay_id = json.id;
        circle.type_id = json.type;
        map.addOverlay(circle);
        return circle;
    },

    /**
     * @desc 添加折线
     * @param json {json} json对象
     */
    addLine: function (json) {
        if (json.style == null) {
            var default_style = this.line_default_style;
        } else {
            var style = {
                strokeColor: json.style.linecolor ? '#' + json.style.linecolor : '#00f',
                strokeWeight: json.style.linewidth ? json.style.linewidth : 3,
                strokeOpacity: json.style.linealpha ? json.style.linealpha : 0
            };
        }
        var temp = [];
        var posArr = json.pos;
        for (var j = 1; j < posArr.length; j++) {
            temp.push(new BMap.Point(posArr[j][0], posArr[j][1]));
        }
        var polyline = new BMap.Polyline(temp, style || default_style);
        polyline.overlay_id = json.id;
        polyline.type_id = json.type;
        map.addOverlay(polyline); // 添加折线到地图上
        return polyline;
    },

    /**
     * @desc 添加多边形
     * @param json {json} json对象
     */
    addPolygon: function (json) {
        var temp = [];
        var posArr = json.pos;
        for (var j = 1; j < posArr.length; j++) {
            temp.push(new BMap.Point(posArr[j][0], posArr[j][1]));
        }
        if (json.style == null) {
            var default_style = this.default_style;
        } else {
            var style = {
                strokeColor: json.style.linecolor ? '#' + json.style.linecolor : 'red',
                fillColor: json.style.fillcolor ? '#' + json.style.fillcolor : "#F7C3C1",
                strokeWeight: json.style.linewidth ? json.style.linewidth : 1,
                fillOpacity: json.style.fillalpha ? json.style.fillalpha : 0.2,
                strokeOpacity: json.style.linealpha ? json.style.linealpha : 0
            };
        }
        var polygon = new BMap.Polygon(temp, style || default_style);
        polygon.overlay_id = json.id;
        polygon.type_id = json.type;
        polygon.title = json.title;
        polygon.remark = json.remark;
        map.addOverlay(polygon);
        return polygon;
    },

    /**
     * @desc 打开InfoWindow框
     * @param json {json} json对象
     */
    openInfo: function (json) {
        var html = '<table class="table table-striped table-hover" id="info_table"><tbody>' +
            '<tr><th>名称：</th><td>' + json.name + '</td></tr>' +
            '<tr><th>备注：</th><td>' + json.remark + '</td></tr>' +
            '</tbody></table><div class="dt-pos-a dt-bg-white dt-w100per" style="padding: 5px 12px 5px 20px;bottom:0;left:0;border-top: 1px solid #eeeeee;">' +
            '<span class="btn btn-danger glyphicon glyphicon-trash pull-right dt-mar6r dt-mar6b dt-pointer" style="padding: 6px;" onclick="delArea(' + json.id + ')"></span>' +
            '<span class="btn btn-info glyphicon glyphicon-fullscreen pull-right dt-mar6r dt-mar6b dt-pointer" style="padding: 6px;" onclick="setArea(' + json.id + ')"></span>' +
            '<span class="btn btn-warning glyphicon glyphicon-edit pull-right dt-mar6r dt-mar6b dt-pointer" style="padding: 6px;" onclick="editArea(' + json.id + ')"></span>' +
            '<span class="btn btn-success glyphicon glyphicon-dashboard pull-right dt-mar6r dt-pointer" style="padding: 6px;" onclick="setStyle(' + json.id + ')"></span></div>';
        var infowindow = new BMap.InfoWindow(html, {width: 304, height: 158, title: '区域绘制'});
        var point = new BMap.Point(json.lng, json.lat);
        map.openInfoWindow(infowindow, point);
    },

    /**
     * @desc 拉框缩放功能
     * 需要引入js文件　<script type="text/javascript" src="http://api.map.baidu.com/library/RectangleZoom/1.2/src/RectangleZoom_min.js"></script>
     */
    RectangleZoom: function () {
        var myDrag = new BMapLib.RectangleZoom(map, {
            followText: "拖拽鼠标进行操作",
            strokeWeight: 2
        });
        myDrag.open();
    }
};

/**
 * @desc　覆盖物事件
 */
var Event = {
    click: function (obj, json) {
        obj.addEventListener("click", function (e) {
            var editHtml = ''; var h= 0;
            if(isedit == true){
                h = 34;
                editHtml = '<div class="dt-pos-a dt-bg-white dt-w100per" style="padding: 5px 12px 5px 20px;bottom:0;left:0;border-top: 1px solid #eeeeee;">' +
                    '<span class="btn btn-danger glyphicon glyphicon-trash pull-right dt-mar6r dt-mar6b dt-pointer" style="padding: 6px;" onclick="delArea(' + json.id + ')"></span>' +
                    '<span class="btn btn-info glyphicon glyphicon-fullscreen pull-right dt-mar6r dt-mar6b dt-pointer" style="padding: 6px;" onclick="setArea(' + json.id + ')"></span>' +
                    '<span class="btn btn-warning glyphicon glyphicon-edit pull-right dt-mar6r dt-mar6b dt-pointer" style="padding: 6px;" onclick="editArea(' + json.id + ')"></span>' +
                    '<span class="btn btn-success glyphicon glyphicon-dashboard pull-right dt-mar6r dt-pointer" style="padding: 6px;" onclick="setStyle(' + json.id + ')"></span></div>';
            }
            var html = '<table class="table table-striped table-hover" id="info_table"><tbody>' +
                '<tr><th>名称：</th><td>' + json.name + '</td></tr>' +
                '<tr><th>备注：</th><td>' + json.remark + '</td></tr>' +editHtml+
                '</tbody></table>';
            var infowindow = new BMap.InfoWindow(html, {width: 304, height: 124+h, title: '区域绘制'});
            var point = new BMap.Point(json.lng, json.lat);
            map.openInfoWindow(infowindow, point);

            if(issearch == true){
                var idArr = '';
                var allOverlay = map.getOverlays();
                switch (obj.toString()){
                    case "[object Polygon]":
                        for (var i = 0; i < allOverlay.length - 1; i++) {
                            if(allOverlay[i].type_id == 1 && allOverlay[i].is_show == 1){
                                var result = BMapLib.GeoUtils.isPointInPolygon(allOverlay[i].point, obj);
                                if (result == true) {
                                    idArr += allOverlay[i].marker_id + ',';
                                    allOverlay[i].show();
                                } else {
                                    allOverlay[i].hide();
                                }
                            }
                        }
                        break;
                    case "[object Circle]":
                        for (var i = 0; i < allOverlay.length - 1; i++) {
                            if(allOverlay[i].type_id == 1 && allOverlay[i].is_show == 1){
                                var result = BMapLib.GeoUtils.isPointInCircle(allOverlay[i].point, obj);
                                if (result == true) {
                                    idArr += allOverlay[i].marker_id + ',';
                                    allOverlay[i].show();
                                } else {
                                    allOverlay[i].hide();
                                }
                            }
                        }
                        break;
                }
                var layoutid = document.getElementById('layoutid').value;
                getsearch(layoutid, '', idArr);
            }
        });
    }
};

var html = '<table class="table table-striped table-hover" id="info_table"><tbody>' +
    '<tr><th>名称：</th><td><input name="name" maxlength="10" value="" class="form-control input-sm "></td></tr>' +
    '<tr><th>备注：</th><td><input name="remark" maxlength="20" value="" class="form-control input-sm "></td></tr>' +
    '</tbody></table><div class="dt-pos-a dt-bg-white dt-w100per" style="padding: 5px 12px 5px 20px;bottom:0;left:0;border-top: 1px solid #eeeeee;">' +
    '<span class="btn btn-danger glyphicon glyphicon-trash pull-right dt-mar6r dt-mar6b dt-pointer del-overlay" style="padding: 6px;"></span>' +
    '<span class="btn btn-info glyphicon glyphicon-fullscreen pull-right dt-mar6r dt-mar6b dt-pointer edit-overlay" style="padding: 6px;"></span>' +
    '<span class="btn btn-success glyphicon glyphicon-ok pull-right dt-mar6r dt-pointer submit" style="padding: 6px;"></span></div>';
var infowindow = new BMap.InfoWindow(html, {width: 304, height: 158, title: '区域绘制'});
infowindow.disableCloseOnClick();
infowindow.addEventListener("clickclose", function () {
    window.location.reload();
});

/**
 * @desc 点绘制
 */
function toolsClose() {
    Tools.drawingManager.close();
    Tools.distanceTool.close();
}

/**
 * @desc 点绘制
 */
function addMarker() {
    Tools.distanceTool.close();
    Tools.drawingManager.open();
    Tools.drawingManager.setDrawingMode(BMAP_DRAWING_MARKER);
    Tools.drawingManager.addEventListener("markercomplete", function (overlay) {
        overlay.remove();
        var layoutid = document.getElementById('layoutid').value;
        var url = "/basics/edit/addmarker?layoutid=" + layoutid + "&lng=" + overlay.getPosition().lng + "&lat=" + overlay.getPosition().lat;
        $.dialog('addMarker', url, 400);
        Tools.drawingManager.removeEventListener("markercomplete", arguments.callee);
        Tools.drawingManager.close();
    });
}

/**
 * @desc 圆绘制
 */
function addCircle() {
    Tools.distanceTool.close();
    Tools.drawingManager.open();
    Tools.drawingManager.setDrawingMode(BMAP_DRAWING_CIRCLE);
    Tools.drawingManager.addEventListener("circlecomplete", function (overlay) {
        overlay.setStrokeWeight(3);
        overlay.setStrokeColor('white');
        map.openInfoWindow(infowindow, overlay.getCenter());
        Tools.drawingManager.removeEventListener("circlecomplete", arguments.callee);
        Tools.drawingManager.close();

        overlay.addEventListener("click", function (e) {
            map.openInfoWindow(infowindow, overlay.getCenter());
            //提交表单数据
            $('.submit').click(function () {
                var str = overlay.getRadius() + ',' + overlay.getCenter().lng + ',' + overlay.getCenter().lat;
                pushService(circleType, str);
            });
            $('.del-overlay').click(function () {
                map.closeInfoWindow();
                overlay.remove();
            });
            $('.edit-overlay').click(function () {
                map.closeInfoWindow();
                overlay.enableEditing();
            })
        });

        //提交表单数据
        $('.submit').click(function () {
            var str = overlay.getRadius() + ',' + overlay.getCenter().lng + ',' + overlay.getCenter().lat;
            pushService(circleType, str);
        });
        $('.del-overlay').click(function () {
            map.closeInfoWindow();
            overlay.remove();
        });
        $('.edit-overlay').click(function () {
            map.closeInfoWindow();
            overlay.enableEditing();
        })
    });
}

/**
 * @desc 线绘制
 */
function addLine() {
    Tools.distanceTool.close();
    Tools.drawingManager.open();
    Tools.drawingManager.setDrawingMode(BMAP_DRAWING_POLYLINE);
    Tools.drawingManager.addEventListener("polylinecomplete", function (overlay) {
        //获取中心点
        var view = map.getViewport(overlay.getPath());
        var centerPoint = view.center;
        map.openInfoWindow(infowindow, centerPoint);
        Tools.drawingManager.removeEventListener("polylinecomplete", arguments.callee);
        Tools.drawingManager.close();

        overlay.addEventListener("click", function (e) {
            var view = map.getViewport(overlay.getPath());
            var centerPoint = view.center;
            map.openInfoWindow(infowindow, centerPoint);
            $('.submit').click(function () {
                var str = centerPoint.lng + ',' + centerPoint.lat + '|';
                for (var i = 0; i < overlay.getPath().length; i++) {
                    str += overlay.getPath()[i].lng + ',' + overlay.getPath()[i].lat + '|';
                }
                pushService(polygonType, str);
                overlay.disableEditing();
            });
            $('.del-overlay').click(function () {
                map.closeInfoWindow();
                overlay.remove();
            });
            $('.edit-overlay').click(function () {
                map.closeInfoWindow();
                overlay.enableEditing();
            })
        });

        //提交表单数据
        $('.submit').click(function () {
            var str = centerPoint.lng + ',' + centerPoint.lat + '|';
            for (var i = 0; i < overlay.getPath().length; i++) {
                str += overlay.getPath()[i].lng + ',' + overlay.getPath()[i].lat + '|';
            }
            pushService(polylineType, str);
            overlay.disableEditing();
        });
        $('.del-overlay').click(function () {
            map.closeInfoWindow();
            overlay.remove();
        });
        $('.edit-overlay').click(function () {
            map.closeInfoWindow();
            overlay.enableEditing();
        })
    });
}

/**
 * @desc 多边形绘制
 */
function addRegion() {
    Tools.distanceTool.close();
    Tools.drawingManager.open();
    Tools.drawingManager.setDrawingMode(BMAP_DRAWING_POLYGON);
    Tools.drawingManager.addEventListener("polygoncomplete", function (overlay) {
        overlay.setStrokeWeight(3);
        overlay.setStrokeColor('white');
        //获取中心点
        var view = map.getViewport(overlay.getPath());
        var centerPoint = view.center;
        map.openInfoWindow(infowindow, centerPoint);
        Tools.drawingManager.removeEventListener("polygoncomplete", arguments.callee);
        Tools.drawingManager.close();

        overlay.addEventListener("click", function (e) {
            var view = map.getViewport(overlay.getPath());
            var centerPoint = view.center;
            map.openInfoWindow(infowindow, centerPoint);
            $('.submit').click(function () {
                var str = centerPoint.lng + ',' + centerPoint.lat + '|';
                for (var i = 0; i < overlay.getPath().length; i++) {
                    str += overlay.getPath()[i].lng + ',' + overlay.getPath()[i].lat + '|';
                }
                pushService(polygonType, str);
                overlay.disableEditing();
            });
            $('.del-overlay').click(function () {
                map.closeInfoWindow();
                overlay.remove();
            });
            $('.edit-overlay').click(function () {
                map.closeInfoWindow();
                overlay.enableEditing();
            })
        });

        //提交表单数据
        $('.submit').click(function () {
            var str = centerPoint.lng + ',' + centerPoint.lat + '|';
            for (var i = 0; i < overlay.getPath().length; i++) {
                str += overlay.getPath()[i].lng + ',' + overlay.getPath()[i].lat + '|';
            }
            pushService(polygonType, str);
            overlay.disableEditing();
        });
        $('.del-overlay').click(function () {
            map.closeInfoWindow();
            overlay.remove();
        });
        $('.edit-overlay').click(function () {
            map.closeInfoWindow();
            overlay.enableEditing();
        })
    });
}

/**
 * @desc 批量框选标注点(矩形)
 */
function polygonSelect() {
    Tools.distanceTool.close();
    Tools.drawingManager.open();
    Tools.drawingManager.setDrawingMode(BMAP_DRAWING_POLYGON);
    Tools.drawingManager.addEventListener("polygoncomplete", function (overlay) {
        var idArr = '';
        var allOverlay = map.getOverlays();
        var ply = new BMap.Polygon(overlay.getPath());
        for (var i = 0; i < allOverlay.length - 1; i++) {
            if(allOverlay[i].is_show == 1){
                var result = BMapLib.GeoUtils.isPointInPolygon(allOverlay[i].point, ply);
                if (result == true) {
                    idArr += allOverlay[i].marker_id + ',';
                    allOverlay[i].show();
                } else {
                    allOverlay[i].hide();
                }
            }
        }
        Tools.drawingManager.removeEventListener("polygoncomplete", arguments.callee);
        Tools.drawingManager.close();
        overlay.remove();
        var layoutid = document.getElementById('layoutid').value;
        getsearch(layoutid, '', idArr);
    });
}

/**
 * @desc 批量框选标注点（圆形）
 */
function circleSelect() {
    Tools.distanceTool.close();
    Tools.drawingManager.open();
    Tools.drawingManager.setDrawingMode(BMAP_DRAWING_CIRCLE);
    Tools.drawingManager.addEventListener("circlecomplete", function (overlay) {
        var idArr = '';
        overlay.setStrokeWeight(3);
        overlay.setStrokeColor('white');
        var allOverlay = map.getOverlays();
        var circle = new BMap.Circle(overlay.getCenter(), overlay.getRadius());
        for (var i = 0; i < allOverlay.length - 1; i++) {
            if(allOverlay[i].is_show == 1){
                var result = BMapLib.GeoUtils.isPointInCircle(allOverlay[i].point, circle);
                if (result == true) {
                    idArr += allOverlay[i].marker_id + ',';
                    allOverlay[i].show();
                } else {
                    allOverlay[i].hide();
                }
            }
        }
        Tools.drawingManager.removeEventListener("circlecomplete", arguments.callee);
        Tools.drawingManager.close();
        overlay.remove();
        var layoutid = document.getElementById('layoutid').value;
        getsearch(layoutid, '', idArr);
    });
}

/**
 * @desc 获取省市范围
 * @param keyword
 */
function getAreaFrame(keyword) {
    if (keyword != '') {
        var bdary = new BMap.Boundary();
        bdary.get(keyword, function (rs) {
            var count = rs.boundaries.length;       //统计行政区域的点数量
            for (var i = 0; i < count; i++) {
                var ply = new BMap.Polygon(rs.boundaries[i], {strokeWeight: 2, strokeColor: "#ff0000"}); //建立多边形覆盖物
                ply.temp = 'temp';
                map.addOverlay(ply);                //添加覆盖物
                map.setViewport(ply.getPath(), 12);     //调整视野
            }
            //获取点
            var idArr = '';
            var allOverlay = map.getOverlays();
            for (var j = 0; j < allOverlay.length - 1; j++) {
                var result = BMapLib.GeoUtils.isPointInPolygon(allOverlay[j].point, ply);
                if (result == true) {
                    allOverlay[j].show();
                    idArr += allOverlay[j].marker_id + ',';
                } else {
                    allOverlay[j].hide();
                }
            }
            var layoutid = document.getElementById('layoutid').value;
            var userid = document.getElementById('userid').value;
            $.ajax({
                "type": "POST",
                "url": '/basics/marker/getsearch_ajax',
                "dataType": "json",
                "data": {layoutid: layoutid, idArr: idArr, userid: userid},
                "success": function (data) {
                    $("#mapInfoWrapper").css("display", 'none');
                    $(".pull-box-filter-panel").css("display", 'block');
                    $('#filterListPanelBorder').html('');
                    if (data.code == 200) {
                        var info = data.data;
                        var idarr = new Array();
                        $.each(info, function (i, obj) {
                            idarr[i] = obj.id;
                            var str = '<li class="select_marker dt-pad12x dt-truncate Slist" index="' + obj.id + '">' +
                                '<img class="select_marker" src="/icons/default/' + obj.ico + '">' +
                                '<span class="select_marker marker-title dt-f12 storeList">' + obj.name + '</span>' +
                                '</li>';
                            $('#filterListPanelBorder').append(str);
                            $('#filterCount').text(i - 0 + 1);
                        });
                    }
                }
            });
        });
    }
}

function getsearch(layoutid, name, idArr) {
    var userid = $('#userid').val();
    $.ajax({
        "type": "POST",
        "url": '/basics/marker/getsearch_ajax',
        "dataType": "json",
        "data": {layoutid: layoutid, name: name, idArr: idArr, userid: userid},
        "success": function (data) {
            $("#mapInfoWrapper").css("display", 'none');
            $(".pull-box-filter-panel").css("display", 'block');
            $('#filterListPanelBorder').html('');
            if (data.code == 200) {
                var info = data.data; var str = ''; var num = 0;
                $.each(info, function (i, obj) {
                    str += '<li class="select_marker dt-pad12x dt-truncate Slist" index="' + obj.id + '">' +
                        '<img class="select_marker" src="/icons/default/' + obj.ico + '">' +
                        '<span class="select_marker marker-title dt-f12 storeList">' + obj.name + '</span>' +
                        '</li>';
                    num++;
                });
                if(isedit == true){
                    $('#filterInfoWrapper').removeClass('dt-none');
                    $('#filterInfoWrapper ul').html(str);
                    $('#filterInfoWrapper .filter-count').text(num);
                }else{
                    $('#filterListPanelBorder').html(str);
                    $('#filterCount').text(num);
                }
            } else {
                alert('无数据！')
            }
        }
    });
}

/**
 * @desc 发送坐标数据
 * @param type
 * @param position
 */
function pushService(type, position) {
    var cityId = $('#cityId').val();
    var name = $("input[name=name]").val();
    var remark = $("input[name=remark]").val();
    $.ajax({
        type: 'post',
        url: '/basics/draw/create',
        data: {'cityid': cityId, 'name': name, 'remark': remark, 'type': type, 'position': position},
        dataType: 'json',
        success: function (e) {
            window.location.reload();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('网络错误！请重试……');
        }
    });
}

/**
 * @desc 编辑区域
 * @param id
 */
function setArea(id) {
    var allOverlay = map.getOverlays();
    for (var i = 0; i < allOverlay.length; i++) {
        if (allOverlay[i].overlay_id == id) {
            map.closeInfoWindow();
            var obj = allOverlay[i];
            obj.enableEditing();

            obj.addEventListener("lineupdate", function (e) {
                var str = '';
                if(this.type_id == 2){
                    str = this.getRadius() + ',' + this.getCenter().lng + ',' + this.getCenter().lat;
                }else{
                    var view = map.getViewport(this.getPath());
                    var centerPoint = view.center;
                    str = centerPoint.lng + ',' + centerPoint.lat + '|';
                    for (var j = 0; j < obj.getPath().length; j++) {
                        str += obj.getPath()[j].lng + ',' + obj.getPath()[j].lat + '|';
                    }
                    this.disableEditing();
                }
                $.post('/basics/draw/setposition', {'id': id, 'position': str}, function (data) {});
            });
        }
    }
}

/**
 * @desc 图层编辑模态框
 * @param id
 */
function setStyle(id) {
    var url = "/basics/draw/setstyle?id=" + id;
    $.dialog('setStyle', url, 570);
}

/**
 * @desc 区域轮廓修改模态框
 * @param id
 */
function editArea(id) {
    var url="/basics/draw/edit?id="+id;
    $.dialog('editArea', url, 400);
}

/**
 * @desc 区域轮廓门店模态框
 * @param id
 */
function delArea(id) {
    var url="/basics/draw/del?id="+id;
    $.alert('delArea', url, '删除区域', '确定删除区域信息吗？', 400, function () {
        map.closeInfoWindow();
        window.location.reload();
    });
}

/**
 * @desc　设置地图背景色
 * @param style
 */
function changeMapStyle(style){
    toolsClose();
    map.setMapType(BMAP_NORMAL_MAP);
    map.setMapStyle({style:style});
}

/**
 * @desc　设置地图底图类型
 * @param type
 */
function changeMapType(type) {
    toolsClose();
    switch(type) {
        case "hybrid":
            map.setMapType(BMAP_HYBRID_MAP);
            break;
        default:
            map.setMapType(BMAP_NORMAL_MAP);
            break;
    }
}

/**
 * @desc　获取用户所在位置（有偏差，待解决）
 */
function geolocation() {
    var geolocation = new BMap.Geolocation();
    var gc = new BMap.Geocoder();
    geolocation.getCurrentPosition( function(r) {   //定位结果对象会传递给r变量
            if(this.getStatus() == BMAP_STATUS_SUCCESS) {  //通过Geolocation类的getStatus()可以判断是否成功定位。
                var pt = r.point;
                gc.getLocation(pt, function(rs){
                    var addComp = rs.addressComponents;
                    alert(addComp.province + addComp.city + addComp.district + addComp.street + addComp.streetNumber);
                });
            } else {
                //关于状态码
                //BMAP_STATUS_SUCCESS   检索成功。对应数值“0”。
                //BMAP_STATUS_CITY_LIST 城市列表。对应数值“1”。
                //BMAP_STATUS_UNKNOWN_LOCATION  位置结果未知。对应数值“2”。
                //BMAP_STATUS_UNKNOWN_ROUTE 导航结果未知。对应数值“3”。
                //BMAP_STATUS_INVALID_KEY   非法密钥。对应数值“4”。
                //BMAP_STATUS_INVALID_REQUEST   非法请求。对应数值“5”。
                //BMAP_STATUS_PERMISSION_DENIED 没有权限。对应数值“6”。(自 1.1 新增)
                //BMAP_STATUS_SERVICE_UNAVAILABLE   服务不可用。对应数值“7”。(自 1.1 新增)
                //BMAP_STATUS_TIMEOUT   超时。对应数值“8”。(自 1.1 新增)
                switch( this.getStatus() ) {
                    case 2:
                        alert( '位置结果未知 获取位置失败.' );
                        break;
                    case 3:
                        alert( '导航结果未知 获取位置失败..' );
                        break;
                    case 4:
                        alert( '非法密钥 获取位置失败.' );
                        break;
                    case 5:
                        alert( '对不起,非法请求位置  获取位置失败.' );
                        break;
                    case 6:
                        alert( '对不起,当前 没有权限 获取位置失败.' );
                        break;
                    case 7:
                        alert( '对不起,服务不可用 获取位置失败.' );
                        break;
                    case 8:
                        alert( '对不起,请求超时 获取位置失败.' );
                        break;
                }
            }
        },
        {enableHighAccuracy: true}
    )
}


/*
 switch (obj.toString()){
 case "[object Polyline]":
 break;
 case "[object Polygon]":
 break;
 case "[object Circle]":
 break;
 }*/
