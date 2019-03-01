
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class VendorController extends CI_Controller {
    function __construct(){
        parent::__construct();
        // Your own constructor code
        $this->load->model('VendorModel', 'vendor');
		$this->lang->load('vendor', $this->config->item("language"));
    }
    public function index() {
        $authority = $this->user->hasAuthority("seller");
        if($authority["total"] == false)
            return redirect("/logout");

        $page_no = isset($_GET['per_page']) ? $_GET['per_page'] : 1;
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
       // print_r($keyword);
     
        $per_page = 10;
        if($keyword){
            ///$session = array('key' => $keyword);
            $result['total'] = $this->vendor->record_keyword_count($keyword);
            $result['vendor'] = $this->vendor->get_keyword_result($keyword);

        }
        $offset = ($page_no - 1) * $per_page;

        $result['total'] = $this->vendor->record_count();
        $result['vendor'] = $this->vendor->get_vendor_list($offset, $per_page, $keyword);
        $result['page'] = $page_no;
        $result['per_page'] = $per_page;
		
		$data = array(
			"subtitle" => "Vendedores",
			"description" => "Gestión del vendedor",
			"contentview" => "vendor/vendor",
			'total' => $this->vendor->record_count(),
			'vendor' => $this->vendor->get_vendor_list($offset, $per_page, $keyword),
			'page' => $page_no,
			'per_page' => $per_page,
            'authority' => $this->user->hasAuthority("seller"),
		);
		
		$this->load->view('layout', $data);
    }

    public function vendor_attach() {
        $footer_data = array(
            'js' => array(
                'public/vender/vender_register.js',
            ),
        );
        $this->load->view('include/admin_header');
        $this->load->view('vendor/vendor_register');
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
        $this->db->insert('vendor', $data);

        echo 'ok';
    }
    //required|min_length[8]|max_length[16]'
	var $form_config = array(
		array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required'
		),
		array(
			'field' => 'street',
			'label' => 'street',
			'rules' => 'required',
		),
		array(
			'field' => 'extStreetNumber',
			'label' => 'ExternalStreetNumber',
			'rules' => 'required',
		),
		array(
			'field' => 'inStreetNumber',
			'label' => 'InnerStreetNumber',
			'rules' => 'required',
		),
		array(
			'field' => 'city',
			'label' => 'city',
			'rules' => 'required',
		),
	);

	public function add_vendor() {
        $authority = $this->user->hasAuthority("seller");
		$this->form_validation->set_rules($this->form_config);
		$state = 0;
		if ($this->form_validation->run() != FALSE) {
            //var_dump($_POST); exit;
		    if($this->input->post('state') == 'on'){
		        $state = 1;
            }
			$new_vendor['name'] = $this->input->post('name');
			$new_vendor['street'] = $this->input->post('street');
			$new_vendor['extStreetNumber'] = $this->input->post('extStreetNumber');
			$new_vendor['inStreetNumber'] = $this->input->post('inStreetNumber');
			$new_vendor['complementaryInfo'] = $this->input->post('complementaryInfo');
			$new_vendor['city'] = $this->input->post('city');
            $new_vendor['state'] = $this->input->post('state');
			$new_vendor['zipcode'] = $this->input->post('zipcode');
			$new_vendor['country'] = $this->input->post('country');
			$new_vendor['phoneNumber'] = $this->input->post('phonenumber');
			$new_vendor['mail'] = $this->input->post('mail');
			$msg = $this->vendor->vendor_add($new_vendor);
            $vendor = $this->vendor->get_list();
			$html = '';
			if ($msg) {
			    $i = 0;
			    foreach($vendor as $v) {
			        $i++;
                    $html .="<tr id='tr_".$v['vid']."'>";
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
                        $html .= "<td><a href='javascript:edit_vendor_model(".$v['vid'].")'><i class=\"fa fa-edit\"></i> " . lang("edit") . "</a></td>";
                    if($authority["delete"])
                        $html .= "<td><a href='javascript:confirm_delete(".$v['vid'].")'><i class=\"fa fa-trash-o\"></i>" . lang("delete") . "</a></td>";
                    $html .= '</tr>';
                }
			}
			echo $html;
		}
	}
	public function edit_vendor() {
        $authority = $this->user->hasAuthority("seller");
	    //var_dump($_POST);exit;
		$this->form_validation->set_rules($this->form_config);
		if ($this->form_validation->run() != FALSE) {
			$vid = $this->input->post('vid');
			$vendor['name'] = $this->input->post('name');
            $vendor['street'] = $this->input->post('street');
            $vendor['extStreetNumber'] = $this->input->post('extStreetNumber');
            $vendor['inStreetNumber'] = $this->input->post('inStreetNumber');
            $vendor['complementaryInfo'] = $this->input->post('complementaryInfo');
            $vendor['city'] = $this->input->post('city');
            $vendor['state'] = $this->input->post('state');
            $vendor['zipcode'] = $this->input->post('zipcode');
            $vendor['country'] = $this->input->post('country');
            $vendor['phoneNumber'] = $this->input->post('phonenumber');
            $vendor['mail'] = $this->input->post('mail');

			$msg = $this->vendor->vendor_edit($vid, $vendor);
			if ($msg) {
				$vendors = $this->vendor->get_vendor_list();
                $i = 0;
                $html = '';
                foreach($vendors as $v) {
                    $i++;
                    $html .="<tr id='tr_".$v['vid']."'>";
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
                        $html .= "<td><a href='javascript:edit_vendor_model(".$v['vid'].")'><i class=\"fa fa-edit\"></i> " . lang("edit") . "</a></td>";
                    if($authority["delete"])
                        $html .= "<td><a href='javascript:confirm_delete(".$v['vid'].")'><i class=\"fa fa-trash-o\"></i>" . lang("delete") . "</a></td>";
                    $html .= '</tr>';
                }
                echo json_encode($html);
			}
		}
	}

	public function vendor_search() {
        $authority = $this->user->hasAuthority("seller");
		$key = $this->input->post('srch_key');
		$res = $this->vendor->search_result($key);
        $i = 0;
        $html = '';
        foreach($res as $v) {
            $i++;
            $html .="<tr id='tr_".$v['vid']."'>";
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
                $html .= "<td><a href='javascript:edit_vendor_model(".$v['vid'].")'><i class=\"fa fa-edit\"></i> " . lang("edit") . "</a></td>";
            if($authority["delete"])
                $html .= "<td><a href='javascript:confirm_delete(".$v['vid'].")'><i class=\"fa fa-trash-o\"></i>" . lang("delete") . "</a></td>";
            $html .= '</tr>';
        }
		echo json_encode($html);
	}

	public function del_vendor() {
        $authority = $this->user->hasAuthority("seller");
	    //var_dump($_POST);exit;
		$vid = $this->input->post('vid');
		$msg = $this->vendor->delete_vendor($vid);
        $vendor = $this->vendor->get_list();
        $i = 0;
        $html = '';
        foreach($vendor as $v) {
            $i++;
            $html .="<tr id='tr_".$v['vid']."'>";
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
                $html .= "<td><a href='javascript:edit_vendor_model(".$v['vid'].")'><i class=\"fa fa-edit\"></i> " . lang("edit") . "</a></td>";
            if($authority["delete"])
                $html .= "<td><a href='javascript:confirm_delete(".$v['vid'].")'><i class=\"fa fa-trash-o\"></i>" . lang("delete") . "</a></td>";
            $html .= '</tr>';
        }
        $data = array(
            'msg' => $msg,
            'html' => $html,
        );
		echo json_encode($data);
	}
}







