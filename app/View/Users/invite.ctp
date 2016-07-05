<div class="ui container">
  <div class="ui segments">
    <div class="ui segment">
        <div class="ui top attached large label">邀请统计总览</div>
          <div class="ui statistics">  <!-- statistics begin-->
        
            <div class="statistic">  <!-- statistic begin-->
              <div class="value"> 
                <?php 
                    $user_info = $this->get('user_info');
                    $voucher_recs = $this->get('voucher_recs');
                    echo $this->get('total_visit_count')
                        ?>
              </div>
              <div class="lable">
                  邀请链接被访问总数
              </div>
            </div> <!-- statistic end-->
        
            <div class="statistic">  <!-- statistic begin-->
              <div class="value"> 
                    <?php 
                        echo $this->get('uniq_visit_count')
                        ?>
              </div>
              <div class="lable">
                  独立访问数
              </div>
            </div> <!-- statistic end-->
        
            <div class="statistic">  <!-- statistic begin-->
              <div class="value"> 
                    <?php echo $user_info['invite_num'];
                        ?>
                  
              </div>
              <div class="lable">
                  好友注册数
              </div>
            </div> <!-- statistic end-->
        
            <div class="statistic">  <!-- statistic begin-->
              <div class="value"> 
                    <?php echo $this->get('total_voucher_count');
                        ?>
                  
              </div>
              <div class="lable">
                  我的金币数
              </div>
            </div> <!-- statistic end-->

          </div>  <!-- statistics end-->
    </div>

  <script type='text/javascript'>
    new Clipboard('#cpybt');
    new Clipboard('#cpybt2');
  </script>
    <div class="ui segment">
        <h3 class="ui top attached large label">我的邀请</h3>
          <div class="ui fluid action input">
            <input id="foo" readonly="readonly" value="<?php 
                        echo $this->Html->url(
                            array(
                                'controller' => 'users',
                                'action' => 'register',
                                $this->get('uniq_md5'),
                            ),
                            true
                        );
                    ?>">
               <div class="ui teal button" id="cpybt" data-clipboard-target="#foo" title="点击复制内容" alt="点击复制内容">
                 复制
               </div>
          </div>
          <div class="ui divider"></div>

          <div class="ui fluid action input">
            <textarea id="tarea" cols=100% rows=3 readonly="readonly" >我用了“倚天剑shadow”的ss账号，觉得还不错！邀请你也来用，从这个邀请链接里进去注册即获得金币！只能帮你到这啦！            <?php 
                        echo $this->Html->url(
                            array(
                                'controller' => 'users',
                                'action' => 'register',
                                $this->get('uniq_md5'),
                            ),
                            true
                        );
                 ?>   </textarea>
               <div class="ui teal button" id="cpybt2" data-clipboard-target="#tarea" title="点击复制内容" alt="点击复制内容">
                 复制
               </div>
          </div>

<div class="ui positive message">
  <div class="header">
    邀请说明
  </div>
  <ul class="list">
                <li> 分享上面的内容给朋友，或发布到社交网络上。</li>
                <li> 每有一个用户通过链接注册并购买账号成功后，1元金币将存入您的账户。</li>
                <li> 所有金币可用于购买账号，邀请好友方式获得的金币可联系客服提现。</li>
  </ul>
</div>
    </div> <!-- ui segment end -->

    <div class="ui segment">
        <h3 class="ui top attached large label">我的金币</h3>
          <table class="ui celled striped table">
            <thead>
              <tr>
                <th>券号</th>
                <th>获取方式</th>
                <th>获取时间</th>
                <th>过期时间</th>
                <th>券额</th>
                <th>剩余时间</th>
              </tr>
            </thead>
    
            <tbody>
            <?php 
                $get_from = array('', '邀请好友', '被好友邀请');
                foreach ($voucher_recs as $voucher):
                    $voucher_item = $voucher['Voucher'];
            ?>

            <tr>
              <td><?php echo $voucher_item['md5str']; ?></td>
              <td><?php $index = $voucher_item['get_from']; echo $get_from[$index]; ?></td></td>
              <td><?php echo $voucher_item['created']; ?></td>
              <td><?php echo $voucher_item['expire']; ?></td>
              <td><?php echo $voucher_item['amount'] / 100; ?>元</td>
              <td><div class="ui left pointing label"><?php echo $voucher_item['remaining_days']; ?>天后过期</div></td>
            </tr>

            <?php
                endforeach;
            ?>
    
            <!-- total account < max show this buy link -->
            <tr>
                <td colspan=7>金币将在消费时自动抵扣。现在去<a href="<?php 
                echo $this->Html->url([
                    'controller'=>'users',
                    'action'=>'buy_ss',
                    ]);

                ?>" class="ui primary button">购买账号</a></td>
            </tr>
    
            </tbody>
    
          </table>

    </div> <!-- ui segment end -->
  </div> <!-- ui segments end -->
</div>

