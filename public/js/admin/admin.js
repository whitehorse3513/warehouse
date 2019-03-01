function del_user($id) {
    $.ajax({
        url: $("#baseurl").val() + 'user/delete',
        data: {'del_id': $id},
        type: 'POST',
        dataType: 'json',
        success: function (msg) {
            if (msg) {
                parent.location.href = $("#baseurl").val() + 'user';
                alert("Deleted Successfully!");
            } else {

            }
            $('#del_modal').modal('hide');
        }
    });
}

function user_form_validate() {
    var firstname = $('#firstname').val();
    var lastname = $('#lastname').val();
    var email = $('#email').val();
    var password = $('#password').val();
    var confirm_password = $('#confirm_password').val();

    if ($.trim(firstname) == '') {
        alert('Por favor ingrese el nombre de usuario');
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