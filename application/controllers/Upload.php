<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

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
		$this->load->view('upload',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('upload');
			$crud->set_subject('Upload File');
			$crud->required_fields('type','file','id_dist');
            $crud->add_fields('type','file','id_dist');
            $crud->edit_fields('state');
            $crud->columns('action','id_upload','size','row','period','type','file','id_dist','state','created_date');
			$crud->set_relation('id_dist','distributor','code');
			$crud->unset_edit();

			if($this->uri->segment(3)=="id")
			{	
				$crud->where('id_upload',$this->uri->segment(4));
			}	

            $crud->unset_read();
//            $crud->unset_delete();
			$crud->field_type('type', 'dropdown',array('1'=>'Customer','2'=>'Invoice','3'=>'Stock'));
			$crud->field_type('state', 'dropdown',array('0'=>'Not Processed Yet','1'=>'On Processing','2'=>'Processed','3'=>'On Processing'));
			$crud->set_field_upload('file', 'assets/uploads');
			$crud->unset_print();
			$crud->unset_clone();
			$crud->display_as('id_upload','ID Upload');
			$crud->display_as('action','');
			$crud->display_as('row','Total Row');
			$crud->display_as('created_date','Date');
			$crud->display_as('file','File');
			$crud->display_as('type','Type');
			$crud->display_as('id_dist','Distributor');
            $crud->callback_column('size',array($this,'_callback_size'));
            $crud->callback_column('row',array($this,'_callback_row'));
            $crud->callback_column('period',array($this,'_callback_period'));
            $crud->callback_column('action',array($this,'_callback_action'));
			$crud->callback_before_delete(array($this,'before_delete'));			
			$crud->callback_after_update(array($this,'after_update'));			
			$crud->set_lang_string('form_update_changes','Update');
			$crud->set_lang_string('form_update_and_go_back','Update & Return');
			$crud->set_lang_string('form_save_and_go_back','Save & Return');
			$crud->set_lang_string('form_upload_delete','Delete');

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

	public function before_delete($primary_key)
	{	
		$type="0";
		$query = $this->db->query("SELECT type FROM upload WHERE id_upload=".$primary_key);
		foreach ($query->result() as $row2)
		{			
			$type = $row2->type;
		}

		if($type==2)
		{
			$this->db->delete('invoice', array('id_upload' => $primary_key));
		}			
		if($type==3)
		{
			$this->db->delete('stock', array('id_upload' => $primary_key));
		}			
		$this->db->delete('pending_upload', array('id_upload' => $primary_key)); 
		
		return true;
	}

    public function _callback_size($value, $row)
    {
		$bytes=filesize("/home/crmtaisho/public_html/assets/uploads/".$row->file);
		
		$bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

		foreach($arBytes as $arItem)
		{
			if($bytes >= $arItem["VALUE"])
			{
				$result = $bytes / $arItem["VALUE"];
				$result = str_replace(".", "," , strval(round($result, 3)))." ".$arItem["UNIT"];
				break;
			}
		}	
		return $result;
	}	

	public function after_update($post_array, $primary_key)
	{		
		if($post_array['state']=="2")
		{	
//			$this->db->delete('customer', array('id_upload' => $primary_key)); 
			$this->db->delete('invoice', array('id_upload' => $primary_key)); 
			$this->db->delete('pending_upload', array('id_upload' => $primary_key)); 
		}	
		
		return true;
	}

    public function reexecute()
    {
		$data = array(		
			   'state' => "3"
		);
		$this->db->where('id_upload', $_GET['id']);
		$this->db->update("upload",$data);

		$type="0";
		$query = $this->db->query("SELECT type FROM upload WHERE id_upload=".$_GET['id']);
		foreach ($query->result() as $row2)
		{			
			$type = $row2->type;
		}

		if($type==2)
		{
			$this->db->delete('invoice', array('id_upload' => $_GET['id']));
		}			
		if($type==3)
		{
			$this->db->delete('stock', array('id_upload' => $_GET['id']));
		}			
		$this->db->delete('pending_upload', array('id_upload' => $_GET['id']));

//		$command = "/usr/local/bin/php -q /home/crmtaisho/public_html/application/controllers/Excel.php ".$_GET['id']." < /dev/null &";
		$command = "/usr/local/bin/php /home/crmtaisho/public_html/application/controllers/Excel.php ".$_GET['id']." > /dev/null 2>&1 & echo $!";
		//$command = "/usr/local/bin/php /home/crmtaisho/public_html/application/controllers/Test.php 1 &";
		exec($command, $op);
//		$pid = (int) $op[0];
		die("File is on processing. Just close this Form");
//		redirect("/Upload");
	}

    public function execute()
    {
//		$command = "/usr/local/bin/php -q /home/crmtaisho/public_html/application/controllers/Excel.php ".$_GET['id']." < /dev/null &";
		$command = "/usr/local/bin/php /home/crmtaisho/public_html/application/controllers/Excel.php ".$_GET['id']." > /dev/null 2>&1 & echo $!";
		//$command = "/usr/local/bin/php /home/crmtaisho/public_html/application/controllers/Test.php 1 &";
		exec($command, $op);
//		$pid = (int) $op[0];
		die("File is on processing. Just close this Form");
//		redirect("/Upload");
	}
	
    public function _callback_action($value, $row)
    {
		$button = "";
		if($row->state=="0")
		{
			$button="<a type='button' id='create' class='btn btn-primary btn-xs' target='_blank' href='".base_url()."index.php/Upload/execute?id=".$row->id_upload."'>&nbsp;Processed</a>";
		}
		else if($row->state=="2")
		{
			$button="<a type='button' id='create' class='btn btn-warning btn-xs' target='_blank' href='".base_url()."index.php/Upload/reexecute?id=".$row->id_upload."'>&nbsp;Re-Processed</a>";
		}	

        return $button;
    }

    public function _callback_row($value, $row)
    {
		if($row->type=="1")
		{
			$result="0";
			$query = $this->db->query("SELECT count(*) as jumlah FROM customer WHERE id_upload=".$row->id_upload);
			foreach ($query->result() as $row2)
			{			
				$result = $row2->jumlah;
			}

		}
		else if($row->type=="2")
		{
			$result="0";
			$query = $this->db->query("SELECT count(*) as jumlah FROM invoice WHERE id_upload=".$row->id_upload);
			foreach ($query->result() as $row2)
			{			
				$result = $row2->jumlah;
			}
		}	
		else if($row->type=="3")
		{
			$result="0";
			$query = $this->db->query("SELECT count(*) as jumlah FROM stock WHERE id_upload=".$row->id_upload);
			foreach ($query->result() as $row2)
			{			
				$result = $row2->jumlah;
			}
		}	

        return number_format($result,0);
    }

    public function _callback_period($value, $row)
    {
		if($row->type=="1")
		{
			$result = "";
		}
		else if($row->type=="2")
		{
			$result="";
			$query = $this->db->query("SELECT distinct substr(period,1,6) as period FROM invoice WHERE id_upload='".$row->id_upload."' order by substr(period,1,6)");
			foreach ($query->result() as $row2)
			{			
				$result = $result.$row2->period." | ";
			}
		}	
		else if($row->type=="3")
		{
			$result="";
			$query = $this->db->query("SELECT distinct period FROM stock WHERE id_upload='".$row->id_upload."' order by period");
			foreach ($query->result() as $row2)
			{			
				$result = $result.$row2->period." | ";
			}
		}	
		$result=rtrim($result," | ");

        return $result;
    }


}
