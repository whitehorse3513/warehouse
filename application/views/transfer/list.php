
<style type="text/css">
	.hide-field {
		display: none;
	}
</style>
<div class="alert alert-success alert-dismissible" id="success_msg" style="display: none;">
  <strong>Success!</strong> <span id="success_text"></span>
</div>
<!-- BEGIN SAMPLE TABLE PORTLET-->
<div class="portlet box">
	<div class="portlet-body">
		<?php if($transfer_permis['add']) {?>
		<div class="action">
			<a href="javascript:transfer_modal()" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> <?php echo lang('Transfer'); ?></a>
			<div style="clear: both;"></div>
		</div>
		<?php }?>
		<div class="table-scrollable" style="margin-top: 10px; overflow: auto;">
			<table class="table table-striped table-hover table-bordered">
			<thead>
			<tr>
				<th>
					 #
				</th>
				<th>
					 <?php echo lang('Ticket Number'); ?>
				</th>
				<th>
					<?php echo lang('From Warehouse_id'); ?>
				</th>
				<th>
					  <?php echo lang('From User_id'); ?>
				</th>
				<th>
					 <?php echo lang('To Warehouse_id'); ?>
				</th>
				<th>
					 <?php echo lang('To User_id'); ?>
				</th>
                <th>
					 <?php echo ('Trasnpotista'); ?>
				</th>
                <th>
					 <?php echo ('Guia'); ?>
				</th>
				<th>
					 <?php echo lang('Transfer Date'); ?>
				</th>
                <?php if($transfer_permis['list']) {?>
				<th>
					 <?php echo lang('View'); ?>
				</th>
                <?php }?>
                <?php if($transfer_permis['delete']) {?>
                <th>
                    <?php echo lang('Delete'); ?>
                </th>
                <?php }?>
			</tr>
			</thead>
			<tbody  id="transfer_table">
				<?php $i = 0; foreach($transfer_recent as $transfer) {$i++; ?>
					<tr id="tr_<?php echo $transfer['id']; ?>">
						<td><?php echo $i; ?></td>
						<td><?php echo $transfer['ticket_num']; ?></td>
						<td><?php echo $transfer['from_warehouse']; ?></td>
						<td><?php echo $transfer['from_user']; ?></td>
						<td><?php echo $transfer['to_warehouse']; ?></td>
						<td><?php echo $transfer['to_user']; ?></td>
						<td><?php echo $transfer['company']; ?></td>
						<td><?php echo $transfer['tracking']; ?></td>
						<td><?php echo $transfer['transfer_date']; ?></td>
                        <?php if($transfer_permis['list']) {?>
						<td><a href="javascript:view_transfer_info(<?php echo $transfer['ticket_num']; ?>)"><?php echo lang('View'); ?></a></td>
                        <?php }?>
                        <?php if($transfer_permis['delete']) {?>
						<td><a href="javascript:delete_transfer_info(<?php echo $transfer['id']; ?>)"><?php echo lang('Delete'); ?></a></td>
                        <?php }?>
					</tr>
				<?php }?>
			</tbody>
			</table>
		</div>
	</div>
</div>
<form class="product-form">
	<div id="transfer_modal" class="modal fade" role="dialog" data-backdrop="static">
	  	<div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
		        <div class="modal-header">
					<div class="alert alert-warning alert-dismissible" id="warning_msg" style="display: none;">
				  		<strong><?php echo lang('Warning'); ?></strong> <span id="warning_text"></span>
					</div>
		        	<button type="button" class="close" data-dismiss="modal">&times;</button>
		        	<h4 class="modal-title" id="modal_name"></h4>
		        </div>
		        <div class="modal-body">
			      	<div class="form-group col-md-6">
					    <label  style = "display: none" for="name">numero de ticket:</label>
					    <input style = "display: none" type="text" class="form-control" id="ticket_number" required readonly>
					</div>
					<div class="form-group col-md-6">
					    <label for="code"><?php echo lang('Transfer Date'); ?></label>
						<input type="text" size="16" readonly class="form-control date" id="transfer_date" data-date-format="yyyy-mm-dd">
					</div>
			        <div class="form-group col-md-6">
					    <label for="name"><?php echo lang('From Warehouse_name'); ?>:</label>
					    <select id="from_wh_list" class="form-control select2me">
					    	
					    </select>
					</div>
					<div class="form-group col-md-6">
					    <label for="code"><?php echo lang('From User_name'); ?></label>
					    <select id="from_user_list" class="form-control select2me">
					    	
					    </select>
					</div>
					<div class="form-group col-md-6">
					    <label for="category"><?php echo lang('To Warehouse_name'); ?></label>
					    <select id="to_wh_list" class="form-control select2me">
					    	
					    </select>
					</div>
					<div class="form-group col-md-6">
					    <label for="buyPrice"><?php echo lang('To User_name'); ?></label>
					    <select id="to_user_list" class="form-control select2me">
					    	
					    </select>
					</div>
					<div class="form-group col-md-6">
					    <label for="name">Transpotista:</label>
					    <input id="company" class="form-control">
					</div>
					<div class="form-group col-md-6">
					    <label for="name">Guia:</label>
					    <input id="tracking" class="form-control">
					</div>
					<a href="#" class="btn btn-primary pull-right" id="product_add" style="margin-bottom: 10px;"><?php echo lang('Add Product'); ?></a>
					<dir style="clear: both;"></dir>
					<div class="table-scrollable" style="overflow: auto;">
						<table class="table table-striped table-hover table-bordered">
						<thead>
						<tr>
							<th>#</th>
                            <th><?php echo "Cantidad"; ?></th>
							<th><?php echo lang('Name'); ?></th>
							<th><?php echo lang('BuyPrice'); ?></th>
							<th><?php echo lang('Width'); ?></th>
							<th><?php echo lang('Height'); ?></th>
							<th><?php echo lang('TotalPrice'); ?></th>
							<th><?php echo lang('TotalSquare'); ?></th>
							<th><?php echo lang('Delete'); ?></th>
						</tr>
						</thead>
						<tbody  id="added_product">
						</tbody>
						</table>
					</div>
			   </div>
		        <div class="modal-footer">
		      		<a href="javascript:transfer()" class="btn btn-primary" id="product_ctrl"><?php echo lang('OK'); ?></a>
		        	<a id ="cancellpro" type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('Close'); ?></a>
		        </div>
			</div>
	  	</div>
	</div>
