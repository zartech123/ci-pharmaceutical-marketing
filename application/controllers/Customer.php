<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

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
		$this->load->view('customer',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('customer');
			$crud->set_subject('Customer');
			$crud->columns('id_upload','id_cust2','id_dist','id_channel','id_branch','name','address','phone2','fax','postcode2','npwp','city','group_customer');
			$crud->fields('id_cust2','id_dist','id_channel','id_branch','name','address','phone2','fax','postcode2','npwp','city','group_customer');
			$crud->required_fields('id_cust2','id_dist','id_channel','id_branch','name','npwp');
			$crud->set_relation('id_dist','distributor','code');
			$state = $crud->getState();
			if($state=="edit")
			{	
				$crud->set_relation('id_channel','channel','name',null,'name');
				$crud->set_relation('id_branch','branch','name',null,'name');
			}	
			else
			{	
				$crud->set_relation('id_channel','channel','name',array('id_dist'=>'0'),'name');
				$crud->set_relation('id_branch','branch','name',array('id_dist'=>'0'),'name');
			}	
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_clone();
			$crud->field_type("postcode2","integer");
			$crud->field_type("latitude","integer");
			$crud->field_type("longitude","integer");
			$crud->field_type("id_cust2","integer");
			$crud->display_as('id_upload','ID Upload');
			$crud->display_as('postcode2','Post Code');
			$crud->display_as('phone2','Phone');
			$crud->display_as('id_dist','Distributor');
			$crud->display_as('id_channel','Channel');
			$crud->display_as('id_branch','Branch');
			$crud->display_as('group_customer','Group Customer');
			$crud->display_as('npwp','NPWP');
			$crud->display_as('id_cust2','Customer Code');
			$crud->set_lang_string('form_update_changes','Update');
			$crud->set_lang_string('form_update_and_go_back','Update & Return');
			$crud->set_lang_string('form_save_and_go_back','Save & Return');
			$crud->set_lang_string('form_upload_delete','Delete');

			$output = $crud->render();
			$jumlah = 0;
			$query = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and page='".$this->uri->segment(1)."' and (id_group like '".$this->session->userdata('id_group').",%' or id_group like '%,".$this->session->userdata('id_group')."' or id_group like '%,".$this->session->userdata('id_group').",%' or id_group='".$this->session->userdata('id_group')."')");
			foreach ($query->result() as $row2)
			{
				$jumlah = $row2->jumlah;
				if($jumlah==0 && isset($_GET['access']))
				{
					$query2 = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and page='".$this->uri->segment(1)."' and (id_group like '".$_GET['access'].",%' or id_group like '%,".$_GET['access']."' or id_group like '%,".$_GET['access'].",%' or id_group='".$_GET['access']."')");
					foreach ($query2->result() as $row3)
					{
						$jumlah = $row3->jumlah;
					}
				}
			}

			if(!$this->session->userdata('id_group'))
			{
				redirect("/Login");
			}
			else
			{		
				if($jumlah==1)
				{
					$this->load->view('menu_admin.html');
					$this->_user_output($output);
				}
				else
				{
					$this->load->view('info2');
				}				
			}	

    		/*if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
			{	
				$this->load->view('menu_admin.html');
				$this->_user_output($output);
			}	
			else
			{
				redirect("/Login");
			}*/


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


	public function getChannel()
	{
		$result="[";
		$query = $this->db->query("SELECT distinct id_channel as id, name  FROM channel WHERE id_dist=".$_GET['id_dist']);
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id."\",\"name\":\"".$row2->name."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}


	public function getBranch()
	{
		$result="[";
		$query = $this->db->query("SELECT distinct id_branch as id, name  FROM branch WHERE id_dist=".$_GET['id_dist']);
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id."\",\"name\":\"".$row2->name."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}

}
