    <!-- Bootstrap 3.3.2 -->
    <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/custom.css" rel="stylesheet" type="text/css" />


  <!-- ADD THE CLASS layout-boxed TO GET A BOXED LAYOUT -->
  <!--body class="skin-red layout"-->
    <!-- Site wrapper -->
    <div class="wrapper">
		<div class="main-header">
        <a href="<?php echo $this->Html->url('/'); ?>" class="logo"><i class="fa fa-cart-arrow-down"></i> 倚天剑</a>
	    <!-- Header Navbar: style can be found in header.less -->
			<div class="navbar navbar-static-top">
					<?php 
						//if logged in
						if (!$this->Session->read('uid')):?>
				<ul class="nav navbar-nav pull-right">
                <li><a href="<?php echo $this->Html->url([
                    'controller'=>'users',
                    'action'=>'register']); ?>">
                <i class="fa fa-user"></i> 免费注册</a></li>
					<li><a href="<?php  echo $this->Html->url([
                    'controller'=>'users',
                    'action'=>'login']); 
						?>"><i class="fa fa-sign-in"></i> 会员登录</a></li>
				</ul>
					<?php 
                        //not logged in, in controller already judged, TODO
                        //2be deleted
						else: ?>
				<ul class="nav navbar-nav pull-right">
                <li><a href="<?php echo $this->Html->url([
                    'controller'=>'users',
                    'action'=>'ucenter']); ?>">
                <i class="fa fa-user"></i>我的主页</a></li>
				<li><a href="<?php echo $this->Html->url([
                    'controller'=>'users',
                    'action'=>'logout']); ?>">
					<i class="fa fa-sign-in"></i>注销</a></li>
				</ul>
					<?php endif; ?>
	       </div>
		</div>	
      

      <!-- Left side column. contains the sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <!--div class="pull-left image">
              <img src="dist/img/no-avatar.png" class="img-circle" alt="User Image" />
            </div-->
            <div class="pull-left info">
              <p>test@test.cn</p>
							
              <!--a href="goods#"><i class="fa fa-circle text-success"></i>普通会员              <br> (
                2016-10-01 到期
              )
              </a-->
            </div>
          </div>
          
          <!--p style="border: 2px dashed #9ACD32;margin:6px;padding: 3px 9px;">
            <i style="color: #ffff00" class="fa fa-fire fa-2"></i> 
            <a style="color:#ADFF2F" href="http://vip.qianbite.com/p/16/?r=dt" target="_blank">手续费狂降2%！</a>
          </p-->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">管理面板</li>
           <li ><a href=""><i class="fa fa-desktop"></i> 管理首页</a></li>
		   
		   <li ><a href=""><i class="fa fa-folder-open"></i> 管理商品</a></li>
		   <li><a href="?r=dm" target="_blank"><i class="fa fa-trophy"></i> 白金会员</a></li>
		   		   <li class='active'><a href=""><i class="fa fa-cog"></i> 账号设置</a></li>
		   <li ><a href=""><i class="fa fa-sign-out"></i> 注销</a></li>
		             </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

        <!--rebuild begin-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header col-sm-6">
          <h1>
            账号信息
            <small>若第一次使用请查看页面的帮助信息</small>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="msg">
            </div>
            <div class="row margin-bottom">
                <!--div class="col-lg-2 col-sm-3 col-xs-12 pull-right">
                    <button class="btn btn-block btn-primary" id="save-settings"><i class="fa fa-save"></i> 保存</button>
                </div-->
            </div>
            <!--div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4> 提醒！<h4>系统将对长时间未使用的账号回收！
            </div-->
        <div class="row">
          <div class="col-sm-6">
             <div class="table ">
                <table class="table table-striped">
                   <caption>shadowsocks账号信息（提醒：账号长时间不用将被系统回收！）</caption>
                   <thead>
                      <tr>
                         <th>描述</th>
                         <th>信息</th>
                      </tr>
                   </thead>
                   <tbody>
                      <tr>
                         <td>地址</td>
                         <td>scholar.gso.hk</td>
                      </tr>
                      <tr>
                         <td>端口</td>
                         <td>8992</td>
                      </tr>
                      <tr>
                         <td>加密</td>
                         <td>aes-256-cfb</td>
                      </tr>
                      <tr>
                         <td>密码</td>
                         <td>feab29</td>
                      </tr>
             
                   </tbody>
                </table>
             </div>      <!--table-responsive-->
          </div>    <!--  col -->

          <div class="col-sm-6">
             <div class="table ">
                <table class="table table-striped">
                   <caption>帮助信息</caption>
                   <thead>
                      <tr>
                         <th>描述</th>
                         <th>链接</th>
                      </tr>
                   </thead>
                   <tbody>
                      <tr>
                         <td>产品1</td>
                         <td>待发货</td>
                      </tr>
                      <tr>
                         <td>产品2</td>
                         <td>发货中</td>
                      </tr>
                      <tr>
                         <td>产品2</td>
                         <td>发货中</td>
                      </tr>
             
                   </tbody>
                </table>
             </div>      <!--table-responsive-->
          </div>
        </div>  <!-- row -->
        <div class="row">
          <div class="col-sm-6">
            <h3>投诉与建议 <small> 我来吐吐槽/我来献良策</small></h3>
            <textarea class="form-control" name="advice" rows="7" placeholder="我要投诉/建议" id="shop_brief"></textarea>
                <!--div class="col-lg-2 col-sm-3 col-xs-12 pull-right"-->
                <br/>
                <div class="pull-left">
                    <input type="text" style="width:80px;height:35px;" 
                    name="vcode" placeholder="验证码" />
                      <img src="<?php echo $this->Html->url(array(
                          "controller"=>'users',
                          "action"=>'vcode')); ?>" width="" heigt="" style="cursor:pointer" 
                          onclick="document.getElementById('vcode').src='<?php 
                          echo $this->Html->url(array(
                          "controller"=>'users',
                          "action"=>'vcode')); ?>?'+ Math.random();"   
                          id="vcode"
                          />
                      <a href="###" 
                          onclick="document.getElementById('vcode').src='<?php 
                          echo $this->Html->url(array(
                          "controller"=>'users',
                          "action"=>'vcode')); ?>?'+ Math.random();"   
                      class="text-center">看不清？点我！</a>
                          </div>
                <div class="pull-right">
                    <button class="btn btn-block btn-primary"  
                        id="save-settings"><i class="fa fa-save"></i> 提交</button>
                </div>
          </div>
          
        </div>

        </section>
        
      </div><!-- /.content-wrapper -->

        <!--rebuild end-->














      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header col-sm-6">
          <h1>
            账号设置
            <small>修改您的帐号信息</small>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
					
        <div class="msg">
        </div>
        <div class="row margin-bottom">
            <div class="col-lg-2 col-sm-3 col-xs-12 pull-right">
                <button class="btn btn-block btn-primary" id="save-settings"><i class="fa fa-save"></i> 保存</button>
            </div>
        </div>
        <div>
                <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4> 恭喜!</h4>您的资料修改成功！</div>
        </div>
        <div id="msg">
                <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4> 恭喜!</h4>您的资料修改成功！</div>
        </div>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-info"></i> 重要提示!</h4>
            您必须填写收款的支付宝账号，QQ号码，并设置店铺的相关信息才能发布收款链接。
        </div>

        <div class="row">
          <div class="col-sm-6">
          <div class="box">

            <div class="box-header with-border">
              <h3 class="box-title">基本设置</h3>
              <div class="box-tools pull-right">
                 <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div> <!--box-header-->

            <div class="box-body">
              <div class="clearfix"></div>
              <div class="form-group">
                <label>E-mail</label>
                <input class="form-control" placeholder="E-mail" value="test@test.test" id="email" type="text">
              </div>
              <div class="row row-even">
                <div class="col-sm-3">
                <label>QQ</label>
                </div>
                <div class="col-sm-3">
                <label> 515930293922</label>
                </div>
                <!--input class="form-control" placeholder="E-mail" value="0" id="qq" type="text"-->
              </div>
              <div class="form-group">
                <label class="text-red">支付宝账号 （填写错误将无法收款）</label>
                <input class="form-control" placeholder="收款支付宝账号"  value="" id="payment_address" type="text">
              </div>
              <div class="form-group">
                <label>真实姓名（与支付宝实名一致）</label>
                <input class="form-control" placeholder="真实姓名"  value="" id="payment_name" type="text">
              </div>
              <div class="form-group">
                <label>新密码</label>
                <input class="form-control" placeholder="如无需修改原密码，请留空" value="" id="password" type="password">
              </div>

            </div><!-- /.box-body -->
	
            <div class="overlay tableL" style="display:none;"><i class="fa fa-refresh fa-spin"></i></div>
          </div> <!--box-->


        </div> <!--col-end-->

