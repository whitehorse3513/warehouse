<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Model Name: WarehouseModel;
 */
class WarehouseModel extends CI_model
{
    function __construct()
    {
        parent::__construct();

    }

    function get_warehouse_list() {
        $this->db->select('*');
        $query = $this->db->get('warehouse');
        return $query->result_array();
    }

    function warehouse_add($warehouse) {
        $this->db->select('*');
        $this->db->where('name',$warehouse['name']);
        $result=$this->db->get("warehouse");
        if ($result->num_rows()>0) {
            return false;
        }
        return $this->db->insert('warehouse', $warehouse);
    }

    function delete_warehouse($del_id) {
        $this->db->where('id', $del_id);
        return $this->db->delete('warehouse');
    }
    function warehouse_getid($getid)
    {
        $this->db->select('*');
        $this->db->where('id',$getid);
        $result = $this->db->get("warehouse");
        return $result->result_array();
    }
    function warehouse_edit($id,$editname)
    {
        $this->db->set('name',$editname);
        $this->db->where('id', $id);
        return $this->db->update('warehouse');
    }
    function get_warehousebyuserid()
    {
        $user = $this->session->userdata('user');
        $a = $this->config->item('admin')['id'] ;
        if ($this->config->item('admin')['id'] == $user['email'] ){
            $result = $this->db->query("SELECT warehouse.id,warehouse.`name` FROM warehouse");
        } else if ($this->config->item('admin')['id'] != $user['email']) {
            $result = $this->db->query("SELECT warehouse.id,warehouse.`name` FROM warehouse INNER JOIN user_warehouse ON user_warehouse.warehouseId = warehouse.id INNER JOIN `user` ON user_warehouse.userId = `user`.id WHERE user.email = '".$user['email']."'");
        }

        return $result->result_array();
    }
}