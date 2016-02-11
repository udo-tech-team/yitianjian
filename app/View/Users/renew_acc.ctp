<div class="ui text container">
  <div class="ui segments">

    <!-- begin ui segment -->
    <div class="ui segment">
        <h2 class="ui center aligned header">续费shadowsocks账号</h2>
    </div> <!-- end ui segment -->

    <!-- begin ui segment -->
    <div class="ui segment">
    <form class="ui form " action="<?php 
echo $this->Html->url(
    array('controller' => 'orders',
        'action' => 'alicreate'
        )
    );
?>"
method='post'
>
        <div class="ui message">
          <div class="header">有效期至</div>
            <?php echo $this->get('port')['expire']; ?>
        </div>
        <div class="required field">
          <label>续费（<?php 
            echo Configure::read('account_types.old_continue.monthly_price'); ?>
            元/月）
          </label>
          <input type=hidden name="acctype" value="<?php echo $this->get('acctype'); ?>" />
          <select id='ss_month' class="ui fluid dropdown" name="months">
            <option value="1">1 个月</option>
            <option value="2">2 个月</option>
            <option value="3">3 个月</option>
            <option value="6">6 个月</option>
            <option value="9">9 个月</option>
            <option value="12">12 个月</option>
          </select>
        </div>
        <div class="field">
        <div class="ui pointing label">
            续费1个月表示有效期顺延1个月
        </div>
        </div>
        <button onclick="return confirm_release();" 
                class='ui primary button'>续费</button>
      </form>
    </div> <!-- end ui segment -->

<div class="ui segment"> <!-- segment begin-->
  <h3 class="ui top attached large label">用户帮助信息</h3>
  <!-- list area begin -->
  <div class="ui bulleted list">

    <!-- item begin-->
    <div class="item">
      <div class="content">
        <div class="header">7天无理由退款</div>
        若在使用过程7天内，有任何账号、软件问题，无条件退还所有款项。
      </div>
    </div>
    <!-- item end-->

    <!-- item begin-->
    <div class="item">
      <div class="content">
        <div class="header">美国线路</div>
        服务器位于美国Los Angeles，稳定快速，适合大众科学上网需求。
      </div>
    </div>
    <!-- item end-->

    <!-- item begin-->
    <div class="item">
      <div class="content">
        <div class="header">不限流量</div>
        流量不设限！妈妈再也不用担心我上youtube流量不够用啦！
      </div>
    </div>
    <!-- item end-->

  </div>
  <!-- list area end -->

</div>  <!-- segment end-->

  </div> <!-- end ui segments -->

</div>  <!-- container end-->
