<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MER2List extends CI_Controller {

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
		$this->load->view('mer2list',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('mer');
            $crud->columns('action2','nodoc','event_name','event_organizer','event_venue','event_start_date','event_end_date','type','state','review','action');
			$crud->set_subject('MASTER EVENT REQUEST FORM');
            $crud->order_by('year, nodoc');
			$crud->unset_add();
			$crud->unset_edit();
			$crud->unset_delete();
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_clone();
			$crud->field_type('type','dropdown',array('1' => 'ThirdParty', '2' => 'TPI'));			
			$crud->field_type('review','dropdown',array('0' => '', '1' => 'Yes'));			
			$crud->field_type('state','dropdown',array('1' => 'Prepared', '2' => 'Pending Medical Review', '3' => 'Pending CS Section Head Review', '4' => 'Pending Business Operation Review', '5' => 'Pending Commercial Director Approval', '6' => 'Pending President Director Approval', '7' => 'Approved', '8' => 'Rejected'));
			$crud->callback_column('event_start_date',array($this,'callback_date'));
			$crud->callback_column('event_end_date',array($this,'callback_date'));
			$crud->display_as('review','Re-Submitted');
			$crud->display_as('nodoc','MER');
			$crud->display_as('event_name','Event Name');
			$crud->display_as('event_start_date','Start Date');
			$crud->display_as('event_end_date','End Date');
			$crud->display_as('event_name','Event Name');
			$crud->display_as('event_organizer','Event Organizer');
			$crud->display_as('event_venue','Event Venue');
			$crud->display_as('action','');
			$crud->display_as('action2','');

            $crud->callback_column('action',array($this,'_callback_action'));
            $crud->callback_column('action2',array($this,'_callback_action2'));
            $crud->callback_column('nodoc',array($this,'_callback_nodoc'));
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


	public function callback_date($value, $row)
	{
		return date('Y-m-d',strtotime($value));
	}

    public function _callback_action($value, $row)
    {
		$button="";
		if($row->type=="ThirdParty" && $row->state=="Approved" && $row->is_open=="1")
		{
			$name="hcp1-".$row->id_mer;
			$name2="hcp-".$row->id_mer;
			$button="<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/HCP1?id_mer=".$row->id_mer."'><i class='fa fa-plus'></i>&nbsp;&nbsp;HCP SRF 1</a>";

			$jumlah2 = 0;
			$query = $this->db->query("SELECT count(*) as jumlah FROM hcp WHERE id_mer=".$row->id_mer);
			foreach ($query->result() as $row2)
			{			
				$jumlah2 = $row2->jumlah;
			}
			if($jumlah2==0)
			{	
				$button=$button."&nbsp;<a type='button' id='".$name2."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/HCP?id_mer=".$row->id_mer."'><i class='fa fa-plus'></i>&nbsp;&nbsp;HCP Consultant</a>";
			}	

			$jumlah = 0;
			$query = $this->db->query("SELECT count(*) as jumlah FROM budget_mer WHERE id_parent=".$row->id_mer." AND amount>0 AND (sponsor_type LIKE 'Booth%' or sponsor_type LIKE 'Symposium%') ");
			foreach ($query->result() as $row2)
			{			
				$jumlah = $row2->jumlah;
			}
//			if($jumlah>0)
			{
				$name="hco-".$row->id_mer;
				$button=$button."&nbsp;<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/HCO?id_mer=".$row->id_mer."'><i class='fa fa-plus'></i>&nbsp;&nbsp;HCO</a>";
			}	
		}
		else if($row->type=="TPI" && $row->state=="Approved" && $row->is_open=="1")
		{
			if($row->state=="Approved")
			{ 
	 			$name="sc-".$row->id_mer;
				$button="<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/Scientific?id_mer=".$row->id_mer."'><i class='fa fa-plus'></i>&nbsp;&nbsp;SERF</a>";
			}	
		}			

        return $button;
    }

    public function _callback_nodoc($value, $row)
    {
		$result="";
		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, nodoc FROM mer WHERE id_mer=".$row->id_mer);
		foreach ($query->result() as $row2)
		{			
			$result = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
		}

		if($row->active=="0")
		{
			$span_start="<button class='btn btn-secondary btn-xs'>";
			$span_end="</button>";
		}
		else
		{
			if($row->state=="7")
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

    public function updateState()	
    {
		$this->db->set('is_open', $_GET['val'], FALSE);
		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("mer");		
	}

    public function _callback_action2($value, $row)
    {
        $name="mer".$row->id_mer;
		$button = "";
		if($this->session->userdata('id_group')<=7 || $this->session->userdata('id_group')==10 || $this->session->userdata('id_group')==11 || $this->session->userdata('id_group')==12 || $this->session->userdata('id_group')==14 || $this->session->userdata('id_group')==18)
		{	
			$button="<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/MER?id=".$row->id_mer."'><i class='fa fa-pencil'></i>&nbsp;Edit</a>";
		}	

		$no = substr($row->created_date,0,4)."/MER/".date("m",strtotime($row->created_date))."/".$row->nodoc;

		if($row->state==1 && ($this->session->userdata('id_group')==11 || $this->session->userdata('id_group')==12))
		{
			$url = base_url()."index.php/MER/delete?id=".$row->id_mer;
			$button=$button."<a href='#basicModal' class='btn btn-default btn-xs' data-toggle='modal' data-url='$url' data-id='$no' data-target='#basicModal'><i class='fa fa-trash'></i>&nbsp;Delete</a>";
		}	

		if($row->state==7 && ($this->session->userdata('id_group')==11 || $this->session->userdata('id_group')==12))
		{
			$button=$button."&nbsp;<select class='input-sm' id='select".$row->id_mer."' style='width:70px;font-size:9px;height:24px;'>";
			if($row->is_open=="1")
			{
			  $button=$button."<option value='0'>Close</option>
			  <option value='1' selected>Open</option>";
			}
			else
			{
			  $button=$button."<option value='0' selected>Close</option>
			  <option value='1'>Open</option>";
			}				
			$button=$button."</select>";
		}	

        $amount = "0";
		$query = $this->db->query("SELECT sum(replace(amount,'.','')*replace(description,'.','')) as amount from budget_mer where id_parent='".$row->id_mer."'");
		foreach ($query->result() as $row2)
		{
            $amount = number_format($row2->amount,2);
		}
		$amount = str_replace(".00","",$amount);

		if($row->state==7 && $amount<=100000000 && ($this->session->userdata('id_group')==18 || $this->session->userdata('id_group')==3))
		{
			$name="mer2-".$row->id_mer;
			$url = base_url()."index.php/MER/UpdateState5?id=".$row->id_mer;
//			$button=$button."<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/MER/UpdateState5?id=".$row->id_mer."'>&nbsp;Reject&nbsp;";
			$button=$button."<a href='#basicModal2' class='btn btn-default btn-xs' data-toggle='modal' data-url='$url' data-id='$no' data-target='#basicModal2'><i class='fa fa-trash'></i>&nbsp;Reject</a>";
			$name="mer3-".$row->id_mer;
			$url = base_url()."index.php/MER/UpdateState6?id=".$row->id_mer;
//			$button=$button."<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/MER/UpdateState6?id=".$row->id_mer."'>&nbsp;Review&nbsp;";
			$button=$button."<a href='#basicModal3' class='btn btn-default btn-xs' data-toggle='modal' data-url='$url' data-id='$no' data-target='#basicModal3'><i class='fa fa-trash'></i>&nbsp;Review</a>";
		}			

		if($row->state==7 && $amount>100000000 && ($this->session->userdata('id_group')==18 || $this->session->userdata('id_group')==2))
		{
			$name="mer2-".$row->id_mer;
//			$button=$button."<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/MER/UpdateState5?id=".$row->id_mer."'>&nbsp;Reject&nbsp;";
			$url = base_url()."index.php/MER/UpdateState5?id=".$row->id_mer;
			$button=$button."<a href='#basicModal2' class='btn btn-default btn-xs' data-toggle='modal' data-url='$url' data-id='$no' data-target='#basicModal2'><i class='fa fa-trash'></i>&nbsp;Reject</a>";
			$name="mer3-".$row->id_mer;
			$url = base_url()."index.php/MER/UpdateState6?id=".$row->id_mer;
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
