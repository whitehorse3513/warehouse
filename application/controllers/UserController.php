<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('UserModel','user');
		$this->load->model('WarehouseModel','warehouse');
		$this->load->model('UserAuthorityModel','userAuthority');
		$this->load->model('UserWarehouseModel','userWarehouse');
		$this->lang->load('user', $this->config->item("language"));
	}
	public function index()
	{

    }
	public function usermanage()
    {
        $authority = $this->user->hasAuthority("user");
        if($authority["total"] == false)
            return redirect("/logout");
        $user = $this->user->get_user_list();
        $permission = $this->user->hasAuthority('user');
        $country = $this->db->query("select * from country");
        if (empty($permission))
            redirect('AuthController/');
		$data = array(
			"subtitle" => "Control de usuario",
			"description" => "En esta página, puede agregar, eliminar y modificar los detalles de los usuarios.",
			"contentview" => "admin/usermanage",
			"user" => $user,
            "country" => $country->result_array()
		);
		$this->load->view('layout', $data);
    }   
    public function user_delete()
    {
        $p_id = $this->input->post('del_id');
        $msg = $this->user->delete_user($p_id);
        echo json_encode($msg);
    }
    
	public function updateuser()
    {
        $result = $this->db->query("select * from user where id !='".$this->input->post('usernum')."' and email = '".$this->input->post('email')."'");
        if($result->num_rows()>0)
        {
            $data = array('msg' => 'failed');
            echo json_encode($data);
        }
        else {
            $this->db->set('name', $this->input->post('name'));
            $this->db->set('email', $this->input->post('email'));
            $this->db->set('password', $this->input->post('password'));
            $this->db->set('phone', $this->input->post('phone'));
            $this->db->set('country', $this->input->post('country'));
            $this->db->set('city', $this->input->post('city'));
            $this->db->set('street', $this->input->post('street'));
            $this->db->set('exterior', $this->input->post('exterior'));
            $this->db->set('interior', $this->input->post('interior'));
            $this->db->set('colonia', $this->input->post('colonia'));
            $this->db->where('id', $this->input->post('usernum'));
            $result =  $this->db->update('user');
            if($result == true) {
                $data = array('msg' => 'success');
                echo json_encode($data);
            }
        }
    }
	public function userpermision()
	{
		$userdata= $this->user->user_getid($this->input->get('id'));
		$warehouse = $this->warehouse->get_warehouse_list();
		$warehousecheck = $this->userWarehouse->get_warehouse_checkedlist($this->input->get('id'));
		$userAuthority = $this->userAuthority->get_userAuthority($this->input->get('id'));
        $country = $this->db->query("select * from country")->result_array();
		$data = array(
			"subtitle" => "Control de usuario",
			"description" => "Información total sobre nuestra usermanage.",
			"contentview" => "admin/userpermision",
			"userdata" => $userdata,
			"warehouse" => $warehouse,
			"warehousecheck" => $warehousecheck,
			"userAuthority" => $userAuthority,
            "country" => $country
		);
		$this->load->view('layout',$data);
	}
	
	public function usersearch()
	{
		$user['user'] = $this->user->get_searchlist($this->input->post('search_str'));
		$this->load->view('/admin/table',$user);
	}
	
	public function user_authoritycheck()
	{
		$result = $this->userAuthority->set_userAuthority($this->input->post('id'),$this->input->post('state'),$this->input->post('usernum'),$this->input->post('value'));
		if($result == true)
        {
            $data = array('msg'=>'success');
            echo json_encode($data);
        }
        else {
            $data = array('msg' => 'failed');
            echo json_encode($data);
        }
	}
	public function user_warehousecheck()
	{
		$result = $this->userWarehouse->setWarehouse($this->input->post('id'),$this->input->post('state'),$this->input->post('usernum'));
		if($result == true)
        {
            $data = array('msg'=>'success');
            echo json_encode($data);
        }
        else {
            $data = array('msg' => 'failed');
            echo json_encode($data);
        }
	}
	
}
