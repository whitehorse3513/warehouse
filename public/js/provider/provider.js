function delete_provider(id) {
    $.ajax({
        url: provider_delete,
        data: {pid: id},
        type: 'POST',
        dataType:'html',
        success: function(msg) {
            if (msg){
                $('#tr_'+id).css('display', 'none');
                $('#success_text').text('Proveedor eliminado correctamente.');
                $('#success_msg').css('display', 'block');
                $('#provider_table').html(msg);
            }else {
                $('#warning_text').text("El proveedor no eliminó.");
                $('#warning_msg').css('display', 'block');
                $('#provider_table').html(msg);
            }

            $('#del_modal').modal('hide');
        }
    });
}

function add_provider_modal() {
    $('#modal_name').text('Añadir proveedor');
    $('#provider_ctrl').attr('href', 'javascript:add_provider()');
    $('#provider_modal').modal();

    $('#name').val('');
    $('#street').val('');
    $('#extStreetNumber').val('');
    $('#inStreetNumber').val('');
    $('#complementary_info').val('');
    $('#city').val('');
    $('#zipcode').val('');
    $('#country').select2('val','');
    $('#phonenumber').val('');
    $('#mail').val('');
    $('#state').val('');
}

function add_provider() {
    if (provider_form_validate() != true)
        return;
    var No = 0;
    $( "[id^='tr_']" ).each(function( index ) {
        No++;
    });
    var name = $('#name').val();
    var street = $('#street').val();
    var extstreetnumber = $('#extStreetNumber').val();
    var inStreetNumber = $('#inStreetNumber').val();
    var complementaryInfo = $('#complementary_info').val();
    var city = $('#city').val();
    var zipcode = $('#zipcode').val();
    var sel = document.getElementById('country');
    var country = sel.options[sel.selectedIndex].value;
    var phonenumber = $('#phonenumber').val();
    var mail = $('#mail').val();
    var state = $('#state').val();
    $.ajax({
        url: provider_add,
        data: {name: name, street:street , extStreetNumber: extstreetnumber, inStreetNumber: inStreetNumber, complementaryInfo: complementaryInfo, city: city,zipcode:zipcode,
            country:country, phonenumber: phonenumber, mail:mail, state:state,
        },
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            if (data.type) {
                $('#provider_table').html(data.html);
                $('#provider_modal').modal('hide');
                $('#success_text').text('Proveedor de éxito añadido.');
                $('#success_msg').css('display', 'block');
                 name = $('#name').val('');
                 street = $('#street').val('');
                 extstreetnumber = $('#extStreetNumber').val('');
                 inStreetNumber = $('#inStreetNumber').val('');
                 complementaryInfo = $('#complementary_info').val('');
                 city = $('#city').val('');
                 zipcode = $('#zipcode').val('');
                 country = $('#country').val('');
                 phonenumber = $('#phonenumber').val('');
                 mail = $('#mail').val('');
                 state = $('#state').val('');
            }
            else{
                $('#provider_modal').modal('hide');
                $('#warning_text').text("Proveedor de fallos de adición!");
                $('#warning_msg').css('display', 'block');
                name = $('#name').val('');
                street = $('#street').val('');
                extstreetnumber = $('#extStreetNumber').val('');
                inStreetNumber = $('#inStreetNumber').val('');
                complementaryInfo = $('#complementary_info').val('');
                city = $('#city').val('');
                zipcode = $('#zipcode').val('');
                country = $('#country').val('');
                phonenumber = $('#phonenumber').val('');
                mail = $('#mail').val('');
                state = $('#state').val('');
            }
        }
    });
}

