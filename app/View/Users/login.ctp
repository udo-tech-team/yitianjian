
    <div class="login-box">
      <div class="login-logo hide">
        <a href="login"></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">会员登录</p>
        <form action="<?php 
            echo $this->Html->url(
            array(
            'controller' => 'users',
            'action' => 'login'
            )
            );
            ?>" 
            method="post" onsubmit="return check_email();">
            <?php if ($this->get('isError') > 0): ?>
          <div class="alert alert-warning form-group">
            <!--input type="text" name="username" value="" class="form-control" placeholder="用户名"/--->
            <?php echo $this->get('errMsg'); ?>
            <!--span class="glyphicon glyphicon-user form-control-feedback"></span-->
          </div>
            <?php  endif; ?>
          <div class="form-group has-feedback">
			<input type="text" name="email" value="<?php if ($this->request->is('post')) { echo $this->request->data['email']; } ?>" 
				class="form-control" 
				id="email" placeholder="Email / Telephone"/>
            <span class="glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="密码"/>
            <span class="glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-4">    
              <!--div class="checkbox icheck">
                <label>
                  <input type="checkbox" name="remember"> 记住
                </label>
              </div-->                        
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
            </div><!-- /.col -->
          </div>
        </form>
<!--a href="forgot_password.php">忘记密码？</a--><br>
<a href="<?php 
            echo $this->Html->url(
                array('controller' => 'users',
                'action' => 'register'
            )
            );
?>" 
        class="text-center">还没有账号？请注册</a>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
