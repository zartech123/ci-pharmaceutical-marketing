<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MER extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper(array('url','form'));
		$this->load->helper('date');

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

		if(isset($_GET['id'])==true)
		{				
			$query = $this->db->query("select title0, title1, title2, title3, title4, title5, approver0, approver1, approver2, approver3, approver4, approver5, active, type, DATE_FORMAT(updated_date1,'%d-%M-%Y') as updated_date1, DATE_FORMAT(updated_date2,'%d-%M-%Y') as updated_date2, DATE_FORMAT(updated_date3,'%d-%M-%Y') as updated_date3, DATE_FORMAT(updated_date4,'%d-%M-%Y') as updated_date4, DATE_FORMAT(updated_date5,'%d-%M-%Y') as updated_date5, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, speciality2, state, nodoc, location, requested_by, event_name, event_venue, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date, event_quota, event_organizer, nodoc2, topic, presentation, hcp_criteria, product_event, note1, note2, note3, note4, note5, speciality from mer where id_mer=".$_GET['id']);
			foreach ($query->result() as $row2)
			{
				$data = array(
					'id_mer' => $_GET['id'],
    				'nodoc' => $row2->nodoc,
    				'type' => $row2->type,
    				'location' => $row2->location,
    				'requested_by' => $row2->requested_by,
    				'event_name' => $row2->event_name,
    				'event_venue' => $row2->event_venue,
    				'event_start_date' => $row2->event_start_date,
    				'event_end_date' => $row2->event_end_date,
    				'event_quota' => $row2->event_quota,
    				'event_organizer' => $row2->event_organizer,
    				'nodoc2' => $row2->nodoc2,
					'created_date' => $row2->created_date,
					'updated_date1' => $row2->updated_date1,
					'updated_date2' => $row2->updated_date2,
					'updated_date3' => $row2->updated_date3,
					'updated_date4' => $row2->updated_date4,
					'updated_date5' => $row2->updated_date5,
    				'topic' => $row2->topic,
    				'state' => $row2->state,
    				'presentation' => $row2->presentation,
    				'note1' => $row2->note1,
    				'note2' => $row2->note2,
    				'note3' => $row2->note3,
    				'note4' => $row2->note4,
    				'note5' => $row2->note5,
    				'active' => $row2->active,
					'speciality2' => $row2->speciality2,
    				'speciality' => $row2->speciality,
    				'approver0' => $row2->approver0,
    				'approver1' => $row2->approver1,
    				'approver2' => $row2->approver2,
    				'approver3' => $row2->approver3,
    				'approver4' => $row2->approver4,
    				'approver5' => $row2->approver5,
    				'title0' => $row2->title0,
    				'title1' => $row2->title1,
    				'title2' => $row2->title2,
    				'title3' => $row2->title3,
    				'title4' => $row2->title4,
    				'title5' => $row2->title5
				);
			}
			$i=0;
			$query = $this->db->query("select id_product, percent from charge_product where type=1 and id_parent=".$_GET['id']." order by id_charge");
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
			if($i==0)
			{
				$data = array_merge($data, array('product1'=>"1"));
				$data = array_merge($data, array('product_percent1'=>"0"));
				$data = array_merge($data, array('product2'=>"1"));
				$data = array_merge($data, array('product_percent2'=>"0"));
				$data = array_merge($data, array('product3'=>"1"));
				$data = array_merge($data, array('product_percent3'=>"0"));
				$data = array_merge($data, array('product4'=>"1"));
				$data = array_merge($data, array('product_percent4'=>"0"));

			}

			$i=0;
			$data = array_merge($data, array('sponsor11'=>""));
			$data = array_merge($data, array('description11'=>"0"));
			$data = array_merge($data, array('amount11'=>"0"));
			$query = $this->db->query("select sponsor_type, description, amount from budget_mer where id_parent=".$_GET['id']);
			foreach ($query->result() as $row2)
			{
				$sponsor_text = "sponsor".($i+1);
				$description_text = "description".($i+1);
				$amount_text = "amount".($i+1);
				if($row2->sponsor_type=="Symposium/Congres")
				{
					$data = array_merge($data, array('description1'=>$row2->description));
					$data = array_merge($data, array('amount1'=>$row2->amount));
				}
				else if($row2->sponsor_type=="Booth")
				{
					$data = array_merge($data, array('description2'=>$row2->description));
					$data = array_merge($data, array('amount2'=>$row2->amount));
				}
				else if($row2->sponsor_type=="Registration")
				{
					$data = array_merge($data, array('description3'=>$row2->description));
					$data = array_merge($data, array('amount3'=>$row2->amount));
				}
				else if($row2->sponsor_type=="Travel")
				{
					$data = array_merge($data, array('description4'=>$row2->description));
					$data = array_merge($data, array('amount4'=>$row2->amount));
				}
				else if($row2->sponsor_type=="Accommodation")
				{
					$data = array_merge($data, array('description5'=>$row2->description));
					$data = array_merge($data, array('amount5'=>$row2->amount));
				}
				else if($row2->sponsor_type=="Business Meeting")
				{
					$data = array_merge($data, array('description6'=>$row2->description));
					$data = array_merge($data, array('amount6'=>$row2->amount));
				}
				else if($row2->sponsor_type=="Speaker Fee")
				{
					$data = array_merge($data, array('description7'=>$row2->description));
					$data = array_merge($data, array('amount7'=>$row2->amount));
				}
				else if($row2->sponsor_type=="Booth Construction")
				{
					$data = array_merge($data, array('description8'=>$row2->description));
					$data = array_merge($data, array('amount8'=>$row2->amount));
				}
				else if($row2->sponsor_type=="PP")
				{
					$data = array_merge($data, array('description9'=>$row2->description));
					$data = array_merge($data, array('amount9'=>$row2->amount));
				}
				else if($row2->sponsor_type=="RTD")
				{
					$data = array_merge($data, array('description10'=>$row2->description));
					$data = array_merge($data, array('amount10'=>$row2->amount));
				}
				else
				{
					$data = array_merge($data, array($sponsor_text=>$row2->sponsor_type));
					$data = array_merge($data, array($description_text=>$row2->description));
					$data = array_merge($data, array($amount_text=>$row2->amount));
				}
				$i = $i + 1;

			}	
			$data = array_merge($data, array('budget'=>$i));
			if($i==0)
			{
				$data = array_merge($data, array('description1'=>"0"));
				$data = array_merge($data, array('amount1'=>"0"));
				$data = array_merge($data, array('description2'=>"0"));
				$data = array_merge($data, array('amount2'=>"0"));
				$data = array_merge($data, array('description3'=>"0"));
				$data = array_merge($data, array('amount3'=>"0"));
				$data = array_merge($data, array('description4'=>"0"));
				$data = array_merge($data, array('amount4'=>"0"));
				$data = array_merge($data, array('description5'=>"0"));
				$data = array_merge($data, array('amount5'=>"0"));
				$data = array_merge($data, array('description6'=>"0"));
				$data = array_merge($data, array('amount6'=>"0"));
				$data = array_merge($data, array('description7'=>"0"));
				$data = array_merge($data, array('amount7'=>"0"));
				$data = array_merge($data, array('description8'=>"0"));
				$data = array_merge($data, array('amount8'=>"0"));
				$data = array_merge($data, array('description9'=>"0"));
				$data = array_merge($data, array('amount9'=>"0"));
				$data = array_merge($data, array('description10'=>"0"));
				$data = array_merge($data, array('amount10'=>"0"));
			}

			//$this->uri->segment(1);
			$jumlah = 0;
			$query = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and replace(page,'List','')='".$this->uri->segment(1)."2' and (id_group like '".$this->session->userdata('id_group').",%' or id_group like '%,".$this->session->userdata('id_group')."' or id_group like '%,".$this->session->userdata('id_group').",%' or id_group='".$this->session->userdata('id_group')."')");
			foreach ($query->result() as $row2)
			{
				$jumlah = $row2->jumlah;
				if($jumlah==0 && isset($_GET['access']))
				{
					$query2 = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and replace(page,'List','')='".$this->uri->segment(1)."2' and (id_group like '".$_GET['access'].",%' or id_group like '%,".$_GET['access']."' or id_group like '%,".$_GET['access'].",%' or id_group='".$_GET['access']."')");
					foreach ($query2->result() as $row3)
					{
						$jumlah = $row3->jumlah;
					}
				}
			}
			
			
			/*if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
			{
				$this->load->view('mer',$data);
			}
			else if($_GET['access']>=1 && $_GET['access']<=18)
			{
				$this->load->view('mer',$data);
			}
			else
			{
				$this->load->view('login');
			}*/

//			if(!$this->session->userdata('id_group') && !isset($_GET['access']))
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
					$this->load->view('mer',$data);
				}
				else
				{
					$this->load->view('info2');
				}				
			}	
		}	
		else
		{		
			$query = $this->db->query("select max(nodoc)+1 as nodoc from mer where year='".date("Y")."'");
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
			$data = array(
   				'nodoc' => $nodoc,
   				'location' => "1",
   				'requested_by' => "1",
   				'event_name' => "",
   				'event_venue' => "",
   				'event_start_date' => "",
   				'event_end_date' => "",
   				'event_quota' => "0",
   				'active' => "1",
   				'event_organizer' => "",
   				'nodoc2' => "",
   				'topic' => "",
   				'type' => "2",
   				'presentation' => "",
   				'speciality' => "",
   				'speciality2' => "",
   				'product1' => "1",
   				'product2' => "1",
   				'product3' => "1",
   				'product4' => "1",
				'created_date' => date("d-M-Y"),
   				'product_percent1' => "0",
   				'product_percent2' => "0",
   				'product_percent3' => "0",
   				'product_percent4' => "0",
				'note1' => "",
				'budget' => "11",   
   				'note2' => "",
   				'note3' => "",
   				'note4' => "",
   				'note5' => "",
   				'state' => "1",
   				'approver0' => "",
   				'approver1' => "",
   				'approver2' => "",
   				'approver3' => "",
   				'approver4' => "",
   				'approver5' => "",
   				'title0' => "",
   				'title1' => "",
   				'title2' => "",
   				'title3' => "",
   				'title4' => "",
   				'title5' => ""
			);

			$data = array_merge($data, array('description1'=>"0"));
			$data = array_merge($data, array('amount1'=>"0"));
			$data = array_merge($data, array('description2'=>"0"));
			$data = array_merge($data, array('amount2'=>"0"));
			$data = array_merge($data, array('description3'=>"0"));
			$data = array_merge($data, array('amount3'=>"0"));
			$data = array_merge($data, array('description4'=>"0"));
			$data = array_merge($data, array('amount4'=>"0"));
			$data = array_merge($data, array('description5'=>"0"));
			$data = array_merge($data, array('amount5'=>"0"));
			$data = array_merge($data, array('description6'=>"0"));
			$data = array_merge($data, array('amount6'=>"0"));
			$data = array_merge($data, array('description7'=>"0"));
			$data = array_merge($data, array('amount7'=>"0"));
			$data = array_merge($data, array('description8'=>"0"));
			$data = array_merge($data, array('amount8'=>"0"));
			$data = array_merge($data, array('description9'=>"0"));
			$data = array_merge($data, array('amount9'=>"0"));
			$data = array_merge($data, array('description10'=>"0"));
			$data = array_merge($data, array('amount10'=>"0"));
			$data = array_merge($data, array('sponsor11'=>""));
			$data = array_merge($data, array('description11'=>"0"));
			$data = array_merge($data, array('amount11'=>"0"));

			$jumlah = 0;
			$query = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and replace(page,'List','')='".$this->uri->segment(1)."2' and (id_group like '".$this->session->userdata('id_group').",%' or id_group like '%,".$this->session->userdata('id_group')."' or id_group like '%,".$this->session->userdata('id_group').",%' or id_group='".$this->session->userdata('id_group')."')");
			foreach ($query->result() as $row2)
			{
				$jumlah = $row2->jumlah;
				if($jumlah==0 && isset($_GET['access']))
				{
					$query2 = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and replace(page,'List','')='".$this->uri->segment(1)."2' and (id_group like '".$_GET['access'].",%' or id_group like '%,".$_GET['access']."' or id_group like '%,".$_GET['access'].",%' or id_group='".$_GET['access']."')");
					foreach ($query2->result() as $row3)
					{
						$jumlah = $row3->jumlah;
					}
				}
			}

			/*if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
			{
				$this->load->view('mer',$data);
			}
			else if($_GET['access']>=1 && $_GET['access']<=18)
			{
				$this->load->view('mer',$data);
			}
			else
			{
				$this->load->view('login');
			}*/	

//			if(!$this->session->userdata('id_group') && !isset($_GET['access']))
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
					$this->load->view('mer',$data);
				}
				else
				{
					$this->load->view('info2');
				}				
			}	
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
	
	function sendEmail()
	{
		$length = 8;
		$randomletter = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, $length);
		$this->email->from('esponsorship@onetpi.co.id', 'E-Sponsorship Administrator');
		$this->email->to("yudhi_h_utama@yahoo.com");
