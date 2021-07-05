<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AMEL extends CI_Controller {

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
		$this->load->view('amel',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('mer');
			$crud->set_subject('Approved Master Event List ');
			$crud->columns('nodoc','event_name','event_start_date','event_end_date','event_venue','type','speciality','speciality2','event_quota','est_budget');
			$crud->unset_add();
			$crud->unset_edit();
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_delete();
			$crud->unset_clone();
			$crud->where('state=7');
			$crud->field_type('type','dropdown',array('1' => 'ThirdParty', '2' => 'TPI'));			
			$crud->display_as('event_name','Event Name');
			$crud->display_as('nodoc','MER');
			$crud->display_as('event_start_date','Start Date');
			$crud->display_as('event_end_date','End Date');
			$crud->display_as('event_venue','Venue');
			$crud->display_as('event_quota','Sponsor Quota');
			$crud->display_as('est_budget','Est. Budget');
			$crud->display_as('speciality','Speaker Speciality');
			$crud->display_as('speciality2','Attendance Speciality');
            $crud->callback_column('event_start_date',array($this,'_callback_date'));
            $crud->callback_column('event_end_date',array($this,'_callback_date'));
            $crud->callback_column('est_budget',array($this,'_callback_est_budget'));
            $crud->callback_column('speciality',array($this,'_callback_speciality'));
            $crud->callback_column('speciality2',array($this,'_callback_speciality2'));
            $crud->callback_column('nodoc',array($this,'_callback_nodoc'));

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

	public function _callback_date($value, $row)
	{
		return date('Y-m-d',strtotime($value));
	}

    public function _callback_nodoc($value, $row)
    {
		$result="";
		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, nodoc FROM mer WHERE id_mer=".$row->id_mer);
		foreach ($query->result() as $row2)
		{			
			$result = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
		}

        return $result;
    }

    public function _callback_est_budget($value, $row)
    {
        $amount = "0";
		$query = $this->db->query("SELECT sum(replace(amount,'.','')*replace(description,'.','')) as amount from budget_mer where id_parent='".$row->id_mer."'");
		foreach ($query->result() as $row2)
		{
            $amount = number_format($row2->amount,2);
		}
		$amount = str_replace(".00","",$amount);

        return $amount;
    }

    public function _callback_speciality($value, $row)
    {
        $speciality = "";
		$x = explode(',',$row->speciality);
		foreach($x as $key => $val) 
		{
			$query = $this->db->query("select name_speciality from speciality where id_speciality='".$val."'");
			foreach ($query->result() as $row2)
			{
				$speciality = $speciality.$row2->name_speciality.", ";
			}
		}		

        return $speciality;
    }

    public function _callback_speciality2($value, $row)
    {
        $speciality = "";
		$x = explode(',',$row->speciality2);
		foreach($x as $key => $val) 
		{
			$query = $this->db->query("select name_speciality from speciality where id_speciality='".$val."'");
			foreach ($query->result() as $row2)
			{
				$speciality = $speciality.$row2->name_speciality.", ";
			}
		}				

        return $speciality;
    }

}
