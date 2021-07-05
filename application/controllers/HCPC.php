<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HCPC extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url','form');
		$this->load->library('email');

		$this->load->library('session');
		$this->load->library('user_agent');
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
		$k = 0;
		if(isset($_GET['id'])==true)
		{
			$query = $this->db->query("select active, id_mer, night, DATE_FORMAT(updated_date3,'%d-%M-%Y') as updated_date3, DATE_FORMAT(updated_date1,'%d-%M-%Y') as updated_date1, DATE_FORMAT(updated_date2,'%d-%M-%Y') as updated_date2, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, payee_type, flight, room, exchange, event_name, event_organizer, event_venue, nodoc2, requested_by, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date, DATE_FORMAT(event_start_date1,'%d/%m/%Y') as event_start_date1, DATE_FORMAT(event_end_date1,'%d/%m/%Y') as event_end_date1, DATE_FORMAT(event_start_date2,'%d/%m/%Y') as event_start_date2, DATE_FORMAT(event_end_date2,'%d/%m/%Y') as event_end_date2, event_institution, event_contact, payee, bank, branch, account_number, medicheck, doctor, note1, state, note2, reason, note3 from hcp where id_hcp=".$_GET['id']);
			foreach ($query->result() as $row2)
			{
				$data = array(
					'event_organizer' => $row2->event_organizer,
					'event_name' => $row2->event_name,
					'event_venue' => $row2->event_venue,
					'event_start_date' => $row2->event_start_date,
					'event_end_date' => $row2->event_end_date,
					'event_institution' => $row2->event_institution,
					'event_contact' => $row2->event_contact,
					'event_start_date1' => $row2->event_start_date1,
					'event_end_date1' => $row2->event_end_date1,
					'event_start_date2' => $row2->event_start_date2,
					'event_end_date2' => $row2->event_end_date2,
					'nodoc2' => $row2->nodoc2,
					'night' => $row2->night,
					'reason' => $row2->reason,
					'nodoc' => "",
					'medicheck' => $row2->medicheck,
					'doctor' => $row2->doctor,
					'requested_by' => $row2->requested_by,
					'payee' => $row2->payee,
					'bank' => $row2->bank,
					'active' => $row2->active,
					'branch' => $row2->branch,
					'account_number' => $row2->account_number,
					'state' => $row2->state,
					'room' => $row2->room,
					'exchange' => $row2->exchange,
					'flight' => $row2->flight,
					'note1' => $row2->note1,
					'note2' => $row2->note2,
					'note3' => $row2->note3,
					'created_date' => $row2->created_date,
					'created_date2' => "",
					'updated_date1' => $row2->updated_date1,
					'updated_date2' => $row2->updated_date2,
					'updated_date3' => $row2->updated_date3,
					'payee_type' => $row2->payee_type
				);
				$k = $k + 1;
			}
		}

		if($k==0)
		{
			$query = $this->db->query("select max(nodoc2)+1 as nodoc from hcp where year='".date("Y")."'");
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
				'event_organizer' => "",
				'event_name' => "",
				'event_venue' => "",
				'event_start_date' => "",
				'event_end_date' => "",
				'nodoc' => "",
				'reason' => "",
				'event_start_date1' => "",
				'event_end_date1' => "",
				'event_start_date2' => "",
				'event_end_date2' => "",
				'event_contact' => "",
				'event_institution' => "",
				'nodoc2' => $nodoc,
				'budget' => "4",
				'medicheck' => "",
				'doctor' => "",
				'created_date' => date("d-M-Y"),
				'created_date2' => "",
				'requested_by' => "9",
				'payee' => "",
				'bank' => "",
				'branch' => "",
				'account_number' => "",
				'state' => "1",
				'active' => "1",
				'room' => "",
				'night' => "",
				'exchange' => "",
				'flight' => "",
				'note1' => "",
				'note2' => "",
				'payee_type' => "1"
			);
		}	

		$i=0;
		if(isset($_GET['id'])==true)
		{
			$query = $this->db->query("select id_product, percent from charge_product where type=6 and id_parent=".$_GET['id']." order by id_charge");
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
		if(isset($_GET['id'])==true)
		{
			$query = $this->db->query("select sponsor_type, description, local_amount, foreign_amount from budget_hcp where id_parent=".$_GET['id']);
			foreach ($query->result() as $row2)
			{
				$sponsor_text = "sponsor".($i+1);
				$foreign_amount_text = "foreign_amount".($i+1);
				$description_text = "description".($i+1);
				$local_amount_text = "local_amount".($i+1);
				if($row2->sponsor_type=="Travel")
				{
					$data = array_merge($data, array('local_amount1'=>$row2->local_amount));
					$data = array_merge($data, array('foreign_amount1'=>$row2->foreign_amount));
				}
				else if($row2->sponsor_type=="Accommodation")
				{
					$data = array_merge($data, array('local_amount2'=>$row2->local_amount));
					$data = array_merge($data, array('foreign_amount2'=>$row2->foreign_amount));
				}
				else if($row2->sponsor_type=="Registration Fee")
				{
					$data = array_merge($data, array('description3'=>$row2->description));
					$data = array_merge($data, array('local_amount3'=>$row2->local_amount));
					$data = array_merge($data, array('foreign_amount3'=>$row2->foreign_amount));
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
			$data = array_merge($data, array('sponsor4'=>""));
			$data = array_merge($data, array('local_amount4'=>"0"));
			$data = array_merge($data, array('foreign_amount4'=>"0"));
			$data = array_merge($data, array('description4'=>""));
			$data = array_merge($data, array('local_amount1'=>"0"));
			$data = array_merge($data, array('foreign_amount1'=>"0"));
			$data = array_merge($data, array('local_amount2'=>"0"));
			$data = array_merge($data, array('foreign_amount2'=>"0"));
			$data = array_merge($data, array('description3'=>""));
			$data = array_merge($data, array('local_amount3'=>"0"));
			$data = array_merge($data, array('foreign_amount3'=>"0"));
		}	

		if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
		{
			$this->load->view('hcpc',$data);
		}
		else if($_GET['access']>=1 && $_GET['access']<=18)
		{
			$this->load->view('hcpc',$data);
		}
		else
		{
			$this->load->view('login');
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
		$this->db->delete("budget_hcp");

		$this->db->where('id_hcp', $_GET['id']);
		$this->db->delete("hcp");
		echo "This data has been deleted";
	}

	public function updateState4()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$this->db->set('active', $_GET['active'], FALSE);
		$this->db->where('id_hcp', $_GET['id']);
		$this->db->update("hcp");		
	}

	public function updateState()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$state = 0;
		$query = $this->db->query("SELECT state FROM hcp where id_hcp=".$_GET['id']);
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
		$cd = "";
		$od = "";
		$review = "";
		$pd = "";
		$note1 = "";
		$note2 = "";
		$note3 = "";
		$query = $this->db->query("SELECT sum(replace(local_amount,'.','')) AS amount FROM budget_hcp where id_parent=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$amount = $row2->amount;	
		}

		$query = $this->db->query("SELECT email, id_group FROM user WHERE id_group IN (16,7,6,5,4,3,2)");
		foreach ($query->result() as $row2)
		{
			if($row2->id_group==16)
			{
				$od = $row2->email;
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

		$query = $this->db->query("SELECT review, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, note1, note2, note3, state, DATE_FORMAT(event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') AS event_end_date, nodoc2, event_name, event_organizer, name FROM hcp a, user b WHERE a.requested_by=b.id_user AND id_hcp=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$note1 = $row2->note1;
			$note2 = $row2->note2;
			$note3 = $row2->note3;
			$nodoc = date("Y",strtotime($row2->created_date))."/HCPC/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
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
			$email = $bo;
		}
		else if($state==2)
		{
			$email = $cd;
			$email2 = $medical;
			$email3 = $bo;
		}
		else if($state==3)
		{
			$email = $od;
			$email2 = $medical.",".$bo;
			$email3 = $cd;
		}
		else if($state==4)
		{
			$email = "";
			$email2 = $medical.",".$bo.",".$cd;
			$email3 = $od;
		}

		if($state==4)
		{
			$this->db->set('state', '6', FALSE);
		}
		else
		{
			$this->db->set('state', 'state+1', FALSE);
		}
		$this->db->where('id_hcp', $_GET['id']);
		$this->db->update("hcp");

		if($state==1)
		{
			if($review==0)
			{
				$this->db->set('created_date', 'now()', FALSE);
			}
		}
		else if($state==2)
		{
			$this->db->set('updated_date1', 'now()', FALSE);			
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
		$this->db->where('id_hcp', $_GET['id']);
		$this->db->update("hcp");

		if($state<4)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
			$this->email->to($email);
			$this->email->subject('Please Approve HCP Conusltant with No '.$nodoc);
			$content_html = "<table style='border: 1px solid black;'><tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'><strong>Event Name</strong></td><td style='border: 1px solid black;'><strong>Event Organizer</strong></td><td style='border: 1px solid black;'><strong>Event Date</strong></td><td style='border: 1px solid black;'><strong>Cost Estimation</strong></td><td style='border: 1px solid black;'><strong>Created By</strong></td></tr>";
			$content_html = $content_html."<tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'>".$event_name."</td><td style='border: 1px solid black;'>".$event_organizer."</td><td style='border: 1px solid black;'>".$event_start_date." - ".$event_end_date."</td><td style='border: 1px solid black;'>".$amount."</td><td style='border: 1px solid black;'>".$created_by."</td></tr></table>";
			$content_html = $content_html."<br><br>";
			$content_html = $content_html."Please Click this link to <a href='".base_url()."index.php/HCPC?id=".$_GET['id']."&access=".($_GET['id_group']-1)."'>Approve or Review or Reject</a>";
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
			$this->email->subject('HCP Consultant with No '.$nodoc. ' has been Approved by '.$email3);
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
		$od = "";
		$cd = "";
		$pd = "";
		$note1 = "";
		$note2 = "";
		$note3 = "";
		$state = 0;
		$query = $this->db->query("SELECT sum(replace(local_amount,'.','')) AS amount FROM budget_hcp where id_parent=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$amount = $row2->amount;	
		}

		$query = $this->db->query("SELECT email, id_group FROM user WHERE id_group IN (16,7,6,5,4,3,2)");
		foreach ($query->result() as $row2)
		{
			if($row2->id_group==16)
			{
				$od = $row2->email;
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

		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, note1, note2, note3, state, DATE_FORMAT(event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') AS event_end_date, nodoc2, event_name, event_organizer, name FROM hcp a, user b WHERE a.requested_by=b.id_user AND id_hcp=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$note1 = $row2->note1;
			$note2 = $row2->note2;
			$note3 = $row2->note3;
			$nodoc = date("Y",strtotime($row2->created_date))."/HCPC/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
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
			$email2 = $medical;
			$email3 = $bo;
		}
		else if($state==3)
		{
			$note = $note2;
			$email2 = $medical.",".$bo;
			$email3 = $cd;
		}
		else if($state==4)
		{
			$note = $note3;
			$email2 = $medical.",".$bo.",".$cd;
			$email3 = $od;
		}

		$data = array(
   				'state' => "7");
		$this->db->where('id_hcp', $_GET['id']);
		$this->db->update("hcp",$data);

		if($state>=2)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
			$this->email->to($email2);
			$this->email->subject('HCP Consultant with No '.$nodoc. ' has been Rejected by '.$email3);
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
		$od = "";
		$cd = "";
		$pd = "";
		$note1 = "";
		$note2 = "";
		$note3 = "";
		$state = 0;
		$query = $this->db->query("SELECT sum(replace(local_amount,'.','')) AS amount FROM budget_hcp where id_parent=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$amount = $row2->amount;	
		}

		$query = $this->db->query("SELECT email, id_group FROM user WHERE id_group IN (16,7,6,5,4,3,2)");
		foreach ($query->result() as $row2)
		{
			if($row2->id_group==16)
			{
				$od = $row2->email;
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

		$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, note1, note2, note3, state, DATE_FORMAT(event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') AS event_end_date, nodoc2, event_name, event_organizer, name FROM hcp a, user b WHERE a.requested_by=b.id_user AND id_hcp=".$_GET['id']);
		foreach ($query->result() as $row2)
		{
			$note1 = $row2->note1;
			$note2 = $row2->note2;
			$note3 = $row2->note3;
			$nodoc = date("Y",strtotime($row2->created_date))."/HCPC/".date("m",strtotime($row2->created_date))."/".$row2->nodoc2;
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
			$email2 = $medical;
			$email3 = $bo;
		}
		else if($state==3)
		{
			$note = $note2;
			$email2 = $medical.",".$bo;
			$email3 = $cd;
		}
		else if($state==4)
		{
			$note = $note3;
			$email2 = $medical.",".$bo.",".$cd;
			$email3 = $od;
		}

		$this->db->set('state', '1', FALSE);
		$this->db->where('id_hcp', $_GET['id']);
		$this->db->update("hcp");

		$this->db->set('review', '1', FALSE);
		$this->db->where('id_hcp', $_GET['id']);
		$this->db->update("hcp");

		if($state>=2)
		{
			$this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
			$this->email->to($email2);
			$this->email->subject($email3.' Request to review HCP Consultant with No '.$nodoc);
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
        if($start_date=="")
		{	
			$start_date2 = '1970-01-01';
		}
		else
		{
			$start_date = explode('/', $this->input->post('event_start_date'));		
			$start_date2 = $start_date[2].'-'.$start_date[1].'-'.$start_date[0];
		}	

        if($end_date=="")
		{	
			$end_date2 = '1970-01-01';
		}
		else
		{	
			$end_date = explode('/', $this->input->post('event_end_date'));
			$end_date2 = $end_date[2].'-'.$end_date[1].'-'.$end_date[0];
		}	

        if($start_date1=="")
		{	
			$start_date12 = '1970-01-01';
		}
		else
		{
			$start_date1 = explode('/', $this->input->post('event_start_date1'));
			$start_date12 = $start_date1[2].'-'.$start_date1[1].'-'.$start_date1[0];
		}	

        if($end_date1=="")
		{	
			$end_date12 = '1970-01-01';
		}
		else
		{
			$end_date1 = explode('/', $this->input->post('event_end_date1'));
			$end_date12 = $end_date1[2].'-'.$end_date1[1].'-'.$end_date1[0];
		}	

        if($start_date3=="")
		{	
			$start_date32 = '1970-01-01';
		}
		else
		{
			$start_date3 = explode('/', $this->input->post('event_start_date2'));
			$start_date32 = $start_date3[2].'-'.$start_date3[1].'-'.$start_date3[0];
		}	

        if($end_date3=="")
		{	
			$end_date32 = '1970-01-01';
		}
		else
		{
			$end_date3 = explode('/', $this->input->post('event_end_date2'));
			$end_date32 = $end_date3[2].'-'.$end_date3[1].'-'.$end_date3[0];
		}	

		$i = 0;
		$j = 0;

		$data = array(
			'id_mer' => "0",
			'event_organizer' => $this->input->post('event_organizer'),
			'event_name' => $this->input->post('event_name'),
			'event_venue' => $this->input->post('event_venue'),
			'event_start_date' => $start_date2,
			'event_end_date' => $end_date2,
			'event_institution' => $this->input->post('event_institution'),
			'event_contact' => $this->input->post('event_contact'),
			'event_start_date1' => $start_date12,
			'event_end_date1' => $end_date12,
			'event_start_date2' => $start_date32,
			'event_end_date2' => $end_date32,
			'reason' => $this->input->post('reason'),
			'nodoc2' => $this->input->post('nodoc2'),
			'medicheck' => $this->input->post('medicheck'),
			'doctor' => $this->input->post('doctor'),
			'requested_by' => $this->input->post('requested_by1'),
			'payee' => $this->input->post('payee'),
			'bank' => $this->input->post('bank'),
			'branch' => $this->input->post('branch'),
			'account_number' => $this->input->post('account_number'),
			'room' => $this->input->post('room'),
			'night' => $this->input->post('night'),
			'exchange' => $this->input->post('exchange'),
			'flight' => $this->input->post('flight'),
			'note1' => $this->input->post('note1'),
			'note2' => "",
			'payee_type' => $this->input->post('payee_type')
		);
		if(empty($this->input->post('id_parent')))
		{
			$this->db->insert("hcp",$data);
			$id_hcp = $this->db->insert_id();
		}	
		else
		{
			$this->db->where('id_hcp', $this->input->post('id_parent'));
			$this->db->update("hcp",$data);
			$id_hcp = $this->input->post('id_parent');

			$query = $this->db->query("select id_charge from charge_product where type=6 and id_parent=".$id_hcp." order by id_charge");
			foreach ($query->result() as $row2)
			{
				$id_charge[] = $row2->id_charge;
				$i = $i + 1;
			}	

			$query = $this->db->query("select id_budget from budget_hcp where id_parent=".$id_hcp." order by id_budget");
			foreach ($query->result() as $row2)
			{
				$id_budget[] = $row2->id_budget;
				$j = $j + 1;
			}	

		}	

		//
		

		$data3 = array(
            'sponsor_type' => "Travel",
            'local_amount' => $this->input->post('local_amount1'),
            'foreign_amount' => $this->input->post('foreign_amount1'),
            'id_parent' => $id_hcp,
            'description' => ""
        );
		if($i==0)
		{
			$this->db->insert("budget_hcp",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[0]);
			$this->db->update("budget_hcp",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Accommodation",
            'local_amount' => $this->input->post('local_amount2'),
            'foreign_amount' => $this->input->post('foreign_amount2'),
            'id_parent' => $id_hcp,
            'description' => ""
        );
		if($i==0)
		{
			$this->db->insert("budget_hcp",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[1]);
			$this->db->update("budget_hcp",$data3);
		}	

		$data3 = array(
            'sponsor_type' => "Registration Fee",
            'local_amount' => $this->input->post('local_amount3'),
            'foreign_amount' => $this->input->post('foreign_amount3'),
            'id_parent' => $id_hcp,
            'description' => $this->input->post('description3')
        );
		if($i==0)
		{
			$this->db->insert("budget_hcp",$data3);
		}
		else
		{
			$this->db->where('id_budget', $id_budget[2]);
			$this->db->update("budget_hcp",$data3);
		}	



		//Charge Product

		$data2 = array(
            'id_product' => $this->input->post('product1'),
			'type' => "6",
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
			'type' => "6",
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
			'type' => "6",
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
			'type' => "6",
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
				'id_parent' => $id_hcp,
				'description' => $description[$k]
			);
			if(empty($id_budget[3+$k]))
			{
				$this->db->insert("budget_hcp",$data3);
			}
			else
			{
				$this->db->where('id_budget', $id_budget[3+$k]);
				$this->db->update("budget_hcp",$data3);
			}
			$k = $k + 1;
		}
		if($j>$k)
		{
			for($l=($k+3);$l<$j;$l++)
			{
				$this->db->where('id_budget',$id_budget[$l]);
				$this->db->delete('budget_hcp');				
			}			
		}


//		echo "<script>window.close();</script>";
		redirect(base_url()."index.php/HCPC?id=".$id_hcp);
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
		/*$query = $this->db->query("select distinct file_type from attachment where type=9 and id_parent=".$_GET['id']." and file_type in (2) order by file_type");
		foreach ($query->result() as $row2)
		{
			$type = $type + $row2->file_type;	
		}
		echo $type;*/
	}

	public function getDoctor()
	{
		$result="[";
//		$result=$result."{\"id\":\"0\",\"name\":\"\"}";
		$query = $this->db->query("select id_doctor, name from doctor order by name");
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id_doctor."\",\"name\":\"".$row2->name."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}

	public function getMedicheck()
	{
		$result="";
		$query = $this->db->query("select medicheck from doctor where id_doctor=".$_GET['id_doctor']);
		foreach ($query->result() as $row2)
		{			
			$result=$row2->medicheck;
		}
		echo $result;
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

	public function getAttachment()
	{

		$type = 0;
		$query = $this->db->query("select distinct file_type from attachment where type=9 and id_parent=".$_GET['id']." and file_type in (2) order by file_type");
		foreach ($query->result() as $row2)
		{
			$type = $type + $row2->file_type;	
		}

		$result = "";
		$file_type = array("1"=>"Travel Itinerary","2"=>"Others");
		$query = $this->db->query("select id_attachment, file_name, file_type from attachment where type=9 and id_parent=".$_GET['id']." order by file_type");
		foreach ($query->result() as $row2)
		{	
			$result=$result."<div class='row'>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:340px;text-align:center;border-bottom:1px solid black;word-wrap: break-word;'
			>
				&nbsp;<a href='".base_url()."/assets/img/".$row2->file_name."' target='popup'>".$row2->file_name."</a>&nbsp;
			</div>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:260px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;word-wrap: break-word;'
			>
				&nbsp;".$file_type[$row2->file_type]."&nbsp;
			</div>
			<div
				class='col-xs-1'
			>
			";
			if($this->session->userdata('id_group')==5 && $_GET['state']=="1")
			{
				$result=$result."<a href='javascript:deleteAttachment(".$row2->id_attachment.")'><i class='fa fa-times fa-2x' aria-hidden='true'></i></a>";
			}
			$result=$result."</div>
			</div>";
		}
		/*if($type<2)
		{
			$result=$result."<div class='row'>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:600px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;color:red'
			>
				&nbsp;Please upload Permit Letter from Institution
			</div></div>";
		}*/
		echo $result;

	}	

	public function upload()
	{
        $file_name = $this->upload_file('file');
		$data = array(
			'file_name' => $file_name,
			'type' => "9",
			'file_type' => $this->input->post('file_type'),
			'id_parent' => $this->input->post('id_parent')
		);
		$this->db->insert("attachment",$data);
	}

}
