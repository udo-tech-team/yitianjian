<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <?php echo $this->Html->charset(); ?>
    <title>倚天剑 - 提供shadowsocks科学上（翻）网（墙）账号！</title>
    <!--title><?php $this->fetch('title'); ?> </title-->
    <meta name="description" content="倚天剑，提供shadowsocks翻墙账号，让您畅游网络世界。无障碍使用google搜索，登录facebook、twitter，登录gmail收发邮件！">
    <meta name="keywords" content="倚天剑，shadowsocks，翻墙，科学上网，登录谷歌，登录facebook，登录twitter，登录gmail">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link rel="shortcut icon" href="<?php echo $this->webroot; ?>favicon.ico">

    <?php //fetch resources
        echo $this->Html->css('bootstrap.min');
        //echo $this->Html->css('font-awesome.min');  // this css will produce error log, and it can be deleted
        echo $this->Html->css('AdminLTE.min');
        echo $this->Html->css('skin-red');
        echo $this->Html->css('downloadPage');
        echo $this->Html->css('stylecss');

        echo $this->fetch('mata');
        //echo $this->fetch('css');
        echo $this->Html->script('../plugins/jQuery/jQuery-2.1.3.min');
        echo $this->Html->script('bootstrap.min');
        echo $this->fetch('script');
    ?>
    <!-- Theme style -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
<!--div id='wx_pic' style='margin:0 auto;display:none;'>

<img src="http://upload-images.jianshu.io/upload_images/29832-6923a476322c8a59.png" />
</div-->
<!--img src="<?php echo $this->webroot; ?>img/favicon.png" /-->
<div id='wx_pic' style='margin:0 auto;overflow:hidden;display:none;'>
<!--img src="<?php echo $this->webroot; ?>img/favicon.png" /-->
<img src="http://www.ashadowsocks.com/img/tutorial/img/tutorials/windows_shadowsocks_05.png" />
  </div>
  </head>
  <body class="download-page skin-red layout">
                    <span style=" display:none">
    </span>
    <style>
    .main-header {
        margin-bottom: 16px;
        border-bottom: 1px solid #fff;
    }
    .logo .fa {font-size:28px;}
    @media (max-width: 768px) {
        .navbar-nav {display: none;}
        .navbar-nav.pull-right {
            display: block;
            width: 100%;
        }
        .navbar-nav.pull-right li {
            display: inline-block;
            width: 45%;
            text-align: center;
        }
    }
    </style>

<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">提示</h4>
      </div>
      <div class="modal-body">
        <p>为方便您查看账号，请在登录后购买！</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <a href="<?php 
                echo $this->Html->url([
                    'controller'=>'users',
                    'action'=>'login']); 
                ?>" 
        type="button" class="btn btn-primary">现在登录</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
                        <!--a type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal">购买</a-->

        <div class="main-header">
        <a href="<?php echo $this->Html->url('/'); ?>" class="logo"><i class="fa fa-cart-arrow-down"></i> 倚天剑</a>
        <!-- Header Navbar: style can be found in header.less -->
            <div class="navbar navbar-static-top">
                            <!--ul class="nav navbar-nav">
                    <li><a href=""><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href=""><i class="fa fa-globe"></i> 媒体报道</a></li>
                    <li><a href=""><i class="fa fa-money"></i> 关于我们</a></li>
                </ul-->
                    <?php 
                        //if logged in
                        if (!$this->Session->read('uid')):?>
                <ul class="nav navbar-nav pull-right">
                <li><a href="<?php echo $this->Html->url([
                    'controller'=>'users',
                    'action'=>'register']); ?>">
                <i class="fa fa-user"></i> 免费注册</a></li>
                    <li><a href="<?php  echo $this->Html->url([
                    'controller'=>'users',
                    'action'=>'login']); 
                        ?>"><i class="fa fa-sign-in"></i> 会员登录</a></li>
                </ul>
                    <?php 
                    //not logged in
                        else: ?>
                <ul class="nav navbar-nav pull-right">
                <li><a href="<?php echo $this->Html->url([
                    'controller'=>'users',
                    'action'=>'ucenter']); ?>">
                <i class="fa fa-user"></i>我的主页</a></li>
                <li><a href="<?php echo $this->Html->url([
                    'controller'=>'users',
                    'action'=>'logout']); ?>">
                    <i class="fa fa-sign-in"></i>注销</a></li>
                </ul>
                    <?php endif; ?>
           </div>
        </div>    
        
        
        <div class="row home-wrap">

            <div class="focus">
                <!--img src="dist/img/banner.png" />
                <div class="focus-content" style="display:none"-->
                <div class="focus-content" >
                        
                    <dl>
                        <dt>倚天剑</dt>
                        <dd>发布shadowsocks科学上网（翻*墙）账号的平台！</dd>
                    </dl>
                    <dl>
                        <dt>傻瓜式</dt>
                        <dd>无需任何技术基础，查看教程即能学会使用shadowsocks账号登录谷歌、脸书、推特，好用到没朋友！</dd>
                    </dl>
                    <dl>
                        <dt>注册即送体验vip账号</dt>
                        <dd>活动期间，注册账号即送vip体验账号，让您翻*墙畅游！</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="row home-wrap">
          <div class="col-md-4">
            <h2>多终端</h2>
            <p>支持windows/mac/ios/android访问国外优秀网站畅通无阻！</p>
            <p><a href="<?php 
                echo $this->Html->url([
                    'controller' => 'tutorial'
                ]);
            ?>" class="btn btn-info btn-large">了解更多</a></p>
          </div>

          <div class="col-md-4">
            <h2>傻瓜式</h2>
            <p>无需要任何技术基础，按照教程一步一步设置，即可翻越城墙！</p>
            <p><a href="<?php 
                    echo $this->Html->url([
                    'controller' => 'tutorial',
                    'action' => 'trial_port',
                    '#' => 'tutorials'
                            ]);
            ?>" class="btn btn-primary btn-large">查看教程</a></p>
          </div>

          <div class="col-md-4">
            <h2>免费体验</h2>
            <p>本站提供免费体验账号，注册成功后送vip账号。</p>
            <p><a href="<?php 
                    echo $this->Html->url([
                    'controller' => 'tutorial',
                    'action' => 'trial_port',
                    '#' => 'free'
                            ]);
            ?>" class="btn btn-success btn-large">免费体验</a></p>
          </div>
        </div>
