
$(document).ready(function() {
	$('#register').click(function () {
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
			url: '/user/user_add',
			data: {firstname: firstname, lastname: lastname, email: email, phone: phone, password: password, country: country,
				city: city, street: street, exterior: exterior, interior: interior, colonia: colonia},
			type: 'POST',
			dataType: 'json',
			success: function(data) {

				if (data.msg == 'success') {
					parent.location.href = '/login';
					alert("Registered Successfully!");
				}
				else
				{
					alert("Existing User!");
				}
			}
		});
	});
});
function user_form_validate() {
	var firstname = $('#firstname').val();
	var lastname = $('#lastname').val();
	var email = $('#email').val();
	var password = $('#password').val();
	var confirm_password = $('#confirm_password').val();

	if ($.trim(firstname) == '') {
		alert('Por favor ingrese el nombre del producto');
		$('#firstname').focus();
		return false;
	}
	if ($.trim(lastname) == '') {
		alert('Por favor ingrese el apellido del usuario');
		$('#lastname').focus();
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
	if ($.trim(confirm_password) == '') {
		alert('Por favor ingrese Confirmar contraseña');
		$('#confirm_password').focus();
		return false;
	}
	if ($.trim(confirm_password) != $.trim(password)) {
		alert('Por favor revisa tu contraseña');
		$('#password').focus();
		return false;
	}


	return true;
}