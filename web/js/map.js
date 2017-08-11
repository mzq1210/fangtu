//临时infoBox框
var infoBoxTemp = null;

if (window.WebSocket) {

    websocket = new WebSocket(sServer);
    websocket.onclose = function (evt) {
        console.log("Disconnected");
    };

//监听连接打开
    websocket.onopen = function (evt) {
        console.log('swoole open.....')
        var userid = document.getElementById('userid').value;
        var layoutid = document.getElementById('layoutid').value;
        var data = '{"type":"layer","layoutid":"'+layoutid+'", "userid":"'+userid+'"}';
        websocket.send(data);
    };
//监听
    websocket.onmessage = function (evt) {
        var data = JSON.parse(evt.data);
        switch(data.type) {
            case "upload":
                addStore(data);
                break;
            case "init":
                createMarker.init(data);
                break;
            case "searchData":
                listStore(data);
                break;
            case "sortStore":
                sortStore(data);
                break;
            case "loadLayerStore":
                loadLayerStoreReceive(data);
                break;
            default:
                createMarker.init(data);
                break;
        }
    };
}


/**
 * @desc 更换图层图标
 * @param layerid
 * @param info
 */
function updateIco(layerid, info) {
    $(".layer-store"+layerid+" img").attr('src', info.ico);
    var userid = document.getElementById('userid').value;
    var layoutid = document.getElementById('layoutid').value;
    var allOverlay = map.getOverlays();
    if(info.lable != ''){
        for (var j = 0; j < allOverlay.length; j++){
            if(allOverlay[j].layerid == layerid){
                allOverlay[j].remove();
            }
        }
        var sendData = '{"type":"layer","layoutid":"'+ layoutid +'","layerid":"'+layerid+'", "userid":"'+userid+'"}';
        websocket.send(sendData);
    }else{
        for (var i = 0; i < allOverlay.length; i++){
            if(allOverlay[i].layerid == layerid){
                var size = createMarker.setIconSize(info.size);
                allOverlay[i].setIcon(new BMap.Icon(info.ico, size));
            }
        }
    }
}

/**
 * @desc 更换单个图标
 * @param storeid
 * @param src　路径
 * @param s  大小
 */
function updateStoreIco(storeid, src, s) {
    $(".store"+storeid+" img").attr('src', src);
    var allOverlay = map.getOverlays();
    for (var i = 0; i < allOverlay.length; i++){
        if(allOverlay[i].marker_id == storeid){
            var size = createMarker.setIconSize(s);
            allOverlay[i].setIcon(new BMap.Icon(src, size));
        }
    }
}

/**
 * @desc 更换字段
 * @param layerid
 */
function updateInfoboxFiled(layerid) {
    var userid = document.getElementById('userid').value;
    var layoutid = document.getElementById('layoutid').value;
    var allOverlay = map.getOverlays();
    for (var j = 0; j < allOverlay.length; j++){
        if(allOverlay[j].layerid == layerid){
            allOverlay[j].remove();
        }
    }
    var sendData = '{"type":"layer","layoutid":"'+ layoutid +'","layerid":"'+layerid+'", "userid":"'+userid+'"}';
    websocket.send(sendData);
}

//批量添加数据返回后添加到左侧列表
function addStore(obj){
    if (obj.subType == 'columnwrong'){
        $("#file_upload_desc_tip").css("color","red").html(obj.msg).show();
        return false;
    }
    if (obj.subType == 'rowerror'){
        $("#file_upload_desc_tip").css("color","red").html(obj.msg).show();
        return false;
    }
    if(obj.subType == 'finish'){
        $("#progress_addItem .tip").html(obj.msg);
        var download = '';
        if(obj.download){
            download = '<a href="'+obj.download+'">点击下载错误数据</a>';
            $('#addStoreStatus').append(download);
        }

        $("#progress_addItem img").css('display','none');
        $("#progress_addItem .progress").css('display','none');
        return false;
    }
    if(obj.subType == 'alreadyexist'){
        $("#file_upload_desc_tip").css("color","red").html(obj.msg).show();
        return false;
    }
    document.getElementById('localUpload').style.display="none";
    document.getElementById('submitUpload').style.display="none";
    document.getElementById('progress_addItem').style.display="block";
    var processBar = document.getElementsByClassName('progress-bar')[0];
    var num = Math.floor((obj.yesRow/(obj.allRow-obj.noRow))*100);
    processBar.innerHTML =num +"%";
    processBar.style.width = num +"%";
    document.getElementById('addStoreStatus').innerHTML = "共有 "+obj.allRow+" 条数据记录，定位成功 "+obj.yesRow+" 条,定位失败 "+obj.noRow+" 条。" ;
    var oldAllStore = $('#layerStoreNum'+obj.layerid).html();
    if(obj.subType == 'yes'){
        var ss = '<li class="select_marker dt-truncate Slist layer-store'+obj.layerid+'" index="'+obj.id+'"><img class="select_marker" src="/icons/default/'+obj.ico+'"> <span layout_id="'+obj.layoutid+'" class="select_marker marker-title dt-f12 storeList" index="'+obj.id+'" title="'+obj.name+'">'+ obj.name +'</span></li>';
        var newAllStore = parseInt(oldAllStore) + 1;
        $('#layerStoreNum'+obj.layerid).html(newAllStore);
        $('#layerid'+obj.layerid).append(ss);
        createMarker.init(obj);
    }
}

