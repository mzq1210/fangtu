<?php
use yii\helpers\Url;
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">添加标注</h4>
</div>
<div class="modal-body dt-inline dt-w100per" id="edit_region">
    <div class="dt-hidden">
        <ul class="nav nav-tabs">
            <?php if ($model->type != 3):?>
                <li role="presentation" class="region_sets active" data-type="fill"><a href="javascript:void(0);">填充设置</a></li>
            <?php endif;?>
            <li role="presentation" class="region_sets " data-type="stroke"><a href="javascript:void(0);">轮廓设置</a></li>
        </ul>
        <div class="tab" <?php if ($model->type != 3):?>style="display: block;"<?php else:?>style="display: none;"<?php endif;?> >
            <div class="col-md-4 dt-mar12t" style="float:left;padding:0;width:146px;">
                <style>
                    .select-color {
                        height: 20px;
                        width: 20px;
                        margin:2px;
                        border-radius: 4px;
                        float: left;
                        border: 1px solid #ccc;
                    }
                    .box{
                        border-width: 8px;
                        border-style: solid;
                        border-color: rgb(245, 194, 114);
                        background: #f00;
                    }
                </style>
                <div class="dt-hidden color-picker">
                    <div class="select-color dt-pointer fcolor" data-color="f1f075" style="background-color:#f1f075;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="eaf7ca" style="background-color:#eaf7ca;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="c5e96f" style="background-color:#c5e96f;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="a3e46b" style="background-color:#a3e46b;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="7ec9b1" style="background-color:#7ec9b1;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="b7ddf3" style="background-color:#b7ddf3;"></div>

                    <div class="select-color dt-pointer fcolor" data-color="63b6e5" style="background-color:#63b6e5;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="3ca0d3" style="background-color:#3ca0d3;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="1087bf" style="background-color:#1087bf;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="548cba" style="background-color:#548cba;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="677da7" style="background-color:#677da7;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="9c89cc" style="background-color:#9c89cc;"></div>

                    <div class="select-color dt-pointer fcolor" data-color="c091e6" style="background-color:#c091e6;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="d27591" style="background-color:#d27591;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="f86767" style="background-color:#f86767;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="e7857f" style="background-color:#e7857f;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="fa946e" style="background-color:#fa946e;"></div>
                    <div class="select-color dt-pointer fcolor active" data-color="f5c272" style="background-color:#f5c272;"></div>

                    <div class="select-color dt-pointer fcolor" data-color="ede8e4" style="background-color:#ede8e4;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="ffffff" style="background-color:#ffffff;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="cccccc" style="background-color:#cccccc;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="6c6c6c" style="background-color:#6c6c6c;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="1f1f1f" style="background-color:#1f1f1f;"></div>
                    <div class="select-color dt-pointer fcolor" data-color="000000" style="background-color:#000000;"></div>

                </div>
            </div>
            <div class="col-md-4 dt-mar24l" style="float:left;padding:0;width:195px;">
                <div class="custom-color dt-mar12t pull-left dt-line-34h dt-mar12r">自定义颜色</div>
                <div class="dt-hidden dt-pos-r custom-color-layout">
                    <span class="dt-pos-a color99" style="top:19px;">#</span>
                    <input id="region_selected_color" class="form-control dt-mar12t color99 dt-w100 pull-left" name="fillcolor" type="text" maxlength="6" value="<?= $fillcolor?>">
                </div>
                <!--<div id="region_opacity_text" class="pull-left dt-mar4t dt-line-34h dt-mar12r">透明度</div>
                <div id="region_opacity" class="pull-left dt-mar4t dt-pos-r">
                    <div class="input-group spinner">
                        <input type="text" class="form-control" name="fillalpha" value="">
                        <span class="dt-pos-a" style="top:10px;z-index: 10;right: 20px;">%</span>
                    </div>
                </div>-->
            </div>
            <div class="col-md-4 dt-mar18l" style="float:left;padding-bottom:8px;border-bottom:1px solid #ccc;width:135px;">
                <div id="region_swatch" class="box" style="<?php echo 'background:#'.$fillcolor.';border-width:'.$linewidth.'px;border-color:#'.$linecolor.';border-style: solid;'?>"></div>
            </div>
        </div>
        <div class="tab" <?php if ($model->type != 3):?>style="display: none;"<?php else:?>style="display: block;"<?php endif;?>>
            <div class="col-md-4 dt-mar12t" style="float:left;padding:0;width:146px;">
                <style>
                    .select-color {
                        height: 20px;
                        width: 20px;
                        margin:2px;
                        border-radius: 4px;
                        float: left;
                        border: 1px solid #ccc;
                    }
                </style>
                <div class="dt-hidden color-picker">
                    <div class="select-color dt-pointer lcolor" data-color="f1f075" style="background-color:#f1f075;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="eaf7ca" style="background-color:#eaf7ca;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="c5e96f" style="background-color:#c5e96f;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="a3e46b" style="background-color:#a3e46b;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="7ec9b1" style="background-color:#7ec9b1;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="b7ddf3" style="background-color:#b7ddf3;"></div>

                    <div class="select-color dt-pointer lcolor" data-color="63b6e5" style="background-color:#63b6e5;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="3ca0d3" style="background-color:#3ca0d3;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="1087bf" style="background-color:#1087bf;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="548cba" style="background-color:#548cba;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="677da7" style="background-color:#677da7;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="9c89cc" style="background-color:#9c89cc;"></div>

                    <div class="select-color dt-pointer lcolor" data-color="c091e6" style="background-color:#c091e6;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="d27591" style="background-color:#d27591;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="f86767" style="background-color:#f86767;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="e7857f" style="background-color:#e7857f;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="fa946e" style="background-color:#fa946e;"></div>
                    <div class="select-color dt-pointer lcolor active" data-color="f5c272" style="background-color:#f5c272;"></div>

                    <div class="select-color dt-pointer lcolor" data-color="ede8e4" style="background-color:#ede8e4;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="ffffff" style="background-color:#ffffff;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="cccccc" style="background-color:#cccccc;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="6c6c6c" style="background-color:#6c6c6c;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="1f1f1f" style="background-color:#1f1f1f;"></div>
                    <div class="select-color dt-pointer lcolor" data-color="000000" style="background-color:#000000;"></div>

                </div>
            </div>
            <div class="col-md-4 dt-mar24l" style="float:left;padding:0;width:195px;">
                <div class="custom-color dt-mar12t pull-left dt-line-34h dt-mar12r">自定义颜色</div>
                <div class="dt-hidden dt-pos-r custom-color-layout">
                    <span class="dt-pos-a color99" style="top:19px;">#</span>
                    <input id="region_selected_color" class="form-control dt-mar12t color99 dt-w100 pull-left" name="linecolor" type="text" maxlength="6" value="<?= $linecolor?>">
                </div>
                <!--<div id="region_opacity_text" class="pull-left dt-mar4t dt-line-34h dt-mar12r">透明度</div>
                <div id="region_opacity" class="pull-left dt-mar4t dt-pos-r">
                    <div class="input-group spinner">
                        <input type="text" class="form-control" name="linealpha" value="">
                        <span class="dt-pos-a" style="top:10px;z-index: 10;right: 20px;">%</span>
                    </div>
                </div>-->
                <div id="region_stroke_text" class="pull-left dt-mar4t dt-line-34h dt-mar12r">线宽度</div>
                <div id="region_stroke" class="pull-left dt-mar4t">
                    <div class="spinner">
                        <input type="text" class="form-control color99" name="linewidth" value="<?= $linewidth?>">
                    </div>
                </div>
            </div>
            <div class="col-md-4 dt-mar18l" style="float:left;padding-bottom:8px;border-bottom:1px solid #ccc;width:135px;">
                <div id="region_swatch" class="box" style="<?php echo 'background:#'.$fillcolor.';border-width:'.$linewidth.'px;border-color:#'.$linecolor.';border-style: solid;'?>"></div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" value="<?=$model->id?>" name="id">
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
    <button type="submit" class="btn btn-primary set-style">提交</button>
