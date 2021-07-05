<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report4 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
		$this->load->library('session');
		$this->load->library('user_agent');
	}

	public function _report_output($output = null)
	{
		$this->load->view('report4',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
			
			$this->menu="";
			$this->id_channel="";
			$this->id_product="";
			$this->id_dist="";
			$this->y1="";
			$this->y2="";
			$this->m1="";
			$this->m2="";

			if(isset($_GET['m2']))
			{	
				$this->m2 = $_GET['m2'];
			}	

			if(isset($_GET['y2']))
			{	
				$this->y2 = $_GET['y2'];
			}	

			if(isset($_GET['y1']))
			{	
				$this->y1 = $_GET['y1'];
			}	

			if(isset($_GET['m1']))
			{	
				$this->m1 = $_GET['m1'];
			}	

			if(isset($_GET['menu']))
			{	
				$this->menu = $_GET['menu'];
			}	
					
			if(isset($_GET['id_channel']))
			{	
				$this->id_channel = $_GET['id_channel'];
			}	

			if(isset($_GET['id_product']))
			{	
				$this->id_product = $_GET['id_product'];
			}	

			if(isset($_GET['id_dist']))
			{	
				$this->id_dist = $_GET['id_dist'];
			}	
			
			$crud->set_theme('bootstrap');
			$crud->set_table('user');
			$crud->set_subject('Report Sales');
			$output = $crud->render();
			
			
    		if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
			{	
				if($this->menu!="0")	
				{	
					$this->load->view('menu_admin.html');
				}
				else
				{
					$this->load->view('load.html');
				}					
				$data['menu'] = $this->menu;
				$data['id_channel'] = $this->id_channel;
				$data['id_product'] = $this->id_product;
				$data['id_dist'] = $this->id_dist;
				$data['y1'] = $this->y1;
				$data['m1'] = $this->m1;
				$data['y2'] = $this->y2;
				$data['m2'] = $this->m2;
				$output->data = $data;
				$this->_report_output($output);

//				$this->load->view('menu_admin.html');
//				$this->_report_output($output);
			}	
			else
			{
				redirect("/Login");
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

	public function getDistributor()
	{
		$result="[";
		$query = $this->db->query("select id_dist, code from distributor order by id_dist");
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id_dist."\",\"name\":\"".$row2->code."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}

	public function getProduct()
	{
		$result="[";
		$query = $this->db->query("select a.id_product, a.name_product from product a, product_dist b where a.id_product=b.id_product and b.id_dist='".$_GET['id']."' order by name_product");
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id_product."\",\"name\":\"".$row2->name_product."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}

	public function getProductName()
	{
		$result="";
		$query = $this->db->query("select name_product from product where id_product='".$_GET['id']."'");
		foreach ($query->result() as $row2)
		{			
			$result=$row2->name_product;
		}
		echo $result;
	}

	public function getTotal4()
	{
		$command = "/usr/local/bin/php /home/crmtaisho/public_html/application/controllers/ReportOutletCovered.php ".$_GET['id_product']." ".$_GET['id_channel']." ".$_GET['id_dist']." ".$_GET['year1']." ".$_GET['year2']." ".$_GET['month1']." ".$_GET['month2']." > /dev/null 2>&1 & echo $!";

		exec($command, $op);
		
		echo "";
	}	

	public function getData()
	{
		$labels="{\"labels\": [";	
		$datasets="\"datasets\": [";

		$month = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec");
		for($j=$_GET['year1'];$j<=$_GET['year2'];$j++)
		{
			if($_GET['year1']==$_GET['year2'])
			{
				for($i=$_GET['month1'];$i<=$_GET['month2'];$i++)
				{	
					$labels=$labels."\"".$j."-".$month[$i-1]."\",";
				}	
			}
			else
			{		
				if($j==$_GET['year1'])
				{
					for($i=$_GET['month1'];$i<=12;$i++)
					{	
						$labels=$labels."\"".$j."-".$month[$i-1]."\",";
					}	
				}
				else if($j==$_GET['year2'])
				{
					for($i=1;$i<=$_GET['month2'];$i++)
					{	
						$labels=$labels."\"".$j."-".$month[$i-1]."\",";
					}	
				}
				else
				{
					for($i=1;$i<=12;$i++)
					{	
						$labels=$labels."\"".$j."-".$month[$i-1]."\",";
					}	
				}				
			}	
		}

		$colour = array('#0275d8','#888888','#d11141','#00b159','#00aedb','#f37735','#ffc425','#e43b22');
		$distributor = array();

		$query = $this->db->query("select id_dist, code from distributor order by id_dist");
		$i = 0;
		foreach ($query->result() as $row2)
		{	
			$distributor[$i] = $row2->code;	
			$i = $i + 1;
		}

		$id_dist = explode(",", $_GET['id_dist']);

		foreach ($id_dist as &$value)
//		for($k=1;$k<=7;$k++)
		{	

			$id_cust="";
			$query = $this->db->query("select distinct id_cust from channel a, customer b where a.id_channel=b.id_channel and b.id_dist in (".$value.") and a.big in (".$_GET['id_channel'].")");
			foreach ($query->result() as $row2)
			{
				$id_cust=$id_cust."'".$row2->id_cust."',";				
			}
			$id_cust=$id_cust."''";

			$total_awal = array();
			$query = $this->db->query("select distinct id_cust from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period between '201701' and '".$_GET['year1'].str_pad(($_GET['month1']),2,"0",STR_PAD_LEFT)."'");
			foreach ($query->result() as $row2)
			{			
				array_push($total_awal,$row2->id_cust);
			}


			$response=$distributor[$value-1];
			//$colour = '#'.str_pad(dechex(rand(0x000000, 0x777777)), 6, 0, STR_PAD_LEFT);
			$datasets=$datasets."{";
			$datasets=$datasets."\"label\":\"".$response."\",";
				$datasets=$datasets."\"borderCapStyle\":\"square\",";
				$datasets=$datasets."\"borderDash\": [],";
				$datasets=$datasets."\"borderDashOffset\": 0.0,";
				$datasets=$datasets."\"borderJoinStyle\": \"miter\",";
				$datasets=$datasets."\"pointBorderColor\":\"".$colour[$value-1]."\",";
				$datasets=$datasets."\"pointBackgroundColor\":\"".$colour[$value-1]."\",";
				$datasets=$datasets."\"pointBorderWidth\": 2,";
				$datasets=$datasets."\"borderWidth\": 2,";
				$datasets=$datasets."\"pointHoverRadius\": 6,";
				$datasets=$datasets."\"pointHoverBackgroundColor\":\"".$colour[$value-1]."\",";
				$datasets=$datasets."\"pointHoverBorderColor\": \"".$colour[$value-1]."\",";
				$datasets=$datasets."\"pointHoverBorderWidth\": 2,";
				$datasets=$datasets."\"pointRadius\": 2,";
				$datasets=$datasets."\"pointHitRadius\": 2,";
				$datasets=$datasets."\"lineTension\":0.1,";
				$datasets=$datasets."\"spanGaps\": true,";
				$datasets=$datasets."\"fill\":true,";
				$datasets=$datasets."\"yAxisID\":\"line-stacked\",";
				$datasets=$datasets."\"borderColor\":\"".$colour[$value-1]."\",";
				$datasets=$datasets."\"backgroundColor\":\"".$colour[$value-1]."33\",";


				$datasets=$datasets."\"data\": [";

				for($j=$_GET['year1'];$j<=$_GET['year2'];$j++)
				{
					if($_GET['year1']==$_GET['year2'])
					{
						for($i=$_GET['month1'];$i<=$_GET['month2'];$i++)
						{	
							$average1 = 0;
							$divider=$_GET['month2']-$_GET['month1']+1;
							$query = $this->db->query("select distinct id_cust from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$j.str_pad($i,2,"0",STR_PAD_LEFT)."'");
							foreach ($query->result() as $row2)
							{			
								array_push($total_awal,$row2->id_cust);
							}
							$datasets=$datasets."\"".sizeof(array_unique($total_awal))."\",";
						}	
					}
					else
					{	
						if($j==$_GET['year1'])
						{
							for($i=$_GET['month1'];$i<=12;$i++)
							{	
								$average1 = 0;
								$divider=12-$_GET['month1']+1;
								$query = $this->db->query("select distinct id_cust from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$j.str_pad($i,2,"0",STR_PAD_LEFT)."'");
								foreach ($query->result() as $row2)
								{			
									array_push($total_awal,$row2->id_cust);
								}
								$datasets=$datasets."\"".sizeof(array_unique($total_awal))."\",";
							}	
						}
						else if($j==$_GET['year2'])
						{
							for($i=1;$i<=$_GET['month2'];$i++)
							{	
								$average1 = 0;
								$divider=$_GET['month2'];
								$query = $this->db->query("select distinct id_cust from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$j.str_pad($i,2,"0",STR_PAD_LEFT)."'");
								foreach ($query->result() as $row2)
								{			
									array_push($total_awal,$row2->id_cust);
								}
								$datasets=$datasets."\"".sizeof(array_unique($total_awal))."\",";
							}	
						}
						else
						{
							for($i=1;$i<=12;$i++)
							{	
								$average1 = 0;
								$divider=12;
								$query = $this->db->query("select distinct id_cust from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$j.str_pad($i,2,"0",STR_PAD_LEFT)."'");
								foreach ($query->result() as $row2)
								{			
									array_push($total_awal,$row2->id_cust);
								}
								$datasets=$datasets."\"".sizeof(array_unique($total_awal))."\",";
							}	
						}				
					}	
				}

			$datasets=rtrim($datasets,",");
			$datasets=$datasets."]";
			$datasets=$datasets."},";
		}

		$labels=rtrim($labels,",");
		$datasets=rtrim($datasets,",");
		$labels=$labels."],";	
		$datasets=$datasets."]}";
		echo $labels.$datasets;
		//echo json_encode($result);
	}


	public function getTotal()
	{
		$result="";
		$total = 0;
		$average = 0;
		
		$id_dist = explode(",", $_GET['id_dist']);
				
		for($j=$_GET['year1'];$j<=$_GET['year2'];$j++)
		{

			$total = 0;
			$average = 0;
			foreach ($id_dist as &$value)
			{
				if($_GET['year1']==$_GET['year2'])
				{
					$divider=$_GET['month2']-$_GET['month1']+1;
					$query = $this->db->query("select count(id_cust) as total from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (select distinct id_cust from channel a, customer b where a.id_channel=b.id_channel and b.id_dist in (".$value.") and a.big in (".$_GET['id_channel'].")) and period between '".$j.str_pad($_GET['month1'],2,"0",STR_PAD_LEFT)."' and '".$j.str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."'");
				}
				else
				{	
					if($j==$_GET['year1'])
					{
						$divider=12-$_GET['month1']+1;
						$query = $this->db->query("select count(id_cust) as total from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (select distinct id_cust from channel a, customer b where a.id_channel=b.id_channel and b.id_dist in (".$value.") and a.big in (".$_GET['id_channel'].")) and substr(period,1,4)='".$j."' and period>='".$j.str_pad($_GET['month1'],2,"0",STR_PAD_LEFT)."'");
					}				
					else if($j==$_GET['year2'])
					{
						$divider=$_GET['month2'];
						$query = $this->db->query("select count(id_cust) as total from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (select distinct id_cust from channel a, customer b where a.id_channel=b.id_channel and b.id_dist in (".$value.") and a.big in (".$_GET['id_channel'].")) and substr(period,1,4)='".$j."' and period<'".$j.str_pad(($_GET['month2']+1),2,"0",STR_PAD_LEFT)."'");
					}				
					else
					{
						$divider=12;				
						$query = $this->db->query("select count(id_cust) as total from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (select distinct id_cust from channel a, customer b where a.id_channel=b.id_channel and b.id_dist in (".$value.") and a.big in (".$_GET['id_channel'].")) and substr(period,1,4)='".$j."'");
					}				
				}	
				foreach ($query->result() as $row2)
				{			
					if($row2->total==null)
					{
						$result=$result."0;0;";
					}
					else
					{			
						$result=$result.number_format($row2->total,2).";".number_format($row2->total/$divider,2).";";
						$total = $total + $row2->total;
						$average = $average + ($row2->total/$divider);
					}	
				}
			}
			$result=$result.number_format($total,2).";".number_format($average,2).";";
		}
		$result=rtrim($result, ";");
		$result=str_replace(".000","",$result);
		$result=str_replace(".00","",$result);
		echo $result;
	}	

	public function getTotal3()
	{
		$result="";
		$total = array();
				
		$labels="{\"labels\": [";	
		$datasets="\"datasets\": [";

		$month = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec");
		for($j=$_GET['year1'];$j<=$_GET['year2'];$j++)
		{
			if($_GET['year1']==$_GET['year2'])
			{
				for($i=$_GET['month1'];$i<=$_GET['month2'];$i++)
				{	
					$labels=$labels."\"".$j."-".$month[$i-1]."\",";
				}	
			}
			else
			{		
				if($j==$_GET['year1'])
				{
					for($i=$_GET['month1'];$i<=12;$i++)
					{	
						$labels=$labels."\"".$j."-".$month[$i-1]."\",";
					}	
				}
				else if($j==$_GET['year2'])
				{
					for($i=1;$i<=$_GET['month2'];$i++)
					{	
						$labels=$labels."\"".$j."-".$month[$i-1]."\",";
					}	
				}
				else
				{
					for($i=1;$i<=12;$i++)
					{	
						$labels=$labels."\"".$j."-".$month[$i-1]."\",";
					}	
				}				
			}	
		}

		$colour = array('#0275d8','#888888','#d11141','#00b159','#00aedb','#f37735','#ffc425','#e43b22');
		$distributor = array();

		$query = $this->db->query("select id_dist, code from distributor order by id_dist");
		$i = 0;
		foreach ($query->result() as $row2)
		{	
			$distributor[$i] = $row2->code;	
			$i = $i + 1;
		}

		$id_dist = explode(",", $_GET['id_dist']);

		foreach ($id_dist as &$value) 
		{
			$k = 0;

			$response=$distributor[$value-1];
			//$colour = '#'.str_pad(dechex(rand(0x000000, 0x777777)), 6, 0, STR_PAD_LEFT);
			$datasets=$datasets."{";
			$datasets=$datasets."\"label\":\"".$response."\",";
				$datasets=$datasets."\"borderCapStyle\":\"square\",";
				$datasets=$datasets."\"borderDash\": [],";
				$datasets=$datasets."\"borderDashOffset\": 0.0,";
				$datasets=$datasets."\"borderJoinStyle\": \"miter\",";
				$datasets=$datasets."\"pointBorderColor\":\"".$colour[$value-1]."\",";
				$datasets=$datasets."\"pointBackgroundColor\":\"".$colour[$value-1]."\",";
				$datasets=$datasets."\"pointBorderWidth\": 2,";
				$datasets=$datasets."\"borderWidth\": 2,";
				$datasets=$datasets."\"pointHoverRadius\": 6,";
				$datasets=$datasets."\"pointHoverBackgroundColor\":\"".$colour[$value-1]."\",";
				$datasets=$datasets."\"pointHoverBorderColor\": \"".$colour[$value-1]."\",";
				$datasets=$datasets."\"pointHoverBorderWidth\": 2,";
				$datasets=$datasets."\"pointRadius\": 2,";
				$datasets=$datasets."\"pointHitRadius\": 2,";
				$datasets=$datasets."\"lineTension\":0.1,";
				$datasets=$datasets."\"spanGaps\": true,";
				$datasets=$datasets."\"type\":\"line\",";
				$datasets=$datasets."\"fill\":true,";
				$datasets=$datasets."\"yAxisID\":\"line-stacked\",";
				$datasets=$datasets."\"borderColor\":\"".$colour[$value-1]."\",";
				$datasets=$datasets."\"backgroundColor\":\"".$colour[$value-1]."33\",";


				$datasets=$datasets."\"data\": [";

			$id_cust="";
			$query = $this->db->query("select distinct id_cust from channel a, customer b where a.id_channel=b.id_channel and b.id_dist in (".$value.") and a.big in (".$_GET['id_channel'].")");
			foreach ($query->result() as $row2)
			{
				$id_cust=$id_cust."'".$row2->id_cust."',";				
			}
			$id_cust=$id_cust."''";

			$total_awal = array();
			$query = $this->db->query("select distinct id_cust from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period between '201701' and '".$_GET['year1'].str_pad(($_GET['month1']),2,"0",STR_PAD_LEFT)."'");
			foreach ($query->result() as $row2)
			{			
				array_push($total_awal,$row2->id_cust);
			}

			for($i=$_GET['year1'];$i<=$_GET['year2'];$i++)
			{	
	//			$id_cust=rtrim($id_cust,",");

				if($_GET['year2']==$_GET['year1'])
				{	
						for($j=$_GET['month1'];$j<=$_GET['month2'];$j++)
						{
							if(!isset($total[$k]))	
							{	
								$total[$k]=0;
							}	
							$query = $this->db->query("select distinct id_cust from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'");
							foreach ($query->result() as $row2)
							{			
								array_push($total_awal,$row2->id_cust);
							}
							$datasets=$datasets."\"".sizeof(array_unique($total_awal))."\",";
							$result=$result.number_format(sizeof(array_unique($total_awal)),2).";";
							$total[$k] = $total[$k] + sizeof(array_unique($total_awal));
							$k = $k + 1;
						}
				}
				else
				{	
					if($i==$_GET['year1'])
					{	
						for($j=$_GET['month1'];$j<=12;$j++)
						{
							if(!isset($total[$k]))	
							{	
								$total[$k]=0;
							}	
							$query = $this->db->query("select distinct id_cust from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'");
							foreach ($query->result() as $row2)
							{			
								array_push($total_awal,$row2->id_cust);
							}
							$datasets=$datasets."\"".sizeof(array_unique($total_awal))."\",";
							$result=$result.number_format(sizeof(array_unique($total_awal)),2).";";
							$total[$k] = $total[$k] + sizeof(array_unique($total_awal));
							$k = $k + 1;
						}
						
					}	
					else if($i==$_GET['year2'])
					{	
						for($j=1;$j<=$_GET['month2'];$j++)
						{
							if(!isset($total[$k]))
							{	
								$total[$k]=0;
							}	
							$query = $this->db->query("select distinct id_cust from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'");
							foreach ($query->result() as $row2)
							{			
								array_push($total_awal,$row2->id_cust);
							}
							$datasets=$datasets."\"".sizeof(array_unique($total_awal))."\",";
							$result=$result.number_format(sizeof(array_unique($total_awal)),2).";";
							$total[$k] = $total[$k] + sizeof(array_unique($total_awal));
							$k = $k + 1;
						}
					}
					else
					{
						for($j=1;$j<=12;$j++)
						{
							if(!isset($total[$k]))
							{	
								$total[$k]=0;
							}	
							$query = $this->db->query("select distinct id_cust from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'");
							foreach ($query->result() as $row2)
							{			
								array_push($total_awal,$row2->id_cust);
							}
							$datasets=$datasets."\"".sizeof(array_unique($total_awal))."\",";
							$result=$result.number_format(sizeof(array_unique($total_awal)),2).";";
							$total[$k] = $total[$k] + sizeof(array_unique($total_awal));
							$k = $k + 1;
						}
					}					
				}	
			}
			$datasets=rtrim($datasets,",");
			$datasets=$datasets."]";
			$datasets=$datasets."},";


		}
		for($l=0;$l<$k;$l++)
		{
			$result=$result.number_format($total[$l],2).";";
		}

		$result=rtrim($result, ";");
		$result=str_replace(".00","",$result);

		$labels=rtrim($labels,",");
		$datasets=rtrim($datasets,",");
		$labels=$labels."],";	
		$datasets=$datasets."]}";

		echo $result."|".$labels.$datasets;
	}	

}
