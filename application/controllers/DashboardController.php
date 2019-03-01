<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->lang->load('dashboard', $this->config->item("language"));
	}
	
	public function index()
	{
		if($this->session->userdata("user")["email"] == "")
			redirect(base_url() . 'login', 'location');
		$data = array(
			"subtitle" => "Tablero",
			"description" => "Esta página describe acerca de nuestro almacén.",
			"contentview" => "dashboard/index",
		);
		$this->load->view('layout', $data);	
	}
}
