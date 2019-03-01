<?php $permission = $this->user->hasAuthority('buy');?>
<thead>
<tr>
    <th> # </th>
    <th> Cantidad </th>
    <th> Producto </th>
    <th> Precio </th>
    <th> Ancho </th>
    <th> Alto </th>
    <th> M 2 </th>
    <th> -- $ -- </th>
    <?php if($permission['modify']) {?>
    <th> Editar </th>
    <?php }?>
    <?php if($permission['delete']) {?>
    <th> Borrar </th>
    <?php }?>
</tr>
</thead>
<tbody>
<?php $i = 0; foreach($temp_product as $temp_product) {$i++;?>
    <tr >
        <td><?php echo ($maxid+$i);?></td>
        <td><?php echo $temp_product['quantity']?></td>
        <td><?php echo $temp_product['pname']?></td>
        <td><?php echo $temp_product['price']?></td>
        <td><?php echo $temp_product['width']?></td>
        <td><?php echo $temp_product['height']?></td>
        <td><?php echo $temp_product['square']?></td>
        <td><?php echo $temp_product['dollar']?></td>
        <?php if($permission['modify']) {?>
            <td><a class="fa fa-edit" href="javascript:edit_tempproduct(<?php echo $temp_product['id']?>)">Editar</a></td>
        <?php }?>
        <?php if($permission['delete']) {?>
            <td><a class="fa fa-trash-o" href="javascript:delete_tempproduct(<?php echo $temp_product['id']?>)">Borrar</a></td>
        <?php }?>
    </tr>
<?php }?>
<tr>
    <td colspan="3">
        Recuento : <?php echo $buyproduct[0]['count']; ?>
    </td>
    <td colspan="3">
        Suma M2: <?php echo $buyproduct[0]['square']; ?>
    </td>

    <td colspan="3">
        Suma $: <?php echo $buyproduct[0]['dollar']; ?>
    </td>
    <td>
        <label id="tempchitnum" data-id="" style="display:none" ><?php echo $tempchitnum;?></label>
    </td>

</tr>
</tbody>

