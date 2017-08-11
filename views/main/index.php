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
        <title>工作台-房图</title>
        <meta name="keywords" content="网点标注，营销地图，地图制作">
        <meta name="description" content="房图">
        <link rel="stylesheet" media="all" href="/css/application.css">
        <link rel="stylesheet" media="screen" href="/css/style.css">

        <!--加载模态框-->
        <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!--加载模态框-->
        <link rel="stylesheet" media="all" href="/css/toastr.min.css"/>

        <script src="http://cdn.bootcss.com/toastr.js/2.1.1/toastr.min.js"></script>
        <script src="/js/dialog.js"></script>
        <script type="text/javascript">
            $(function () {
                toastr.options = {
                    closeButton: false,
                    debug: true,
                    progressBar: false,
                    positionClass: "toast-top-center",
                    onclick: null,
                    showDuration: "500",
                    hideDuration: "1000",
                    timeOut: "1000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut"
                };
                $(function () {
                    var webHeight = document.body.clientHeight - 48;
                    $('.left-height').height(webHeight);
                    $('.right-height').height(webHeight);
                })
            })
        </script>
        <link rel="shortcut icon" type="image/x-icon"  href="images/favicon.ico">
    </head>
    <body data-role="none">
        <div id="content">
            <div class="dt-w100per dt-bg-blue3A dt-h48 dt-m-w690">
                <div class="pull-left dt-mar12x  dt-bold white dt-h48">
                    <div class="pull-left">
                        <a href="/" class="white">
                            <img class="dt-mar4t" title="房图首页" alt="房图首页" src="/images/logo88x40.png" width="88" height="40">
                        </a>
                    </div>

                    <div class="pull-left dt-mar12l dt-h48">
                        <span class="dropdown">
                            <a class="change-org dt-normal dt-f16 dt-line-62h white" data-target="#" href="javascript:void(0)"
                               data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                PHP团队研发
                                <span class="caret"></span>
                            </a>
                        </span>
                        <a href="javascript:void(0);" class="white" data-toggle="tooltip" data-placement="bottom" data-container="body" title="">
                            <span class="dt-mar6l dt-normal dt-f12">
                                beta版
                            </span>
                        </a>
                    </div>

                </div>
                <div class="pull-right white dt-h48">
                    <span class="dt-f16 dt-line-48h dt-mar24x dt-mar12r pull-right">
                        <ul class="nav-ul-login">
                            <li class="dropdown">
                                <a id="user_nav" class="dropdown-toggle white dt-pad6x dt-pad6y" aria-haspopup="true" aria-expanded="false"
                                   data-toggle="dropdown" href="javascript:void(0)">
                                    <img class="img-circle" alt="<?php echo $realname; ?>" title="<?php echo $realname; ?>" src="/images/header.png" width="30" height="30"> <?php echo $realname; ?>
                                    <b class="caret"></b></a>
                                <ul class="dropdown-menu  text-center">
                                    <li class="text-left dt-pad12x dt-pad12y dt-pos-r dt-hidden">
                                        <img class="img-circle pull-left" src="/images/header.png" width="60" height="60">
                                        <div class="pull-left dt-line-30h">
                                            <h4 class="black dt-mar0 dt-pad12x dt-pad6t dt-mar12l dt-truncate dt-w152">
                                                <span class="dt-show dt-truncate"><?php echo $realname; ?></span>
                                            </h4>
                                            <span class="black dt-f14 dt-mar12l"><?php echo $mobile;?></span>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <div class="dt-pad12x dt-pad12y dt-hidden">
                                        <a rel="nofollow" class="btn btn-danger btn-sm pull-right" data-method="delete" href="/default/loginout">退出</a>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </span>
                </div>
            </div>


            <div class="dt-bg-e9 dt-hidden left-height" style="margin-left: 86px;">
                <div class="dt-w86 text-center dt-pos-f dt-z10 dt-bg-blue3A dt-ba-e0" style="height:100%;left:0;border-top:1px solid #0b8da5">
                    <ul class="product">
                        <a href="/main" class="dt-line-24h white">
                            <li class="dt-pad20 silder-active">
                                <span class="icons map-icon"></span>
                                <span class="dt-f12">地图</span>
                            </li>
                        </a>

                        <a href="<?= Url::toRoute(['/basics/draw/index']) ?>" target="_blank" class="dt-line-24h white">
                            <li class="dt-pad20 ">
                                <span class="icons general"></span>
                                <span class="dt-f12">区域</span>
                            </li>
                        </a>
                    </ul>
                </div>
                <div class="dt-map dt-bg-e9 dt-border-e9 dt-auto right-height">
                    <div class="create-map">
                        <span class="pull-left dt-line-32h">欢迎使用房图</span>
                        <!-- Split button -->
                        <div class="btn-group pull-right">
                            <button class="btn btn-primary dt-f16 dropdown-toggle" href="javascript:viod(0);" onclick="addLayout()">
                                <span class="icons c-map"></span>新建地图
                            </button>
                        </div>

                    </div>
                        <div class="map-layout">
                            <?php if (!empty($info)): ?>

                                <?php foreach ($info as $val): ?>
                                    <div class="map pull-left dt-mar7x layout-<?php echo $val['id'];?>">
                                        <p class="dt-f18 color33 dt-truncate dt-w90per" title="<?php echo $val['name'] ?>">
                                            <span class="dt-f18 dt-truncate dt-show"><?php echo \app\common\components\library\Tools::cutUtf8($val['name'], 10,'') ?></span>
                                        </p>
                                        <div class="dt-pos-a down-list">
                                            <span class="glyphicon  dt-pointer color99" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <a href="javascript:void(0)" onclick="editLayoutInfo(<?php echo $val['id'];?>)">修改</a> |
                                                <a href="javascript:void(0);" onclick="delLayout(<?php echo $val['id']; ?>)">删除</a>

                                                <!--<button class="btn btn-mini btn-primary" style=" padding: 1px 10px;" type="button">修改</button> |
                                               <button class="btn btn-mini" type="button" style=" padding: 1px 10px;">删除</button>-->

                                            </span>
                                        </div>
                                        <div class="pull-left">
                                            <img class="img-rounded" src="/icons/default/<?php echo md5($val['cityid']); ?>.png">
                                        </div>
                                        <div class="pull-left dt-mar12l text-list">
                                            <span class="dt-line-20h dt-f12 dt-gray dt-show dt-mar4t">
                                                创建者：<span class="black dt-truncate name"><?php echo $realname; ?></span>
                                            </span>
                                            <span class="dt-line-20h dt-f12 dt-gray dt-show">
                                                城市：<span class="black dt-truncate name"><?php echo $val['cityName'] ?></span>
                                            </span>
                                            <span class="dt-line-20h dt-f12 dt-gray dt-show ">
                                                更新时间：
                                                <span class="black"><?php echo substr($val['edittime'], 0, 10); ?></span>
                                            </span>
                                            <span class="dt-line-20h dt-f12 dt-gray dt-show dt-truncate layer">
                                                图层/记录：<span class="black"><?php echo $val['layerNum'] ?></span>个图层&nbsp;
                                                <span class="black"><?php echo $val['storeNum'] ?></span>条记录
                                            </span>
                                            <p>
                                                <a class="btn btn-info dt-mar10l" style="margin-top: 0px;"   title="进入编辑" href="<?php echo Url::toRoute(['/basics/edit','layoutid' => $val['id']]);?>">编辑</a>
                                                <a class="btn btn-info dt-mar10l" style="margin-top: 0px;"    title="查看地图" target="_blank" href="<?php echo Url::toRoute(['/basics/marker','layoutid' => $val['id']]);?>">查看</a>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="dialogContent"></div>
            <script type="text/javascript">

                function show_confirm(id) {
                    var result = confirm('是否删除地图项目');
                    if (result) {
                        var url = "<?php echo Url::toRoute(['/main/del_ajax']); ?>";
                        $.post(url, {'id': id}, function (data) {
                            var info = JSON.parse(data);
                            if (info.code == 200) {
                                toastr.success("删除成功");
                                setInterval("window.location.reload()", 1500);
                            } else {
                                toastr.error("删除失败");
                            }
                        })
                    }
                }
                //数据视图模态框关闭时清除缓存
                $("#layerEdit").on("hidden.bs.modal", function () {
                    $(this).removeData("bs.modal");
                });
                function editLayoutInfo(layoutId){
                    var url="<?=Url::toRoute('/main/edit')?>?id="+layoutId;
                    $.dialog('editLayoutInfo', url, 400);
                }

                function addLayout(){
                    var url = "<?php echo Url::toRoute('/main/add'); ?>";
                    $.dialog('addLayout', url, 400);
                }

                function delLayout(layoutId){
                    var url="<?php echo Url::toRoute('/main/del_ajax')?>?id="+layoutId;
                    $.alert('delLayer', url, '删除地图', '删除地图后数据将不可恢复，确定将此地图项目删除吗？', 460, function () {
                        $('.layout-'+layoutId).remove();
                    });
                }

                $(".product li").click(function () {
                    $(".product li").removeClass('silder-active');
                    $(this).addClass('silder-active');
                })
            </script>

    </body>
</html>