<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AgreementLetterList3 extends CI_Controller {

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
		$this->load->view('agreement-letter-list3',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('scientific_hcp');
			$crud->set_subject('SPEAKER AGREEMENT LETTER - TPI');
//            $crud->columns('id_mer','nodoc2','event_name','hcp','event_organizer','event_venue','event_institution','event_start_date','event_end_date','action','action2');
            $crud->columns('action2','id_mer','nodoc','nodoc2','id_sc','name_hcp','institution_hcp','event_start_date','event_end_date','action');
            $crud->set_relation('id_sc','scientific','topic');
            $crud->set_relation('institution_hcp','hospital','{name}, {type}, {address}');
            $crud->set_relation('name_hcp','doctor','{name}');
            $crud->order_by('year, nodoc');
			$crud->where('scientific_hcp.type=2 and scientific_hcp.id_sc in (select id_sc from scientific where state=6)');
			$crud->unset_add();
			$crud->unset_edit();
			$crud->unset_delete();
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_clone();
			$crud->callback_column('event_start_date',array($this,'callback_date'));
			$crud->callback_column('event_end_date',array($this,'callback_date'));
			$crud->display_as('id_mer','MER');
			$crud->display_as('nodoc','SERF');
			$crud->display_as('nodoc2','Speaker Agreement');
			$crud->display_as('institution_hcp','Event Institution');
			$crud->display_as('name_hcp','Doctor');
			$crud->display_as('event_start_date','Start Date');
			$crud->display_as('event_end_date','End Date');
			$crud->display_as('id_sc','Event Name');
			$crud->display_as('action','');
			$crud->display_as('action2','');
            $crud->callback_column('action',array($this,'_callback_action'));
            $crud->callback_column('action2',array($this,'_callback_action2'));
            $crud->callback_column('id_mer',array($this,'_callback_nodoc'));
            $crud->callback_column('nodoc',array($this,'_callback_nodoc2'));
            $crud->callback_column('nodoc2',array($this,'_callback_nodoc3'));
            $crud->callback_column('event_start_date',array($this,'_callback_start_date'));
            $crud->callback_column('event_end_date',array($this,'_callback_end_date'));

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

    public function _callback_nodoc3($value, $row)
    {
		$result="";
		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, nodoc2 FROM agreement_letter3 WHERE id_sc=".$row->id_sc_hcp);
		foreach ($query->result() as $row2)
		{			
			$result = substr($row2->created_date,-4)."/SA/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
		}

        return $result;
    }

    public function _callback_nodoc2($value, $row)
    {
		$result="";
		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, nodoc FROM scientific WHERE id_sc=".$row->id_sc);
		foreach ($query->result() as $row2)
		{			
			$result = substr($row2->created_date,-4)."/SERF/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
		}

        return $result;
    }

	public function _callback_nodoc($value, $row)
    {
		$result="";
		$query = $this->db->query("SELECT DATE_FORMAT(a.created_date,'%d-%M-%Y') as created_date, a.nodoc FROM mer a, scientific b WHERE a.id_mer=b.id_mer and id_sc=".$row->id_sc);
		foreach ($query->result() as $row2)
		{			
			$result = substr($row2->created_date,-4)."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
		}

        return $result;
    }


    public function _callback_action($value, $row)
    {
        $i = 0;
		$query = $this->db->query("SELECT id_sc from agreement_letter3 WHERE id_sc=".$row->id_sc_hcp);
		foreach ($query->result() as $row2)
		{			
            $i = $i+1;
        }    
        if($i>0)
        {
			$button="<a type='button' id='create' style='visibility:hidden' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/AgreementLetter3?id_sc=".$row->id_sc_hcp."'><i class='fa fa-plus'></i>&nbsp;&nbsp;Speaker Agreement</a>";
		}
		else
		{
			$button="<a type='button' id='create' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/AgreementLetter3?id_sc=".$row->id_sc_hcp."'><i class='fa fa-plus'></i>&nbsp;&nbsp;Speaker Agreement</a>";
		}	

        return $button;
    }

    public function _callback_action2($value, $row)
    {
        $button="";

		$query = $this->db->query("SELECT id_tl from agreement_letter3 WHERE id_sc=".$row->id_sc_hcp);
		foreach ($query->result() as $row2)
		{			
			$name="tl".$row->id_sc_hcp;
			$button=$button."<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/AgreementLetter3?id_sc=".$row->id_sc_hcp."&id=".$row2->id_tl."'><i class='fa fa-pencil'></i>&nbsp;Edit</a>&nbsp;";
		}

        return $button;
    }

	public function _callback_start_date($value, $row)
	{
		$start_date="";
		$query = $this->db->query("SELECT event_start_date from scientific a, scientific_hcp b WHERE a.id_sc=b.id_sc and id_sc_hcp=".$row->id_sc_hcp);
		foreach ($query->result() as $row2)
		{			
			$start_date=$row2->event_start_date;
		}

		return date('d M Y', strtotime($start_date));
	}

	public function _callback_end_date($value, $row)
	{
		$end_date="";
		$query = $this->db->query("SELECT event_end_date from scientific a, scientific_hcp b WHERE a.id_sc=b.id_sc and id_sc_hcp=".$row->id_sc_hcp);
		foreach ($query->result() as $row2)
		{			
			$end_date=$row2->event_end_date;
		}

		return date('d M Y', strtotime($end_date));
	}

}
