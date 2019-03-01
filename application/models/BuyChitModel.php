<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Model Name: WarehouseModel;
 */
class BuyChitModel extends CI_model
{
    function __construct()
    {
        parent::__construct();
    }
    function get_Buy()
    {
        $user = $this->session->userdata('user');
        if ($this->config->item('admin')['id']=='admin' & $this->config->item('admin')['password']=='1234'){

            $query = "SELECT buy_chit.id,buy_chit.chitNum,warehouse.`name` as warehouse,warehouse.id as warehouseId,provider.`name` as provider,buy_chit.buyDate,If(Isnull(`user`.`name`),'admin',`user`.`name`) as name,buy_chit.shipCmp,buy_chit.tracking,buy_chit.payWay,buy_chit.providerId FROM buy_chit Left JOIN warehouse ON buy_chit.warehouseId = warehouse.id LEFT JOIN provider ON buy_chit.providerId = provider.pid left JOIN `user` ON buy_chit.userId = `user`.id order by warehouse.id,buy_chit.chitNum,buy_chit.buyDate";

        }
        else {
            $query = "SELECT buy_chit.id,buy_chit.chitNum,warehouse.`name` as warehouse,warehouse.id as warehouseId,provider.`name` as provider,buy_chit.buyDate,`user`.`name`,buy_chit.shipCmp,buy_chit.tracking,buy_chit.payWay,buy_chit.providerId FROM buy_chit INNER JOIN warehouse ON buy_chit.warehouseId = warehouse.id LEFT JOIN provider ON buy_chit.providerId = provider.pid INNER JOIN `user` ON buy_chit.userId = `user`.id WHERE `user`.email = '".$user['email']."' order by warehouse.id,buy_chit.chitNum,buy_chit.buyDate";
        }

        $result = $this->db->query($query);
        return $result->result_array();
    }

}