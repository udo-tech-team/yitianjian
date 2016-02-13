<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shadowsocks - 免费shadowsocks帐号和使用教程</title>
    <meta name="description" content="shadowsocks为大家长期更新免费倚天剑账号,提供最详细的倚天剑在windows/Mac/Android上的使用教程和倚天剑各种平台的软件下载,带各位小伙伴零基础轻松学会和玩转倚天剑" />
    <meta name="keywords" content="shadowsocks,免费倚天剑,倚天剑账号,倚天剑怎么用,倚天剑教程" />


    <!-- Bootstrap Core CSS - Uses Bootswatch Flatly Theme: http://bootswatch.com/flatly/ -->
<?php
        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('freelancer');
?>

    <!-- Custom Fonts 
    <link href="http://fonts.useso.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="http://fonts.useso.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--link rel="shortcut icon" href="http://www.ashadowsocks.com/img/favicon.ico"-->

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#page-top">shadowsocks</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="#tutorials">如何使用</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#download">软件下载</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#free">免费shadowsocks</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#vip">vip账号</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Free Shadowsocks Section -->
    <section id="free">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h3>免费shadowsocks测试帐号</h3>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 text-center">
                    <!--
                    <h4>A服务器地址:us1.iss.tf</h4>
                    <h4>端口:8989</h4>
<h4>A密码:28408319</h4>
                    <h4>加密方式:aes-256-cfb</h4>
                    <h4>状态:<font color="green">正常</font></h4>
                    <h4><font color="red">注意：每6小时更换一次密码</font></h4>
                    -->
                </div>
		<div class="col-lg-4 text-left">
        <h4><p class="text-lowercase">服务器地址: <?php echo $this->get('port')['sshost']; ?></p></h4>
        <h4>端口: <?php echo $this->get('port')['ssport']; ?></h4>
                    <div id="vip"></div>
                    <h4><p class="text-lowercase">密码: <?php echo $this->get('port')['sspass']; ?></p></h4>
                    <h4><p class="text-lowercase">加密方式: <?php echo $this->get('port')['ssencrypt']; ?></p></h4>
                    <h4>状态: <?php if ($this->get('port')): ?><font color="green">正常 </font><?php else:?>  异常<?php endif; ?></h4>
                    <h4><font color="red">注意：每6小时更新一次密码</font></h4>
                    <h4><font color="red"><a href="<?php 
                    echo $this->Html->url('/');
                        ?>">购买专用账号=>go</a></font></h4>
                </div>
                <div class="col-lg-4 text-center">
                    <!--
                    <h4>C服务器地址:hk3.iss.tf</h4>
                    <h4>端口:8989</h4>
