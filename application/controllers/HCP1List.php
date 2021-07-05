<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HCP1List extends CI_Controller {

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
		$this->load->view('hcp1list',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('hcp1');
			$crud->set_subject('HCP SPONSORSHIP REQUEST FORM 1');
			$crud->columns('action2','id_mer','nodoc2','event_name','event_organizer','event_venue','event_institution','event_start_date','event_end_date','state','requested_by','action');
			$crud->set_relation('event_institution','hospital','{name} - {address}');
            $crud->set_relation('requested_by','user','name');
			$crud->order_by('state');
			if($this->session->userdata('id_group')==8 || $this->session->userdata('id_group')==10)
			{
				$crud->where('requested_by='.$this->session->userdata('id_user').' or requested_by in (select id_user from user where id_department='.$this->session->userdata('id_user').')');
			}				
			if($this->session->userdata('id_group')==9)
			{
				$crud->where('requested_by='.$this->session->userdata('id_user'));
			}				
			$crud->unset_add();
			$crud->unset_edit();
			$crud->unset_delete();
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_clone();
			$crud->field_type('state','dropdown',array('1' => 'Prepared', '2' => 'Pending PM Approval', '6' => 'Approved', '7' => 'Rejected'));			
			$crud->callback_column('event_start_date',array($this,'callback_date'));
			$crud->callback_column('event_end_date',array($this,'callback_date'));
			$crud->display_as('id_mer','MER');
			$crud->display_as('nodoc2','HCP SRF 1');
			$crud->display_as('event_name','Event Name');
			$crud->display_as('event_start_date','Start Date');
			$crud->display_as('event_end_date','End Date');
			$crud->display_as('event_organizer','Event Organizer');
			$crud->display_as('event_venue','Event Venue');
			$crud->display_as('event_institution','Institution');
			$crud->display_as('action','');
			$crud->display_as('action2','');		
            $crud->callback_column('action',array($this,'_callback_action'));
            $crud->callback_column('action2',array($this,'_callback_action2'));
            $crud->callback_column('nodoc2',array($this,'_callback_nodoc2'));
            $crud->callback_column('id_mer',array($this,'_callback_nodoc'));
            $crud->callback_column('event_start_date',array($this,'_callback_date'));
            $crud->callback_column('event_end_date',array($this,'_callback_date'));

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


    public function _callback_nodoc2($value, $row)
    {
		$result="";
		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, nodoc2 FROM hcp1 WHERE id_hcp1=".$row->id_hcp1);
		foreach ($query->result() as $row2)
		{			
			$result = substr($row2->created_date,-4)."/HCP1/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
		}

		if($row->active=="0")
		{
			$span_start="<button class='btn btn-secondary btn-xs'>";
			$span_end="</button>";
		}
		else
		{
			if($row->state=="6")
			{ 
				$span_start="<button class='btn btn-success btn-xs'>";
				$span_end="</button>";
			}
			else if($row->state=="8")
			{
				$span_start="<button class='btn btn-danger btn-xs'>";
				$span_end="</button>";
			}				
			else
			{
				$span_start="<button class='btn btn-warning btn-xs'>";
				$span_end="</button>";
			}				
		}			
        return $span_start.$result.$span_end;
    }

    public function _callback_nodoc($value, $row)
    {
		$result="";
		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, nodoc FROM mer WHERE id_mer=".$row->id_mer);
		foreach ($query->result() as $row2)
		{			
			$result = substr($row2->created_date,-4)."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
		}

        return $result;
    }

	public function callback_date($value, $row)
	{
		return date('Y-m-d',strtotime($value));
	}

    public function _callback_action($value, $row)
    {
		$button="";

		$jumlah = 0;
		$query = $this->db->query("SELECT id_hcp2 from hcp2 WHERE state<7 and id_hcp1=".$row->id_hcp1);
		foreach ($query->result() as $row2)
		{			
			$jumlah = $jumlah + 1;	
		}

		if($row->state=="Approved")
		{
			$id_user = $this->session->userdata('id_user').",";
			$query2 = $this->db->query("select id_user from user where id_department='".$this->session->userdata('id_user')."'");
			foreach ($query2->result() as $row3)
			{
				$id_user=	$id_user.$row3->id_user.",";				
			}

			$query = $this->db->query("SELECT id_mer, hcp from hcp1 WHERE id_hcp1=".$row->id_hcp1);
			foreach ($query->result() as $row2)
			{							
				if($jumlah<$row2->hcp)
				{	
					if(($this->session->userdata('id_group')==8 || $this->session->userdata('id_group')==9 || $this->session->userdata('id_group')==10) && strpos($id_user, $row->requested_by)!==false)
					{	
						$button="<a type='button' id='create' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/HCP2?id_mer=".$row2->id_mer."&id_hcp1=".$row->id_hcp1."'><i class='fa fa-plus'></i>&nbsp;&nbsp;HCP SRF 2</a>";
					}	
					else if($this->session->userdata('id_group')!=8 && $this->session->userdata('id_group')!=9 && $this->session->userdata('id_group')!=10)
					{
						$button="<a type='button' id='create' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/HCP2?id_mer=".$row2->id_mer."&id_hcp1=".$row->id_hcp1."'><i class='fa fa-plus'></i>&nbsp;&nbsp;HCP SRF 2</a>";
					}
				}	
			}	
		}
		else
		{
			$button="";
		}	

        return $button;
    }

    public function _callback_action2($value, $row)
    {

        $name="hcp1".$row->id_hcp1;
		$button="";

		$id_user = $this->session->userdata('id_user').",";
		$query2 = $this->db->query("select id_user from user where id_department='".$this->session->userdata('id_user')."'");
		foreach ($query2->result() as $row3)
		{
			$id_user=	$id_user.$row3->id_user.",";				
		}

		if(($this->session->userdata('id_group')==8 || $this->session->userdata('id_group')==9 || $this->session->userdata('id_group')==10) && strpos($id_user, $row->requested_by)!==false)
		{	
			$button="<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/HCP1?id_mer=".$row->id_mer."&id=".$row->id_hcp1."'><i class='fa fa-pencil'></i>&nbsp;Edit</a>&nbsp;";
		}	
		else if($this->session->userdata('id_group')!=8 && $this->session->userdata('id_group')!=9 && $this->session->userdata('id_group')!=10)
		{
			$button="<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/HCP1?id_mer=".$row->id_mer."&id=".$row->id_hcp1."'><i class='fa fa-pencil'></i>&nbsp;Edit</a>&nbsp;";
		}			



		$no = substr($row->created_date,0,4)."/HCP1/".date("m",strtotime($row->created_date))."/".$row->nodoc2;
		$url = base_url()."index.php/HCP1/delete?id=".$row->id_hcp1;

		if($row->state==1 && ($this->session->userdata('id_group')==11 || $this->session->userdata('id_group')==12))
		{
//			$button=$button."<a type='button' id='".$name."' class='btn btn-danger btn-xs' target='popup' onclick=window.open('".base_url()."index.php/HCP1/delete?id=".$row->id_hcp1."','popup','width=300,height=100')><i class='fa fa-trash'></i>&nbsp;Delete</a><br>";
			$button=$button."<a href='#basicModal' class='btn btn-default btn-xs' data-toggle='modal' data-url='$url' data-id='$no' data-target='#basicModal'><i class='fa fa-trash'></i>&nbsp;Delete</a>";
		}	

		if($row->state==6 && $this->session->userdata('id_group')==6)
		{
			$name="hcp12-".$row->id_hcp1;
			$url = base_url()."index.php/HCP1/UpdateState5?id=".$row->id_hcp1;
//			$button=$button."<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/MER/UpdateState5?id=".$row->id_mer."'>&nbsp;Reject&nbsp;";
			$button=$button."<a href='#basicModal2' class='btn btn-default btn-xs' data-toggle='modal' data-url='$url' data-id='$no' data-target='#basicModal2'><i class='fa fa-trash'></i>&nbsp;Reject</a>";
			$name="hcp13-".$row->id_hcp1;
			$url = base_url()."index.php/HCP1/UpdateState6?id=".$row->id_hcp1;
//			$button=$button."<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/MER/UpdateState6?id=".$row->id_mer."'>&nbsp;Review&nbsp;";
			$button=$button."<a href='#basicModal3' class='btn btn-default btn-xs' data-toggle='modal' data-url='$url' data-id='$no' data-target='#basicModal3'><i class='fa fa-trash'></i>&nbsp;Review</a>";
		}			

		return $button;
    }

	public function _callback_date($value, $row)
	{
		return date('d M Y', strtotime($value));
	}
}
