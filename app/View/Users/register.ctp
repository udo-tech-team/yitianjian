
    <div class="login-box">
      <div class="login-logo hide">
        <a href="register">倚天剑</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">免费注册倚天剑</p>
        <form action="<?php 
            echo $this->Html->url(
            array(
            'controller' => 'users',
            'action' => 'register'
            )
            );
            ?>" 
			method="post" onsubmit="return check_pass();" >

            <?php if (!empty($this->Session->read('money'))): ?>
          <div class="alert alert-success form-group">
            <!--input type="text" name="username" value="" class="form-control" placeholder="用户名"/--->
            <?php echo $this->get('remindInfo'); ?>
            <!--span class="glyphicon glyphicon-user form-control-feedback"></span-->
          </div>
            <?php  endif; ?>

            <?php if ($this->get('isError') > 0): ?>
          <div class="alert alert-warning form-group">
            <!--input type="text" name="username" value="" class="form-control" placeholder="用户名"/--->
            <?php echo $this->get('errMsg'); ?>
            <!--span class="glyphicon glyphicon-user form-control-feedback"></span-->
          </div>
            <?php  endif; ?>

          <div class="form-group has-feedback">
              <input type="text" name="email" id="email" value="<?php if ($this->request->is('post')) { echo $this->request->data['email']; } ?>"
                     class="form-control" placeholder="Email / Telephone"/>
            <!--span class="glyphicon glyphicon-envelope form-control-feedback"></span-->
            <span class="glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" id="pass1" 
                value="<?php if ($this->request->is('post')) { echo $this->request->data['password']; } ?>"
                    class="form-control" placeholder="密码"/>

            <span class="glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" id="pass2" name="password2" 
                value="<?php if ($this->request->is('post')) { echo $this->request->data['password2']; } ?>"
                class="form-control" placeholder="重复密码"/>
            <span class="glyphicon-log-in form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-4">
            
                <?php 
                    //read session like this
                     $this->Session->read('vcode');
                ?> 
            <input type="text" id="checkcode" name="checkcode" class="form-control" placeholder="验证码" />
            </div>
            <div class="col-xs-3">
            <img src="<?php echo $this->Html->url(array(
                "controller"=>'users',
                "action"=>'vcode')); ?>" width="" heigt="" style="cursor:pointer" 
                onclick="document.getElementById('vcode').src='<?php 
                echo $this->Html->url(array(
                "controller"=>'users',
                "action"=>'vcode')); ?>?'+ Math.random();"   
                id="vcode"
                />
            </div>
            <div class="col-xs-5">
            <a href="#" 
                onclick="document.getElementById('vcode').src='<?php 
                echo $this->Html->url(array(
                "controller"=>'users',
                "action"=>'vcode')); ?>?'+ Math.random();"   
            class="text-center">看不清？点我！</a>
            </div>
          </div>
          <div class="row">
            <br/>
           <div class="col-xs-4">    
              <!--div class="checkbox">
                <label class="checkbox">
                  <input  name="terms" type="checkbox"> 我同意 <a href="register#">服务条款</a>
                </label>
              </div-->                        
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat" >注册</button>
            </div><!-- /.col -->
          </div>
        </form>       

        
        <a href="<?php 
                echo $this->Html->url(
                    array('controller'=>'users',
                        'action' => 'login'
                ));
                ?>" class="text-center">已经有了账号，请登录！</a>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
