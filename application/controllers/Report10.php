<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report10 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper(array('url','form'));

		$this->load->library('email');
		$this->load->library('session');

//		$this->load->library('grocery_CRUD');
		$this->load->library('session');
		$this->load->library('user_agent');
	}

	public function _report_output($output = null)
	{
//		$this->load->view('report1',(array)$output);
		$this->load->view('report10');
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

//			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
			
			
//			$crud->set_theme('bootstrap');
//			$crud->set_table('user');
//			$crud->set_subject('Report Sales');
//			$output = $crud->render();
			$output = "";
			
			
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
					$this->_report_output($output);
				}
				else
				{
					$this->load->view('info2');
				}				
			}	

    		/*if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
			{	
				$this->load->view('menu_admin.html');
				$this->_report_output($output);
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

	public function getTotal3()
	{

		$array_dist = array();
		$query = $this->db->query("SELECT id_dist, code FROM distributor");
		foreach ($query->result() as $row2)
		{
			$array_dist[$row2->code]=$row2->id_dist;
		}

		$state = "0";
		$result = "";
		$query = $this->db->query("select state from job where id_job=1");
		foreach ($query->result() as $row2)
		{			
			$state = $row2->state;
		}	
		if($state==0)
		{	
			$result="<tr><td colspan='2'><a type='button' id='create' class='btn btn-primary' target='_blank' href='".base_url()."index.php/Report10/execute'>&nbsp;Recapitulation</a></td><td colspan=11>&nbsp;</td></tr>";	
		}	
		else if($state==1)
		{
			$result="<tr><td colspan='2'>Recapitulation is on progress</td><td colspan=11>&nbsp;</td></tr>";
		}			
		
		$result=$result."<tr><td colspan='13'>&nbsp;</td></tr>";
		
			
		$query2 = $this->db->query("select distinct substr(period,1,4) as period from invoice_sum");
		$month = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec");
		$result=$result."<tr><td><button type='button' class='btn btn-success btn-xs' style='width:140px'>Invoice</button></td>";
		for($i=1;$i<=12;$i++)
		{	
			$result=$result."<td><button type='button' class='btn btn-warning btn-xs' style='width:140px'>".$month[$i-1]."</button></td>";
		}
		$data = array();
		$result=$result."</tr>";
		foreach ($query2->result() as $row3)
		{	
			$result=$result."<tr><td><button type='button' class='btn btn-primary btn-xs' style='width:140px'>".$row3->period."</button></td>";
			$query = $this->db->query("select id_upload, count(*) as jumlah, substr(period,1,6) as period, id_dist from invoice where substr(period,1,4)='".$row3->period."' group by id_upload, substr(period,1,6) order by substr(period,1,6)");
			foreach ($query->result() as $row2)
			{			
				if(!isset($data[$row2->period]))
				{
					$data[$row2->period]="";
				}					
				$class="btn btn-default btn-xs";
				$id_dist="";
				$query3 = $this->db->query("select count(*) as jumlah from pending_upload where id_upload='".$row2->id_upload."'");
				foreach ($query3->result() as $row4)
				{			
					if($row4->jumlah>0)
					{
						$class="btn btn-danger btn-xs";
					}							
				}		
				$id_dist=array_search($row2->id_dist,$array_dist);
				$data[$row2->period]=$data[$row2->period]."<button type='button' class='".$class."' style='width:140px'>ID ".$row2->id_upload." | ".$id_dist." : [".$row2->jumlah."]</button>";
				/*$result=$result."<td>";					
				$result=$result."<a href='Upload/index/id/".$row2->id_upload."'><button type='button' class='".$class."' style='width:100px'>ID [".$row2->id_upload."] : ".number_format($row2->jumlah,0)."</button></a>";
				$result=$result."</td>";*/
			}