<h4>C密码:10027000</h4>
                    <h4>加密方式:aes-256-cfb</h4>
                    <h4>状态:<font color="green">正常</font></h4>
                    <h4><font color="red">注意：每6小时更换一次密码</font></h4>
                    -->
                </div>
            </div>
            <div class="row" >
                <div class="col-lg-12 text-center">
                    <h3>shadowsocks vip帐号</h3>
                    <hr class="star-primary">
                    <h4><font color="red"><a href="<?php 
                    echo $this->Html->url('/');
                    ?>">购买专用账号=>go</a></font></h4>
                </div>
            </div>
        </div>
    </section>

    <!-- vip
    <section id="vip">
        <div class="container">
        </div>
    </section> -->

    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                <?php echo $this->Html->image('tutorial/img/profile.png', 
                ['alt' => 'shadowsocks-profile-1', 
                'class' => 'img-responsive']); ?>
                    <div class="intro-text">
                        <span class="name">开始shadowsocks吧</span>
                        <hr class="star-light">
                        <span class="skills">轻巧快速 - 使用简单 - 稳定自如的科学上（翻）网（墙）方式</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Portfolio Grid Section -->
    <section id="tutorials">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>使用教程</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 portfolio-item">
                    <a href="#portfolioModal1" class="portfolio-link" data-toggle="modal">
                        <div class="caption">
                            <div class="caption-content">
                                <i class="fa fa-search-plus fa-3x"></i>
                            </div>
                        </div>
                <?php echo $this->Html->image('tutorial/img/portfolio/windows.png', 
                ['alt' => 'shadowsocks-windows-1', 
                'class' => 'img-responsive']); ?>
                        <center><h3>Windows使用教程</h3></center>
                    </a>
                </div>
                <div class="col-sm-4 portfolio-item">
                    <a href="#portfolioModal2" class="portfolio-link" data-toggle="modal">
                        <div class="caption">
                            <div class="caption-content">
                                <i class="fa fa-search-plus fa-3x"></i>
                            </div>
                        </div>
                <?php echo $this->Html->image('tutorial/img/portfolio/android.png', 
                ['alt' => 'shadowsocks-android-1', 
                'class' => 'img-responsive']); ?>
                        <center><h3>Android使用教程</h3></certer>
                    </a>
                </div>
                <div class="col-sm-4 portfolio-item">
                    <a href="#portfolioModal3" class="portfolio-link" data-toggle="modal">
                        <div class="caption">
                            <div class="caption-content">
                                <i class="fa fa-search-plus fa-3x"></i>
                            </div>
                        </div>
                <?php echo $this->Html->image('tutorial/img/portfolio/mac.png', 
                ['alt' => 'shadowsocks-mac-1', 
                'class' => 'img-responsive']); ?>
                        <center><h3>Macbook使用教程</h3></certer>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Howto Section -->
    <section class="success" id="download">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>软件下载</h2>
                    <hr class="star-light">
                    <h4><font color="red">需要在浏览器中打开链接!!!</font></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 text-center">
                <?php echo $this->Html->image('tutorial/img/windows-circle.png', 
                ['alt' => 'shadowsocks-windows-circle', 
                'class' => 'img-responsive img-centered']); ?>
                    <h3>Windows</h3>
                    <p>Win7及以下<a href="https://github.com/shadowsocks/shadowsocks-csharp/releases/download/2.5.6/Shadowsocks-win-2.5.6.zip" 
        class="btn btn-info"  target="_blank">
                        <i class="fa fa-download"></i> 官方下载 
                    </a>  <a href="http://pan.baidu.com/s/1c05CZT2" class="btn btn-info" target="_blank">
                        <i class="fa fa-download"></i> 百度网盘 
                    </a></p>
                    <p>Win8及以上<a href="https://github.com/shadowsocks/shadowsocks-csharp/releases/download/2.5.6/Shadowsocks-win-2.5.6.zip" 
        class="btn btn-info"  target="_blank">
                        <i class="fa fa-download"></i> 官方下载 
                    </a>  <a href="http://pan.baidu.com/s/1c05CZT2" class="btn btn-info" target="_blank">
                        <i class="fa fa-download"></i> 百度网盘 
                    </a></p>
                </div>
        		<div class="col-lg-6 text-center">
                <?php echo $this->Html->image('tutorial/img/android-circle.png', 
                ['alt' => 'shadowsocks-android-circle', 
                'class' => 'img-responsive img-centered']); ?>
                    <h3>Android</h3>
                            <p><a href="https://play.google.com/store/apps/details?id=com.github.shadowsocks" class="btn btn btn-info"  target="_blank">
                                <i class="fa fa-download"></i> Google Play
                            </a></p>
                            <p><a href="http://pan.baidu.com/s/1jGwDrIu" class="btn btn btn-info"  target="_blank">
                                <i class="fa fa-download"></i> 百度网盘
                            </a></p>
                        </div>
            </div>
            <hr class="star-light">
            <div class="row">
        		<div class="col-lg-6 text-center">
                <?php echo $this->Html->image('tutorial/img/mac_os_x-circle.png', 
                ['alt' => 'shadowsocks-mac-os-x-circle', 
                'class' => 'img-responsive img-centered']); ?>
                    <h3>Mac OS X</h3>
                            <p><a href="http://sourceforge.net/projects/shadowsocksgui/files/dist/ShadowsocksX-2.6.3.dmg" class="btn btn btn-info"  target="_blank">
                                <i class="fa fa-download"></i> 官方下载
                            </a></p>
                            <p><a href="http://pan.baidu.com/s/1pJAGlB1" class="btn btn btn-info"  target="_blank">
                                <i class="fa fa-download"></i> 百度网盘
                            </a></p>
                        </div>
        		<div class="col-lg-6 text-center">
                <?php echo $this->Html->image('tutorial/img/apple-circle.png', 
                ['alt' => 'shadowsocks-apple-circle', 
                'class' => 'img-responsive img-centered']); ?>
                            <h3>iPhone/iPad</h3>
                            <p><a href="https://itunes.apple.com/tc/app/shadowsocks/id665729974?mt=8" class="btn btn-info"  target="_blank">
                                <i class="fa fa-download"></i> AppStore
                            </a></p>
                            <p><a href="http://apt.thebigboss.org/repofiles/cydia/debs2.0/shadowsocks_0.3.2-3.deb" class="btn btn-info"  target="_blank">
                                <i class="fa fa-download"></i> 越狱版
                            </a></p>
                        </div>
            </div>
        </div>
    </section>

    <!-- Free Shadowsocks Section -->

    <!-- Provider list Section -->

    <!-- Footer -->
    <footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-6">
                        <h3>责任声明</h3>
                        <p>本站提供shadowsocks仅供学习交流，请遵守国家法律，服务器已禁止Spam、BT下载和非法网站</p>
                    </div>
                    <!--div class="footer-col col-md-4">
                        <h3>社交网络</h3>
                        <ul class="list-inline">
                            <li>
                                <a href="index.html#" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="index.html#" class="btn-social btn-outline"><i class="fa fa-fw fa-google-plus"></i></a>
                            </li>
                            <li>
                                <a href="index.html#" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="index.html#" class="btn-social btn-outline"><i class="fa fa-fw fa-linkedin"></i></a>
                            </li>
                            <li>
                                <a href="index.html#" class="btn-social btn-outline"><i class="fa fa-fw fa-dribbble"></i></a>
                            </li>
                        </ul>
                    </div-->
                    <div class="footer-col col-md-6">
                        <h3>联系我们</h3>
                        <p>如有任何问题，请联系ye515430@163.com</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; shadowsocks 2015
