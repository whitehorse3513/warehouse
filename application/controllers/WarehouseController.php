<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WarehouseController extends CI_Controller {


	function __construct() {
		parent::__construct();
		$this->load->model('WarehouseModel','warehouse');
		$this->load->model('UserModel','user');
		$this->lang->load('warehouse', $this->config->item("language"));
	}
	public function index()
	{
    }
	public function warehouse()
    {
		$authority = $this->user->hasAuthority("warehouse");
		if($authority["total"] !== true)
			return redirect("/logout");
        $warehouse = $this->warehouse->get_warehouse_list();
		$data = array(
			"subtitle" => "Sucursales",
			"description" => "Información total sobre nuestro sucursales.",
			"contentview" => "admin/warehouse",
			"warehouse" => $warehouse
		);
		$this->load->view('layout',$data);
    }
    public function warehouse_delete()
    {
        $p_id = $this->input->post('del_id');
        $msg = $this->warehouse->delete_warehouse($p_id);
        echo json_encode($msg);

    }
    
    public function warehouse_add()
    {
        $new_warehouse['name'] = $this->input->post('name');
        $result=$this->warehouse->warehouse_add($new_warehouse);
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
    public function warehouse_getid()
    {
        //$getid['id'] = $this->input->post('id');
        $result=$this->warehouse->warehouse_getid($this->input->post('id'));
        $data = array('name'=>$result[0]['name']);
        echo json_encode($data);
    }
    public function warehouse_edit()
    {
        $result = $this->warehouse->warehouse_edit($this->input->post('edit_id'),$this->input->post('name'));
        if($result ==  true)
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
