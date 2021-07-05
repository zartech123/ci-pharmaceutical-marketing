<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report1 extends CI_Controller {

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
		$this->load->view('report1');
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

	public function getProduct()
	{
		$result="[";
		$query = $this->db->query("select distinct a.id_product, a.name_product, c.name from product a, product_dist b, product_group c where a.id_group=c.id_group and a.id_product=b.id_product and b.id_dist in (".$_GET['id'].") order by name_product");
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id_product."\",\"name_group\":\"".$row2->name."\",\"name\":\"".$row2->name_product."\"}";
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


	public function getData()
	{
		$labels="{\"labels\": [";	
		$datasets="\"datasets\": [";
		
		$type = $_GET['type'];
		
		if($type=="1")
		{
			$sum="sum(qty_sales+retur_qty)";
		}
		else
		{
			$sum="sum(sales_value+retur_value)";
		}			

		for($j=$_GET['year1'];$j<=$_GET['year2'];$j++)
		{	
			$labels=$labels."\"".$j."\",";
		}	

		$colour = array('#0275d8','#888888','#d11141','#00b159','#00aedb','#f37735','#ffc425','#e43b22');
		$channel = array("1 HOSPITAL", "2 PHARMACY", "3 DRUGSTORE", "4 INSTITUTION", "5 MTC", "6 PHARMA CHAIN", "7 GT & OTHERS", "8 PBF","TOTAL");

		$id_channel = explode(",", $_GET['id_channel']);

//		for($i=1;$i<=8;$i++)
		foreach ($id_channel as &$value) 
		{	
			$id_cust="";
			if($value==6)
			{
				$query = $this->db->query("select distinct id_cust from customer b where id_cust not in (select distinct id_cust from customer_redistribution where id_dist in (".$_GET['id_dist'].")) and is_pharmachain=1 and id_dist in (".$_GET['id_dist'].")");
			}
			else
			{		
				$query = $this->db->query("select distinct id_cust from channel a, customer b where id_cust not in (select distinct id_cust from customer_redistribution where id_dist in (".$_GET['id_dist'].")) and is_pharmachain=0 and a.id_channel=b.id_channel and b.id_dist in (".$_GET['id_dist'].") and big=".$value);
			}	
			foreach ($query->result() as $row2)
			{
				$id_cust=$id_cust."'".$row2->id_cust."',";				
			}
			$id_cust=$id_cust."''";


			$response=$channel[$value-1];
			//$colour = '#'.str_pad(dechex(rand(0x000000, 0x777777)), 6, 0, STR_PAD_LEFT);
			$datasets=$datasets."{";
			$datasets=$datasets."\"label\":\"".$response."\",";

			$datasets=$datasets."\"borderWidth\":1,";
			$datasets=$datasets."\"borderColor\":\"".$colour[$value-1]."\",";
			$datasets=$datasets."\"backgroundColor\":\"".$colour[$value-1]."33\",";
			$datasets=$datasets."\"hoverBackgroundColor\":\"".$colour[$value-1]."\",";

			$datasets=$datasets."\"data\": [";

			for($j=$_GET['year1'];$j<=$_GET['year2'];$j++)
			{
				if($_GET['year1']==$_GET['year2'])
				{
					$divider=$_GET['month2']-$_GET['month1']+1;
					$query = $this->db->query("select ".$sum."/".$divider." as average from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period between '".$j.str_pad($_GET['month1'],2,"0",STR_PAD_LEFT)."' and '".$j.str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."'");
				}
				else
				{		
					if($j==$_GET['year1'])
					{
						$divider=12-$_GET['month1']+1;
						$query = $this->db->query("select ".$sum."/".$divider." as average from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period between '".$j.str_pad($_GET['month1'],2,"0",STR_PAD_LEFT)."' and '".$j."12'");
					}				
					else if($j==$_GET['year2'])
					{
						$divider=$_GET['month2'];
						$query = $this->db->query("select ".$sum."/".$divider." as average from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period between '".$j."01' and '".$j.str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."'");
					}				
					else
					{
						$divider=12;				
						$query = $this->db->query("select ".$sum."/".$divider." as average from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and substr(period,1,4)='".$j."'");
					}				
				}
				$average1 = 0;
				foreach ($query->result() as $row2)
				{			
					if($row2->average==null)
					{
//						$average1="0";
					}
					else
					{			
						$average1=$average1+$row2->average;
					}	
				}
				$datasets=$datasets."\"".$average1."\",";
				//$datasets=$datasets."\"".$average2."\",";

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
		$labels="{\"labels\": [";	
		$datasets="\"datasets\": [";

		$result="";
		
		for($j=$_GET['year1'];$j<=$_GET['year2'];$j++)
		{	
			$labels=$labels."\"".$j."\",";
		}	

		$colour = array('#0275d8','#888888','#d11141','#00b159','#00aedb','#f37735','#ffc425','#e43b22');
		$channel = array("1 HOSPITAL", "2 PHARMACY", "3 DRUGSTORE", "4 INSTITUTION", "5 MTC", "6 PHARMA CHAIN", "7 GT & OTHERS", "8 PBF","TOTAL");

		$id_channel = explode(",", $_GET['id_channel']);
				
		$type = $_GET['type'];
		
		if($type=="1")
		{
			$sum="sum(qty_sales+retur_qty)";
		}
		else
		{
			$sum="sum(sales_value+retur_value)";
		}			

		$id_custarray = array();
		foreach ($id_channel as &$value)
		{
			$id_cust2="";
			if($value==6)
			{
				$query2 = $this->db->query("select distinct id_cust from customer b where id_cust not in (select distinct id_cust from customer_redistribution where id_dist in (".$_GET['id_dist'].")) and is_pharmachain=1 and id_dist in (".$_GET['id_dist'].")");
			}
			else
			{		
				$query2 = $this->db->query("select distinct id_cust from channel a, customer b where id_cust not in (select distinct id_cust from customer_redistribution where id_dist in (".$_GET['id_dist'].")) and is_pharmachain=0 and a.id_channel=b.id_channel and b.id_dist in (".$_GET['id_dist'].") and big=".$value);
			}	
			foreach ($query2->result() as $row3)
			{			
				$id_cust2=$id_cust2."'".$row3->id_cust."',";				
			}
			$id_cust2=$id_cust2."''";
			
			$id_custarray[$value]=$id_cust2;

		}

		$total = array();
		$average = array();

		foreach ($id_channel as &$value)
		{
			$response=$channel[$value-1];
			//$colour = '#'.str_pad(dechex(rand(0x000000, 0x777777)), 6, 0, STR_PAD_LEFT);
			$datasets=$datasets."{";
			$datasets=$datasets."\"label\":\"".$response."\",";

			$datasets=$datasets."\"borderWidth\":1,";
			$datasets=$datasets."\"borderColor\":\"".$colour[$value-1]."\",";
			$datasets=$datasets."\"backgroundColor\":\"".$colour[$value-1]."33\",";
			$datasets=$datasets."\"hoverBackgroundColor\":\"".$colour[$value-1]."\",";

			$datasets=$datasets."\"data\": [";
			for($j=$_GET['year1'];$j<=$_GET['year2'];$j++)
			{
				if(!isset($total[$j-1]))
				{
					$total[$j-1]=0;
				}					
				if(!isset($average[$j-1]))
				{
					$average[$j-1]=0;
				}					
				if($_GET['year1']==$_GET['year2'])
				{
					$divider=$_GET['month2']-$_GET['month1']+1;
					$query = $this->db->query("select ".$sum." as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_custarray[$value].") and period between '".$j.str_pad($_GET['month1'],2,"0",STR_PAD_LEFT)."' and '".$j.str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."'");
				}
				else
				{		
					if($j==$_GET['year1'])
					{
						$divider=12-$_GET['month1']+1;
						$query = $this->db->query("select ".$sum." as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_custarray[$value].") and period between '".$j.str_pad($_GET['month1'],2,"0",STR_PAD_LEFT)."' and '".$j."12'");
					}				
					else if($j==$_GET['year2'])
					{
						$divider=$_GET['month2'];
						$query = $this->db->query("select ".$sum." as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_custarray[$value].") and period between '".$j."01' and '".$j.str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."'");
					}				
					else
					{
						$divider=12;				
						$query = $this->db->query("select ".$sum." as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_custarray[$value].") and substr(period,1,4)='".$j."'");
					}				
				}	
				$average1 = 0;
				foreach ($query->result() as $row2)
				{			
					if($row2->total==null)
					{
						$result=$result."0;0;";
					}
					else
					{			
						$result=$result.number_format($row2->total,2).";".number_format($row2->total/$divider,2).";";
						$total[$j-1] = $total[$j-1] + $row2->total;
						$average[$j-1] = $average[$j-1] + ($row2->total/$divider);
						$average1=$average1+($row2->total/$divider);
					}	
				}
				$datasets=$datasets."\"".$average1."\",";
			}
			$datasets=rtrim($datasets,",");
			$datasets=$datasets."]";
			$datasets=$datasets."},";
//			$result=$result.number_format($total,2).";".number_format($average,2).";";
		}
			for($j=$_GET['year1'];$j<=$_GET['year2'];$j++)
			{
				$result=$result.number_format($total[$j-1],2).";".number_format($average[$j-1],2).";";
//				$result=$result.number_format($total[$j-1],2).";";
			}
		$labels=rtrim($labels,",");
		$datasets=rtrim($datasets,",");
		$labels=$labels."],";	
		$datasets=$datasets."]}";

		$result=rtrim($result, ";");
		$result=str_replace(".000","",$result);
		$result=str_replace(".00","",$result);
		echo $result."|".$labels.$datasets;
//		echo $result;
	}	

	public function getTotal3()
	{
		$result="";
		$total = array();
		$total[0] = 0;
		$total[1] = 0;
		$total[2] = 0;
		$total[3] = 0;
		$total[4] = 0;
		$total[5] = 0;
		$total[6] = 0;
		$total[7] = 0;
		$total[8] = 0;
		$total[9] = 0;
		$total[10] = 0;
		$total[11] = 0;
				
		$id_channel = explode(",", $_GET['id_channel']);

		$type = $_GET['type'];
		
		if($type=="1")
		{
			$sum="sum(qty_sales+retur_qty)";
		}
		else
		{
			$sum="sum(sales_value+retur_value)";
		}			

		foreach ($id_channel as &$value) 
		{	
			$id_cust="";
			if($value==6)
			{
				$query = $this->db->query("select distinct id_cust from customer b where id_cust not in (select distinct id_cust from customer_redistribution where id_dist in (".$_GET['id_dist'].")) and is_pharmachain=1 and id_dist in (".$_GET['id_dist'].")");
			}
			else
			{		
				$query = $this->db->query("select distinct id_cust from channel a, customer b where id_cust not in (select distinct id_cust from customer_redistribution where id_dist in (".$_GET['id_dist'].")) and is_pharmachain=0 and a.id_channel=b.id_channel and b.id_dist in (".$_GET['id_dist'].") and big=".$value);
			}	
			foreach ($query->result() as $row2)
			{
				$id_cust=$id_cust."'".$row2->id_cust."',";				
			}
			$id_cust=$id_cust."''";

			for($j=$_GET['month1'];$j<=$_GET['month2'];$j++)
			{
				$query = $this->db->query("select ".$sum." as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$_GET['year'].str_pad($j,2,"0",STR_PAD_LEFT)."'");
				foreach ($query->result() as $row2)
				{			
					if($row2->total==null)
					{
						$result=$result."0;";
						$total[$j-1] = $total[$j-1] + 0;
					}
					else
					{			
						$result=$result.number_format($row2->total,2).";";
						$total[$j-1] = $total[$j-1] + $row2->total;
					}	
				}
			}	
		}	
			for($j=$_GET['month1'];$j<=$_GET['month2'];$j++)
			{
				$result=$result.number_format($total[$j-1],2).";";
			}
		$result=rtrim($result, ";");
		$result=str_replace(".00","",$result);
		echo $result;
	}	

	public function getTotal2()
	{
		$result=array();
		$result2=array();
		$result3="";
		$result5="";
		$result6="";
		$result4=array();
		$average1 = 0;
		$average2 = 0;

		$id_channel = explode(",", $_GET['id_channel']);

		$type = $_GET['type'];
		
		if($type=="1")
		{
			$sum="sum(qty_sales+retur_qty)";
		}
		else
		{
			$sum="sum(sales_value+retur_value)";
		}			

		foreach ($id_channel as &$value) 
		{
			$id_cust="";
			if($value==6)
			{
				$query = $this->db->query("select distinct id_cust from customer b where id_cust not in (select distinct id_cust from customer_redistribution where id_dist in (".$_GET['id_dist'].")) and is_pharmachain=1 and id_dist in (".$_GET['id_dist'].")");
			}
			else
			{		
				$query = $this->db->query("select distinct id_cust from channel a, customer b where id_cust not in (select distinct id_cust from customer_redistribution where id_dist in (".$_GET['id_dist'].")) and is_pharmachain=0 and a.id_channel=b.id_channel and b.id_dist in (".$_GET['id_dist'].") and big=".$value);
			}	
			foreach ($query->result() as $row2)
			{
				$id_cust=$id_cust."'".$row2->id_cust."',";				
			}
			$id_cust=$id_cust."''";

			$result[$value-1] = 0;
			$result2[$value-1] = 0;
			$result4[$value-1] = 0;
			$query = $this->db->query("select ".$sum."/".$_GET['month2']." as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period between '".$_GET['year2']."01' and '".$_GET['year2'].str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."'");
			foreach ($query->result() as $row2)
			{			
				if($row2->total==null)
				{
					$result[$value-1]=0;
				}
				else
				{			
					$result[$value-1]=$row2->total;
					$average2 = $average2 + $row2->total;
				}	
			}
			$query = $this->db->query("select ".$sum."/".(12-$_GET['month1']+1)." as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period between '".$_GET['year1'].str_pad($_GET['month1'],2,"0",STR_PAD_LEFT)."' and '".$_GET['year1']."12'");
			foreach ($query->result() as $row2)
			{			
				if($row2->total==null)
				{
					if($result[$value-1]==0)
					{	
						$result2[$value-1]=0;
						$result4[$value-1]=0;
					}
					else
					{	
						$result2[$value-1]=100;						
						$result4[$value-1]=number_format($result[$value-1],2);
					}
				}
				else
				{				
					$average1 = $average1 + $row2->total;
					$result2[$value-1]=number_format($result[$value-1]*100/$row2->total,2);
					$result4[$value-1]=number_format($result[$value-1]-$row2->total,2);
				}
			}
			$result3=$result3.$result2[$value-1].";";
			$result5=$result5.$result4[$value-1].";";
		}	
		if($average1==0)
		{
			$result6=$result3."0;".$result5.number_format($average2-$average1,2).";";
		}
		else
		{
			$result6=$result3.number_format($average2*100/$average1,2).";".$result5.number_format($average2-$average1,2).";";
		}	
		$result6=rtrim($result6, ";");
		$result6=str_replace(".00","",$result6);
		unset($result2);
		unset($result4);
		unset($result);
		echo $result6;
	}	

}
