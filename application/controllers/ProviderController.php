
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ProviderController extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('ProviderModel', 'provider');
		$this->lang->load('provider', $this->config->item("language"));
    }
    public function index() {
        $authority = $this->user->hasAuthority("provider");
        if($authority["total"] == false)
            return redirect("/logout");
        $page_no = isset($_GET['per_page']) ? $_GET['per_page'] : 1;
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
        $js = array(
            'public/js/provider/provider.js',
        );
        $per_page = 10;
        if($keyword){
            $result['total'] = $this->provider->record_keyword_count($keyword);
            $result['provider'] = $this->provider->get_keyword_result($keyword);

        }
        $offset = ($page_no - 1) * $per_page;

        $country = $this->db->query("select * from country");
		$data = array(
			"subtitle" => "Proveedores",
			"description" => "Gestion de proveedores",
			"contentview" => "provider/provider",
			'total' => $this->provider->record_count(),
			'provider' => $this->provider->get_provider_list($offset, $per_page, $keyword),
			'page' => $page_no,
			'per_page' => $per_page,
            'authority' => $this->user->hasAuthority("provider"),
            'country' => $country->result_array()
		);
		
		$this->load->view('layout', $data);
    }

    public function provider_attach() {
        $footer_data = array(
            'js' => array(
                'public/vender/vender_register.js',
            ),
        );
        $this->load->view('include/admin_header');
        $this->load->view('provider/provider_register');
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
        $this->db->insert('provider', $data);
        echo 'ok';
    }
    var $form_config = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required'
        )
    );

    public function add_provider() {
        $authority = $this->user->hasAuthority("provider");
        $this->form_validation->set_rules($this->form_config);
        if ($this->form_validation->run() != FALSE) {
            $new_provider['name'] = $this->input->post('name');
            $new_provider['street'] = $this->input->post('street');
            $new_provider['extStreetNumber'] = $this->input->post('extStreetNumber');
            $new_provider['inStreetNumber'] = $this->input->post('inStreetNumber');
            $new_provider['complementaryInfo'] = $this->input->post('complementaryInfo');
            $new_provider['city'] = $this->input->post('city');
            $new_provider['state'] = $this->input->post('state');
            $new_provider['zipcode'] = $this->input->post('zipcode');
            $new_provider['country'] = $this->input->post('country');
            $new_provider['phoneNumber'] = $this->input->post('phonenumber');
            $new_provider['mail'] = $this->input->post('mail');
            $msg = $this->provider->provider_add($new_provider);
            $html = ''; 
            if ($msg) {
                $i = 0;
                $provider = $this->provider->get_list();
                foreach($provider as $v) {
                    $i++;
                    $html .= "<tr id='tr_".$v['pid']."'>";
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
                        $html .= "<td><a href='javascript:edit_provider_modal(".$v['pid'].")'><i class=\"fa fa-edit\"></i> " . lang("edit") . "</a></td>";
                    if($authority["delete"])
                        $html .= "<td><a href='javascript:confirm_delete(".$v['pid'].")'><i class=\"fa fa-trash-o\"></i>" . lang("delete") . "</a></td>";
                    $html .= "</tr>";
                }
            }
            $data = array(
                'type' => $msg,
                'html' => $html,
            );
            echo json_encode($data);
        }
    }
    public function edit_provider() {
        $authority = $this->user->hasAuthority("provider");
        $this->form_validation->set_rules($this->form_config);
        if ($this->form_validation->run() != FALSE) {
            $pid = $this->input->post('pid');
            $provider['name'] = $this->input->post('name');
            $provider['street'] = $this->input->post('street');
            $provider['extStreetNumber'] = $this->input->post('extStreetNumber');
            $provider['inStreetNumber'] = $this->input->post('inStreetNumber');
            $provider['complementaryInfo'] = $this->input->post('complementaryInfo');
            $provider['city'] = $this->input->post('city');
            $provider['state'] = $this->input->post('state');
            $provider['zipcode'] = $this->input->post('zipcode');
            $provider['country'] = $this->input->post('country');
            $provider['phoneNumber'] = $this->input->post('phonenumber');
            $provider['mail'] = $this->input->post('mail');
            $msg = $this->provider->provider_edit($pid, $provider);
            if ($msg) {
                $providers = $this->provider->get_list();
                $i = 0;
                $html = '';
                foreach($providers as $v) {
                    $i++;
                    $html .="<tr id='tr_".$v['pid']."'>";
                    $html .="<td>".$i."</td>";
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
                        $html .= "<td><a href='javascript:edit_provider_modal(".$v['pid'].")'><i class=\"fa fa-edit\"></i> " . lang("edit") . "</a></td>";
                    if($authority["delete"])
                        $html .= "<td><a href='javascript:confirm_delete(".$v['pid'].")'><i class=\"fa fa-trash-o\"></i>" . lang("delete") . "</a></td>";
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
    public function provider_search() {
        $authority = $this->user->hasAuthority("provider");
        $key = $this->input->post('srch_key');
        $res = $this->provider->search_result($key);
        if(!empty($res)){
            if(is_array($res)){
                $i = 0;
                $html = '';
                foreach($res as $v) {
                    $i++;
                    $html .="<tr id='tr_".$v['pid']."'>";
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
                        $html .= "<td><a href='javascript:edit_provider_modal(".$v['pid'].")'><i class=\"fa fa-edit\"></i> " . lang("edit") . "</a></td>";
                    if($authority["delete"])
                        $html .= "<td><a href='javascript:confirm_delete(".$v['pid'].")'><i class=\"fa fa-trash-o\"></i>" . lang("delete") . "</a></td>";
                    $html .= '</tr>';
                }
                $data = array('type' =>TRUE,'html' => $html );
                echo json_encode($data);
            }
        }else{
            $data = array('type' => FALSE ,'html' => '' );
            echo json_encode($data);
        }
    }

    public function del_provider() {
        $authority = $this->user->hasAuthority("provider");
        $pid = $this->input->post('pid');
        $msg = $this->provider->delete_provider($pid);
        $provider = $this->provider->get_list();
        $i = 0;
        $html = '';
        foreach($provider as $v) {
            $i++;
            $html .="<tr id='tr_".$v['pid']."'>";
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
                $html .= "<td><a href='javascript:edit_provider_modal(".$v['pid'].")'><i class=\"fa fa-edit\"></i> " . lang("edit") . "</a></td>";
            if($authority["delete"])
                $html .= "<td><a href='javascript:confirm_delete(".$v['pid'].")'><i class=\"fa fa-trash-o\"></i>" . lang("delete") . "</a></td>";
            $html .= '</tr>';
        }       
        echo $html;
    }
}