//			$result=$result."</tr>";
//			$result = $result ."<tr>";
			for($i=1;$i<=12;$i++)
			{	
				$result = $result."<td>";
				if(isset($data[$row3->period.str_pad($i,2,"0",STR_PAD_LEFT)]))
				{	
					$result = $result.$data[$row3->period.str_pad($i,2,"0",STR_PAD_LEFT)];						
				}	
				else
				{
					$result = $result."<button type='button' class='btn btn-default btn-xs' style='width:140px'>&nbsp;</button>";
				}					
				$result = $result."</td>";
			}				
			$result=$result."</tr>";
			$result=$result."<tr><td colspan=13 style='font-size:5px'>&nbsp;</td></tr>";
		}
		
		
		$result=$result."<tr><td colspan=13><hr></td></tr>";
		$result=$result."<tr><td colspan=2><button type='button' class='btn btn-success btn-xs' style='width:280px'>Customer</button></td><td colspan=11>&nbsp</td></tr>";
		$query2 = $this->db->query("select count(*) as jumlah from customer");
		$total_cust = 0;
		foreach ($query2->result() as $row3)
		{	
			$total_cust = $row3->jumlah;
			$result=$result."<tr><td colspan=2><button type='button' class='btn btn-default btn-xs' style='width:280px;text-align:left'>Total : ".number_format($row3->jumlah,0)."</button></td></tr>";
		}
		$query2 = $this->db->query("select count(*) as jumlah from customer where id_cust_profile<>0");
		foreach ($query2->result() as $row3)
		{	
			$result=$result."<tr><td colspan=2><button type='button' class='btn btn-default btn-xs' style='width:280px;text-align:left'>Profile : ".number_format($row3->jumlah,0)." ( ".number_format($row3->jumlah*100/$total_cust,2)."% )</button></td></tr>";
		}
		$query2 = $this->db->query("select count(*) as jumlah from customer where length(npwp)<20");
		foreach ($query2->result() as $row3)
		{	
			$result=$result."<tr><td colspan=2><button type='button' class='btn btn-default btn-xs' style='width:280px;text-align:left'>NPWP Mismatch : ".number_format($row3->jumlah,0)." ( ".number_format($row3->jumlah*100/$total_cust,2)."% )</button></td></tr>";
		}
		$result=$result."<tr><td colspan=13><hr></td></tr>";
		$query2 = $this->db->query("select distinct substr(period,1,4) as period from stock");
		$result=$result."<tr><td><button type='button' class='btn btn-success btn-xs' style='width:140px'>Stock</button></td>";
		for($i=1;$i<=12;$i++)
		{	
			$result=$result."<td><button type='button' class='btn btn-warning btn-xs' style='width:140px'>".$month[$i-1]."</button></td>";
		}
		$data = array();
		$result=$result."</tr>";
		foreach ($query2->result() as $row3)
		{	
			$result=$result."<tr><td><button type='button' class='btn btn-primary btn-xs' style='width:140px'>".$row3->period."</button></td>";
			$query = $this->db->query("select id_upload, count(*) as jumlah, substr(period,1,6) as period, id_dist from stock where substr(period,1,4)='".$row3->period."' group by id_upload, substr(period,1,6) order by substr(period,1,6)");
			foreach ($query->result() as $row2)
			{			
				if(!isset($data[$row2->period]))
				{
					$data[$row2->period]="";
				}					
				$class="btn btn-default btn-xs";
				$id_dist="";
				$query3 = $this->db->query("select count(*) as jumlah from pending_upload where id_upload='".$row2->id_upload."'");
				foreach ($query3->result() as $row4)
				{			
					if($row4->jumlah>0)
					{
						$class="btn btn-danger btn-xs";
					}							
				}		
				$id_dist=array_search($row2->id_dist,$array_dist);
				$data[$row2->period]=$data[$row2->period]."<button type='button' class='".$class."' style='width:140px'>ID ".$row2->id_upload." | ".$id_dist." : [".$row2->jumlah."]</button>";
				/*$result=$result."<td>";					
				$result=$result."<a href='Upload/index/id/".$row2->id_upload."'><button type='button' class='".$class."' style='width:100px'>ID [".$row2->id_upload."] : ".number_format($row2->jumlah,0)."</button></a>";
				$result=$result."</td>";*/
			}
//			$result=$result."</tr>";
//			$result = $result ."<tr>";
			for($i=1;$i<=12;$i++)
			{	
				$result = $result."<td>";
				if(isset($data[$row3->period.str_pad($i,2,"0",STR_PAD_LEFT)]))
				{	
					$result = $result.$data[$row3->period.str_pad($i,2,"0",STR_PAD_LEFT)];						
				}	
				else
				{
					$result = $result."<button type='button' class='btn btn-default btn-xs' style='width:140px'>&nbsp;</button>";
				}					
				$result = $result."</td>";
			}				
			$result=$result."</tr>";
			$result=$result."<tr><td colspan=13 style='font-size:5px'>&nbsp;</td></tr>";
		}
		$result=$result."<tr><td colspan=13><hr></td></tr>";
		$result=$result."<tr><td colspan=3><button type='button' class='btn btn-success btn-xs' style='width:280px'>Pending Upload</button></td><td>&nbsp;</td><td colspan=11>&nbsp</td></tr>";
		$query = $this->db->query("select a.id_upload, count(*) as jumlah, b.type from pending_upload a, upload b where a.id_upload=b.id_upload group by id_upload order by a.id_upload");
		foreach ($query->result() as $row2)
		{			
				$text = " (Invoice) ";
			if($row2->type=="1")
			{
				$text = " (Customer) ";
			}
			else if($row2->type=="3")
			{
				$text = " (Stock) ";
			}
				
			$reproccess = "";	
			$query2 = $this->db->query("select id_upload from pending_upload where id<>'' and id in (select id_cust2 from customer) and id_upload='".$row2->id_upload."' union all select id_upload from pending_upload where id<>'' and id in (select id_branch2 from branch) and id_upload='".$row2->id_upload."' union all select id_upload from pending_upload where id<>'' and id in (select id_product3 from product_dist) and id_upload='".$row2->id_upload."' union all select id_upload from pending_upload where id>0 and id in (select id_channel2 from channel) and id_upload='".$row2->id_upload."'");
			foreach ($query2->result() as $row3)
			{			
				$reproccess = "Need Re-Processed";
			}
			$result=$result."<tr><td colspan=2><a href='PendingUpload/index/id_upload/".$row2->id_upload."'><button type='button' class='btn btn-default btn-xs' style='width:280px;text-align:left'>ID [".$row2->id_upload."] : ".number_format($row2->jumlah,0)." ".$text." </button></a></td><td><button type='button' class='btn btn-default btn-xs' style='text-align:left;color:red'>".$reproccess."</button></td></tr>";
		}
				
		$result=$result."<tr><td colspan=13><hr></td></tr>";
		echo $result;
	}	


    public function execute()
    {
//		$command = "/usr/local/bin/php -q /home/crmtaisho/public_html/application/controllers/Excel.php ".$_GET['id']." < /dev/null &";
		$command = "/usr/local/bin/php /home/crmtaisho/public_html/application/controllers/Summary.php > /dev/null 2>&1 & echo $!";
		//$command = "/usr/local/bin/php /home/crmtaisho/public_html/application/controllers/Test.php 1 &";
		exec($command, $op);
//		$pid = (int) $op[0];
		die("Invoice is on processing. Just close this Form");
//		redirect("/Upload");
	}
	
    public function _callback_action($value, $row)
    {
		$button = "";
		if($row->state=="0")
		{
		}
		else if($row->state=="2")
		{
			$button="<a type='button' id='create' class='btn btn-warning btn-xs' target='_blank' href='".base_url()."index.php/Upload/reexecute?id=".$row->id_upload."'>&nbsp;Re-Processed</a>";
		}	

        return $button;
    }


}
