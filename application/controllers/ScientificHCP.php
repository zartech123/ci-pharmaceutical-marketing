<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ScientificHCP extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
		$this->load->library('session');
		$this->load->library('user_agent');
	}

	public function _user_output($output = null)
	{
		$this->load->view('scientific_hcp',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('scientific_hcp');
			$crud->set_subject('SCIENTIFIC HCP');
			$crud->required_fields('id_sc','type');
            $crud->fields('id_sc','type','internal_speaker','speaker_criteria','speaker_criteria2','name_hcp','npwp_hcp','service_hcp','institution_hcp','fee_hcp','bank_name_hcp','account_name_hcp','bank_hcp','file_ktp','file_npwp','file_bank','file_cv');
            $crud->columns('type','speaker_criteria','speaker_criteria2','name_hcp','npwp_hcp','service_hcp','institution_hcp','fee_hcp','bank_hcp','internal_speaker');
//			$crud->set_relation('id_sc','scientific','event_agenda','id_sc='.$this->uri->segment(4));
			$crud->set_relation('bank_name_hcp','bank','{name} ({code})');
			$crud->set_relation('name_hcp','doctor','{name}');
			$crud->set_relation('institution_hcp','hospital','{name}, {type}, {address}');
            if($this->uri->segment(4)!=null)
            {
				$crud->where('scientific_hcp.id_sc',$this->uri->segment(4));
			}			
            $crud->field_type('internal_speaker','multiselect',$this->internal_speaker());
//			$crud->unset_delete();
            $crud->unset_read();
			$crud->field_type('id_sc','hidden',$this->uri->segment(4));
            $crud->field_type('speaker_criteria','multiselect',
            array('1'=>'Medical background suit with the topic that will present',
            '2'=>'High skill and experienced in related field / topic',
            '3'=>'Good communication and presentation skill',
            '4'=>'Have influence in scientific related matters',
            '5'=>'Recommended or appointed as speaker by institution / committee / organisation / association</option',
            '6'=>'Able to share knowledge and skill to others HCP',
            '7'=>'Refer to the Sales & Marketing-Medical KOL List'));
			$crud->field_type('service_hcp', 'dropdown',array('1'=>'Speaker','2'=>'Moderator'));
			$crud->field_type('type', 'dropdown',array('1'=>'Internal','2'=>'External'));
			$crud->set_field_upload('file_ktp', 'assets/uploads');
			$crud->set_field_upload('file_npwp', 'assets/uploads');
			$crud->set_field_upload('file_bank', 'assets/uploads');
			$crud->set_field_upload('file_cv', 'assets/uploads');
			if($this->session->userdata('id_group')==7 || $this->session->userdata('id_group')==8 || $this->session->userdata('id_group')==9 || $this->session->userdata('id_group')==10)
			{
			}
			else
			{
				$crud->unset_edit();
				$crud->unset_delete();
				$crud->unset_add();
			}				
			$crud->unset_print();
			$crud->unset_clone();
			$crud->display_as('file_ktp','KTP');
			$crud->display_as('file_npwp','NPWP');
			$crud->display_as('file_bank','Bank Account');
			$crud->display_as('file_cv','CV');
			$crud->display_as('id_sc','Scientific');
			$crud->display_as('speaker_criteria2','Other Speaker Criteria');
			$crud->display_as('name_hcp','Name');
			$crud->display_as('npwp_hcp','NPWP');
			$crud->display_as('institution_hcp','Institution Name');
			$crud->display_as('fee_hcp','Estimated Fee');
			$crud->display_as('speaker_criteria','Speaker Criteria');
			$crud->display_as('bank_name_hcp','Bank Name');
			$crud->display_as('account_name_hcp','Account Name');
			$crud->display_as('bank_hcp','Bank Account');
			$crud->display_as('internal_speaker','Internal Speaker');
			$crud->display_as('service_hcp','Type of Service');
			$crud->set_rules('file_ktp','File','callback_file_ktp');
			$crud->set_rules('file_npwp','File','callback_file_npwp');
			$crud->set_rules('file_bank','File','callback_file_bank');
			$crud->set_rules('file_cv','File','callback_file_cv');
			$crud->set_lang_string('form_update_changes','Update');
			$crud->set_lang_string('form_update_and_go_back','Update & Return');
			$crud->set_lang_string('form_save_and_go_back','Save & Return');
			$crud->set_lang_string('form_upload_delete','Delete');

			$output = $crud->render();
    		if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
			{	
//				$this->load->view('menu_admin.html');
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


	function file_ktp($post_array) 
	{		
		if($_POST['type']=="2")
		{
			if(!empty($_POST['file_ktp']))
			{	
				return TRUE;
			}	
			else
			{
				$this->form_validation->set_message('file_ktp', 'Please upload KTP');
				return FALSE;
			}			
		}
		else
		{
			return TRUE;
		}	
	}

	function file_bank($post_array) 
	{		
		if($_POST['type']=="2")
		{
			if(!empty($_POST['file_bank']))
			{	
				return TRUE;
			}	
			else
			{
				$this->form_validation->set_message('file_bank', 'Please upload Account Bank');
				return FALSE;
			}			
		}
		else
		{
			return TRUE;
		}	
	}

	function file_npwp($post_array) 
	{		
		if($_POST['type']=="2")
		{
			if(!empty($_POST['file_npwp']))
			{	
				return TRUE;
			}	
			else
			{
				$this->form_validation->set_message('file_npwp', 'Please upload NPWP');
				return FALSE;
			}			
		}
		else
		{
			return TRUE;
		}	
	}

	function file_cv($post_array) 
	{		
		if($_POST['type']=="2")
		{
			if(!empty($_POST['file_cv']))
			{	
				return TRUE;
			}	
			else
			{
				$this->form_validation->set_message('file_cv', 'Please upload CV');
				return FALSE;
			}			
		}
		else
		{
			return TRUE;
		}	
	}

	public function internal_speaker()
	{
		$user = array();
		$query = $this->db->query("SELECT id_user, name FROM user where id_group in (5,6,7,8,9)");
		foreach ($query->result() as $row2)
		{
			$user = array_merge($user, array($row2->id_user=>$row2->name));	
			//array_push($user,array($row2->id_user=>$row2->name));
		}

		return $user;
	}

}