<div class="col-sm-6">
<div class="box">
<div class="box-header with-border">
<h3 class="box-title">店铺设置</h3>
<div class="box-tools pull-right">
<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
</div>
</div>
<div class="box-body">
<div class="clearfix"></div>
<div class="form-group">
<label>店铺名称</label>
<input class="form-control" placeholder="店铺名称" value="" id="shop_name" type="text">
</div>
<div class="form-group">
<label>别名(二级域名)  <small id="edit_domain_chk"></small></label>
<input class="form-control" placeholder="二级域名（如：demo）" value=""  id="shop_alias" type="text">
<span class="help-block"><b>4-16位英文和数字组合</b>，申请后不能修改。如：http://<font id="alias_demo" color="red">demo</font>.qianbite.com (红色部分)</span> 
</div>
<div class="form-group">
<label>店铺介绍</label>
<textarea class="form-control" rows="7" id="shop_brief"></textarea>
</div>
</div><!-- /.box-body -->
<div class="overlay tableL" style="display:none;"><i class="fa fa-refresh fa-spin"></i></div>
</div>
</div>
	

  	  
</div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
  </div><!-- ./wrapper -->

    <!-- jQuery 2.1.3 -->
    <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="http://qianbite.com/plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
	<!-- dropZone -->
    <script src="plugins/dropzone/dropzone.js" type="text/javascript"></script>
	<!-- bootbox -->
    <script src="plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
	 <!-- ChartJS 1.0.1 -->
    <script src="plugins/chartjs/Chart.min.js" type="text/javascript"></script>
	<!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
	<!-- daterangepicker -->
	<script src="plugins/daterangepicker/moment.min.js" type="text/javascript"></script>
    <script src="plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
	 <!-- datepicker -->
    <script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- FLOT CHARTS -->
    <script src="plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
	<script src="plugins/flot/jquery.flot.time.min.js" type="text/javascript"></script>
	<script src="plugins/flot/jquery.flot.tooltip.min.js" type="text/javascript"></script>
    <script src="plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
    <!-- Select2 -->
    <script src="plugins/select2/select2.min.js" type="text/javascript"></script>

	
  <!--/body>
