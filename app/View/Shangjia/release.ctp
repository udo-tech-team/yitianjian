<!-- ui modal begin -->
<div class="ui modal">
  <div class="header">Header</div>
  <div class="content">
    <p></p>
  </div>
  <div class="actions">
    <div class="ui approve button">Approve</div>
    <div class="ui button">Neutral</div>
    <div class="ui cancel button">Cancel</div>
  </div>
</div>
<!-- ui modal end -->

<script type="text/javascript">
function check_telephone() {
    var tele_len = $('#ss_tel').val().length;
    var tele_expect_len = 11;
    if (tele_len > 0 && tele_len != tele_expect_len) { 
        window.alert('电话号码位数有误！已输入长度' 
            + tele_len + '，应为' 
            + tele_expect_len + '位！');
        // $('#ss_tel').focus();
    }
    // window.alert(tele.length);
}

function confirm_release() {
    var confirm_str = '请您核对以下信息：\n\n';
    confirm_str += '用户电话:\t';
    confirm_str += $('#ss_tel').val();
    confirm_str += '\n续费时长:\t';
    confirm_str += $('#ss_month').val() + '个月';
    return window.confirm(confirm_str);
}
function confirm_input() {
    $('.ui.modal')
        .modal({
            onDeny : function() {
             //   window.alert('deny');
                return false;
            },
            onApprove : function() {
            //    window.alert('prove');
                return true;
            }
        });
    return $('.ui.modal').modal('show');
}
</script>

<div class="ui text container">
  <div class="ui segments">

    <!-- begin ui segment -->
    <div class="ui segment">
        <h2 class="ui center aligned header">发放账号</h2>
    </div> <!-- end ui segment -->

    <!-- begin ui segment -->
    <div class="ui segment">
    <form class="ui form " action="<?php 
echo $this->Html->url(
    array('controller' => 'shangjia',
        'action' => 'release_account'
        )
    );
?>"
method='post'
>
        <div class="field">
          <label>电话</label>
          <input id='ss_tel' onblur="check_telephone();" placeholder="138" name="telephone" type="text">
        </div>
        <div class="required field">
          <label>期限（20元/月）</label>
          <select id='ss_month' class="ui fluid dropdown" name="ss_month">
            <option value="1">1 个月</option>
            <option value="2">2 个月</option>
            <option value="3">3 个月</option>
            <option value="6">6 个月</option>
            <option value="9">9 个月</option>
            <option value="12">12 个月</option>
          </select>
        </div>
        <button onclick="return confirm_release();" 
                class='ui primary button'>发放</button>
      </form>
    </div> <!-- end ui segment -->

  </div> <!-- end ui segments -->

</div>  <!-- container end-->