<br/><br/>

<!--
        <div class="row home-wrap">
            <div align="center" style="margin-bottom:36px;">
                <div class="btn-group">
                <a href="<?php 
                echo $this->Html->url([
                    'controller' => 'tutorial'
                ]);
                    ?>" class="btn btn-success">啥是shadowsocks?</a>
                        <a href="<?php 
                    echo $this->Html->url([
                    'controller' => 'tutorial',
                    'action' => 'trial_port',
                    '#' => 'tutorials'
                            ]);
                        ?>" target="_blank" class="btn btn-warning">如何使用shadowsocks?</a>
                            <a href="<?php 
                    echo $this->Html->url([
                    'controller' => 'tutorial',
                    'action' => 'trial_port',
                    '#' => 'download'
                            ]);
                            
                            ?>" class="btn btn-success">win/mac/apple/android客户端下载</a>
                </div>
            </div>
        </div> -->

                    <?php 
                        //if logged in
                        // judge if login here, if login && switch on, show goods list
                        // if not login, show nothing

                        // user login && switch on
                        if ($this->Session->read('uid') && $this->get("show_goods_list")):?>
        <div class="row home-wrap">
                <div class="col-md-6">
                  <div class="thumbnail">
                    <div class="caption">
                    <h3>shadowsocks基础版</h3>
                    <p>月流量：30G</p>
                    <p>适用：google/facebook/twitter/youtube等网站</p>
                    <p>线路：美国洛杉矶</p>
                    <p>价格：￥5/月</p>
                    <form action="<?php 
        echo $this->Html->url([
            'controller' => 'orders',
            'action' => 'alicreate',
            ]);
?>" method="post" target="_blank">
                    <input type="hidden" name="acctype" value="basic"/>
                    <p>
                        <select class="form-control" name="months">
                          <option value="1">1个月</option>
                          <option value="2">2个月</option>
                          <option value="3">3个月</option>
                          <option value="6">6个月</option>
                          <option value="9">9个月</option>
                          <option value="12">一年</option>
                        </select>
                    </p>
                    <?php if (!empty(CakeSession::read('uid'))): ?>
                    <button type='submit' class="btn btn-danger" data-toggle="modal" data-target="#myModal">购买</button>
                    <?php else: ?>
                        <a type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal">购买</a>
                    <!--a href="<?php 
                echo $this->Html->url([
                    'controller'=>'users',
                    'action'=>'login']); 
                        ?>" 
                        class="btn btn-warning">购买</a-->
                    <?php endif ?>
                    </form>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="thumbnail">
                    <div class="caption">
                    <h3>shadowsocks专业版</h3>
                    <p>月流量：70G</p>
                    <p>适用：google/facebook/twitter/youtube等网站</p>
                    <p>线路：美国洛杉矶</p>
                    <p>价格：￥10/月</p>
                    <form action="" method="post">
                    <p>
                        <select class="form-control">
                          <option>1个月</option>
                          <option>2个月</option>
                          <option>3个月</option>
                          <option>4个月</option>
                          <option>5个月</option>
                          <option>6个月</option>
                          <option>7个月</option>
                          <option>8个月</option>
                          <option>9个月</option>
                          <option>10个月</option>
                          <option>11个月</option>
                          <option>一年</option>
                        </select>
                    </p>
                    <button type='submit' class="btn btn-danger">购买</button>
                    </form>
                    </div>
                  </div>
                </div>
        </div>

        <div class="row home-wrap">
                <div class="col-md-6">
                  <div class="thumbnail">
                    <div class="caption">
                    <h3>shadowsocks尊享版</h3>
                    <p>月流量：120G</p>
                    <p>适用：google/facebook/twitter/youtube等网站</p>
                    <p>线路：美国洛杉矶</p>
                    <p>价格：￥15/月</p>
                    <form action="<?php 
        echo $this->Html->url([
            'controller' => 'orders',
            'action' => 'alicreate',
            ]);
