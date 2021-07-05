<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Branch extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
		$this->load->library('user_agent');
		$this->load->library('session');
	}

	public function _user_output($output = null)
	{
		$this->load->view('branch',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('branch');
			$crud->set_subject('Branch');
			$crud->columns('id_branch2','name','id_province','id_dist','region','postcode','latitude','longitude');
			$crud->fields('id_branch2','name','id_province','id_dist','region','postcode','latitude','longitude');
			$crud->set_relation('id_dist','distributor','code');
			$crud->set_relation('id_province','provinces','name');
			$crud->required_fields('id_branch2','name','id_province','id_dist');
			$crud->field_type('region','dropdown',array('1' => 'R1', '2' => 'R2','3' => 'R3'));			
			if($this->session->userdata('id_group')==11 || $this->session->userdata('id_group')==12 || $this->session->userdata('id_group')==6 || $this->session->userdata('id_group')==13)
			{
			}				
			else
			{
				$crud->unset_add();
				$crud->unset_edit();
				$crud->unset_delete();
			}				
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_clone();
			$crud->field_type("postcode","integer");
			$crud->field_type("latitude","integer");
			$crud->field_type("longitude","integer");
			$crud->field_type("id_branch2","integer");
			
			$crud->display_as('postcode','Post Code');
			$crud->display_as('id_branch2','ID Branch');
			$crud->display_as('id_province','Region');
			$crud->display_as('id_dist','Distributor');
			$crud->set_lang_string('form_update_changes','Update');
			$crud->set_lang_string('form_update_and_go_back','Update & Return');
			$crud->set_lang_string('form_save_and_go_back','Save & Return');
			$crud->set_lang_string('form_upload_delete','Delete');

			$output = $crud->render();
    		if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
			{	
				$this->load->view('menu_admin.html');
				$this->_user_output($output);
			}	
			else
			{
				redirect("/Login");
			}


		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	
	//		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function getAuditTrail()
	{
		$ip = $this->input->ip_address();
		
		$agent = "";
		if ($this->agent->is_browser())
		{
			$agent = $this->agent->browser().' '.$this->agent->version();
		}
		elseif ($this->agent->is_robot())
		{
			$agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
			$agent = $this->agent->mobile();
		}
		else
		{
			$agent = 'Unidentified User Agent';
		}

		$agent = $agent." ".$this->agent->platform();

		$url = current_url().'?'.$_SERVER['QUERY_STRING'];

		$agent_full = $_SERVER['HTTP_USER_AGENT'];

		$data = array(
            'page' => $url,
			'id_user' => $this->session->userdata('id_user'),
            'ip_address' => $ip,
            'user_agent' => $agent,
			'user_agent_full' => $agent_full
        );
		$this->db->insert("log_page",$data);

	}

}
