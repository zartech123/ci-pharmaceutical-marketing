<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EventReportList extends CI_Controller {

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
		$this->load->view('eventreportlist',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('event_report');
			$crud->set_subject('Event Report OTC');
            $crud->columns('action2','nodoc','id_event','participant_actual','booth_actual','booth_date','trophy_actual','trophy_date','spg_actual','transportation_actual','transportation_date','gimmick_actual','sample_actual','state');
            $crud->set_relation('id_event','event_otc','event_name');
			$crud->where('jdc00106c.state','6');

			if($this->session->userdata('id_group')==15 || $this->session->userdata('id_group')==10)
			{
				$id_event = "0";
				$query = $this->db->query("select id_event from event_otc where requested_by='".$this->session->userdata('id_user')."'");
				foreach ($query->result() as $row2)
				{
					$id_event = $id_event.",".$row2->id_event;					
				}
				if($id_event!="0")
				{
					$crud->where('jdc00106c.id_event in ('.$id_event.')');
				}	
			}				
			if($this->session->userdata('id_group')==22 || $this->session->userdata('id_group')==23 || $this->session->userdata('id_group')==25)
			{
				$id_event = "0";
				$query = $this->db->query("select id_event from event_pic where id_user='".$this->session->userdata('id_user')."'");
				foreach ($query->result() as $row2)
				{
					$id_event = $id_event.",".$row2->id_event;					
				}
				if($id_event!="0")
				{
					$crud->where('jdc00106c.id_event in ('.$id_event.')');
				}	
			}				
			if($this->session->userdata('id_group')==19)
			{
				$id_regency = 0;
				$query = $this->db->query("select id_regency from user where id_user='".$this->session->userdata('id_user')."'");
				foreach ($query->result() as $row2)
				{
					$id_regency = $row2->id_regency;					
				}
				$crud->where('id_product_group='.$id_regency);
			}				
			if($this->session->userdata('id_group')==20)
			{
				$id_event = "0";
				$query = $this->db->query("select id_event from area_event a, event_otc b where a.id_area=b.id_area and (id_user like '".$this->session->userdata('id_user').",%' or id_user like '%,".$this->session->userdata('id_user')."' or id_user like '%,".$this->session->userdata('id_user').",%' or id_user='".$this->session->userdata('id_user')."')");				
				foreach ($query->result() as $row2)
				{
					$id_event = $id_event.",".$row2->id_event;					
				}
				if($id_event!="0")
				{
					$crud->where('jdc00106c.id_event in ('.$id_event.')');
				}	
			}
			$crud->unset_add();
			$crud->unset_edit();
			$crud->unset_delete();
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_clone();
            $crud->order_by('year, nodoc','desc');
			$crud->field_type('state','dropdown',array('1' => 'Prepared','2' => 'Final', '6' => 'Approved', '7' => 'Rejected'));			
			$crud->display_as('id_event','Event Name');
			$crud->display_as('participant_actual','Participant');
			$crud->display_as('booth_actual','Booth (IDR)');
			$crud->display_as('booth_date','Booth (Date Transfer)');
			$crud->display_as('trophy_actual','Jumlah Trophy');
			$crud->display_as('trophy_date','Trophy (Date Transfer)');
			$crud->display_as('spg_actual','Jumlah SPG');
			$crud->display_as('nodoc','Event Report OTC');
			$crud->display_as('gimmick_actual','Jumlah Gimmick');
			$crud->display_as('sample_actual','Jumlah Sample');
			$crud->display_as('transportation_actual','Transportation (IDR)');
			$crud->display_as('transportation_date','Transportation (Date Transfer)');
			$crud->display_as('action','');
			$crud->display_as('action2','');
            $crud->callback_column('nodoc',array($this,'_callback_nodoc'));
            $crud->callback_column('action2',array($this,'_callback_action2'));
            $crud->callback_column('booth_date',array($this,'_callback_date'));
            $crud->callback_column('trophy_date',array($this,'_callback_date'));
            $crud->callback_column('transportation_date',array($this,'_callback_date'));

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

    public function _callback_action2($value, $row)
    {
        $button="";

        $name="eventreport".$row->id_report;
        $button=$button."<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/EventReport?id_event=".$row->id_event."&id=".$row->id_report."'><i class='fa fa-pencil'></i>&nbsp;Edit</a>&nbsp;";

        return $button;
    }

    public function _callback_nodoc($value, $row)
    {

		$result="";
//		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, nodoc FROM event_report WHERE id_report=".$row->id_report);
		$query = $this->db->query("SELECT DATE_FORMAT(a.created_date,'%d-%M-%Y') as created_date, a.nodoc, code FROM event_otc a, product_group b, event_report c WHERE a.id_event=c.id_event and a.id_product_group=id_group and id_report=".$row->id_report);
		foreach ($query->result() as $row2)
		{			
			$result = substr($row2->created_date,-4)."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
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
			else if($row->state=="7")
			{
				$span_start="<button class='btn btn-danger btn-xs'>";
				$span_end="</button>";
			}				
			else if($row->review=="1")
			{
				$span_start="<button class='btn btn-primary btn-xs'>";
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

	public function _callback_date($value, $row)
	{
		return $value;
	}

}
