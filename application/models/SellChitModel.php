<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Model Name: WarehouseModel;
 */
class SellChitModel extends CI_model
{
    function __construct()
    {
        parent::__construct();
    }
    function get_sell()
    {
        $user = $this->session->userdata('user');
        if ($this->config->item('admin')['id']=='admin' & $this->config->item('admin')['password']=='1234'){

                $query = "SELECT sell_chit.id,sell_chit.chitNum,warehouse.`name` as warehouse,warehouse.id as warehouseId,customer.`name` as customer,sell_chit.sellDate,If(Isnull(`user`.`name`),'admin',`user`.`name`) as name,sell_chit.shipCmp,sell_chit.tracking,sell_chit.payWay,sell_chit.customerId FROM sell_chit Left JOIN warehouse ON sell_chit.warehouseId = warehouse.id LEFT JOIN customer ON sell_chit.customerId = customer.cid left JOIN `user` ON sell_chit.userId = `user`.id order by warehouse.id,sell_chit.chitNum";

        }
        else {
            $query = "SELECT sell_chit.id,sell_chit.chitNum,warehouse.`name` as warehouse,customer.`name` as customer,sell_chit.sellDate,`user`.`name`,sell_chit.shipCmp,sell_chit.tracking,sell_chit.payWay,sell_chit.customerId FROM sell_chit INNER JOIN warehouse ON sell_chit.warehouseId = warehouse.id LEFT JOIN customer ON sell_chit.customerId = customer.cid INNER JOIN `user` ON sell_chit.userId = `user`.id WHERE `user`.email = '".$user['email']."' order by warehouse.id,sell_chit.chitNum";
        }

        $result = $this->db->query($query);
        return $result->result_array();
    }

}