</form>
<div id="product_add_modal" class="modal fade" role="dialog" data-backdrop="static">
	  	<div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
		        <div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal">&times;</button>
		        	<h4 class="modal-title" id="modal_name"><?php echo lang('Add Product'); ?></h4>
		        </div>
				<input type="hidden" id="curPro_id" value="" />
				<input type="hidden" id="curPro_type" value="" />
		        <div class="modal-body">
			      	<div class="form-group col-md-4">
					    <label for="name"><?php echo lang('Ticket Number'); ?>:</label>
					    <select id="chit_list" class="form-control select2me">
					    </select>
					</div>

					<div class="form-group col-md-4">
					    <label for="name"><?php echo lang('p_num'); ?>:</label>
					    <select id="pchit_list" class="form-control select2me">
					    	
					    </select>
					</div>
					<div class="form-group col-md-4">
					    <label for="code"><?php echo lang('Product'); ?></label>
					    <select id="product" class="form-control select2me">
					    	
					    </select>
					</div>
			        <div class="form-group col-md-6">
					    <label for="name"><?php echo lang('BuyPrice'); ?>:</label>
					    <input id="buyprice" class="form-control" disabled>
					</div>
					<div class="form-group col-md-6">
						<div class="form-group col-md-5">
					    	<label for="code"><?php echo lang('Width'); ?></label>
					    	<input type="number" class="form-control" id="width" disabled>
						</div>
                        <input type="hidden" id="maxWidth" value="" />
						<div class="form-group col-md-5"  id="is_disp_width">
					    	<label for="code"><?php echo lang('Height'); ?></label>
					    	<input type="number" class="form-control" id="height" disabled>
						</div>
					</div>
					<div class="form-group col-md-6">
					    <label for="category"><?php echo lang('TotalPrice'); ?></label>
					    <input type="text" class="form-control" id="total_price" required readonly>
					</div>
					<div class="form-group col-md-6">
					    <label for="buyPrice"><?php echo lang('TotalSquare'); ?></label>
					    <input type="text" class="form-control" id="total_square" required readonly>
					</div>
					<dir style="clear: both;"></dir>
			   </div>
		        <div class="modal-footer">
		      		<a href="javascript:add_product_temp()" class="btn btn-primary pull-right" id="product_ctrl"><?php echo lang('Add Product'); ?></a>
		        	<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right: 10px;"><?php echo lang('Close'); ?></button>
		        </div>
			</div>
	  	</div>
	</div>
<div id="view_transfer_modal" class="modal fade" role="dialog">
	  	<div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
		        <div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal">&times;</button>
		        	<h4 class="modal-title" id="modal_name"><?php echo lang('Transfer Info'); ?></h4>
		        </div>
		        <div class="modal-body">
			      	<div class="table-scrollable" style="overflow: auto;">
						<table class="table table-striped table-hover table-bordered">
						<thead>
						<tr>
							<th>#</th>
                            <th><?php echo "Cantidad"; ?></th>
							<th><?php echo lang('Name'); ?></th>
                            <th><?php echo lang('BuyPrice'); ?></th>
							<th><?php echo lang('Width'); ?></th>
							<th><?php echo lang('Height'); ?></th>
							<th><?php echo lang('TotalPrice'); ?></th>
							<th><?php echo lang('TotalSquare'); ?></th>
						</tr>
						</thead>
						<tbody  id="transfer_product_info">
						</tbody>
						</table>
					</div>
					<dir style="clear: both;"></dir>
			   </div>
		        <div class="modal-footer">
		        	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('Close'); ?></button>
		        </div>
			</div>
	  	</div>
	</div>
<script type="text/javascript" src="<?php echo base_url() ?>/public/js/transfer/transfer.js?000"></script>
<script>
function confirm_delete(id) {
	$('#product_del').attr('href','javascript:delete_product('+id+')');
	$("#del_modal").modal();
}
</script>