?>" method="post" target="_blank">
                    <input type="hidden" name="acctype" value="high"/>
                    <p>
                        <select class="form-control" name="months">
                          <option value="1">1个月</option>
                          <option value="2">2个月</option>
                          <option value="3">3个月</option>
                          <option value="6">6个月</option>
                          <option value="9">9个月</option>
                          <option value="12">一年</option>
                        </select>
                    </p>
                    <?php if (!empty(CakeSession::read('uid'))): ?>
                    <button type='submit' class="btn btn-danger" data-toggle="modal" data-target="#myModal">购买</button>
                    <?php else: ?>
                        <a type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal">购买</a>
                    <!--a href="<?php 
                echo $this->Html->url([
                    'controller'=>'users',
                    'action'=>'login']); 
                        ?>" 
                        class="btn btn-warning">购买</a-->
                    <?php endif ?>
                    </form>

                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="thumbnail">
                    <div class="caption">
                    <h3>shadowsocks畅游版</h3>
                    <p>月流量：无限制</p>
                    <p>适用：google/facebook/twitter/youtube等网站</p>
                    <p>线路：美国洛杉矶</p>
                    <p>价格：￥25/月</p>
                    <p>
                        <select class="form-control">
                          <option>1个月</option>
                          <option>一年</option>
                        </select>
                    </p>
                    <a class="btn btn-danger">购买</a>
                    </div>
                  </div>
                </div>

        </div>  <!-- end row home-wrap -->

                    <?php else: 
                    // user not login or switch off
                    $log_str = "user not login or switch off, show no goods";
                    $log_str .= ", swtich[" . $this->get("show_goods_list") . "]";
                    CakeLog::write("debug", $log_str);
?>

                    <?php endif; ?>


    <div class="row home-wrap">
        <div class="userwords">
            <div class="title">
                <div class="d-line"></div>
                <h3>TA 们正在使用shadowsocks</h3>
            </div>
            <div class="uw-content row">
                <div class="item col-md-6">
                <div class="photo">
                   <?php echo $this->Html->image('uw_1.jpg'); ?>" 
                </div>
                    <div class="info">
                        <div class="name">小马－ 程序员</div>
                        <q>可以上谷歌搜索英文资料，github，codeproject，stackoverflow所有资料轻松搜索查阅。</q>
                    </div>
                </div>

                <div class="item col-md-6">
                    <div class="photo">
                   <?php echo $this->Html->image('uw_2.jpg'); ?>" 
                    </div>
                    <div class="info">
                        <div class="name">丫丫 － 白领</div>
                        <q>用了shadowsocks账号后，可以在facebook twitter上轻松和在国外的朋友聊天互动了，很方便！Gmail也可以任性登录^^</q>
                    </div>
                </div>

                <div class="item col-md-6">
                    <div class="photo">
                   <?php echo $this->Html->image('uw_3.jpg'); ?>" 
                    </div>
                    <div class="info">
                        <div class="name">王教授－ 高校研究员</div>
                        <q>国外的文献再也不用愁了，可以开通账号后通过谷歌学术检索到各种最新文献。</q>
                    </div>
                </div>

                <div class="item col-md-6">
                    <div class="photo">
                   <?php echo $this->Html->image('uw_4.jpg'); ?>" 
                    </div>
                    <div class="info">
                        <div class="name">小林 － 学生</div>
                        <q>看youtube的视频，看国外新闻，这翻*墙利器，必须的！</q>
                    </div>
                </div>

                <div class="clearfix"></div>

            </div>
            </div>
    </div>
    <br><br>
        <div class="footer-wrap">
        <p align="center">
            <!--a href="">关于倚天剑</a> |
            <a href="">联系我们</a> |
             <a href="">服务条款</a> |
             <br /-->

            &copy; 2016 gso.hk 倚天剑shadow  All Rights Reserved.
            <br />

        沪ICP备15047922号 客服QQ 3382558130 
<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=3382558130&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:3382558130:52" alt="咨询客服" title="咨询客服"/></a>
        </p>
        <p align="center">
        <?php 
         echo $this->Html->image('foot-2.png', array('border'=>"0",
             'style'=>"height:32px;border:1px solid #d10000;"));
        ?>
        <?php 
         echo $this->Html->image('foot-1.png', array('border'=>"0",
             'style'=>"height:32px;border:1px solid #ff8800;"));
        ?>

        </p>
    </div>    <!--div id="wx_code"></div-->
  </body>
</html>
