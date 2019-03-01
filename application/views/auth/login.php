<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
	<html>
	<head>
		<title><?php echo $this->lang->line("login_title") ?></title>
		<link href="<?php echo base_url() ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/css/login.css">
	</head>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/global/plugins/jquery.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#login').click(function(){
			    var email = $('#email').val();
			    var password = $('#pwd').val();
                $.ajax({
                    url: '<?php echo base_url() ?>user/login',
                    data: {'email': email, 'password': password},
                    type: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        if (data.msg=='success') {
                            parent.location.href = '<?php echo base_url() ?>';
                        }
                        else
                        {
                           $('#is_warning').css({'display':'block', 'color': 'red'});
                        }
                    }
                });

			});
		});
	</script>
	<body>
		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-offset-4 col-md-3 login-content">
						<div class="login-header text-center">
							<h1><a href="#" style="text-decoration: none;"><?php echo $this->lang->line("warehouse_logo") ?></a></h1>
						</div>
						<div class="login-body">
							<form action="">
							    <div class="form-group">
							      <label for="email"><?php echo $this->lang->line("email") ?>:</label>
							      <input type="emal" class="form-control" id="email" placeholder="<?php echo $this->lang->line("email_placeholder") ?>" name="email">
							    </div>
							    <div class="form-group">
							      <label for="pwd"><?php echo $this->lang->line("password") ?>:</label>
							      <input type="password" class="form-control" id="pwd" placeholder="<?php echo $this->lang->line("password_placeholder") ?>" name="pswd">
							    </div><br>
							    <div class="form-group form-check">
							      <a class="btn btn-primary login-btn pull-right login-btn" id="login" name="login" href="#"><?php echo $this->lang->line("login") ?></a>
							    </div>
						    </form><br>
						    <div>
						    	<p  id="is_warning" style="display: none"><?php echo $this->lang->line("forget_pwd") ?> .</p>
						    	<!--<p> Not member yet? Click <a href= "<?php echo base_url() ?>user/register">here</a>.</p>-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>