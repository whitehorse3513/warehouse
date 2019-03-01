<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BuyController extends CI_Controller {

	function __construct() {
		parent::__construct();
        $this->load->model('BuyChitModel','buychit');
        $this->load->model('WarehouseModel','warehouse');
	}
	public function index()
	{
        $authority = $this->user->hasAuthority("buy");
        if($authority["total"] == false)
            return redirect("/logout");
	    $buydata = $this->buychit->get_Buy();
        $permission = $this->user->hasAuthority('buy');
        if (empty($permission))
            redirect('AuthController/');
        //$this->db->query('Truncate table buy_product_temp');

        $data = array(
            "subtitle" => "Compras",
            "description" => "Puedes registrar la compra",
            "contentview" => "/buy/buychit",
            "buydata" => $buydata,
            "permission" => $permission
        );

        $this->load->view('layout', $data);
	}
	public function buyproduct()
    {
        $warehouse = $this->warehouse->get_warehousebyuserid();
        $permission = $this->user->hasAuthority('buy');
        if (empty($permission))
             redirect('AuthController/');
        $user = $this->session->userdata('user');
        $userdata = $this->db->query("select id,name,email from user where email = '" . $user['email'] . "' group by email");
        $maxchitnum = $this->db->query("select max(chitNum)+1 as chitnum from buy_chit  ");
        if($maxchitnum->result_array()[0]['chitnum']== null)
        {
            $maxchitnum = $this->db->query("select 1 as chitnum ");
        }
        $provider = $this->db->query("select pid,name from provider ");
//        $temp_product = $this->db->query("select a.id,a.chitNum,a.price,if((products.type=1),'',a.width) as width,if((products.type=1),'',a.height) as height,if((products.type=1),a.width,1) as quantity,if((products.type=1),'',(a.width*a.height)) as square,(a.width*a.height*a.price) as dollar,products.name as pname from buy_product_temp as a  Left join products on a.productId = products.id where a.chitNum ='" . $maxchitnum->result_array()[0]['chitnum'] . "'");
//
//        $query = "Select sum(if((products.type=1),a.width,1)) as count, sum(if((products.type=1),0,(a.width*a.height))) as square,sum((a.width*a.height*a.price)) as dollar from buy_product_temp as a   Left join products on a.productId = products.id  where a.chitNum ='" .$maxchitnum->result_array()[0]['chitnum']. "'";
//        $buyproduct = $this->db->query($query);
//        $maxid = 0;
//        $buyproductId = $this->db->query("select max(id) as id from buy_product")->result_array();
//        if(count($buyproductId)>0)
//        {
//            $maxid = $buyproductId[0]['id'];
//        }
        $tempchitnum = '';
        $data = array(
            "subtitle" => "Compras",
            "description" => "Editar",
            "contentview" => "/buy/buyproduct",
            "warehouse" => $warehouse,
            "userdata" => $userdata->result_array(),
            "chitnum" => $maxchitnum->result_array(),
            "provider" => $provider->result_array(),
//            "temp_product" => $temp_product->result_array(),
//            "buyproduct" => $buyproduct->result_array(),
            "permission" => $permission,
//            "maxid" => $maxid,
            "tempchitnum" => $tempchitnum
        );
        $this->load->view('layout', $data);
    }
    public function productlist()
    {
        $productlist = $this->db->query('select id,code,name,buyprice from products');
        echo json_encode($productlist->result_array());
    }
    public function productprice()
    {
        $productprice = $this->db->query("select buyPrice,type from products where id='".$this->input->post('id')."'");
        echo json_encode($productprice->result_array());
    }
    public function productview()
    {
        $temp_product =  $this->db->query("select a.id,buy_chit.chitNum,a.price,if((products.type=1),'',a.width) as width,if((products.type=1),'',a.height) as height,if((products.type=1),a.width,1) as quantity,if((products.type=1),'',(a.width*a.height)) as square,(a.width*a.height*a.price) as dollar,products.name as pname from buy_product as a  Left join buy_chit on a.buychit_id = buy_chit.id Left join products on a.productId = products.id where a.buychit_id ='".$this->input->post('buychit_id')."'")->result_array();
        $query = "Select sum(if((products.type=1),a.width,1)) as count,sum(if((products.type=1),0,(a.width*a.height))) as square,sum((a.width*a.height*a.price)) as dollar from buy_product as a  Left join products on a.productId = products.id  where a.buychit_id ='" .$this->input->post('buychit_id'). "'";
        $buyproduct = $this->db->query($query);
        $data = array(
            "temp_product" => $temp_product,
            "buyproduct" => $buyproduct->result_array()
        );
        $this->load->view('/buy/tableview',$data);
    }

    public function productsavetemp()
    {
        $product = $this->db->query("select code,name from products where id='".$this->input->post('id')."'")->result_array();
        if(count($product)==1)
        {
            $new_product['code'] = $product[0]['code'];
            $new_product['productId'] = $this->input->post('id');
            if( $this->input->post('tempchitnum')=='')
            {
                $tempchitnum = $this->db->query('select max(chitNum)+1 as tempchitnum from buy_product_temp')->result_array();
                if($tempchitnum[0]['tempchitnum']== null)
                {
                    $tempchitnum = $this->db->query("select 1 as tempchitnum ")->result_array();
                }
                $tchitnum = $tempchitnum[0]['tempchitnum'];
            }
            else{
                $tchitnum = $this->input->post('tempchitnum');
            }
            //$new_product['chitNum'] = $this->input->post('chitnum');
            $new_product['chitNum'] = $tchitnum;
            $new_product['price'] = $this->input->post('price');
            $new_product['width'] = $this->input->post('width');
            $new_product['height'] = $this->input->post('height');
            $result = $this->db->insert('buy_product_temp',$new_product);
            if($result == true)
            {

                $temp_product =   $this->db->query("select a.id,a.chitNum,a.price,if((products.type=1),'',a.width) as width,if((products.type=1),'',a.height) as height,if((products.type=1),a.width,1) as quantity,if((products.type=1),'',(a.width*a.height)) as square,(a.width*a.height*a.price) as dollar,products.name as pname from buy_product_temp as a  Left join products on a.productId = products.id where a.chitNum ='".$tchitnum."'")->result_array();
                $query = "Select sum(if((products.type=1),a.width,1)) as count,sum(if((products.type=1),0,(a.width*a.height))) as square,sum((a.width*a.height*a.price)) as dollar from buy_product_temp as a  Left join products on a.productId = products.id  where a.chitNum ='" .$tchitnum. "'";
                $buyproduct = $this->db->query($query);

                $maxid = 0;
                $buyproductId = $this->db->query("select max(id) as id from buy_product")->result_array();
                if(count($buyproductId)>0)
                {
                    $maxid = $buyproductId[0]['id'];
                }

                $data = array(
                    "temp_product" => $temp_product,
                    "buyproduct" => $buyproduct->result_array(),
                    "maxid" => $maxid,
                    "tempchitnum" => $tchitnum
                );
                $this->load->view('/buy/table',$data);
            }
        }

    }
    public function productupdatetemp()
    {
        $product = $this->db->query("select code,name from products where id='".$this->input->post('productId')."'")->result_array();
        $update_product['code'] = $product[0]['code'];
        $update_product['productId'] = $this->input->post('productId');
        $update_product['chitNum'] = $this->input->post('tempchitnum');
        $update_product['price'] = $this->input->post('price');
        $update_product['width'] = $this->input->post('width');
        $update_product['height'] = $this->input->post('height');
        $this->db->set('code', $update_product['code']);
        $this->db->set('productId', $update_product['productId']);
        $this->db->set('chitNum', $update_product['chitNum']);
        $this->db->set('price', $update_product['price']);
        $this->db->set('width', $update_product['width']);
        $this->db->set('height', $update_product['height']);
        $this->db->where('id',$this->input->post('id'));
        $this->db->update('buy_product_temp');

        $temp_product =   $this->db->query("select a.id,a.chitNum,a.price,if((products.type=1),'',a.width) as width,if((products.type=1),'',a.height) as height,if((products.type=1),a.width,1) as quantity,if((products.type=1),'',(a.width*a.height)) as square,(a.width*a.height*a.price) as dollar,products.name as pname from buy_product_temp as a  Left join products on a.productId = products.id where a.chitNum ='".$this->input->post('tempchitnum')."'")->result_array();
        $query = "Select sum(if((products.type=1),a.width,1)) as count,sum(if((products.type=1),0,(a.width*a.height))) as square,sum((a.width*a.height*a.price)) as dollar from buy_product_temp as a  Left join products on a.productId = products.id  where a.chitNum ='" .$this->input->post('tempchitnum'). "'";
        $buyproduct = $this->db->query($query);


        $maxid = 0;
        $buyproductId = $this->db->query("select max(id) as id from buy_product")->result_array();
        if(count($buyproductId)>0)
        {
            $maxid = $buyproductId[0]['id'];
        }

        $data = array(
            "temp_product" => $temp_product,
            "buyproduct" => $buyproduct->result_array(),
            "maxid" => $maxid,
            "tempchitnum" =>$this->input->post('tempchitnum')
        );
        $this->load->view('/buy/table',$data);

    }
    public function chitsave()
    {
        $user = $this->session->userdata('user');
        $userdata = $this->db->query("select id,name,email from user where email = '".$user['email']."' group by email")->result_array();
        if ($user['email']=='admin'){
            $new_chit['userId'] = '0';
        } else if ($this->config->item('admin')['id'] != $user['email']) {
            $new_chit['userId'] = $userdata[0]['id'];
        }

        $maxchitnum = $this->db->query("select max(chitNum)+1 as chitnum from buy_chit  where warehouseId='".$this->input->post("warehouseId")."'");
        if($maxchitnum->result_array()[0]['chitnum']== null)
        {
            $maxchitnum = $this->db->query("select 1 as chitnum ");
        }
        $maxchit = $maxchitnum->result_array()[0]['chitnum'];
        $new_chit['chitNum'] = $maxchit;
        $new_chit['warehouseId'] = $this->input->post('warehouseId');
        $new_chit['shipCmp'] = $this->input->post('shipcpm');
        $new_chit['buyDate'] = $this->input->post('buydate');
        $new_chit['tracking'] = $this->input->post('tracking');
        $new_chit['payWay'] = $this->input->post('waypay');
        $new_chit['providerId'] = $this->input->post('provider');
        $result = $this->db->insert('buy_chit',$new_chit);
        if($result ==true){
            $buychit_id = $this->db->query("select id from buy_chit where chitNum='".$maxchit."' and warehouseId='".$this->input->post('warehouseId')."'")->result_array();

            $result1 = $this->db->query("insert into buy_product (select '' as id,'".$buychit_id[0]['id']."' as buychit_id,productId,code,price,width,height from buy_product_temp where chitNum =  '".$this->input->post('chitNum')."')");
            $result2 = $this->db->query("insert into current_product (select '' as id ,'".$this->input->post('warehouseId')."' as warehouseId,'".$maxchit."' as chitNum,id as pChitNum,productId,width,height,0 as selled from buy_product where buychit_id =  '".$buychit_id[0]['id']."')");
            if(($result == true) & ($result1 == true) & ($result2 == true))
            {
                $data = array(
                    'msg' => 'success',
                    'maxchit' => $maxchit
                );
                echo json_encode($data);
            }
        }
    }
    public function chitdelete()
    {
        $this->db->where('chitNum',$this->input->post('chitNum'));
        $this->db->where('warehouseId',$this->input->post('warehouseId'));
        $this->db->delete('current_product');
        $this->db->where('buychit_id',$this->input->post('id'));
        $this->db->delete('buy_product');
        $this->db->where('chitNum',$this->input->post('chitNum'));
        $this->db->where('warehouseId',$this->input->post('warehouseId'));
        $this->db->delete('buy_chit');
        return 'success';
    }
    public function tempproductdelete()
    {
        $this->db->where('id',$this->input->post('id'));
        $this->db->delete('buy_product_temp');
        $temp_product =  $this->db->query("select a.*,(a.width*a.height) as square,(a.width*a.height*a.price) as dollar,products.name as pname from buy_product_temp as a  inner join products on a.productId = products.id where a.chitNum ='".$this->input->post('chitNum')."'")->result_array();
        $query = "Select count(a.id) as count, sum((a.width*a.height)) as square,sum((a.width*a.height*a.price)) as dollar from buy_product_temp as a  where a.chitNum ='" .$this->input->post('chitNum'). "'";
        $buyproduct = $this->db->query($query);
        $data = array(
            "temp_product" => $temp_product,
            "buyproduct" => $buyproduct->result_array()
        );
        $this->load->view('/buy/table',$data);
    }
    public function chit_search()
    {
        $query = "SELECT a.id,warehouse.`name` as warehouse,If(Isnull(`user`.`name`),'admin',user.name) as name,a.shipCmp,a.tracking,a.payWay,provider.`name` as provider,a.chitNum,a.buyDate FROM buy_chit as a LEFT JOIN warehouse ON a.warehouseId = warehouse.id left JOIN `user` ON a.userId = `user`.id left JOIN provider ON a.providerId = provider.pid WHERE a.shipCmp LIKE '%".$this->input->post('search_str')."%' or a.shipCmp LIKE '%".$this->input->post('search_str')."%' or a.tracking LIKE '%".$this->input->post('search_str')."%' or a.payWay LIKE '%".$this->input->post('search_str')."%' or provider.`name` LIKE '%".$this->input->post('search_str')."%' or warehouse.`name` LIKE '%".$this->input->post('search_str')."%' or If(Isnull(`user`.`name`),'admin',user.name) like '%".$this->input->post('search_str')."%' or a.chitNum LIKE '%".$this->input->post('search_str')."%'";
        $buydata['buydata'] = $this->db->query($query)->result_array();
        $this->load->view('/buy/tablechit',$buydata);
    }
    public function tempproductlist()
    {
        $this->db->where('id',$this->input->post('id'));
        $result = $this->db->get('buy_product_temp')->result_array();
        $data = array('id'=>$result[0]['id'],'productId'=>$result[0]['productId'],'price'=>$result[0]['price'],'width'=>$result[0]['width'],'height'=>$result[0]['height']);
        echo json_encode($data);
    }
}
