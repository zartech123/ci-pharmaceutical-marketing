<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HCP1 extends CI_Controller {

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
				$query = $this->db->query("select title0, title1, approver0, approver1, active, id_mer, DATE_FORMAT(updated_date1,'%d-%M-%Y') as updated_date1, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, event_phone, event_name, event_organizer, event_venue, nodoc2, requested_by, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date, event_institution, event_contact, event_address, hcp, speciality, note1, state from hcp1 where id_hcp1=".$_GET['id']);
				foreach ($query->result() as $row2)
				{
					$id_mer = $row2->id_mer;
					$data = array(
						'event_organizer' => $row2->event_organizer,
						'event_name' => $row2->event_name,
						'event_venue' => $row2->event_venue,
						'event_start_date' => $row2->event_start_date,
						'event_end_date' => $row2->event_end_date,
						'event_institution' => $row2->event_institution,
						'event_contact' => $row2->event_contact,
						'event_address' => $row2->event_address,
						'event_phone' => $row2->event_phone,
						'event_end_date' => $row2->event_end_date,
						'nodoc2' => $row2->nodoc2,
						'speciality' => $row2->speciality,
						'requested_by' => $row2->requested_by,
						'hcp' => $row2->hcp,
						'active' => $row2->active,
						'state' => $row2->state,
						'created_date' => $row2->created_date,
						'updated_date1' => $row2->updated_date1,
						'note1' => $row2->note1,
						'approver1' => $row2->approver1,
						'approver0' => $row2->approver0,
						'title1' => $row2->title1,
						'title0' => $row2->title0
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
				$query = $this->db->query("select max(nodoc2)+1 as nodoc from hcp1 where year='".date("Y")."'");
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

				$query = $this->db->query("select DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, nodoc, event_name, event_organizer, event_venue, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date, speciality from mer where id_mer=".$_GET['id_mer']);
				foreach ($query->result() as $row2)
				{
					$data = array(
						'event_organizer' => $row2->event_organizer,
						'event_name' => $row2->event_name,
						'event_venue' => $row2->event_venue,
						'event_start_date' => $row2->event_start_date,
						'event_end_date' => $row2->event_end_date,
						'nodoc' => $row2->nodoc,
						'created_date' => date("d-M-Y"),
						'created_date2' => $row2->created_date,						
						'event_institution' => "",
						'event_contact' => "",
						'event_address' => "",
						'active' => "1",
						'nodoc2' => $nodoc,
						'budget' => "5",   
						'event_phone' => "",
						'speciality' => $row2->speciality,
						'requested_by' => "9",
						'hcp' => "",
						'state' => "1",
						'note1' => "",
						'approver1' => "",
						'approver0' => "",
						'title1' => "",
						'title0' => ""
						
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
				$query = $this->db->query("select id_product, percent from charge_product where type=3 and id_parent=".$_GET['id']." order by id_charge");
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
			else
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
			$data = array_merge($data, array('cost_each5'=>"0"));
			$data = array_merge($data, array('pax5'=>"0"));
			$data = array_merge($data, array('description5'=>""));
			$i=0;
			if(isset($_GET['id'])==true)
			{
				$query = $this->db->query("select sponsor_type, description, cost_each, pax from budget_hcp1 where id_parent=".$_GET['id']);
				foreach ($query->result() as $row2)
				{
					$sponsor_text = "sponsor".($i+1);
					$cost_text = "cost_each".($i+1);
					$description_text = "description".($i+1);
					$pax_text = "pax".($i+1);
					if($row2->sponsor_type=="Registration")
					{
						$data = array_merge($data, array('description1'=>$row2->description));
						$data = array_merge($data, array('cost_each1'=>$row2->cost_each));
						$data = array_merge($data, array('pax1'=>$row2->pax));
					}
					else if($row2->sponsor_type=="Travel")
					{
						$data = array_merge($data, array('description2'=>$row2->description));
						$data = array_merge($data, array('cost_each2'=>$row2->cost_each));
						$data = array_merge($data, array('pax2'=>$row2->pax));
					}
					else if($row2->sponsor_type=="Speaker")
					{
						$data = array_merge($data, array('description3'=>$row2->description));
						$data = array_merge($data, array('cost_each3'=>$row2->cost_each));
						$data = array_merge($data, array('pax3'=>$row2->pax));
					}
					else if($row2->sponsor_type=="Accommodation")
					{
						$data = array_merge($data, array('description4'=>$row2->description));
						$data = array_merge($data, array('cost_each4'=>$row2->cost_each));
						$data = array_merge($data, array('pax4'=>$row2->pax));
					}
					else
					{
						$data = array_merge($data, array($sponsor_text=>$row2->sponsor_type));
						$data = array_merge($data, array($cost_text=>$row2->cost_each));
						$data = array_merge($data, array($description_text=>$row2->description));
						$data = array_merge($data, array($pax_text=>$row2->pax));
					}
					$i = $i + 1;

				}	
				$data = array_merge($data, array('budget'=>$i));
			}	
			if($i==0)
			{
				$data = array_merge($data, array('description1'=>""));
				$data = array_merge($data, array('cost_each1'=>"0"));
				$data = array_merge($data, array('pax1'=>"0"));
				$data = array_merge($data, array('description2'=>""));
				$data = array_merge($data, array('cost_each2'=>"0"));
				$data = array_merge($data, array('pax2'=>"0"));
				$data = array_merge($data, array('description3'=>""));
				$data = array_merge($data, array('cost_each3'=>"0"));
				$data = array_merge($data, array('pax3'=>"0"));
				$data = array_merge($data, array('description4'=>""));
				$data = array_merge($data, array('cost_each4'=>"0"));
				$data = array_merge($data, array('pax4'=>"0"));
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
					$this->load->view('hcp1',$data);
				}
				else
				{
					$this->load->view('info2');
				}				
			}	

			/*if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
			{
				$this->load->view('hcp1',$data);
			}
			else if($_GET['access']>=1 && $_GET['access']<=18)
			{
				$this->load->view('hcp1',$data);
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
		$this->db->delete("budget_hcp1");


		$this->db->where('id_hcp1', $_GET['id']);
		$this->db->delete("hcp1");
		echo "This data has been deleted";
	}

	public function updateState5()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$this->db->set('state', "7", FALSE);
		$this->db->where('id_hcp1', $_GET['id']);
		$this->db->update("hcp1");

		$this->db->set('state', "7", FALSE);
		$this->db->where('id_hcp1', $_GET['id']);
		$this->db->update("hcp2");

		echo "This data has been Rejected";
	}

	public function updateState6()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$this->db->set('state', "1", FALSE);
		$this->db->where('id_hcp1', $_GET['id']);
		$this->db->update("hcp1");

		$this->db->set('review', '1', FALSE);
		$this->db->where('id_hcp1', $_GET['id']);
		$this->db->update("hcp1");
		
		echo "This data has been Review";
	}

	public function updateState4()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$this->db->set('active', $_GET['active'], FALSE);
		$this->db->where('id_hcp1', $_GET['id']);
		$this->db->update("hcp1");		
	}

	public function updateState()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$state = 0;
		$query = $this->db->query("SELECT state FROM hcp1 where id_hcp1=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$state = $row2->state;	
		}

		$amount = 0;
		$ma = "nurmala.sari@ma.taisho.co.id";
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
		$query = $this->db->query("SELECT sum(replace(cost_each,'.','')*replace(pax,'.','')) AS amount FROM budget_hcp1 where id_parent=".$_GET['id']);
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

		$query = $this->db->query("SELECT review, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, note1, state, DATE_FORMAT(event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') AS event_end_date, nodoc2, event_name, event_organizer, name FROM hcp1 a, user b WHERE a.requested_by=b.id_user AND id_hcp1=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$note1 = $row2->note1;
			$nodoc = date("Y",strtotime($row2->created_date))."/HCP1/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
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
			$email = $pm;
		}
		else if($state==2)
		{
			$email = "";
			$email2 = $kam;
			$email3 = $pm;
		}

		if($state==2)
		{
			$this->db->set('state', '6', FALSE);
		}
		else
		{
			$this->db->set('state', 'state+1', FALSE);
		}	
		$this->db->where('id_hcp1', $_GET['id']);
		$this->db->update("hcp1");

		if($state==1)
		{			
			$this->db->set('approver0', "'".$GLOBALS['approver0']."'", FALSE);
			$this->db->set('title0', "'".$GLOBALS['title0']."'", FALSE);
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
		$this->db->where('id_hcp1', $_GET['id']);
		$this->db->update("hcp1");


		if($state<2)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
//			$this->email->to("yudhi_h_utama@yahoo.com");
			$this->email->to($email);
			$this->email->cc($ma);
			$this->email->subject('Please Approve HCP SRF 1 with No '.$nodoc);
			$content_html = "<table style='border: 1px solid black;'><tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'><strong>Event Name</strong></td><td style='border: 1px solid black;'><strong>Event Organizer</strong></td><td style='border: 1px solid black;'><strong>Event Date</strong></td><td style='border: 1px solid black;'><strong>Cost Estimation</strong></td><td style='border: 1px solid black;'><strong>Created By</strong></td></tr>";
			$content_html = $content_html."<tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'>".$event_name."</td><td style='border: 1px solid black;'>".$event_organizer."</td><td style='border: 1px solid black;'>".$event_start_date." - ".$event_end_date."</td><td style='border: 1px solid black;'>".$amount."</td><td style='border: 1px solid black;'>".$created_by."</td></tr></table>";
			$content_html = $content_html."<br><br>";
			$content_html = $content_html."Please Click this link to <a href='".base_url()."index.php/HCP1?id_mer=".$_GET['id_mer']."&id=".$_GET['id']."&access=".($_GET['id_group']-1)."'>Approve or Review or Reject</a>";
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
//			$this->email->to("yudhi_h_utama@yahoo.com");
			$this->email->to($email2);
			$this->email->cc($ma);
			$this->email->subject('HCP SRF 1 with No '.$nodoc. ' has been Approved by '.$email3);
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
		$kam = "";
		$pm = "";
		$medical = "";
		$bo = "";
		$cd = "";
		$pd = "";
		$note1 = "";
		$state = 0;
		$query = $this->db->query("SELECT sum(replace(cost_each,'.','')*replace(pax,'.','')) AS amount FROM budget_hcp1 where id_parent=".$_GET['id']);
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

		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, note1, state, DATE_FORMAT(event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') AS event_end_date, nodoc2, event_name, event_organizer, name FROM hcp1 a, user b WHERE a.requested_by=b.id_user AND id_hcp1=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$note1 = $row2->note1;
			$nodoc = date("Y",strtotime($row2->created_date))."/HCP1/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
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
			$email2 = $kam;
			$email3 = $pm;
		}

		$data = array(
   				'state' => "7");
		$this->db->where('id_hcp1', $_GET['id']);
		$this->db->update("hcp1",$data);

		if($state>=2)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
			$this->email->to($email2);
			$this->email->subject('HCP SRF 1 with No '.$nodoc. ' has been Rejected by '.$email3);
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
		$state = 0;
		$query = $this->db->query("SELECT sum(replace(cost_each,'.','')*replace(pax,'.','')) AS amount FROM budget_hcp1 where id_parent=".$_GET['id']);
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

		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, note1, state, DATE_FORMAT(event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') AS event_end_date, nodoc2, event_name, event_organizer, name FROM hcp1 a, user b WHERE a.requested_by=b.id_user AND id_hcp1=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$note1 = $row2->note1;
			$nodoc = date("Y",strtotime($row2->created_date))."/HCP1/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
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
			$email2 = $kam;
			$email3 = $pm;
		}

		$this->db->set('state', '1', FALSE);
		$this->db->where('id_hcp1', $_GET['id']);
		$this->db->update("hcp1");

		$this->db->set('review', '1', FALSE);
		$this->db->where('id_hcp1', $_GET['id']);
		$this->db->update("hcp1");

			$data = array(
				'approver1'=>'',
				'approver0'=>'',
				'title1'=>'',
				'title0'=>''
			);

		$this->db->where('id_hcp1', $_GET['id']);
		$this->db->update("hcp1",$data);

		if($state>=2)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
			$this->email->to($email2);
			$this->email->subject($email3.' Request to review HCP SFR 1 with No '.$nodoc);
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

		$speciality = $this->input->post('speciality');
		$speciality2 = "";

		foreach ($speciality as $a){
			$speciality2 = $speciality2.$a.",";
		}
		$speciality2 = substr_replace($speciality2 ,"",-1);

		$data = array(
			'id_mer' => $this->input->post('id_mer'),
			'event_venue' => $this->input->post('event_venue'),
            'event_start_date' => $start_date2,
            'event_end_date' => $end_date2,
			'event_phone' => $this->input->post('event_phone'),
			'nodoc2' => $this->input->post('nodoc2'),
			'requested_by' => $this->input->post('requested_by1'),
			'speciality' => $speciality2,
			'event_contact' => $this->input->post('event_contact'),
			'event_address' => $this->input->post('event_address'),
			'event_institution' => $this->input->post('event_institution'),
			'event_name' => $this->input->post('event_name'),
			'event_organizer' => $this->input->post('event_organizer'),
			'hcp' => $this->input->post('hcp'),
			'note1' => $this->input->post('note1')
        );
		if(empty($this->input->post('id_parent')))
		{
			$this->db->insert("hcp1",$data);
			$id_hcp = $this->db->insert_id();
		}	
		else
		{
			$this->db->where('id_hcp1', $this->input->post('id_parent'));
			$this->db->update("hcp1",$data);
			$id_hcp = $this->input->post('id_parent');

			$query = $this->db->query("select id_charge from charge_product where type=3 and id_parent=".$id_hcp." order by id_charge");
			foreach ($query->result() as $row2)
			{
				$id_charge[] = $row2->id_charge;
				$i = $i + 1;
			}	

			$query = $this->db->query("select id_budget from budget_hcp1 where id_parent=".$id_hcp." order by id_budget");
			foreach ($query->result() as $row2)
			{
				$id_budget[] = $row2->id_budget;
				$j = $j + 1;
			}	

		}	

		//
		

		$data3 = array(
            'sponsor_type' => "Registration",
            'cost_each' => $this->input->post('cost_each1'),
            'pax' => $this->input->post('pax1'),
            'id_parent' => $id_hcp,
            'description' => $this->input->post('description1')
        );
		if($i==0)
		{
			$this->db->insert("budget_hcp1",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[0]);
			$this->db->update("budget_hcp1",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Travel",
            'cost_each' => $this->input->post('cost_each2'),
            'pax' => $this->input->post('pax2'),
            'id_parent' => $id_hcp,
            'description' => $this->input->post('description2')
        );
		if($i==0)
		{
			$this->db->insert("budget_hcp1",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[1]);
			$this->db->update("budget_hcp1",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Speaker",
            'cost_each' => $this->input->post('cost_each3'),
            'pax' => $this->input->post('pax3'),
            'id_parent' => $id_hcp,
            'description' => $this->input->post('description3')
        );
		if($i==0)
		{
			$this->db->insert("budget_hcp1",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[2]);
			$this->db->update("budget_hcp1",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Accommodation",
            'cost_each' => $this->input->post('cost_each4'),
            'pax' => $this->input->post('pax4'),
            'id_parent' => $id_hcp,
            'description' => $this->input->post('description4')
        );
		if($i==0)
		{
			$this->db->insert("budget_hcp1",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[3]);
			$this->db->update("budget_hcp1",$data3);
		}

		$type_sponsor = $this->input->post('type_sponsor');
		$cost = $this->input->post('cost_each');
		$pax = $this->input->post('pax');
		$description = $this->input->post('description');

		$k = 0;
		foreach ($type_sponsor as $a)
		{
			$data3 = array(
				'sponsor_type' => $a,
				'cost_each' => $cost[$k],
				'pax' => $pax[$k],
				'id_parent' => $id_hcp,
				'description' => $description[$k]
			);
			if(empty($id_budget[4+$k]))
			{
				$this->db->insert("budget_hcp1",$data3);
			}
			else
			{
				$this->db->where('id_budget', $id_budget[4+$k]);
				$this->db->update("budget_hcp1",$data3);
			}
			$k = $k + 1;
		}
		if($j>$k)
		{
			for($l=($k+4);$l<$j;$l++)
			{
				$this->db->where('id_budget',$id_budget[$l]);
				$this->db->delete('budget_hcp1');				
			}			
		}


		//Charge Product

		$data2 = array(
            'id_product' => $this->input->post('product1'),
			'type' => "3",
            'id_parent' => $id_hcp,
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
			'type' => "3",
            'id_parent' => $id_hcp,
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
			'type' => "3",
            'id_parent' => $id_hcp,
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
			'type' => "3",
            'id_parent' => $id_hcp,
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

		redirect(base_url()."index.php/HCP1?id_mer=".$this->input->post('id_mer')."&id=".$id_hcp);

	}

	public function deleteAttachment()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
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
		echo $type;
	}

	public function getAttachment()
	{

		$type = 0;

		$result = "";
		$file_type = array("1"=>"Others");
		$query = $this->db->query("select id_attachment, file_name, file_type from attachment where type=3 and id_parent=".$_GET['id']." order by file_type");
		foreach ($query->result() as $row2)
		{	
			$result=$result."<div class='row'>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:240px;text-align:center;border-bottom:1px solid black;word-wrap: break-word;'
			>
				&nbsp;<a href='".base_url()."/assets/img/".$row2->file_name."' target='popup'>".$row2->file_name."</a>&nbsp;
			</div>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:160px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;word-wrap: break-word;'
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
		/*if($type<14)
		{
			$result=$result."<div class='row'>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:320px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;color:red'
			>
				&nbsp;Please submit KTP, NPWP, Bank Account & CV
			</div></div>";
		}*/
		echo $result;

	}	

	public function upload()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
        $file_name = $this->upload_file('file');
		$data = array(
			'file_name' => $file_name,
			'type' => "3",
			'file_type' => $this->input->post('file_type'),
			'id_parent' => $this->input->post('id_parent')
		);
		$this->db->insert("attachment",$data);
	}

}