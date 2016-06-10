

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
              <!--p>test@test.cn</p-->
							
              <!--a href="goods#"><i class="fa fa-circle text-success"></i>普通会员              <br> (
                2016-10-01 到期
              )
              </a-->
            </div>
          </div>
          
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">管理面板</li>
           <li ><a href=""><i class="fa fa-desktop"></i> 个人中心</a></li>
		   
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
            <small>若第一次使用请查看教程链接</small>
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
                   <caption>账户账务信息</caption>
                   <thead>
                      <tr>
                         <th>充值日期</th>
                         <th>余额</th>
                      </tr>
                   </thead>
                   <tbody>

                    <?php if ($this->get('coupon_info')) :  ?>
                      <tr class="danger">
                      <td>
                            <?php 
                                echo $this->get('coupon_info')['Coupon']['created'];
                            ?>
                       </td>
                       <td>
                            ￥<?php 
                                echo $this->get('coupon_info')['Coupon']['balance'];
                            ?>
                       </td>
                      </tr>

                    <?php else: ?>
                      <tr>
                       <td>
                        暂未查到记录
                       </td>

                       <td>
                       </td>
                      </tr>
                    <?php endif ?>
             
                   </tbody>
                </table>
             </div>      <!--table-responsive-->
          </div>  <!-- col-sm-xx -->

          <div class="col-sm-6">
            <?php if ($this->get('user_port')) :  ?>
             <div class="table">
                <table class="table table-striped">
                   <caption>shadowsocks账号信息</caption>
                   <thead>
                      <tr>
                         <th>描述</th>
                         <th>信息</th>
                      </tr>
                   </thead>
                   <tbody>
                      <tr>
                         <td>地址</td>
                         <td><?php echo $this->get('user_port')['Port']['sshost']; ?></td>
                      </tr>
                      <tr>
                         <td>远程端口</td>
                         <td><?php echo $this->get('user_port')['Port']['ssport']; ?></td>
                      </tr>
                      <tr>
                         <td>加密</td>
                         <td><?php echo $this->get('user_port')['Port']['ssencrypt']; ?></td>
                      </tr>
                      <tr>
                         <td>密码</td>
                         <td><?php echo $this->get('user_port')['Port']['sspass']; ?></td>
                      </tr>
                      <tr>
                         <td>过期时间</td>
                         <td><?php echo $this->get('user_port')['Port']['expire']; ?></td>
                      </tr>
             
                   </tbody>
                </table>
             </div>      <!--table-responsive-->
            <?php 
                    $remain_day = $this->get('remain_day');
                ?>
             <?php if ($remain_day > 0): ?>
             <span>账号将在<?php 
                    echo $remain_day;
                ?> 天后过期</span> 
             <?php elseif ($remain_second > 0 && $remain_day == 0): ?>
             <span>账号将在明天过期</span> 
             <?php else: ?>
             <span>账号已过期</span> 
             <?php endif; ?>
                    现在去<a class="btn btn-success" href="<?php
                    echo $this->Html->url(array(
                        'controller' => 'users',
                        'action' => 'renew_acc',
                    ));
                    ?>"
                >续费</a><br/>
                <span>将上述账号信息填入shadowsocks客户端即可开启科学上（翻）网（墙）模式，shadowsocks客户端
                <a href="<?php 
                            echo $this->Html->url(
                             array(
                                 'controller' => 'tutorial',
                                 'action' => 'trial_port',
                                 '#' => 'download'
                             )
                            );
                                ?>" 
                    class="btn btn-warning">
                             下载
                </a>
                    ，<font color=red>需要在浏览器中打开链接下载</font></span><br/>
            <?php else: ?>
            <span>暂时未获取到您的账号信息，您可以:</span><br/> <br/>
            <a href="<?php 
                echo $this->Html->url(['controller' => 'users', 'action' => 'buy_acc']);
                 ?>" class="btn btn-primary btn-lg active" role="button">购买科学上（翻）网（墙）账号</a>

            <?php endif ?>
          </div>    <!--  col -->

        </div>  <!-- row -->

        <div class="row">
          <div class="col-sm-6">
             <div class="table ">
                <table class="table table-striped">
                   <caption>shadowsocks帮助信息</caption>
                   <thead>
                      <tr>
                         <th>教程中的软件请用浏览器打开下载</th>
                         <!--th>链接</th-->
                      </tr>
                   </thead>
                   <tbody>
                      <tr>
                      <td>
                            <?php echo $this->Html->link(
                             '什么是shadowsocks?我可以用shadowsocks账号干什么?',
                             array(
                                 'controller' => 'tutorial',
                                 'action' => 'index'
                             )
                            );
                            ?>
                       </td>
                         <!--td>待发货</td-->
                      </tr>
                      <tr>
                         <td>
                            <?php echo $this->Html->link(
                             'shadowsocks客户端哪里下载？',
                             array(
                                 'controller' => 'tutorial',
                                 'action' => 'trial_port',
                                 '#' => 'download'
                             )
                            );
                            ?>
                        </td>
                      </tr>
                      <tr>
                         <td>
                            <?php echo $this->Html->link(
                             'shadowsocks账号mac/android/windows/apple客户端如何设置？',
                             array(
                                 'controller' => 'tutorial',
                                 'action' => 'trial_port',
                                 '#' => 'tutorials'
                             )
                            );
                            ?>
                        </td>
                      </tr>
             
                   </tbody>
                </table>
             </div>      <!--table-responsive-->
          </div>  <!-- col-sm-xx -->


          <div class="col-sm-6">
            <h3>投诉与建议 <small> 我来吐吐槽/我来献良策</small></h3>
            <form action="<?php  
                echo $this->Html->url(
                    array(
                        'controller' => "users",
                        'action' => 'save_advice'
                    )
                    );
                ?>"
                method="post" name="advice_form">
            <textarea class="form-control" name="content" rows="7" placeholder="我要投诉/建议" id="advice"></textarea>
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
                <hr/><br/>
                </form>
          </div> <!-- col -->
          
        </div> <!-- row -->

        </section>
        
      </div><!-- /.content-wrapper -->

        <!--rebuild end-->

  </div><!-- ./wrapper -->
