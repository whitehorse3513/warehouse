<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('UserModel','user');
		$this->lang->load('auth', $this->config->item("language"));
	}
	public function index()
	{
		$this->load->view('auth/login');
		
	}
	public function login()
	{
        $this->load->view('auth/login');
	}
	
	public function register()
	{
		$this->load->view('auth/register');
	}
	
	public function logout()
	{
		$this->session->unset_userdata('user');
		redirect(base_url() . 'login', 'location');
	}

	public function login_action()
    {
        $login_user['email'] = $this->input->post('email');
        $login_user['password'] = $this->input->post('password');
		$admin = $this->config->item("admin");
		if(strtolower($login_user['email']) == strtolower($admin["id"]) &&  strtolower($login_user['password']) == strtolower($admin["password"]))
		{
			$this->session->set_userdata('user', array(
				"id" => "admin",
				"email"=> "admin"
			)); 
			$data = array('msg'=>'success');
			echo json_encode($data);
		}
		else 
		{
			$result = $this->user->login_user($login_user);
			if($result["result"] == true)
			{
				$this->session->set_userdata('user', $result["data"]);
				$data = array('msg'=>'success');
				echo json_encode($data);
			}
			else{
				$data = array('msg'=>'failed');
				echo json_encode($data);
			}
		}
    }
	
	public function user_add()
    {
        $new_user['name'] = $this->input->post('firstname').' '.$this->input->post('lastname');
        $new_user['email'] = $this->input->post('email');
        $new_user['password'] = $this->input->post('password');
        $new_user['phone'] = $this->input->post('phone');
        $new_user['country'] = $this->input->post('country');
        $new_user['city'] = $this->input->post('city');
        $new_user['street'] = $this->input->post('street');
        $new_user['exterior'] = $this->input->post('exterior');
        $new_user['interior'] = $this->input->post('interior');
        $new_user['colonia'] = $this->input->post('colonia');
        $new_user['createdAt'] = date("Y-m-d h:i:s");
        $result=$this->user->user_add($new_user);
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
