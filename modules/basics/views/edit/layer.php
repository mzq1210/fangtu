<?php

use yii\helpers\Url;
?>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">图层管理</h4>
</div>
<div class="modal-content" style="padding:6px;border-radius:0;overflow: auto;">
    <div style="">
        <div style="margin:0 0 5px 10px;">
            <span class="pull-left dt-mar4l data-refresh dt-pointer">
                <span class="dt-f16 dt-middle glyphicon glyphicon-refresh dt-mar2t pull-left dt-mar6l coloraa"></span>
                <span class="coloraa dt-f12 dt-line-24h dt-mar4l dt-normal">刷新</span>
            </span>
        </div>
        <table class="table table-bordered table-striped table-hover table-condensed">
            <thead>
            <th width="40%" style="text-align:center;">图层名称</th>
            <th width="15%" style="text-align:center;">排序</th>
            <th width="15%" style="text-align: center;">是否显示</th>
<!--            <th width="15%" style="text-align:center;">是否公开</th>-->
            <th width="15%" style="text-align:center;">是否隐藏</th>
            </thead>
            <tbody id="store-tbody">
                <?php foreach ($info as $val): ?>
                    <tr data-id="<?php echo $val->id; ?>">
                        <td style="text-align: center;"><?php echo $val->name; ?></td>
                        <td style="text-align: center;"><span style="color:#ff0000;" class="glyphicon glyphicon-arrow-up dt-pointer selfsort-up"></span><span style="margin-left:5px;color:#4cae4c" class="glyphicon glyphicon-arrow-down dt-pointer selfsort-down"></span></td>
                        <td style="text-align: center;"><span class="glyphicon <?php
                            if ($val->is_show == '1'):echo 'glyphicon-eye-open font-green';
                            else:echo 'glyphicon-eye-close font-red';
                            endif;
                            ?> dt-pointer dt-gray" onclick="displayRow(this)" title="显示/隐藏"></span></td>
<!--                        <td style="text-align: center;"><input id="overt--><?php //echo $val->id; ?><!--" name="overt" type="checkbox" --><?php //if ($val->is_public == '1'): echo 'checked';
//                            endif;
//                            ?><!-- class="overt chk_4"/><label for="overt--><?php //echo $val->id; ?><!--" class="dt-middle"></label></td>-->
                        <td style="text-align: center;"><input id="shower<?php echo $val->id; ?>" name="shower" type="checkbox" <?php if ($val->is_display == '1'): echo 'checked';
                endif;
                ?> class="shower chk_4"/><label for="shower<?php echo $val->id; ?>" class="dt-middle"></label></td>
                    </tr>
<?php endforeach; ?>
            </tbody>
        </table>
        <input type="hidden" name="layoutid" value="<?php echo $layoutid; ?>">
    </div>
</div>        



