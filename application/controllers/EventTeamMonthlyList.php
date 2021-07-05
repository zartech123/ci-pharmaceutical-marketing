<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EventTeamMonthlyList extends CI_Controller {

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
		$this->load->view('event-monthlylist',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('eventmonthlylist');
			$crud->set_subject('Event OTC Monthly Report by Team');
            $crud->columns('month_desc','year','action2');
			$crud->unset_add();
			$crud->unset_edit();
			$crud->unset_delete();
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_clone();
//			$crud->field_type('month','dropdown',array('1' => 'January','2' => 'February', '3' => 'Maret', '4' => 'April', '5' => 'Mei', '6' => 'Juni', '7' => 'July', '8' => 'Agustus', '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'));			
			$crud->display_as('month_desc','Bulan');
			$crud->display_as('year','Tahun');
			$crud->display_as('action','');
			$crud->display_as('action2','');
            $crud->callback_column('year',array($this,'_callback_year'));
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


	public function callback_date($value, $row)
	{
		return date('Y-m-d',strtotime($value));
	}

    /*public function _callback_action($value, $row)
    {
		$button = "";
        $readonly = "";
        $i = 0;
		$query = $this->db->query("SELECT id_report from hco_report WHERE id_hco=".$row->id_hco);
		foreach ($query->result() as $row2)
		{			
            $i = $i+1;
        }    
        if($i>0)
        {
            $readonly = "disabled";
        }
        $button=$button."<a type='button' id='create' class='btn btn-primary btn-xs' target='_blank' href='".base_url()."index.php/HCOReport?id_mer=".$row->id_mer."&id_hco=".$row->id_hco."' ".$readonly.">Create Form</a>";

        return $button;
    }*/

    public function _callback_action2($value, $row)
    {
        $name="kpkreport".$row->month;
        $button="<a type='button' id='".$name."' class='btn btn-success btn-xs' target='_blank' href='".base_url()."index.php/EventTeamMonthly?year=".$row->year."&month=".$row->month."'>View</a>";

        return $button;
    }

    public function _callback_year($value, $row)
    {

        return date("Y");
    }


}
