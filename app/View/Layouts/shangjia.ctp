<!DOCTYPE html>
<html>
  <head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $this->fetch('title'); ?> </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<?php 
        echo $this->Html->css('../plugins/semantic/semantic.min'); 
        echo $this->Html->script('../plugins/jQuery/jQuery-2.1.3.min');
        echo $this->Html->script('../plugins/semantic/semantic.min'); 
?>
    </head>
<body>


<?php 
        if ($this->Session->read("suid")):
?>

<!-- common page begin-->
<h1 class="ui center aligned header">商家管理中心</h1>
<!-- <div class="ui stackable container menu"> -->
 <div class="ui large menu"> 
 <a class="<?php if ($this->get('scenter_active')) {
     echo 'active';
         } ?> item" href="<?php 
            echo Router::url(array('controller'=>'shangjia',
                'action'=>'scenter'), false);
?>">
    Home
  </a>

    <a class="item" href="<?php 
        echo $this->html->url("/"); 
        ?>">
    倚天剑
  </a>

  <a class="<?php if ($this->get('release_active')) {
        echo 'active';
            }?> item" href="<?php 
        echo Router::url(array('controller'=>'shangjia', 'action'=>'release_account'), false);
        ?>">
    发放账号
  </a>

  <div class="right menu">
        <!-- item -->
        <a 
    href="<?php 
        echo $this->Html->url(array(
            'controller'=>'shangjia',
            'action'=>'borders_stat'
        ));
            ?>"
                class="<?php 
                if ($this->get('order_stat_active')) {
                    echo 'active';
                }
            ?> item">订单统计</a>

        <!-- item -->
        <a 
    href="<?php 
        echo $this->Html->url(array(
            'controller' => 'shangjia',
            'action' => 'merchant_info',
        ));
            ?>"
                class="<?php 
                if ($this->get('merchant_info_active')) {
                    echo 'active';
                }
            ?> item">商家信息</a>

        <!-- item -->
        <a 
    href="<?php 
            echo $this->Html->url(
              array('controller' => 'shangjia',
                  'action' => 'logout'
                  )
              );
            ?>"
            class="item">注销</a>
  </div>
</div>

<style>

h1.ui.center.header {
    margin-top: 1em;
  }

</style>
<!-- common page end-->

<?php
    endif;
?>

<?php 
    echo $this->Flash->render();
    echo $this->fetch('content');
?>

<div class="ui text container">
<div class="segments">
  <div class="ui green center aligned segment">
    <h4>copyright@ashadowsocks.com</h4>
  </div>
</div>
</div>

</body>
</html>