/*$this->email->SMTPOptions =  array(
   'ssl' => array(
     'verify_peer' => false,
     'verify_peer_name' => false,
     'allow_self_signed' => true
    )
 );*/
		$this->email->subject('Your E-Sponsorship Account have been Active');
		$file=fopen(APP_PATH."assets/email_activation.html", "r") or die("Unable to open file!");
		$content=fread($file,filesize(APP_PATH."assets/email_activation.html"));
		$content_text = htmlentities($content);
		$content_text=str_replace("_url",base_url()."Login",$content_text);
		$content_text=str_replace("_email","yudhi_h_utama@yahoo.com",$content_text);
		$content_text=str_replace("_password",$randomletter,$content_text);
		$content_html=html_entity_decode($content_text);
		$this->email->message($content_html);			

		if($this->email->send())
		{	
			echo "OK";
			//$this->session->set_flashdata("email_sent","Congratulation Email Send Successfully.");
		}	
		else
		{	
			echo "NOK";
//			$this->session->set_flashdata("email_sent","You have encountered an error");		
		}		
		

	}

	public function test()
	{
			$this->db->set('updated_date1', "now()", FALSE);
			$this->db->set('approver1', "'".$GLOBALS['md']."'", FALSE);
			/*$data = array(
				'updated_date1' => date('Y-m-d H:i:s',now()),
				'approver1' => $GLOBALS['md']
			);*/

			$this->db->where('id_mer', $_GET['id']);
			$this->db->update("mer");		
	}

	public function add2()
	{
			$data = array(		
				   'state' => "7",
				   'note1' => $this->input->post('note1')
			);
		$this->db->where('id_mer', 9);
		$this->db->update("mer",$data);
	}

	public function delete()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$this->db->where('id_parent', $_GET['id']);
		$this->db->delete("budget_mer");

		$this->db->where('id_mer', $_GET['id']);
		$this->db->delete("mer");
		echo "This data has been deleted";
	}


	public function updateState5()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$this->db->set('state', "8", FALSE);
		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("mer");
		
		$this->db->set('state', "7", FALSE);
		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("hcp1");

		$this->db->set('state', "7", FALSE);
		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("hcp2");

		$this->db->set('state', "7", FALSE);
		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("hco");

		$this->db->set('state', "7", FALSE);
		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("hcp_report");

		$this->db->set('state', "7", FALSE);
		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("hco_report");

		$this->db->set('state', "7", FALSE);
		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("scientific_report");

		echo "This data has been Rejected";
	}

	public function updateState6()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$this->db->set('state', "1", FALSE);
		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("mer");

		$this->db->set('review', '1', FALSE);
		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("mer");
		
		echo "This data has been Review";
	}

	public function updateState4()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$this->db->set('active', $_GET['active'], FALSE);
		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("mer");
		
		echo "OK";
	}


	public function resendEmail()
	{
		$amount = 0;
		$nodoc = "";
		$event_name = "";
		$event_organizer = "";
		$created_by = "";
		$event_start_date = "";
		$event_end_date = "";
		$pm = "";
		$medical = "";
		$bo = "";
		$cd = "";
		$cs = "";
		$pd = "";
		$gm = "";
		$state = 0;
		$amount = 0;
		$query = $this->db->query("SELECT sum(replace(amount,'.','')*replace(description,'.','')) AS amount FROM budget_mer where id_parent=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$amount = $row2->amount;	
		}

		$query = $this->db->query("SELECT email, id_group FROM user WHERE active=1 and id_group IN (12, 6,5,4,3,2,18)");
		foreach ($query->result() as $row2)
		{
			if($row2->id_group==12)
			{
				$cs = $row2->email;
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
			else if($row2->id_group==18)
			{
				$gm = $row2->email;
			}
			else if($row2->id_group==2)
			{
				$pd = $row2->email;
			}
		}

		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, state, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date, nodoc, event_name, event_organizer, name FROM mer a, user b where a.requested_by=b.id_user and id_mer=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
			$event_name = $row2->event_name;	
			$event_organizer = $row2->event_organizer;	
			$created_by = $row2->name;
			$event_start_date = $row2->event_start_date;	
			$event_end_date = $row2->event_end_date;	
			$state = $row2->state;	
		}

		if($state==2)
		{
			$email = $medical;
			$id_group = 5;
		}
		else if($state==3)
		{
			$email = $cs;
			$id_group = 12;
			$email2 = $pm;
			$email3 = $medical;
		}
		else if($state==4)
		{
			$email = $bo;
			$id_group = 4;
			$email2 = $pm.",".$medical;
			$email3 = $cs;
		}
		else if($state==5)
		{
			$email = $gm;
			$id_group = 3;
			$email2 = $pm.",".$medical.",".$cs;
			$email3 = $bo;
		}
		else if($state==6)
		{
			$email = $pd;
			$id_group = 2;
			$email2 = $pm.",".$medical.",".$cs.",".$bo;
			$email3 = $gm;
		}
		
		$ma = "nurmala.sari@ma.taisho.co.id";

		if($state<6)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
//			$this->email->to("yudhi_h_utama@yahoo.com");
			$this->email->to($email);
			$this->email->cc($ma);
//			$this->email->to();
			$this->email->subject('Please Approve MER with No '.$nodoc);
			$content_html = "<table style='border: 1px solid black;'><tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'><strong>Event Name</strong></td><td style='border: 1px solid black;'><strong>Event Organizer</strong></td><td style='border: 1px solid black;'><strong>Event Date</strong></td><td style='border: 1px solid black;'><strong>Cost Estimation</strong></td><td style='border: 1px solid black;'><strong>Created By</strong></td></tr>";
			$content_html = $content_html."<tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'>".$event_name."</td><td style='border: 1px solid black;'>".$event_organizer."</td><td style='border: 1px solid black;'>".$event_start_date." - ".$event_end_date."</td><td style='border: 1px solid black;'>".$amount."</td><td style='border: 1px solid black;'>".$created_by."</td></tr></table>";
			$content_html = $content_html."<br><br>";
			$content_html = $content_html."Please Click this link to <a href='".base_url()."index.php/MER?id=".$_GET['id']."&access=".$id_group."'>Approve or Review or Reject</a>";
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

//		echo "<script>window.close();</script>";
	}


	public function updateState()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$amount = 0;
		$nodoc = "";
		$event_name = "";
		$event_organizer = "";
		$created_by = "";
		$event_start_date = "";
		$event_end_date = "";
		$pm = "";
		$cs = "";
		$medical = "";
		$review = "";
		$bo = "";
		$cd = "";
		$pd = "";
		$gm = "";
		$id_group = "";
		$state = 0;
		$ma = "nurmala.sari@ma.taisho.co.id";
		$amount = 0;
		$query = $this->db->query("SELECT sum(replace(amount,'.','')*replace(description,'.','')) AS amount FROM budget_mer where id_parent=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$amount = $row2->amount;	
		}

		$query = $this->db->query("SELECT email, id_group FROM user WHERE active=1 and id_group IN (12,6,5,4,3,2,18)");
		foreach ($query->result() as $row2)
		{
			if($row2->id_group==12)
			{
				$cs = $row2->email;
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
			else if($row2->id_group==18)
			{
				$gm = $row2->email;
			}
			else if($row2->id_group==2)
			{
				$pd = $row2->email;
			}
		}

		$query = $this->db->query("SELECT review, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, state, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date, nodoc, event_name, event_organizer, name FROM mer a, user b where a.requested_by=b.id_user and id_mer=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;
			$event_name = $row2->event_name;	
			$event_organizer = $row2->event_organizer;	
			$created_by = $row2->name;
			$event_start_date = $row2->event_start_date;	
			$event_end_date = $row2->event_end_date;	
			$state = $row2->state;	
			$review = $row2->review;	
		}

		if($state==5 && intval($amount)<=300000000)
		{
			$this->db->set('state', '7', FALSE);
		}
		else
		{
			$this->db->set('state', 'state+1', FALSE);
		}
		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("mer");

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
			$this->db->set('updated_date2', "now()", FALSE);
			$this->db->set('approver2', "'".$GLOBALS['approver2']."'", FALSE);
			$this->db->set('title2', "'".$GLOBALS['title2']."'", FALSE);
		}
		else if($state==4)
		{
			$this->db->set('updated_date3', "now()", FALSE);
			$this->db->set('approver3', "'".$GLOBALS['approver3']."'", FALSE);
			$this->db->set('title3', "'".$GLOBALS['title3']."'", FALSE);
		}
		else if($state==5)
		{
			$this->db->set('updated_date4', "now()", FALSE);
			$this->db->set('approver4', "'".$GLOBALS['approver4']."'", FALSE);
			$this->db->set('title4', "'".$GLOBALS['title4']."'", FALSE);
		}
		else if($state==6)
		{
			$this->db->set('updated_date5', "now()", FALSE);
			$this->db->set('approver5', "'".$GLOBALS['approver5']."'", FALSE);
			$this->db->set('title5', "'".$GLOBALS['title5']."'", FALSE);
		}
		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("mer");

		if($state==1)
		{
			$email = $medical;
			$id_group = 5;
		}
		else if($state==2)
		{
			$id_group = 12;
			$email = $cs;
			$email2 = $pm;
			$email3 = $medical;
		}
		else if($state==3)
		{
			$id_group = 4;
			$email = $bo;
			$email2 = $pm.",".$medical;
			$email3 = $cs;
		}
		else if($state==4)
		{
			$id_group = 3;
			$email = $cd;
			$email2 = $pm.",".$medical.",".$cs;
			$email3 = $bo;
		}
		else if($state==5)
		{
			$id_group = 18;
			$email = $gm;
			$email2 = $pm.",".$medical.",".$cs.",".$bo;
			$email3 = $cd;
		}
		else if($state==6)
		{
			$email = "";
			$email2 = $pm.",".$medical.",".$cs.",".$bo.",".$cd.",".$gm;
			$email3 = $gm;
		}

		if($state<6)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
