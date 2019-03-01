$(document).ready(function() {
	var base_url = $('#baseurl').val();
	$('.date').datetimepicker({
       format: 'yyyy-mm-dd H:i:s'
     });
	$('#from_wh_list').change(function(){
		var from_u_id = $('#from_wh_list > option:selected').attr("user_id");
		$('#from_user_list').val(from_u_id);
	});
	$('#to_wh_list').change(function() {
		var to_u_id = $('#to_wh_list > option:selected').attr("user_id");
		$('#to_user_list').val(to_u_id);
	});

	$('#cancellpro').click(function() {
		$.ajax({
			url: base_url + '/transfer/cancellpro',
			dataType: 'html',
			success: function (data) {
				if (data) {
				}
			}
		});
	});
	$('#product_add').click(function() {
		if($('#from_wh_list').val()==''||$('#to_wh_list').val()=='')
		{
			alert("Por favor seleccione el Sucursal");
			return;
		}
		var from_wh_id = $('#from_wh_list').val();
		$.ajax({
			url: base_url+'/transfer/get_chit',
			data: {wh_id: from_wh_id},
			type: 'POST',
			dataType: 'html',
			success: function(option_list) {
				var product = JSON.parse(option_list);
				if (product) {
					$('#chit_list').html(product.chit_list);
					$('#chit_list').select2('val','');
					$('#pchit_list').select2('val','');
					$('#product').select2('val','');
					$('#width').val('');
					$('#height').val('');
					$('#buyprice').val('');
					$('#total_price').val('');
					$('#total_square').val('');
				}
				else {
					alert(product);
				}
			}
		});
		$('#product_add_modal').modal();
	});

	$('#chit_list').change(function() {
		var chit_id = $('#chit_list').val();
		var from_wh_id = $('#from_wh_list').val();
		$.ajax({
			url: base_url+'/transfer/get_pchit',
			data: {chit_id: chit_id, warehouse_id: from_wh_id},
			type: 'POST',
			dataType: 'html',
			success: function(option_list) {
				var product = JSON.parse(option_list);
				if (product) {
					$('#pchit_list').html(product.p_chit_list);
					$('#pchit_list').select2('val','');
				}
				else {
					alert(product);
				}
			}
		});
	});

	$('#pchit_list').change(function() {
		var pchit_id = $('#pchit_list').val();
		var chit_id = $('#chit_list').val();
		var from_wh_id = $('#from_wh_list').val();
		$.ajax({
			url: base_url+'/transfer/get_pchit_product',
			data: {pchit_id: pchit_id,chit_id:chit_id,warehouseId:from_wh_id},
			type: 'POST',
			dataType: 'html',
			success: function(option_list) {
				var product = JSON.parse(option_list);
				if (product) {
					$('#product').html(product.product_list);
					$('#product').select2('val','');
				}
				else {
					alert(product);
				}
			}
		});
	});

	$('#product').change(function() {
		var pchit_id = $('#pchit_list').val();
		var chit_id = $('#chit_list').val();
		var from_wh_id = $('#from_wh_list').val();
		var product_id = $('#product').val();
		$.ajax({
			url: base_url+'/transfer/get_info',
			data: {pro_id: product_id,pchit_id: pchit_id,chit_id:chit_id,warehouseId:from_wh_id},
			type: 'POST',
			dataType: 'html',
			success: function(option_list) {	
				var product = JSON.parse(option_list);
				if (product) {
					$('#buyprice').val(product.buyPrice);
					$("#curPro_id").val(product.curPro_id);
					$('#curPro_type').val(product.type);
					if (product.type == 1){
						$('#is_disp_width').addClass('hide-field');
						$('#width').removeAttr('disabled');
						$('#width').val(product.anchor);
						$('#maxWidth').val(product.anchor);
						$('#height').val('1');
						$('#total_price').val(product.buyPrice*product.anchor);
						$('#total_square').val(product.anchor);
					}else {
						$('#is_disp_width').removeClass('hide-field');
						$('#width').prop('disabled',true);
						$('#width').val(product.anchor);
						$('#maxWidth').val(product.anchor);
						$('#height').val(product.alto);
						$('#total_price').val(product.buyPrice*(product.anchor*product.alto));
						$('#total_square').val(product.anchor*product.alto);
					}
				}
				else {
					alert(product);
				}
			}
		});
	});

	$('#height').change(function() {
		var width = $('#width').val();
		if ($.trim(width) == '') {
			alert('Enter value of width!');
			$('#width').focus();
			return false;
		}
		var buy_p = $('#buyprice_list').val();
		var height = $('#height').val();
		var total_square = width * height;
		var total_price = buy_p * total_square;
		$('#total_price').val(total_price);
		$('#total_square').val(total_square);
	});
	$('#width').change(function() {
		var height = $('#height').val();
		if ((parseFloat($('#maxWidth').val()) < parseFloat($('#width').val()))||(parseFloat($('#maxWidth').val())==0)) {
			alert("por favor verifique el valor de la cantidad max ="+$('#maxWidth').val()+"!!!");
			$('#width').val($('#maxWidth').val());
			return false;
		}
		if ($.trim(height) == '') {
			return false;
		}
		var buy_p = $('#buyprice').val();
		var width = $('#width').val();
		var total_square = width * height;
		var total_price = buy_p * total_square;
		$('#total_price').val(total_price);
		$('#total_square').val(total_square);
	});
});

