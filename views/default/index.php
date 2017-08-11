<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equi="Pragma" content="no-cache"> 
        <meta http-equi="Cache-Control" content="no-cache"> 
        <meta http-equi="Expires" content="0">
        <title>房图 企业平台</title>
        <meta http-equiv="Content-Language" content="zh-CN">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
        <meta name="keywords" content="keyword1,keyword2,keyword3">
        <meta name="description" content="this is my page">
        <meta name="content-type" content="text/html; charset=UTF-8">

        <!--<link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/css/home.css">
        <script type="text/javascript" src="/js/jquery-3.0.0.min.js"></script>

        <script src="/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/js/dialog.js"></script>

    </head>
    <body class="scrollbar ng-scope" ng-app="homeApp" ng-controller="homeCtrl">
        <div class="div-content to-here">
            <header class="">
                <div class="header-div">
                    <div class="dth-h60">
                        <div class="header-main">
                            <div class="logo-div">
                                <a href="/" class="logo-hover">
                                    <img alt="New logo yellow" class="logo-img" src="/images/logo88x40.png">
                                </a>
                            </div>
                            <div class="nav-div">
                                <ul class="nav-bar">
                                    <a class="dth-color4d "><li class="nav-li dth-hover">首页</li></a>
                                    <a class="dth-color4d "><li class="nav-li dth-hover">产品特性</li></a>
                                    <a class="dth-color4d"><li class="nav-li dth-hover">应用场景</li></a>
                                    <li class="login-li">
                                        <div id="logReg" class="user-login-panel" style="display:block;">
                                            <!--<a id="loginbtn" class="login-a reg" href="">登录</a>-->
                                            <div id="user_info" class="user-info" style="">
                                                <?php if(!empty($realname)):?>
                                                <img id="avatar" src="http://dituhui-cute.oss-cn-hangzhou.aliyuncs.com/default_img/2016/8/25/9cf50e75db1de4ae326f40997d190956.png">
                                                <a href="/main"><?php echo $realname;?></a>&nbsp;<a href="javascript:void(0);" style="padding: 0px 5px; text-decoration:none">|</a>&nbsp;&nbsp;&nbsp;<a href="/default/loginout">退出</a>
                                                <?php else:?>
                                                 <a class=" reg" style="font-size: 14px; text-decoration: none;color: #fff" href="javascript:void(0);" onclick="login()" >登录</a>
                                                <?php endif;?>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div id="home-banner">
                <div class="banner-text">
                    <p class="banner-line1 white">您的专属‘房’图平台</p>
                    <p class="banner-line2 white">40W用户的共同选择，让制图更专业</p>
                    <?php if(empty($realname)):?>
                    <a class="banner-btn1 bannerBtn" style="height: 44px; text-decoration: none; color: #fff"  href="javascript:void(0);" onclick="login()">立即体验</a>
                    <?php else:?>
                        <a class="banner-btn1"  style="height: 44px; text-decoration: none;color: #fff"  href="/main">进入工作台</a>
                    <?php endif;?>
                </div>
            </div>

            <div class="adver-back-odd to-here">
                <div class="adver-content">
                    <div class="pic-odd pic-odd1"></div>
                    <div class="aderver-text-content-odd">
                        <p class="div-content-ti">海量数据轻松展示</p>
                        <p class="div-content-co">支持上万量级的数据批量标注与展示，并提供多种可视化方式，让你轻轻松松浏览地图</p>
                    </div>
                </div>
            </div>

            <div class="adver-back-eve">
                <div class="adver-content adver-bgc">
                    <div class="aderver-text-content-eve">
                        <p class="div-content-ti">统计分析辅助决策</p>
                        <p class="div-content-co">支持按区域、类别对用户自有业务数据进行统计分析，辅助商业决策</p>
                    </div>
                    <div class="cyclo-pic"></div>
                </div>
            </div>

            <div class="adver-back-odd">
                <div class="adver-color-back"></div>
                <div class="adver-content">
                    <div class="pic-odd pic-odd3"></div>
                    <div class="aderver-text-content-odd" style="padding-top:36px;">
                        <p class="div-content-ti" style="margin-top:95px;">多人协作轻松办公</p>
                        <p class="div-content-co">支持多人协作标记、画区、管理地图，支持权限分级，不同协作拥有不同权限，保证制图安全性</p>
                    </div>
                </div>
            </div>

            <div class="adver-back-eve">
                <div class="adver-color-back back-right"></div>
                <div class="adver-content adver-bgc">
                    <div class="aderver-text-content-eve">
                        <p class="div-content-ti">大数据叠加分析</p>
                        <p class="div-content-co">与权威机构合作，提供人口、经济、气候、消费、房产、商业网点等地理大数据，可与用户自有业务数据叠加展示</p>
                    </div>
                    <div class="pic-bgc"></div>
                </div>
            </div>


            <div class="case-div to-here" style="background-color:#F3F3F3;height:680px;">
                <div class="content-w1000">
                    <h2 class="center-title"><img src="/images/image_title.png"></h2>
                    <ul class="points left-points">
                        <li><h3 class="point">客户分析</h3><p class="point-disc">直观展示客户分布位置，分析业务覆盖区域</p><img src="/images/icon_distribution.png" class="left-point-icon"></li>
                        <li><h3 class="point">广告位管理</h3><p class="point-disc">广告位置与销售状态分类展示与查询，快速分派人员采集数据与维修</p><img src="/images/icon_ad.png" class="left-point-icon"></li>
                        <li><h3 class="point">销售管理</h3><p class="point-disc">划分销售片区，分区统计销售业绩，跟踪考勤与客户拜访记录</p><img src="/images/icon_sell.png" class="left-point-icon"></li>
                    </ul>
                    <img src="/images/image_computer.png" class="computer-image">
                    <ul class="points right-points">
                        <li><h3 class="point">竞品分析</h3><p class="point-disc">叠加竞品数据进行分类展示，借助图表统计分析，对比竞品状态</p><img src="/images/icon_analyze.png" class="right-point-icon"></li>
                        <li><h3 class="point">巡店管理</h3><p class="point-disc">定期巡查店铺情况，上传图片、文字、视频等资料，与电脑端同步</p><img src="/images/icon_shop.png" class="right-point-icon"></li>
                        <li><h3 class="point">更多应用场景</h3><p class="point-disc">先试试：<?php if(!empty($realname)):?><a href="/main">立即体验</a><?php else:?><a href="javascript:;" onclick="login()">立即体验</a><?php endif;?></p><img src="/images/icon_more.png" class="right-point-icon"></li>

                    </ul>
                </div>
            </div>
        </div>

        <footer>
            <div class="cute-footer  to-here">
                <h1 class="dthxw-title"><a class="dituhui" href="http://www.dituhui.com/">房图&nbsp;</a>•&nbsp;企业平台</h1>
                <p class="dthxw-disc">由房图团队打造的一款面向企业用户提供的在线地图应用服务，用户无需编程与安装软件，即可快速搭建企业级地图应用系统、管理企业业务数据。服务内容安全可靠，可按需提供，帮助企业节省资源成本，告别庞杂的重型系统。</p>
            </div>
        </footer>

        <div id="dialogContent"></div>
        <script type="text/javascript" src="/js/home.js"></script>
        <script type="text/javascript">
            function login() {
                var url = '<?php echo \yii\helpers\Url::toRoute("/default/login")?>';
                $.dialog('loginModal',url,370);
            }
        </script>
    </body>
</html>
