
<div class="ui container">
  <div class="ui segments">
    <div class="ui segment">
        <div class="ui top attached large label">ss账号总览</div>
          <div class="ui statistics">  <!-- statistics begin-->
        
            <div class="statistic">  <!-- statistic begin-->
              <div class="value"> 
                    <?php echo $this->get('total_ports_num');
                     ?>
              </div>
              <div class="lable">
                  ss账号数
              </div>
            </div> <!-- statistic end-->
        
            <div class="statistic">  <!-- statistic begin-->
              <div class="value"> 
                    <?php echo $this->get('expire_in_one_month');
                    ?>
                  
              </div>
              <div class="lable">
                  一个月内将过期
              </div>
            </div> <!-- statistic end-->
        
            <div class="statistic">  <!-- statistic begin-->
              <div class="value"> 
                    <?php echo $this->get('expire_in_one_week');
                        ?>
                  
              </div>
              <div class="lable">
                  7天内将过期
              </div>
            </div> <!-- statistic end-->

          </div>  <!-- statistics end-->
    </div>

    <div class="ui segment">
        <h3 class="ui top attached large label">ss账号说明</h3>
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
                <div class="header">不限流量</div>
                不限制使用流量，妈妈再也不用担心我看youtube流量不够啦！
              </div>
            </div>
            <!-- item end-->
        
            <!-- item begin-->
            <div class="item">
              <div class="content">
                <div class="header">客服随时答疑</div>
                使用过程中遇到的问题，可以随时向客服咨询，或提交吐槽/建议。
              </div>
            </div>
            <!-- item end-->

            <!-- item begin-->
            <div class="item">
              <div class="content">
                <div class="header">美国线路</div>
                <p>目前开通了美国Los Angeles线路，更多线路正在拓展中。</p>
              </div>
            </div>
            <!-- item end-->
        
            <!-- item begin-->
            <div class="item">
              <div class="content">
                <div class="header">试用后购买</div>
                <p>由于用户使用不同运营商提供的不同带宽的网络，连接速度差异较大，建议使用满意后购买。</p>
              </div>
            </div>
            <!-- item end-->
          </div>
          <!-- list area end -->

    </div> <!-- ui segment end -->

    <div class="ui segment">
        <div class="ui top attached large label">账号详情</div>
          <table class="ui celled striped table">
            <thead>
              <tr>
                <th>线路</th>
                <th>地址</th>
                <th>远程端口</th>
                <th>加密方式</th>
                <th>密码</th>
                <th>过期时间</th>
                <th>剩余时间</th>
                <th>操作</th>
              </tr>
            </thead>
    
            <tbody>
            <?php 
                $cents_per_yuan = $this->get("CENTS_PER_YUAN");
                $user_ports = $this->get('user_ports');
                foreach ($user_ports as $port):
                    $port_item = $port['Port'];
            ?>
            <tr>
              <td>美国洛杉矶</td>
              <td><?php echo $port_item['sshost']; ?></td>
              <td><?php echo $port_item['ssport']; ?></td>
              <td><?php echo $port_item['ssencrypt']; ?></td>
              <td><?php echo $port_item['sspass']; ?></td>
              <td><?php echo $port_item['expire']; ?></td>

              <?php if ($port_item['remain_days'] >=0): ?>
              <td><div class="ui right pointing label"><?php 
                    echo $port_item['remain_days'];
                ?>天后过期</div></td>

              <?php else: ?>
              <td><div class="ui right pointing label">账号已过期</div></td>
              <?php endif; ?>

              <td><a href='<?php 
                echo $this->Html->url([
                    'controller'=>'users',
                    'action'=>'renew_ss',
                    $port_item['id'],
                    ]);
                ?>' class="ui primary button">续费</a></td>
            </tr>
            <?php
                    endforeach;
            ?>
    
            <!-- total account < max show this buy link -->
            <tr>
              <td colspan=8>现在去<a href='<?php 
                echo $this->Html->url([
                    'controller'=>'users',
                    'action'=>'buy_ss',
                    ]);
                ?>' class="ui primary button">购买</a>新账号</td>
            </tr>
    
            </tbody>
    
          </table>
    </div>

    <div class="ui segment">
        <h3 class="ui top attached large label">ss使用教程</h3>
          <!-- list area begin -->
          <div class="ui bulleted list">
        
            <!-- item begin-->
            <div class="item">
              <div class="content">
                <div class="header">ss简介</div>
                <a href="<?php 
                echo $this->Html->url([
                    'controller' => 'tutorial'
                ]);
                    ?>">加密访问网络利器</a>
              </div>
            </div>
            <!-- item end-->
        
            <!-- item begin-->
            <div class="item">
              <div class="content">
                <div class="header">ss下载</div>
                <a href="<?php 
                echo $this->Html->url([
                    'controller' => 'tutorial',
                    'action' => 'trial_port',
                    '#' => 'download',
                ]);
                    ?>">多种客户端下载</a>
              </div>
            </div>
            <!-- item end-->
        
            <!-- item begin-->
            <div class="item">
              <div class="content">
                <div class="header">ss设置</div>
                <a href="<?php
                echo $this->Html->url([
                    'controller' => 'tutorial',
                    'action' => 'trial_port',
                    '#' => 'tutorials',
                ]);
                ?>">客户端ss账号设置</a>
              </div>
            </div>
            <!-- item end-->
        
          </div>
          <!-- list area end -->
    </div> <!-- ui segment end -->

  </div> <!-- ui segments end -->
</div>

