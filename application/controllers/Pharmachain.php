<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pharmachain extends CI_Controller {

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
		$this->load->view('pharmachain',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('pharmachain');
			$crud->set_subject('Pharmachain Customer');
			$crud->columns('id_cust2','id_cust','id_dist','id_channel');
			$crud->fields('id_cust');
			$crud->set_relation('id_cust','customer','name');
			$crud->unset_edit();
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_clone();
			$crud->display_as('id_cust','Name');
			$crud->display_as('id_dist','Distributor');
			$crud->display_as('id_cust2','Code');
			$crud->display_as('id_channel','Channel');
			$crud->set_lang_string('form_update_changes','Update');
            $crud->callback_column('id_cust2',array($this,'_callback_code'));
            $crud->callback_column('id_dist',array($this,'_callback_dist'));
            $crud->callback_column('id_channel',array($this,'_callback_channel'));
			$crud->callback_before_delete(array($this,'before_delete'));			
			$crud->callback_after_insert(array($this,'after_add'));
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

    public function _callback_code($value, $row)
    {
		$result="";
		$query = $this->db->query("SELECT id_cust2 FROM customer WHERE id_cust=".$row->id_cust);
		foreach ($query->result() as $row2)
		{			
			$result=$row2->id_cust2;
		}
		
		return $result;
    }

    public function _callback_channel($value, $row)
    {
		$result="";
		$query = $this->db->query("SELECT b.name FROM customer a, channel b WHERE a.id_channel=b.id_channel and id_cust=".$row->id_cust);
		foreach ($query->result() as $row2)
		{			
			$result=$row2->name;
		}
		
		return $result;
    }

    public function _callback_dist($value, $row)
    {
		$result="";
		$query = $this->db->query("SELECT code FROM customer a, distributor b WHERE a.id_dist=b.id_dist and id_cust=".$row->id_cust);
		foreach ($query->result() as $row2)
		{			
			$result=$row2->code;
		}
		
		return $result;
    }

	public function before_delete($primary_key)
	{	
		$query = $this->db->query("SELECT id_cust FROM pharmachain WHERE id_pharma=".$primary_key);
		foreach ($query->result() as $row2)
		{			
			$this->db->set('is_pharmachain', '0', FALSE);
			$this->db->where('id_cust', $row2->id_cust);
			$this->db->update("customer");
		}
		
		return true;
	}

	function after_add($post_array,$primary_key)
	{
		$this->db->set('is_pharmachain', '1', FALSE);
		$this->db->where('id_cust', $post_array['id_cust']);
		$this->db->update("customer");
	 
		return true;
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