//点击更新左侧列表显示数据
function listStore(obj){
    var ss = '<li class="select_marker dt-truncate Slist layer-store'+obj.layerid+' store'+ obj.id +'" index="'+obj.id+'"><img class="select_marker" src="/icons/default/'+obj.ico+'"> <span layout_id="'+obj.layoutid+'" class="select_marker marker-title dt-f12 storeList" index="'+obj.id+'" title="'+obj.showColumn+'">'+ obj.showColumn +'</span></li>';
    $('#layerid'+obj.layerid).append(ss);
}

//左侧图层加载更多的记录
function loadLayerStoreSend(layer){
    $.ajax({
        type:'post',
        url:'/basics/edit/layerstore_ajax',
        data:{"layer":layer,"type":"loadLayerStore"},
        dataType:'json',
        success:function(data){
            if(data.code == 200) {
                document.getElementById('loadLayerStore'+layer).style.display="none";
                var obja = eval(data);
                var obj = obja.data;
                for (var i=0 ; i < obj.length;i++){
                    var ss = '<li class="closeMore select_marker dt-truncate Slist layer-store'+obj[i].layerid+'" index="'+obj[i].id+'"><img class="select_marker" src="/icons/default/'+obj[i].ico+'"> <span layout_id="'+obj[i].layoutid+'" class="select_marker marker-title dt-f12 storeList" index="'+obj[i].id+'" title="'+obj[i].showColumn+'">'+ obj[i].showColumn +'</span></li>';
                    $('#layerid'+obj[i].layerid).append(ss);
                }
                $('#closeMore'+obj[0].layerid).removeClass("dt-none");
            } else {
                alert(data.data);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert('网络错误！请重试……');
        }
    });
}

function closeMore(layer){
    $('.closeMore').attr("class","dt-none");
    $("#closeMore" + layer).addClass("dt-none");
    document.getElementById('loadLayerStore'+layer).style.display="block";
}

function searchData(obj){
    var column = obj.value;
    var layout = document.getElementById('layoutid').value;
    var layer = document.getElementById('setTitle-layerid').value;
    var form = document.getElementById('layerid'+layer);
    form.innerHTML = "";
    if(!$("#closeMore" + layer).hasClass("dt-none")){
        $("#closeMore" + layer).addClass("dt-none");
        document.getElementById('loadLayerStore'+layer).style.display="block";
    }
    var sendData = '{"layout":"'+ layout +'","layer":"'+layer+'","type":"searchData","column":"' + column + '"}';
    websocket.send(sendData);
}
$("#file").change(function(){
    $("#file_upload_desc_tip").css("color","blue").html('已经选择数据').show();
});
function sendFile() {
    var file = document.getElementById("file").files[0];
    var layer = document.getElementById('layerFile').value;
    var layout = document.getElementById('layoutid').value;
    var userid = $('#userid').val();
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function (e) {
        var img_data = '{"layout":"'+ layout +'","layer":"'+layer+'","userid":"'+userid+'","type":"upload","data":"' + this.result + '"}';
        console.log("\n开始发送文件");
        websocket.send(img_data);
    };
    return false;
}

//隐藏上传状态信息
function closeStatus(){
    document.getElementById('progress_addItem').style.display="none";
    document.getElementById('localUpload').style.display="block";
    document.getElementById('submitUpload').style.display="inline-block";
    document.getElementById('show_img').style.display="block";
    document.getElementById('show_progress').style.display="block";
}
//排序是点击默认隐藏底部选择框
function sortHidden(){
    var sortField = document.getElementById('data_sort_fields');
    document.getElementById("sortRadio").value = "default";
    sortField.style.display = 'none';
    sendSort();
}

//点击排序显示底部选择框
function sortShow(val){
    var sortField = document.getElementById('data_sort_fields');
    sortField.style.display = '';
    document.getElementById("sortRadio").value = val;
    sendSort();
}

//点击排序之后请求后台数据
function sortSel(val){
    document.getElementById("sortSelect").value = val;
    sendSort();
}

function sendSort(){
    var sortRadio = document.getElementById("sortRadio").value;
    var sortSelect = document.getElementById("sortSelect").value;
    var layer = document.getElementById('setOrder-layerid').value;
    var form = document.getElementById('layerid'+layer);
    var layout = document.getElementById('layoutid').value;
    form.innerHTML = "";
    if(!$("#closeMore" + layer).hasClass("dt-none")){
        $("#closeMore" + layer).addClass("dt-none");
        document.getElementById('loadLayerStore'+layer).style.display="block";
    }
    var sendData = '{"layout":"'+ layout +'","layer":"'+layer+'","type":"sortStore","sortRadio":"' + sortRadio + '","sortSelect":"'+ sortSelect +'"}';
    websocket.send(sendData);
}

function sortStore(obj){
    var ss = '<li class="select_marker  dt-truncate Slist layer-store'+obj.layerid+'" index="'+obj.id+'"><img class="select_marker" src="/icons/default/'+obj.ico+'"> <span layout_id="'+obj.layoutid+'" class="select_marker marker-title dt-f12 storeList" index="'+obj.id+'" title="'+obj.showColumn+'">'+ obj.showColumn +'</span></li>';
    $('#layerid'+obj.layerid).append(ss);
}

function setMsgBox(layerid){
    var url = "/basics/layer/setmsgbox?layerid="+layerid;
    $.dialog("editStore",url,400);
}

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

    //左侧列表图层显隐状态切换
    $(".layer-top").click(function () {
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

    //左侧列表眼睛状态切换
    $(".display_layer").click(function(){
        var layerid = $(this).parent().attr('layer-id'); var status = 0;var maker = $(this).attr("maker");
        if($(this).hasClass("glyphicon-eye-open")){
            $(this).parent().attr('is_show',0);status = 0;
            $(this).removeClass('glyphicon-eye-open font-green').addClass('glyphicon-eye-close font-red');
            $(this).siblings('span').css("display", "none");
            createMarker.hide(layerid);
        }else{
            $(this).parent().attr('is_show',1);status = 1;
            $(this).removeClass('glyphicon-eye-close font-red').addClass('glyphicon-eye-open font-green');
            $(this).siblings('span').css("display", "block");
            createMarker.show(layerid);
        }
        if(maker != 'maker'){ //不等于maker表示编辑,等于maker表示查看页面
            $.post("/basics/layer/setshow_ajax", {layerid:layerid,status:status}, function(data){});
        }
        return false;
    });

    //左侧图层('更多')面板切换
    $(".more").click(function () {
        $('.more-list').addClass('dt-none');
        var UL = $(this).next('.more-list');
        if (UL.hasClass('dt-none')) {
            UL.removeClass('dt-none');
        } else {
            UL.addClass('dt-none');
        }
    });

    //左侧图层'x'关闭('更多')面板
    $(".close-list").click(function () {
        $(this).parent().addClass('dt-none');
    });

    //左侧图层循环改变layerid表单值
    $(document).on('click','.titles,.newtitles',function(){
        var layerid = $(this).parents('.box').attr('layer-id');
        $("input[name=layerid]").each(function (){
            $(this).val(layerid)
        });
    });

    //右侧工具栏('搜索')按钮
    $("#searchBtn").click(function () {
        $(this).find('#searchControl').css("width", "247px");
        $(this).find('input').css("width", "235px");
    });

    //编辑页面右侧工具栏('聚焦')按钮切换
    $.tab_display($("#pullBoxPanel"), $("#pullBoxPanel").next());
    //右侧地图样式
    $.tab_display($(".set-mapstyle"), $(".map_style"));
    //展示页面区域绘制弹框控制
    $.tab_display($("#search_control"), $(".search-one"));
    //展示页面区域搜索弹框控制
    $.tab_display($("#search_area"), $(".search-two"));

    //右侧工具栏关闭('聚焦')弹框
    $("#pullBoxSearch, #pullBoxCircle").click(function () {
        $(this).parent().addClass('dt-none');
    });

    //右侧工具栏('搜索')框获取省市范围
    $.search_keydown($("#search_input, #searchArea"));
    
    //展示页面区域搜索（提交按钮搜索）
    $("#searchAreaButton").click(function () {
        var keyword = $('#searchArea').val();
        getAreaFrame(keyword);
    });

    $("#store-tbody").on("click",".store_info",function(){
        $(this).children("p").hide();
        $(this).children(".input_store_info").show().focus();
    });

    //编辑页面右侧工具栏('搜索')框获取省市范围（enter键）
    $("#searchInput").keydown(function (e) {
        var e = e || event, keycode = e.which || e.keyCode;
        if (keycode === 13) {
            var keyword = $(this).val();
            var layoutid = $("#layoutid").val();
            getsearch(layoutid, keyword);
        }
    });
    //编辑页面右侧工具栏('搜索')框获取省市范围（提交按钮）
    $(".input-group-btn").click(function () {
        var name = $("#searchInput").val();
        var layoutid = $("#layoutid").val();
        getsearch(layoutid, name);
    });

    //展示页面清除
    $(".clear-search-all").click(function () {
        $("#mapInfoWrapper").css("display",'block');
        $(".pull-box-filter-panel").css("display",'none');
        //清空搜索框
        $("#searchInput, #searchArea").val('');
        $(".search-one, .search-two").addClass('dt-none');
        var allOverlay = map.getOverlays();
        for (var j = 0; j < allOverlay.length; j++){
            //删除临时的区域覆盖物
            if(allOverlay[j].temp == 'temp'){
                allOverlay[j].remove();
            }
            if(allOverlay[j].type_id == 1 && allOverlay[j].is_show == 1){
                allOverlay[j].show();
            }
        }
    });

    //编辑页面搜索（关闭）
    $(".close-filter-panel").click(function () {
        $("#mapInfoWrapper").css("display",'block');
        $('#filterInfoWrapper').addClass('dt-none');
        var allOverlay = map.getOverlays();
        for (var j = 0; j < allOverlay.length; j++){
            if(allOverlay[j].type_id == 1 && allOverlay[j].is_show == 1){
                allOverlay[j].show();
            }
        }
    });
    
    //数据视图访问时调用的ajax方法
    $(".dataviewspan").click(function(){
        var layerid = $(this).attr("layer-id");
        $("#dataViewLayerid").val(layerid);
        $.ajax({
            url:"/basics/store/getstore_ajax",
            type:"POST",
            dataType:"json",
            data:{layerid:layerid},
            success:function(data){
                //修改图层标题
                var layername = data.data.layername;
                $("#dataViewName").html(layername);
                var head = '<tr class="ui-jqgrid-labels"><th class="ui-th-column ui-th-ltr" style="width: 35px;text-align:center;"></th>'; //<th class="ui-th-column ui-th-ltr" style="width: 60px;text-align:center;">显示</th>
                $.each(data.data.head,function(key,value){
                    head += '<th class="ui-th-column ui-th-ltr dt-pos-r" style="width: 168px;text-align:center;" >'+ value +'</th>';
                });
                head += '</tr>';
                $("#dataViewThead").html(head);

                var html = '';
                $.each(data.data.data,function(key,value){
                    html += '<tr class="jqgrow ui-row-ltr" tabindex="-1"><td class="jqgrid-rownum active" style="text-align:center;width: 35px;">'+ (parseInt(key)+1) +'</td><td class="store_info"><p>'+ value.name +'</p><input type="text" value="'+ value.name +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="1" style="display:none;"></td> <td class="store_info"><p>'+ value.address +'</p><input type="text" value="'+ value.address +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="2" style="display:none;"></td>';
                    for(var i=3;i<=data.data.headcount;i++){
                        html += '<td class="store_info"><p>'+ eval("value.v"+i) +'</p><input type="text" value="'+ eval("value.v"+i) +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="'+ i +'" style="display:none;"></td>';
                    }
                    html += '</tr>';
                });
                $("#dataViewTbody").html(html);
                $("input[name=dataviewpage]").val(data.data.page + 1);
                $("#jqGridPager_right div").html("共" + data.data.count + "条");
                $("#sp_1_jqGridPager").html(data.data.pages);
            }
        });
        $("#dataView").show();
    });

    $("#dataListClose").click(function(){
        $("#searchDataList").val("");
        $("#dataViewThead").empty();
        $("#dataViewTbody").empty();
        $("#dataView").hide();
    });

    $("#first_jqGridPager").click(function(){
        var page = $("input[name=dataviewpage]").val();
        var layerid = $("#dataViewLayerid").val();
        var search = $("#searchDataList").val();
        if(page == 1){
            return false;
        }
        $.ajax({
            url:"/basics/store/getstore_ajax",
            type:"POST",
            dataType:"json",
            data:{layerid:layerid,search:search},
            success:function(data){
                $("#dataViewTbody").empty();
                var html = '';
                $.each(data.data.data,function(key,value){
                    html += '<tr class="jqgrow ui-row-ltr" tabindex="-1"><td class="jqgrid-rownum active" style="text-align:center;width: 35px;">'+ (parseInt(key)+1) +'</td><td class="store_info"><p>'+ value.name +'</p><input type="text" value="'+ value.name +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="1" style="display:none;"></td> <td class="store_info"><p>'+ value.address +'</p><input type="text" value="'+ value.address +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="2" style="display:none;"></td>';
                    for(var i=3;i<=data.data.headcount;i++){
                        html += '<td class="store_info"><p>'+ eval("value.v"+i) +'</p><input type="text" value="'+ eval("value.v"+i) +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="'+ i +'" style="display:none;"></td>';
                    }
                    html += '</tr>';
                });
                $("#dataViewTbody").html(html);
                $("input[name=dataviewpage]").val(parseInt(data.data.page) + 1);
            }
        });
    });

    $("#prev_jqGridPager").click(function(){
        var page = $("input[name=dataviewpage]").val();
        var layerid = $("#dataViewLayerid").val();
        var search = $("#searchDataList").val();
        if(page == 1){
            return false;
        }
        page -=2;
        $.ajax({
            url:"/basics/store/getstore_ajax",
            type:"POST",
            dataType:"json",
            data:{layerid:layerid,page:page,search:search},
            success:function(data){
                $("#dataViewTbody").empty();
                var html = '';
                $.each(data.data.data,function(key,value){
                    html += '<tr class="jqgrow ui-row-ltr" tabindex="-1"><td class="jqgrid-rownum active" style="text-align:center;width: 35px;">'+ (parseInt(key)+1+data.data.page*data.data.pageSize) +'</td> <td class="store_info"><p>'+ value.name +'</p><input type="text" value="'+ value.name +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="1" style="display:none;"></td> <td class="store_info"><p>'+ value.address +'</p><input type="text" value="'+ value.address +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="2" style="display:none;"></td>';
                    for(var i=3;i<=data.data.headcount;i++){
                        html += '<td class="store_info"><p>'+ eval("value.v"+i) +'</p><input type="text" value="'+ eval("value.v"+i) +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="'+ i +'" style="display:none;"></td>';
                    }
                    html += '</tr>';
                });
                $("#dataViewTbody").html(html);
                $("input[name=dataviewpage]").val(parseInt(data.data.page) + 1);
            }
        });
    });

    $("#next_jqGridPager").click(function(){
        var page = $("input[name=dataviewpage]").val();
        var layerid = $("#dataViewLayerid").val();
        var totalpage = $("#sp_1_jqGridPager").html();
        var search = $("#searchDataList").val();
        if(page == totalpage){ return false;}

        $.ajax({
            url:"/basics/store/getstore_ajax",
            type:"POST",
            dataType:"json",
            data:{layerid:layerid,page:page,search:search},
            success:function(data){
                $("#dataViewTbody").empty();
                var html = '';
                $.each(data.data.data,function(key,value){
                    html += '<tr class="jqgrow ui-row-ltr" tabindex="-1"><td class="jqgrid-rownum active" style="text-align:center;width: 35px;">'+ (parseInt(key)+1+data.data.page*data.data.pageSize) +'</td> <td class="store_info"><p>'+ value.name +'</p><input type="text" value="'+ value.name +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="1" style="display:none;"></td> <td class="store_info"><p>'+ value.address +'</p><input type="text" value="'+ value.address +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="2" style="display:none;"></td>';
                    for(var i=3;i<=data.data.headcount;i++){
                        html += '<td class="store_info"><p>'+ eval("value.v"+i) +'</p><input type="text" value="'+ eval("value.v"+i) +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="'+ i +'" style="display:none;"></td>';
                    }
                    html += '</tr>';
                });
                $("#dataViewTbody").html(html);
                $("input[name=dataviewpage]").val(parseInt(data.data.page) + 1);
            }
        });
    });

    $("#last_jqGridPager").click(function(){
        var page = $("input[name=dataviewpage]").val();
        var layerid = $("#dataViewLayerid").val();
        var totalpage = $("#sp_1_jqGridPager").html();
        var search = $("#searchDataList").val();
        if(page == totalpage){ return false;}
        totalpage--;

        $.ajax({
            url:"/basics/store/getstore_ajax",
            type:"POST",
            dataType:"json",
            data:{layerid:layerid,page:totalpage,search:search},
            success:function(data){
                $("#dataViewTbody").empty();
                var html = '';
                $.each(data.data.data,function(key,value){
                    html += '<tr class="jqgrow ui-row-ltr" tabindex="-1"><td class="jqgrid-rownum active" style="text-align:center;width: 35px;">'+ (parseInt(key)+1+data.data.page*data.data.pageSize) +'</td> <td class="store_info"><p>'+ value.name +'</p><input type="text" value="'+ value.name +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="1" style="display:none;"></td> <td class="store_info"><p>'+ value.address +'</p><input type="text" value="'+ value.address +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="2" style="display:none;"></td>';
                    for(var i=3;i<=data.data.headcount;i++){
                        html += '<td class="store_info"><p>'+ eval("value.v"+i) +'</p><input type="text" value="'+ eval("value.v"+i) +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="'+ i +'" style="display:none;"></td>';
                    }
                    html += '</tr>';
                });
                $("#dataViewTbody").html(html);
                $("input[name=dataviewpage]").val(parseInt(data.data.page) + 1);
            }
        });
    });

    $("#dataViewTbody").on("click",".store_info",function(){
        $(this).children("p").hide();
        $(this).children(".input_store_info").show().focus();
    });
    
    $("#dataViewTbody").on("blur",".input_store_info",function(){
        var id = $(this).attr("data-id");
        var type = $(this).attr('type-id');
        var name = $.trim($(this).val());
        var obj = $(this);

        $.ajax({
            "type":"POST",
            "url":"/basics/store/edit_ajax",
            "dataType":"json",
            "data":{name:name,id:id,type:type},
            "success":function(data){
                if(data.code == 200){
                    obj.siblings("p").text(name).show();
                    obj.hide();
                    if(data.data.update == 1){
                        //$(".store"+ id +" span").html(name);
                        $("li[index="+ id +"] span").html(name);
                    }
                    var json = data.data;
                    if(infoBoxTemp){
                        infoBoxTemp.close();
                    }
                    var allOverlay = map.getOverlays();
                    for (var i = 0; i < allOverlay.length; i++){
                        if(json.id == allOverlay[i].marker_id){
                            createMarker.removeMarker(allOverlay[i].marker_id);
                        }
                    }
                    toastr.success(data.msg);
                    createMarker.init(json);
                }
                
            }
        });
    });

    $("#searchDataList").keyup(function(){
        var layerid = $("#dataViewLayerid").val();
        var search = $(this).val();
        $.ajax({
            "type":"POST",
            "url":"/basics/store/getstore_ajax",
            "dataType":"json",
            "data":{layerid:layerid,search:search},
            "success":function(data){
                $("#dataViewTbody").empty();
                var html = '';
                $.each(data.data.data,function(key,value){
                    html += '<tr class="jqgrow ui-row-ltr" tabindex="-1"><td class="jqgrid-rownum active" style="text-align:center;width: 35px;">'+ (parseInt(key)+1) +'</td> <td class="store_info"><p>'+ value.name +'</p><input type="text" value="'+ value.name +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="1" style="display:none;"></td> <td class="store_info"><p>'+ value.address +'</p><input type="text" value="'+ value.address +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="2" style="display:none;"></td>';
                    for(var i=3;i<=data.data.headcount;i++){
                        html += '<td class="store_info"><p>'+ eval("value.v"+i) +'</p><input type="text" value="'+ eval("value.v"+i) +'" class="input_store_info form-control" data-id="'+ value.id +'" type-id="'+ i +'" style="display:none;"></td>';
                    }
                    html += '</tr>';
                });
                $("#dataViewTbody").html(html);
                $("input[name=dataviewpage]").val(data.data.page + 1);
                $("#jqGridPager_right div").html("共" + data.data.count + "条");
                $("#sp_1_jqGridPager").html(data.data.pages);
            }
        });
    });
});
