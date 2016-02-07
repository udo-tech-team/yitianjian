<div class="ui text container">
<div class="ui top attached tabular menu">
  <a class="item active" data-tab="first">今天</a>
  <a class="item" data-tab="second">本月</a>
  <a class="item" data-tab="third">历史</a>
</div>
  <div class="ui bottom attached tab segment active" data-tab="first">
    <!-- ui container begin -->
    <div class="ui container">
      <table class="ui celled striped table">
        <thead>
          <tr>
            <th>时间</th>
            <th>电话</th>
            <th>期限（月）</th>
            <th>收费</th>
          </tr>
        </thead>

        <tbody>
        <?php 
            $cents_per_yuan = $this->get("CENTS_PER_YUAN");
            foreach ($this->get('today_orders') as $border): ?>
        <tr>
          <td><?php echo $border['Mtorder']['created']; ?></td>
          <td><?php echo $border['Mtorder']['telephone']; ?></td>
          <td><?php echo $border['Mtorder']['months']; ?></td>
          <td><?php $price = ((int)($border['Mtorder']['charge_price'])
          / (int)$cents_per_yuan); 
            echo $price;
            ?></td>
        </tr>
        <?php endforeach; ?>

        </tbody>

      </table>
    </div>
    <!-- ui container end -->
  </div>

  <!-- segment begin -->
  <div class="ui bottom attached tab segment" data-tab="second">
    <!-- ui container begin -->
    <div class="ui container">
      <table class="ui celled striped table">
        <thead>
          <tr>
            <th>时间</th>
            <th>电话</th>
            <th>期限（月）</th>
            <th>收费</th>
          </tr>
        </thead>

        <tbody>
        <?php 
            $cents_per_yuan = $this->get("CENTS_PER_YUAN");
            foreach ($this->get('month_orders') as $border): ?>
        <tr>
          <td><?php echo $border['Mtorder']['created']; ?></td>
          <td><?php echo $border['Mtorder']['telephone']; ?></td>
          <td><?php echo $border['Mtorder']['months']; ?></td>
          <td><?php $price = ((int)($border['Mtorder']['charge_price'])
          / (int)$cents_per_yuan); 
            echo $price;
            ?></td>
        </tr>
        <?php endforeach; ?>

        </tbody>

      </table>
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
            <th>时间</th>
            <th>电话</th>
            <th>期限（月）</th>
            <th>收费</th>
          </tr>
        </thead>

        <tbody>
        <?php 
            $cents_per_yuan = $this->get("CENTS_PER_YUAN");
            foreach ($this->get('history_orders') as $border): ?>
        <tr>
          <td><?php echo $border['Mtorder']['created']; ?></td>
          <td><?php echo $border['Mtorder']['telephone']; ?></td>
          <td><?php echo $border['Mtorder']['months']; ?></td>
          <td><?php $price = ((int)($border['Mtorder']['charge_price'])
          / (int)$cents_per_yuan); 
            echo $price;
            ?></td>
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
</script>

</div>

