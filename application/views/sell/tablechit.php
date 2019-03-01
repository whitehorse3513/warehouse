<?php $permission = $this->user->hasAuthority('sells');?>
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
            <td><a class="fa fa-edit" href="javascript:view_chit(<?php echo $selldata['chitNum']; ?>)">Ver</a></td>
        <?php }?>
        <?php if($permission['delete']) {?>
            <td><a class="fa fa-trash-o" href="javascript:delete_chit(<?php echo $selldata['chitNum']; ?>)">Borrar</a></td>
        <?php }?>
    </tr>
<?php }?>
</tbody>