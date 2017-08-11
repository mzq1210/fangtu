/**
 * Created by mzq on 17-1-14.
 */
//绘制标注文件
var createMarker = {

    //默认标注大小
    defaultSize : 's',
    //默认标注icon
    defaultIcon : '/icons/default/ff0000-s-null.png',
    //默认标注颜色
    defaultColor : 'a3e46b',

    /**
     * @desc 开始创建标注
     * @param json
     */
    init : function (json){
        var size_init = json.size || this.defaultSize;
        var size = this.setIconSize(size_init);
        var ico = '/icons/default/'+json.ico || this.defaultIcon;
        var label = this.createLabel(json);
        var marker = new BMap.Marker(
            new BMap.Point(json.lng, json.lat),
                {icon: new BMap.Icon(ico, size)}
            );
        if(json.lable != 0){ //是否设置label
            marker.setLabel(label);
        }
        marker.marker_id = json.id;
        marker.layerid = json.layerid;
        marker.is_show = json.is_show;
        marker.type_id = 1;
        map.addOverlay(marker);
        if(json.is_show == '0'){
            marker.hide();
        }
        this.addClickInfobox(marker, label, json);
    },

    /**
     * @desc 获取icon尺寸
     * @param s
     * @returns
     */
    setIconSize : function(s) {
        var size = {};
        switch(s) {
            case "s":
                size = new BMap.Size(20, 30);
                break;
            case "m":
                size = new BMap.Size(30, 50);
                break;
            case "l":
                size = new BMap.Size(35, 58);
                break;
            default:
                size = new BMap.Size(20, 30);
                break;
        }
        return size;
    },

    /**
     * @desc 创建label
     * @param json
     * @returns
     */
    createLabel : function(json){
        var showName ={}; //label偏移量
        var styleOptions = {
            color : "rgb(62, 62, 62)",
            fontSize : "12px",
            backgroundColor :"#FFF",
            border :"solid 1px red",
            fontFamily: "arial, sans-serif",
            lineHeight: "24px",
            borderRadius: "6px",
            padding: "0 8px"
        };
        var size_init = json.size || this.defaultSize;
        var size = this.setLabelSize(size_init);
        if(typeof (json.lable) != 'undefined' && json.lable != 0){
            showName = json.lable_field.name+':'+json.lable_field.value;
        }else{
            showName = '';
        }

        var color = json.color || this.defaultColor;
        if(!showName){
            styleOptions.border = 'solid 0px #'+color;
        }else{
            styleOptions.border = 'solid 1.8px #'+color;
        }
        var label = new BMap.Label(showName,{offset:size});
        label.setStyle(styleOptions);
        return label;
    },

    /**
     * @desc 获取Label尺寸
     * @param s
     * @returns
     */
    setLabelSize : function(s) {
        var size = {};
        switch(s) {
            case "s":
                size = new BMap.Size(20, 0);
                break;
            case "m":
                size = new BMap.Size(28, 5);
                break;
            case "l":
                size = new BMap.Size(36, 10);
                break;
            default:
                size = new BMap.Size(20, 0);
                break;
        }
        return size;
    },

    /**
     * @desc 添加点击事件
     * @param marker
     * @param label
     * @param json
     */
    addClickInfobox : function(marker, label, json){
        var infoBox = this.createInfobox(json);
        marker.addEventListener("click",function(e){
            if(infoBoxTemp){
                infoBoxTemp.close();
            }
            infoBoxTemp = infoBox;
            infoBox.open(marker);
        });
        label.addEventListener("click",function(e){
            infoBox.open(marker);
        });
        //marker移入事件
        marker.addEventListener("mouseover",function(e){
            marker.setTop(true,9999);
        });
        //label移入事件
        label.addEventListener("mouseover",function(e){
            marker.setTop(true,9999);
        });
        //marker移出事件
        marker.addEventListener("mouseout",function(e){
            marker.setTop(false);
        });
        //label移出事件
        label.addEventListener("mouseout",function(e){
            marker.setTop(false);
        });
    },

    /**
     * @desc 添加点击事件
     * @param marker
     * @param label
     * @param json
     */
    addClickInfoWindow : function(marker, label, json){
        var infowindow =this.createInfoWindow(json);
        //marker点击事件
        marker.addEventListener("click",function(e){
            var p = e.target;
            var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
            map.panTo(new BMap.Point(p.getPosition().lng, p.getPosition().lat));
            marker.openInfoWindow(infowindow,point); //开启信息窗口
        });
        //label点击事件
        label.addEventListener("click",function(e){
            var p = e.target;
            var point = new BMap.Point(p.point.lng, p.point.lat);
            map.panTo(new BMap.Point(p.getPosition().lng, p.getPosition().lat));
            marker.openInfoWindow(infowindow,point); //开启信息窗口
        });
        //marker移入事件
        marker.addEventListener("mouseover",function(e){
            marker.setTop(true,9999);
        });
        //label移入事件
        label.addEventListener("mouseover",function(e){
            marker.setTop(true,9999);
        });
        //marker移出事件
        marker.addEventListener("mouseout",function(e){
            marker.setTop(false);
        });
        //label移出事件
        label.addEventListener("mouseout",function(e){
            marker.setTop(false);
        });
    },

    /**
     * @desc 创建弹出框
     * @param json
     * @returns
     */
    createInfoWindow : function(json){
        var editHtml = ''; var h = 0;
        if(isedit == true){
            h = 34;
            editHtml = '<div class="bottom">'+
                '<span class="glyphicon glyphicon-trash pull-right dt-mar6r dt-pointer" onclick="delStore('+json.id+')" title="删除"></span>'+
                '<span class="glyphicon glyphicon-edit pull-right dt-mar6r dt-pointer" onclick="editStore('+json.id+')" title="编辑属性"></span>'+
                '<span class="glyphicon glyphicon-dashboard pull-right dt-mar6r dt-pointer" onclick="storeStyle('+json.id+')" title="更换图标"></span></div>';
        }
        var html = '<table class="table table-striped table-hover" id="info_table"><tbody>';
        for (var i in json.show_field) {
            h += 34;
            html += '<tr><th>'+json.show_field[i].name+'：</th><td>'+json.show_field[i].value+'</td></tr>';
        }
        html += '</tbody></table>'+editHtml;
        return new BMap.InfoWindow(html,{width:344,height:55+h,title:json.name});
    },

    /**
     * @desc 创建弹出框
     * @param json
     * @returns
     */
    openInfoWindow : function(json){
        if(json.is_show == 0) return;
        var editHtml = ''; var h = 0;
        if(isedit == true){
            h = 34;
            editHtml = '<div class="bottom">'+
                '<span class="glyphicon glyphicon-trash pull-right dt-mar6r dt-pointer" onclick="delStore('+json.id+')" title="删除"></span>'+
                '<span class="glyphicon glyphicon-edit pull-right dt-mar6r dt-pointer" onclick="editStore('+json.id+')" title="编辑属性"></span>'+
                '<span class="glyphicon glyphicon-dashboard pull-right dt-mar6r dt-pointer" onclick="storeStyle('+json.id+')" title="更换图标"></span></div>';
        }
        var html = '<table class="table table-striped table-hover" id="info_table"><tbody>';
        for (var i in json.show_field) {
            h += 34;
            html += '<tr><th>'+json.show_field[i].name+'：</th><td>'+json.show_field[i].value+'</td></tr>';
        }
        html += '</tbody></table>'+editHtml;
        map.openInfoWindow(
            new BMap.InfoWindow(html,{width:344,height:55+h,title:json.name}),
            new BMap.Point(json.lng, json.lat)
        );
        map.panTo(new BMap.Point(json.lng, json.lat));
    },

    /**
     * @desc 创建Infobox
     */
    createInfobox : function(json) {
        var editHtml = ''; var h = 36;
        if(isedit == true){
            editHtml = '<div class="dt-pos-a dt-bg-white dt-w100per" style="padding: 5px 12px 5px 20px;bottom:0;left:0;border-top: 1px solid #eeeeee;">'+
                '<span class="btn btn-danger glyphicon glyphicon-trash pull-right dt-mar6r dt-mar6b dt-pointer" style="padding: 6px;" onclick="delStore('+json.id+')"></span>'+
                '<span class="btn btn-info glyphicon glyphicon-repeat pull-right dt-mar6r dt-pointer" style="padding: 6px;" onclick="storeResetStyle('+json.id+')"></span>'+
                '<span class="btn btn-warning glyphicon glyphicon-edit pull-right dt-mar6r dt-mar6b dt-pointer" style="padding: 6px;" onclick="editStore('+json.id+')"></span>'+
                '<span class="btn btn-success glyphicon glyphicon-dashboard pull-right dt-mar6r dt-pointer" style="padding: 6px;" onclick="storeStyle('+json.id+')"></span></div>';
        }

        var html = '<hr style="margin-top:28px;margin-bottom:2px;"><div id="attr_details"><table id="info_table" class="table table-striped table-hover"><tbody>';
        for (var i in json.show_field) {
            var namestr = json.show_field[i].name;
            var valuestr = json.show_field[i].value;
            if (valuestr.length >33 ){
                h += 68;
            }else{
                h += 34;
            }
            if (namestr.length >6 ){
                h += 34;
            }

            html += '<tr><th>'+json.show_field[i].name+'：</th><td>'+json.show_field[i].value+'</td></tr>';
        }
        html += '</tbody></table></div>'+editHtml+'<div class="leaflet-popup-tip-container"><div class="leaflet-popup-tip"></div></div>';

        return new BMapLib.InfoBox(map,html,{
            boxStyle:{
                background:"white",
                width: "340px",
                height: 60+h+"px",
                borderRadius: "5px",
                boxShadow: "0 3px 14px rgba(0,0,0,0.4)",
                padding: "0 20px"
            },
            closeIconUrl:'http://api0.map.bdimg.com/images/iw_close1d3.gif',
            closeIconMargin: "9px",
            enableAutoPan: true
        });
    },

    /**
     * @desc 创建infobox弹出框
     * @param json
     * @returns
     */
    openInfobox : function(json){
        if(json.is_show == 0) return;
        var infoBox = this.createInfobox(json);
        if(infoBoxTemp){
            infoBoxTemp.remove();
        }
        infoBoxTemp = infoBox;
        var allOverlay = map.getOverlays();
        for (var i = 0; i < allOverlay.length; i++){
            if(json.id == allOverlay[i].marker_id){
                infoBox.open(allOverlay[i]);
            }
        }
    },

    /**
     * @desc 移除指定图层下的marker
     * @param layerid
     */
    hide : function(layerid) {
        var allOverlay = map.getOverlays();
        for (var i = 0; i < allOverlay.length; i++){
            if(allOverlay[i].layerid == layerid){
                allOverlay[i].hide();
                allOverlay[i].is_show = 0;
            }
        }
    },

    /**
     * @desc 移除指定图层下的marker
     * @param id
     */
    hideMarker : function(id) {
        var allOverlay = map.getOverlays();
        for (var i = 0; i < allOverlay.length; i++){
            if(allOverlay[i].marker_id == id){
                allOverlay[i].hide();
                allOverlay[i].is_show = 0;
            }
        }
    },

    /**
     * @desc 移除指定图层下的marker
     * @param layerid
     */
    show : function(layerid) {
        var allOverlay = map.getOverlays();
        for (var i = 0; i < allOverlay.length; i++){
            if(allOverlay[i].layerid == layerid){
                allOverlay[i].show();
                allOverlay[i].is_show = 1;
            }
        }
    },

    /**
     * @desc 移除指定图层下的marker
     * @param id
     */
    showMarker : function(id) {
        var allOverlay = map.getOverlays();
        for (var i = 0; i < allOverlay.length; i++){
            if(allOverlay[i].marker_id == id){
                allOverlay[i].show();
                allOverlay[i].is_show = 1;
            }
        }
    },

    /**
     * @desc 移除指定图层下的marker
     * @param layerid
     */
    remove : function(layerid) {
        var allOverlay = map.getOverlays();
        for (var i = 0; i < allOverlay.length; i++){
            if(allOverlay[i].layerid == layerid){
                allOverlay[i].remove();
            }
        }
    },

    /**
     * @desc 移除指定图层下的marker
     * @param id
     */
    removeMarker : function(id) {
        var allOverlay = map.getOverlays();
        for (var i = 0; i < allOverlay.length; i++){
            if(allOverlay[i].marker_id == id){
                allOverlay[i].remove();
            }
        }
    }

};