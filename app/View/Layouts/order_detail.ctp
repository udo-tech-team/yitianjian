<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <?php echo $this->Html->charset(); ?>
    <title>倚天剑 - 提供shadowsocks科学上（翻）网（墙）账号！</title>
    <meta name="description" content="倚天剑，提供shadowsocks翻墙账号，让您畅游网络世界。无障碍使用google搜索，登录facebook、twitter，登录gmail收发邮件！">
	<meta name="keywords" content="倚天剑，shadowsocks，翻墙，科学上网，登录谷歌，登录facebook，登录twitter，登录gmail">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="<?php echo $this->webroot; ?>img/favicon.png">
    <!-- Bootstrap 3.3.2 -->
    <?php //fetch resources
        echo $this->Html->meta('icon');
        echo $this->Html->css('bootstrap.min');
        //echo $this->Html->css('font-awesome.min');
        echo $this->Html->css('AdminLTE.min');
        echo $this->Html->css('skin-red');
        echo $this->Html->css('downloadPage');
        echo $this->Html->css('stylecss');

        echo $this->fetch('mata');
        //echo $this->fetch('css');
        echo $this->fetch('script');
    ?>
    <!-- Theme style -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
<div id='wx_pic' style='margin:0 auto;display:none;'>

<?php echo $this->Html->image('favicon.png', ['alt' => 'logo']); ?>
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
		<div class="main-header">
        <a href="<?php echo $this->Html->url('/'); ?>" class="logo"><i class="fa fa-cart-arrow-down"></i> 倚天剑</a>
	    <!-- Header Navbar: style can be found in header.less -->
			<div class="navbar navbar-static-top">
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
    <?php if ($this->get('errNo')): ?>
        <div id="msg">
                <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4> <?php echo $this->get("htext"); ?></h4> <?php echo $this->get("detail_info"); ?>
                <?php echo $this->get('pay_info'); ?>

                </div>
        </div>
    <?php else: ?>
    <table class="table table-bordered table-striped">
        <caption>订单信息</caption>
        <!--thead></thead-->
        <tbody>
            <tr>
                <td> 购买时间
                </td>
                <td> <?php $record = $this->get('trade_record'); echo $record['months']; ?>个月
                </td>
            </tr>

            <tr>
                <td> 月流量
                </td>
                <td> <?php echo $record['month_flow']; ?>G
                </td>
            </tr>

            <tr>
                <td> 订单价格
                </td>
                <td> ￥<?php echo $record['price']/100; ?>
                </td>
            </tr>

            <tr>
                <td> 订单状态
                </td>
                <td><?php if (!$record['is_paid']):?> 待付款 <?php else: ?> 已付款<?php endif; ?>
                </td>
            </tr>

        </tbody>
    </table>
        <!--tfoot></tfoot-->

    <?php endif; ?>
    </div>  <!--row home-wrap end -->



	<br><br>
	    <div class="footer-wrap">
        <p align="center">
            <!--a href="about">关于倚天剑</a> |
            <a href="about#contact">联系我们</a> |
             <a href="policy">服务条款</a> |
             <br /-->

            &copy; 2015 gso.hk 倚天剑 All Rights Reserved.
            <br />

        沪ICP备28364509号
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
    </div>	<!--div id="wx_code"></div-->
  </body>
</html>