<script type="text/javascript">
    $(function () {
        //设置是否隐藏图层
        $("#store-tbody").on("click", ".shower", function () {
            var obj = $(this).parent().parent();
            var id = obj.attr("data-id");
            var checked = this.checked;
            $.ajax({
                url: "<?php echo Url::toRoute('/basics/edit/setdisplay_ajax') ?>",
                type: "POST",
                dataType: "json",
                data: {id: id, checked: checked},
                success: function (res) {
                    if (res.code == 200) {
                        toastr.success("操作成功");
                    }
                }
            });
        });
        //设置是否公开图层
        $("#store-tbody").on("click", ".overt", function () {
            var id = $(this).parent().parent().attr("data-id");
            var checked = this.checked;
            $.ajax({
                url: "<?php echo Url::toRoute('/basics/edit/setpublic_ajax') ?>",
                type: "POST",
                dataType: "json",
                data: {id: id, checked: checked},
                success: function (res) {
                    if (res.code == 200) {
                        toastr.success("操作成功");
                    }
                }
            });
        });
        //设置向上排序图层
        $("#store-tbody").on("click", ".selfsort-up", function () {
            var obj = $(this).parent().parent();
            var id = obj.attr("data-id");
            var preObj = obj.prev();
            if (preObj.length < 1) {
                return false;
            }
            var preId = preObj.attr("data-id");
            $.ajax({
                url: "<?php echo Url::toRoute('/basics/edit/setsort_ajax') ?>",
                type: "POST",
                dataType: "json",
                data: {id: id, up: true, exid: preId},
                success: function (res) {
                    if (res.code == 200) {
                        obj.insertBefore(preObj);
                        $(".layer"+id).insertBefore($(".layer"+id).prev());
                        toastr.success("排序成功");
                    }
                }
            });
        });
        //设置向下排序图层
        $("#store-tbody").on("click", ".selfsort-down", function () {
            var obj = $(this).parent().parent();
            var id = obj.attr("data-id");
            var nextObj = obj.next();
            if (nextObj.length < 1) {
                return false;
            }
            var nextId = nextObj.attr("data-id");
            $.ajax({
                url: "<?php echo Url::toRoute('/basics/edit/setsort_ajax') ?>",
                type: "POST",
                dataType: "json",
                data: {id: id, up: false, exid: nextId},
                success: function (res) {
                    if (res.code == 200) {
                        obj.insertAfter(nextObj);
                        toastr.success("排序成功");
                    }
                }
            });
        });
    });

    //设置是否展示图层内容(小眼睛)
    function displayRow(obj)
    {
        
        var id = $(obj).parent().parent().attr("data-id");
        var checked = 0;
        if ($(obj).hasClass("glyphicon-eye-open")) {
            checked = 0;
            $.ajax({
                url: "<?php echo Url::toRoute('/basics/edit/setshow_ajax') ?>",
                type: "POST",
                dataType: "json",
                data: {id: id, checked: checked},
                success: function (res) {
                    if (res.code == 200) {
                        $(obj).removeClass("glyphicon-eye-open font-green").addClass("glyphicon-eye-close font-red");
                        toastr.success("操作成功");
                    }

                }
            });

        } else if ($(obj).hasClass("glyphicon-eye-close")) {
            checked = 1;
            $.ajax({
                url: "<?php echo Url::toRoute('/basics/edit/setshow_ajax') ?>",
                type: "POST",
                dataType: "json",
                data: {id: id, checked: checked},
                success: function (res) {
                    if (res.code == 200) {
                        $(obj).removeClass("glyphicon-eye-close font-red").addClass("glyphicon-eye-open font-green");
                        toastr.success("操作成功");
                    }
                }
            });
        }
    }

    $(".data-refresh").click(function () {
        var layoutid = $("input[name=layoutid]").val();
        $.ajax({
            url: "<?php echo Url::toRoute('/basics/edit/layeredit_ajax') ?>",
            type: "POST",
            dataType: "json",
            data: {layoutid: layoutid},
            success: function (res) {
                if (res.code == 200) {
                    var html = "";
                    $.each(res.data, function (key, value) {
                        html += '<tr data-id="' + value.id + '">' +
                                '<td style="text-align: center;">' + value.name + '</td>' +
                                '<td style="text-align: center;"><span style="color:#ff0000;" class="glyphicon glyphicon-arrow-up dt-pointer selfsort-up"></span><span style="margin-left:5px;color:#4cae4c" class="glyphicon glyphicon-arrow-down dt-pointer selfsort-down"></span></td>' +
                                '<td style="text-align: center;"><span class="glyphicon ' + (value.is_show == 1 ? 'glyphicon-eye-open font-green' : 'glyphicon-eye-close font-red') + ' dt-pointer dt-gray" onclick="displayRow(this)" title="显示/隐藏"></span></td>' +
//                                '<td style="text-align: center;"><input id="overt' + value.id + '" name="overt" type="checkbox" ' + (value.is_public == 1 ? 'checked' : '') + ' class="overt chk_4"/><label for="overt' + value.id + '" class="dt-middle"></td>' +
                                '<td style="text-align: center;"><input id="shower' + value.id + '" name="shower" type="checkbox" ' + (value.is_display == 1 ? 'checked' : '') + ' class="shower chk_4"/><label for="shower' + value.id + '" class="dt-middle"></td>' +
                                '</tr>';
                    });

                    $("#store-tbody").html(html);
                    toastr.success("刷新成功");
                }
            }
        });
    });
</script>