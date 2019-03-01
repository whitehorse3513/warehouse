<?php $total_count = 0; $total_sum = 0; $total_square = 0; ?>
<?php $i = 0; foreach($temp_products as $product) {$i++; ?>
	<tr id="tr_<?php echo $product['id']; ?>">
		<td><?php echo $i; ?></td>
        <td><?php if($product['type']==1){echo ($product['width']);} else {echo '1';} ?></td>
		<td><?php echo $product['name']; ?></td>
		<td><?php echo $product['buyPrice']; ?></td>
        <td><?php if($product['type']==0){echo ($product['width']);} else {echo '';} ?></td>
        <td><?php if($product['type']==0){echo ($product['height']);} else {echo '';} ?></td>
		<td><?php echo $product['totalPrice']; ?></td>
		<td><?php if($product['type']==0){echo ($product['totalSquare']);} else {echo '';} ?></td>
		<?php if($view_info == false) {?>
		<td><a href="javascript:delete_product(<?php echo $product['id']; ?>)">Delete</a></td>
		<?php }?>
	</tr>

<?php if($product['type']==1){$total_count += $product['width'];} else {$total_count += 1;}
$total_sum += $product['totalPrice'];
if($product['type']==0){$total_square += $product['totalSquare'];} }?>
	<tr>
		<td colspan="2">Pieces <?php echo $total_count; ?></td>
        <td colspan="3">Cuadrado total: <?php echo $total_square; ?></td>
		<td>Precio total: </td>
		<td><?php echo $total_sum; ?></td>
        <td>
            <label id="tempchitnum" data-id="" style="display:none" ><?php echo $tempchitnum;?></label>
        </td>
	</tr>