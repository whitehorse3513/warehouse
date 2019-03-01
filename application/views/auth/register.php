<!DOCTYPE html>
<html>
<head>
	<title><?php echo $this->lang->line("register_title") ?></title>
	<link href="<?php echo base_url() ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/css/register.css">
</head>
<script type="text/javascript" src="<?php echo base_url() ?>assets/global/plugins/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>public/js/auth/register.js"></script>
<body>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-offset-3 col-md-6 reg-content">
                <div class="reg-header text-center">
                    <h1><a href="#" style="text-decoration: none;"><?php echo $this->lang->line("register_subtitle") ?></a></h1>
                </div>
                <div class="reg-body">
                <form action="">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="firstname"><?php echo $this->lang->line("firstname") ?>:</label>
                            <input type="text" class="form-control" id="firstname" placeholder="<?php echo $this->lang->line("firstname_placeholder") ?>" name="firstname">
                        </div>

                        <div class="col-md-6">
                            <label for="lastname"><?php echo $this->lang->line("lastname") ?>:</label>
                            <input type="text" class="form-control" id="lastname" placeholder="<?php echo $this->lang->line("lastname_placeholder") ?>" name="lastname">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="email"><?php echo $this->lang->line("email") ?>:</label>
                            <input type="email" class="form-control" id="email" placeholder="<?php echo $this->lang->line("email_placeholder") ?>" name="email">
                        </div>
                        <div class="col-md-6">
                            <label for="phone"><?php echo $this->lang->line("phone") ?>:</label>
                            <input type="text" class="form-control" id="phone" placeholder="<?php echo $this->lang->line("phonenumber_placeholder") ?>" name="phone">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="password"><?php echo $this->lang->line("password") ?>:</label>
                            <input type="password" class="form-control" id="password" placeholder="<?php echo $this->lang->line("password_placeholder") ?>" name="password">
                        </div>
                        <div class="col-md-6">
                            <label for="confirm_password"><?php echo $this->lang->line("confirm_pwd") ?>:</label>
                            <input type="password" class="form-control" id="confirm_password" placeholder="<?php echo $this->lang->line("confirm_pwd_placeholder") ?>" name="confirm_password">
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="country"><?php echo $this->lang->line("country") ?>:</label>
                            <input type="text" class="form-control" id="country" placeholder="<?php echo $this->lang->line("country_placeholder") ?>" name="country">
                        </div>
                        <div class="col-md-6">
                            <label for="city"><?php echo $this->lang->line("city") ?>:</label>
                            <input type="text" class="form-control" id="city" placeholder="<?php echo $this->lang->line("city_placeholder") ?>" name="city">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="street"><?php echo $this->lang->line("street") ?>:</label>
                            <input type="text" class="form-control" id="street" placeholder="<?php echo $this->lang->line("street_placeholder") ?>" name="street">
                        </div>
                        <div class="col-md-6">
                            <label for="exterior"><?php echo $this->lang->line("exterior") ?>:</label>
                            <input type="text" class="form-control" id="exterior" placeholder="<?php echo $this->lang->line("exterior_placeholder") ?>" name="exterior">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="interior"><?php echo $this->lang->line("interior") ?>:</label>
                            <input type="text" class="form-control" id="interior" placeholder="<?php echo $this->lang->line("interior_placeholder") ?>" name="interior">
                        </div>
                        <div class="col-md-6">
                            <label for="colonia"><?php echo $this->lang->line("colonia") ?>:</label>
                            <input type="text" class="form-control" id="colonia" placeholder="<?php echo $this->lang->line("colina_placeholder") ?>" name="colonia">
                        </div>
                    </div>
                    <div class="form-group" style="padding-right: 15px; padding-top: 30px;">
                        <a class="btn btn-primary pull-right cancel-btn" style="margin-top: 30px;margin-bottom: 30px;" id="cancel" href="<?php echo base_url() ?>login"><?php echo $this->lang->line("cancel") ?></a>
                        <button class="btn btn-primary login-btn pull-right register-btn" style="margin-top: 30px;margin-bottom:30px;" name="register" id="register"><?php echo $this->lang->line("register") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</body>
<script type="text/javascript">
	$(document).ready(function(){
		$('#login').click(function(){
			$('#is_warning').css({'display':'block', 'color': 'red'});
		});
	});
</script>
</html>