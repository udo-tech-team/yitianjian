<div class="ui container">
  <div class="ui segments">
    <div class="ui segment">
        <div class="ui top attached large label">购买ss账号</div>
          <div class="ui statistics">  <!-- statistics begin-->
        
            <div class="statistic">  <!-- statistic begin-->
              <div class="value"> 
                    <?php echo $this->get('lines_count')
                        ?>
              </div>
              <div class="lable">
                  目前可用线路数
              </div>
            </div> <!-- statistic end-->
          </div>  <!-- statistics end-->
    </div> <!-- ui segment end -->

    <div class="ui segment"> <!-- ui segment begin -->
      <div class="ui cards"> <!-- ui cards begin -->

        <?php 
            $cents_per_yuan = 100;
            foreach ($this->get('basic_single_lines_arr') as $line):
                $line_info = $line['Line'];
            ?>
        <div class="card"> <!-- card begin -->
          <div class="content">
            <div class="header"><?php 
                    echo $line_info['country_cn'] . $line_info['city_cn']; 
                ?>专线</div>
            <div class="description">
                <ul class="ui list">
                    <li><?php echo $line_info['city'] . $line_info['city_cn'];?>机房</li>
                    <li>不限流量</li>
                    <li><?php 
                $price = ((int)$line_info['monthly_price']) / (int)$cents_per_yuan;
                echo $price;
                    ?>
                    元/月</li>
                    <li>7 天无理由退款</li>
                    <li>7*24小时支付宝随时下单购买</li>
                    <li>客服随时解答使用疑难</li>
                    <li>建议在<a href="<?php
                        echo $this->Html->url(
                            array(
                                'controller' => 'tutorial',
                                'action' => 'trial_port',
                                '#' => 'free',
                            )
                        );
                    ?>">试用</a>满意后再购买！</li>
                </ul>
            </div>
          </div>
          <!--div class="ui bottom attached button" onclick="$('#Japan').modal('show');">
            抢先试用
          </div-->
          <a href="<?php 
                echo $this->Html->url(
                    array(
                        'controller' => 'users',
                        'action' => 'make_order',
                        $line_info['id'],
                    )
                );
                ?>" class="ui bottom attached primary button">
            购买账号
          </a> 
        </div>  <!-- card end-->
        <?php endforeach;?>


        <div class="card"> <!-- card begin -->
          <div class="content">
            <div class="header">更多线路</div>
            <div class="description">
              正在努力拓展中......
            </div>
          </div>
          <a href="<?php    
            echo $this->Html->url([
                'controller' => 'users',
                'action' => 'info',
                '点赞成功！',
                '谢谢您的支持！您的支持是我们完善服务，提供更好产品的动力！',
                'success',
                2,
            ]);
            ?>" class="ui bottom attached primary button">
            我来点赞支持！
          </a>
        </div>  <!-- card end-->

      </div> <!-- ui cards end -->

    </div> <!-- ui segment end -->
  </div> <!-- ui segments end -->
</div>

<div class="ui modal" id="Japan">
  <div class="header">
    Profile Picture
  </div>
  <div class="content">
    <div class="description">
      <div class="ui header">我们为你自动选择了一张资料图片.</div>
        <p>我们从<a href="https://www.gravatar.com" target="_blank">gravatar</a>抓取的下面这些图片，图像与你注册的邮箱地址相关.</p>
            <p>可以使用这张照片吗? Japan here. Welcome!</p>
    </div>
  </div>
  <div class="actions">
    <div class="ui positive right labeled icon button">
      确定
    </div>
  </div>
</div>

<div class="ui modal" id="American">
  <div class="header">
    Profile Picture
  </div>
  <div class="content">
    <div class="description">
      <div class="ui header">我们为你自动选择了一张资料图片.</div>
        <p>我们从<a href="https://www.gravatar.com" target="_blank">gravatar</a>抓取的下面这些图片，图像与你注册的邮箱地址相关.</p>
            <p>可以使用这张照片吗?</p>
    </div>
  </div>
  <div class="actions">
    <div class="ui positive right labeled icon button">
      确定
    </div>
  </div>
</div>

        
