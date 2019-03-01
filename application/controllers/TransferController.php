<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Controller for managing Transfer
 */
class TransferController extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('TransferModel', 'transfer');
		$this->lang->load('transfer');
	}

	public function index() {
		$recent = $this->transfer->get_transfer_list();
		$permission = $this->user->hasAuthority('transfer');
        if($permission["total"] == false)
            return redirect("/logout");
		if (empty($permission))
			redirect('AuthController/');

        $user = $this->session->userdata('user');
        $userdata = $this->db->query("select id,name,email,password from user where email = '".$user['email']."' group by email")->result_array();
        $result = $this->db->query("select transfer_product_temp.*,products.type from transfer_product_temp inner join products on transfer_product_temp.product_id = products.id where transfer_product_temp.userId='0'");
        $userId = '0';
        if ($this->config->item('admin')['id'] != $user['email']) {
            $userId = $userdata[0]['id'];
            $result = $this->db->query("select transfer_product_temp.*,products.type from transfer_product_temp inner join products on transfer_product_temp.product_id = products.id where transfer_product_temp.userId='".$userdata[0]['id']."'");
        }


        if($result->num_rows()>0)
        {
            $data = $result->result_Array();
            for($i=0;$i<count($data);$i++)
            {
                if($data[$i]['type']==1)
                {
                    $this->db->set('anchor','anchor+'.$data[$i]['width'],false);
                    $this->db->where('id',$data[$i]['cp_id_1']);
                    $this->db->update('current_product');

                    $this->db->where('id',$data[$i]['cp_id_2']);
                    $this->db->delete('current_product');
                }
                else if($data[$i]['type']==0)
                {
                    $this->db->set('warehouseId',$data[$i]['cp_id_2']);
                    $this->db->where('id',$data[$i]['cp_id_1']);
                    $this->db->update('current_product');
                }
            }
            $this->db->where('userId',$userId);
            $this->db->delete('transfer_product_temp');
        }
		$data = array(
			'subtitle'       => 'Transferencias',
			'description'    => 'Transferencias entre sucursales',
			'contentview'    => 'transfer/list',
			'transfer_recent'=> $recent,
			'transfer_permis'=> $permission
		);
		$this->load->view('layout', $data);
	}

	public function delete_transfer_info()
    {
        $del_id = $this->input->post('del_id');
        $this->db->select('ticket_num');
        $this->db->where('id',$del_id);
        $result = $this->db->get('transfer_cheat')->result_array();
        if(count($result)>0) {
            $data1 = $this->db->query("select transfer_product.*,products.type from transfer_product left join products on transfer_product.product_id = products.id where transfer_product.temp_id = '".$result[0]['ticket_num']."'");
            if($data1->num_rows()>0)
            {
                $data = $data1->result_Array();
                for($i=0;$i<count($data);$i++)
                {
                    if($data[$i]['type']==1)
                    {
                        $this->db->set('anchor','anchor+'.$data[$i]['width'],false);
                        $this->db->where('id',$data[$i]['cp_id_1']);
                        $this->db->update('current_product');

                        $this->db->where('id',$data[$i]['cp_id_2']);
                        $this->db->delete('current_product');
                    }
                    else if($data[$i]['type']==0)
                    {
                        $this->db->set('warehouseId',$data[$i]['cp_id_2']);
                        $this->db->where('id',$data[$i]['cp_id_1']);
                        $this->db->update('current_product');
                    }
                }
            }
            $this->db->where('id',$del_id);
            $this->db->delete('transfer_cheat');
            $this->db->where('temp_id',$result[0]['ticket_num']);
            $this->db->delete('transfer_product');

            $this->db->select('tc.id, tc.company ,tc.tracking,tc.ticket_num, transfer_date, wh_a.name as from_warehouse, us_a.name as from_user, wh_b.name as to_warehouse, us_b.name as to_user');
            $this->db->join('warehouse as wh_a', 'tc.from_wh_id = wh_a.id', 'left');
            $this->db->join('user as us_a', 'tc.from_user_id = us_a.id', 'left');
            $this->db->join('warehouse as wh_b', 'tc.to_wh_id = wh_b.id', 'left');
            $this->db->join('user as us_b', 'tc.to_user_id = us_b.id', 'left');
            $data['transfer_recent'] = $this->db->get('transfer_cheat as tc')->result_array();
            $html = $this->load->view('transfer/table', $data, true);
            echo $html;
        }

    }
    public function cancellpro()
    {
        $user = $this->session->userdata('user');
        $userdata = $this->db->query("select id,name,email,password from user where email = '".$user['email']."' group by email")->result_array();
        $result = $this->db->query("select transfer_product_temp.*,products.type from transfer_product_temp inner join products on transfer_product_temp.product_id = products.id where transfer_product_temp.userId='0'");
        $userId = '0';
        if ($this->config->item('admin')['id'] != $user['email']) {
            $userId = $userdata[0]['id'];
            $result = $this->db->query("select transfer_product_temp.*,products.type from transfer_product_temp inner join products on transfer_product_temp.product_id = products.id where transfer_product_temp.userId='".$userdata[0]['id']."'");
        }


        if($result->num_rows()>0)
        {
            $data = $result->result_Array();
            for($i=0;$i<count($data);$i++)
            {
                if($data[$i]['type']==1)
                {
                    $this->db->set('anchor','anchor+'.$data[$i]['width'],false);
                    $this->db->where('id',$data[$i]['cp_id_1']);
                    $this->db->update('current_product');

                    $this->db->where('id',$data[$i]['cp_id_2']);
                    $this->db->delete('current_product');
                }
                else if($data[$i]['type']==0)
                {
                    $this->db->set('warehouseId',$data[$i]['cp_id_2']);
                    $this->db->where('id',$data[$i]['cp_id_1']);
                    $this->db->update('current_product');
                }
            }
            $this->db->where('userId',$userId);
            $this->db->delete('transfer_product_temp');
        }
        return;

    }
	public function get_ticket_number() {
		$number = $this->transfer->get_number();
		if (isset($number->ticket_num)) {
			echo $number->ticket_num;
			return;
		}
		echo $number;
	}

	public function wh_list() {
		$data['wh_list'] = $this->transfer->get_wh_list();
		$html = $this->load->view('transfer/wh_option_list', $data, true);
		echo $html;
	}

	public function user_list() {
		$data['user_list'] = $this->transfer->get_user_list();
		$html = $this->load->view('transfer/user_option_list', $data, true);
		echo $html;
	}

	public function get_chit_list() {
		$wh_id = $this->input->post('wh_id');
		$data['option_list'] = $this->transfer->get_chit($wh_id);
		$option_list['chit_list'] = $this->load->view('transfer/chit_option_list', $data, true);
		echo json_encode($option_list);
	}

	public function get_pchit_list() {
		$chit_id = $this->input->post('chit_id');
		$house_id = $this->input->post('warehouse_id');
		$data['option_list'] = $this->transfer->get_pchit($chit_id, $house_id);
		$option_list['p_chit_list'] = $this->load->view('transfer/productChit_option_list', $data, true);
		echo json_encode($option_list);
	}
	public function get_pchit_product() {
		$pchit_id = $this->input->post('pchit_id');
		$chit_id = $this->input->post('chit_id');
        $warehouseId = $this->input->post('warehouseId');
		$data['option_list'] = $this->transfer->get_product($pchit_id,$chit_id,$warehouseId);
		$option_list['product_list']  = $this->load->view('transfer/product_option_list', $data, true);
		echo json_encode($option_list);
	}

	public function get_product_info() {
		$pro_id = $this->input->post('pro_id');
        $pchit_id = $this->input->post('pchit_id');
        $chit_id = $this->input->post('chit_id');
        $warehouseId = $this->input->post('warehouseId');

		$data = $this->transfer->get_product_price($pro_id,$pchit_id,$chit_id,$warehouseId);
		echo json_encode($data);
	}

	public function get_products() {
		$category_name = $this->input->post('name');
		$data['option_list'] = $this->transfer->get_products($category_name);
		$option_list['product_list']  = $this->load->view('transfer/product_option_list', $data, true);
		$option_list['buyprice_list']  = $this->load->view('transfer/buyprice_option_list', $data, true);
		echo json_encode($option_list);
	}

	public function add_product_temp() {

	    if($this->input->post('temp_id')==0)
        {
            $tempchitnum = $this->db->query('select max(temp_id)+1 as tempchitnum from transfer_product_temp')->result_array();
            if($tempchitnum[0]['tempchitnum']== null)
            {
                $tempchitnum = $this->db->query("select 1 as tempchitnum ")->result_array();
            }
            $tchitnum = $tempchitnum[0]['tempchitnum'];
        }
	    else{
            $tchitnum = $this->input->post('temp_id');
        }
		$new_data['temp_id'] = $tchitnum;
		$new_data['cur_id'] = $this->input->post('curPro_id');
		$new_data['product_id'] = $this->input->post('product_id');
		$new_data['buyPrice'] = $this->input->post('buyprice');
		$new_data['width'] = $this->input->post('width');
		$new_data['height'] = $this->input->post('height');
		$new_data['totalPrice'] = $this->input->post('total_price');
		$new_data['totalSquare'] = $this->input->post('total_square');
		$new_data['type'] = $this->input->post('type');
		$new_data['chitNum'] = $this->input->post('chitNum');
		$new_data['pchitNum'] = $this->input->post('pchitNum');
		$new_data['warehouseId'] = $this->input->post('to_id');
		$new_data['fromwarehouseId'] = $this->input->post('from_id');


        $user = $this->session->userdata('user');
        $userdata = $this->db->query("select id,name,email,password from user where email = '".$user['email']."' group by email")->result_array();
        if ($user['email']=='admin'){
            $new_data['userId'] = '0';
        } else if ($this->config->item('admin')['id'] != $user['email']) {
            $new_data['userId'] = $userdata[0]['id'];
        }


        $msg = $this->transfer->add_temp($new_data);

		if ($msg) {
			$data['temp_products'] = $this->transfer->get_temp_products($new_data['temp_id']);
			$data['view_info'] = false;
			$data['tempchitnum']= $tchitnum;
			$html = $this->load->view('transfer/added_products_list', $data, true);
			echo $html;
			return;
		}
	}

	public function delete_product() {
		$id = $this->input->post('del_id');
        $data['temp_products'] = $this->transfer->del_product($id,$this->input->post('temp_id'));
        $html = $this->load->view('transfer/added_products_list', $data, true);
        echo $html;
        return;
	}

	public function add_transfer() {


        $maxchitnum = $this->db->query("select max(ticket_num)+1 as chitnum from transfer_cheat  ");
        if($maxchitnum->result_array()[0]['chitnum']== null)
        {
            $maxchitnum = $this->db->query("select 1 as chitnum ");
        }
        $maxchit = $maxchitnum->result_array()[0]['chitnum'];
        $tempchitnum = $this->input->post('temp_id');
		$new_data['ticket_num'] = $maxchit;
		$new_data['transfer_date'] = $this->input->post('trans_date');
		$new_data['from_wh_id'] = $this->input->post('from_wh_id');
		$new_data['from_user_id'] = $this->input->post('from_user_id');
		$new_data['to_wh_id']    = $this->input->post('to_wh_id');
		$new_data['to_user_id']  = $this->input->post('to_user_id');
		$new_data['company']  = $this->input->post('company');
		$new_data['tracking']  = $this->input->post('tracking');

		$data['transfer_recent'] = $this->transfer->transfer_add($new_data,$tempchitnum);
		$html = $this->load->view('transfer/table', $data, true);
		$rdata = array(
		    'msg' => $maxchit,
            'html' => $html
        );
		echo json_encode($rdata);
		return;
	}

	public function transfer_product_info() {
		$transfer_id = $this->input->post('transfer_id');
		$data['temp_products'] = $this->transfer->get_product_info($transfer_id);
		$data['view_info'] = True;
		$html = $this->load->view('transfer/added_products_list', $data, true);
		echo $html;
		return;
	}

	public function delete_temp_product($id) {
		$id = $this->input->post('del_id');
		$msg = $this->transfer->del_temp_product($id);
		echo $msg;
		return;
	}
}