<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ScientificReport extends CI_Controller {

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

		/*$query = $this->db->query("select a.name, a.id_group, description from user a, groups b where a.id_group=b.id and a.id_group IN (12,7,6,5,4,3,2,18)");
		foreach ($query->result() as $row2)
		{
			if($row2->id_group==12)
			{
				$GLOBALS['cs'] = $row2->name;
				$GLOBALS['cs-grp'] = $row2->description;
			}
			else if($row2->id_group==18)
			{
				$GLOBALS['gm'] = $row2->name;
				$GLOBALS['gm-grp'] = $row2->description;
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
		if(isset($_GET['id_mer'])==true && isset($_GET['id_sc'])==true)
		{				
			$k = 0;
			if(isset($_GET['id'])==true)
			{				
				$query = $this->db->query("select title0, title1, approver0, approver1, prepared_note, active, DATE_FORMAT(updated_date1,'%d-%M-%Y') as updated_date1, nodoc2, reason, topic, product, time1, time2,time3,time4,time5,location1, location2,location3,location4,DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, event_venue, requested_by, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date, hcp, note1, state from scientific_report where id_report=".$_GET['id']);
				foreach ($query->result() as $row2)
				{
					$data = array(
						'event_venue' => $row2->event_venue,
						'event_start_date' => $row2->event_start_date,
						'event_end_date' => $row2->event_end_date,
						'requested_by' => $row2->requested_by,
						'hcp' => $row2->hcp,
						'topic' => $row2->topic,
						'reason' => $row2->reason,
						'product' => $row2->product,
						'location1' => $row2->location1,
						'location2' => $row2->location2,
						'location3' => $row2->location3,
						'location4' => $row2->location4,
						'nodoc2' => $row2->nodoc2,
						'time1' => $row2->time1,
						'time2' => $row2->time2,
						'time3' => $row2->time3,
						'time4' => $row2->time4,
						'time5' => $row2->time5,
						'state' => $row2->state,
						'created_date' => $row2->created_date,
						'updated_date1' => $row2->updated_date1,
						'active' => $row2->active,
						'note1' => $row2->note1,
						'approver1' => $row2->approver1,
						'approver0' => $row2->approver0,
						'title0' => $row2->title0,
						'title1' => $row2->title1,
						'prepared_note' => $row2->prepared_note
					);
					$k = $k + 1;
				}	
			}

			if($k==0)
			{
				$query = $this->db->query("select max(nodoc2)+1 as nodoc from scientific_report where year='".date("Y")."'");
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
				$query = $this->db->query("select physician, nurse, taisho, topic, product_event, event_venue, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date from scientific where id_sc=".$_GET['id_sc']);
				foreach ($query->result() as $row2)
				{
					$data = array(
						'location1' => "",
						'location2' => "",
						'location3' => "",
						'location4' => "",
						'time1' => "",
						'time2' => "",
						'time3' => "",
						'time4' => "",
						'time5' => "",
						'product' => $row2->product_event,
						'hcp' => "",
						'topic' => $row2->topic,
						'reason' => "",
						'budget' => "9",   
						'event_venue' => $row2->event_venue,
						'event_start_date' => $row2->event_start_date,
						'event_end_date' => $row2->event_end_date,
						'event_end_date' => $row2->event_end_date,
						'nodoc2' => $nodoc,
						'created_date' => date("d-M-Y"),
						'requested_by' => "9",
						'state' => "1",
						'active' => "1",
						'note1' => "",
						'approver1' => "",
						'approver0' => "",
						'title0' => "",
						'title1' => "",
						'prepared_note' => "",
						'plana1'=>$row2->physician,
						'plana2'=>$row2->nurse,
						'plana3'=>$row2->taisho
					);
				}
			}
			$query = $this->db->query("select nodoc from mer where id_mer=".$_GET['id_mer']);
			foreach ($query->result() as $row2)
			{
				$data = array_merge($data, array('nodoc'=>$row2->nodoc));
			}

			$i=0;


			$i=0;
//			$data = array_merge($data, array('sponsor7'=>""));
//			$data = array_merge($data, array('planb7'=>"0"));
//			$data = array_merge($data, array('actualb7'=>"0"));
			if(isset($_GET['id'])==true)
			{
				$query = $this->db->query("select sponsor_type, plana, planb, actuala, actualb, kpk from budget_scientific_report where id_parent=".$_GET['id']);
				foreach ($query->result() as $row2)
				{
					$sponsor_text = "sponsor".($i+1);
					$plan_text = "planb".($i+1);
					$actual_text = "actualb".($i+1);
					$kpk_text = "kpk".($i+1);
					if($row2->sponsor_type=="Meal")
					{
						$data = array_merge($data, array('plana1'=>$row2->plana));
						$data = array_merge($data, array('planb1'=>$row2->planb));
						$data = array_merge($data, array('actuala1'=>$row2->actuala));
						$data = array_merge($data, array('actualb1'=>$row2->actualb));
						$data = array_merge($data, array('kpk1'=>$row2->kpk));
					}
					else if($row2->sponsor_type=="Meeting Room Rent Fee/Institution Fee")
					{
						$data = array_merge($data, array('plana2'=>$row2->plana));
						$data = array_merge($data, array('planb2'=>$row2->planb));
						$data = array_merge($data, array('actuala2'=>$row2->actuala));
						$data = array_merge($data, array('actualb2'=>$row2->actualb));
						$data = array_merge($data, array('kpk2'=>$row2->kpk));
					}
					else if($row2->sponsor_type=="Association / Organisation Fee")
					{
						$data = array_merge($data, array('plana3'=>$row2->plana));
						$data = array_merge($data, array('planb3'=>$row2->planb));
						$data = array_merge($data, array('actuala3'=>$row2->actuala));
						$data = array_merge($data, array('actualb3'=>$row2->actualb));
						$data = array_merge($data, array('kpk3'=>$row2->kpk));
					}
					else if($row2->sponsor_type=="Speaker 1 Fee")
					{
						$data = array_merge($data, array('planb4'=>$row2->planb));
						$data = array_merge($data, array('actualb4'=>$row2->actualb));
						$data = array_merge($data, array('kpk4'=>$row2->kpk));
					}
					else if($row2->sponsor_type=="Speaker 2 Fee")
					{
						$data = array_merge($data, array('planb5'=>$row2->planb));
						$data = array_merge($data, array('actualb5'=>$row2->actualb));
						$data = array_merge($data, array('kpk5'=>$row2->kpk));
					}
					else if($row2->sponsor_type=="Moderator Fee")
					{
						$data = array_merge($data, array('planb6'=>$row2->planb));
						$data = array_merge($data, array('actualb6'=>$row2->actualb));
						$data = array_merge($data, array('kpk6'=>$row2->kpk));
					}
					else if($row2->sponsor_type=="Flight Ticket Speaker / Moderator")
					{
						$data = array_merge($data, array('planb7'=>$row2->planb));
						$data = array_merge($data, array('actualb7'=>$row2->actualb));
						$data = array_merge($data, array('kpk7'=>$row2->kpk));
					}
					else if($row2->sponsor_type=="Accommodation Speaker / Moderator")
					{
						$data = array_merge($data, array('planb8'=>$row2->planb));
						$data = array_merge($data, array('actualb8'=>$row2->actualb));
						$data = array_merge($data, array('kpk8'=>$row2->kpk));
					}
					else
					{
						$data = array_merge($data, array($sponsor_text=>$row2->sponsor_type));
						$data = array_merge($data, array($plan_text=>$row2->planb));
						$data = array_merge($data, array($actual_text=>$row2->actualb));
						$data = array_merge($data, array($kpk_text=>$row2->kpk));
					}

					$i = $i + 1;

				}	
				$data = array_merge($data, array('budget'=>$i));
			}	
			if($i==0)
			{
				$j = 0;
				$query = $this->db->query("select sponsor_type, total_budget from budget_scientific where id_parent=".$_GET['id_sc']);
				foreach ($query->result() as $row2)
				{
					$sponsor_text = "sponsor".($i+1);
					$plan_text = "planb".($i+1);
					$actual_text = "actualb".($i+1);
					$kpk_text = "kpk".($i+1);
					if($row2->sponsor_type=="Meal")
					{
						$data = array_merge($data, array('planb1'=>$row2->total_budget));
						$data = array_merge($data, array('actuala1'=>"0"));
						$data = array_merge($data, array('actualb1'=>"0"));
						$data = array_merge($data, array('kpk1'=>"4"));
					}
					else if($row2->sponsor_type=="Meeting Room Rent Fee/Institution Fee")
					{
						$data = array_merge($data, array('planb2'=>$row2->total_budget));
						$data = array_merge($data, array('actuala2'=>"0"));
						$data = array_merge($data, array('actualb2'=>"0"));
						$data = array_merge($data, array('kpk2'=>"4"));
					}
					else if($row2->sponsor_type=="Association / Organisation Fee")
					{
						$data = array_merge($data, array('planb3'=>$row2->total_budget));
						$data = array_merge($data, array('actuala3'=>"0"));
						$data = array_merge($data, array('actualb3'=>"0"));
						$data = array_merge($data, array('kpk3'=>"4"));
					}
					else if($row2->sponsor_type=="Speaker 1 Fee")
					{
						$data = array_merge($data, array('planb4'=>$row2->total_budget));
						$data = array_merge($data, array('actualb4'=>"0"));
						$data = array_merge($data, array('kpk4'=>"4"));
					}
					else if($row2->sponsor_type=="Speaker 2 Fee")
					{
						$data = array_merge($data, array('planb5'=>$row2->total_budget));
						$data = array_merge($data, array('actualb5'=>"0"));
						$data = array_merge($data, array('kpk5'=>"4"));
					}
					else if($row2->sponsor_type=="Moderator Fee")
					{
						$data = array_merge($data, array('planb6'=>$row2->total_budget));
						$data = array_merge($data, array('actualb6'=>"0"));
						$data = array_merge($data, array('kpk6'=>"4"));
					}
					else if($row2->sponsor_type=="Flight Ticket Speaker / Moderator")
					{
						$data = array_merge($data, array('planb7'=>$row2->total_budget));
						$data = array_merge($data, array('actualb7'=>"0"));
						$data = array_merge($data, array('kpk7'=>"4"));
					}
					else if($row2->sponsor_type=="Accommodation Speaker / Moderator")
					{
						$data = array_merge($data, array('planb8'=>$row2->total_budget));
						$data = array_merge($data, array('actualb8'=>"0"));
						$data = array_merge($data, array('kpk8'=>"4"));
					}
					else
					{
						$data = array_merge($data, array($sponsor_text=>$row2->sponsor_type));
						$data = array_merge($data, array($plan_text=>$row2->total_budget));
						$data = array_merge($data, array($actual_text=>"0"));
						$data = array_merge($data, array($kpk_text=>"4"));
						$j = $j + 1;
					}

					$i = $i + 1;

				}	
				$data = array_merge($data, array('budget'=>$i));
				/*$data = array_merge($data, array('plana1'=>"0"));
				$data = array_merge($data, array('planb1'=>"0"));
				$data = array_merge($data, array('actuala1'=>"0"));
				$data = array_merge($data, array('actualb1'=>"0"));
				$data = array_merge($data, array('plana2'=>"0"));
				$data = array_merge($data, array('planb2'=>"0"));
				$data = array_merge($data, array('actuala2'=>"0"));
				$data = array_merge($data, array('actualb2'=>"0"));
				$data = array_merge($data, array('plana3'=>"0"));
				$data = array_merge($data, array('planb3'=>"0"));
				$data = array_merge($data, array('actuala3'=>"0"));
				$data = array_merge($data, array('actualb3'=>"0"));
				$data = array_merge($data, array('plana4'=>"0"));
				$data = array_merge($data, array('planb4'=>"0"));
				$data = array_merge($data, array('actuala4'=>"0"));
				$data = array_merge($data, array('actualb4'=>"0"));
				$data = array_merge($data, array('planb5'=>"0"));
				$data = array_merge($data, array('planb6'=>"0"));
				$data = array_merge($data, array('actualb5'=>"0"));
				$data = array_merge($data, array('actualb6'=>"0"));*/
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
						$this->load->view('scientific-report',$data);
					}
					else
					{
						$this->load->view('info2');
					}				
				}	
			/*if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
			{
				$this->load->view('scientific-report',$data);
			}
			else if($_GET['access']>=1 && $_GET['access']<=18)
			{
				$this->load->view('scientific-report',$data);
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
		$this->db->delete("budget_scientific_report");

		$this->db->where('id_report', $_GET['id']);
		$this->db->delete("scientific_report");
	}

	public function updateState4()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$this->db->set('active', $_GET['active'], FALSE);
		$this->db->where('id_report', $_GET['id']);
		$this->db->update("scientific_report");
		
		echo "OK";
	}

	public function updateState()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$state = 0;
		$query = $this->db->query("SELECT state FROM scientific_report where id_report=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$state = $row2->state;	
		}

		$ma = "nurmala.sari@ma.taisho.co.id";
		$amount = 0;
		$nodoc = "";
		$event_name = "";
		$event_organizer = "";
		$created_by = "";
		$event_start_date = "";
		$event_end_date = "";
		$cs = "";
		$kam = "";
		$pm = "";
		$medical = "";
		$bo = "";
		$review = "";
		$cd = "";
		$pd = "";
		$note1 = "";
		$query = $this->db->query("SELECT sum(replace(actual,'.','')) AS amount FROM budget_scientific_report where id_parent=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$amount = $row2->amount;	
		}

		$query = $this->db->query("SELECT email, id_group FROM user WHERE active=1 and id_group IN (7,6,5,4,3,2,12,18)");
		foreach ($query->result() as $row2)
		{
			if($row2->id_group==12)
			{
				$cs = $row2->email;
			}
			else if($row2->id_group==7)
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

		$query = $this->db->query("SELECT a.review, DATE_FORMAT(a.created_date,'%d-%M-%Y') as created_date, a.note1, a.state, DATE_FORMAT(a.event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(a.event_end_date,'%d/%m/%Y') AS event_end_date, a.nodoc2, a.topic, name FROM scientific_report a, user b, scientific c WHERE c.id_sc = a.id_sc AND a.requested_by=b.id_user AND id_report=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$note1 = $row2->note1;
			$nodoc = date("Y",strtotime($row2->created_date))."/R-SERF/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
			$event_name = $row2->topic;	
			$event_organizer = "TPI";	
			$created_by = $row2->name;
			$event_start_date = $row2->event_start_date;	
			$event_end_date = $row2->event_end_date;	
			$state = $row2->state;	
			$review = $row2->review;	
		}

		if($state==1)
		{
			$email = $cs;
		}
		else if($state==2)
		{
			$email = "";
			$email2 = $kam;
			$email3 = $cs;
		}

		if($state==2)
		{
			$this->db->set('state', '6', FALSE);
		}
		else
		{
			$this->db->set('state', 'state+1', FALSE);
		}	
		$this->db->where('id_report', $_GET['id']);
		$this->db->update("scientific_report");

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
			$this->db->set('updated_date2', 'now()', FALSE);						
		}
		else if($state==4)
		{
			$this->db->set('updated_date3', 'now()', FALSE);						
		}
		else if($state==5)
		{
			$this->db->set('updated_date4', 'now()', FALSE);						
		}
		$this->db->where('id_report', $_GET['id']);
		$this->db->update("scientific_report");


		if($state<2)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
			$this->email->to($email);
			$this->email->cc($ma);
			$this->email->subject('Please Approve Scientific Report with No '.$nodoc);
			$content_html = "<table style='border: 1px solid black;'><tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'><strong>Event Name</strong></td><td style='border: 1px solid black;'><strong>Event Organizer</strong></td><td style='border: 1px solid black;'><strong>Event Date</strong></td><td style='border: 1px solid black;'><strong>Cost Estimation</strong></td><td style='border: 1px solid black;'><strong>Created By</strong></td></tr>";
			$content_html = $content_html."<tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'>".$event_name."</td><td style='border: 1px solid black;'>".$event_organizer."</td><td style='border: 1px solid black;'>".$event_start_date." - ".$event_end_date."</td><td style='border: 1px solid black;'>".$amount."</td><td style='border: 1px solid black;'>".$created_by."</td></tr></table>";
			$content_html = $content_html."<br><br>";
			$content_html = $content_html."Please Click this link to <a href='".base_url()."index.php/ScientificReport?id_mer=".$_GET['id_mer']."&id_sc=".$_GET['id_sc']."&id=".$_GET['id']."&access=".($_GET['id_group']-1)."'>Approve or Review or Reject</a>";
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
			$this->email->subject('Scientific Report with No '.$nodoc. ' has been Approved by '.$email3);
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
		$cs = "";
		$kam = "";
		$pm = "";
		$medical = "";
		$bo = "";
		$cd = "";
		$pd = "";
		$note1 = "";
		$state = 0;
		$query = $this->db->query("SELECT sum(replace(actual,'.','')) AS amount FROM budget_scientific_report where id_parent=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$amount = $row2->amount;	
		}

		$query = $this->db->query("SELECT email, id_group FROM user WHERE active=1 and id_group IN (7,6,5,4,3,2,12,18)");
		foreach ($query->result() as $row2)
		{
			if($row2->id_group==12)
			{
				$cs = $row2->email;
			}
			else if($row2->id_group==7)
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

		$query = $this->db->query("SELECT DATE_FORMAT(a.created_date,'%d-%M-%Y') as created_date, a.note1, a.state, DATE_FORMAT(a.event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(a.event_end_date,'%d/%m/%Y') AS event_end_date, a.nodoc2, a.topic, name FROM scientific_report a, user b, scientific c WHERE c.id_sc = a.id_sc AND a.requested_by=b.id_user AND id_report=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$note1 = $row2->note1;
			$nodoc = date("Y",strtotime($row2->created_date))."/R-SERF/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
			$event_name = $row2->topic;	
			$event_organizer = "TPI";	
			$created_by = $row2->name;
			$event_start_date = $row2->event_start_date;	
			$event_end_date = $row2->event_end_date;	
			$state = $row2->state;	
		}

		if($state==2)
		{
			$note = $note1;
			$email2 = $kam;
			$email3 = $cs;
		}

		$data = array(
   				'state' => "7");
		$this->db->where('id_report', $_GET['id']);
		$this->db->update("scientific_report",$data);

		if($state>=2)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
			$this->email->to($email2);
			$this->email->subject('Scientific Report with No '.$nodoc. ' has been Rejected by '.$email3);
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

	public function updateState5()
	{
		$i = 0;
		$query = $this->db->query("select id_budget from budget_scientific_report where id_parent=".$_GET['id']." order by id_budget");
		foreach ($query->result() as $row2)
		{
			$id_budget[] = $row2->id_budget;
			$i = $i + 1;
		}	
	

		$data3 = array(
            'kpk' => $this->input->post('kpk1'),
            'id_parent' => $_GET['id']
        );
		$this->db->where('id_budget', $id_budget[0]);
		$this->db->update("budget_scientific_report",$data3);

		$data3 = array(
            'kpk' => $this->input->post('kpk2'),
            'id_parent' => $_GET['id']
        );
		$this->db->where('id_budget', $id_budget[1]);
		$this->db->update("budget_scientific_report",$data3);

		$data3 = array(
            'kpk' => $this->input->post('kpk3'),
            'id_parent' => $_GET['id']
        );
		$this->db->where('id_budget', $id_budget[2]);
		$this->db->update("budget_scientific_report",$data3);

		$data3 = array(
            'kpk' => $this->input->post('kpk4'),
            'id_parent' => $_GET['id']
        );
		$this->db->where('id_budget', $id_budget[3]);
		$this->db->update("budget_scientific_report",$data3);

		$data3 = array(
            'kpk' => $this->input->post('kpk5'),
            'id_parent' => $_GET['id']
        );
		$this->db->where('id_budget', $id_budget[4]);
		$this->db->update("budget_scientific_report",$data3);

		$data3 = array(
            'kpk' => $this->input->post('kpk6'),
            'id_parent' => $_GET['id']
        );
		$this->db->where('id_budget', $id_budget[5]);
		$this->db->update("budget_scientific_report",$data3);

		$data3 = array(
            'kpk' => $this->input->post('kpk7'),
            'id_parent' => $_GET['id']
        );
		$this->db->where('id_budget', $id_budget[6]);
		$this->db->update("budget_scientific_report",$data3);

		$data3 = array(
            'kpk' => $this->input->post('kpk8'),
            'id_parent' => $_GET['id']
        );
		$this->db->where('id_budget', $id_budget[7]);
		$this->db->update("budget_scientific_report",$data3);

		$kpk = $this->input->post('kpk');

		$k = 0;
		foreach ($kpk as $a)
		{
			$data3 = array(
				'kpk' => $a,
				'id_parent' => $_GET['id']
			);
			$this->db->where('id_budget', $id_budget[8+$k]);
			$this->db->update("budget_scientific_report",$data3);
			$k = $k + 1;
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
		$cs = "";
		$kam = "";
		$pm = "";
		$medical = "";
		$bo = "";
		$cd = "";
		$pd = "";
		$note1 = "";
		$state = 0;
		$query = $this->db->query("SELECT sum(replace(actual,'.','')) AS amount FROM budget_scientific_report where id_parent=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$amount = $row2->amount;	
		}

		$query = $this->db->query("SELECT email, id_group FROM user WHERE active=1 and id_group IN (7,6,5,4,3,2,12,18)");
		foreach ($query->result() as $row2)
		{
			if($row2->id_group==12)
			{
				$cs = $row2->email;
			}
			else if($row2->id_group==7)
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

		$query = $this->db->query("SELECT DATE_FORMAT(a.created_date,'%d-%M-%Y') as created_date, a.note1, a.state, DATE_FORMAT(a.event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(a.event_end_date,'%d/%m/%Y') AS event_end_date, a.nodoc2, a.topic, name FROM scientific_report a, user b, scientific c WHERE c.id_sc = a.id_sc AND a.requested_by=b.id_user AND id_report=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$note1 = $row2->note1;
			$nodoc = date("Y",strtotime($row2->created_date))."/R-SERF/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
			$event_name = $row2->topic;	
			$event_organizer = "TPI";	
			$created_by = $row2->name;
			$event_start_date = $row2->event_start_date;	
			$event_end_date = $row2->event_end_date;	
			$state = $row2->state;	
		}

		if($state==2)
		{
			$note = $note1;
			$email2 = $kam;
			$email3 = $cs;
		}

		$this->db->set('state', '1', FALSE);
		$this->db->where('id_report', $_GET['id']);
		$this->db->update("scientific_report");

			$data = array(
				'approver0'=>'',
				'approver1'=>'',
				'title0'=>'',
				'title1'=>''
			);

		$this->db->where('id_report', $_GET['id']);
		$this->db->update("scientific_report",$data);

		$this->db->set('review', '1', FALSE);
		$this->db->where('id_report', $_GET['id']);
		$this->db->update("scientific_report");

		if($state>=2)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
			$this->email->to($email2);
			$this->email->subject($email3.' Request to review Scientific Report with No '.$nodoc);
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
        $start_date = explode('/', $this->input->post('event_start_date'));
        $start_date2 = $start_date[2].'-'.$start_date[1].'-'.$start_date[0];

		$end_date = explode('/', $this->input->post('event_end_date'));
        $end_date2 = $end_date[2].'-'.$end_date[1].'-'.$end_date[0];

		$i = 0;

		$data = array(
			'id_mer' => $this->input->post('id_mer'),
			'id_sc' => $this->input->post('id_sc'),
			'event_venue' => $this->input->post('event_venue'),
            'event_start_date' => $start_date2,
            'event_end_date' => $end_date2,
			'topic' => $this->input->post('topic'),
			'requested_by' => $this->input->post('requested_by1'),
			'product' => $this->input->post('product'),
			'reason' => $this->input->post('reason'),
			'time1' => $this->input->post('time1'),
			'time2' => $this->input->post('time2'),
			'time3' => $this->input->post('time3'),
			'time4' => $this->input->post('time4'),
			'time5' => $this->input->post('time5'),
			'location1' => $this->input->post('location1'),
			'location2' => $this->input->post('location2'),
			'location3' => $this->input->post('location3'),
			'location4' => $this->input->post('location4'),
			'nodoc2' => $this->input->post('nodoc'),
			'hcp' => $this->input->post('hcp'),
			'note1' => $this->input->post('note1'),
			'prepared_note' => $this->input->post('prepared_note')
        );
		if(empty($this->input->post('id_parent')))
		{
			$this->db->insert("scientific_report",$data);
			$id_report = $this->db->insert_id();
		}	
		else
		{
			$this->db->where('id_sc', $this->input->post('id_parent'));
			$this->db->update("scientific_report",$data);
			$id_report = $this->input->post('id_parent');

			$query = $this->db->query("select id_budget from budget_scientific_report where id_parent=".$id_report." order by id_budget");
			foreach ($query->result() as $row2)
			{
				$id_budget[] = $row2->id_budget;
				$i = $i + 1;
			}	

		}	

		//
		

		$data3 = array(
            'sponsor_type' => "Meal",
            'plana' => $this->input->post('plana1'),
            'planb' => $this->input->post('planb1'),
            'actuala' => $this->input->post('actuala1'),
            'actualb' => $this->input->post('actualb1'),
            'kpk' => $this->input->post('kpk1'),
            'id_parent' => $id_report
        );
		if($i==0)
		{
			$this->db->insert("budget_scientific_report",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[0]);
			$this->db->update("budget_scientific_report",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Meeting Room Rent Fee/Institution Fee",
            'plana' => $this->input->post('plana2'),
            'planb' => $this->input->post('planb2'),
            'actuala' => $this->input->post('actuala2'),
            'actualb' => $this->input->post('actualb2'),
            'kpk' => $this->input->post('kpk2'),
            'id_parent' => $id_report
        );
		if($i==0)
		{
			$this->db->insert("budget_scientific_report",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[1]);
			$this->db->update("budget_scientific_report",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Association / Organisation Fee",
            'plana' => $this->input->post('plana3'),
            'planb' => $this->input->post('planb3'),
            'actuala' => $this->input->post('actuala3'),
            'actualb' => $this->input->post('actualb3'),
            'kpk' => $this->input->post('kpk3'),
            'id_parent' => $id_report
        );
		if($i==0)
		{
			$this->db->insert("budget_scientific_report",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[2]);
			$this->db->update("budget_scientific_report",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Speaker 1 Fee",
            'planb' => $this->input->post('planb4'),
            'actualb' => $this->input->post('actualb4'),
            'kpk' => $this->input->post('kpk4'),
            'id_parent' => $id_report
        );
		if($i==0)
		{
			$this->db->insert("budget_scientific_report",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[3]);
			$this->db->update("budget_scientific_report",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Speaker 2 Fee",
            'planb' => $this->input->post('planb5'),
            'actualb' => $this->input->post('actualb5'),
            'kpk' => $this->input->post('kpk5'),
            'id_parent' => $id_report
        );
		if($i==0)
		{
			$this->db->insert("budget_scientific_report",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[4]);
			$this->db->update("budget_scientific_report",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Moderator Fee",
            'planb' => $this->input->post('planb6'),
            'actualb' => $this->input->post('actualb6'),
            'kpk' => $this->input->post('kpk6'),
            'id_parent' => $id_report
        );
		if($i==0)
		{
			$this->db->insert("budget_scientific_report",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[5]);
			$this->db->update("budget_scientific_report",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Flight Ticket Speaker / Moderator",
            'planb' => $this->input->post('planb7'),
            'actualb' => $this->input->post('actualb7'),
            'kpk' => $this->input->post('kpk7'),
            'id_parent' => $id_report
        );
		if($i==0)
		{
			$this->db->insert("budget_scientific_report",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[6]);
			$this->db->update("budget_scientific_report",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Accommodation Speaker / Moderator",
            'planb' => $this->input->post('planb8'),
            'actualb' => $this->input->post('actualb8'),
            'kpk' => $this->input->post('kpk8'),
            'id_parent' => $id_report
        );
		if($i==0)
		{
			$this->db->insert("budget_scientific_report",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[7]);
			$this->db->update("budget_scientific_report",$data3);
		}	

		$type_sponsor = $this->input->post('type_sponsor');
		$planb = $this->input->post('planb');
		$actualb = $this->input->post('actualb');
		$kpk = $this->input->post('kpk');

		$k = 0;
		foreach ($type_sponsor as $a)
		{
			$data3 = array(
				'sponsor_type' => $a,
				'planb' => $planb[$k],
				'actualb' => $actualb[$k],
				'kpk' => $kpk[$k],
				'id_parent' => $id_report,
			);
			if(empty($id_budget[8+$k]))
			{
				$this->db->insert("budget_scientific_report",$data3);
			}
			else
			{
				$this->db->where('id_budget', $id_budget[8+$k]);
				$this->db->update("budget_scientific_report",$data3);
			}
			$k = $k + 1;
		}
		if($i>$k)
		{
			for($l=($k+8);$l<$i;$l++)
			{
				$this->db->where('id_budget',$id_budget[$l]);
				$this->db->delete('budget_scientific_report');				
			}			
		}


//		echo "<script>window.close();</script>";

		//Charge Product

		redirect(base_url()."index.php/ScientificReport?id_mer=".$this->input->post('id_mer')."&id=".$id_report."&id_sc=".$this->input->post('id_sc'));

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
		$query = $this->db->query("select distinct file_type from attachment where type=8 and id_parent=".$_GET['id']." and file_type in (2,3) order by file_type");
		foreach ($query->result() as $row2)
		{
			$type = $type + $row2->file_type;	
		}
		echo $type;
	}

	public function getAttachment()
	{

		$jumlah = 0;
		$query = $this->db->query("SELECT COUNT(*) AS jumlah FROM scientific_hcp WHERE TYPE=2 and id_sc=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$jumlah = $row2->jumlah;	
		}


		$type = 0;
		$query = $this->db->query("select distinct file_type from attachment where type=8 and id_parent=".$_GET['id']." and file_type in (2,3) order by file_type");
		foreach ($query->result() as $row2)
		{
			$type = $type + $row2->file_type;	
		}

		$result = "";
		$file_type = array("1"=>"Q & A","2"=>"Photo","3"=>"Attendance List","4"=>"Speaker Agreement");
		$query = $this->db->query("select id_attachment, file_name, file_type from attachment where type=8 and id_parent=".$_GET['id']." order by file_type");
		foreach ($query->result() as $row2)
		{	
			$result=$result."<div class='row'>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:360px;text-align:center;border-bottom:1px solid black;word-wrap: break-word;'
			>
				&nbsp;<a href='".base_url()."/assets/img/".$row2->file_name."' target='popup'>".$row2->file_name."</a>&nbsp;
			</div>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;word-wrap: break-word;'
			>
				&nbsp;".$file_type[$row2->file_type]."&nbsp;
			</div>
			<div
				class='col-xs-1'
			>
			";
			if(($this->session->userdata('id_group')==7 || $this->session->userdata('id_group')==8 || $this->session->userdata('id_group')==9 || $this->session->userdata('id_group')==10) && $_GET['state']=="1")
			{
				$result=$result."<a href='javascript:deleteAttachment(".$row2->id_attachment.")'><i class='fa fa-times fa-2x' aria-hidden='true'></i></a>";
			}
			$result=$result."</div>
			</div>";
		}

			if($type<2)
			{
				$result=$result."<div class='row'>
				<div
					class='col-xs-1'
					style='border-left:1px solid black;width:560px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;color:red'
				>
					&nbsp;Please Submit Attendance List
				</div></div>";
				$result=$result."<div class='row'>
				<div
					class='col-xs-1'
					style='border-left:1px solid black;width:560px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;color:red'
				>
					&nbsp;Please Submit Photo
				</div></div>";

			}		
			else if($type==2)
			{
				$result=$result."<div class='row'>
				<div
					class='col-xs-1'
					style='border-left:1px solid black;width:560px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;color:red'
				>
					&nbsp;Please Submit Attendance List
				</div></div>";
			}
			else if($type==3)
			{
				$result=$result."<div class='row'>
				<div
					class='col-xs-1'
					style='border-left:1px solid black;width:560px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;color:red'
				>
					&nbsp;Please Submit Photo
				</div></div>";
			}		
		echo $result;

	}	

	public function upload()
	{
        $file_name = $this->upload_file('file');
		$data = array(
			'file_name' => $file_name,
			'type' => "8",
			'file_type' => $this->input->post('file_type'),
			'id_parent' => $this->input->post('id_parent')
		);
		$this->db->insert("attachment",$data);
	}

}
