<option value=""></option>
<?php foreach($wh_list as $wh) {?>
<option value="<?php echo $wh['id']; ?>" user_id="<?php echo $wh['userId']; ?>"><?php echo $wh['name']; ?></option>
<?php }?>