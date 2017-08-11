/**
 * Created by mzq on 17-2-6.
 * 注意：使用时请在页面body体内添加modal容器　<div id="dialogContent"></div>
 */
$(function () {
    /**
     * @desc 弹窗封装
     * @param str 唯一ID标识
     * @param url
     * @param width
     * @param callback
     */
    $.dialog = function (str, url, width, callback) {
        var html = '<div class="modal fade" id="'+str+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'+
            '<div class="modal-dialog" style="width: '+width+'px;"><div class="modal-content"></div></div></div>';
        $('#dialogContent').html(html);
        var obj= $('#'+str);
        obj.modal({backdrop: 'static', keyboard: false, remote: url});
        obj.on("hidden.bs.modal", function() {//解决模态框只加载一次问题
            $(this).removeData("bs.modal"); callback && callback();
        });
    };

    /**
     * @desc 提示框封装
     * @param str　唯一ID标识
     * @param url
     * @param title
     * @param content
     * @param width
     * @param callback
     */
    $.alert = function (str, url, title, content, width, callback) {
        var html = '<div class="modal fade" id="'+str+'" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true"><div class="tb"> <div class="tc">'+
            '<div class="modal-dialog" style="width:'+width+'px;"> <div class="modal-content"> <div class="modal-header">'+
            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+
            '<h4 class="modal-title" id="myModalLabel">'+title+'</h4></div>'+
            '<div class="modal-body" style="height: 160px;"> <div class="txtBox">'+
            '<div class="bigIcon" style="background-position: -48px 0px;"></div>'+
            '<p style="margin-top: 0px;">'+content+'</p>'+
            '</div></div><div class="modal-footer">'+
            '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>'+
            '<button type="button" class="btn btn-primary">确定</button></div></div></div></div></div></div>';
        $('#dialogContent').html(html);
        var obj= $('#'+str);
        obj.modal('show');
        $('.btn-primary').on("click", function() {
            $.post(url,function(data){
                var info = JSON.parse(data);
                if(info.code == 200){
                    if(typeof(infoBoxTemp) != 'undefined' && infoBoxTemp != null ){
                        infoBoxTemp.close();
                    }
                    //by lixiaobin 点击提示框 确认按钮 关闭模态框 2017-02-06
                    obj.modal('hide');
                    toastr.success("操作成功!");
                    callback && callback(info);
                }else{
                    toastr.error("操作失败!");
                }
            });
        });
        obj.on("hidden.bs.modal", function() {//解决模态框只加载一次问题
            $(this).removeData("bs.modal");
        });
    };

    /**
     * @desc 封装
     * @param evenObj
     * @param operateObj
     * @param callback
     * @param callback1
     * @param callback2
     */
    $.tab_display = function (evenObj, operateObj, callback, callback1, callback2) {
        evenObj.on("click", function() {
            callback && callback();
            if(operateObj.hasClass("dt-none")){
                callback1 && callback1();
                operateObj.removeClass("dt-none");
                toolsClose();
            }else{
                operateObj.addClass("dt-none");
                callback2 && callback2();
                toolsClose();
            }
        });
    };

    /**
     * @desc 封装
     * @param evenObj
     */
    $.search_keydown = function (evenObj) {
        evenObj.keydown(function (e) {
            var e = e || event, keycode = e.which || e.keyCode;
            if (keycode === 13) {
                var keyword = $(this).val();
                getAreaFrame(keyword);
            }
        });
    };

    /**
     * @desc 封装
     * @param evenObj
     * @param operateObj
     */
    $.is_hide = function (evenObj, operateObj) {alert()
        evenObj.on("click", function() {
            operateObj.addClass("dt-none");
        });
    };

});