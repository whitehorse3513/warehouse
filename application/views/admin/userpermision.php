<div class="container-fluid">
	<div class="row">
		<div class="col-md-6">				
			<!-- BEGIN SAMPLE TABLE PORTLET-->
			<div class="portlet box yellow">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-comments"></i><?php echo $this->lang->line("permission") ?>
					</div>
				</div>
				<div class="portlet-body">
					<div class="table-scrollable">
						<table class="table table-bordered table-hover">
							<thead>
							<tr>
								<th> <?php echo $this->lang->line("type") ?> </th>
								<th> <?php echo $this->lang->line("add") ?> </th>
								<th> <?php echo $this->lang->line("delete") ?> </th>
								<th> <?php echo $this->lang->line("modify") ?> </th>
								<th> <?php echo $this->lang->line("view") ?> </th>
							</tr>
							</thead>
							<tbody>
								<?php $i = 0; foreach($userAuthority as $ua) {$i++; $str = decbin($ua['sellerAuthority']);?>		
								<tr>
									<td><?php echo $this->lang->line("seller") ?></td>
									<td><input id="s11" type="checkbox" <?php echo ((((int)$ua['sellerAuthority'] & 8) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s12" type="checkbox" <?php echo ((((int)$ua['sellerAuthority'] & 4) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s13" type="checkbox" <?php echo ((((int)$ua['sellerAuthority'] & 2) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s14" type="checkbox" <?php echo ((((int)$ua['sellerAuthority'] & 1) > 0) ? "checked" : "");?> ></input></td>		
								</tr>    
								<tr>     
									<td><?php echo $this->lang->line("provider") ?></td>
									<?php $str = $ua['providerAuthority'];?>
									<td><input id="s21" type="checkbox" <?php echo ((((int)$str & 8) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s22" type="checkbox" <?php echo ((((int)$str & 4) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s23" type="checkbox" <?php echo ((((int)$str & 2) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s24" type="checkbox" <?php echo ((((int)$str & 1) > 0) ? "checked" : "");?> ></input></td>	
								</tr>   
								<tr>    
									<td><?php echo $this->lang->line("customer") ?></td>										
									<?php $str = $ua['customerAuthority'];?>
									<td><input id="s31" type="checkbox" <?php echo ((((int)$str & 8) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s32" type="checkbox" <?php echo ((((int)$str & 4) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s33" type="checkbox" <?php echo ((((int)$str & 2) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s34" type="checkbox" <?php echo ((((int)$str & 1) > 0) ? "checked" : "");?> ></input></td>	
								</tr>  
								<tr>    
									<td><?php echo $this->lang->line("product") ?></td>										
									<?php $str = $ua['productAuthority'];?>
									<td><input id="s41" type="checkbox" <?php echo ((((int)$str & 8) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s42" type="checkbox" <?php echo ((((int)$str & 4) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s43" type="checkbox" <?php echo ((((int)$str & 2) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s44" type="checkbox" <?php echo ((((int)$str & 1) > 0) ? "checked" : "");?> ></input></td>	
								</tr>   
								<tr>   
									<td><?php echo $this->lang->line("sells") ?></td>
									<?php $str = $ua['sellsAuthority'];?>
									<td><input id="s51" type="checkbox" <?php echo ((((int)$str & 8) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s52" type="checkbox" <?php echo ((((int)$str & 4) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s53" type="checkbox" <?php echo ((((int)$str & 2) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s54" type="checkbox" <?php echo ((((int)$str & 1) > 0) ? "checked" : "");?> ></input></td>	
								</tr>   
								<tr>    
									<td><?php echo $this->lang->line("buy") ?></td>
									<?php $str = $ua['buyAuthority'];?>
									<td><input id="s61" type="checkbox" <?php echo ((((int)$str & 8) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s62" type="checkbox" <?php echo ((((int)$str & 4) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s63" type="checkbox" <?php echo ((((int)$str & 2) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s64" type="checkbox" <?php echo ((((int)$str & 1) > 0) ? "checked" : "");?> ></input></td>	
								</tr>    
								<tr>    
									<td><?php echo $this->lang->line("transfer") ?></td>
									<?php $str = $ua['transferAuthority'];?>
									<td><input id="s71" type="checkbox" <?php echo ((((int)$str & 8) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s72" type="checkbox" <?php echo ((((int)$str & 4) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s73" type="checkbox" <?php echo ((((int)$str & 2) > 0) ? "checked" : "");?> ></input></td>
									<td><input id="s74" type="checkbox" <?php echo ((((int)$str & 1) > 0) ? "checked" : "");?> ></input></td>	
								</tr>
								<?php }?>
							</tbody>
						</table>
					</div>
				</div>

			</div>

            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-comments"></i><?php echo $this->lang->line("warehouse_check") ?></div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> <?php echo $this->lang->line("name") ?> </th>
                                <th> <?php echo $this->lang->line("select") ?> </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $j = 0; foreach($warehouse as $warehouse) {$j++; ?>
                                <tr>
                                    <td><?php echo $j; ?></td>
                                    <td><?php echo $warehouse['name']; ?></td>
                                    <td><input id = "w<?php echo $warehouse['id']?>"type="checkbox"
                                            <?php
                                            $i = 0;
                                            foreach($warehousecheck as $check) {
                                                $i++;
                                                if($check['warehouseId']==$warehouse['id']){
                                                    echo "checked";
                                                }
                                            }
                                            ?>></input></td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
			<!-- END SAMPLE TABLE PORTLET-->
		</div>
		<div class="col-md-6">
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-edit font-dark"></i>
						<span class="caption-subject font-dark bold uppercase"><?php echo $this->lang->line("userdetail") ?></span>
					</div>
					<a id="backsaveuser" class="btn green pull-right"> <?php echo $this->lang->line("back") ?>
						<i class="fa fa-return"></i>
					</a>
				</div>
				<div class="portlet-body">
					<div class="note note-success">
					<?php $i = 0; foreach($userdata as $user) {$i++; ?>
                        <div class="reg-body" >
                            <div class="form-group  form-md-line-input form-md-floating-label col-md-12" >
                                <input type="text" class="form-control col-md-6" id="name" placeholder="" name="name" value = "<?php echo $user['name'];?>">
                                <label for="name"><?php echo $this->lang->line("name")?></label>
                            </div>
                        </div>
                        <div class="reg-body" >
                            <div class="form-group  form-md-line-input form-md-floating-label col-md-12" >
                                <input type="text" class="form-control col-md-6" id="email" placeholder="" name="email" value = "<?php echo $user['email'];?>">
                                <label for="email"><?php echo $this->lang->line("email") ?></label>
                            </div>
                        </div>
                        <div class="reg-body" >
                            <div class="form-group  form-md-line-input form-md-floating-label col-md-12" >
                                <input type="text" class="form-control col-md-6" id="password" placeholder="" name="password" value = "<?php echo $user['password'];?>">
                                <label for="password"><?php echo $this->lang->line("password") ?></label>
                            </div>
                        </div>
                        <div class="reg-body" >
                            <div class="form-group  form-md-line-input form-md-floating-label col-md-12" >
                                <input type="text" class="form-control col-md-6" id="phone" placeholder="" name="phone" value = "<?php echo $user['phone'];?>">
                                <label for="phone"><?php echo $this->lang->line("phone") ?></label>
                            </div>
                        </div>
                        <div class="reg-body" >
                            <div class="form-group form-md-line-input form-md-floating-label has-info col-md-12">
                                <select class="form-control input-large select2me"  id="country">
                                    <?php foreach($country as $country){ ?>
                                    <option value="<?php echo $country['id'];?>" selected=""><?php echo $country['countryname'];?>
                                    <?php }?>
                                </select>
                                <label for="country">Pais</label>
                                <label id="countrytempid" data-id="<?php echo $user['country'];?>" style="display:none"><?php echo $user['country'];?></label>
                            </div>
                        </div>
                        <div class="reg-body" >
                            <div class="form-group  form-md-line-input form-md-floating-label col-md-12" >
                                <input type="text" class="form-control col-md-6" id="city" placeholder="" name="city" value = "<?php echo $user['city'];?>">
                                <label for="city"> <?php echo $this->lang->line("city") ?> </label>
                            </div>
                        </div>
                        <div class="reg-body" >
                            <div class="form-group  form-md-line-input form-md-floating-label col-md-12" >
                                <input type="text" class="form-control col-md-6" id="street" placeholder="" name="street" value = "<?php echo $user['street'];?>">
                                <label for="street"> <?php echo $this->lang->line("street") ?> </label>
                            </div>
                        </div>
                        <div class="reg-body" >
                            <div class="form-group  form-md-line-input form-md-floating-label col-md-12" >
                                <input type="text" class="form-control col-md-6" id="exterior" placeholder="" name="exterior" value = "<?php echo $user['exterior'];?>">
                                <label for="exterior"> <?php echo $this->lang->line("exterior") ?> </label>
                            </div>
                        </div>
                        <div class="reg-body" >
                            <div class="form-group  form-md-line-input form-md-floating-label col-md-12" >
                                <input type="text" class="form-control col-md-6" id="interior" placeholder="" name="interior" value = "<?php echo $user['interior'];?>">
                                <label for="interior"> <?php echo $this->lang->line("interior") ?> </label>
                            </div>
                        </div>
                        <div class="reg-body" >
                            <div class="form-group  form-md-line-input form-md-floating-label col-md-12" >
                                <input type="text" class="form-control col-md-6" id="colonia" placeholder="" name="colonia" value = "<?php echo $user['colonia'];?>">
                                <label for="colonia"> <?php echo $this->lang->line("colonia") ?> </label>
                            </div>
                        </div>
                        <div class="reg-body"  >
                            <h5><b>.</b></h5>
                            <input style="display:none" type="text" class="form-control col-md-6" id="" placeholder="" name="" value = " ">
                            <label id="usernum" data-id="<?php echo $user['id'];?>" style="display:none"><?php echo $user['id'];?></label>
                        </div>
					<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
<script>
    function user_form_validate() {
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        if ($.trim(name) == '') {
            alert('Por favor ingrese el nombre del usuario');
            $('#username').focus();
            return false;
        }

        if ($.trim(email) == '') {
            alert('Por favor ingrese el correo electrónico del usuario');
            $('#email').focus();
            return false;
        }

        if ($.trim(password) == '') {
            alert('Por favor ingrese la contraseña de usuario');
            $('#password').focus();
            return false;
        }
        return true;
    }
	$(document).ready(function() {

		$('[id^="w"]').change(function(data){
			var ware_num = data.currentTarget['id'];			
			var state=document.getElementById(ware_num).checked;
			var usernum = $('#usernum').data("id");
			ware_num=ware_num.slice(1);
			$.ajax({
                url: '<?php echo base_url() ?>user/warehouse_check',
                data: {'usernum':usernum,'id':ware_num,'state':state},
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                }
            });
		});
		$('[id^="s"]').change(function(data){
			var auth_num = data.currentTarget['id'];			
			var state = document.getElementById(auth_num).checked;
			var usernum = $('#usernum').data("id");
			var id = auth_num.slice(1,2);
			auth_num = auth_num.slice(2);
			var value;
			if(state == true)
			{
				value = 2**(4-eval(auth_num));
			}
			else if(state == false)
			{
				value = 15-2**(4-eval(auth_num));
			}

			$.ajax({
                url: '<?php echo base_url() ?>user/authority_check',
                data: {'usernum':usernum,'id':id,'state':state,'value':value},
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                }
            });
		});
		$('#backsaveuser').click(function(){
            if (user_form_validate() != true) {
                return;
            }

            var usernum = $('#usernum').data("id");
            var name = $('#name').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var password = $('#password').val();
            var country = $('#country').val();
            var city = $('#city').val();
            var street = $('#street').val();
            var exterior = $('#exterior').val();
            var interior = $('#interior').val();
            var colonia = $('#colonia').val();
            $.ajax({
                url: '<?php echo base_url() ?>user/updateuser',
                data: {name: name, email: email, phone: phone, password: password, country: country,
                    city: city, street: street, exterior: exterior, interior: interior, colonia: colonia,usernum : usernum},
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    if (data.msg='success') {
                        parent.location.href = '<?php echo base_url() ?>user';
                    }
                    else
                    {
                        alert("<?php echo $this->lang->line("exist_user_msg") ?>");
                    }
                }
            });
        });
        $('#country').val($('#countrytempid').text());
	});
</script>
</html>