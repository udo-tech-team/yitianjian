<!DOCTYPE html>
<html>
  <head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $this->fetch('title'); ?> </title>
    <meta name="description" content="倚天剑shadow，提供shadowsocks科学上（翻）网（墙）账号，免费shadowsocks账号，试用shadowsocks账号，让您畅游网络世界。无障碍使用google搜索，登录facebook、twitter，登录gmail收发邮件！">
    <meta name="keywords" content="倚天剑shadow，免费shadowsocks账号，科学上（翻）网（墙），shadowsocks试用账号，goagent，shadowsocks教程">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Bootstrap 3.3.2 -->
    <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('bootstrap.min');
        //echo $this->Html->css('font-awesome.min');
        echo $this->Html->css('AdminLTE.min');
        echo $this->Html->css('skin-red');
        echo $this->Html->css('downloadPage');
        echo $this->Html->css('stylecss');
        //echo $this->Html->css('../plugins/iCheck/suqare/blue'); 
        echo $this->Html->script('../plugins/jQuery/jQuery-2.1.3.min');
        //echo $this->Html->script('../plugins/iCheck/icheck.min');
        echo $this->Html->script('bootstrap.min');

        echo $this->fetch('mata');
    ?>
    <!-- iCheck -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
        
        function check_email() {
          var re;
          var ss=$('#email').val();
          var re= /\w@\w*\.\w/;
          var tel_reg = /1\d{10}/;
          if(re.test(ss)) {
              return true;
          } else if (tel_reg.test(ss)) {
              return true;
          } else {
              alert('请输入正确的Email / Telephone!');
              $('#email').focus();
              return false;
          }
        }

		function check_vcode() {
			var len = $('#checkcode').val().length;
			//alert($('#checkcode').val() + len);
			if (len != 4) {
				alert('请输入4位验证码！');
				$('#checkcode').focus();
				return false;
			}
			return true;
		}

        function check_pass() {
            var pass1 = $('#pass1').val();
            var pass2 = $('#pass2').val();
            if (pass1 == pass2) {
                return (check_email() && check_vcode()) ;
            }
            alert("两次输入密码不一致，请重新输入！");
            $('#pass1').focus();
            return false;
        }
    </script>
  </head>

<body class="login-page skin-red layout">
	<span style=" display:none">
	    <script type="text/javascript">
	    var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
	    document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fae41c0f84fa318617eb8ea8a76558666' type='text/javascript'%3E%3C/script%3E"));
	    </script>
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
							<!--ul class="nav navbar-nav">
					<li><a href="index.html"><i class="fa fa-home"></i> 首页</a></li>
					<li><a href="media"><i class="fa fa-globe"></i> 媒体报道</a></li>
					<li><a href="about"><i class="fa fa-money"></i> 关于我们</a></li>
				</ul-->
					<?php 
						//if not logged in
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
					//logged in
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
    <?php 
        echo $this->Flash->render();
        echo $this->fetch('content');
    ?>

  </body>
</html>
