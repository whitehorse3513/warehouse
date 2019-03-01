<option value=""></option>
<?php foreach($user_list as $user) {?>
<option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
<?php }?>