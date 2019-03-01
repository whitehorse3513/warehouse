<?php $permission = $this->user->hasAuthority('buy'); ?>
<thead>
<tr>
    <th> #</th>
    <th> Sucursal</th>
    <th> Personal</th>
    <th> Transportista</th>
    <th> Guia</th>
    <th> Forma Pago</th>
    <th> Proveeder</th>
    <th> D ate</th>
    <?php if ($permission['list']) { ?>
        <th>Ver</th>
    <?php } ?>
    <?php if ($permission['delete']) { ?>
        <th> Borrar</th>
    <?php } ?>

</tr>
</thead>
<tbody>
<?php $i = 0;
foreach ($buydata as $buydata) {
    $i++; ?>
    <tr>
        <td><?php echo $buydata['chitNum']; ?></td>
        <td><?php echo $buydata['warehouse']; ?></td>
        <td><?php echo $buydata['name']; ?></td>
        <td><?php echo $buydata['shipCmp']; ?></td>
        <td><?php echo $buydata['tracking']; ?></td>
        <td><?php echo $buydata['payWay']; ?></td>
        <td><?php echo $buydata['provider']; ?></td>
        <td><?php echo $buydata['buyDate']; ?></td>
        <?php if ($permission['list']) { ?>
            <td><a class="fa fa-edit"
                   href="javascript:view_chit(<?php echo $buydata['chitNum']; ?>)">Ver</a>
            </td>
        <?php } ?>
        <?php if ($permission['delete']) { ?>
            <td><a class="fa fa-trash-o"
                   href="javascript:delete_chit(<?php echo $buydata['chitNum']; ?>)">Borrar</a>
            </td>
        <?php } ?>
    </tr>
<?php } ?>
</tbody>