<?php
require(APPPATH.'libraries/REST_Controller.php');
require(APPPATH.'libraries/Format.php');

use Restserver\Libraries\REST_Controller;
 
class Loginrest extends REST_Controller {
 
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
	}
 
    function login_get()
    {
		$email = urldecode($this->get('email'));
		$password = urldecode($this->get('password'));

		$password = md5($password);
		
		$this->db->where("email",$email);
		$this->db->where("active","1");
		$this->db->where("expired_date>","date(now())");
		$this->db->where("password",$password);
		$query = $this->db->get("caleg");
		
		if ($query->num_rows()==1) 
		{
            $this->response("Success", 200);
		}	
		else
		{
			$this->db->where("email",$email);
			$this->db->where("password",$password);
			$this->db->where("active","1");
			$query = $this->db->get("user");

			if ($query->num_rows() == 1) 
			{
				$this->response("Success", 200);
			}
			else
			{
				$this->response("Failed", 502);
			}				
		}	
	}
	
	function forgot_get()
	{
		$email = urldecode($this->get('email'));

		$this->db->where("email",$email);
		$this->db->where("active","1");
		$this->db->where("expired_date>","date(now())");
		$query = $this->db->get("caleg");
		
		if ($query->num_rows() == 1) 
		{
			$this->response("Success", 200);
		}
		else
		{
			$this->db->where("email",$email);
			$this->db->where("active","1");
			$query = $this->db->get("user");

			if ($query->num_rows() == 1) 
			{
				$this->response("Success", 200);
			}
			else
			{
				$this->response("Failed", 502);
			}
		}	
	}
		
}