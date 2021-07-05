<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EventList extends CI_Controller {

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
		$this->load->view('eventlist',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('event_otc');
			$crud->set_subject('Event OTC');
            $crud->columns('action2','nodoc','id_product_group','event_name','event_date','location','id_area','bundling','participant_est','booth_est','trophy','trophy_est','spg','transportation_est','gimmick','other','sample_est','sales_est','state','action');
            $crud->set_relation('id_product_group','product_group','name');
            $crud->set_relation('id_area','area_event','{name} - {province}');
			$crud->unset_add();
			if($this->session->userdata('id_group')==15 || $this->session->userdata('id_group')==10)
			{
				$crud->where('requested_by='.$this->session->userdata('id_user'));
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
					$crud->where('id_event in ('.$id_event.')');
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
				$crud->where('state=6 and id_event not in (select id_event from event_report)');
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
					$crud->where('id_event in ('.$id_event.')');
				}	
			}
            $crud->order_by('year, nodoc','desc');
			$crud->unset_edit();
			$crud->unset_delete();
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_clone();
			$crud->field_type('state','dropdown',array('1' => 'Prepared','2' => 'Pending Product Manager OTC Review', '6' => 'Approved', '7' => 'Rejected'));			
			$crud->field_type('bundling','dropdown',array('0' => 'NO','1' => 'YES'));			
			$crud->display_as('event_name','Event Name');
			$crud->display_as('event_date','Event Date');
			$crud->display_as('id_area','Area');
			$crud->display_as('participant_est','Participant');
			$crud->display_as('id_product_group','Product Group');
			$crud->display_as('booth_est','Booth (IDR)');
			$crud->display_as('trophy','Jumlah Trophy');
			$crud->display_as('other','Biaya Lain (IDR)');
			$crud->display_as('trophy_est','Trophy (IDR)');
			$crud->display_as('spg','SPG (IDR)');
			$crud->display_as('nodoc','Event OTC');
			$crud->display_as('gimmick','Gimmick (IDR)');
			$crud->display_as('sample_est','Jumlah Sample');
			$crud->display_as('sales_est','Estimasi Penjualan (IDR)');
			$crud->display_as('transportation_est','Transportation (IDR)');
			$crud->display_as('action','');
			$crud->display_as('action2','');
            $crud->callback_column('nodoc',array($this,'_callback_nodoc'));
            $crud->callback_column('spg',array($this,'_callback_spg'));
            $crud->callback_column('gimmick',array($this,'_callback_gimmick'));
            $crud->callback_column('other',array($this,'_callback_other'));
            $crud->callback_column('nodoc',array($this,'_callback_nodoc'));
            $crud->callback_column('sales_est',array($this,'_callback_sales'));
            $crud->callback_column('event_date',array($this,'_callback_date'));
            $crud->callback_column('action',array($this,'_callback_action'));
            $crud->callback_column('action2',array($this,'_callback_action2'));

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

        $name="event".$row->id_event;
        $button=$button."<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/Event?id=".$row->id_event."'><i class='fa fa-pencil'></i>&nbsp;Edit</a>&nbsp;";

		$no="";
		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$row->id_event);
		foreach ($query->result() as $row2)
		{			
			$no = substr($row2->created_date,-4)."/".$row2->code."-BTL/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
		}
		
		if($row->state==6 && ($this->session->userdata('id_group')==19))
		{
			$name="event2-".$row->id_event;
			$url = base_url()."index.php/Event/UpdateState5?id=".$row->id_event;
//			$button=$button."<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/MER/UpdateState5?id=".$row->id_mer."'>&nbsp;Reject&nbsp;";
			$button=$button."<a href='#basicModal2' class='btn btn-default btn-xs' data-toggle='modal' data-url='$url' data-id='$no' data-target='#basicModal2'><i class='fa fa-trash'></i>&nbsp;Reject</a>";
			$name="event3-".$row->id_event;
			$url = base_url()."index.php/Event/UpdateState6?id=".$row->id_event;
//			$button=$button."<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/MER/UpdateState6?id=".$row->id_mer."'>&nbsp;Review&nbsp;";
			$button=$button."<a href='#basicModal3' class='btn btn-default btn-xs' data-toggle='modal' data-url='$url' data-id='$no' data-target='#basicModal3'><i class='fa fa-trash'></i>&nbsp;Review</a>";
		}			


        return $button;
    }

    public function _callback_action($value, $row)
    {

		$i = 0;
		$query = $this->db->query("SELECT id_report from event_report WHERE state<7 and id_event=".$row->id_event);
		$button = "";
		foreach ($query->result() as $row2)
		{			
            $i = $i+1;
        }

		if($i==0 && $row->state=="Approved")
		{
			if($this->session->userdata('id_group')==20)
			{
				$button="<a type='button' id='create' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/EventReport?id_event=".$row->id_event."'><i class='fa fa-plus'></i>&nbsp;&nbsp;Event Report</a>";
			}	
		}	

        return $button;
    }

    public function _callback_nodoc($value, $row)
    {
		$result="";
		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, nodoc, code FROM event_otc a, product_group b WHERE a.id_product_group=id_group and id_event=".$row->id_event);
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
//		return date('d M Y', strtotime($value));
		$date= str_replace(",", "<br>", $value);
		$date = str_replace('\'', '', $date);
		return $date;
	}

	public function _callback_other($value, $row)
	{
		$amount = 0;
		$query = $this->db->query("SELECT sum(replace(budget,'.','')) AS amount FROM budget_event where id_parent=".$row->id_event);
		foreach ($query->result() as $row2)
		{
			$amount = $row2->amount;	
		}

		return number_format($amount,0,'.',',');
	}

	public function _callback_sales($value, $row)
	{
		$amount = 0;
		$query = $this->db->query("select sum(cust_cost*qty_est) as total from event_sku where id_event=".$row->id_event);
		foreach ($query->result() as $row2)
		{
			$amount = $row2->total;	
		}

		return number_format($amount,0,'.',',');
	}

	public function _callback_spg($value, $row)
	{
		return number_format(($value*250000),0,'.',',');
	}

	public function _callback_gimmick($value, $row)
	{
		return number_format(($value*10000),0,'.',',');
	}



}
