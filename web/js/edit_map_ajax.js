/**
 * 修改地图异步提交js
 * @Author <lixiaobin>
 */

$(function(){

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

    //设置标签字段
    $('#styleShowTitle a').on('click', function(){
        $(this).addClass("active").siblings().removeClass('active');
        var data_size = $(this).attr("data-size");
        $('#lable').val(data_size);
    });
    //设置尺寸
    $('.marker-normal-size a').on('click', function(){
        $(this).addClass("active").siblings().removeClass('active');
        var data_size = $(this).attr("data-size");
        $('#size').val(data_size);
        createImageLabel();
    });
    //设置图案
    $(".list-unstyled .select-shape").click( function (e) {
        $(".select-shape").removeClass("active");
        $(this).addClass("active");
        createImageLabel();
    });

    //设置有无气泡
    $('#marker_has_bubble').click(function(){
        var bubble = $('#marker_has_bubble').val();
        if(bubble == 0){
            $('#marker_has_bubble').val('1');
            $('#marker_has_bubble').attr('checked','checked');
            createImageLabel();
        }else{
           $('#marker_has_bubble').val('0');
            $('#marker_has_bubble').removeAttr('checked');
            createImageLabel();
        }

    });
    //调取颜色模板
    $('#picker').colpick({
        flat:true,
        layout:'hex',
        submit:0,
        onChange:function() {
            createImageLabel()
        }

    });
    //异步生成图标
    function createImageLabel() {
        var color = $(".colpick_hex_field input").val();
        var size = $(".marker-normal-size .active").attr("data-size");
        var symbol = $(".dt-icon-base .active").attr("data-symbol");
        var bubble = $('#marker_has_bubble').val();
        if(bubble == 0 && symbol == 'null'){
            toastr.error("气泡和图案必须选择一个");
            return false;
        }
        var url = '/basics/layer/createimg_ajax';
        $.post(url,{'color':color,'size':size,'symbol':symbol,'bubble':bubble},function(data){
            var info = JSON.parse(data);
            if(info.code == 200){
                $(".icon_preview").attr('src','/icons/default/'+info.data.imgName);
            }else{
                toastr.error("添加失败!");
            }
        });
    }

    //提交设置图层样式
    $('.site-layer-style').click(function(){
        var bubble =$('#marker_has_bubble').val();
        var color = $(".colpick_hex_field input").val();
        var size = $(".marker-normal-size .active").attr("data-size");
        var symbol = $(".select-shape.active").attr("data-symbol");
        var lable = $('#styleShowTitle .active').attr('data-size');
        var id = $('.edit-layer-id').attr('layer-id');
        var url = '/basics/layer/sitestyle_ajax';
        $.post(url,{'bubble':bubble, 'color':color, 'size':size, 'symbol':symbol, 'lable':lable,'id':id},function(data){
            var info = JSON.parse(data);
            if(info.code == 200){
                toastr.success("设置成功");
                updateIco(id, info.data);
            }else{
                toastr.error("设置失败!");
            }
            $('#edit-layer-style').modal('hide');
        });
    });

    /*$('.marker-layer-style').on('click', function (e) {
        var layerid = $(this).parent('div').attr('layer-id');
        $('.edit-layer-id').attr('layer-id',layerid);
        var url = '/basics/layer/info_ajax';
        $.post(url, {'layerid':layerid}, function(data){
            var info = JSON.parse(data);
            if(info.code == 200){
                $("#edit-layer-style").modal('show');
                $(".colpick_hex_field input").val('8b32c7');
                //设置有无气泡
                if(info.data.bubble == 0){
                    $('#marker_has_bubble').val('0');
                    $('#marker_has_bubble').removeAttr('checked');
                }else if(info.data.bubble == 1){
                    $('#marker_has_bubble').val('1');
                    $('#marker_has_bubble').prop('checked',true);

                }
                //设置尺寸
                $('.marker-normal-size a').removeClass('active');
                if(info.data.size == 's'){
                    $('.marker-normal-size a').eq(0).addClass('active');
                }else if(info.data.size == 'm'){
                    $('.marker-normal-size a').eq(1).addClass('active');
                }else if(info.data.size == 'l'){
                    $('.marker-normal-size a').eq(2).addClass('active');
                }

                //设置标签字段
                $('#styleShowTitle a').removeClass('active');
                if(info.data.lable == 0){
                    $('#styleShowTitle a').eq(0).addClass('active');
                }else if(info.data.lable == 1){
                    $('#styleShowTitle a').eq(1).addClass('active');
                }else if(info.data.lable == 2){
                    $('#styleShowTitle a').eq(2).addClass('active');
                }else if(info.data.lable == 3){
                    $('#styleShowTitle a').eq(3).addClass('active');
                }else if(info.data.lable == 4){
                    $('#styleShowTitle a').eq(4).addClass('active');
                }else if(info.data.lable == 5){
                    $('#styleShowTitle a').eq(5).addClass('active');
                }
                $('.icon_preview').attr('src','/icons/default/'+info.data.ico);

            }
        });
    })*/


   
})
