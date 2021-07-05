<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
		$this->load->library('session');
		$this->load->library('email');
		$this->load->library('user_agent');
	}

	public function _user_output($output = null)
	{
		$this->load->view('user',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('user');
			$crud->set_subject('User');
			$crud->columns('photo','user_name','email','name','id_group','active','id_department','id_regency');
			$crud->required_fields('name','email','user_name','id_group');
			if($this->session->userdata('id_group')==15 || $this->session->userdata('id_group')==8 || $this->session->userdata('id_group')==9 || $this->session->userdata('id_group')==16 || $this->session->userdata('id_group')==10)
			{
				$crud->where('user.id_department='.$this->session->userdata('id_user'));
			}				
			else if($this->session->userdata('id_group')==24)
			{
				$crud->where('user.id_group in (22,23,15,25,16)');
			}				
			else if($this->session->userdata('id_group')==11)
			{
				$crud->where('user.id_group not in (22,23,15,25,16)');
			}
			else
			{
				$crud->where('user.id_user',$this->session->userdata('id_user'));
			}
			
			if($this->session->userdata('id_group')!=11 && $this->session->userdata('id_group')!=24)
			{
				$crud->unset_add();
			}				
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_delete();
			$crud->unset_clone();
			$crud->order_by('id_group');
			$crud->set_field_upload('photo', 'assets/uploads');
			$crud->field_type('active', 'dropdown',array('0'=>'Non Active','1'=>'Active'));
			$crud->add_fields('user_name','email','name','photo','id_group','id_regency');
			if($this->session->userdata('id_group')==11 || $this->session->userdata('id_group')==13)
			{
				$crud->edit_fields('user_name','email','name','photo','id_group','active','id_department','new_password1','new_password2','password');
				$crud->field_type('password', 'hidden','');
				$crud->field_type('new_password1', 'password');
				$crud->field_type('new_password2', 'password');
			}	
			else if($this->session->userdata('id_group')==19)
			{
				$crud->edit_fields('user_name','email','name','photo','id_group','id_regency','active','id_department','new_password1','new_password2','password');
				$crud->field_type('password', 'hidden','');
				$crud->field_type('new_password1', 'password');
				$crud->field_type('new_password2', 'password');
				$crud->set_relation('id_regency','product_group','name');
				$crud->display_as('id_regency','Product Group');
			}	
			else if($this->session->userdata('id_group')==24)
			{
				$crud->columns('photo','user_name','email','name','id_group','id_bank','account_name','account_number','id_department','id_regency','active');
				$crud->edit_fields('user_name','email','name','photo','id_group','id_regency','active','id_bank','account_name','account_number','id_department','new_password1','new_password2','password');
				$crud->field_type('password', 'hidden','');
				$crud->field_type('account_number', 'integer');
				$crud->field_type('new_password1', 'password');
				$crud->field_type('new_password2', 'password');
				$crud->set_relation('id_bank','bank','name');
				$crud->set_relation('id_regency','regency','name',"name like 'KOTA%' or name like '%JEMBER' or name like '%KARAWANG'");
				$crud->display_as('id_regency','Area');
				$crud->display_as('id_bank','Bank');
				$crud->display_as('account_number','Account Number');
				$crud->display_as('account_name','Account Name');
			}	
			else if($this->session->userdata('id_group')==10)
			{
				$crud->edit_fields('user_name','email','name','photo','id_regency','new_password1','new_password2','password');
				$crud->field_type('password', 'hidden','');
				$crud->field_type('new_password1', 'password');
				$crud->field_type('new_password2', 'password');
				$crud->set_relation('id_regency','area_sales','name');
				$crud->display_as('id_regency','Area');
			}	
			else if($this->session->userdata('id_group')==15)
			{
				$crud->edit_fields('user_name','email','name','photo','id_regency','new_password1','new_password2','password');
				$crud->field_type('password', 'hidden','');
				$crud->field_type('new_password1', 'password');
				$crud->field_type('new_password2', 'password');
				$crud->set_relation('id_regency','regency','name',"name like 'KOTA%' or name like '%JEMBER' or name like '%KARAWANG'");
				$crud->display_as('id_regency','Area');
			}	
			else if($this->session->userdata('id_group')==8 || $this->session->userdata('id_group')==9)
			{
				$crud->edit_fields('user_name','email','name','photo','id_regency','new_password1','new_password2','password');
				$crud->field_type('password', 'hidden','');
				$crud->field_type('new_password1', 'password');
				$crud->field_type('new_password2', 'password');
				$crud->set_relation('id_regency','regency','name',"name like 'KOTA%' or name like '%JEMBER' or name like '%KARAWANG'");
				$crud->display_as('id_regency','Area');
			}	
			else if($this->session->userdata('id_group')==22 || $this->session->userdata('id_group')==23 || $this->session->userdata('id_group')==25)
			{
				$crud->columns('photo','user_name','email','name','id_group','id_bank','account_name','account_number','id_department','id_regency','active');
				$crud->edit_fields('user_name','email','name','photo','id_bank','account_name','account_number','id_regency','new_password1','new_password2','password');
				$crud->field_type('password', 'hidden','');
				$crud->field_type('account_number', 'integer');
				$crud->field_type('new_password1', 'password');
				$crud->field_type('new_password2', 'password');
				$crud->set_relation('id_bank','bank','name');
				$crud->set_relation('id_regency','regency','name',"name like 'KOTA%' or name like '%JEMBER' or name like '%KARAWANG'");
				$crud->display_as('id_regency','Area');
				$crud->display_as('id_bank','Bank');
				$crud->display_as('account_number','Account Number');
				$crud->display_as('account_name','Account Name');
			}	
			else
			{
				$crud->edit_fields('user_name','email','name','photo','old_password','new_password1','new_password2','password');
				$crud->field_type('password', 'hidden','');
				$crud->field_type('old_password', 'password');
				$crud->field_type('new_password1', 'password');
				$crud->field_type('new_password2', 'password');
				$crud->set_relation('id_regency','regency','name',"name like 'KOTA%' or name like '%JEMBER' or name like '%KARAWANG'");
				$crud->display_as('id_regency','Area');
			}	
			$crud->unique_fields('user_name');
			if($this->session->userdata('id_group')==13)
			{
				$crud->set_relation('id_group','groups','description','id in (15,8,10,13)','id');
			}
			else if($this->session->userdata('id_group')==24)
			{
				$crud->set_relation('id_group','groups','description','id in (22,23,15,25,10,8,9,25)','id');
			}
			else
			{	
				$crud->set_relation('id_group','groups','description',null,'id');
			}	
			$crud->set_relation('id_department','user','name');
			$crud->display_as('id_group','User Group');
			$crud->display_as('id_department','Leader');
			$crud->display_as('user_name','User Name');
			$crud->display_as('active','Status');
			$crud->display_as('name','Nama');
			$crud->display_as('old_password','Old Password');
			$crud->display_as('new_password1','New Password');
			$crud->display_as('new_password2','New Password (Confirmation)');
			$crud->set_lang_string('form_update_changes','Update');
			$crud->set_lang_string('form_update_and_go_back','Update & Return');
			$crud->set_lang_string('form_save_and_go_back','Save & Return');
			$crud->set_lang_string('form_upload_delete','Delete');
			$crud->set_rules('email','Email','callback_checkEmail|required');
			$crud->callback_before_update(array($this, 'before_update'));
			$crud->callback_before_upload(array($this, 'valid_images'));
			$crud->callback_edit_field('email',array($this,'email_edit'));
			$crud->callback_edit_field('user_name',array($this,'user_name_edit'));
			$crud->callback_after_insert(array($this,'after_insert'));
			$crud->callback_after_update(array($this,'after_update'));
			$crud->set_rules('new_password1','New Password','callback_new_password1');
//			$crud->set_rules('user_name','User Name','callback_check_user_name|required');
			


			$output = $crud->render();
			if(!$this->session->userdata('id_group'))
			{
				redirect("/Login");
			}
			else
			{	
				$this->load->view('menu_admin.html');
				$this->_user_output($output);
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

	function after_insert($post_array,$primary_key)
	{
		
		$length = 8;
//		$randomletter = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, $length);
		$randomletter = "password";
		$this->email->from('esponsorship@onetpi.co.id', 'E-Sponsorship Administrator');
		$this->email->to($post_array['email']);
		$this->email->subject('Your E-Sponsorship Account have been Active');
		$file=fopen(APP_PATH."assets/email_activation.html", "r") or die("Unable to open file!");
		$content=fread($file,filesize(APP_PATH."assets/email_activation.html"));
		$content_text = htmlentities($content);
		$content_text=str_replace("_url",base_url()."index.php/Login",$content_text);
		$content_text=str_replace("_email",$post_array['user_name'],$content_text);
		$content_text=str_replace("_password",$randomletter,$content_text);
		$content_html=html_entity_decode($content_text);
		$this->email->message($content_html);			
		$query = $this->db->query("update user set password='".md5($randomletter)."',active=1 where id_user = '".$primary_key."'");
					
		if($this->email->send())
		{	
			$this->session->set_flashdata("email_sent","Congratulation Email Send Successfully.");
		}	
		else
		{	
			$this->session->set_flashdata("email_sent","You have encountered an error");		
		}		

		return true;
		
	}
	
	function check_user_name($post_array) 
	{		
		if(preg_match('/^[a-z0-9_-]{8,20}$/',$_POST['user_name'])) 
		{
     		return TRUE;
     	}
     	else
     	{
	    	$this->form_validation->set_message('check_user_name', 'Please check your User Name format');
	    	return FALSE;
     	}	
    }

	function new_password1($post_array) 
	{		
		if(isset($_POST['old_password']))
		{	
			if($_POST['new_password1']!="" || $_POST['new_password2']!="" || $_POST['old_password']!="")
			{		
				if(trim($_POST['new_password1'])=="" && trim($_POST['new_password1'])=="")
				{
					$this->form_validation->set_message('new_password1', 'Your New Password and Confirmation is blank');
					return FALSE;
				}	
				else
				{
					if(trim($_POST['new_password1'])!=trim($_POST['new_password2']))
					{
						$this->form_validation->set_message('new_password1', 'Your New Password Confirmation is not match');
						return FALSE;
					}				
					else
					{
						$i=0;
						$query = $this->db->query("SELECT password from user where id_user='".$_POST['id_user']."'");
						foreach ($query->result() as $row2)
						{
							if(trim($row2->password)==md5(trim($_POST['old_password'])))		
							{	
								$this->form_validation->set_message('new_password1', 'Your Old Password is not match');
								return FALSE;
								$i=$i+1;	
							}	
						}
						if(trim($_POST['old_password'])==trim($_POST['new_password1']))
						{
							$this->form_validation->set_message('new_password1', 'Your New Password same with Old Password');
							return FALSE;
						}						
						else
						{
							return TRUE;
						}						
					}				
				}				
			}			
			else
			{
				return TRUE;
			}
		}
		else
		{
			if($_POST['new_password1']!="" || $_POST['new_password2']!="")
			{		
				if(trim($_POST['new_password1'])=="" && trim($_POST['new_password1'])=="")
				{
					$this->form_validation->set_message('new_password1', 'Your New Password and Confirmation is blank');
					return FALSE;
				}	
				else
				{
					if(trim($_POST['new_password1'])!=trim($_POST['new_password2']))
					{
						$this->form_validation->set_message('new_password1', 'Your New Password Confirmation is not match');
						return FALSE;
					}				
					else
					{
						return TRUE;
					}				
				}				
			}			
			else
			{
				return TRUE;
			}
		}			
	}
	
	
	function checkEmail($post_array) 
	{		
		if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/',trim($_POST['email']))) 
		{
     		return TRUE;
     	}
     	else
     	{
	    	$this->form_validation->set_message('checkEmail', 'Please check your email format');
	    	return FALSE;
     	}	
    }

	function after_update($post_array, $primary_key)
	{
		if(isset($post_array['password']))
		{	
			$this->email->from('esponsorship@onetpi.co.id', 'E-Sponsorship Administrator');
			$this->email->to($post_array['email']);
			$this->email->subject('Your E-Sponsorship Account Password have been Changed');
			$file=fopen(APP_PATH."assets/change_password.html", "r") or die("Unable to open file!");
			$content=fread($file,filesize(APP_PATH."assets/change_password.html"));
			$content_text = htmlentities($content);
			$content_text=str_replace("_url",base_url()."index.php/Login",$content_text);
			$content_text=str_replace("_email",$post_array['user_name'],$content_text);
			$content_text=str_replace("_password",$post_array['password'],$content_text);
			$content_html=html_entity_decode($content_text);
			$query = $this->db->query("update user set password=md5(password) where id_user = '".$primary_key."'");
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
	
	function before_update($post_array, $primary_key) 
	{
		if($post_array['new_password1']!="")
		{
			$post_array['password']=$post_array['new_password1'];
		}			
		else
		{
			unset($post_array['password']);
		}			
			
		if(isset($post_array['old_password']))	unset($post_array['old_password']);
		unset($post_array['new_password1']);
		unset($post_array['new_password2']);
	
		return $post_array;
	}

	public function valid_images($files_to_upload, $field_info)
	{
		$type=$files_to_upload[$field_info->encrypted_field_name]['type'];
	  if ($type!= 'image/png' && $type!= 'image/jpeg' && $type!= 'image/jpg' && $type!= 'image/gif')
	  {
	   	return 'You can upload only Images File';
	  }
	  return true;
	}
	
	function email_edit($value, $primary_key)
	{
		return '<input id="field-email" class="form-control" name="email" type="text" value="'.$value.'" readonly>';
	}

	function user_name_edit($value, $primary_key)
	{
		return '<input id="field-user_name" class="form-control" name="user_name" type="text" value="'.$value.'" readonly>';
	}

}
