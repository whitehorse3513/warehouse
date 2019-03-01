<?php $permission = $this->user->hasAuthority('product'); ?>
<?php $i = 0; foreach($products as $product) {$i++; ?>
	<tr id="tr_<?php echo $product['id']; ?>">
		<td><?php echo $i; ?></td>
		<td><?php echo $product['name']; ?></td>
		<td><?php echo $product['code']; ?></td>
		<td><?php echo $product['family']; ?></td>
		<td><?php echo $product['description']; ?></td>
		<td><?php echo $product['buyPrice']; ?></td>
		<td><?php echo $product['sellPrice']; ?></td>
		<?php if(isset($permission['modify'])) {?>
		<td><a href="javascript:edit_product_modal(<?php echo $product['id']; ?>)"><i class="fa fa-edit"></i>  <?php echo $this->lang->line("edit") ?></a></td>
		<?php }?>
		<?php if(isset($permission['delete'])) {?>
		<td><a href="javascript:confirm_delete(<?php echo $product['id']; ?>)"><i class="fa fa-trash-o"></i>  <?php echo $this->lang->line("delete") ?></a></td>
		<?php }?>
	</tr>
<?php }?>