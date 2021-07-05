<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class TelegramWebHook extends CI_Controller {

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
		$this->load->view('hospital',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
						
			$path = "https://api.telegram.org/bot1784983891:AAFrTjCVQdDZxpAEvHL_KI7vkUcVFSnvuHA";

			$json = file_get_contents('php://input');
			$update = json_decode($json,true);

			$chat_id = 	$update['message']['chat']['id'];	
			$message = 	$update['message']['text'];
						
//			file_get_contents($path."/sendmessage?chat_id=".$chat_id."&text=".$message);
			$data3 = array(
				'message' => $message,
				'chat_id' => $chat_id
			);
			$this->db->insert("telegram_message",$data3);
//			echo "return 1";


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

}
