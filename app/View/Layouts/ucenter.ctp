<!DOCTYPE html>
<html>
  <head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $this->fetch('title'); ?> </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('bootstrap.min');
        //echo $this->Html->css('font-awesome.min');
        echo $this->Html->css('AdminLTE.min');
        echo $this->Html->css('skin-red');
        echo $this->Html->css('downloadPage');
        echo $this->Html->css('stylecss');
        //echo $this->Html->css('../plugins/iCheck/suqare/blue'); 
        echo $this->Html->script('../plugins/jQuery/jQuery-2.1.3.min');
        echo $this->Html->script('../plugins/iCheck/icheck.min');
        echo $this->Html->script('bootstrap.min');

        echo $this->fetch('mata');
    ?>
    <!-- iCheck -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <style>
        .row-env {
            background-color:#76A0D3;
        }
    </style>

    <script type="text/javascript">
        
        function check_email() {
          var re;
          var ss=$('#email').val();
          re= /\w@\w*\.\w/
          if(re.test(ss)) {
              return true;
          }
          else {
              alert('请输入正确的Email!');
              $('#email').focus();
              return false;
          }
        }

		function check_vcode() {
			var len = $('#checkcode').val().length;
			//alert($('#checkcode').val() + len);
			if (len != 4) {
				alert('请输入4位验证码！');
				$('#checkcode').focus();
				return false;
			}
			return true;
		}

        function check_pass() {
            var pass1 = $('#pass1').val();
            var pass2 = $('#pass2').val();
            if (pass1 == pass2) {
                return (check_email() && check_vcode()) ;
            }
            alert("两次输入密码不一致，请重新输入！");
            $('#pass1').focus();
            return false;
        }
    </script>
  </head>

<body class="skin-red layout">
    <?php 
        echo $this->Flash->render();
        echo $this->fetch('content');
    ?>

  </body>
</html>
