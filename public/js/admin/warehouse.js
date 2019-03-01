$(document).ready(function() {
	$('#warehouse_save').click(function(){
		var name = $('#name').val();
		$.ajax({
			url: $("#baseurl").val() + 'warehouse/warehouse_add',
			data: {'name': name},
			type: 'POST',
			dataType: 'json',
			success: function(data) {
				if (data.msg=='success') {
					parent.location.href = $("#baseurl").val() + 'warehouse';
					alert("Created Successfully!");
				}
				else
				{
					alert("Existing Warehouse!");
				}
			}
		});
	});
});
function delete_warehouse(id) {
	$('#warehouse_del').attr('href','javascript:del_warehouse('+id+')');
	$("#del_modal").modal();
}

function add_warehouse(){
	$("#add_modal").modal();
}
function del_warehouse($id) {
    $.ajax({
        url: $("#baseurl").val() + 'warehouse/delete',
        data: {'del_id': $id},
        type: 'POST',
        dataType: 'json',
        success: function (msg) {
            if (msg) {
                parent.location.href = $("#baseurl").val() + 'warehouse';
                alert("Deleted Successfully!");
            } else {

            }
            $('#del_modal').modal('hide');
        }
    });
}
function edit_warehouse_modal(id)
{
    $.ajax({
        url: $("#baseurl").val() + 'warehouse/get_warehouse_id',
        data: {'id':id},
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            $('#warehouse_edit').attr('href','javascript:edit_warehouse('+id+')');
            $("#edit_modal").modal();
            $('#editname').val(data['name']);
        }
    });
}
function edit_warehouse(id) {
    var editname = $('#editname').val();
    $.ajax({
        url: $("#baseurl").val() + 'warehouse/edit',
        data: {'edit_id': id,'name':editname},
        type: 'POST',
        dataType: 'json',
        success: function (msg) {
            if (msg) {
                $('#editname').val('');
                parent.location.href = $("#baseurl").val() + 'warehouse';
            } else {
                alert("Problem happened in edit!");
            }
            $('#edit_modal').modal('hide');
        }
    });
}
