
<!-- END THEME LAYOUT SCRIPTS -->
<script>

    function view_chit(sellchit_id){
        $.ajax({
            url: $("#baseurl").val() + 'sell/productview',
            data: {'sellchit_id': sellchit_id},
            type: 'POST',
            dataType: 'html',
            success: function (data) {
                $('#productdata').html(data);
                $('#view_modal').modal();
            }
        });
    }
    $(document).ready(function() {
        $('#search_btn').click(function(){
            var str = $('#search_str').val();
            $.ajax({
                url: '<?php echo base_url() ?>sell/chit_search',
                data: {'search_str': str},
                type: 'POST',
                dataType: 'html',
                success: function(data) {
                    $('#userdata').html(data);
                }
            });
        });
    });
    function delete_chit(id,chitNum,warehouseId) {
        $('#chit_del').attr('href','javascript:chit_del('+id+','+chitNum+','+warehouseId+')');
        $("#del_modal").modal();
    }
    function chit_del(id,chitNum,warehouseId) {
        $.ajax({
            url: $("#baseurl").val() + 'sell/chitdelete',
            data: {'id': id,'chitNum': chitNum,'warehouseId': warehouseId},
            type: 'POST',
            dataType: 'json',
            success: function (msg) {
                parent.location.href = $("#baseurl").val() + 'sell';
                alert("Deleted Successfully!");
                $('#del_modal').modal('hide');
            }
        });

    }
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-body">
                    <div class="table-toolbar pull-right">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a id="addchit" href="<?php echo base_url() ?>/sell/product" class="btn blue">
                                        <i class="fa fa-plus"></i> Venta
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
					<div style="overflow: auto; width: 100%;">
                    <table class="table table-striped table-hover table-bordered" id="userdata">
                        <thead>
                        <tr>
                            <th> # </th>
                            <th> Sucursal </th>
                            <th> Personal </th>
                            <th> Transportista</th>
                            <th> Guia</th>
                            <th> Forma Pago</th>
                            <th> Clientes</th>
                            <th> Date</th>
                            <?php if($permission['list']) {?>
                            <th> Ver</th>
                            <?php }?>
                            <?php if($permission['delete']) {?>
                            <th> Borrar</th>
                            <?php }?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; foreach($selldata as $selldata) {$i++; ?>
                            <tr >
                                <td><?php echo $selldata['chitNum']; ?></td>
                                <td><?php echo $selldata['warehouse']; ?></td>
                                <td><?php echo $selldata['name']; ?></td>
                                <td><?php echo $selldata['shipCmp']; ?></td>
                                <td><?php echo $selldata['tracking']; ?></td>
                                <td><?php echo $selldata['payWay']; ?></td>
                                <td><?php echo $selldata['customer']; ?></td>
                                <td><?php echo $selldata['sellDate']; ?></td>
                                <?php if($permission['list']) {?>
                                    <td><a class="fa fa-edit" href="javascript:view_chit(<?php echo $selldata['id']; ?>)">Ver</a></td>
                                <?php }?>
                                <?php if($permission['delete']) {?>
                                    <td><a class="fa fa-trash-o" href="javascript:delete_chit(<?php echo $selldata['id']; ?>,<?php echo $selldata['chitNum']; ?>,<?php echo $selldata['warehouseId']; ?>)">Borrar</a></td>
                                <?php }?>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
					</div>
                </div>
                <div class="modal fade in" id="add_modal" tabindex="-1" aria-hidden="true" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Add new Warehouse!</h4>
                            </div>
                            <div class="modal-body">
                                <div class="content">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="reg-body">
                                                <form action="">
                                                    <div class="col-md-6">
                                                        <label for="name">Warehouse Name:</label>
                                                        <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancel</button>
                                <button type="button" id="warehouse_save" class="btn green">Create Warehouse</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bs-modal-sm in" id="del_modal" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Borrar</h4>
                            </div>
                            <div class="modal-body">
                                <p>¿Realmente quieres borrar esta ficha?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="" class="btn blue" id="chit_del">Borrar</a>
                                <button type="button" class="btn btn-green" data-dismiss="modal">Cancelar ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade in" id="edit_modal" tabindex="-1" aria-hidden="true" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Edit Warehouse!</h4>
                            </div>
                            <div class="modal-body">
                                <div class="content">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="reg-body">
                                                <form action="">
                                                    <div class="col-md-6">
                                                        <label for="name">Warehouse Name:</label>
                                                        <input type="text" class="form-control" id="editname" placeholder="Enter Name" name="editname">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancel</button>
                                <a type="button" id="warehouse_edit" class="btn green">Save Warehouse</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade in" id="view_modal" tabindex="-1" aria-hidden="true" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">Ver Productos!</h4>
                            </div>
                            <div class="modal-body">
                                <div class="content">
                                    <div class="container-fluid table-scrollable">
                                        <table class="table table-striped table-hover table-bordered" id="productdata"></table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
