<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Model Name: user_model;
 */
class UserModel extends CI_model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_user_list() {
        $query = $this->db->query('select user.*,country.countryname from user left join country on country.id = user.country');
        return $query->result_array();
    }
    function login_user($user) {
        $this->db->select('*');
        $this->db->where('email', $user['email']);
        $this->db->where('password',$user['password']);
        $result = $this->db->get('user');
        if ($result->num_rows() == 1) {
            $this->db->set('lastloginAt', date("Y-m-d h:i:s"));
            $this->db->where('email', $user['email']);
            $this->db->update('user');
            return array(
				"result" => true,
				"data" => $result->result_array()[0],
			);
        }
        else
        {
            return array(
				"result" => false,
				"data" => null
			);
        }
    }
	
	function hasAuthority($subpage)
	{
		$userInfo = $this->session->userdata("user");
		$authority = array(
			"total" => false,
			"add" => false,
			"delete" => false,
			"modify" => false,
			"list" => false,
		);
		if($userInfo["email"] != "")
		{
			if($userInfo["email"] == $this->config->item("admin")["id"])
			{
				return array(
					"total" => true,
					"add" => true,
					"delete" => true,
					"modify" => true,
					"list" => true,
				);
			}
			else 
			{
				$this->db->select('*');
				$this->db->where('userid', $userInfo['id']);
				$authDB = $this->db->get('user_authority');
				$authDB = $authDB->result_array();
				if(count($authDB) > 0) 
				{
					$auth = 0;
					if($subpage == "seller")
					{
						$auth = (int)$authDB[0]["sellerAuthority"];
					}
					else if($subpage == "provider")
					{
						$auth = (int)$authDB[0]["providerAuthority"];
					}
					else if($subpage == "customer")
					{
						$auth = (int)$authDB[0]["customerAuthority"];
					}
					else if($subpage == "product")
					{
						$auth = (int)$authDB[0]["productAuthority"];
					}
					else if($subpage == "sells")
					{
						$auth = (int)$authDB[0]["sellsAuthority"];
					}
					else if($subpage == "buy")
					{
						$auth = (int)$authDB[0]["buyAuthority"];
					}
					else if($subpage == "transfer")
					{
						$auth = (int)$authDB[0]["transferAuthority"];
					}
						
					return array(
						"total" => $auth > 0,
						"add" => ($auth & 8) > 0,
						"delete" => ($auth & 4) > 0,
						"modify" => ($auth & 2) > 0,
						"list" => ($auth & 1) > 0,
					);
				}
				else
				{
					return $authority;
				}
			}
		}
		else
		{
			return $authority;
		}
	}
	
	function get_searchlist($str)
	{
		$this->db->like('name',$str);
		$this->db->or_like('email',$str);
		$this->db->or_like('country',$str);
		$this->db->or_like('createdAt',$str);
		$result = $this->db->get('user');
		return $result->result_array();
	}
	
    function user_add($user) {
        $this->db->select('*');
        $this->db->where('name',$user['name']);
        $this->db->where('email',$user['email']);
        $result=$this->db->get("user");
        if ($result->num_rows()>0) {
            return false;
        }
        return $this->db->insert('user', $user);
    }

    function user_getid($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('user');
        return $query->result_array();
    }

    function delete_user($del_id) {
        $this->db->where('id', $del_id);
        return $this->db->delete('user');
    }
}