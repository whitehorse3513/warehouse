<?php 
$i = 0;

$transfer_permis = $this->user->hasAuthority('transfer');
foreach($transfer_recent as $transfer) { 
	$i++; ?>
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
<?php } ?>