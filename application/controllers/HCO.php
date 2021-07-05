<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HCO extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url','form');
		$this->load->library('email');

		$this->load->library('session');
		$this->load->library('user_agent');

		$query=$this->db->query("select level, name, id_group, description from (
		select '0' as level, a.name, a.id_group, description from user a, groups b, approver c, menu_approver d where c.id_menu=d.id_menu_approver and d.page='".$this->uri->segment(1)."' and active=1 and a.id_group=b.id and a.id_group and prepared=b.id
		UNION all
		select '1' as level, a.name, a.id_group, description from user a, groups b, approver c, menu_approver d where c.id_menu=d.id_menu_approver and d.page='".$this->uri->segment(1)."' and active=1 and a.id_group=b.id and a.id_group and approver1=b.id
		UNION all
		select '2' as level, a.name, a.id_group, description from user a, groups b, approver c, menu_approver d where c.id_menu=d.id_menu_approver and d.page='".$this->uri->segment(1)."' and active=1 and a.id_group=b.id and a.id_group and approver2=b.id
		UNION all
		select '3' as level, a.name, a.id_group, description from user a, groups b, approver c, menu_approver d where c.id_menu=d.id_menu_approver and d.page='".$this->uri->segment(1)."' and active=1 and a.id_group=b.id and a.id_group and approver3=b.id
		UNION all
		select '4' as level, a.name, a.id_group, description from user a, groups b, approver c, menu_approver d where c.id_menu=d.id_menu_approver and d.page='".$this->uri->segment(1)."' and active=1 and a.id_group=b.id and a.id_group and approver4=b.id
		UNION all
		select '5' as level, a.name, a.id_group, description from user a, groups b, approver c, menu_approver d where c.id_menu=d.id_menu_approver and d.page='".$this->uri->segment(1)."' and active=1 and a.id_group=b.id and a.id_group and approver5=b.id) x");
		foreach ($query->result() as $row2)
		{
			if($row2->level=="0")
			{
				$GLOBALS['title0'] = $row2->description;
				$GLOBALS['approver0'] = $row2->name;
				$GLOBALS['grp0'] = $row2->id_group;
			}				
			else if($row2->level=="1")
			{
				$GLOBALS['title1'] = $row2->description;
				$GLOBALS['approver1'] = $row2->name;
				$GLOBALS['grp1'] = $row2->id_group;
			}				
			else if($row2->level=="2")
			{
				$GLOBALS['title2'] = $row2->description;
				$GLOBALS['approver2'] = $row2->name;
				$GLOBALS['grp2'] = $row2->id_group;
			}				
			else if($row2->level=="3")
			{
				$GLOBALS['title3'] = $row2->description;
				$GLOBALS['approver3'] = $row2->name;
				$GLOBALS['grp3'] = $row2->id_group;
			}				
			else if($row2->level=="4")
			{
				$GLOBALS['title4'] = $row2->description;
				$GLOBALS['approver4'] = $row2->name;
				$GLOBALS['grp4'] = $row2->id_group;
			}				
			else if($row2->level=="5")
			{
				$GLOBALS['title5'] = $row2->description;
				$GLOBALS['approver5'] = $row2->name;
				$GLOBALS['grp5'] = $row2->id_group;
			}				
		}

		/*$query = $this->db->query("select a.name, a.id_group, description from user a, groups b where a.id_group=b.id and a.id_group IN (12,7,6,5,4,3,2)");
		foreach ($query->result() as $row2)
		{
			if($row2->id_group==12)
			{
				$GLOBALS['cs'] = $row2->name;
				$GLOBALS['cs-grp'] = $row2->description;
			}
			else if($row2->id_group==7)
			{
				$GLOBALS['kam'] = $row2->name;
				$GLOBALS['kam-grp'] = $row2->description;
			}
			else if($row2->id_group==6)
			{
				$GLOBALS['pm'] = $row2->name;
				$GLOBALS['pm-grp'] = $row2->description;
			}
			else if($row2->id_group==5)
			{
				$GLOBALS['md'] = $row2->name;
				$GLOBALS['md-grp'] = $row2->description;
			}
			else if($row2->id_group==4)
			{
				$GLOBALS['bo'] = $row2->name;
				$GLOBALS['bo-grp'] = $row2->description;
			}
			else if($row2->id_group==3)
			{
				$GLOBALS['cd'] = $row2->name;
				$GLOBALS['cd-grp'] = $row2->description;
			}
			else if($row2->id_group==2)
			{
				$GLOBALS['pd'] = $row2->name;
				$GLOBALS['pd-grp'] = $row2->description;
			}		
		}*/
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		if(isset($_GET['id_mer'])==true)
		{				
			$k = 0;
			if(isset($_GET['id'])==true)
			{				
				$id_mer="";
				$query = $this->db->query("select title0, title1, title2, approver0, approver1, approver2, active, id_mer, DATE_FORMAT(updated_date1,'%d-%M-%Y') as updated_date1, DATE_FORMAT(updated_date2,'%d-%M-%Y') as updated_date2, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, payee, bank, branch, account_number, payee_type, exchange, nodoc2, event_name, event_organizer, event_venue, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date, requested_by, note1, note2, state from hco where id_hco=".$_GET['id']);
				foreach ($query->result() as $row2)
				{
					$id_mer = $row2->id_mer;
					$data = array(
						'event_organizer' => $row2->event_organizer,
						'event_name' => $row2->event_name,
						'event_venue' => $row2->event_venue,
						'event_start_date' => $row2->event_start_date,
						'event_end_date' => $row2->event_end_date,
						'requested_by' => $row2->requested_by,
						'exchange' => $row2->exchange,
						'nodoc2' => $row2->nodoc2,
						'state' => $row2->state,
						'created_date' => $row2->created_date,
						'note1' => $row2->note1,
						'note2' => $row2->note2,
						'approver0' => $row2->approver0,
						'approver1' => $row2->approver1,
						'approver2' => $row2->approver2,
						'title0' => $row2->title0,
						'title1' => $row2->title1,
						'title2' => $row2->title2,
						'payee' => $row2->payee,
						'bank' => $row2->bank,
						'active' => $row2->active,
						'branch' => $row2->branch,
						'account_number' => $row2->account_number,
						'updated_date1' => $row2->updated_date1,
						'updated_date2' => $row2->updated_date2,
						'payee_type' => $row2->payee_type
					);
					$k = $k + 1;
				}	
				$query = $this->db->query("select DATE_FORMAT(created_date,'%d-%M-%Y') as created_date from mer where id_mer=".$id_mer);
				foreach ($query->result() as $row2)
				{
					$data = array_merge($data, array('created_date2'=>$row2->created_date));
				}
			}

			if($k==0)
			{
				$query = $this->db->query("select max(nodoc2)+1 as nodoc from hco where year='".date("Y")."'");
				foreach ($query->result() as $row2)
				{
					if($row2->nodoc==NULL)
					{
						$nodoc = "0001";
					}
					else
					{		
						$nodoc = str_pad($row2->nodoc,4,"0",STR_PAD_LEFT);
					}	
				}
				$query = $this->db->query("select DATE_FORMAT(created_date,'%d-%M-%Y') as created_date,nodoc, nodoc2, event_name, event_organizer, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date, event_venue from mer where id_mer=".$_GET['id_mer']);
				foreach ($query->result() as $row2)
				{
					$data = array(
						'event_organizer' => $row2->event_organizer,
						'event_name' => $row2->event_name,
						'nodoc' => $row2->nodoc,
						'nodoc2' => $nodoc,
						'exchange' => "",
						'event_start_date' => $row2->event_start_date,
						'event_end_date' => $row2->event_end_date,
						'event_venue' => $row2->event_venue,
						'requested_by' => "1",
						'created_date' => date("d-M-Y"),
						'created_date2' => $row2->created_date,
						'budget' => "5",   
						'state' => "1",
						'note1' => "",
						'note2' => "",
						'approver1' => "",
						'approver2' => "",
						'approver0' => "",
						'title0' => "",
						'title1' => "",
						'title2' => "",
						'payee' => "",
						'bank' => "",
						'active' => "1",
						'branch' => "",
						'account_number' => "",
						'payee_type' => ""
					);
				}
			}
			else
			{
				$query = $this->db->query("select nodoc from mer where id_mer=".$_GET['id_mer']);
				foreach ($query->result() as $row2)
				{
					$data = array_merge($data, array('nodoc'=>$row2->nodoc));
				}
			}

			$i=0;
			if(isset($_GET['id'])==true)
			{
				$query = $this->db->query("select id_product, percent from charge_product where type=5 and id_parent=".$_GET['id']." order by id_charge");
				foreach ($query->result() as $row2)
				{
					if($i==0)
					{
						$data = array_merge($data, array('product1'=>$row2->id_product));
						$data = array_merge($data, array('product_percent1'=>$row2->percent));
					}	
					if($i==1)
					{
						$data = array_merge($data, array('product2'=>$row2->id_product));
						$data = array_merge($data, array('product_percent2'=>$row2->percent));
					}	
					if($i==2)
					{
						$data = array_merge($data, array('product3'=>$row2->id_product));
						$data = array_merge($data, array('product_percent3'=>$row2->percent));
					}	
					if($i==3)
					{
						$data = array_merge($data, array('product4'=>$row2->id_product));
						$data = array_merge($data, array('product_percent4'=>$row2->percent));
					}	
					$i = $i + 1;
				}
			}	
			if($i==0)
			{
				$query = $this->db->query("select id_product, percent from charge_product where type=1 and id_parent=".$_GET['id_mer']." order by id_charge");
				foreach ($query->result() as $row2)
				{
					if($i==0)
					{
						$data = array_merge($data, array('product1'=>$row2->id_product));
						$data = array_merge($data, array('product_percent1'=>$row2->percent));
					}	
					if($i==1)
					{
						$data = array_merge($data, array('product2'=>$row2->id_product));
						$data = array_merge($data, array('product_percent2'=>$row2->percent));
					}	
					if($i==2)
					{
						$data = array_merge($data, array('product3'=>$row2->id_product));
						$data = array_merge($data, array('product_percent3'=>$row2->percent));
					}	
					if($i==3)
					{
						$data = array_merge($data, array('product4'=>$row2->id_product));
						$data = array_merge($data, array('product_percent4'=>$row2->percent));
					}	
					$i = $i + 1;
				}
			}

			$data = array_merge($data, array('sponsor5'=>""));
			$data = array_merge($data, array('local_amount5'=>"0"));
			$data = array_merge($data, array('foreign_amount5'=>"0"));
			$data = array_merge($data, array('description5'=>""));
			$i=0;
			if(isset($_GET['id'])==true)
			{
				$query = $this->db->query("select sponsor_type, description, local_amount, foreign_amount from budget_hco where id_parent=".$_GET['id']);
				foreach ($query->result() as $row2)
				{
					$sponsor_text = "sponsor".($i+1);
					$local_amount_text = "local_amount".($i+1);
					$description_text = "description".($i+1);
					$foreign_amount_text = "foreign_amount".($i+1);
					if($row2->sponsor_type=="Booth Stand")
					{
						$data = array_merge($data, array('description1'=>$row2->description));
						$data = array_merge($data, array('local_amount1'=>$row2->local_amount));
						$data = array_merge($data, array('foreign_amount1'=>$row2->foreign_amount));
					}
					else if($row2->sponsor_type=="Symposia")
					{
						$data = array_merge($data, array('description2'=>$row2->description));
						$data = array_merge($data, array('local_amount2'=>$row2->local_amount));
						$data = array_merge($data, array('foreign_amount2'=>$row2->foreign_amount));
					}
					else if($row2->sponsor_type=="Institution Fee")
					{
						$data = array_merge($data, array('description3'=>$row2->description));
						$data = array_merge($data, array('local_amount3'=>$row2->local_amount));
						$data = array_merge($data, array('foreign_amount3'=>$row2->foreign_amount));
					}
					else if($row2->sponsor_type=="Assosiation Fee")
					{
						$data = array_merge($data, array('description4'=>$row2->description));
						$data = array_merge($data, array('local_amount4'=>$row2->local_amount));
						$data = array_merge($data, array('foreign_amount4'=>$row2->foreign_amount));
					}
					else
					{
						$data = array_merge($data, array($sponsor_text=>$row2->sponsor_type));
						$data = array_merge($data, array($local_amount_text=>$row2->local_amount));
						$data = array_merge($data, array($description_text=>$row2->description));
						$data = array_merge($data, array($foreign_amount_text=>$row2->foreign_amount));
					}
					$i = $i + 1;

				}	
				$data = array_merge($data, array('budget'=>$i));
			}	
			if($i==0)
			{
				$data = array_merge($data, array('description1'=>""));
				$data = array_merge($data, array('local_amount1'=>"0"));
				$data = array_merge($data, array('foreign_amount1'=>"0"));
				$data = array_merge($data, array('description2'=>""));
				$data = array_merge($data, array('local_amount2'=>"0"));
				$data = array_merge($data, array('foreign_amount2'=>"0"));
				$data = array_merge($data, array('description3'=>""));
				$data = array_merge($data, array('local_amount3'=>"0"));
				$data = array_merge($data, array('foreign_amount3'=>"0"));
				$data = array_merge($data, array('description4'=>""));
				$data = array_merge($data, array('local_amount4'=>"0"));
				$data = array_merge($data, array('foreign_amount4'=>"0"));
			}

			$jumlah = 0;
			$query = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and replace(page,'List','')='".$this->uri->segment(1)."' and (id_group like '".$this->session->userdata('id_group').",%' or id_group like '%,".$this->session->userdata('id_group')."' or id_group like '%,".$this->session->userdata('id_group').",%' or id_group='".$this->session->userdata('id_group')."')");
			foreach ($query->result() as $row2)
			{
				$jumlah = $row2->jumlah;
				if($jumlah==0 && isset($_GET['access']))
				{
					$query2 = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and replace(page,'List','')='".$this->uri->segment(1)."' and (id_group like '".$_GET['access'].",%' or id_group like '%,".$_GET['access']."' or id_group like '%,".$_GET['access'].",%' or id_group='".$_GET['access']."')");
					foreach ($query2->result() as $row3)
					{
						$jumlah = $row3->jumlah;
					}
				}
			}

			if(!$this->session->userdata('id_group'))
			{
				$user_name = "";
				$query = $this->db->query("select user_name from user a, groups b where active=1 and a.id_group=b.id and id='".$_GET['access']."'");
				foreach ($query->result() as $row2)
				{
					$user_name = $row2->user_name;
				}
				
				$data2 = array(
					'access' => $user_name,
					'url' => $this->uri->uri_string()."?id=".$_GET['id'],
					'id' => $_GET['id']);
					
				$this->load->view('login',$data2);
			}
			else
			{		
				if($jumlah==1)
				{
					$this->load->view('hco',$data);
				}
				else
				{
					$this->load->view('info2');
				}				
			}	

			/*if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
			{
				$this->load->view('hco',$data);
			}
			else if($_GET['access']>=1 && $_GET['access']<=18)
			{
				$this->load->view('hco',$data);
			}
			else
			{
				$this->load->view('login');
			}*/	
		}
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

    function upload_file($field)
    {
        $config['upload_path'] = APP_PATH.'assets/img';
        $config['allowed_types'] = '*';
        $config['file_name'] = time().$_FILES[$field]['name'];
        $filename = "";

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

		if (!$this->upload->do_upload($field)) 
        {
            $error = array('error' => $this->upload->display_errors());
            $filename = array('error' => $this->upload->display_errors());
        } 
        else 
        {
            $upload_data = $this->upload->data();
            $filename = $upload_data['file_name'];
        }

        return $filename;
    }

	public function delete()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$this->db->where('id_parent', $_GET['id']);
		$this->db->delete("budget_hco");

		$this->db->where('id_hco', $_GET['id']);
		$this->db->delete("hco");
		echo "This data has been deleted";
	}

	public function updateState4()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$this->db->set('active', $_GET['active'], FALSE);
		$this->db->where('id_hco', $_GET['id']);
		$this->db->update("hco");		
	}

	public function updateState()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$state = 0;
		$query = $this->db->query("SELECT state FROM hco where id_hco=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$state = $row2->state;	
		}

		$amount = 0;
		$nodoc = "";
		$event_name = "";
		$event_organizer = "";
		$created_by = "";
		$event_start_date = "";
		$event_end_date = "";
		$kam = "";
		$pm = "";
		$medical = "";
		$bo = "";
		$review = "";
		$cd = "";
		$pd = "";
		$note1 = "";
		$ma = "nurmala.sari@ma.taisho.co.id";
		$note2 = "";
		$query = $this->db->query("SELECT sum(replace(local_amount,'.','')) AS amount FROM budget_hco where id_parent=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$amount = $row2->amount;	
		}

		$query = $this->db->query("SELECT email, id_group FROM user WHERE active=1 and id_group IN (7,6,5,4,3,2,12,18)");
		foreach ($query->result() as $row2)
		{
			if($row2->id_group==7)
			{
				$kam = $row2->email;
			}
			else if($row2->id_group==6)
			{
				$pm = $row2->email;
			}
			else if($row2->id_group==5)
			{
				$medical = $row2->email;
			}
			else if($row2->id_group==4)
			{
				$bo = $row2->email;
			}
			else if($row2->id_group==3)
			{
				$cd = $row2->email;
			}
			else if($row2->id_group==2)
			{
				$pd = $row2->email;
			}
		}

		$query = $this->db->query("SELECT review, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, note1, note2, state, DATE_FORMAT(event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') AS event_end_date, nodoc2, event_name, event_organizer, name FROM hco a, user b WHERE a.requested_by=b.id_user AND id_hco=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$note1 = $row2->note1;
			$note2 = $row2->note2;
			$nodoc = date("Y",strtotime($row2->created_date))."/HCO/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
			$event_name = $row2->event_name;	
			$event_organizer = $row2->event_organizer;	
			$created_by = $row2->name;
			$event_start_date = $row2->event_start_date;	
			$event_end_date = $row2->event_end_date;	
			$state = $row2->state;	
			$review = $row2->review;	
		}

		if($state==1)
		{
			$email = $medical;
		}
		else if($state==2)
		{
			$email = $bo;
			$email2 = $pm;
			$email3 = $medical;
		}
		else if($state==3)
		{
			$email = "";
			$email2 = $medical.",".$pm;
			$email3 = $bo;
		}

		if($state==3)
		{
			$this->db->set('state', '6', FALSE);
		}
		else
		{
			$this->db->set('state', 'state+1', FALSE);
		}	
		$this->db->where('id_hco', $_GET['id']);
		$this->db->update("hco");

		if($state==1)
		{			
			$this->db->set('title0', "'".$GLOBALS['title0']."'", FALSE);
			$this->db->set('approver0', "'".$GLOBALS['approver0']."'", FALSE);
			if($review==0)
			{
				$this->db->set('created_date', "now()", FALSE);
					
			}
		}
		else if($state==2)
		{
			$this->db->set('updated_date1', "now()", FALSE);
			$this->db->set('approver1', "'".$GLOBALS['approver1']."'", FALSE);
			$this->db->set('title1', "'".$GLOBALS['title1']."'", FALSE);
		}
		else if($state==3)
		{
			$this->db->set('updated_date2', "now()", FALSE);
			$this->db->set('approver2', "'".$GLOBALS['bo']."'", FALSE);
			$this->db->set('title2', "'".$GLOBALS['bo-grp']."'", FALSE);
		}
		else if($state==4)
		{
			$this->db->set('updated_date3', 'now()', FALSE);						
		}
		else if($state==5)
		{
			$this->db->set('updated_date4', 'now()', FALSE);						
		}
		$this->db->where('id_hco', $_GET['id']);
		$this->db->update("hco");


		if($state<3)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
			$this->email->to($email);
			$this->email->cc($ma);
			$this->email->subject('Please Approve HCO with No '.$nodoc);
			$content_html = "<table style='border: 1px solid black;'><tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'><strong>Event Name</strong></td><td style='border: 1px solid black;'><strong>Event Organizer</strong></td><td style='border: 1px solid black;'><strong>Event Date</strong></td><td style='border: 1px solid black;'><strong>Cost Estimation</strong></td><td style='border: 1px solid black;'><strong>Created By</strong></td></tr>";
			$content_html = $content_html."<tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'>".$event_name."</td><td style='border: 1px solid black;'>".$event_organizer."</td><td style='border: 1px solid black;'>".$event_start_date." - ".$event_end_date."</td><td style='border: 1px solid black;'>".$amount."</td><td style='border: 1px solid black;'>".$created_by."</td></tr></table>";
			$content_html = $content_html."<br><br>";
			$content_html = $content_html."Please Click this link to <a href='".base_url()."index.php/HCO?id_mer=".$_GET['id_mer']."&id=".$_GET['id']."&access=".($_GET['id_group']-1)."'>Approve or Review or Reject</a>";
			$content_html = $content_html."<br><br>";
			$this->email->message($content_html);			
							
			if($this->email->send())
			{	
				$this->session->set_flashdata("email_sent","Congratulation Email Send Successfully.");
			}	
			else
			{	
				$this->session->set_flashdata("email_sent","You have encountered an error");		
			}		
		}	

		if($state>=2)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
			$this->email->to($email2);
			$this->email->cc($ma);
			$this->email->subject('HCO with No '.$nodoc. ' has been Approved by '.$email3);
			$content_html = "<table style='border: 1px solid black;'><tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'><strong>Event Name</strong></td><td style='border: 1px solid black;'><strong>Event Organizer</strong></td><td style='border: 1px solid black;'><strong>Event Date</strong></td><td style='border: 1px solid black;'><strong>Cost Estimation</strong></td><td style='border: 1px solid black;'><strong>Created By</strong></td></tr>";
			$content_html = $content_html."<tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'>".$event_name."</td><td style='border: 1px solid black;'>".$event_organizer."</td><td style='border: 1px solid black;'>".$event_start_date." - ".$event_end_date."</td><td style='border: 1px solid black;'>".$amount."</td><td style='border: 1px solid black;'>".$created_by."</td></tr></table>";
			$content_html = $content_html."<br><br>";
			$this->email->message($content_html);			
							
			if($this->email->send())
			{	
				$this->session->set_flashdata("email_sent","Congratulation Email Send Successfully.");
			}	
			else
			{	
				$this->session->set_flashdata("email_sent","You have encountered an error");		
			}		
		}	

	}

	public function sendEmail()
	{
			$email = "yudhihutama@gmail.com,yudhi_h_utama@yahoo.com";
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
			$this->email->to($email);
			$this->email->subject('HCP SRF 1 with No  has been Approved by ');
			$this->email->message('xxxx yyy zzz');

			if($this->email->send())
			{	
				$this->session->set_flashdata("email_sent","Congratulation Email Send Successfully.");
				echo "OK";
			}	
			else
			{	
				$this->session->set_flashdata("email_sent","You have encountered an error");		
				echo "NOK";
			}		

	}

	public function updateState3()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$amount = 0;
		$nodoc = "";
		$event_name = "";
		$event_organizer = "";
		$created_by = "";
		$event_start_date = "";
		$event_end_date = "";
		$kam = "";
		$pm = "";
		$medical = "";
		$bo = "";
		$cd = "";
		$pd = "";
		$note1 = "";
		$note2 = "";
		$state = 0;
		$query = $this->db->query("SELECT sum(replace(local_amount,'.','')) AS amount FROM budget_hco where id_parent=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$amount = $row2->amount;	
		}

		$query = $this->db->query("SELECT email, id_group FROM user WHERE active=1 and id_group IN (7,6,5,4,3,2,12,18)");
		foreach ($query->result() as $row2)
		{
			if($row2->id_group==7)
			{
				$kam = $row2->email;
			}
			else if($row2->id_group==6)
			{
				$pm = $row2->email;
			}
			else if($row2->id_group==5)
			{
				$medical = $row2->email;
			}
			else if($row2->id_group==4)
			{
				$bo = $row2->email;
			}
			else if($row2->id_group==3)
			{
				$cd = $row2->email;
			}
			else if($row2->id_group==2)
			{
				$pd = $row2->email;
			}
		}

		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, note1, note2, state, DATE_FORMAT(event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') AS event_end_date, nodoc2, event_name, event_organizer, name FROM hco a, user b WHERE a.requested_by=b.id_user AND id_hco=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$note1 = $row2->note1;
			$note2 = $row2->note2;
			$nodoc = date("Y",strtotime($row2->created_date))."/HCO/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
			$event_name = $row2->event_name;	
			$event_organizer = $row2->event_organizer;	
			$created_by = $row2->name;
			$event_start_date = $row2->event_start_date;	
			$event_end_date = $row2->event_end_date;	
			$state = $row2->state;	
		}

		if($state==2)
		{
			$note = $note1;
			$email2 = $pm;
			$email3 = $medical;
		}
		else if($state==3)
		{
			$note = $note2;
			$email2 = $pm.",".$medical;
			$email3 = $bo;
		}

		$data = array(
   				'state' => "7");
		$this->db->where('id_hco', $_GET['id']);
		$this->db->update("hco",$data);

		if($state>=2)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
			$this->email->to($email2);
			$this->email->subject('HCO with No '.$nodoc. ' has been Rejected by '.$email3);
			$content_html = "<table style='border: 1px solid black;'><tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'><strong>Event Name</strong></td><td style='border: 1px solid black;'><strong>Event Organizer</strong></td><td style='border: 1px solid black;'><strong>Event Date</strong></td><td style='border: 1px solid black;'><strong>Cost Estimation</strong></td><td style='border: 1px solid black;'><strong>Created By</strong></td><td style='border: 1px solid black;'><strong>Note</strong></td></tr>";
			$content_html = $content_html."<tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'>".$event_name."</td><td style='border: 1px solid black;'>".$event_organizer."</td><td style='border: 1px solid black;'>".$event_start_date." - ".$event_end_date."</td><td style='border: 1px solid black;'>".$amount."</td><td style='border: 1px solid black;'>".$created_by."</td><td style='border: 1px solid black;'>".$note."</td></tr></table>";
			$content_html = $content_html."<br><br>";
			$this->email->message($content_html);
							
			if($this->email->send())
			{	
				$this->session->set_flashdata("email_sent","Congratulation Email Send Successfully.");
			}	
			else
			{	
				$this->session->set_flashdata("email_sent","You have encountered an error");		
			}		
		}	


	}

	public function updateState2()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$amount = 0;
		$nodoc = "";
		$event_name = "";
		$event_organizer = "";
		$created_by = "";
		$event_start_date = "";
		$event_end_date = "";
		$kam = "";
		$pm = "";
		$medical = "";
		$bo = "";
		$cd = "";
		$pd = "";
		$note1 = "";
		$note2 = "";
		$state = 0;
		$query = $this->db->query("SELECT sum(replace(local_amount,'.','')) AS amount FROM budget_hco where id_parent=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$amount = $row2->amount;	
		}

		$query = $this->db->query("SELECT email, id_group FROM user WHERE active=1 and id_group IN (7,6,5,4,3,2,12,18)");
		foreach ($query->result() as $row2)
		{
			if($row2->id_group==7)
			{
				$kam = $row2->email;
			}
			else if($row2->id_group==6)
			{
				$pm = $row2->email;
			}
			else if($row2->id_group==5)
			{
				$medical = $row2->email;
			}
			else if($row2->id_group==4)
			{
				$bo = $row2->email;
			}
			else if($row2->id_group==3)
			{
				$cd = $row2->email;
			}
			else if($row2->id_group==2)
			{
				$pd = $row2->email;
			}
		}

		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, note1, note2, state, DATE_FORMAT(event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') AS event_end_date, nodoc2, event_name, event_organizer, name FROM hco a, user b WHERE a.requested_by=b.id_user AND id_hco=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$note1 = $row2->note1;
			$note2 = $row2->note2;
			$nodoc = date("Y",strtotime($row2->created_date))."/HCO/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
			$event_name = $row2->event_name;	
			$event_organizer = $row2->event_organizer;	
			$created_by = $row2->name;
			$event_start_date = $row2->event_start_date;	
			$event_end_date = $row2->event_end_date;	
			$state = $row2->state;	
		}

		if($state==2)
		{
			$note = $note1;
			$email2 = $pm;
			$email3 = $medical;
		}
		else if($state==3)
		{
			$note = $note2;
			$email2 = $pm.",".$medical;
			$email3 = $bo;
		}

		$this->db->set('state', '1', FALSE);
		$this->db->where('id_hco', $_GET['id']);
		$this->db->update("hco");

			$data = array(
				'approver1'=>'',
				'approver2'=>'',
				'approver0'=>'',
				'title0'=>'',
				'title1'=>'',
				'title2'=>''
			);

		$this->db->where('id_hco', $_GET['id']);
		$this->db->update("hco",$data);

		$this->db->set('review', '1', FALSE);
		$this->db->where('id_hco', $_GET['id']);
		$this->db->update("hco");

		if($state>=2)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
			$this->email->to($email2);
			$this->email->subject($email3.' Request to review HCO with No '.$nodoc);
			$content_html = "<table style='border: 1px solid black;'><tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'><strong>Event Name</strong></td><td style='border: 1px solid black;'><strong>Event Organizer</strong></td><td style='border: 1px solid black;'><strong>Event Date</strong></td><td style='border: 1px solid black;'><strong>Cost Estimation</strong></td><td style='border: 1px solid black;'><strong>Created By</strong></td><td style='border: 1px solid black;'><strong>Note</strong></td></tr>";
			$content_html = $content_html."<tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'>".$event_name."</td><td style='border: 1px solid black;'>".$event_organizer."</td><td style='border: 1px solid black;'>".$event_start_date." - ".$event_end_date."</td><td style='border: 1px solid black;'>".$amount."</td><td style='border: 1px solid black;'>".$created_by."</td><td style='border: 1px solid black;'>".$note."</td></tr></table>";
			$content_html = $content_html."<br><br>";
			$this->email->message($content_html);
							
			if($this->email->send())
			{	
				$this->session->set_flashdata("email_sent","Congratulation Email Send Successfully.");
			}	
			else
			{	
				$this->session->set_flashdata("email_sent","You have encountered an error");		
			}		
		}	

	}

	public function add()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
        $start_date = explode('/', $this->input->post('event_start_date'));
        $start_date2 = $start_date[2].'-'.$start_date[1].'-'.$start_date[0];

		$end_date = explode('/', $this->input->post('event_end_date'));
        $end_date2 = $end_date[2].'-'.$end_date[1].'-'.$end_date[0];
		$i = 0;
		$j = 0;

		$data = array(
			'id_mer' => $this->input->post('id_mer'),
			'exchange' => $this->input->post('exchange'),
			'nodoc2' => $this->input->post('nodoc2'),
            'event_start_date' => $start_date2,
            'event_end_date' => $end_date2,
			'event_venue' => $this->input->post('event_venue'),
			'requested_by' => $this->input->post('requested_by'),
			'event_name' => $this->input->post('event_name'),
			'event_organizer' => $this->input->post('event_organizer'),
			'payee' => $this->input->post('payee'),
			'payee_type' => $this->input->post('payee_type'),
			'bank' => $this->input->post('bank'),
			'branch' => $this->input->post('branch'),
			'account_number' => $this->input->post('account_number'),
			'note1' => $this->input->post('note1'),
			'note2' => $this->input->post('note2')
        );
		if(empty($this->input->post('id_parent')))
		{
			$this->db->insert("hco",$data);
			$id_hco = $this->db->insert_id();
		}	
		else
		{
			$this->db->where('id_hco', $this->input->post('id_parent'));
			$this->db->update("hco",$data);
			$id_hco = $this->input->post('id_parent');

			$query = $this->db->query("select id_charge from charge_product where type=5 and id_parent=".$id_hco." order by id_charge");
			foreach ($query->result() as $row2)
			{
				$id_charge[] = $row2->id_charge;
				$i = $i + 1;
			}	

			$query = $this->db->query("select id_budget from budget_hco where id_parent=".$id_hco." order by id_budget");
			foreach ($query->result() as $row2)
			{
				$id_budget[] = $row2->id_budget;
				$j = $j + 1;
			}	

		}	

		//
		

		$data3 = array(
            'sponsor_type' => "Booth Stand",
            'local_amount' => $this->input->post('local_amount1'),
            'foreign_amount' => $this->input->post('foreign_amount1'),
            'id_parent' => $id_hco,
            'description' => $this->input->post('description1')
        );
		if($i==0)
		{
			$this->db->insert("budget_hco",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[0]);
			$this->db->update("budget_hco",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Symposia",
            'local_amount' => $this->input->post('local_amount2'),
            'foreign_amount' => $this->input->post('foreign_amount2'),
            'id_parent' => $id_hco,
            'description' => $this->input->post('description2')
        );
		if($i==0)
		{
			$this->db->insert("budget_hco",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[1]);
			$this->db->update("budget_hco",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Institution Fee",
            'local_amount' => $this->input->post('local_amount3'),
            'foreign_amount' => $this->input->post('foreign_amount3'),
            'id_parent' => $id_hco,
            'description' => $this->input->post('description3')
        );
		if($i==0)
		{
			$this->db->insert("budget_hco",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[2]);
			$this->db->update("budget_hco",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Assosiation Fee",
            'local_amount' => $this->input->post('local_amount4'),
            'foreign_amount' => $this->input->post('foreign_amount4'),
            'id_parent' => $id_hco,
            'description' => $this->input->post('description4')
        );
		if($i==0)
		{
			$this->db->insert("budget_hco",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[3]);
			$this->db->update("budget_hco",$data3);
		}	

		$type_sponsor = $this->input->post('type_sponsor');
		$local_amount = $this->input->post('local_amount');
		$foreign_amount = $this->input->post('foreign_amount');
		$description = $this->input->post('description');

		$k = 0;
		foreach ($type_sponsor as $a)
		{
			$data3 = array(
				'sponsor_type' => $a,
				'local_amount' => $local_amount[$k],
				'foreign_amount' => $foreign_amount[$k],
				'id_parent' => $id_hco,
				'description' => $description[$k]
			);
			if(empty($id_budget[4+$k]))
			{
				$this->db->insert("budget_hco",$data3);
			}
			else
			{
				$this->db->where('id_budget', $id_budget[4+$k]);
				$this->db->update("budget_hco",$data3);
			}
			$k = $k + 1;
		}
		if($j>$k)
		{
			for($l=($k+4);$l<$j;$l++)
			{
				$this->db->where('id_budget',$id_budget[$l]);
				$this->db->delete('budget_hco');				
			}			
		}


		//Charge Product

		$data2 = array(
            'id_product' => $this->input->post('product1'),
			'type' => "5",
            'id_parent' => $id_hco,
            'percent' => $this->input->post('product_percent1')
        );
		if(empty($this->input->post('id_parent')))
		{
			$this->db->insert("charge_product",$data2);
		}
		else
		{
			$this->db->where('id_charge', $id_charge[0]);
			$this->db->update("charge_product",$data2);
		}	

		$data2 = array(
            'id_product' => $this->input->post('product2'),
			'type' => "5",
            'id_parent' => $id_hco,
            'percent' => $this->input->post('product_percent2')
        );
		if(empty($this->input->post('id_parent')))
		{
			$this->db->insert("charge_product",$data2);
		}
		else
		{
			$this->db->where('id_charge', $id_charge[1]);
			$this->db->update("charge_product",$data2);
		}	

		$data2 = array(
            'id_product' => $this->input->post('product3'),
			'type' => "5",
            'id_parent' => $id_hco,
            'percent' => $this->input->post('product_percent3')
        );
		if(empty($this->input->post('id_parent')))
		{
			$this->db->insert("charge_product",$data2);
		}
		else
		{
			$this->db->where('id_charge', $id_charge[2]);
			$this->db->update("charge_product",$data2);
		}	

		$data2 = array(
            'id_product' => $this->input->post('product4'),
			'type' => "5",
            'id_parent' => $id_hco,
            'percent' => $this->input->post('product_percent4')
        );
		if(empty($this->input->post('id_parent')))
		{
			$this->db->insert("charge_product",$data2);
		}
		else
		{
			$this->db->where('id_charge', $id_charge[3]);
			$this->db->update("charge_product",$data2);
		}	

		redirect(base_url()."index.php/HCO?id_mer=".$this->input->post('id_mer')."&id=".$id_hco);

	}

	public function getBank()
	{
		$result="[";
		$query = $this->db->query("select id_bank, concat(name,' (',code,')') as name from bank order by name");
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id_bank."\",\"name\":\"".$row2->name."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}

	public function deleteAttachment()
	{
		$query = $this->db->query("select file_name from attachment where id_attachment=".$_GET['id']);
		foreach ($query->result() as $row2)
		{			
			unlink(APP_PATH.'assets/img/'.$row2->file_name);
			$this->db->where('id_attachment', $_GET['id']);
			$this->db->delete('attachment');			
		}
	}

	public function getListAttachment()
	{
		$type = 0;
		$query = $this->db->query("select distinct file_type from attachment where type=5 and id_parent=".$_GET['id']." and file_type in (1) order by file_type");
		foreach ($query->result() as $row2)
		{
			$type = $type + $row2->file_type;	
		}
		echo $type;
	}

	public function getAttachment()
	{

		$type = 0;
		$query = $this->db->query("select distinct file_type from attachment where type=5 and id_parent=".$_GET['id']." and file_type in (1) order by file_type");
		foreach ($query->result() as $row2)
		{
			$type = $type + $row2->file_type;	
		}

		$result = "";
		$file_type = array("1"=>"Proposal/Letter from the organizing committee");
		$query = $this->db->query("select id_attachment, file_name, file_type from attachment where type=5 and id_parent=".$_GET['id']." order by file_type");
		foreach ($query->result() as $row2)
		{	
			$result=$result."<div class='row'>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:260px;text-align:center;border-bottom:1px solid black;word-wrap: break-word;'
			>
				&nbsp;<a href='".base_url()."/assets/img/".$row2->file_name."' target='popup'>".$row2->file_name."</a>&nbsp;
			</div>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:340px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;word-wrap: break-word;'
			>
				&nbsp;".$file_type[$row2->file_type]."&nbsp;
			</div>
			<div
				class='col-xs-1'
			>
			";
			if($this->session->userdata('id_group')==6 && $_GET['state']=="1")
			{
				$result=$result."<a href='javascript:deleteAttachment(".$row2->id_attachment.")'><i class='fa fa-times fa-2x' aria-hidden='true'></i></a>";
			}
			$result=$result."</div>
			</div>";
		}
		if($type<1)
		{
			$result=$result."<div class='row'>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:600px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;color:red'
			>
				&nbsp;Please submit Proposal/Letter from the Organizing Committee
			</div></div>";
		}
		echo $result;

	}	

	public function upload()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
        $file_name = $this->upload_file('file');
		$data = array(
			'file_name' => $file_name,
			'type' => "5",
			'file_type' => $this->input->post('file_type'),
			'id_parent' => $this->input->post('id_parent')
		);
		$this->db->insert("attachment",$data);
	}

}