//			$this->email->to("yudhi_h_utama@yahoo.com");
			$this->email->to($email);
			$this->email->cc($ma);
			$this->email->subject('Please Approve MER with No '.$nodoc);
			$content_html = "<table style='border: 1px solid black;'><tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'><strong>Event Name</strong></td><td style='border: 1px solid black;'><strong>Event Organizer</strong></td><td style='border: 1px solid black;'><strong>Event Date</strong></td><td style='border: 1px solid black;'><strong>Cost Estimation</strong></td><td style='border: 1px solid black;'><strong>Created By</strong></td></tr>";
			$content_html = $content_html."<tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'>".$event_name."</td><td style='border: 1px solid black;'>".$event_organizer."</td><td style='border: 1px solid black;'>".$event_start_date." - ".$event_end_date."</td><td style='border: 1px solid black;'>".$amount."</td><td style='border: 1px solid black;'>".$created_by."</td></tr></table>";
			$content_html = $content_html."<br><br>";
			$content_html = $content_html."Please Click this link to <a href='".base_url()."index.php/MER?id=".$_GET['id']."&access=".$id_group."'>Approve or Review or Reject</a>";
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
			$this->email->subject('MER with No '.$nodoc. ' has been Approved by '.$email3);
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
//		echo "<script>window.close();</script>";
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
		$pm = "";
		$medical = "";
		$bo = "";
		$cd = "";
		$cs = "";
		$pd = "";
		$gm = "";
		$note1 = "";
		$note2 = "";
		$note3 = "";
		$note4 = "";
		$note5 = "";
		$ma = "nurmala.sari@ma.taisho.co.id";
		$state = 0;
		$query = $this->db->query("SELECT sum(replace(amount,'.','')*replace(description,'.','')) AS amount FROM budget_mer where id_parent=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$amount = $row2->amount;	
		}

		$query = $this->db->query("SELECT email, id_group FROM user WHERE active=1 and id_group IN (12,6,5,4,3,2,18)");
		foreach ($query->result() as $row2)
		{
			if($row2->id_group==12)
			{
				$cs = $row2->email;
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
			else if($row2->id_group==18)
			{
				$gm = $row2->email;
			}
			else if($row2->id_group==2)
			{
				$pd = $row2->email;
			}
		}

		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, note1, note2, note3, note4, note5, state, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date, nodoc, event_name, event_organizer, name FROM mer a, user b where a.requested_by=b.id_user and id_mer=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$note1 = $row2->note1;
			$note2 = $row2->note2;
			$note3 = $row2->note3;
			$note4 = $row2->note4;
			$note5 = $row2->note5;
			$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;	
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
			$email3 = $cs;
		}
		else if($state==4)
		{
			$note = $note3;
			$email2 = $pm.",".$medical.",".$cs;
			$email3 = $bo;
		}
		else if($state==5)
		{
			$note = $note4;
			$email2 = $pm.",".$medical.",".$cs.",".$bo;
			$email3 = $cd;
		}
		else if($state==6)
		{
			$note = $note5;
			$email2 = $pm.",".$medical.",".$cs.",".$bo.",".$cd;
			$email3 = $gm;
		}

		$data = array(
   				'state' => "8");
		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("mer",$data);

		if($state>=2)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
			$this->email->to($email2);
			$this->email->cc($ma);
			$this->email->subject('MER with No '.$nodoc. ' has been Rejected by '.$email3);
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
		$pm = "";
		$medical = "";
		$bo = "";
		$cd = "";
		$cs = "";
		$pd = "";
		$gm = "";
		$note1 = "";
		$note2 = "";
		$note3 = "";
		$ma = "nurmala.sari@ma.taisho.co.id";
		$note4 = "";
		$note5 = "";
		$state = 0;
		$query = $this->db->query("SELECT sum(replace(amount,'.','')*replace(description,'.','')) AS amount FROM budget_mer where id_parent=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$amount = $row2->amount;	
		}

		$query = $this->db->query("SELECT email, id_group FROM user WHERE active=1 and id_group IN (12,6,5,4,3,2,18)");
		foreach ($query->result() as $row2)
		{
			if($row2->id_group==12)
			{
				$cs = $row2->email;
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
			else if($row2->id_group==18)
			{
				$gm = $row2->email;
			}
			else if($row2->id_group==2)
			{
				$pd = $row2->email;
			}
		}

		$this->db->set('review', '1', FALSE);
		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("mer");

		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, note1, note2, note3, note4, note5, state, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date, nodoc, event_name, event_organizer, name FROM mer a, user b where a.requested_by=b.id_user and id_mer=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$note1 = $row2->note1;
			$note2 = $row2->note2;
			$note3 = $row2->note3;
			$note4 = $row2->note4;
			$note5 = $row2->note5;
			$nodoc = date("Y",strtotime($row2->created_date))."/MER/".date("m",strtotime($row2->created_date))."/".$row2->nodoc;	
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
			$email3 = $cs;
		}
		else if($state==4)
		{
			$note = $note3;
			$email2 = $pm.",".$medical.",".$cs;
			$email3 = $bo;
		}
		else if($state==5)
		{
			$note = $note4;
			$email2 = $pm.",".$medical.",".$cs.",".$bo;
			$email3 = $cd;
		}
		else if($state==6)
		{
			$note = $note5;
			$email2 = $pm.",".$medical.",".$cs.",".$bo.",".$cd;
			$email3 = $gm;
		}

		$this->db->set('state', '1', FALSE);
		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("mer");

			$data = array(
				'approver0'=>'',
				'approver1'=>'',
				'approver2'=>'',
				'approver3'=>'',
				'approver4'=>'',
				'approver5'=>'',
				'title0'=>'',
				'title1'=>'',
				'title2'=>'',
				'title3'=>'',
				'title4'=>'',
				'title5'=>''
			);

		$this->db->where('id_mer', $_GET['id']);
		$this->db->update("mer",$data);

		if($state>=2)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
			$this->email->to($email2);
			$this->email->cc($ma);
			$this->email->subject($email3.' Request to review MER with No '.$nodoc);
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
        $start_date = explode('/', $this->input->post('event_start_date') );
        $start_date2 = $start_date[2].'-'.$start_date[1].'-'.$start_date[0];

		$end_date = explode('/', $this->input->post('event_end_date') );
        $end_date2 = $end_date[2].'-'.$end_date[1].'-'.$end_date[0];

		$i = 0;
		$j = 0;
		$id_mer = 0;

		$speciality2 = "";
		if($this->input->post('speciality')!=null)
		{	
			$speciality = $this->input->post('speciality');
			$speciality2 = "";

			foreach ($speciality as $a){
				$speciality2 = $speciality2.$a.",";
			}
			$speciality2 = substr_replace($speciality2 ,"",-1);
		}

		$speciality2b = "";
		if($this->input->post('speciality2')!=null)
		{	
			$specialityb = $this->input->post('speciality2');
			$speciality2b = "";

			foreach ($specialityb as $a){
				$speciality2b = $speciality2b.$a.",";
			}
			$speciality2b = substr_replace($speciality2b ,"",-1);
		}

		$data = array(
            'location' => $this->input->post('location'),
            'nodoc2' => $this->input->post('nodoc2'),
            'nodoc' => $this->input->post('nodoc'),
			'type' => $this->input->post('type'),
            'requested_by' => $this->input->post('requested_by'),
            'event_name' => $this->input->post('event_name'),
            'event_organizer' => $this->input->post('event_organizer'),
            'event_venue' => $this->input->post('event_venue'),
            'event_start_date' => $start_date2,
            'event_end_date' => $end_date2,
            'event_quota' => $this->input->post('event_quota'),
            'topic' => $this->input->post('topic'),
            'presentation' => $this->input->post('presentation'),
            'speciality' => $speciality2,
            'speciality2' => $speciality2b,
            'note1' => $this->input->post('note1'),
            'note2' => $this->input->post('note2'),
            'note3' => $this->input->post('note3'),
            'note4' => $this->input->post('note4'),
            'note5' => $this->input->post('note5')
        );
		if(empty($this->input->post('id_parent')))
		{
			$this->db->insert("mer",$data);
			$id_mer = $this->db->insert_id();
		}	
		else
		{
			$this->db->where('id_mer', $this->input->post('id_parent'));
			$this->db->update("mer",$data);
			$id_mer = $this->input->post('id_parent');

			$query = $this->db->query("select id_charge from charge_product where type=1 and id_parent=".$id_mer." order by id_charge");
			foreach ($query->result() as $row2)
			{
				$id_charge[] = $row2->id_charge;
				$i = $i + 1;
			}	

			$query = $this->db->query("select id_budget from budget_mer where id_parent=".$id_mer." order by id_budget");
			foreach ($query->result() as $row2)
			{
				$id_budget[] = $row2->id_budget;
				$j = $j + 1;
			}	

		}	

		//
		

		$data3 = array(
            'sponsor_type' => "Symposium/Congres",
            'amount' => $this->input->post('amount1'),
            'id_parent' => $id_mer,
            'description' => $this->input->post('description1')
        );
		if($i==0)
		{
			$this->db->insert("budget_mer",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[0]);
			$this->db->update("budget_mer",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Booth",
            'amount' => $this->input->post('amount2'),
            'id_parent' => $id_mer,
            'description' => $this->input->post('description2')
        );
		if($i==0)
		{
			$this->db->insert("budget_mer",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[1]);
			$this->db->update("budget_mer",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Registration",
            'amount' => $this->input->post('amount3'),
            'id_parent' => $id_mer,
            'description' => $this->input->post('description3')
        );
		if($i==0)
		{
			$this->db->insert("budget_mer",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[2]);
			$this->db->update("budget_mer",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Travel",
            'amount' => $this->input->post('amount4'),
            'id_parent' => $id_mer,
            'description' => $this->input->post('description4')
        );
		if($i==0)
		{
			$this->db->insert("budget_mer",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[3]);
			$this->db->update("budget_mer",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Accommodation",
            'amount' => $this->input->post('amount5'),
            'id_parent' => $id_mer,
            'description' => $this->input->post('description5')
        );
		if($i==0)
		{
			$this->db->insert("budget_mer",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[4]);
			$this->db->update("budget_mer",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Business Meeting",
            'amount' => $this->input->post('amount6'),
            'id_parent' => $id_mer,
            'description' => $this->input->post('description6')
        );
		if($j==0)
		{
			$this->db->insert("budget_mer",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[5]);
			$this->db->update("budget_mer",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Speaker Fee",
            'amount' => $this->input->post('amount7'),
            'id_parent' => $id_mer,
            'description' => $this->input->post('description7')
        );
		if($j==0)
		{
			$this->db->insert("budget_mer",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[6]);
			$this->db->update("budget_mer",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Booth Construction",
            'amount' => $this->input->post('amount8'),
            'id_parent' => $id_mer,
            'description' => $this->input->post('description8')
        );
		if($j==0)
		{
			$this->db->insert("budget_mer",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[7]);
			$this->db->update("budget_mer",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "PP",
            'amount' => $this->input->post('amount9'),
            'id_parent' => $id_mer,
            'description' => $this->input->post('description9')
        );
		if($j==0)
		{
			$this->db->insert("budget_mer",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[8]);
			$this->db->update("budget_mer",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "RTD",
            'amount' => $this->input->post('amount10'),
            'id_parent' => $id_mer,
            'description' => $this->input->post('description10')
        );
		if($j==0)
		{
			$this->db->insert("budget_mer",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[9]);
			$this->db->update("budget_mer",$data3);
		}	


		$type_sponsor = $this->input->post('type_sponsor');
		$amount = $this->input->post('amount');
		$description = $this->input->post('description');

		$k = 0;
		foreach ($type_sponsor as $a)
		{
			$data3 = array(
				'sponsor_type' => $a,
				'amount' => $amount[$k],
				'id_parent' => $id_mer,
				'description' => $description[$k]
			);
			if(empty($id_budget[10+$k]))
			{
				$this->db->insert("budget_mer",$data3);
			}
			else
			{
				$this->db->where('id_budget', $id_budget[10+$k]);
				$this->db->update("budget_mer",$data3);
			}
			$k = $k + 1;
		}
		if($j>$k)
		{
			for($l=($k+10);$l<$j;$l++)
			{
				$this->db->where('id_budget',$id_budget[$l]);
				$this->db->delete('budget_mer');				
			}			
		}

		//Charge Product

		$data2 = array(
            'id_product' => $this->input->post('product1'),
			'type' => "1",
            'id_parent' => $id_mer,
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
			'type' => "1",
            'id_parent' => $id_mer,
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
			'type' => "1",
            'id_parent' => $id_mer,
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
			'type' => "1",
            'id_parent' => $id_mer,
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

		redirect(base_url()."index.php/MER?id=".$id_mer."&type=".$this->input->post('type'));
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

	public function getProduct()
	{
		$result="[";
		$query = $this->db->query("SELECT DISTINCT b.id_group, b.name  FROM product_group b ORDER BY NAME");
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id_group."\",\"name\":\"".$row2->name."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}

	public function getSpeciality()
	{
		$result="[";
		$query = $this->db->query("select id_speciality, name_speciality from speciality order by name_speciality");
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id_speciality."\",\"name\":\"".$row2->name_speciality."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}

	public function getSpeciality2()
	{
		$speciality = "";
		if(isset($_GET['id'])==true)
		{
			$query = $this->db->query("select speciality from mer where id_mer='".$_GET['id']."'");
		}
		if(isset($_GET['id_hcp1'])==true)
		{
			$query = $this->db->query("select speciality from hcp1 where id_hcp1='".$_GET['id_hcp1']."'");
		}	
		if(isset($_GET['id_sc'])==true)
		{
			$query = $this->db->query("select id_speciality as speciality from scientific_hcp a, doctor b where a.name_hcp=b.id_doctor and institution_hcp='".$_GET['institution_hcp']."' and id_sc='".$_GET['id_sc']."'");
		}	
		if(isset($_GET['id_hcp2'])==true)
		{
			$query = $this->db->query("select speciality from hcp1 a, hcp2 b where a.id_hcp1=b.id_hcp1 and id_hcp2='".$_GET['id_hcp2']."'");
		}	
		foreach ($query->result() as $row2)
		{			
			$speciality = $speciality.$row2->speciality.",";
		}
		$speciality = str_replace(',','\',\'',$speciality);

		$result="[";
		$query = $this->db->query("select id_speciality, name_speciality from speciality where id_speciality in ('".$speciality."') order by name_speciality");
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id_speciality."\",\"name\":\"".$row2->name_speciality."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}

	public function getUser()
	{
		$result="[";
		$query = $this->db->query("SELECT id_user, CONCAT(a.name,' - ',b.name) AS user_name  FROM user a, groups b WHERE a.id_group=b.id AND a.id_user=".$_GET['id']);
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id_user."\",\"name\":\"".$row2->user_name."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}


	public function getUser2()
	{
		$result="[";
		$query = $this->db->query("SELECT id_user, CONCAT(a.name,' - ',b.name) AS user_name  FROM user a, groups b WHERE a.id_group=b.id AND a.id_group in ('7','5','6','8','9')");
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id_user."\",\"name\":\"".$row2->user_name."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}

	public function getLeader()
	{
		$result="[";
		$query = $this->db->query("SELECT id_user, CONCAT(a.name,' - ',b.name) AS user_name  FROM user a, groups b WHERE a.id_group=b.id AND id_user IN (SELECT id_department FROM user WHERE id_user=".$_GET['id'].")");
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id_user."\",\"name\":\"".$row2->user_name."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}

	public function getAmount()
	{
		$amount = 0;
		$query = $this->db->query("SELECT sum(replace(amount,'.','')*replace(description,'.','')) as amount from budget_mer where id_parent=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$amount = $row2->amount;	
		}
		echo $amount;
	}

	public function getListAttachment()
	{
		$type = 0;
		$query = $this->db->query("select distinct file_type from attachment where type=1 and id_parent=".$_GET['id']." and file_type in (3) order by file_type");
		foreach ($query->result() as $row2)
		{
			$type = $type + $row2->file_type;	
		}
		echo $type;
	}

	public function getAttachment()
	{

		$type = 0;
		$query = $this->db->query("select distinct file_type from attachment where type=1 and id_parent=".$_GET['id']." and file_type in (3) order by file_type");
		foreach ($query->result() as $row2)
		{
			$type = $type + $row2->file_type;	
		}

		$result = "";
		$file_type = array("1"=>"Proposal", "2"=>"Event Clarificartion", "3"=>"Presentation Material","4"=>"Announcement","5"=>"Others");
		$query = $this->db->query("select id_attachment, file_name, file_type from attachment where type=1 and id_parent=".$_GET['id']." order by file_type");
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
				style='border-left:1px solid black;width:225px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;word-wrap: break-word;'
			>
				&nbsp;".$file_type[$row2->file_type]."&nbsp;
			</div>
			<div
				class='col-xs-1'
			>
			";
			if(($this->session->userdata('id_group')==6 && $_GET['state']=="1") || ($this->session->userdata('id_group')==5 && $_GET['state']=="2"))
			{
				$result=$result."<a href='javascript:deleteAttachment(".$row2->id_attachment.")'><i class='fa fa-times fa-2x' aria-hidden='true'></i></a>";
			}
			$result=$result."</div>
			</div>";
		}
		if($type==0)
		{
			if($_GET['tpi']==1)
			{
				/*$result=$result."<div class='row'>
				<div
					class='col-xs-1'
					style='border-left:1px solid black;width:585px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;color:red'
				>
					&nbsp;Please Submit Proposal
				</div></div>";*/
			}
			if($_GET['tpi']==2)
			{
				$result=$result."<div class='row'>
				<div
					class='col-xs-1'
					style='border-left:1px solid black;width:585px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;color:red'
				>
					&nbsp;Please Submit Presentation Material
				</div></div>";
			}
		}
		if($type==3)
		{
			/*$result=$result."<div class='row'>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:585px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;color:red'
			>
				&nbsp;Please Submit Proposal
			</div></div>";*/
		}
		echo $result;

	}	


	public function upload()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
        $file_name = $this->upload_file('file');
		$data = array(
			'file_name' => $file_name,
			'type' => "1",
			'file_type' => $this->input->post('file_type'),
			'id_parent' => $this->input->post('id_parent')
		);
		$this->db->insert("attachment",$data);
	}

}