function transfer_modal() {
	var base_url = $('#baseurl').val();
	$('#added_product').html("");
	$.ajax({
		url: base_url+'/transfer/wh_list',
		dataType: 'html',
		success: function(wh_list) {
			if (wh_list) {
				$('#from_wh_list').html(wh_list);
				$('#from_wh_list').select2('val','');
				$('#to_wh_list').html(wh_list);
				$('#to_wh_list').select2('val','');
			}
		}
	});
	$.ajax({
		url: base_url+'/transfer/user_list',
		dataType: 'html',
		success: function(user_list) {
			if (user_list) {
				$('#from_user_list').html(user_list);
				$('#to_user_list').html(user_list);

				$('#from_user_list').select2('val','');
				$('#to_user_list').select2('val','');
			}
		}
	});
	$.ajax({
		url: base_url+'/transfer/get_ticket_number',
		dataType: 'json',
		success: function(number) {
			var num = JSON.parse(number)+1;
			if (num) {
				$('#ticket_number').val(num);
				$('#modal_name').text('Transferencias');
				$('#transfer_modal').modal();
			}
			else {
				alert(number);
			}
		}
	});
}

function add_product_temp() {
	if ((parseFloat($('#maxWidth').val()) < parseFloat($('#width').val()))||(parseFloat($('#maxWidth').val())==0)) {
		alert("por favor verifique el valor de la cantidad max ="+$('#maxWidth').val()+"!!!");
		$('#width').val($('#maxWidth').val());
		return false;
	}
	var base_url = $('#baseurl').val();
	//var temp_id = $('#ticket_number').val();
	var find = document.getElementById('tempchitnum');
	if(find==null)
	{
		var temp_id = 0;
	} else {
		var temp_id = $('#tempchitnum').text();
	}
	var curPro_id = $('#curPro_id').val();
	var product_id = $('#product').val();
	var buyprice   = $('#buyprice').val();
	var width = $('#width').val();
	var height = $('#height').val();
	var total_price = $('#total_price').val();
	var total_square = $('#total_square').val();
	var to_wh_id = $('#to_wh_list').val();
	var from_wh_id = $('#from_wh_list').val();
	var chitNum = $('#chit_list').val();
	var pchitNum = $('#pchit_list').val();
	var type = $('#curPro_type').val();

	$.ajax({
		url: base_url+'/transfer/add_product_temp',
		data: {temp_id: temp_id, product_id: product_id, buyprice: buyprice, width: width, height: height, total_price: total_price, total_square: total_square, to_id: to_wh_id,from_id:from_wh_id, chitNum: chitNum, pchitNum: pchitNum, type: type, curPro_id: curPro_id},
		type: 'POST',
		dataType:'html',
		success: function(html) {
			if(html) {
				$('#added_product').html(html);
				$('#product_add_modal').modal('hide');
			}
			else
				alert(msg);
		}
	});
}