<?php
echo "hello";
?>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll visible-xs visible-sm">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>

    <!-- Portfolio Modals -->
    <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>Windows设置使用shadowsocks教程</h2>
                            <hr class="star-primary">
                <?php echo $this->Html->image('tutorial/img/tutorials/windows_shadowsocks_00.png', 
                ['alt' => 'shadowsocks-windows', 
                'class' => 'img-responsive img-centered']); ?>
                            <h4>Step1，下载shadowsocks软件</h4>
                            <p>百度网盘<strong><a href="http://pan.baidu.com/s/1qW5dpyk" target="_blank">Win7及以下点这里</a></strong>    <strong><a href="http://pan.baidu.com/s/1pJxDI3L" target="_blank">Win8点这里</a></strong></p>
                            <h4>Step2，解压到任意目录，运行其中的shadowsocks.exe</h4>
                <?php echo $this->Html->image('tutorial/img/tutorials/windows_shadowsocks_01.png', 
                ['alt' => 'shadowsocks-windows-01', 
                'class' => 'img-responsive img-centered']); ?>
                            <h4>Step3，首次运行，会弹出编辑服务器窗口，按图示填写您的shadowsocks服务器地址，端口，密码和加密方式，点确定</h4>
                <?php echo $this->Html->image('tutorial/img/tutorials/windows_shadowsocks_02.png', 
                ['alt' => 'shadowsocks-windows-02', 
                'class' => 'img-responsive img-centered']); ?>
                            <p>点确定后，会如下提示</p>
                <?php echo $this->Html->image('tutorial/img/tutorials/windows_shadowsocks_03.png', 
                ['alt' => 'shadowsocks-windows-03', 
                'class' => 'img-responsive img-centered']); ?>
                            <h4>Step4：按提示右键程序图标，弹出菜单，勾选“启用系统代理”</h4>
                <?php echo $this->Html->image('tutorial/img/tutorials/windows_shadowsocks_04.png', 
                ['alt' => 'shadowsocks-windows-04', 
                'class' => 'img-responsive img-centered']); ?>
                            <p>好了，大功告成，打开任意浏览器上（翻）网（墙）吧，就是这么简单，就是这么任性</p>
                            <p>设置好以后，IE/Chrome/Firefox无需设置，直接打开网址即可</p>
                <?php echo $this->Html->image('tutorial/img/tutorials/windows_shadowsocks_05.png', 
                ['alt' => 'shadowsocks-windows-05', 
                'class' => 'img-responsive img-centered']); ?>
                            <p>Tips1 如何关闭？退出程序就OK了</p>
                            <p>Tips2 PAC和全局模式是什么意思？PAC模式访问国内网站不通过服务器，全局模式所有网站都通过服务器</p>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> 关闭并返回</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>Android设置使用shadowsocks教程</h2>
                            <hr class="star-primary">
                <?php echo $this->Html->image('tutorial/img/tutorials/android_shadowsocks_00.png', 
                ['alt' => 'shadowsocks-android-00', 
                'class' => 'img-responsive img-centered']); ?>
                            <h4>Step1，下载安卓的shadowsocks软件，安卓上叫“影梭”</h4>
                            <p><strong><a href="http://pan.baidu.com/s/1sj5HHUl" target="_blank">百度网盘apk下载地址</a></strong></p>
                            <p><strong><a href="https://play.google.com/store/apps/details?id=com.github.shadowsocks" target="_blank">Google Play下载地址</a></strong></p>
                            <h4>Step2，安装下载的apk文件，安装完成后打开“影梭”</h4>
                <?php echo $this->Html->image('tutorial/img/tutorials/android_shadowsocks_01.png', 
                ['alt' => 'shadowsocks-android-01', 
                'class' => 'img-responsive img-centered']); ?>
                            <h4>Step3，按图示填写您的shadowsocks服务器地址，端口，密码和加密方式，右上方拖动打开</h4>
                            <p>右上方拖动至打开</p>
                <?php echo $this->Html->image('tutorial/img/tutorials/android_shadowsocks_02.png', 
                ['alt' => 'shadowsocks-android-02', 
                'class' => 'img-responsive img-centered']); ?>
                            <h4>Step4，勾选我信任此软件，点“确定”，开始连接</h4>
                <?php echo $this->Html->image('tutorial/img/tutorials/android_shadowsocks_03.png', 
                ['alt' => 'shadowsocks-android-03', 
                'class' => 'img-responsive img-centered']); ?>
                            <h4>连接成功后，最上面会出现一把锁的图标，此时，打开你喜欢的应用吧，比如twitter、instagram</h4>
                <?php echo $this->Html->image('tutorial/img/tutorials/android_shadowsocks_04.png', 
                ['alt' => 'shadowsocks-android-04', 
                'class' => 'img-responsive img-centered']); ?>
                            <p>再次打开“影梭”，拖动即可断开连接</p>
                <?php echo $this->Html->image('tutorial/img/tutorials/android_shadowsocks_05.png', 
                ['alt' => 'shadowsocks-android-05', 
                'class' => 'img-responsive img-centered']); ?>
                            <p>也可以在屏幕下拉菜单中，选中关闭</p>
                <?php echo $this->Html->image('tutorial/img/tutorials/android_shadowsocks_06.png', 
                ['alt' => 'shadowsocks-android-06', 
                'class' => 'img-responsive img-centered']); ?>
                            <p>Tips1 无需root即可使用</p>
                            <p>Tips2 浏览器和App都可以代理，和VPN效果完全一样</p>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> 关闭并返回</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="modal-body">
                            <h2>Mac OS X设置使用shadowsocks教程</h2>
                            <hr class="star-primary">
                <?php echo $this->Html->image('tutorial/img/tutorials/mac_shadowsocks_00.png', 
                ['alt' => 'shadowsocks-mac-00', 
                'class' => 'img-responsive img-centered']); ?>
                            <h4>Step1，下载用于Mac OS X的shadowsocksX软件</h4>
                            <p><strong><a href="http://pan.baidu.com/s/1jGxO0cA" target="_blank">百度网盘dmg下载地址</a></strong></p>
                            <h4>Step2，打开下载的dmg文件，将程序图标拖到右边的Applications，安装完成</h4>
                <?php echo $this->Html->image('tutorial/img/tutorials/mac_shadowsocks_01.png', 
                ['alt' => 'shadowsocks-mac-01', 
                'class' => 'img-responsive img-centered']); ?>
                            <h4>Step3，进入Launchpad，打开ShadowsocksX,右上方出现程序图标，点击图标--“服务器”--“打开服务器设定”</h4>
                <?php echo $this->Html->image('tutorial/img/tutorials/mac_shadowsocks_02.png', 
                ['alt' => 'shadowsocks-mac-02', 
                'class' => 'img-responsive img-centered']); ?>
                            <h4>Step4，根据帐号信息，填写服务器地址（IP或者域名），端口，加密方式和密码，点确定</h4>
                <?php echo $this->Html->image('tutorial/img/tutorials/mac_shadowsocks_03.png', 
                ['alt' => 'shadowsocks-mac-03', 
                'class' => 'img-responsive img-centered']); ?>
                            <h4>Step5，选择刚刚配置好的服务器，点“打开Shadowsocks”，Done!</h4>
                <?php echo $this->Html->image('tutorial/img/tutorials/mac_shadowsocks_04.png', 
                ['alt' => 'shadowsocks-mac-04', 
                'class' => 'img-responsive img-centered']); ?>
                            <h4>打开Safari或者Chrome开始上（翻）网（墙）吧</h4>
                <?php echo $this->Html->image('tutorial/img/tutorials/mac_shadowsocks_05.png', 
                ['alt' => 'shadowsocks-mac-05', 
                'class' => 'img-responsive img-centered']); ?>
                            <p>有些应用需要单独设置，比如Dropbox</p>
                            <p>打开Dropbox首选项，“网络”--代理服务器“更改设置”，然后按下图设置即可</p>
                <?php echo $this->Html->image('tutorial/img/tutorials/mac_shadowsocks_dropbox01.png', 
                ['alt' => 'shadowsocks-mac-dropbox-01', 
                'class' => 'img-responsive img-centered']); ?>
                <?php echo $this->Html->image('tutorial/img/tutorials/mac_shadowsocks_dropbox02.png', 
                ['alt' => 'shadowsocks-mac-dropbox-02', 
                'class' => 'img-responsive img-centered']); ?>
                            <p>Tips1 如果有网站打不开，或者图片刷不出来，切换全局试试</p>
                            <p>Tips2 同样可以编辑PAC，自定义通过服务器代理的网站</p>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> 关闭并返回</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
<?php
        echo $this->Html->script('trialport/jquery');
        echo $this->Html->script('trialport/bootstrap.min');
        echo $this->Html->script('trialport/cbpAnimatedHeader');
        echo $this->Html->script('trialport/contact_me');
        echo $this->Html->script('trialport/jqBootstrapValidation');
        echo $this->Html->script('trialport/classie');
        echo $this->Html->script('trialport/freelancer');
        echo $this->Html->script('jquery.easing.min.js');
?>
    <!-- jQuery >
    <script src="js/jquery.js"></script-->

    <!-- Bootstrap Core JavaScript >
    <script src="js/bootstrap.min.js"></script-->

    <!-- Plugin JavaScript >
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script-->

    <!-- Contact Form JavaScript >
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script-->

    <!-- Custom Theme JavaScript >
    <script src="js/freelancer.js"></script-->
</body>

</html>
