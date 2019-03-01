<div class="alert alert-success alert-dismissible" id="success_msg" style="display: none;">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong><?php echo $this->lang->line("success") ?></strong> <span id="success_text"></span>
</div>
<div class="alert alert-warning alert-dismissible" id="warning_msg" style="display: none;">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong><?php echo $this->lang->line("warning") ?></strong> <span id="warning_text"></span>
</div>
<!-- BEGIN SAMPLE TABLE PORTLET-->
<div class="portlet box">
	<div class="portlet-body">
		<div class="action">
		
		<?php if($authority["add"]) { ?>
			<a href="javascript:add_customer_modal()" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> <?php echo $this->lang->line("customer") ?></a>
		<?php } ?>
			<div class="search pull-right">
			</div>
			<div style="clear: both;"></div>
		</div>
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
					<?php echo $this->lang->line("street") ?>
					</th>
					<th>
					<?php echo $this->lang->line("exterior") ?>
					</th>
					<th>
					<?php echo $this->lang->line("interior") ?>
					</th>
					<th>
					<?php echo $this->lang->line("colonia") ?>
					</th>
					<th>
					<?php echo $this->lang->line("city") ?>
					</th>
					<th>
					<?php echo $this->lang->line("zipcode") ?>
					</th>
					<th style="display:none">
                        countryid
                    </th>
                    <th>
					<?php echo $this->lang->line("country") ?>
					</th>
					<th>
					<?php echo $this->lang->line("phonenumber") ?>
					</th>
					<th>
					<?php echo $this->lang->line("email") ?>
					</th>
					<th>
					<?php echo $this->lang->line("state") ?>
					</th>
					<?php if($authority["modify"]) { ?>
					<th>
					<?php echo $this->lang->line("edit") ?>
					</th>
					<?php } ?>
					<?php if($authority["delete"]) { ?>
					<th>
					<?php echo $this->lang->line("delete") ?>
					</th>
					<?php } ?>
				</tr>
				</thead>
				<tbody  id="customer_table">
				<?php $i = ($page-1) * $per_page; foreach($customer as $v) {$i++;?>
					<tr id="tr_<?php echo $v['cid']; ?>">
						<td><?php echo $i; ?></td>
						<td><?php echo $v['name']; ?></td>
						<td><?php echo $v['street']; ?></td>
						<td width="100"><?php echo $v['extStreetNumber']; ?></td>
						<td width="100"><?php echo $v['inStreetNumber']; ?></td>
						<td width="100"><?php echo $v['complementaryInfo']; ?></td>
						<td width="150"><?php echo $v['city']; ?></td>
						<td><?php echo $v['zipcode']; ?></td>
                        <td style="display:none"><?php echo $v['countryid']; ?></td>
						<td><?php echo $v['countryname']; ?></td>
						<td><?php echo $v['phoneNumber']; ?></td>
						<td><?php echo $v['mail']; ?></td>
						<td><?php echo $v['state']; ?></td>
					<?php if($authority["modify"]) { ?>
						<td><a href="javascript:edit_customer_modal(<?php echo $v['cid']; ?>)"><i class="fa fa-edit"></i> <?php echo $this->lang->line("edit") ?></a></td>
					<?php } ?>
					<?php if($authority["delete"]) { ?>
						<td><a href="javascript:confirm_delete(<?php echo $v['cid']; ?>)"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line("delete") ?></a></td>
					<?php } ?>
					</tr>
				<?php }?>
				</tbody>
			</table>
			<div style="padding-left:35%;">
				<?php
					$this->load->library('pagination');
					$config['uri_segment'] = 3;
					$config['num_links'] = 2;
					$config['use_page_numbers'] = TRUE;
					$config['page_query_string'] = TRUE;
					$config['full_tag_open'] = '<ul class="pagination">';
					$config['full_tag_close'] = '</ul>';
					$config['first_link'] = 'First';
					$config['first_tag_open'] = '<li class="prev page">';
					$config['first_tag_close'] = '</li>';
					$config['last_link'] ='last';
					$config['last_tag_open'] = '<li class="next page">';
					$config['last_tag_close'] ='</li>';
					$config['next_link'] = '&gt';
					$config['next_tag_open'] = '<li class="next page">';
					$config['next_tag_close'] = '</li>';
					$config['prev_link'] = '&lt';
					$config['prev_tag_open'] = '<li class="prev page">';
					$config['prev_tag_close'] = '</li>';
					$config['cur_tag_open'] = '<li class="active"><a href="">';
					$config['cur_tag_close'] = '</a></li>';
					$config['num_tag_open'] = '<li class="page">';
					$config['num_tag_close'] = '</li>';

					$config['base_url'] = site_url().'/customer/index';

					$config['base_url'] = site_url().'/customer_controller/index';

					$config['base_url'] = base_url().'customer';

					$config['total_rows'] = $total;
					$config['per_page'] = 10;
					$this->pagination->initialize($config);
					echo $this->pagination->create_links();
				?>
			</div>
		</div>
	</div>
