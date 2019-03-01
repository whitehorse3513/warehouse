<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model for managing Transfer
 */
class TransferModel extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function get_number() {
		$result = $this->db->query('SELECT * FROM transfer_cheat ORDER BY ticket_num DESC LIMIT 0, 1');
		if ($result->num_rows() == '') {
			return 0;
		}
		return $result->row();
	}

	function get_wh_list() {
		$result = $this->db->query('select w.*, uw.userId from warehouse w left join user_warehouse uw on w.id=uw.warehouseId group by w.id;');
		return $result->result_array();
	}

	function get_user_list() {
		$this->db->select('id, name');
		$result = $this->db->get('user');
		return $result->result_array();
	}

	function get_chit($id) {
		$this->db->select('*');
		$this->db->where('cp.warehouseId', $id);
		$this->db->where('cp.selled', 0);
		$this->db->group_by('chitNum');
		$result = $this->db->get('current_product as cp');
		return $result->result_array();
	}

	function get_pchit($id, $house_id) {
		$this->db->select('*');
		$this->db->where('cp.warehouseId', $house_id);
		$this->db->where('cp.chitNum', $id);
		$this->db->where('cp.selled', 0);
		$this->db->join('products as p', 'cp.productId = p.id', 'left');
		$result = $this->db->get('current_product as cp');
		return $result->result_array();
	}

	function get_product($pchit_id,$chit_id,$warehouseId) {
		$this->db->select('*,cp.productId,cp.id as curPro_id');
		$this->db->where('cp.pChitNum', $pchit_id);
		$this->db->where('cp.chitNum', $chit_id);
		$this->db->where('cp.warehouseId', $warehouseId);
		$this->db->where('cp.selled', 0);
		$this->db->join('products as p', 'cp.productId = p.id', 'left');
		$result = $this->db->get('current_product as cp');
		return $result->row();
	}
	function get_product_price($pro_id,$pchit_id,$chit_id,$warehouseId) {
		$this->db->select('*, cp.id as curPro_id');
		$this->db->where('cp.pChitNum', $pchit_id);
		$this->db->where('cp.chitNum', $chit_id);
		$this->db->where('cp.warehouseId', $warehouseId);
		$this->db->where('cp.productId', $pro_id);
		$this->db->where('cp.selled', 0);
		$this->db->join('products as p', 'cp.productId = p.id', 'left');
		$result = $this->db->get('current_product as cp');
		return $result->row();
	}

	function get_products($name) {
		$this->db->select('*');
		$this->db->where('family', $name);
		$result = $this->db->get('products');
		return $result->result_array();
	}

	function add_temp($data) {
		$id = $data['cur_id'];
		$alto   = ($data['type'] != 1) ? $data['height'] : 1;
		$cur_data = array(
			'warehouseId' => $data['warehouseId'],
			'chitNum'     => $data['chitNum'],
			'pChitNum'    => $data['pchitNum'],
			'productId'   => $data['product_id'],
			'anchor'      => $data['width'],
			'alto'        => $alto,
			'selled'      => 0 
		);
		if ($data['type'] == 1) {
			$this->db->set('anchor', 'anchor-'.$data['width'], false);
			$this->db->where('id', $id);
			$this->db->update('current_product');
			$this->db->insert('current_product', $cur_data);

            $this->db->select('id');
            $this->db->where('selled', 0);
            $this->db->where('chitNum', $data['chitNum']);
            $this->db->where('pChitNum', $data['pchitNum']);
            $this->db->where('productId', $data['product_id']);
            $this->db->where('warehouseId', $data['warehouseId']);
            $result = $this->db->get('current_product');

            $get_newID = $result->row()->id;
		}else {
		    $this->db->set('warehouseId',$data['warehouseId']);
			$this->db->where('id', $id);
			$this->db->update('current_product');
            $get_newID = $data['fromwarehouseId'];
		}

		$temp_data = array(
			'product_id'      => $data['product_id'],
			'buyPrice'        => $data['buyPrice'],
			'width'           => $data['width'],
			'height'          => $alto,
			'totalPrice'      => $data['totalPrice'],
			'totalSquare'     => $data['totalSquare'],
			'temp_id'         => $data['temp_id'],
			'cp_id_1'         => $id,
			'cp_id_2'         => $get_newID,
			'userId'         =>   $data['userId']
		);
		return $this->db->insert('transfer_product_temp', $temp_data);
	}

	function get_temp_products($temp_id) {
		// $query = "SELECT p.id as id, p.name, tpt.buyPrice, tpt.width, tpt.height, tpt.totalPrice, tpt.totalSquare, SUM(tpt.totalPrice) AS total_sum, COUNT(tpt.id) AS total_count, SUM(tpt.totalSquare) AS total_square FROM transfer_product_temp AS tpt LEFT JOIN products AS p ON (tpt.product_id = p.id) WHERE tpt.temp_id=".$temp_id;
		$this->db->select('tpt.id as id, products.name,products.type, tpt.buyPrice, tpt.width, tpt.height, tpt.totalPrice, tpt.totalSquare');
		$this->db->where('temp_id', $temp_id);
		$this->db->join('products', 'tpt.product_id = products.id', 'left');
		$result = $this->db->get('transfer_product_temp as tpt');
		return $result->result_array();
	}

	function get_product_info($temp_id) {
		// $query = "SELECT p.id as id, p.name, tp.buyPrice, tp.width, tp.height, tp.totalPrice, tp.totalSquare, SUM(tp.totalPrice) AS total_sum, COUNT(tp.id) AS total_count, SUM(tp.totalSquare) AS total_square FROM transfer_product AS tp LEFT JOIN products AS p ON (tp.product_id = p.id) WHERE tp.temp_id=".$temp_id;
		$this->db->select('tp.id as id, products.name, tp.buyPrice, tp.width, tp.height, tp.totalPrice, tp.totalSquare,products.type');
		$this->db->where('temp_id', $temp_id);
		$this->db->join('products', 'tp.product_id = products.id', 'left');
		$result = $this->db->get('transfer_product as tp');
		// $result = $this->db->query($query);
		return $result->result_array();
	}

	function del_product($del_id,$temp_id) {
		$result = $this->db->query("select products.type,a.width,a.cp_id_1,a.cp_id_2 from transfer_product_temp as a left join products on products.id = a.product_id where a.id = '".$del_id."'")->result_array();
	    if(count($result)>0){
	        if($result[0]['type']=='1')
            {
                $this->db->set('anchor','anchor+'.$result[0]['width'],false);
                $this->db->where('id',$result[0]['cp_id_1']);
                $this->db->update('current_product');

                $this->db->where('id',$result[0]['cp_id_2']);
                $this->db->delete('current_product');
            }
	        else if($result[0]['type']=='0'){
                $this->db->set('warehouseId',$result[0]['cp_id_2']);
                $this->db->where('id',$result[0]['cp_id_1']);
                $this->db->update('current_product');
            }
        }

	    $this->db->where('id',$del_id);
	    $result1 = $this->db->delete('transfer_product_temp');
	    if($result1)
        {
            $this->db->select('tpt.id as id, products.name,products.type, tpt.buyPrice, tpt.width, tpt.height, tpt.totalPrice, tpt.totalSquare');
            $this->db->where('temp_id', $temp_id);
            $this->db->join('products', 'tpt.product_id = products.id', 'left');
            $result = $this->db->get('transfer_product_temp as tpt');
            return $result->result_array();
        }

	}

	function transfer_add($new_data,$tempchitnum) {
		$this->db->insert('transfer_cheat', $new_data);
		$this->db->select('id');
		$this->db->where('ticket_num', $new_data['ticket_num']);
		$result = $this->db->get('transfer_cheat');
		$transfer_id = $result->row();
		$new_id['transfer_id'] = $transfer_id->id;
		$this->db->query("INSERT INTO transfer_product (product_id, buyPrice, width, height, totalPrice, totalSquare, temp_id,cp_id_1,cp_id_2) SELECT product_id, buyPrice, width, height, totalPrice, totalSquare,'".$new_data['ticket_num']."' as temp_id,cp_id_1,cp_id_2 FROM transfer_product_temp WHERE temp_id = '".$tempchitnum."'");
		//$this->db->where('temp_id', $new_data['ticket_num']);
		//$this->db->delete('transfer_product_temp');
        $this->db->set('userId','-1');
        $user = $this->session->userdata('user');
        $userdata = $this->db->query("select id,name,email,password from user where email = '".$user['email']."' group by email")->result_array();
        if ($user['email']=='admin'){
            $this->db->where('userId','0');
        } else if ($this->config->item('admin')['id'] != $user['email']) {
            $this->db->where('userId',$userdata[0]['id']);
        }
        $this->db->update('transfer_product_temp');

		//$this->db->where('temp_id', $new_data['ticket_num']);
		//$this->db->update('transfer_product', $new_id);

		$this->db->select('tc.id, tc.company ,tc.tracking,tc.ticket_num, transfer_date, wh_a.name as from_warehouse, us_a.name as from_user, wh_b.name as to_warehouse, us_b.name as to_user');
		$this->db->join('warehouse as wh_a', 'tc.from_wh_id = wh_a.id', 'left');
		$this->db->join('user as us_a', 'tc.from_user_id = us_a.id', 'left');
		$this->db->join('warehouse as wh_b', 'tc.to_wh_id = wh_b.id', 'left');
		$this->db->join('user as us_b', 'tc.to_user_id = us_b.id', 'left');
		$result = $this->db->get('transfer_cheat as tc');
		return $result->result_array();
	}

	function get_transfer_list() {
		$this->db->select('tc.id, tc.company ,tc.tracking, tc.ticket_num, transfer_date, wh_a.name as from_warehouse, us_a.name as from_user, wh_b.name as to_warehouse, us_b.name as to_user');
		$this->db->join('warehouse as wh_a', 'tc.from_wh_id = wh_a.id', 'left');
		$this->db->join('user as us_a', 'tc.from_user_id = us_a.id', 'left');
		$this->db->join('warehouse as wh_b', 'tc.to_wh_id = wh_b.id', 'left');
		$this->db->join('user as us_b', 'tc.to_user_id = us_b.id', 'left');
		$result = $this->db->get('transfer_cheat as tc');
		return $result->result_array();
	}
}