<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');

		$this->load->library('session');
		$this->load->library('email');
		$this->load->library('user_agent');
		
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


	public function getActive()
	{
		$active="0";
		$query = $this->db->query("SELECT active FROM user WHERE user_name='".$_GET['id']."'");
		foreach ($query->result() as $row2)
		{			
			$active = $row2->active;
		}
		echo $active;
	}
	
	public function getFirstTime()
	{
		$first = "";
		$email = "";
		$code = "";
		$is_code = "";
		$i = 0;
		$query = $this->db->query("SELECT is_change, email, is_code, user_name FROM user WHERE user_name='".$_GET['id']."'");
		foreach ($query->result() as $row2)
		{			
			$first = $row2->is_change;
			$email = $row2->email;
			$user_name = $row2->user_name;
			$is_code = $row2->is_code;
			$i++;
		}

		$length = 5;
		$randomletter = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, $length);
		$this->email->from('esponsorship@onetpi.co.id', 'E-Sponsorship Administrator');
		$this->email->to($email);
		$this->email->subject('Your ('.$user_name.') Verification Code');
		$file=fopen(APP_PATH."assets/challange.html", "r") or die("Unable to open file!");
		$this->db->set('is_code',"0");
		$this->db->set('code',$randomletter);
		$this->db->where("user_name",$_GET['id']);
		$this->db->where('is_code',"1");
		$this->db->update('user');
		
		if($i>0 && $is_code=="1")
		{		
			$content=fread($file,filesize(APP_PATH."assets/challange.html"));
			$content_text = htmlentities($content);
			$content_text=str_replace("_code",$randomletter,$content_text);
			$content_html=html_entity_decode($content_text);
			$this->email->message($content_html);			
			if($this->email->send())
			{
			}	
			else
			{	
			}
		}			
		else if($i>0 && $is_code=="0")
		{
			$query = $this->db->query("SELECT code FROM user WHERE active=1 and user_name='".$_GET['id']."'");
			foreach ($query->result() as $row2)
			{			
				$randomletter = $row2->code;
			}
			$content=fread($file,filesize(APP_PATH."assets/challange.html"));
			$content_text = htmlentities($content);
			$content_text=str_replace("_code",$randomletter,$content_text);
			$content_html=html_entity_decode($content_text);
			$this->email->message($content_html);			

			if($this->email->send())
			{
			}	
			else
			{	
			}

		}			
		else
		{
			$randomletter = "";
		}

		echo $randomletter;

	}

	public function login()
	{
		$email = $this->input->post('username');
		$password = $this->input->post('password');
		$code = $this->input->post('code');
		$password = md5($password);
		
		$this->db->where("user_name",$email);
		$this->db->where("password",$password);
		$this->db->where("code",$code);
		$this->db->where("active","1");
		$query = $this->db->get("user");

		if ($query->num_rows() == 1) 
		{

			$id_user = $query->row()->id_user;
			$id_group = $query->row()->id_group;
			$name = $query->row()->name;

			$this->db->set('is_code',"1");
			$this->db->where("id_user",$id_user);
			$this->db->update('user');

				
			$this->session->set_userdata('id_user',$id_user);
			$this->session->set_userdata('id_group',$id_group);
			$this->session->set_userdata('name',$name);
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
			if(!empty($this->input->post('url')))
			{
				redirect('/'.$this->input->post('url'));
			}
			else
			{		
				redirect('/User');
			}	
		}
		else
		{					
			$data['error']= "Username or Password or Code is not match";
			$this->load->view('login.php', $data);
		}	
		
	}
	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
			{			
				$this->load->view('menu_admin.html');			
			}
			else
			{			
				$this->load->view('login');
			}	


		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	
	//		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function logout()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		$this->session->unset_userdata(array('id_user', 'id_group','name'));		
		$this->session->sess_destroy();
		redirect('/Login');
	}

	public function forgot()
	{
		$this->load->view('forgot.php');
	}

	public function change()
	{
		if(isset($_GET['key']))
		{	
			$email=$_GET['key'];
			$this->db->where("md5(user_name)",$email);
			$this->db->where("active","0");
			$query = $this->db->get("user");
			
			if ($query->num_rows() == 1) 
			{
				$data['key']=$email;
				$this->load->view('change.php',$data);			
			}
			else
			{
				$data['error']= "Your Link is no longer valid";
				$this->load->view('info.php', $data);
			}			
		}
		else
		{
			redirect('/Login');
		}			
	}

	public function first_login()
	{
		if(isset($_GET['key']))
		{	
			$data['key']=$_GET['key'];
			$this->load->view('first_login.php',$data);			
		}
		else
		{
			redirect('/Login');
		}			
	}

	public function activate()
	{
		if(isset($_GET['key']))
		{	
			$email=$_GET['key'];
			$this->db->where("md5(user_name)",$email);
			$this->db->where("active","0");
			$query = $this->db->get("user");
			
			if ($query->num_rows() == 1) 
			{
				$data['key']=$email;
				$this->load->view('activate.php',$data);			
			}
			else
			{
				$data['error']= "Your Link is no longer valid";
				$this->load->view('info.php', $data);
			}			
		}
		else
		{
			redirect('/Login');
		}			
	}
	
	
	public function forgotpassword()
	{				
		$email = $this->input->post('username');
		
		$this->db->where("user_name",$email);
		$this->db->where("active","1");
		$query = $this->db->get("user");

		if ($query->num_rows() == 1) 
		{
			foreach ($query->result() as $row)				
			{
				$email2 = $row->email;
			}
				
			$length = 5;
			$randomletter = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, $length);
			$this->email->from('esponsorship@onetpi.co.id', 'E-Sponsorship Administrator');
			$this->email->to($email2);
			$this->email->subject('Forgot Your Password ?');
			$file=fopen(APP_PATH."assets/email_forgot.html", "r") or die("Unable to open file!");
			$this->db->set('active',"0");
			$this->db->set('code',$randomletter);
			$this->db->where("user_name",$email);
			$this->db->where("active","1");
			$this->db->update('user');
			$content=fread($file,filesize(APP_PATH."assets/email_forgot.html"));
			$content_text = htmlentities($content);
			$content_text=str_replace("_url",base_url()."index.php/Login/change?key=".md5($email),$content_text);
			$content_text=str_replace("_code",$randomletter,$content_text);
			$content_html=html_entity_decode($content_text);
			$this->email->message($content_html);			
					
			if($this->email->send())
			{	
				$this->session->set_flashdata("email_sent","Congratulation Email Send Successfully.");
				redirect('/Login');
			}	
			else
			{	
				$this->session->set_flashdata("email_sent","You have encountered an error");		
			}
		}
		else
		{					
			$data['error']= "User Name is not register yet";
			$this->load->view('forgot.php', $data);
		}	
	}
	
	public function changepassword()
	{
		$code = $this->input->post('code');
		$email = $this->input->post('email');
		$password1 = $this->input->post('password1');
		$password2 = $this->input->post('password2');
		
		//if($password1==$password2)
		//{
			$this->db->where("code",$code);
			$this->db->where("md5(user_name)",$email);
			$this->db->where("active","0");
			$query = $this->db->get("user");

			if ($query->num_rows() == 1) 
			{
				foreach ($query->result() as $row)				
				{
					$email2 = $row->email;
					$user_name = $row->user_name;
				}

				$this->db->set('password',md5($password1));
				$this->db->set('active',"1");
				$this->db->where("active","0");
				$this->db->where("md5(user_name)",$email);
				$this->db->update('user');

				$this->email->from('esponsorship@onetpi.co.id', 'E-Sponsorship Administrator');
				$this->email->to($email2);
				$this->email->subject('Your E-Sponsorship Account have been Active');
				$file=fopen(APP_PATH."assets/email_activation.html", "r") or die("Unable to open file!");
				$content=fread($file,filesize(APP_PATH."assets/email_activation.html"));
				$content_text = htmlentities($content);
				$content_text=str_replace("_url",base_url()."index.php/Login",$content_text);
				$content_text=str_replace("_email",$user_name,$content_text);
				$content_text=str_replace("_password",$password2,$content_text);
				$content_html=html_entity_decode($content_text);
				$this->email->message($content_html);			
						
				if($this->email->send())
				{	
					$this->session->set_flashdata("email_sent","Congratulation Email Send Successfully.");
					redirect('/Login');
				}	
				else
				{	
					$this->session->set_flashdata("email_sent","You have encountered an error");		
				}

			}
			else
			{
				$data['error']= "Your Security Code is not match";
				$this->load->view('info.php', $data);
					
			}
		//}
		/*else
		{
			$data['error']= "Your New Password and Confirmation is not match";
			//$this->load->view('change.php?key='.$email, $data);
		}*/			
		
	}

	public function changepassword2()
	{
		$email = $this->input->post('email');
		$password1 = $this->input->post('password1');
		$password2 = $this->input->post('password2');
		
		//if($password1==$password2)
		//{
			$this->db->where("user_name",$email);
			$this->db->where("active","1");
			$query = $this->db->get("user");

			if ($query->num_rows() == 1) 
			{
				foreach ($query->result() as $row)				
				{
					$email2 = $row->email;
				}

				$this->db->set('password',md5($password1));
				$this->db->set('is_change','1');
				$this->db->where("user_name",$email);
				$this->db->update('user');

				$this->email->from('esponsorship@onetpi.co.id', 'E-Sponsorship Administrator');
				$this->email->to($email2);
				$this->email->subject('Your E-Sponsorship Account have been Changed');
				$file=fopen(APP_PATH."assets/change_password.html", "r") or die("Unable to open file!");
				$content=fread($file,filesize(APP_PATH."assets/change_password.html"));
				$content_text = htmlentities($content);
				$content_text=str_replace("_url",base_url()."index.php/Login",$content_text);
				$content_text=str_replace("_email",$email,$content_text);
				$content_text=str_replace("_password",$password2,$content_text);
				$content_html=html_entity_decode($content_text);
				$this->email->message($content_html);			
						
				if($this->email->send())
				{	
					$this->session->set_flashdata("email_sent","Congratulation Email Send Successfully.");
					redirect('/Login');
				}	
				else
				{	
					$this->session->set_flashdata("email_sent","You have encountered an error");		
				}

			}
			else
			{
				$data['error']= "Your User Name is not match";
				$this->load->view('info.php', $data);
					
			}
		//}
		/*else
		{
			$data['error']= "Your New Password and Confirmation is not match";
			//$this->load->view('change.php?key='.$email, $data);
		}*/			
		
	}
	
	
	public function activateaccount()
	{
		$code = $this->input->post('code');
		$email = $this->input->post('email');
		
		//if($password1==$password2)
		//{
			$this->db->where("code",$code);
			$this->db->where("md5(user_name)",$email);
			$this->db->where("active","0");
			$query = $this->db->get("user");

			if ($query->num_rows() == 1) 
			{
				foreach ($query->result() as $row)				
				{
					$email2 = $row->email;
				}

				$length = 8;
				$randomletter = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, $length);
								
				$this->db->set('password',md5($randomletter));
				$this->db->set('active',"1");
				$this->db->where("active","0");
				$this->db->where("md5(user_name)",$email);
				$this->db->where("code",$code);
				$this->db->update('user');

				$this->email->from('esponsorship@onetpi.co.id', 'E-Sponsorship Administrator');
				$this->email->to($email2);
				$this->email->subject('Your E-Sponsorship Account have been Active');
				$file=fopen(APP_PATH."assets/email_activation.html", "r") or die("Unable to open file!");
				$content=fread($file,filesize(APP_PATH."assets/email_activation.html"));
				$content_text = htmlentities($content);
				$content_text=str_replace("_url",base_url()."index.php/Login",$content_text);
				$content_text=str_replace("_email",$email,$content_text);
				$content_text=str_replace("_password",$randomletter,$content_text);
				$content_html=html_entity_decode($content_text);
				$this->email->message($content_html);			
						
				if($this->email->send())
				{	
					$this->session->set_flashdata("email_sent","Congratulation Email Send Successfully.");
					redirect('/Login/logout');					
				}	
				else
				{	
					$this->session->set_flashdata("email_sent","You have encountered an error");		
				}

			}
			else
			{
				$data['error']= "Your Security Code is not match";
				$this->load->view('info.php', $data);
					
			}
		//}
		/*else
		{
			$data['error']= "Your New Password and Confirmation is not match";
			//$this->load->view('change.php?key='.$email, $data);
		}*/			
		
	}	
}
