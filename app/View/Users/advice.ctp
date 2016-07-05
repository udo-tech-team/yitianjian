<script type="text/javascript">
function confirm_checkcode() {
    var checkcode = $('#checkcode').val();
    var len = $('#checkcode').val().length;
    if (len != 4) {
        window.alert('请输入4位验证码！');
        $('#checkcode').focus();
        return false;
    }
    return true;
}
</script>

<div class="ui container">
  <div class="ui segments">
    <div class="ui segment">
        <div class="ui top attached large label">我的建议</div>
          <div class="ui statistics">  <!-- statistics begin-->
        
            <div class="statistic">  <!-- statistic begin-->
              <div class="value">  <?php echo $this->get('total_advices'); ?>
              </div>
              <div class="lable">
                  我的建议
              </div>
            </div> <!-- statistic end-->
        
            <div class="statistic">  <!-- statistic begin-->
              <div class="value"> <?php echo $this->get('last_half_year_count'); ?>
                  
              </div>
              <div class="lable">
                  半年内建议
              </div>
            </div> <!-- statistic end-->
        
            <div class="statistic">  <!-- statistic begin-->
              <div class="value"> <?php echo $this->get('last_month_count'); ?>
                  
              </div>
              <div class="lable">
                  一个月内建议
              </div>
            </div> <!-- statistic end-->

          </div>  <!-- statistics end-->
    </div>

    <div class="ui segment">
        <h3 class="ui top attached large label">新的建议/吐槽</h3>

    <form class="ui form " action="<?php 
echo $this->Html->url(
    array('controller' => 'users',
        'action' => 'advice'
        )
    );
?>"
method='post'
>
        <div class="field">
          <label>建议/吐槽内容</label>
          <textarea name='content'></textarea>
            <div class="ui pointing label">
                这里填写您的建议/您的吐槽
            </div>
        </div>
        <div class="two fields">
            <div class="field">
                <div class="three fields">
                  <div class="field">
                      <img  style="float:right;" src="<?php echo $this->Html->url(array(
                          "controller"=>'users',
                          "action"=>'vcode')); ?>" width="" heigt="" style="cursor:pointer" 
                          onclick="document.getElementById('vcode').src='<?php 
                          echo $this->Html->url(array(
                          "controller"=>'users',
                          "action"=>'vcode')); ?>?'+ Math.random();"   
                          id="vcode"
                          />
                  </div>
                  <div class="field">
                      <a href="###" 
                          onclick="document.getElementById('vcode').src='<?php 
                          echo $this->Html->url(array(
                          "controller"=>'users',
                          "action"=>'vcode')); ?>?'+ Math.random();"   
                      class="text-center">看不清？点我！</a>
                  </div>
                  <div class="field">
                    <input type="text" name="vcode" id="checkcode" placeholder="验证码">
                  </div>
                </div>
            </div>
            <div class="field">
                <button onclick="return confirm_checkcode();" 
                     class='ui primary button'>提交</button>
            </div>
            
        </div>
      </form>


    </div> <!-- ui segment end -->

    <div class="ui segment">
        <div class="ui top attached large label">历史建议</div>
          <table class="ui celled striped table">
            <thead>
              <tr>
                <th>类型</th>
                <th>建议/吐槽内容</th>
                <th>创建时间</th>
                <!--<th>回复时间</th>
                <th>操作</th> -->
              </tr>
            </thead>
    
            <tbody>

            <?php 
                $user_advices = $this->get('user_advices');
                // var_dump($user_advices);
                foreach ($user_advices as $advice):
                    $advice_item = $advice['Advice'];
            ?>

            <tr>
              <td><div class="ui right pointing label">吐槽/建议</div></td>
              <td width="50%"><?php echo $advice_item['content']; ?></td>
              <td><?php echo $advice_item['created']; ?></td>
              <!-- <td>2016-08-20 20:10:40</td>
              <td><a href='' class="ui primary button">查看</a></td> -->
            </tr>

            <?php endforeach; ?>
    
            </tbody>
    
          </table>
    </div>

    <div class="ui segment">
        <h3 class="ui top attached large label">关于吐槽/建议</h3>
          <!-- list area begin -->
          <div class="ui bulleted list">
        
            <!-- item begin-->
            <div class="item">
              <div class="content">
                <div class="header">听取建议</div>
                我们将积极听取您的建议，并改善产品及用户体验。我们珍惜您的每一份建议！
              </div>
            </div>
            <!-- item end-->
        
            <!-- item begin-->
            <div class="item">
              <div class="content">
                <div class="header">接受吐槽</div>
                我们接受您的吐槽，感谢您让我们知道产品用得不爽的地方。我们一直在努力！
              </div>
            </div>
            <!-- item end-->
        

          </div>
          <!-- list area end -->
    </div> <!-- ui segment end -->

  </div> <!-- ui segments end -->
</div>

