<div class="ui text container">
<div class="ui segments">  <!-- segments begin-->

<div class="ui segment"> <!-- segment begin-->
  <!--h3 class="ui left aligned header">order statistics</h3-->
  <div class="ui top attached large label">账户信息</div>

  <div class="ui celled grid">
    <div class="two column row">
      <div class="right aligned column">
            主机地址
      </div>
  
      <div class="left aligned column">
            <?php echo $this->get('ssip'); ?>
      </div>
    </div>

    <div class="two column row">
      <div class="right aligned eight wide column">
            <div class="text">远程端口</div>
      </div>
  
      <div class="left aligned eight wide column">
            <div class="text">
            <?php echo $this->get('ssport'); ?>
            </div>
      </div>
    </div>

    <div class="two column row">
      <div class="right aligned eight wide column">
            <div class="text">加密方式</div>
      </div>
  
      <div class="left aligned eight wide column">
            <div class="text">
            <?php echo $this->get('ssencrypt'); ?>
            </div>
      </div>
    </div>

    <div class="two column row">
      <div class="right aligned eight wide column">
            <div class="text">密码</div>
      </div>
  
      <div class="left aligned eight wide column">
            <div class="text">
            <?php echo $this->get('sspass'); ?>
            </div>
      </div>
    </div>

    <div class="two column row">
      <div class="right aligned eight wide column">
            <div class="text">期限</div>
      </div>
  
      <div class="left aligned eight wide column">
            <div class="text"><?php echo $this->get("ss_month"); ?>个月</div>
      </div>
    </div>

    <div class="two column row">
      <div class="right aligned eight wide column">
            <div class="text">收费</div>
      </div>
  
      <div class="left aligned eight wide column">
          <div class="text"><?php echo $this->get("charge_price"); ?>元</div>
      </div>
    </div>

  </div>

  <!-- list area begin -->
  <div class="ui bulleted list">
  
    <!--div class="item">
      <div class="content">
        <div class="header">用户可通过留下的手机号码+商家手机号查询上面的账号信息</div>
      </div>
    </div-->

    <div class="item">
      <div class="content">
        <div class="header">请至管理首页查看用户帮助信息（客户端下载、教程）</div>
      </div>
    </div>

  </div>
  <!-- list area end -->
  <div class="ui info message">
    <div class="header">跳转提示</div>
<p>此订单已录入系统，页面将在<span id="jump_seconds">60</span>秒后跳转......</p>
  </div>
  
</div>  <!-- segment end-->

</div>  <!-- segments end-->
</div>  <!-- container end-->

<script type="text/javascript">
$(document).ready(function(){
    function jump(count) {
        window.setTimeout(function() {
            --count;
            if (count >= 0) {
                $('#jump_seconds').html(count);
                jump(count);
            } else {
                // return;
                location.href = "<?php 
            echo Router::url(array('controller'=>'shangjia',
                    'action'=>'release_account'));
            ?>";
            }
        }, 1000);
    }

    var remain_seconds = $('#jump_seconds').html();
    jump(remain_seconds);
});
</script>