</div>
<form class="vendeor-form">
	<div id="customer_modal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="modal_name"></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name">*<?php echo $this->lang->line("name") ?>:</label>
						<input type="text" class="form-control" id="name">
					</div>
					<div class="form-group">
						<label for="street"><?php echo $this->lang->line("street") ?></label>
						<input type="text" class="form-control" id="street">
					</div>
					<div class="form-group">
						<label for="extStreetNumber"><?php echo $this->lang->line("exterior") ?></label>
						<input type="text" class="form-control" id="extStreetNumber">
					</div>
					<div class="form-group">
						<label for="inStreetNumber"><?php echo $this->lang->line("interior") ?></label>
						<input type="text" class="form-control" id="inStreetNumber">
					</div>
					<div class="form-group">
						<label for="complementary_info"><?php echo $this->lang->line("colonia") ?></label>
						<input type="text" class="form-control" id="complementary_info">
					</div>
					<div class="form-group">
						<label for="city"><?php echo $this->lang->line("city") ?></label>
						<input type="text" class="form-control" id="city">
					</div>
					<div class="form-group">
						<label for="zipcode"><?php echo $this->lang->line("zipcode") ?></label>
						<input type="text" class="form-control" id="zipcode">
					</div>
                    <div class="form-group">
                        <label class="control-label" for="country"><?php echo $this->lang->line("country") ?>:</label>
                        <select class="pull-right input-xlarge select2me edited" id="country" data-placeholder="Select...">
                            <option value="" selected=""><?php echo '';?></option>
                            <?php foreach($country as $country){ ?>
                            <option value="<?php echo $country['id'];?>" ><?php echo $country['countryname'];?>
                                <?php }?>
                        </select>
                    </div>
					<div class="form-group">
						<label for="phonenumber"><?php echo $this->lang->line("phonenumber") ?></label>
						<input type="text" class="form-control" id="phonenumber">
					</div>
					<div class="form-group">
						<label for="mail">*<?php echo $this->lang->line("email") ?></label>
						<input type="text" class="form-control" id="mail">
					</div>
					<div class="form-group">
						<label for="state"><?php echo $this->lang->line("state") ?></label>
						<input type="input" class="form-control" id="state">
					</div>
				</div>
				<div class="modal-footer">
					<a href="" class="btn btn-primary" id="customer_ctrl"><?php echo $this->lang->line("save") ?></a>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("cancel") ?></button>
				</div>
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
				<a href="" class="btn btn-default" id="customer_del"><?php echo $this->lang->line("ok") ?></a>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("cancel") ?></button>
			</div>
		</div>
	</div>
</div>
<!-- END SAMPLE TABLE PORTLET-->
<script>
	function confirm_delete(id) {
		$('#customer_del').attr('href','javascript:delete_customer('+id+')');
		$("#del_modal").modal();
	}
	var customer_add = "<?php echo base_url() . 'customer/add';?>";
	var customer_edit = "<?php echo base_url() . ('customer/edit');?>";
	var customer_delete = "<?php echo base_url() . ('customer/del');?>";
	var customer_search = "<?php echo base_url() . ('customer/search');?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/customer/customer.js"></script>
