
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
        if ($this->Session->read("uid")):
?>

<!-- common page begin-->
<!-- <div class="ui stackable container menu"> -->
 <div class="ui large menu" style="background-color:#dd4b39; color:#ffffff;"> 

    <a class="item" style="background-color:#d73925; color:#ffffff;" href="<?php 
        echo $this->html->url("/"); 
        ?>">
    倚天剑
  </a>


  <div class="right menu">

        <!-- item -->
        <a 
    href="<?php 
        echo $this->Html->url(array(
            'controller' => 'users',
            'action' => 'ucenter',
        ));
            ?>"
                style="color:#ffffff;"
                class="item">我的主页</a>

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

<div class="ui text container">
<div class="segments">
  <div class="ui green center aligned segment">
    <h4>copyright@ashadowsocks.com</h4>
  </div>
</div>
</div>

</body>
</html>
