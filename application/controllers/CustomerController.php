
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CustomerController extends CI_Controller {
    function __construct(){
        parent::__construct();
        // Your own constructor code
        $this->load->model('CustomerModel', 'customer');
		$this->lang->load('customer', $this->config->item("language"));
    }
    public function index() {
        $authority = $this->user->hasAuthority("customer");
        if($authority["total"] == false)
            return redirect("/logout");
        $page_no = isset($_GET['per_page']) ? $_GET['per_page'] : 1;
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

        $per_page = 10;
        if($keyword){
            ///$session = array('key' => $keyword);
            $result['total'] = $this->customer->record_keyword_count($keyword);
            $result['customer'] = $this->customer->get_keyword_result($keyword);

        }
        $offset = ($page_no - 1) * $per_page;

        $result['total'] = $this->customer->record_count();
        $result['customer'] = $this->customer->get_customer_list($offset, $per_page, $keyword);
        $result['page'] = $page_no;
        $result['per_page'] = $per_page;

        $country = $this->db->query("select * from country");
		$data = array(
			"subtitle" => "Clientes",
			"description" => "Gestión de clientes",
			"contentview" => "customer/customer",
			'total' => $this->customer->record_count(),
			'customer' => $this->customer->get_customer_list($offset, $per_page, $keyword),
			'page' => $page_no,
            'per_page' => $per_page,
            'authority' => $this->user->hasAuthority("customer"),
            'country' => $country->result_array()
		);
		
		$this->load->view('layout', $data);
    }

    public function customer_attach() {
        $footer_data = array(
            'js' => array(
                'public/vender/vender_register.js',
            ),
        );
        $this->load->view('include/admin_header');
        $this->load->view('customer/customer_register');
        $this->load->view('include/admin_footer', $footer_data);
    }

    public function register() {
        $data = array(
            'name' => $this->input->post('name'),
            'street' => $this->input->post('street'),
            'extStreetNumber' => $this->input->post('extStreetNumber'),
            'inStreetNumber' => $this->input->post('inStreetNumber'),
            'complementaryInfo' => $this->input->post('comp_info'),
            'city' => $this->input->post('city'),
            'state' => $this->input->post('state'),
            'zipcode' => $this->input->post('zip_code'),
            'country' => $this->input->post('country'),
            'phoneNumber' => $this->input->post('phone_number'),
            'mail' => $this->input->post('mail'),
        );
        $this->db->insert('customer', $data);

        echo 'ok';
    }
    //required|min_length[8]|max_length[16]'
    var $form_config = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required'
        )
      );

    public function add_customer() {
        $authority = $this->user->hasAuthority("customer");

        $this->form_validation->set_rules($this->form_config);
        if ($this->form_validation->run() != FALSE) {
            $new_customer['name'] = $this->input->post('name');
            $new_customer['street'] = $this->input->post('street');
            $new_customer['extStreetNumber'] = $this->input->post('extStreetNumber');
            $new_customer['inStreetNumber'] = $this->input->post('inStreetNumber');
            $new_customer['complementaryInfo'] = $this->input->post('complementaryInfo');
            $new_customer['city'] = $this->input->post('city');
            $new_customer['state'] = $this->input->post('state');
            $new_customer['zipcode'] = $this->input->post('zipcode');
            $new_customer['country'] = $this->input->post('country');
            $new_customer['phoneNumber'] = $this->input->post('phonenumber');
            $new_customer['mail'] = $this->input->post('mail');
            $msg = $this->customer->customer_add($new_customer);
            $html = '';
            if ($msg) {
                $i = 0;
                $customer = $this->customer->get_list();
                foreach($customer as $v) {
                    $i++;
                    $html .= "<tr id='tr_".$v['cid']."'>";
                    $html .= "<td>".$i."</td>";
                    $html .= "<td>".$v['name']."</td>";
                    $html .= "<td>".$v['street']."</td>";
                    $html .= "<td>".$v['extStreetNumber']."</td>";
                    $html .= "<td>".$v['inStreetNumber']."</td>";
                    $html .= "<td>".$v['complementaryInfo']."</td>";
                    $html .= "<td>".$v['city']."</td>";
                    $html .= "<td>".$v['zipcode']."</td>";
                    $html .= "<td style='display:none'>".$v['countryid']."</td>";
                    $html .= "<td>".$v['countryname']."</td>";
                    $html .= "<td>".$v['phoneNumber']."</td>";
                    $html .= "<td>".$v['mail']."</td>";
                    $html .= "<td>".$v['state']."</td>";
                    if($authority["modify"])
                        $html .= "<td><a href='javascript:edit_customer_modal(".$v['cid'].")'><i class=\"fa fa-edit\"></i> " . lang("edit") . "</a></td>";
                    if($authority["delete"])
                        $html .= "<td><a href='javascript:confirm_delete(".$v['cid'].")'><i class=\"fa fa-trash-o\"></i>" . lang("delete") . "</a></td>";
                }
            }
            $data = array(
                'type' => $msg,
                'html' => $html,
            );
            echo json_encode($data);
        }
    }
    public function edit_customer() {
        $authority = $this->user->hasAuthority("customer");
        $this->form_validation->set_rules($this->form_config);
        if ($this->form_validation->run() != FALSE) {
            $cid = $this->input->post('cid');
            $customer['name'] = $this->input->post('name');
            $customer['street'] = $this->input->post('street');
            $customer['extStreetNumber'] = $this->input->post('extStreetNumber');
            $customer['inStreetNumber'] = $this->input->post('inStreetNumber');
            $customer['complementaryInfo'] = $this->input->post('complementaryInfo');
            $customer['city'] = $this->input->post('city');
            $customer['state'] = $this->input->post('state');
            $customer['zipcode'] = $this->input->post('zipcode');
            $customer['country'] = $this->input->post('country');
            $customer['phoneNumber'] = $this->input->post('phonenumber');
            $customer['mail'] = $this->input->post('mail');
            $html = '';
            $msg = $this->customer->customer_edit($cid, $customer);
            $customer = $this->customer->get_list();
            if ($msg) {
                $i = 0;
                foreach($customer as $v) {
                    $i++;
                    $html .="<tr id='tr_".$v['cid']."'>";
                    $html .="<td>".$i."</td>";
                    $html .= "<td>".$v['name']."</td>";
                    $html .= "<td>".$v['street']."</td>";
                    $html .= "<td>".$v['extStreetNumber']."</td>";
                    $html .= "<td>".$v['inStreetNumber']."</td>";
                    $html .= "<td>".$v['complementaryInfo']."</td>";
                    $html .= "<td>".$v['city']."</td>";
                    $html .= "<td>".$v['zipcode']."</td>";
                    $html .="<td style='display:none'>".$v['countryid']."</td>";
                    $html .= "<td>".$v['countryname']."</td>";
                    $html .= "<td>".$v['phoneNumber']."</td>";
                    $html .= "<td>".$v['mail']."</td>";
                    $html .= "<td>".$v['state']."</td>";
                    if($authority["modify"])
                        $html .= "<td><a href='javascript:edit_customer_modal(".$v['cid'].")'><i class=\"fa fa-edit\"></i> " . lang("edit") . "</a></td>";
                    if($authority["delete"])
                        $html .= "<td><a href='javascript:confirm_delete(".$v['cid'].")'><i class=\"fa fa-trash-o\"></i>" . lang("delete") . "</a></td>";
                    $html .= '</tr>';
                }
            }
            $data = array(
                'type' => $msg,
                'html' => $html,
            );
            echo json_encode($data);
        }
    }
    public function customer_search() {
        $authority = $this->user->hasAuthority("customer");
        $key = $this->input->post('srch_key');
        $res = $this->customer->search_result($key);
        $i = 0;
        $html = '';
        foreach($res as $v) {
            $i++;
            $html .="<tr id='tr_".$v['cid']."'>";
            $html .="<td>".$i."</td>";
            $html .= "<td>".$v['name']."</td>";
            $html .= "<td>".$v['street']."</td>";
            $html .= "<td>".$v['extStreetNumber']."</td>";
            $html .= "<td>".$v['inStreetNumber']."</td>";
            $html .= "<td>".$v['complementaryInfo']."</td>";
            $html .= "<td>".$v['city']."</td>";
            $html .= "<td>".$v['zipcode']."</td>";
            $html .= "<td>".$v['country']."</td>";
            $html .= "<td>".$v['phoneNumber']."</td>";
            $html .= "<td>".$v['mail']."</td>";
            $html .= "<td>".$v['state']."</td>";
            if($authority["modify"])
                $html .= "<td><a href='javascript:edit_customer_modal(".$v['cid'].")'><i class=\"fa fa-edit\"></i> " . lang("edit") . "</a></td>";
            if($authority["delete"])
                $html .= "<td><a href='javascript:confirm_delete(".$v['cid'].")'><i class=\"fa fa-trash-o\"></i>" . lang("delete") . "</a></td>";
            $html .= '</tr>';
        }
        echo json_encode($html);
    }
    public function del_customer() {
        $authority = $this->user->hasAuthority("customer");
        $cid = $this->input->post('cid');
        $msg = $this->customer->delete_customer($cid);
        $customer = $this->customer->get_list();
        $i = 0;
        $html = '';
        if($msg){
            foreach($customer as $v) {
                $i++;
                $html .="<tr id='tr_".$v['cid']."'>";
                $html .="<td>".$i."</td>";
                $html .= "<td>".$v['name']."</td>";
                $html .= "<td>".$v['street']."</td>";
                $html .= "<td>".$v['extStreetNumber']."</td>";
                $html .= "<td>".$v['inStreetNumber']."</td>";
                $html .= "<td>".$v['complementaryInfo']."</td>";
                $html .= "<td>".$v['city']."</td>";
                $html .= "<td>".$v['zipcode']."</td>";
                $html .= "<td>".$v['country']."</td>";
                $html .= "<td>".$v['phoneNumber']."</td>";
                $html .= "<td>".$v['mail']."</td>";
                $html .= "<td>".$v['state']."</td>";
                if($authority["modify"])
                    $html .= "<td><a href='javascript:edit_customer_modal(".$v['cid'].")'><i class=\"fa fa-edit\"></i> " . lang("edit") . "</a></td>";
                if($authority["delete"])
                    $html .= "<td><a href='javascript:confirm_delete(".$v['cid'].")'><i class=\"fa fa-trash-o\"></i>" . lang("delete") . "</a></td>";
                $html .= '</tr>';
            }
            echo $html;
        }
    }
}







