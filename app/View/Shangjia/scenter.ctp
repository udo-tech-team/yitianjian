<div class="ui text container">
<div class="ui segments">  <!-- segments begin-->

<div class="ui segment"> <!-- segment begin-->
  <!--h3 class="ui left aligned header">order statistics</h3-->
  <div class="ui top attached large label">统计数据</div>
  <div class="ui statistics">  <!-- statistics begin-->

    <div class="statistic">  <!-- statistic begin-->
      <div class="value">
            <?php echo $this->get('history_total')
                / $this->get('CENTS_PER_YUAN') ; ?>
      </div>
      <div class="lable">
          历史成交
      </div>
    </div> <!-- statistic end-->

    <div class="statistic">  <!-- statistic begin-->
      <div class="value">
            <?php echo $this->get('last_month_total')
                / $this->get('CENTS_PER_YUAN') ; ?>
          
      </div>
      <div class="lable">
          上月成交
      </div>
    </div> <!-- statistic end-->

    <div class="statistic">  <!-- statistic begin-->
      <div class="value">
            <?php echo $this->get('cur_month_total')
                / $this->get('CENTS_PER_YUAN') ; ?>
      </div>
      <div class="lable">
          本月成交
      </div>
    </div> <!-- statistic end-->

    <div class="statistic">  <!-- statistic begin-->
      <div class="value">
            <?php echo $this->get('today_total')
                / $this->get('CENTS_PER_YUAN') ; ?>
      </div>
      <div class="lable">
          今日入账
      </div>
    </div> <!-- statistic end-->

  </div> <!-- statistics end-->
</div>  <!-- segment end-->

<div class="ui segment"> <!-- segment begin-->
  <h3 class="ui top attached large label">用户帮助信息</h3>
  <!-- list area begin -->
  <div class="ui bulleted list">

    <!-- item begin-->
    <div class="item">
      <div class="content">
        <div class="header">客户端下载</div>
        <a 
        href="<?php
            $url = Router::url(array(
                'controller' => 'tutorial',
                'action' => 'trial_port',
                '#' => 'download'), true);
            echo $url;
            ?>"
            >
        <?php
            echo $url;
        ?>
        </a>
      </div>
    </div>
    <!-- item end-->

    <!-- item begin-->
    <div class="item">
      <div class="content">
        <div class="header">用户教程</div>
        <a 
        href="<?php
            $url = Router::url(array(
                'controller' => 'tutorial',
                'action' => 'trial_port',
                '#' => 'tutorials',
            ), true);
            echo $url;
            ?>"
            >
        <?php
            echo $url;
        ?>
        </a>
      </div>
    </div>
    <!-- item end-->

    <!-- item begin-->
    <div class="item">
      <div class="content">
        <div class="header">用户查询账户信息</div>
        <a 
        href="<?php
            $url = Router::url(array(
                'controller' => 'users',
                'action' => 'register',
                ), true);
            echo $url;
            ?>"
            >
        <?php
            echo $url;
        ?>
        </a>
      </div>
    </div>
    <!-- item end-->

  </div>
  <!-- list area end -->

</div>  <!-- segment end-->

<div class="ui segment"> <!-- segment begin-->
  <h3 class="ui top attached large label">网址导航</h3>
  <!-- button area begin -->
  <div class="ui orange fluid four item inverted menu">
    <a class="item" target="_blank" href="http://www.facebook.com">脸书</a>
    <a class="item" target="_blank" href="http://www.google.com">谷歌</a>
    <a class="item" target="_blank" href="http://www.youtube.com">优土必</a>
    <a class="item" target="_blank" href="http://www.twitter.com">推特</a>
  </div>

  <div class="ui blue fluid four item inverted menu">
    <a class="item" target="_blank" href="http://scholar.google.com">谷歌学术</a>
    <a class="item" target="_blank" href="http://www.gmail.com">Gmail</a>
    <a class="item" target="_blank" href="http://www.blogspot.com">Blogspot</a>
    <a class="item" target="_blank" href="http://www.nytimes.com">纽约时报</a>
  </div>
  <!-- button area end -->

</div>  <!-- segment end-->

</div>  <!-- segments end-->
</div>  <!-- container end-->
