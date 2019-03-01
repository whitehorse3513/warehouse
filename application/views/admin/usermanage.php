<script src="<?php echo base_url() ?>public/js/admin/admin.js" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script>
	$(document).ready(function() {
        $('#country').val('114');
		$('#newuser_save').click(function(){
			if (user_form_validate() != true) {
				return;
			}
			var firstname = $('#firstname').val();
			var lastname = $('#lastname').val();
			var email = $('#email').val();
			var phone = $('#phone').val();
			var password = $('#password').val();
			var confirm_password = $('#confirm_password').val();
			var country = $('#country').val();
			var city = $('#city').val();
			var street = $('#street').val();
			var exterior = $('#exterior').val();
			var interior = $('#interior').val();
			var colonia = $('#colonia').val();
			$.ajax({
				url: '<?php echo base_url() ?>user/user_add',
				data: {firstname: firstname, lastname: lastname, email: email, phone: phone, password: password, country: country,
					city: city, street: street, exterior: exterior, interior: interior, colonia: colonia},
				type: 'POST',
				dataType: 'json',
				success: function(data) {

					if (data.msg=='success') {
						parent.location.href = '<?php echo base_url() ?>user';
						alert("<?php echo $this->lang->line("create_success_msg") ?>");
					}
					else
					{
						alert("<?php echo $this->lang->line("exist_user_msg") ?>");
					}
				}
			});
		});
		$('#search_btn').click(function(){
			var str = $('#search_str').val();
				$.ajax({
				url: '<?php echo base_url() ?>user/user_search',
				data: {'search_str': str},
				type: 'POST',
				dataType: 'html',
				success: function(data) {
					$('#user_table').html(data);
					
				}
			});
		});
	});
	function delete_user(id) {
		$('#user_del').attr('href','javascript:del_user('+id+')');
		$("#del_modal").modal();
	}
	function edit_user_modal(id)
	{
		parent.location.href = '<?php echo base_url() ?>user/permision?id='+id;
		//$("#add_modal").modal();
	}
	function add_user(){
		$("#add_modal").modal();
	}
</script>
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet light portlet-fit bordered">
	<div class="portlet-body">
		<div class="table-toolbar pull-right">
			<div class="row">
				<div class="col-md-6">
					<div class="btn-group ">
						<a id="newuser" href="javascript:add_user()" class="btn btn-primary"><i class="fa fa-plus"></i> Usuario
							
						</a>
					</div>
				</div>
			</div>
		</div>
		<div  style="overflow: auto; width: 100%;">
		<table class="table table-striped table-hover table-bordered" id="userdata">
			<thead>
			<tr>
				<th> # </th>
				<th> Nombre </th>
				<th> Mail </th>
				<th> Contraseña </th>
				<th> Telefono </th>
				<th> Pais </th>
				<th> Creacion </th>
				<th> Editar </th>
				<th> Borrar </th>
			</tr>
			</thead>
			<tbody id="user_table">
			<?php $i = 0; foreach($user as $user) {$i++; ?>
				<tr id="tr_<?php echo $user['id']; ?>">
					<td><?php echo $i; ?></td>
					<td><?php echo $user['name']; ?></td>
					<td><?php echo $user['email']; ?></td>
					<td><?php echo $user['password']; ?></td>
					<td><?php echo $user['phone']; ?></td>
					<td><?php echo $user['countryname']; ?></td>
					<td><?php echo $user['createdAt']; ?></td>
					<td><a class="fa fa-edit" href="javascript:edit_user_modal(<?php echo $user['id']; ?>)"> Editar</a></td>
					<td><a class="fa fa-trash-o" href="javascript:delete_user(<?php echo $user['id']; ?>)"> Borrar</a></td>
				</tr>
			<?php }?>
			</tbody>
		</table>
		</div>
	</div>
	<div class="modal fade bs-modal-sm in" id="del_modal" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?php echo $this->lang->line("question") ?></h4>
				</div>
				<div class="modal-body">
					<p>Seguro de borrar?</p>
				</div>
				<div class="modal-footer">
					<a href="" class="btn blue" id="user_del"><?php echo $this->lang->line("yes") ?></a>
					<button type="button" class="btn btn-green" data-dismiss="modal"><?php echo $this->lang->line("cancel") ?></button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade in" id="add_modal" tabindex="-1" aria-hidden="true" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title"><?php echo $this->lang->line("user") ?></h4>
				</div>
				<div class="modal-body">
					<div class="content">
						<div class="container-fluid">
							<div class="row">
								<div class="reg-body">
									<form action="">
										<div class="form-group">
											<div class="col-md-6">
												<label for="username">*<?php echo $this->lang->line("firstname") ?>:</label>
												<input type="text" class="form-control" id="firstname" placeholder="<?php echo $this->lang->line("firstname_placeholder") ?>" name="firstname">
											</div>

											<div class="col-md-6">
												<label for="username">*<?php echo $this->lang->line("lastname") ?>:</label>
												<input type="text" class="form-control" id="lastname" placeholder="<?php echo $this->lang->line("lastname_placeholder") ?>" name="lastname">
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<label for="username">*<?php echo $this->lang->line("email") ?>:</label>
												<input type="email" class="form-control" id="email" placeholder="<?php echo $this->lang->line("email_placeholder") ?>" name="email">
											</div>
											<div class="col-md-6">
												<label for="username"><?php echo $this->lang->line("phone") ?>:</label>
												<input type="text" class="form-control" id="phone" placeholder="<?php echo $this->lang->line("phonenumber_placeholder") ?>" name="phone">
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<label for="password">*<?php echo $this->lang->line("password") ?>:</label>
												<input type="password" class="form-control" id="password" placeholder="<?php echo $this->lang->line("password_placeholder") ?>" name="password">
											</div>
											<div class="col-md-6">
												<label for="confirm_password">*<?php echo $this->lang->line("confirm_pwd") ?>:</label>
												<input type="password" class="form-control" id="confirm_password" placeholder="<?php echo $this->lang->line("confirm_pwd_placeholder") ?>" name="confirm_password">
											</div>

										</div>
										<div class="form-group">
                                            <div class="col-md-6">
                                                <label class="control-label" for="country">*<?php echo $this->lang->line("country") ?>:</label>
                                                <select class="input-medium select2me edited" id="country" data-placeholder="Select...">
                                                    <?php foreach($country as $country){ ?>
                                                    <option value="<?php echo $country['id'];?>" selected=""><?php echo $country['countryname'];?>
                                                    <?php }?>
                                                </select>
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
										</div>
									</form>
								</div>

							</div>
						</div>
					</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn dark btn-outline"><?php echo $this->lang->line("cancel") ?></button>
					<button type="button" id="newuser_save" class="btn green"><?php echo $this->lang->line("create_user") ?></button>
				</div>
				</div>
			</div>
		</div>
	</div>
 </div>
