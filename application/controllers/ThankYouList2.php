<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ThankYouList2 extends CI_Controller {

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
		$this->load->view('thank-letter-list2',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('hco_report');
			$crud->set_subject('Thank You Letter HCO');
            $crud->columns('action2','id_mer','nodoc2','event_name','id_hco','event_organizer','event_venue','action');
            $crud->set_relation('id_hco','hco','doctor');
            $crud->set_relation('id_mer','mer','nodoc');
			$id_hco ="(";
			$query = $this->db->query("SELECT id_parent from budget_hco WHERE sponsor_type='Symposia' and (local_amount>0 or foreign_amount>0)");
			foreach ($query->result() as $row2)
			{			
				$id_hco = $id_hco.$row2->id_parent.",";
			}    
			$id_hco = $id_hco."0)";
			$crud->where('hco_report.state=6 and type='.$_GET['type'].' and hco_report.id_hco in '.$id_hco);
			$crud->unset_add();
			$crud->unset_edit();
			$crud->unset_delete();
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_clone();
			$crud->callback_column('event_start_date',array($this,'callback_date'));
			$crud->callback_column('event_end_date',array($this,'callback_date'));
			$crud->display_as('id_mer','MER No');
			$crud->display_as('nodoc2','HCO Report No');
			$crud->display_as('event_start_date','Start Date');
			$crud->display_as('event_end_date','End Date');
			$crud->display_as('event_name','Event Name');
			$crud->display_as('event_organizer','Event Organizer');
			$crud->display_as('event_venue','Event Venue');
			$crud->display_as('id_hco','Doctor');
			$crud->display_as('action','');
			$crud->display_as('action2','');
            $crud->callback_column('action',array($this,'_callback_action'));
            $crud->callback_column('action2',array($this,'_callback_action2'));

			$output = $crud->render();
    		if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
			{	
				$this->load->view('menu_admin.html');
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


	public function callback_date($value, $row)
	{
		return date('Y-m-d',strtotime($value));
	}

    public function _callback_action($value, $row)
    {
        $i = 0;
		$query = $this->db->query("SELECT id_report from thank_letter2 WHERE id_report=".$row->id_report);
		foreach ($query->result() as $row2)
		{			
            $i = $i+1;
        }    
        if($i>0)
        {
			$button="<a type='button' id='create' style='visibility:hidden' class='btn btn-primary btn-xs' target='_blank' href='".base_url()."index.php/ThankLetter2?id_report=".$row->id_report."'><i class='fa fa-plus'></i>&nbsp;&nbsp;Thank You Letter</a>";
		}
		else
		{
			$button="<a type='button' id='create' class='btn btn-primary btn-xs' target='_blank' href='".base_url()."index.php/ThankLetter2?id_report=".$row->id_report."'><i class='fa fa-plus'></i>&nbsp;&nbsp;Thank You Letter</a>";
		}	

        return $button;
    }

    public function _callback_action2($value, $row)
    {
        $button="";

		$query = $this->db->query("SELECT id_tl from thank_letter2 WHERE id_report=".$row->id_report);
		foreach ($query->result() as $row2)
		{			
			$name="tl".$row->id_report;
			$button=$button."<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/ThankLetter2?id_report=".$row->id_report."&id=".$row2->id_tl."'><i class='fa fa-pencil'></i>&nbsp;Edit</a>&nbsp;";
		}

        return $button;
    }

}
