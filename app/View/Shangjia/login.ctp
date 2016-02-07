
<br/>
<h1 class="ui center aligned header">倚天剑-shadowsocks</h1>

<div class="ui text container">
  <div class="ui segments">

    <div class="ui segment">
        <h2 class="ui center aligned header">商家登录</h2>
    </div>
    <?php if($this->get('errNo') > 0): ?>
    <div class="ui segment">
    <div class="ui red message">
        <?php echo $this->get('errMsg'); ?>
    </div>
    </div>
    <?php endif; ?>
    <div class="ui segment">
    <form class="ui form " action="<?php 
echo $this->Html->url(
    array('controller' => 'shangjia',
        'action' => 'login'
        )
    );
?>"
method='post'
>
        <div class="field">
          <label>用户名</label>
          <input placeholder="xiaofeng" name="username" type="text">
        </div>
        <div class="field">
          <label>密码</label>
          <input name="password" type="password" placeholder="****">
        </div>
        <button class='ui primary button'>登录</button>
      </form>
    </div> <!-- end ui segment -->
  </div>
</div>

<script>
$('.ui.form')
  .form({
    fields: {
        username : {
          identifier : 'username',
          rules : [
          {
          type : 'empty',
          prompt : '请输入用户名'
          }
          ]
        },
        password : {
          identifier : 'password',
          rules : [
          {
          type : 'empty',
          prompt : '请输入密码'
          }
          ]
        }
    }
  }
  );
</script>
