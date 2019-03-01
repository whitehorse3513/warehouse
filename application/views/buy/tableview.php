
<thead>
<tr>
    <th> # </th>
    <th> # </th>
    <th> Cantidad </th>
    <th> Producto </th>
    <th> Precio </th>
    <th> Ancho </th>
    <th> Alto </th>
    <th> M 2 </th>
    <th> -- $ -- </th>
</tr>
</thead>
<tbody>
<?php foreach($temp_product as $temp_product) {?>
    <tr >
        <td><?php echo $temp_product['chitNum']?></td>
        <td><?php echo $temp_product['id']?></td>
        <td><?php echo $temp_product['quantity']?></td>
        <td><?php echo $temp_product['pname']?></td>
        <td><?php echo $temp_product['price']?></td>
        <td><?php echo $temp_product['width']?></td>
        <td><?php echo $temp_product['height']?></td>
        <td><?php echo $temp_product['square']?></td>
        <td><?php echo $temp_product['dollar']?></td>
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
    </tr>
</tbody>