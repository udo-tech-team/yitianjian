
<!DOCTYPE html>
<html>
  <head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $this->fetch('title'); ?> </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<?php 
        echo $this->Html->css('../plugins/semantic/semantic.min'); 
        echo $this->Html->css('user_defined'); 
        echo $this->Html->script('../plugins/jQuery/jQuery-2.1.3.min');
        echo $this->Html->script('../plugins/semantic/semantic.min'); 
        echo $this->Html->script('clipboard.min'); 
?>
    </head>
<body>


<?php 
        if ($this->Session->read("uid")):
?>

<!-- common page begin-->
<!-- <div class="ui stackable container menu"> -->
 <div class="ui large menu" style="background-color:#dd4b39; color:#ffffff;"> 

    <a class="item" style="background-color:#d73925; color:#ffffff;" href="<?php 
        echo $this->html->url("/"); 
        ?>">
    倚天剑<span class="smallfont">shadow</span>

  </a>

    <a class="item" style="background-color:#d73925; color:#ffffff;" href="<?php 
        echo $this->html->url(
              array('controller' => 'users',
                  'action' => 'ucenter'
                  )
            ); 
        ?>">
    我的ss
  </a>

    <a class="item" style="background-color:#d73925; color:yellow;" href="<?php 
        echo $this->html->url(
              array('controller' => 'users',
                  'action' => 'invite'
                  )
            ); 
        ?>">
    邀请赚钱
  </a>


    <a class="item" style="background-color:#d73925; color:#ffffff;" href="<?php 
        echo $this->html->url(
              array('controller' => 'users',
                  'action' => 'buy_ss'
                  )
            ); 
        ?>">
    购买ss
  </a>

  <div class="right menu">

        <!-- item -->
        <a 
    href="<?php 
        echo $this->Html->url(array(
            'controller' => 'users',
            'action' => 'advice',
        ));
            ?>"
                style="color:#ffffff;"
                class="item">吐槽建议</a>

        <!-- item -->
        <a 
    href="<?php 
            echo $this->Html->url(
              array('controller' => 'users',
                  'action' => 'logout'
                  )
              );
            ?>"
            style="color:#ffffff;"
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

<div class="ui container">
<div class="segments">
  <div class="ui green center aligned segment">
    <h4>copyright@ashadowsocks.com
    </h4>
    <h4>
        <a target="_blank" 
            href="http://wpa.qq.com/msgrd?v=3&uin=3382558130&site=qq&menu=yes">
            <img border="0" src="http://wpa.qq.com/pa?p=2:3382558130:52" 
                 alt="咨询客服" title="咨询客服"/>
        </a>
    </h4>
  </div>
</div>
</div>

</body>
</html>