</div>
<script>
    $(function () {
        $('input[name=linewidth]').change(function () {
            $('.box').css("border-width",$(this).val());
        });

        $(".fcolor").bind("click", function () {
            $(this).addClass("active").siblings().removeClass('active');
            $(this).parents('.tab').find('#region_selected_color').val($(this).attr("data-color"));
            $('.box').css("background","#"+$(this).attr('data-color'));
        });
        $(".lcolor").bind("click", function () {
            $(this).addClass("active").siblings().removeClass('active');
            $(this).parents('.tab').find('#region_selected_color').val($(this).attr("data-color"));
            $('.box').css("border-color","#"+$(this).attr('data-color'));
        });

        //设置ICON图片
        $(".region_sets").bind("click", function () {
            var i = $(this).index();
            $(this).addClass('active').siblings().removeClass('active');
            if(i == 0){
                $(".tab").eq(0).show().siblings('.tab').hide();
            }else{
                $(".tab").eq(1).show().siblings('.tab').hide();
            }
        });

        $('.set-style').on('click', function(){
            var id = $('input[name=id]').val();
            var url="<?=Url::toRoute('/basics/draw/setstyle')?>?id="+id;
            var fillcolor = $('input[name=fillcolor]').val();
            var linecolor = $('input[name=linecolor]').val();
            var linewidth = $('input[name=linewidth]').val();
            $.post(url, {
                    'fillcolor':fillcolor,
                    'linecolor':linecolor,
                    'linewidth':linewidth
                },function(data){
                    var info = JSON.parse(data);
                    if(info.code == 200){
                        toastr.success("修改成功");
                        $('#setStyle').modal('hide');
                        setInterval("window.location.reload()",1000);
                    }else{
                        toastr.error("修改失败");
                    }
            });
        });
    });
</script>