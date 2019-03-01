<?php $permission = $this->user->hasAuthority('product'); ?>
<div class="alert alert-success alert-dismissible" id="success_msg" style="display: none;">
  <strong><?php echo $this->lang->line("success") ?></strong> <span id="success_text"></span>
</div>
<!-- BEGIN SAMPLE TABLE PORTLET-->
<div class="portlet box">
	<div class="portlet-body">
		<?php if($product_permis['add']) {?>
		<div class="action">
			<a href="javascript:add_product_modal()" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> <?php echo $this->lang->line("product") ?></a>
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
					 <?php echo $this->lang->line("name") ?>
				</th>
				<th>
					<?php echo $this->lang->line("code") ?>
				</th>
				<th>
					<?php echo $this->lang->line("category") ?>
				</th>
				<th>
					 <?php echo $this->lang->line("description") ?>
				</th>
				<th>
					 <?php echo $this->lang->line("buyprice") ?>
				</th>
				<th>
					 <?php echo $this->lang->line("sellprice") ?>
				</th>
                <th style = "display:none">
                    <?php echo $this->lang->line("sellprice") ?>
                </th>
				<?php if(isset($product_permis['modify'])) {?>
				<th>
					 <?php echo $this->lang->line("edit") ?>
				</th>
				<?php }?>
				<?php if(isset($product_permis['delete'])) {?>
				<th>
					 <?php echo $this->lang->line("delete") ?>
				</th>
				<?php }?>
				
			</tr>
			</thead>
			<tbody  id="product_table">
				<?php $i = 0; foreach($products as $product) {$i++; ?>
					<tr id="tr_<?php echo $product['id']; ?>">
						<td><?php echo $i; ?></td>
						<td><?php echo $product['name']; ?></td>
						<td><?php echo $product['code']; ?></td>
						<td><?php echo $product['family']; ?></td>
						<td><?php echo $product['description']; ?></td>
						<td><?php echo $product['buyPrice']; ?></td>
						<td><?php echo $product['sellPrice']; ?></td>
						<td style = "display:none"><?php echo $product['type']; ?></td>
						<?php if(isset($product_permis['modify'])) {?>
						<td><a href="javascript:edit_product_modal(<?php echo $product['id']; ?>)"><i class="fa fa-edit"></i> <?php echo $this->lang->line("edit") ?></a></td>
						<?php }?>
						<?php if(isset($product_permis['delete'])) {?>
						<td><a href="javascript:confirm_delete(<?php echo $product['id']; ?>)"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line("delete") ?></a></td>
						<?php }?>
					</tr>
				<?php }?>
			</tbody>
			</table>
		</div>
	</div>
</div>
<form class="product-form">
	<div id="product_modal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
			<div class="alert alert-warning alert-dismissible" id="warning_msg" style="display: none;">
			  <strong><?php echo $this->lang->line("warning") ?></strong> <span id="warning_text"></span>
			</div>
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title" id="modal_name"></h4>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
			    <label for="name">*<?php echo $this->lang->line("name") ?></label>
			    <input type="text" class="form-control" id="name" required>
			</div>
			<div class="form-group">
			    <label for="code">*<?php echo $this->lang->line("code") ?></label>
			    <input type="text" class="form-control" id="code" required>
			</div>
			<div class="form-group">
			    <label for="category">*<?php echo $this->lang->line("category") ?></label>
			    <input type="text" class="form-control" id="category" required>
			</div>
			<div class="form-group">
			    <label for="buyPrice">*<?php echo $this->lang->line("buyprice") ?></label>
			    <input type="number" class="form-control" id="buyPrice" required>
			</div>
			<div class="form-group">
			    <label for="sellPrice">*<?php echo $this->lang->line("sellprice") ?></label>
			    <input type="number" class="form-control" id="sellPrice" required>
			</div>
			<div class="form-group">
			    <label for="description"><?php echo $this->lang->line("description") ?></label>
			    <textarea type="text" class="form-control" id="description"></textarea>
			</div>
              <div class="form-group">
                  <div class="input-group">
                      <div class="icheck-inline">
                          <label for="type1">
                              <input type="radio" name="type" id="type1" checked class="icheck"> Piece </label>
                          <label for="type2">
                              <input type="radio" name="type" id="type2"  class="icheck"> Cantidad  </label>
                      </div>
                  </div>
              </div>
	      </div>
	      <?php if($product_permis['add']) {?>
	      <div class="modal-footer">
	      	<a href="" class="btn btn-primary" id="product_ctrl"></a>
	        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("cancel") ?></button>
	      </div>
	  	  <?php }?>
	    </div>

	  </div>
	</div>
</form>
<div class="modal fade" id="del_modal" role="dialog">
<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title"><?php echo $this->lang->line("question") ?></h4>
    </div>
    <div class="modal-body">
      <p><?php echo $this->lang->line("delete_question") ?></p>
    </div>
    <div class="modal-footer">
    	<a href="" class="btn btn-primary" id="product_del">OK</a>
      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("cancel") ?></button>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo base_url() ?>/public/js/product/product.js"></script>
<script>
function confirm_delete(id) {
	$('#product_del').attr('href','javascript:delete_product('+id+')');
	$("#del_modal").modal();
}
</script>