</html-->
<script>
$(document).ready(function() {

$('#shop_alias').on('change keyup', function(){
	var domain = $(this).val().replace(/\ +/g,"");
	var regDomain = /^\w+$/;
	$(this).val(domain);
	$('#alias_demo').text(domain);
		$.get("ajax/file_manager/check.php?d="+domain+"", function( data ) {
			if (data == '1' && regDomain.test(domain)) {
				$('#edit_domain_chk').html('<font color="green">提示: 可以使用。</font>');
			} else {
				$('#edit_domain_chk').html('<font color="red">提示: 该域名不可使用！</font>');
			}
		});
});

$("#save-settings").unbind("click").on("click", function(){
$.post( "ajax/account_settings/save_settings.php", {email: $("#email").val(), qq: $("#qq").val(), shop_name: $("#shop_name").val(), shop_alias: $("#shop_alias").val(), shop_brief: $("#shop_brief").val(), password: $("#password").val(), payment_method: 1, payment_address: $("#payment_address").val(), payment_name: $("#payment_name").val()}).done(
function( data ) {
	if (data == '0') {
		$("#msg").html('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> 资料未保存！</h4> 您的输入有误，请检查别名等信息！</div>');
		return false;
	}
	$("#msg").html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> 恭喜!</h4>您的资料修改成功！</div>');
}
);
});


});
</script>
