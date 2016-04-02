<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>好友发来邀（红）请（包）</title>
    <meta name="description" content="倚天剑，提供shadowsocks翻墙账号，让您畅游网络世界。无障碍使用google搜索，登录facebook、twitter，登录gmail收发邮件！">
    <?php
        //echo $this->Html->css('hongbao.csshake.min');
        echo $this->Html->css('hongbao.style');
        echo $this->Html->script('hongbao.zepto.min');
        echo $this->Html->script('hongbao.red');
    ?>
<div id='wx_pic' style='margin:0 auto;overflow:hidden;display:none;'>
    <img src="http://cdn.upin.com/mfanhuan/images/zhuanti/double11/shareicon.png?v=201510232111" />
      </div>
    <link rel="shortcut icon" href="<?php echo $this->webroot; ?>favicon.ico">
</head>
<body>
<!-- 红包 -->
<div class="red"><!-- shake-chunk -->
  <span style="background-image: url(<?php echo $this->webroot; ?>img/hongbao.red-w.png);">
  </span>
    <button class="redbutton" type="领取">拆</button>
    <div class="red-jg">
        <h1>恭喜您！</h1>
        <h1 align="center">获得￥<?php echo $this->Session->read('money'); ?></h1>
        <h3 align="center">科学上（翻）网（墙）账号￥<?php echo $this->get('money_per_month'); ?>/月</h3>
    </div>
</div>
<!-- End 红包 -->
<!-- 按钮 -->
<div class="t-btn">
<button onclick="window.location.href='<?php echo $this->Html->url([
        'controller' => 'users',
        'action' => 'register'
            ]); ?>';">
存入账号</button>
</div>
<!-- End 按钮 -->
</body>
</html>