function edit_provider_modal(id) {
    $('#name').val($('#tr_'+id+" td:eq(1)").text());
    $('#street').val($('#tr_'+id+" td:eq(2)").text());
    $('#extStreetNumber').val($('#tr_'+id+" td:eq(3)").text());
    $('#inStreetNumber').val($('#tr_'+id+" td:eq(4)").text());
    $('#complementary_info').val($('#tr_'+id+" td:eq(5)").text());
    $('#city').val($('#tr_'+id+" td:eq(6)").text());
    $('#zipcode').val($('#tr_'+id+" td:eq(7)").text());
    $('#country').select2('val',$('#tr_' + id + " td:eq(8)").text());
    $('#phonenumber').val($('#tr_'+id+" td:eq(10)").text());
    $('#mail').val($('#tr_'+id+" td:eq(11)").text());
    $('#state').val($('#tr_'+id+" td:eq(12)").text());
    $('#modal_name').text('provider Edit');
    $('#provider_ctrl').attr('href', 'javascript:edit_provider('+id+')');
    $('#provider_modal').modal();
}

function edit_provider(id) {
    if (provider_form_validate() != true)
        return;
    var name = $('#name').val();
    var street = $('#street').val();
    var extStreetNumber = $('#extStreetNumber').val();
    var inStreetNumber = $('#inStreetNumber').val();
    var complementaryInfo = $('#complementary_info').val();
    var city = $('#city').val();
    var zipcode = $('#zipcode').val();
    var sel = document.getElementById('country');
    var country = sel.options[sel.selectedIndex].value;
    var phonenumber = $('#phonenumber').val();
    var mail = $('#mail').val();
    var state = $('#state').val();

    $.ajax({
        url: provider_edit,
        data: {pid:id,name: name, street:street , extStreetNumber: extStreetNumber, inStreetNumber: inStreetNumber, complementaryInfo: complementaryInfo, city: city,zipcode:zipcode,
            country:country, phonenumber: phonenumber, mail:mail, state:state,
        },
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            if (data.type) {
                $('#provider_modal').modal('hide');
                $('#success_text').text('Proveedor actualizado correctamente.');
                $('#success_msg').css('display', 'block');
                $('#provider_table').html(data.html);
                name = $('#name').val('');
                street = $('#street').val('');
                extStreetNumber = $('#extStreetNumber').val('');
                inStreetNumber = $('#inStreetNumber').val('');
                complementaryInfo = $('#complementary_info').val('');
                city = $('#city').val('');
                zipcode = $('#zipcode').val('');
                country = $('#country').val('');
                phonenumber = $('#phonenumber').val('');
                mail = $('#mail').val('');
                state = $('#state').val('');
                $('#vender_table').html(data);
            }
            else{
                $('#provider_modal').modal('hide');
                $('#warning_text').text("El proveedor no actualizó.");
                $('#warning_msg').css('display', 'block');
                name = $('#name').val('');
                street = $('#street').val('');
                extStreetNumber = $('#extStreetNumber').val('');
                inStreetNumber = $('#inStreetNumber').val('');
                complementaryInfo = $('#complementary_info').val('');
                city = $('#city').val('');
                zipcode = $('#zipcode').val('');
                country = $('#country').val('');
                phonenumber = $('#phonenumber').val('');
                mail = $('#mail').val('');
                state = $('#state').val('');
            }
        }
    });
}

function search_provider() {
    var key_word = $('#search_str').val();
    $.ajax({
        url: provider_search,
        data: {srch_key: key_word},
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            if (data.type) {
                $('#provider_table').html(data.html);
            }
            else
                 $('#provider_table').html(data.html);
        }
    });
}

function provider_form_validate() {
    var name = $('#name').val();
    var mail = $('#mail').val();
    if ($.trim(name) == '') {
        alert('Por favor ingrese el nombre del proveedor');
        $('#name').focus();
        return false;
    }
    if ($.trim(mail) == '') {
        alert('Por favor ingrese el correo electrónico');
        $('#mail').focus();
        return false;
    }


    return true;
}

$(document).ready(function() {
	$("#search_str").keydown(function (e) {
		if (e.keyCode == 13) {
			search_provider();
		}
	});
	$("#search_btn").click(search_provider);
	
});