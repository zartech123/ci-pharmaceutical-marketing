<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OfferLetterList extends CI_Controller {

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
		$this->load->view('offerletterlist',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('hcp1');
			$crud->set_subject('SPONSORSHIP OFFER LETTER HCP');
            $crud->columns('action2','id_mer','nodoc2','nodoc','event_name','event_organizer','event_venue','event_institution','event_start_date','event_end_date','action');
			$crud->set_relation('event_institution','hospital','{name} - {address}');
//            $crud->set_relation('id_mer','mer','nodoc');
            $crud->order_by('year, nodoc2');
			$crud->where('hcp1.state=6');
			$crud->unset_add();
			$crud->unset_edit();
			$crud->unset_delete();
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_clone();
			$crud->callback_column('event_start_date',array($this,'callback_date'));
			$crud->callback_column('event_end_date',array($this,'callback_date'));
			$crud->display_as('id_mer','MER');
			$crud->display_as('nodoc2','HCP SRF 1');
			$crud->display_as('nodoc','Offer Letter');
			$crud->display_as('event_institution','Institution');
			$crud->display_as('event_start_date','Start Date');
			$crud->display_as('event_end_date','End Date');
			$crud->display_as('event_name','Event Name');
			$crud->display_as('event_organizer','Event Organizer');
			$crud->display_as('event_venue','Event Venue');
			$crud->display_as('action','');
			$crud->display_as('action2','');
            $crud->callback_column('action',array($this,'_callback_action'));
            $crud->callback_column('action2',array($this,'_callback_action2'));
            $crud->callback_column('nodoc',array($this,'_callback_nodoc3'));
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

    public function _callback_nodoc2($value, $row)
    {
		$result="";
		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, nodoc2 FROM hcp1 WHERE id_hcp1=".$row->id_hcp1);
		foreach ($query->result() as $row2)
		{			
			$result = substr($row2->created_date,-4)."/HCP1/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
		}

        return $result;
    }

    public function _callback_nodoc3($value, $row)
    {
		$result="";
		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, nodoc2 FROM offer_letter WHERE id_hcp1=".$row->id_hcp1);
		foreach ($query->result() as $row2)
		{			
			$result = substr($row2->created_date,-4)."/HCP1/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
		}

        return $result;
    }

	public function callback_date($value, $row)
	{
		return date('Y-m-d',strtotime($value));
	}

    public function _callback_action($value, $row)
    {

        $i = 0;
		$query = $this->db->query("SELECT id_ol from offer_letter WHERE id_hcp1=".$row->id_hcp1);
		foreach ($query->result() as $row2)
		{			
            $i = $i+1;
        }    
        if($i>0)
        {
   	    $button="<a type='button' id='create' style='visibility:hidden' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/OfferLetter?id_hcp1=".$row->id_hcp1."'>Offer Letter</a>";
		}
		else
		{
			$button="<a type='button' id='create' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/OfferLetter?id_hcp1=".$row->id_hcp1."'><i class='fa fa-plus'></i>&nbsp;&nbsp;Offer Letter</a>";
		}	

        return $button;
    }

    public function _callback_action2($value, $row)
    {
        $button="";

		$query = $this->db->query("SELECT id_ol, event_institution from offer_letter WHERE id_hcp1=".$row->id_hcp1);
		foreach ($query->result() as $row2)
		{			
            $name="offerletter".$row2->id_ol;
            $button=$button."<a type='button' id='".$name."' class='btn btn-default btn-xs' target='_blank' href='".base_url()."index.php/OfferLetter?id_hcp1=".$row->id_hcp1."&id=".$row2->id_ol."'><i class='fa fa-pencil'></i>&nbsp;Edit</a>&nbsp;";
		}

        return $button;
    }

	public function _callback_date($value, $row)
	{
		return date('d M Y', strtotime($value));
	}
}