function delete_transfer_info(id) {

	var base_url = $('#baseurl').val();
	$.ajax({
		url: base_url+'transfer/delete_transfer_info',
		data: {del_id: id},
		type: 'POST',
		dataType: 'html',
		success: function(msg) {
			if(msg){
				$('#transfer_table').html(msg);
			}
			else
			{
				alert(msg);
			}
		}
	});
}
function delete_product(id) {
	var base_url = $('#baseurl').val();
	var temp_id = $('#tempchitnum').text();
	$.ajax({
		url: base_url+'transfer/delete',
		data: {del_id: id,temp_id:temp_id},
		type: 'POST',
		dataType: 'html',
		success: function(msg) {
			if(msg){
				$('#added_product').html(msg);
			}
			else
			{
				alert(msg);
			}
		}
	});
}

function transfer() {

	var base_url = $('#baseurl').val();
	var temp_id = $('#tempchitnum').text();
	var t_date = $('#transfer_date').val();
	var from_wh_id = $('#from_wh_list').val();
	var from_user_id = $('#from_user_list').val();
	var company = $('#company').val();
	var tracking = $('#tracking').val();
	var to_wh_id = $('#to_wh_list').val();
	var to_user_id = $('#to_user_list').val();
	if (transfer_validation() == false) {
		return;
	}
	$.ajax({
		url: base_url+'/transfer/add_transfer',
		data: {temp_id: temp_id, trans_date: t_date, from_wh_id: from_wh_id, from_user_id: from_user_id, to_wh_id: to_wh_id, to_user_id: to_user_id,company:company,tracking:tracking},
		type: 'POST',
		dataType: 'json',
		success: function(data) {
			if (data) {
				alert("Numero guardado :" + data['msg']);
				$('#transfer_table').html(data['html']);
				$('#transfer_modal').modal('hide');
			}
			else
				alert(msg);
		}
	});
}

function view_transfer_info(id) {
	var base_url = $('#baseurl').val();
	$.ajax({
		url: base_url+'transfer/product_info',
		data: {transfer_id: id},
		type: "POST",
		dataType: "html",
		success: function(html){
			if (html) {
				$('#transfer_product_info').html(html);
				$('#view_transfer_modal').modal();
			}
			else {
				alert(html);
			}
		}
	});
}

function transfer_validation() {
	var temp_id = $('#ticket_number').val();
	var t_date = $('#transfer_date').val();
	var from_wh_id = $('#from_wh_list').val();
	var from_user_id = $('#from_user_list').val();
	var to_wh_id = $('#to_wh_list').val();
	var to_user_id = $('#to_user_list').val();
	var exist_products = $('#added_product').html();

	if ($.trim(t_date) == '') {
		alert('Por favor ingrese transfer_date');
		$('#transfer_date').focus();
		return false;
	}
	if ($.trim(from_wh_id) == '') {
		alert('Por favor ingrese desde el sucursal');
		$('#from_wh_list').focus();
		return false;
	}
	if ($.trim(from_user_id) == '') {
		alert('Por favor ingrese desde nombre de usuario');
		$('#from_user_list').focus();
		return false;
	}
	if ($.trim(to_wh_id) == '') {
		alert('Por favor ingrese al sucursal');
		$('#to_wh_list').focus();
		return false;
	}
	if ($.trim(to_user_id) == '') {
		alert('Por favor ingrese desde nombre de usuario');
		$('#to_user_list').focus();
		return false;
	}
	if ($.trim(exist_products) == '') {
		alert("¿No ha añadido productos?");
		return false;
	}

	return true;
}