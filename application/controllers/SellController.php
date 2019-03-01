<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SellController extends CI_Controller {

	function __construct() {
		parent::__construct();
        $this->load->model('SellChitModel','sellchit');
        $this->load->model('WarehouseModel','warehouse');
	}
	public function index()
	{

	    $selldata = $this->sellchit->get_sell();
        $permission = $this->user->hasAuthority('sells');
        if($permission["total"] == false)
            return redirect("/logout");
        if (empty($permission))
            redirect('AuthController/');
        //////////////////////Roll Back Current_Product
                        $user = $this->session->userdata('user');
                        $userdata = $this->db->query("select id,name,email,password from user where email = '".$user['email']."' group by email")->result_array();
                        $result = $this->db->query("select sell_product_temp.*,products.type from sell_product_temp inner join products on sell_product_temp.productId = products.id where sell_product_temp.userId='0'");
                        $userId = '0';
                        if ($this->config->item('admin')['id'] != $user['email']) {
                            $userId = $userdata[0]['id'];
                            $result = $this->db->query("select sell_product_temp.*,products.type from sell_product_temp inner join products on sell_product_temp.productId = products.id where sell_product_temp.userId='".$userdata[0]['id']."'");
                        }

                        if($result->num_rows()>0)
                        {
                            $data = $result->result_Array();
                            for($i=0;$i<count($data);$i++)
                            {
                                if($data[$i]['type']==1)
                                {
                                    $width = $data[$i]['width'];
                                    $this->db->set('anchor','anchor+'.$width,false);
                                    $this->db->where('id',$data[$i]['cpId']);
                                    $this->db->update('current_product');
                                }
                                else if($data[$i]['type']==0)
                                {
                                    $this->db->set('selled','0');
                                    $this->db->where('id',$data[$i]['cpId']);
                                    $this->db->update('current_product');
                                }
                            }
                            $this->db->where('userId',$userId);
                            $this->db->delete('sell_product_temp');
                        }
        //////////////////////////////////////////////////////
	   // $this->db->query('Truncate table sell_product_temp');
        $data = array(
            "subtitle" => "Venta",
            "description" => "Usted puede registrar la venta",
            "contentview" => "/sell/sellchit",
            "selldata" => $selldata,
            "permission" => $permission
        );

        $this->load->view('layout', $data);
	}
    public function productview()
    {

        $temp_product =  $this->db->query("select a.id,sell_chit.chitNum,a.price,if((products.type=1),'',a.width) as width,if((products.type=1),'',a.height) as height,if((products.type=1),a.width,1) as quantity,if((products.type=1),'',(a.width*a.height)) as square,(a.width*a.height*a.price) as dollar,products.name as pname from sell_product as a  Left join sell_chit on sell_chit.id = a.sellchit_id  Left join products on a.productId = products.id where a.sellchit_id ='".$this->input->post('sellchit_id')."'")->result_array();
        $query = "Select sum(if((products.type=1),a.width,1)) as count,sum(if((products.type=1),0,(a.width*a.height))) as square,sum((a.width*a.height*a.price)) as dollar from sell_product as a  Left join products on a.productId = products.id  where a.sellchit_id ='" .$this->input->post('sellchit_id'). "'";
        $sellproduct = $this->db->query($query);


        $maxid = 0;
        $sellproductId = $this->db->query("select max(id) as id from sell_product")->result_array();
        if(count($sellproductId)>0)
        {
            $maxid = $sellproductId[0]['id'];
        }
        $data = array(
            "temp_product" => $temp_product,
            "sellproduct" => $sellproduct->result_array(),
            "maxid" => $maxid
        );
        $this->load->view('/sell/tableview',$data);
    }
	public function sellproduct()
    {
        $warehouse = $this->warehouse->get_warehousebyuserid();
        $permission = $this->user->hasAuthority('sells');
        if (empty($permission))
            redirect('AuthController/');

                        $user = $this->session->userdata('user');
                        $userdata = $this->db->query("select id,name,email,password from user where email = '".$user['email']."' group by email")->result_array();
                        $result = $this->db->query("select sell_product_temp.*,products.type from sell_product_temp inner join products on sell_product_temp.productId = products.id where sell_product_temp.userId='0'");
                        $userId = '0';
                        if ($this->config->item('admin')['id'] != $user['email']) {
                            $userId = $userdata[0]['id'];
                            $result = $this->db->query("select sell_product_temp.*,products.type from sell_product_temp inner join products on sell_product_temp.productId = products.id where sell_product_temp.userId='".$userdata[0]['id']."'");
                        }

                        if($result->num_rows()>0)
                        {
                            $data = $result->result_Array();
                            for($i=0;$i<count($data);$i++)
                            {
                                if($data[$i]['type']==1)
                                {
                                    $width = $data[$i]['width'];
                                    $this->db->set('anchor','anchor+'.$width,false);
                                    $this->db->where('id',$data[$i]['cpId']);
                                    $this->db->update('current_product');
                                }
                                else if($data[$i]['type']==0)
                                {
                                    $this->db->set('selled','0');
                                    $this->db->where('id',$data[$i]['cpId']);
                                    $this->db->update('current_product');
                                }
                            }
                            $this->db->where('userId',$userId);
                            $this->db->delete('sell_product_temp');
                        }


        $maxchitnum = $this->db->query("select max(chitNum)+1 as chitnum from sell_chit  ");
        if($maxchitnum->result_array()[0]['chitnum']== null)
        {
            $maxchitnum = $this->db->query("select 1 as chitnum ");
        }
        $customer = $this->db->query("select cid,name from customer ");
//        $temp_product = $this->db->query("select a.id,a.chitNum,a.price,if((products.type=1),'',a.width) as width,if((products.type=1),'',a.height) as height,if((products.type=1),a.width,1) as quantity,if((products.type=1),'',(a.width*a.height)) as square,(a.width*a.height*a.price) as dollar,products.name as pname from sell_product_temp as a  Left join products on a.productId = products.id where a.chitNum ='" . $maxchitnum->result_array()[0]['chitnum'] . "'");
//
//        $query = "Select sum(if((products.type=1),a.width,1)) as count, sum(if((products.type=1),0,(a.width*a.height))) as square,sum((a.width*a.height*a.price)) as dollar from sell_product_temp as a   Left join products on a.productId = products.id  where a.chitNum ='" .$maxchitnum->result_array()[0]['chitnum']. "'";
//        $sellproduct = $this->db->query($query);

//        $maxid = 0;


        $sellproductId = $this->db->query("select max(id) as id from sell_product")->result_array();
        if(count($sellproductId)>0)
        {
            $maxid = $sellproductId[0]['id'];
        }
        $data = array(
            "subtitle" => "Venta",
            "description" => "Editar",
            "contentview" => "/sell/sellproduct",
            "warehouse" => $warehouse,
            "userdata" => $userdata,
            "chitnum" => $maxchitnum->result_array(),
            "customer" => $customer->result_array(),
            //"temp_product" => $temp_product->result_array(),
            //"sellproduct" => $sellproduct->result_array(),
            "permission" => $permission,
            //"maxid" => $maxid
        );
        $this->load->view('layout', $data);
    }
    public function chitlist()
    {
        $chitlist = $this->db->query("select chitNum from current_product where warehouseId='".$this->input->post('warehouseId')."' and selled='0' group by chitNum");
        echo json_encode($chitlist->result_array());
    }
    public function allproduct()
    {
        $pchitlist = $this->db->query("select current_product.id,current_product.chitNum,current_product.pChitNum,products.code,products.id as prdouctId,products.name from current_product inner join products on products.id = current_product.productId where warehouseId='".$this->input->post('warehouseId')."'  and selled='0'");
        echo json_encode($pchitlist->result_array());
    }
    public function pchitnum()
    {
        $pchitlist = $this->db->query("select current_product.id,pChitNum,products.code,products.id as prdouctId,products.name from current_product inner join products on products.id = current_product.productId where warehouseId='".$this->input->post('warehouseId')."' and chitNum='".$this->input->post('chitNum')."' and selled='0' group by pChitNum");
        echo json_encode($pchitlist->result_array());
    }
    public function productlist()
    {
        $products = $this->db->query("select current_product.id,products.name,products.code from current_product inner join products on products.id = current_product.productId where warehouseId='".$this->input->post('warehouseId')."' and chitNum='".$this->input->post('chitNum')."' and pChitNum='".$this->input->post('pChitNum')."' and selled='0'");
        echo json_encode($products->result_array());
    }
    public function productprice()
    {
        $productinfo = $this->db->query("SELECT a.id,a.productId,a.chitNum,a.pChitNum,products.sellPrice, a.anchor,a.alto,products.type FROM current_product as a INNER JOIN products ON a.productId = products.id WHERE a.id = '".$this->input->post('id')."'");
        echo json_encode($productinfo->result_array());
    }
    public function productsavetemp()
    {
        $product = $this->db->query("select code,name from products where id='".$this->input->post('id')."'")->result_array();
        if(count($product)==1)
        {
            $this->db->set('selled','1');
            $this->db->where('warehouseId',$this->input->post('warehouseId'));
            $this->db->where('chitNum',$this->input->post('buyChitNum'));
            $this->db->where('pChitNum',$this->input->post('pChitNum'));
            $this->db->where('productId',$this->input->post('id'));
            $this->db->update('current_product');
            $result1 = true;
            $cpId = $this->input->post('cpId');
            if($this->input->post('savetype')=='1'){
                $cproduct['warehouseId'] = $this->input->post('warehouseId');
                $cproduct['productId'] = $this->input->post('id');
                $cproduct['chitNum'] = $this->input->post('buyChitNum');
                $cproduct['pChitNum'] = $this->input->post('pChitNum');
                $cproduct['anchor'] = $this->input->post('amount');
                $cproduct['alto'] = $this->input->post('height');
                $cproduct['selled'] = '0';
                $result1 = $this->db->insert('current_product',$cproduct);
                $this->db->select('id');
                $this->db->where('warehouseId',$this->input->post('warehouseId'));
                $this->db->where('chitNum',$this->input->post('buyChitNum'));
                $this->db->where('pChitNum',$this->input->post('pChitNum'));
                $this->db->where('productId',$this->input->post('id'));
                $this->db->where('selled','0');
                $resultcpId = $this->db->get('current_product')->result_array();
                $cpId = $resultcpId[0]['id'];
            }

            $new_product['code'] = $product[0]['code'];
            $new_product['productId'] = $this->input->post('id');
            if( $this->input->post('chitnum')=='')
            {
                $tempchitnum = $this->db->query('select max(chitNum)+1 as tempchitnum from sell_product_temp')->result_array();
                if($tempchitnum[0]['tempchitnum']== null)
                {
                    $tempchitnum = $this->db->query("select 1 as tempchitnum ")->result_array();
                }
                $tchitnum = $tempchitnum[0]['tempchitnum'];
            }
            else{
                $tchitnum = $this->input->post('chitnum');
            }

            $new_product['chitNum'] = $tchitnum;
            $new_product['price'] = $this->input->post('price');
            $new_product['width'] = $this->input->post('width');
            $new_product['height'] = $this->input->post('height');
            $new_product['cpId'] = $cpId;

            $user = $this->session->userdata('user');
            $userdata = $this->db->query("select id,name,email,password from user where email = '".$user['email']."' group by email")->result_array();
            if ($user['email']=='admin'){
                $new_product['userId'] = '0';
            } else if ($this->config->item('admin')['id'] != $user['email']) {
                $new_product['userId'] = $userdata[0]['id'];
            }

            $result = $this->db->insert('sell_product_temp',$new_product);
            if($result == true & $result1 == true)
            {
                $temp_product =  $this->db->query("select a.id,a.chitNum,a.price,if((products.type=1),'',a.width) as width,if((products.type=1),'',a.height) as height,if((products.type=1),a.width,1) as quantity,if((products.type=1),'',(a.width*a.height)) as square,(a.width*a.height*a.price) as dollar,products.name as pname from sell_product_temp as a  Left join products on a.productId = products.id where a.chitNum ='".$tchitnum."'")->result_array();
                $query = "Select sum(if((products.type=1),a.width,1)) as count,sum(if((products.type=1),0,(a.width*a.height))) as square,sum((a.width*a.height*a.price)) as dollar from sell_product_temp as a  Left join products on a.productId = products.id  where a.chitNum ='" .$tchitnum. "'";
                $sellproduct = $this->db->query($query);

                $maxid = 0;
                $sellproductId = $this->db->query("select max(id) as id from sell_product")->result_array();
                if(count($sellproductId)>0)
                {
                    $maxid = $sellproductId[0]['id'];
                }
                $data = array(
                    "temp_product" => $temp_product,
                    "sellproduct" => $sellproduct->result_array(),
                    "maxid" => $maxid,
                    "tempchitnum" => $tchitnum
                );
                $this->load->view('/sell/table',$data);
            }
        }

    }
//    public function productupdatetemp()
//    {
//        $product = $this->db->query("select code,name from products where id='".$this->input->post('productId')."'")->result_array();
//        $update_product['code'] = $product[0]['code'];
//        $update_product['productId'] = $this->input->post('productId');
//        $update_product['chitNum'] = $this->input->post('chitnum');
//        $update_product['price'] = $this->input->post('price');
//        $update_product['width'] = $this->input->post('width');
//        $update_product['height'] = $this->input->post('height');
//        $this->db->set('code', $update_product['code']);
//        $this->db->set('productId', $update_product['productId']);
//        $this->db->set('chitNum', $update_product['chitNum']);
//        $this->db->set('price', $update_product['price']);
//        $this->db->set('width', $update_product['width']);
//        $this->db->set('height', $update_product['height']);
//        $this->db->where('id',$this->input->post('id'));
//        $this->db->update('sell_product_temp');
//
//        $temp_product =  $this->db->query("select a.*,(a.width*a.height) as square,(a.width*a.height*a.price) as dollar,products.name as pname from sell_product_temp as a  inner join products on a.productId = products.id where a.chitNum ='".$this->input->post('chitnum')."'")->result_array();
//        $query = "Select count(a.id) as count, sum((a.width*a.height)) as square,sum((a.width*a.height*a.price)) as dollar from sell_product_temp as a  where a.chitNum ='" .$this->input->post('chitnum'). "'";
//        $sellproduct = $this->db->query($query);
//
//        $maxid = 0;
//        $sellproductId = $this->db->query("select max(id) as id from sell_product")->result_array();
//        if(count($sellproductId)>0)
//        {
//            $maxid = $sellproductId[0]['id'];
//        }
//        $data = array(
//            "temp_product" => $temp_product,
//            "sellproduct" => $sellproduct->result_array(),
//            "maxid" => $maxid
//        );
//        $this->load->view('/sell/table',$data);
//
//    }
    public function chitsave()
    {
        $user = $this->session->userdata('user');
        $userdata = $this->db->query("select id,name,email,password from user where email = '".$user['email']."' group by email")->result_array();
        if ($user['email']=='admin'){
            $new_chit['userId'] = '0';
        } else if ($this->config->item('admin')['id'] != $user['email']) {
            $new_chit['userId'] = $userdata[0]['id'];
        }

        $maxchitnum = $this->db->query("select max(chitNum)+1 as chitnum from sell_chit  where warehouseId='".$this->input->post("warehouseId")."'");
        if($maxchitnum->result_array()[0]['chitnum']== null)
        {
            $maxchitnum = $this->db->query("select 1 as chitnum ");
        }
        $maxchit = $maxchitnum->result_array()[0]['chitnum'];

        $new_chit['chitNum'] = $maxchit;
        $new_chit['warehouseId'] = $this->input->post('warehouseId');
        $new_chit['shipCmp'] = $this->input->post('shipcpm');
        $new_chit['sellDate'] = $this->input->post('selldate');
        $new_chit['tracking'] = $this->input->post('tracking');
        $new_chit['payWay'] = $this->input->post('waypay');
        $new_chit['customerId'] = $this->input->post('customer');
        $result = $this->db->insert('sell_chit',$new_chit);
        if($result ==true){
            $sellchit_id = $this->db->query("select id from sell_chit where chitNum='".$maxchit."' and warehouseId='".$this->input->post('warehouseId')."'")->result_array();
            $result1 = $this->db->query("insert into sell_product (select '' as id,'".$sellchit_id[0]['id']."' as sellchit_id,productId,code,price,width,height,cpId from sell_product_temp where chitNum =  '".$this->input->post('chitNum')."')");
            if(($result == true) & ($result1 == true))
            {

                $this->db->set('userId','-1');

                if ($user['email']=='admin'){
                  $this->db->where('userId','0');
                } else if ($this->config->item('admin')['id'] != $user['email']) {
                  $this->db->where('userId',$userdata[0]['id']);
                }
                $updateresult = $this->db->update('sell_product_temp');
                if($updateresult==true){
                    $data = array(
                        'msg' => 'success',
                        'maxchit' => $maxchit
                    );
                    echo json_encode($data);
                }
            }
        }
    }
    public function chitdelete()
    {

        $result = $this->db->query("select sell_product.*,products.type from sell_product inner join products on sell_product.productId = products.id where sell_product.sellchit_id='".$this->input->post('id')."'");

        if($result->num_rows()>0)
        {
            $data = $result->result_Array();
            for($i=0;$i<count($data);$i++)
            {
                if($data[$i]['type']==1)
                {
                    $width = $data[$i]['width'];
                    $this->db->set('anchor','anchor+'.$width,false);
                    $this->db->where('id',$data[$i]['cpId']);
                    $this->db->update('current_product');
                }
                else if($data[$i]['type']==0)
                {
                    $this->db->set('selled','0');
                    $this->db->where('id',$data[$i]['cpId']);
                    $this->db->update('current_product');
                }
            }
        }

        $this->db->where('sellchit_id',$this->input->post('id'));
        $this->db->delete('sell_product');
        $this->db->where('chitNum',$this->input->post('chitNum'));
        $this->db->where('warehouseId',$this->input->post('warehouseId'));
        $this->db->delete('sell_chit');
        return 'success';
    }
    public function tempproductdelete()
    {
        $data = $this->db->query("select cpId,products.type,width from sell_product_temp inner  join products on products.id = sell_product_temp.productId where sell_product_temp.id='".$this->input->post('id')."'")->result_array();

        if(count($data)>0) {
            if ($data[0]['type'] == 1) {
                $width = $data[0]['width'];
                $this->db->set('anchor', 'anchor+'.$width, false);
                $this->db->where('id', $data[0]['cpId']);
                $this->db->update('current_product');
            } else if ($data[0]['type'] == 0) {
                $this->db->set('selled', '0');
                $this->db->where('id', $data[0]['cpId']);
                $this->db->update('current_product');
            }
        }
        $this->db->where('id',$this->input->post('id'));
        $this->db->delete('sell_product_temp');
        $temp_product =  $this->db->query("select a.*,(a.width*a.height) as square,(a.width*a.height*a.price) as dollar,products.name as pname from sell_product_temp as a  inner join products on a.productId = products.id where a.chitNum ='".$this->input->post('chitNum')."'")->result_array();
        $query = "Select count(a.id) as count, sum((a.width*a.height)) as square,sum((a.width*a.height*a.price)) as dollar from sell_product_temp as a  where a.chitNum ='" .$this->input->post('chitNum'). "'";
        $sellproduct = $this->db->query($query);
        $data = array(
            "temp_product" => $temp_product,
            "sellproduct" => $sellproduct->result_array()
        );
        $this->load->view('/sell/table',$data);
    }
    public function chit_search()
    {
        $query = "SELECT warehouse.`name` as warehouse,If(Isnull(`user`.`name`),'admin',user.name) as name,a.shipCmp,a.tracking,a.payWay,customer.`name` as customer,a.chitNum,a.sellDate FROM sell_chit as a LEFT JOIN warehouse ON a.warehouseId = warehouse.id left JOIN `user` ON a.userId = `user`.id left JOIN customer ON a.customerId = customer.cid WHERE a.shipCmp LIKE '%".$this->input->post('search_str')."%' or a.shipCmp LIKE '%".$this->input->post('search_str')."%' or a.tracking LIKE '%".$this->input->post('search_str')."%' or a.payWay LIKE '%".$this->input->post('search_str')."%' or customer.`name` LIKE '%".$this->input->post('search_str')."%' or warehouse.`name` LIKE '%".$this->input->post('search_str')."%' or If(Isnull(`user`.`name`),'admin',user.name) like '%".$this->input->post('search_str')."%' or a.chitNum LIKE '%".$this->input->post('search_str')."%'";
        $selldata['selldata'] = $this->db->query($query)->result_array();
        $this->load->view('/sell/tablechit',$selldata);
    }
//    public function tempproductlist()
//    {
//        $this->db->where('id',$this->input->post('id'));
//        $result = $this->db->get('sell_product_temp')->result_array();
//        $data = array('id'=>$result[0]['id'],'productId'=>$result[0]['productId'],'price'=>$result[0]['price'],'width'=>$result[0]['width'],'height'=>$result[0]['height']);
//        echo json_encode($data);
//    }
//    public  function testamount()
//    {
//        $buy = $this->db->query("SELECT if(Isnull(sum(buy_product.width)),'0',sum(buy_product.width)) as quantity FROM buy_chit INNER JOIN buy_product ON buy_chit.chitNum = buy_product.chitNum WHERE buy_chit.warehouseId = '".$this->input->post('warehouseId')."' AND buy_product.productId = '".$this->input->post('productId')."' ")->result_array();
//        $sell = $this->db->query("SELECT if(Isnull(sum(sell_product.width)),'0',sum(sell_product.width)) as quantity FROM sell_chit INNER JOIN sell_product ON sell_chit.chitNum = sell_product.chitNum WHERE sell_chit.warehouseId = '".$this->input->post('warehouseId')."' AND sell_product.productId = '".$this->input->post('productId')."' ")->result_array();
//        $temp = $this->db->query("SELECT if(Isnull(sum(sell_product_temp.width)),'0',sum(sell_product_temp.width)) as quantity FROM sell_product_temp  WHERE sell_product_temp.productId = '".$this->input->post('productId')."' ")->result_array();
//        $amount = intval($buy[0]['quantity']) - intval($sell[0]['quantity']) - intval($temp[0]['quantity']);
//        $data= array("amount" => $amount);
//        echo json_encode($data);
//    }
}