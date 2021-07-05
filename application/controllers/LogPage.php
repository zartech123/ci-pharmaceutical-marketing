<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LogPage extends CI_Controller {

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
		$this->load->view('logpage',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('log_page');
			$crud->set_subject('User Activity');
			$crud->columns('desc','nodoc','id_user','ip_address','user_agent','created_date');
			$crud->order_by('created_date, id_log','desc');
			$crud->like('page','/MER?');
			$crud->or_like('page','/MER/');
			$crud->or_like('page','/HCP1?');
			$crud->or_like('page','/HCP1/');
			$crud->or_like('page','/HCP2?');
			$crud->or_like('page','/HCP2/');
			$crud->or_like('page','/ScientificReport/');
			$crud->or_like('page','/ScientificReport?');
			$crud->or_like('page','/HCPReport2/');
			$crud->or_like('page','/HCPReport2?');
			$crud->or_like('page','/HCOReport/');
			$crud->or_like('page','/HCOReport?');
			$crud->or_like('page','/HCPReport/');
			$crud->or_like('page','/HCPReport?');
			$crud->or_like('page','/HCO/');
			$crud->or_like('page','/HCO?');
			$crud->or_like('page','/HCP/');
			$crud->or_like('page','/HCP?');
			$crud->or_like('page','/Scientific/');
			$crud->or_like('page','/Scientific?');
			$crud->or_like('page','/EventReport/');
			$crud->or_like('page','/EventReport?');
			$crud->or_like('page','/Event/');
			$crud->or_like('page','/Event?');
			$crud->or_like('page','/Login/');
			$crud->set_relation('id_user','user','name');
			$crud->unset_edit();
			$crud->unset_delete();
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_clone();
			$crud->display_as('desc','Description');
			$crud->display_as('id_user','User');
			$crud->display_as('nodoc','Document');
			$crud->display_as('ip_address','IP Address');
			$crud->display_as('user_agent','Browser Type');
			$crud->display_as('created_date','Time');
            $crud->callback_column('desc',array($this,'_callback_desc'));
            $crud->callback_column('nodoc',array($this,'_callback_nodoc'));
//            $crud->callback_column('ip_address',array($this,'_callback_ip'));
            $crud->callback_column('created_date',array($this,'_callback_date'));
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

    public function _callback_desc($value, $row)
    {
		$result="";

		$id_group = "0";
		$query = $this->db->query("select id_group from user where id_user=".$row->id_user);
		foreach ($query->result() as $row2)
		{
			$id_group = $row2->id_group;
		}

		if (strpos($row->page, 'EventReport') !== false)
		{	
			if (strpos($row->page, 'upload') !== false) 
			{
				$result="Upload Event Report Attachment";
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="Save / Submit / Approved / Reject / Review / Freeze";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="Delete Event Report Attachment";
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result="Delete Event Report Document";
			}  
			else if (strpos($row->page, 'updateState6') !== false) 
			{
				$result="Review Event Report Document";
			}  
			else if (strpos($row->page, 'updateState5') !== false) 
			{
				$result="Reject Event Report Document";
			}  
			else if (strpos($row->page, 'updateState4') !== false) 
			{
				$result="Freeze Event Report Document";
			}  
			else if (strpos($row->page, 'updateState3') !== false) 
			{
				$result="Reject Event Report Document";
			}  
			else if (strpos($row->page, 'updateState2') !== false) 
			{
				$result="Review Event Report Document";
			}  
			else if (strpos($row->page, 'updateState') !== false) 
			{
				if($id_group=='20')
				{
					$result="Request for Approval Event Report Document";
				}
				else
				{		
					$result="Approved Event Report Document";
				}	
			}  
			else if (strpos($row->page, 'access') !== false) 
			{
				$result="Open Event Report Document from Email Notification";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==2)
				{	
					$result="Create Event Report Document";
				}
				else
				{
					$result="Open Event Report Document from Browser";
				}					
			}			
		}		
		else if (strpos($row->page, 'Event') !== false)
		{	
			if (strpos($row->page, 'upload') !== false) 
			{
				$result="Upload Event Attachment";
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="Save / Submit / Approved / Reject / Review / Freeze";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="Delete Event Attachment";
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result="Delete Event Document";
			}  
			else if (strpos($row->page, 'updateState6') !== false) 
			{
				$result="Review Event Document";
			}  
			else if (strpos($row->page, 'updateState5') !== false) 
			{
				$result="Reject Event Document";
			}  
			else if (strpos($row->page, 'updateState4') !== false) 
			{
				$result="Freeze Event Document";
			}  
			else if (strpos($row->page, 'updateState3') !== false) 
			{
				$result="Reject Event Document";
			}  
			else if (strpos($row->page, 'updateState2') !== false) 
			{
				$result="Review Event Document";
			}  
			else if (strpos($row->page, 'updateState') !== false) 
			{
				if($id_group=='15' || $id_group=='10')
				{
					$result="Request for Approval Event Document";
				}
				else
				{		
					$result="Approved Event Document";
				}	
			}  
			else if (strpos($row->page, 'access') !== false) 
			{
				$result="Open Event Document from Email Notification";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==1)
				{	
					$result="Create Event Document";
				}
				else
				{
					$result="Open Event Document from Browser";
				}					
			}			
		}		
		else if (strpos($row->page, 'ScientificReport') !== false)
		{	
			if (strpos($row->page, 'upload') !== false) 
			{
				$result="Upload SERF Report Attachment";
			}  
			else if (strpos($row->page, 'add?') !== false) 
			{
				$result="Save / Submit / Approved / Reject / Review / Freeze";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="Delete SERF Report Attachment";
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result="Delete SERF Report Document";
			}  
			else if (strpos($row->page, 'updateState6') !== false) 
			{
				$result="Review SERF Report Document";
			}  
			else if (strpos($row->page, 'updateState5') !== false) 
			{
				$result="Reject SERF Report Document";
			}  
			else if (strpos($row->page, 'updateState4') !== false) 
			{
				$result="Freeze SERF Report Document";
			}  
			else if (strpos($row->page, 'updateState3') !== false) 
			{
				$result="Reject SERF Report Document";
			}  
			else if (strpos($row->page, 'updateState2') !== false) 
			{
				$result="Review SERF Report Document";
			}  
			else if (strpos($row->page, 'updateState') !== false) 
			{
				if($row->id_user=='1')
				{
					$result="Request for Approval SERF Report Document";
				}
				else
				{		
					$result="Approved SERF Report Document";
				}	
			}  
			else if (strpos($row->page, 'access') !== false) 
			{
				$result="Open SERF Report Document from Email Notification";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==3)
				{	
					$result="Create SERF Report Document";
				}
				else
				{
					$result="Open SERF Report Document from Browser";
				}					
			}			
		}		
		else if (strpos($row->page, 'HCOReport') !== false)
		{	
			if (strpos($row->page, 'upload') !== false) 
			{
				$result="Upload HCO Report Attachment";
			}  
			else if (strpos($row->page, 'add?') !== false) 
			{
				$result="Save / Submit / Approved / Reject / Review / Freeze";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="Delete HCO Report Attachment";
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result="Delete HCO Report Document";
			}  
			else if (strpos($row->page, 'updateState6') !== false) 
			{
				$result="Review HCO Report Document";
			}  
			else if (strpos($row->page, 'updateState5') !== false) 
			{
				$result="Reject HCO Report Document";
			}  
			else if (strpos($row->page, 'updateState4') !== false) 
			{
				$result="Freeze HCO Report Document";
			}  
			else if (strpos($row->page, 'updateState3') !== false) 
			{
				$result="Reject HCO Report Document";
			}  
			else if (strpos($row->page, 'updateState2') !== false) 
			{
				$result="Review HCO Report Document";
			}  
			else if (strpos($row->page, 'updateState') !== false) 
			{
				if($row->id_user=='1')
				{
					$result="Request for Approval HCO Report Document";
				}
				else
				{		
					$result="Approved HCO Report Document";
				}	
			}  
			else if (strpos($row->page, 'access') !== false) 
			{
				$result="Open HCO Report Document from Email Notification";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==3)
				{	
					$result="Create HCO Report Document";
				}
				else
				{
					$result="Open HCO Report Document from Browser ";
				}					
			}			
		}		
		else if (strpos($row->page, 'HCPReport2') !== false)
		{	
			if (strpos($row->page, 'upload') !== false) 
			{
				$result="Upload HCP Consultant Report Attachment";
			}  
			else if (strpos($row->page, 'add?') !== false) 
			{
				$result="Save / Submit / Approved / Reject / Review / Freeze";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="Delete HCP Consultant Report Attachment";
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result="Delete HCP Consultant Report Document";
			}  
			else if (strpos($row->page, 'updateState6') !== false) 
			{
				$result="Review HCP Consultant Report Document";
			}  
			else if (strpos($row->page, 'updateState5') !== false) 
			{
				$result="Reject HCP Consultant Report Document";
			}  
			else if (strpos($row->page, 'updateState4') !== false) 
			{
				$result="Freeze HCP Consultant Report Document";
			}  
			else if (strpos($row->page, 'updateState3') !== false) 
			{
				$result="Reject HCP Consultant Report Document";
			}  
			else if (strpos($row->page, 'updateState2') !== false) 
			{
				$result="Review HCP Consultant Report Document";
			}  
			else if (strpos($row->page, 'updateState') !== false) 
			{
				if($row->id_user=='1')
				{
					$result="Request for Approval HCP Consultant Report Document";
				}
				else
				{		
					$result="Approved HCP Consultant Report Document";
				}	
			}  
			else if (strpos($row->page, 'access') !== false) 
			{
				$result="Open HCP Consultant Report Document from Email Notification";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==3)
				{	
					$result="Create HCP Consultant Report Document";
				}
				else
				{
					$result="Open HCP Consultant Report Document from Browser ";
				}					
			}			
		}		
		else if (strpos($row->page, 'HCPReport') !== false)
		{	
			if (strpos($row->page, 'upload') !== false) 
			{
				$result="Upload HCP Report Attachment";
			}  
			else if (strpos($row->page, 'add?') !== false) 
			{
				$result="Save / Submit / Approved / Reject / Review / Freeze";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="Delete HCP Report Attachment";
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result="Delete HCP Report Document";
			}  
			else if (strpos($row->page, 'updateState6') !== false) 
			{
				$result="Review HCP Report Document";
			}  
			else if (strpos($row->page, 'updateState5') !== false) 
			{
				$result="Reject HCP Report Document";
			}  
			else if (strpos($row->page, 'updateState4') !== false) 
			{
				$result="Freeze HCP Report Document";
			}  
			else if (strpos($row->page, 'updateState3') !== false) 
			{
				$result="Reject HCP Report Document";
			}  
			else if (strpos($row->page, 'updateState2') !== false) 
			{
				$result="Review HCP Report Document";
			}  
			else if (strpos($row->page, 'updateState') !== false) 
			{
				if($row->id_user=='1')
				{
					$result="Request for Approval HCP Report Document";
				}
				else
				{		
					$result="Approved HCP Report Document";
				}	
			}  
			else if (strpos($row->page, 'access') !== false) 
			{
				$result="Open HCP Report Document from Email Notification";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==3)
				{	
					$result="Create HCP Report Document";
				}
				else
				{
					$result="Open HCP Report Document from Browser ";
				}					
			}			
		}		
		else if (strpos($row->page, 'Scientific') !== false)
		{	
			if (strpos($row->page, 'upload') !== false) 
			{
				$result="Upload SERF Attachment";
			}  
			else if (strpos($row->page, 'add?') !== false) 
			{
				$result="Save / Submit / Approved / Reject / Review / Freeze";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="Delete SERF Attachment";
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result="Delete SERF Document";
			}  
			else if (strpos($row->page, 'updateState6') !== false) 
			{
				$result="Review SERF Document";
			}  
			else if (strpos($row->page, 'updateState5') !== false) 
			{
				$result="Reject SERF Document";
			}  
			else if (strpos($row->page, 'updateState4') !== false) 
			{
				$result="Freeze SERF Document";
			}  
			else if (strpos($row->page, 'updateState3') !== false) 
			{
				$result="Reject SERF Document";
			}  
			else if (strpos($row->page, 'updateState2') !== false) 
			{
				$result="Review SERF Document";
			}  
			else if (strpos($row->page, 'updateState') !== false) 
			{
				if($row->id_user=='1')
				{
					$result="Request for Approval SERF Document";
				}
				else
				{		
					$result="Approved SERF Document";
				}	
			}  
			else if (strpos($row->page, 'access') !== false) 
			{
				$result="Open SERF Document from Email Notification";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==2)
				{	
					$result="Create SERF Document";
				}
				else
				{
					$result="Open SERF Document from Browser";
				}					
			}			
		}		
		else if (strpos($row->page, 'HCP1') !== false)
		{	
			if (strpos($row->page, 'upload') !== false) 
			{
				$result="Upload HCP1 Attachment";
			}  
			else if (strpos($row->page, 'add?') !== false) 
			{
				$result="Save / Submit / Approved / Reject / Review / Freeze";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="Delete HCP1 Attachment";
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result="Delete HCP1 Document";
			}  
			else if (strpos($row->page, 'updateState6') !== false) 
			{
				$result="Review HCP1 Document";
			}  
			else if (strpos($row->page, 'updateState5') !== false) 
			{
				$result="Reject HCP1 Document";
			}  
			else if (strpos($row->page, 'updateState4') !== false) 
			{
				$result="Freeze HCP1 Document";
			}  
			else if (strpos($row->page, 'updateState3') !== false) 
			{
				$result="Reject HCP1 Document";
			}  
			else if (strpos($row->page, 'updateState2') !== false) 
			{
				$result="Review HCP1 Document";
			}  
			else if (strpos($row->page, 'updateState') !== false) 
			{
				if($row->id_user=='1')
				{
					$result="Request for Approval HCP1 Document";
				}
				else
				{		
					$result="Approved HCP1 Document";
				}	
			}  
			else if (strpos($row->page, 'access') !== false) 
			{
				$result="Open HCP1 Document from Email Notification";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==2)
				{	
					$result="Create HCP1 Document";
				}
				else
				{
					$result="Open HCP1 Document from Browser";
				}					
			}			
		}		
		else if (strpos($row->page, 'HCO') !== false)
		{	
			if (strpos($row->page, 'upload') !== false) 
			{
				$result="Upload HCO Attachment";
			}  
			else if (strpos($row->page, 'add?') !== false) 
			{
				$result="Save / Submit / Approved / Reject / Review / Freeze";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="Delete HCO Attachment";
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result="Delete HCO Document";
			}  
			else if (strpos($row->page, 'updateState6') !== false) 
			{
				$result="Review HCO Document";
			}  
			else if (strpos($row->page, 'updateState5') !== false) 
			{
				$result="Reject HCO Document";
			}  
			else if (strpos($row->page, 'updateState4') !== false) 
			{
				$result="Freeze HCO Document";
			}  
			else if (strpos($row->page, 'updateState3') !== false) 
			{
				$result="Reject HCO Document";
			}  
			else if (strpos($row->page, 'updateState2') !== false) 
			{
				$result="Review HCO Document";
			}  
			else if (strpos($row->page, 'updateState') !== false) 
			{
				if($row->id_user=='1')
				{
					$result="Request for Approval HCO Document";
				}
				else
				{		
					$result="Approved HCO Document";
				}	
			}  
			else if (strpos($row->page, 'access') !== false) 
			{
				$result="Open HCO Document from Email Notification";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==2)
				{	
					$result="Create HCO Document";
				}
				else
				{
					$result="Open HCO Document from Browser";
				}					
			}			
		}		
		else if (strpos($row->page, 'HCP2') !== false)
		{	
			if (strpos($row->page, 'upload') !== false) 
			{
				$result="Upload HCP2 Attachment";
			}  
			else if (strpos($row->page, 'add?') !== false) 
			{
				$result="Save / Submit / Approved / Reject / Review / Freeze";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="Delete HCP2 Attachment";
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result="Delete HCP2 Document";
			}  
			else if (strpos($row->page, 'updateState6') !== false) 
			{
				$result="Review HCP2 Document";
			}  
			else if (strpos($row->page, 'updateState5') !== false) 
			{
				$result="Reject HCP2 Document";
			}  
			else if (strpos($row->page, 'updateState4') !== false) 
			{
				$result="Freeze HCP2 Document";
			}  
			else if (strpos($row->page, 'updateState3') !== false) 
			{
				$result="Reject HCP2 Document";
			}  
			else if (strpos($row->page, 'updateState2') !== false) 
			{
				$result="Review HCP2 Document";
			}  
			else if (strpos($row->page, 'updateState') !== false) 
			{
				if($row->id_user=='1')
				{
					$result="Request for Approval HCP2 Document";
				}
				else
				{		
					$result="Approved HCP2 Report Document";
				}	
			}  
			else if (strpos($row->page, 'access') !== false) 
			{
				$result="Open HCP2 Document from Email Notification";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==3)
				{	
					$result="Create HCP2 Document";
				}
				else
				{
					$result="Open HCP2 Document from Browser";
				}					
			}			
		}		
		else if (strpos($row->page, 'HCP') !== false)
		{	
			if (strpos($row->page, 'upload') !== false) 
			{
				$result="Upload HCP Consultant Attachment";
			}  
			else if (strpos($row->page, 'add?') !== false) 
			{
				$result="Save / Submit / Approved / Reject / Review / Freeze";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="Delete HCP Consultant Attachment";
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result="Delete HCP Consultant Document";
			}  
			else if (strpos($row->page, 'updateState6') !== false) 
			{
				$result="Review HCP Consultant Document";
			}  
			else if (strpos($row->page, 'updateState5') !== false) 
			{
				$result="Reject HCP Consultant Document";
			}  
			else if (strpos($row->page, 'updateState4') !== false) 
			{
				$result="Freeze HCP Consultant Document";
			}  
			else if (strpos($row->page, 'updateState3') !== false) 
			{
				$result="Reject HCP Consultant Document";
			}  
			else if (strpos($row->page, 'updateState2') !== false) 
			{
				$result="Review HCP Consultant Document";
			}  
			else if (strpos($row->page, 'updateState') !== false) 
			{
				if($row->id_user=='1')
				{
					$result="Request for Approval HCP Consultant Document";
				}
				else
				{		
					$result="Approved HCP Consultant Document";
				}	
			}  
			else if (strpos($row->page, 'access') !== false) 
			{
				$result="Open HCP Consultant Document from Email Notification";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==2)
				{	
					$result="Create HCP Consultant Document";
				}
				else
				{
					$result="Open HCP Consultant Document from Browser";
				}					
			}			
		}		
		else if (strpos($row->page, 'MER') !== false)
		{	
			if (strpos($row->page, 'type') !== false) 
			{
				$result="Save / Submit / Approved / Reject / Review / Freeze MER";
			}  
			else if (strpos($row->page, 'add?') !== false) 
			{
				$result="Save / Submit / Approved / Reject / Review / Freeze MER";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="Upload MER Attachment";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="Delete MER Attachment";
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result="Delete MER Document";
			}  
			else if (strpos($row->page, 'updateState6') !== false) 
			{
				$result="Review MER Document";
			}  
			else if (strpos($row->page, 'updateState5') !== false) 
			{
				$result="Reject MER Document";
			}  
			else if (strpos($row->page, 'updateState4') !== false) 
			{
				$result="Freeze MER Document";
			}  
			else if (strpos($row->page, 'updateState3') !== false) 
			{
				$result="Reject MER Document";
			}  
			else if (strpos($row->page, 'updateState2') !== false) 
			{
				$result="Review MER Document";
			}  
			else if (strpos($row->page, 'updateState') !== false) 
			{
				if($row->id_user=='1')
				{
					$result="Request for Approval MER Document";
				}
				else
				{		
					$result="Approved MER Document";
				}	
			}  
			else if (strpos($row->page, 'access') !== false) 
			{
				$result="Open MER Document from Email Notification";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==1)
				{	
					$result="Create MER Document";
				}
				else
				{
					$result="Open MER Document from Browser";
				}					
//				$result="Open MER Document from Browser";
			}			
		}	
		else if (strpos($row->page, 'Login') !== false)
		{	
			if (strpos($row->page, 'login?') !== false) 
			{
				$result="Login";
			}  
			else if (strpos($row->page, 'logout?') !== false) 
			{
				$result="Logout";
			}  
		}
		return $result;
    }

    public function _callback_date($value, $row)
    {
		return $value;
	}

    /*public function _callback_ip($value, $row)
    {

		$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $value)); 
		   
		//echo 'Country Name: ' . $ipdat->geoplugin_countryName . "\n"; 
		//echo 'City Name: ' . $ipdat->geoplugin_city . "\n"; 
		//echo 'Continent Name: ' . $ipdat->geoplugin_continentName . "\n"; 
		//echo 'Latitude: ' . $ipdat->geoplugin_latitude . "\n"; 
		//echo 'Longitude: ' . $ipdat->geoplugin_longitude . "\n"; 
		//echo 'Currency Symbol: ' . $ipdat->geoplugin_currencySymbol . "\n"; 
		//echo 'Currency Code: ' . $ipdat->geoplugin_currencyCode . "\n"; 
		//echo 'Timezone: ' . $ipdat->geoplugin_timezone;
		
		return $value." - ".$ipdat->geoplugin_city." - ".$ipdat->geoplugin_countryName;
	}*/

    public function _callback_nodoc($value, $row)
    {
		$result="";
		$result2=array();

		if (strpos($row->page, 'ScientificReport') !== false)
		{	
			if (strpos($row->page, 'updateState') !== false || strpos($row->page, 'updateState2') !== false || strpos($row->page, 'updateState3') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[4];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc2, created_date FROM scientific_report WHERE id_report=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/R-SERF/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc2, created_date FROM scientific_report WHERE id_report=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/R-SERF/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==3)
				{	
					$result = $result2[1];
					$result3 = explode("&", $result);
					$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result3[0]);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
					}
				}
				else
				{
					$result = $result2[2];
					$result3 = explode("&", $result);
					$query = $this->db->query("SELECT nodoc2, created_date FROM scientific_report WHERE id_report=".$result3[0]);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/R-SERF/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
					}
				}					
				$result = $nodoc;
			}				
		}
		else if (strpos($row->page, 'HCOReport') !== false)
		{	
			if (strpos($row->page, 'updateState') !== false || strpos($row->page, 'updateState2') !== false || strpos($row->page, 'updateState3') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[4];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc2, created_date FROM hco_report WHERE id_report=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/R-HCO/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc2, created_date FROM hco_report WHERE id_report=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/R-HCO/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==3)
				{	
					$result = $result2[1];
					$result3 = explode("&", $result);
					$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result3[0]);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
					}
				}
				else
				{
					$result = $result2[2];
					$result3 = explode("&", $result);
					$query = $this->db->query("SELECT nodoc2, created_date FROM hco_report WHERE id_report=".$result3[0]);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/R-HCO/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
					}
				}					
				$result = $nodoc;
			}				
		}
		else if (strpos($row->page, 'HCPReport2') !== false)
		{	
			if (strpos($row->page, 'updateState') !== false || strpos($row->page, 'updateState2') !== false || strpos($row->page, 'updateState3') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[4];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc2, created_date FROM hcp_report2 WHERE id_report=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/R-HCPC/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc2, created_date FROM hcp_report2 WHERE id_report=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/R-HCPC/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==3)
				{	
					$result = $result2[1];
					$result3 = explode("&", $result);
					$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result3[0]);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
					}
				}
				else
				{
					$result = $result2[2];
					$result3 = explode("&", $result);
					$query = $this->db->query("SELECT nodoc2, created_date FROM hcp_report2 WHERE id_report=".$result3[0]);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/R-HCPC/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
					}
				}					
				$result = $nodoc;
			}				
		}
		else if (strpos($row->page, 'HCPReport') !== false)
		{	
			if (strpos($row->page, 'updateState') !== false || strpos($row->page, 'updateState2') !== false || strpos($row->page, 'updateState3') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[4];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc2, created_date FROM hcp_report WHERE id_report=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/R-HCP/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc2, created_date FROM hcp_report WHERE id_report=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/R-HCP/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else
			{
				$nodoc="";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==3)
				{	
					$result = $result2[1];
					$result3 = explode("&", $result);
					$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result3[0]);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
					}
				}
				else
				{
					$result = $result2[2];
					$result3 = explode("&", $result);
					$query = $this->db->query("SELECT nodoc2, created_date FROM hcp_report WHERE id_report=".$result3[0]);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/R-HCP/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
					}
				}					
				$result = $nodoc;
			}				
		}
		else if (strpos($row->page, 'Scientific') !== false)
		{	
			if (strpos($row->page, 'updateState') !== false || strpos($row->page, 'updateState2') !== false || strpos($row->page, 'updateState3') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[3];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc, created_date FROM scientific WHERE id_sc=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/SERF/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc, created_date FROM scientific WHERE id_sc=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/SERF/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==2)
				{	
					$result = $result2[1];
					$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
					}
				}
				else
				{
					//$nodoc = $row->page; 	
					$result = $result2[2];
					$result3 = explode("&", $result);
					$query = $this->db->query("SELECT nodoc, created_date FROM scientific WHERE id_sc=".$result3[0]);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/SERF/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
					}
				}					
				$result = $nodoc;
			}				
		}
		else if (strpos($row->page, 'HCO') !== false)
		{	
			if (strpos($row->page, 'updateState') !== false || strpos($row->page, 'updateState2') !== false || strpos($row->page, 'updateState3') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[3];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc2, created_date FROM hco WHERE id_hco=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/HCO/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc2, created_date FROM hco WHERE id_hco=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/HCO/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==2)
				{	
					$result = $result2[1];
					$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
					}
				}
				else
				{
					$result = $result2[2];
					$result3 = explode("&", $result);			
					$query = $this->db->query("SELECT nodoc2, created_date FROM hco WHERE id_hco=".$result3[0]);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/HCO/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
					}
				}					
				$result = $nodoc;
			}				
		}
		else if (strpos($row->page, 'HCP1') !== false)
		{	
			if (strpos($row->page, 'updateState') !== false || strpos($row->page, 'updateState2') !== false || strpos($row->page, 'updateState3') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[3];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc2, created_date FROM hcp1 WHERE id_hcp1=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/HCP1/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc2, created_date FROM hcp1 WHERE id_hcp1=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/HCP1/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==2)
				{	
					$result = $result2[1];
					$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
					}
				}
				else
				{
					$result = $result2[2];
					$result3 = explode("&", $result);			
					$query = $this->db->query("SELECT nodoc2, created_date FROM hcp1 WHERE id_hcp1=".$result3[0]);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/HCP1/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
					}
				}					
				$result = $nodoc;
			}				
		}
		else if (strpos($row->page, 'HCP2') !== false)
		{	
			if (strpos($row->page, 'updateState') !== false || strpos($row->page, 'updateState2') !== false || strpos($row->page, 'updateState3') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[3];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc2, created_date FROM hcp2 WHERE id_hcp2=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/HCP2/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc2, created_date FROM hcp2 WHERE id_hcp2=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/HCP2/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==3)
				{	
					$result = $result2[2];
					$query = $this->db->query("SELECT nodoc2, created_date FROM hcp1 WHERE id_hcp1=".$result);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/HCP1/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
					}
				}
				else
				{
					$result = $result2[3];
					$query = $this->db->query("SELECT nodoc2, created_date FROM hcp2 WHERE id_hcp1=".$result);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/HCP2/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
					}
				}					
				$result = $nodoc;
			}				
		}
		else if (strpos($row->page, 'HCP') !== false)
		{	
			if (strpos($row->page, 'updateState') !== false || strpos($row->page, 'updateState2') !== false || strpos($row->page, 'updateState3') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[3];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc2, created_date FROM hcp WHERE id_hcp=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/HCPC/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc2, created_date FROM hcp WHERE id_hcp=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/HCPC/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else
			{
				$nodoc = "";
				$result2=explode("=", $row->page);
				if(sizeof($result2)==2)
				{	
					$result = $result2[1];
					$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
					}
				}
				else
				{
					$result = $result2[2];
					$result3 = explode("&", $result);			
					$query = $this->db->query("SELECT nodoc2, created_date FROM hcp WHERE id_hcp=".$result3[0]);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/HCPC/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
					}
				}					
				$result = $nodoc;
			}				
		}
		else if (strpos($row->page, 'MER') !== false)
		{	

			if (strpos($row->page, 'type') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = str_replace('&type','',$result2[1]);
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState6') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState5') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState4') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState3') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState2') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[2];
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'access') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = str_replace('&access','',$result2[1]);
				$nodoc = "";
				$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else
			{
				$result2=explode("=", $row->page);
				if(sizeof($result2)==1)
				{	
					$nodoc = "";
				}
				else
				{	
					$result = $result2[1];
					$nodoc = "";
					$query = $this->db->query("SELECT nodoc, created_date FROM mer WHERE id_mer=".$result);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
					}
				}	
				$result = $nodoc;
			}			
		}	
		else if (strpos($row->page, 'EventReport') !== false)
		{	

			if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState6') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState5') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState4') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState3') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState2') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[2];
				$nodoc = "";
				$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'access') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = str_replace('&access','',$result2[1]);
				$nodoc = "";
				$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else
			{
				$result2=explode("=", $row->page);
				if(sizeof($result2)==2)
				{	
					$nodoc = "";
				}
				else
				{	
					$result = $result2[1];
					$nodoc = "";
					$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
					}
				}	
				$result = $nodoc;
			}			
		}	
		else if (strpos($row->page, 'Event') !== false)
		{	

			if (strpos($row->page, 'add') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'upload') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'deleteAttachment') !== false) 
			{
				$result="";
			}  
			else if (strpos($row->page, 'delete') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState6') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState5') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState4') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState3') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState2') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[1];
				$nodoc = "";
				$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'updateState') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = $result2[2];
				$nodoc = "";
				$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else if (strpos($row->page, 'access') !== false) 
			{
				$result2=explode("=", $row->page);
				$result = str_replace('&access','',$result2[1]);
				$nodoc = "";
				$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
				foreach ($query->result() as $row2)
				{			
					$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
				}
				$result = $nodoc;
			}  
			else
			{
				$result2=explode("=", $row->page);
				if(sizeof($result2)==1)
				{	
					$nodoc = "";
				}
				else
				{	
					$result = $result2[1];
					$nodoc = "";
					$query = $this->db->query("SELECT created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$result);
					foreach ($query->result() as $row2)
					{			
						$nodoc = date("Y",strtotime($row2->created_date))."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
					}
				}	
				$result = $nodoc;
			}			
		}	
		else if (strpos($row->page, 'Login') !== false)
		{	
			$result = "";
		}
		
		return $result;
    }

}
