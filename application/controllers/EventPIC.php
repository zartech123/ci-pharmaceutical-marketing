<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EventPIC extends CI_Controller {

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
		$this->load->view('event_pic',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('event_pic');
			$crud->set_subject('EVENT PIC');
			$crud->required_fields('id_event','id_user');
			if($this->uri->segment(8)==2)
			{
				$crud->edit_fields('id_event','id_user','pic_present','pic_present_date','pic_date','file');
				$crud->add_fields('id_event','id_user','pic_present','pic_present_date','pic_date','file');
//				$crud->columns('id_user','role','area','id_user','id_bank','pic_account','pic_perdiem_est','pic_present','pic_present_date','pic_actual','pic_date','file');
				$crud->display_as('pic_present_date','Tanggal Kehadiran');
				$crud->display_as('file','Bukti Transfer');
				$crud->set_field_upload('file','assets/uploads');
				$event_date = array();
				$event_date2 = array();
				$query = $this->db->query("select event_date from event_otc where id_event='".$this->uri->segment(4)."'");
				foreach ($query->result() as $row2)
				{
					$event_date = explode(",",str_replace("'","",$row2->event_date));					
				}
				
				foreach ($event_date as $value) 
				{
					$event_date2[$value]=$value;
				}
				
				$crud->field_type('pic_present_date','multiselect',$event_date2);

			}
			else
			{
				$crud->fields('id_event','id_user','pic_present_date');
				$crud->required_fields('pic_present_date');
//				$crud->columns('id_user','role','area','id_bank','pic_account_name','pic_account','pic_perdiem_est','pic_present_date');
				$crud->display_as('pic_present_date','Rencana Tanggal Kehadiran');

				$event_date = array();
				$event_date2 = array();
				$query = $this->db->query("select event_date from event_otc where id_event='".$this->uri->segment(4)."'");
				foreach ($query->result() as $row2)
				{
					$event_date = explode(",",str_replace("'","",$row2->event_date));					
				}
				
				foreach ($event_date as $value) 
				{
					$event_date2[$value]=$value;
				}
				
				$crud->field_type('pic_present_date','multiselect',$event_date2);

			}	
            $crud->columns('id_user','role','area','id_bank','pic_account_name','pic_account','pic_perdiem_est','pic_present','pic_present_date','pic_date','file');
//			$crud->set_relation('id_event','event_otc','event_name','id_event='.$this->uri->segment(3));
			$crud->set_relation('id_user','user','{name}','id_group in (15,22,23,25) and active=1','name');
            if($this->uri->segment(4)!=null)
            {
				$crud->where('event_pic.id_event',$this->uri->segment(4));
			}			

//			$crud->unset_delete();
            $crud->unset_read();
			$crud->field_type('id_event','hidden',$this->uri->segment(4));
			if(($this->session->userdata('id_group')==15 || $this->session->userdata('id_group')==10)&& $this->uri->segment(6)=="1")
			{
			}
			else if($this->session->userdata('id_group')==20 && $this->uri->segment(6)=="1")
			{
				$crud->unset_delete();
			}
			else
			{
				$crud->unset_edit();
				$crud->unset_delete();
				$crud->unset_add();
			}
			$crud->unset_print();
			$crud->unset_clone();
			$crud->field_type('pic_present','dropdown',array('0' => 'Tidak Hadir','1' => 'Hadir'));			
			$crud->field_type('pic_date','date');
			$crud->display_as('id_bank','Bank');
			$crud->display_as('id_user','Nama');
			$crud->display_as('file','Bukti Transfer');
			$crud->display_as('pic_account','Account No');
			$crud->display_as('pic_account_name','Account Name');
			$crud->display_as('pic_perdiem_est','PerDiem (IDR)');
			$crud->display_as('pic_date','Tanggal Transfer');
			$crud->display_as('pic_present','Kehadiran');
			$crud->display_as('id_event','Event OTC');
            $crud->callback_column('role',array($this,'_callback_role'));
            $crud->callback_column('area',array($this,'_callback_area'));
            $crud->callback_column('pic_perdiem_est',array($this,'_callback_perdiem'));
            $crud->callback_column('id_bank',array($this,'_callback_bank'));
            $crud->callback_column('pic_account',array($this,'_callback_pic_account'));
            $crud->callback_column('pic_present_date',array($this,'_callback_pic_present_date'));
            $crud->callback_column('pic_account_name',array($this,'_callback_pic_account_name'));
			$crud->set_lang_string('form_update_changes','Update');
			$crud->set_lang_string('form_update_and_go_back','Update & Return');
			$crud->set_lang_string('form_save_and_go_back','Save & Return');
			$crud->set_lang_string('form_upload_delete','Delete');

			$output = $crud->render();
			$jumlah = 0;
			$query = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and replace(page,'List','')='Event' and (id_group like '".$this->session->userdata('id_group').",%' or id_group like '%,".$this->session->userdata('id_group')."' or id_group like '%,".$this->session->userdata('id_group').",%' or id_group='".$this->session->userdata('id_group')."')");
			foreach ($query->result() as $row2)
			{
				$jumlah = $row2->jumlah;
				if($jumlah==0 && isset($_GET['access']))
				{
					$query2 = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and replace(page,'List','')='Event' and (id_group like '".$_GET['access'].",%' or id_group like '%,".$_GET['access']."' or id_group like '%,".$_GET['access'].",%' or id_group='".$_GET['access']."')");
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
					$this->_user_output($output);
//					$this->load->view('event_pic',$data);
				}
				else
				{
					$this->load->view('info2');
				}				
			}	


/*			$output = $crud->render();
    		if($this->session->userdata('id_group')==1 || $this->session->userdata('id_group')<=18)
			{	
//				$this->load->view('menu_admin.html');
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

	public function _callback_role($value, $row)
	{
		$role = "";
		$query = $this->db->query("SELECT description FROM user a, groups b where a.id_group=b.id and id_user=".$row->id_user);
		foreach ($query->result() as $row2)
		{
			$role = $row2->description;	
		}

		return $role;
	}

	public function _callback_bank($value, $row)
	{
		$bank = "";
		$query = $this->db->query("SELECT concat(b.name,' (',b.code,')') as bank FROM user a, bank b where a.id_bank=b.id_bank and id_user=".$row->id_user);
		foreach ($query->result() as $row2)
		{
			$bank = $row2->bank;	
		}

		return $bank;
	}

	public function _callback_pic_account($value, $row)
	{
		$account_number = "";
		$query = $this->db->query("SELECT account_number FROM user where id_user=".$row->id_user);
		foreach ($query->result() as $row2)
		{
			$account_number = $row2->account_number;	
		}

		return $account_number;
	}

	public function _callback_pic_account_name($value, $row)
	{
		$account_name = "";
		$query = $this->db->query("SELECT account_name FROM user where id_user=".$row->id_user);
		foreach ($query->result() as $row2)
		{
			$account_name = $row2->account_name;	
		}

		return $account_name;
	}

	public function _callback_area($value, $row)
	{
		$area = "";
		$query2 = $this->db->query("SELECT id_group FROM user where id_user=".$row->id_user);
		foreach ($query2->result() as $row3)
		{
			if($row3->id_group==15)
			{
				$query = $this->db->query("SELECT b.name FROM user a, area_sales b where a.id_regency=b.id_area and id_user=".$row->id_user);
				foreach ($query->result() as $row2)
				{
					$area = $row2->name;	
				}
			}
			else
			{
				$query = $this->db->query("SELECT b.name FROM user a, regency b where a.id_regency=b.id_regency and id_user=".$row->id_user);
				foreach ($query->result() as $row2)
				{
					$area = $row2->name;	
				}
			}	
		}	

		return $area;
	}

	public function _callback_pic_present_date($value, $row)
	{
		return date("d-M-Y",strtotime($value));
	}
	public function _callback_perdiem($value, $row)
	{
		$perdiem = 0;
		$pic_date="";
		$query2 = $this->db->query("SELECT id_group FROM user where id_user=".$row->id_user);
		foreach ($query2->result() as $row3)
		{
			if($row3->id_group=="15")
			{
				$pic_date = explode(",","".$row->pic_present_date."");
				foreach($pic_date as $value)
				{
					$value2 = str_replace('/', '-', $value);
					if(date("N",strtotime(date("d/m/Y",strtotime($value2))))==6 || date("N",strtotime(date("d/m/Y",strtotime($value2))))==7)
					{
						if($row->pic_present=="1")
						{
							$perdiem=$perdiem+150000;
						}	
					}	
				}
			}
			else
			{
				$pic_date = explode(",","".$row->pic_present_date."");
				foreach($pic_date as $value)
				{
					$value2 = str_replace('/', '-', $value);
					if(date("N",strtotime(date("d/m/Y",strtotime($value2))))==6 || date("N",strtotime(date("d/m/Y",strtotime($value2))))==7)
					{
						if($row->pic_present=="1")
						{
							$perdiem=$perdiem+85000;
						}	
					}	
				}
//				$value = str_replace('/', '-', $row->pic_present_date);
//				$perdiem = date("N",strtotime(date("d/m/Y",strtotime($value))));
//				$perdiem = date("N",strtotime("'".$row->pic_present_date."'"));
			}
		}
		return number_format($perdiem,0,'.',',');
	}


}
