function delete_customer(id) {
	$.ajax({
		url: customer_delete,
		data: {cid: id},
		type: 'POST',
		dataType: 'html',
		success: function (msg) {
			if (msg) {
				$('#tr_' + id).css('display', 'none');
				$('#success_text').text('Cliente eliminado correctamente.');
				$('#success_msg').css('display', 'block');
				$('#customer_table').html(msg);
			} else {
				$('#warning_text').text("el cliente no borró.");
				$('#warning_msg').css('display', 'block');
				$('#customer_table').html(msg);
			}
			$('#del_modal').modal('hide');
		}
	});
}

function add_customer_modal() {
	$('#modal_name').text('Añadir cliente');
	$('#customer_ctrl').attr('href', 'javascript:add_customer()');
	$('#name').val('');
	$('#street').val('');
	$('#extStreetNumber').val('');
	$('#inStreetNumber').val('');
	$('#complementary_info').val('');
	$('#city').val('');
	$('#zipcode').val('');
	$('#phonenumber').val('');
	$('#mail').val('');
	$('#state').val('');
	$('#country').select2('val',' ');
	$('#customer_modal').modal();
}

function add_customer() {
	if (customer_form_validate() != true)
		return;
	var No = 0;
	$("[id^='tr_']").each(function (index) {
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
		url: customer_add,
		data: {
			name: name,
			street: street,
			extStreetNumber: extstreetnumber,
			inStreetNumber: inStreetNumber,
			complementaryInfo: complementaryInfo,
			city: city,
			zipcode: zipcode,
			country: country,
			phonenumber: phonenumber,
			mail: mail,
			state: state,
		},
		type: 'POST',
		dataType: 'json',
		success: function (data) {
			if (data.type) {
				$('#customer_table').html(data.html);
				$('#customer_modal').modal('hide');
				$('#success_text').text('Éxito añadir cliente.');
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
			} else {
				$('#customer_modal').modal('hide');
				$('#warning_text').text("Fallo añadir cliente!");
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

function edit_customer_modal(id) {
	$('#name').val($('#tr_' + id + " td:eq(1)").text());
	$('#street').val($('#tr_' + id + " td:eq(2)").text());
	$('#extStreetNumber').val($('#tr_' + id + " td:eq(3)").text());
	$('#inStreetNumber').val($('#tr_' + id + " td:eq(4)").text());
	$('#complementary_info').val($('#tr_' + id + " td:eq(5)").text());
	$('#city').val($('#tr_' + id + " td:eq(6)").text());
	$('#zipcode').val($('#tr_' + id + " td:eq(7)").text());
	$('#country').select2('val',$('#tr_' + id + " td:eq(8)").text());
	$('#phonenumber').val($('#tr_' + id + " td:eq(10)").text());
	$('#mail').val($('#tr_' + id + " td:eq(11)").text());
	$('#state').val($('#tr_' + id + " td:eq(12)").text());
	$('#modal_name').text('customer Edit');
	$('#customer_ctrl').attr('href', 'javascript:edit_customer(' + id + ')');
	$('#customer_modal').modal();
}

function edit_customer(id) {
	if (customer_form_validate() != true)
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
		url: customer_edit,
		data: {
			cid: id,
			name: name,
			street: street,
			extStreetNumber: extStreetNumber,
			inStreetNumber: inStreetNumber,
			complementaryInfo: complementaryInfo,
			city: city,
			zipcode: zipcode,
			country: country,
			phonenumber: phonenumber,
			mail: mail,
			state: state,
		},
		type: 'POST',
		dataType: 'json',
		success: function (data) {
			if (data.type) {
				$('#customer_modal').modal('hide');
				$('#success_text').text('Cliente actualizado correctamente.');
				$('#success_msg').css('display', 'block');
				$('#customer_table').html(data.html);
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
			} else {
				$('#customer_modal').modal('hide');
				$('#warning_text').text("el cliente no actualizó.");
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

function search_customer() {
	var key_word = $('#search_str').val();
	$.ajax({
		url: customer_search,
		data: {srch_key: key_word},
		type: 'POST',
		dataType: 'json',
		success: function (data) {
			if (data) {
				$('#customer_table').html(data);
			} else
				$('#customer_table').html("");
		}
	});
}

function customer_form_validate() {
	var name = $('#name').val();
	var mail = $('#mail').val();
	if ($.trim(name) == '') {
		alert('Por favor ingrese el nombre del cliente');
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

$(document).ready(function () {
	$("#search_str").keydown(function (e) {
		if (e.keyCode == 13) {
			search_customer();
		}
	});
	$("#search_btn").click(search_customer);

});
