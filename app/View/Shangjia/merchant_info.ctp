<div class="ui text container">
<div class="ui top attached tabular menu">
  <a class="item active" data-tab="first">基本信息</a>
  <a class="item" data-tab="second">修改密码</a>
  <a class="item" data-tab="third">历史登录</a>
</div>
  <!-- segment begin -->
  <div class="ui bottom attached tab segment active" data-tab="first">
  
    <!-- ui celled grid begin -->
    <div class="ui celled grid">
      <div class="sixteen wide column">
        <div class="ui top attached label">账户信息</div>
      </div>

      <div class="two column row">
        <div class="right aligned five wide column">
              用户名
        </div>
    
        <div class="left aligned eleven wide column">
            <?php echo $this->get('merchant')['name']; ?>
        </div>
      </div>

      <div class="two column row">
        <div class="right aligned five wide column">
              联系方式
        </div>
    
        <div class="left aligned eleven wide column">
            <?php echo $this->get('merchant')['tel']; ?>
        </div>
      </div>

      <div class="two column row">
        <div class="right aligned five wide column">
              签到分
        </div>
    
        <div class="left aligned eleven wide column">
            <?php echo $this->get('merchant')['login_score']; ?>
        </div>
      </div>

    </div>
    <!-- ui celled grid end -->

    <!-- ui celled grid begin -->
    <div class="ui celled grid">
      <div class="sixteen wide column">
        <div class="ui top attached label">认证信息</div>
      </div>

      <div class="two column row">
        <div class="right aligned five wide  column">
              认证状态
        </div>
    
        <div class="left aligned eleven wide  column">
            <?php $verify_arr = array('0' => '未认证', '1' =>'已认证'); ?>
            <?php $stat = $this->get('merchant')['is_verified']; echo $verify_arr[$stat];?>
        </div>
      </div>

      <!--
      <div class="two column row">
        <div class="right aligned five wide  column">
              级别
        </div>
    
        <div class="left aligned eleven wide  column">
              普通商家
        </div>
      </div>

      <div class="two column row">
        <div class="right aligned five wide  column">
              积分
        </div>
    
        <div class="left aligned eleven wide  column">
              2938（离下一次升级为银牌商家[3000]，还差80个积分哟）
        </div>
      </div>
      -->

    </div>
    <!-- ui celled grid end -->

  </div>
  <!-- segment end -->

  <!-- segment begin -->
  <div class="ui bottom attached tab segment" data-tab="second">
    <!-- ui container begin -->
    <div class="ui container">
      <form class="ui form " action="<?php 
  echo $this->Html->url(
      array('controller' => 'shangjia',
          'action' => 'change_pass'
          )
      );
  ?>"
  method='post' onsubmit="return check_password();"
  >
          <div class="field">
            <label>原密码</label>
            <input placeholder="****" id="old_pass" name="ori_password" type="text">
          </div>

          <div class="field">
            <label>新密码</label>
            <input name="new_password" id="new_pass" type="password" placeholder="****">
          </div>

          <div class="field">
            <label>确认新密码</label>
            <input name="repeat_password" id="repeat_pass" type="password" placeholder="****">
          </div>

          <button type="submit" class='ui primary button'>确认修改</button>
        </form>
    </div>
    <!-- ui container end -->
  </div>
  <!-- segment end -->

  <!-- segment begin -->
  <div class="ui bottom attached tab segment" data-tab="third"> 
    <!-- ui container begin -->
    <div class="ui container">
      <table class="ui celled striped table">
        <thead>
          <tr>
            <th>time</th>
            <th>ip</th>
          </tr>
        </thead>

        <tbody>
        <?php foreach ($this->get('login_records') as $login_rec): ?>
        <tr>
        <td><?php  echo $login_rec['Mtlogin']['created']; ?></td>
        <td><?php echo $login_rec['Mtlogin']['login_ip']; ?></td>
        </tr>
        <?php endforeach; ?>

        </tbody>

      </table>
    </div>
    <!-- ui container end -->
  </div>
  <!-- segment end -->

<script type="text/javascript">
$(document).ready(function() { 
    $('.menu .item').tab();
});
</script>

</div>
  </div>
  <!-- segment end -->

<script type="text/javascript">
$(document).ready(function() { 
    $('.menu .item').tab();
});

function check_password() {
    var old_pass = $('#old_pass').val();
    var new_pass = $('#new_pass').val();
    var repeat_pass = $('#repeat_pass').val();

    if (old_pass == "" || new_pass == "" || repeat_pass == "") {
        window.alert("对不起，输入项不能为空！");
        return false;
    }

    if (old_pass == new_pass) {
        window.alert("对不起，新密码与旧密码相同！");
        return false;
    }

    if (repeat_pass != new_pass) {
        window.alert("对不起，两次输入新密码不一致！");
        return false;
    }
    return true;
}
</script>

</div>

