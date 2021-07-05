<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report2 extends CI_Controller {

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
		$this->load->view('report2',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
			
			
			$crud->set_theme('bootstrap');
			$crud->set_table('user');
			$crud->set_subject('Report Sales');
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

		$total2 =0;
		$total3 =0;
		$total = array();
		$result2 = "";

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

		$id_dist = explode(",", $_GET['id_dist']);

		$pharma="";
		if (strpos($_GET['id_channel'], '6') !== false)
		{
			$pharma=$pharma."'1',";				
		}			
		if (strpos($_GET['id_channel'], '1') !== false || strpos($_GET['id_channel'], '2') !== false || strpos($_GET['id_channel'], '3') !== false || strpos($_GET['id_channel'], '4') !== false || strpos($_GET['id_channel'], '5') !== false || strpos($_GET['id_channel'], '7') !== false || strpos($_GET['id_channel'], '8') !== false)
		{
			$pharma=$pharma."'0',";				
		}			
		$pharma=$pharma."''";

		$type = $_GET['type'];
		
		if($type=="1")
		{
			$sum="sum(qty_sales+retur_qty)";
		}
		else
		{
			$sum="sum(sales_value+retur_value)";
		}			

		$type2 = $_GET['type2'];

		if($type2=="1")
		{
			$where="";
		}
		else
		{	
			$where="id_cust not in (select id_cust from customer_redistribution where id_dist in (".$_GET['id_dist'].")) and ";
		}

		$colour = array('#0275d8','#888888','#d11141','#00b159','#00aedb','#f37735','#ffc425','#e43b22');
		$channel = array("1 HOSPITAL", "2 PHARMACY", "3 DRUGSTORE", "4 INSTITUTION", "5 MTC", "6 PHARMA CHAIN", "7 GT & OTHERS", "8 PBF","TOTAL");

		$id_channel = explode(",", $_GET['id_channel']);

		foreach ($id_channel as &$value)
		{	

			$id_cust="";
			if($value==6)
			{
				if($type2=="1")
				{
					$query = $this->db->query("select distinct id_cust from customer b where ".$where." is_pharmachain=1 and id_dist in (2) and group_customer not in ('DAYA MUDA AGUNG','KIMIA FARMA TRADING','KIMIA FARMA DISTRIBU','TRI SAPTAJAYA','ENSEVAL PUTERA')");
				}
				else
				{
					$query = $this->db->query("select distinct id_cust from customer b where ".$where." is_pharmachain=1 and id_dist in (".$_GET['id_dist'].")");
				}					
			}
			else
			{		
				if($type2=="1")
				{
					$query = $this->db->query("select distinct id_cust from channel a, customer b where ".$where." a.id_channel=b.id_channel and is_pharmachain=0 and b.id_dist in (2) and big='".$value."' and group_customer not in ('DAYA MUDA AGUNG','KIMIA FARMA TRADING','KIMIA FARMA DISTRIBU','TRI SAPTAJAYA','ENSEVAL PUTERA')");
				}
				else
				{
					$query = $this->db->query("select distinct id_cust from channel a, customer b where ".$where." a.id_channel=b.id_channel and is_pharmachain=0 and b.id_dist in (".$_GET['id_dist'].") and big=".$value);
				}					
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
				$datasets=$datasets."\"borderColor\":\"".$colour[$value-1]."\",";
				$datasets=$datasets."\"backgroundColor\":\"".$colour[$value-1]."33\",";
				
				$datasets=$datasets."\"data\": [";

				$k = 0;
				for($j=$_GET['year1'];$j<=$_GET['year2'];$j++)
				{
					if($_GET['year1']==$_GET['year2'])
					{
							for($i=$_GET['month1'];$i<=$_GET['month2'];$i++)
							{	
								if(!isset($total[$k]))	
								{	
									$total[$k]=0;
								}	
								$average1 = 0;
								$divider=$_GET['month2']-$_GET['month1']+1;
								$query = $this->db->query("select ".$sum." as average from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$j.str_pad($i,2,"0",STR_PAD_LEFT)."'");
								foreach ($query->result() as $row2)
								{			
									if($row2->average==null)
									{
				//						$average1="0";
									}
									else
									{			
										$average1=$average1+($row2->average);
										$total2 = $total2 + $row2->average;
										$total[$k] = $total[$k] + $row2->average;
										$datasets=$datasets."\"".$row2->average."\",";
									}	
								}
								$k = $k + 1;
							}	
							$result2=$result2.number_format($total2,2).";";
							$result2=$result2.number_format($total2/($_GET['month2']-$_GET['month1']+1),2).";";
							$total2 =0;
					}
					else
					{
						if($j==$_GET['year1'])
						{
							for($i=$_GET['month1'];$i<=12;$i++)
							{	
								if(!isset($total[$k]))	
								{	
									$total[$k]=0;
								}	
								$average1 = 0;
								$divider=12-$_GET['month1']+1;
								$query = $this->db->query("select ".$sum." as average from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$j.str_pad($i,2,"0",STR_PAD_LEFT)."'");
								foreach ($query->result() as $row2)
								{			
									if($row2->average==null)
									{
				//						$average1="0";
									}
									else
									{			
										$average1=$average1+($row2->average);
										$total2 = $total2 + $row2->average;
										$total[$k] = $total[$k] + $row2->average;
										$datasets=$datasets."\"".$row2->average."\",";
									}	
								}
								$k = $k + 1;
							}	
							$result2=$result2.number_format($total2,2).";";
							$result2=$result2.number_format($total2/(12-$_GET['month1']+1),2).";";
							$total2 =0;
						}
						else if($j==$_GET['year2'])
						{
							for($i=1;$i<=$_GET['month2'];$i++)
							{	
								if(!isset($total[$k]))	
								{	
									$total[$k]=0;
								}	
								$average1 = 0;
								$divider=$_GET['month2'];
								$query = $this->db->query("select ".$sum." as average from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$j.str_pad($i,2,"0",STR_PAD_LEFT)."'");
								foreach ($query->result() as $row2)
								{			
									if($row2->average==null)
									{
				//						$average1="0";
									}
									else
									{
										$average1=$average1+($row2->average);
										$total2 = $total2 + $row2->average;
										$total[$k] = $total[$k] + $row2->average;
										$datasets=$datasets."\"".$row2->average."\",";
									}	
								}
								$k = $k + 1;
							}	
							$result2=$result2.number_format($total2,2).";";
							$result2=$result2.number_format($total2/$_GET['month2'],2).";";
							$total2 =0;
						}
						else
						{
							for($i=1;$i<=12;$i++)
							{	
								if(!isset($total[$k]))	
								{	
									$total[$k]=0;
								}	
								$average1 = 0;
								$divider=12;
								$query = $this->db->query("select ".$sum." as average from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$j.str_pad($i,2,"0",STR_PAD_LEFT)."'");
								foreach ($query->result() as $row2)
								{			
									if($row2->average==null)
									{
				//						$average1="0";
									}
									else
									{			
										$average1=$average1+($row2->average);
										$total2 = $total2 + $row2->average;
										$total[$k] = $total[$k] + $row2->average;
										$datasets=$datasets."\"".$row2->average."\",";
									}	
								}
								$k = $k + 1;
							}	
							$result2=$result2.number_format($total2,2).";";
							$result2=$result2.number_format($total2/12,2).";";
							$total2 =0;
						}				
					}	
				}

			$datasets=rtrim($datasets,",");
			$datasets=$datasets."]";
			$datasets=$datasets."},";
		}

		for($j=$_GET['year1'];$j<=$_GET['year2'];$j++)
		{
			if($_GET['year2']==$_GET['year1'])
			{	
				$total3 = 0;
				$l = 0;
				for($i=$_GET['month1'];$i<=$_GET['month2'];$i++)
				{	
					$total3 = $total3 + $total[$l];
					$l = $l + 1;
				}	
				$result2=$result2.number_format($total3,2).";";
				$result2=$result2.number_format($total3/($_GET['month2']-$_GET['month1']+1),2).";";
			}
			else
			{	
				if($j==$_GET['year1'])
				{
					$total3 = 0;
					$l = 0;
					for($i=$_GET['month1'];$i<=12;$i++)
					{	
						$total3 = $total3 + $total[$l];
						$l = $l + 1;
					}	
					$result2=$result2.number_format($total3,2).";";
					$result2=$result2.number_format($total3/(12-$_GET['month1']+1),2).";";
					$total3 = 0;
				}
				else if($j==$_GET['year2'])
				{
					for($i=1;$i<=$_GET['month2'];$i++)
					{	
						$total3 = $total3 + $total[$l];
						$l = $l + 1;
					}	
					$result2=$result2.number_format($total3,2).";";
					$result2=$result2.number_format($total3/(12-$_GET['month1']+1),2).";";
					$total3 = 0;
				}
				else
				{
					for($i=1;$i<=12;$i++)
					{	
						$total3 = $total3 + $total[$l];
						$l = $l + 1;
					}	
					$result2=$result2.number_format($total3,2).";";
					$result2=$result2.number_format($total3/(12-$_GET['month1']+1),2).";";
					$total3 = 0;
				}				
			}	
		}

		$result2=rtrim($result2, ";");
		$result2=str_replace(".00","",$result2);
		$labels=rtrim($labels,",");
		$datasets=rtrim($datasets,",");
		$labels=$labels."],";	
		$datasets=$datasets."]}";
		//echo json_encode($result);


		$total2 =0;
		$total3 =0;
		$result2a ="";
//		$total = array();
		if($type2=="1")
		{
			foreach (array_keys($id_dist, "2", true) as $key) {
				unset($id_dist[$key]);
			}			
			
			foreach ($id_dist as &$value) 
			{
				if($value=="1")
				{
					$keyword="'XXX'";
				}					
				else if($value=="3")
				{
					$keyword="'DAYA MUDA AGUNG'";
				}					
				else if($value=="4")
				{
					$keyword="'KIMIA FARMA DISTRIBU','KIMIA FARMA TRADING'";
				}					
				else if($value=="5")
				{
					$keyword="'TRI SAPTAJAYA'";
				}					
				else if($value=="6")
				{
					$keyword="'ENSEVAL PUTERA'";
				}					
				$id_cust="";
				$query = $this->db->query("select distinct id_cust from channel a, customer b where is_pharmachain in (".$pharma.") and a.id_channel=b.id_channel and b.id_dist in (2) and group_customer in (".$keyword.") and a.big in (".$_GET['id_channel'].")");
				foreach ($query->result() as $row2)
				{
					$id_cust=$id_cust."'".$row2->id_cust."',";				
				}
				$id_cust=$id_cust."''";

				$k = 0;
				for($j=$_GET['year1'];$j<=$_GET['year2'];$j++)
				{
					if($_GET['year1']==$_GET['year2'])
					{
							for($i=$_GET['month1'];$i<=$_GET['month2'];$i++)
							{	
								if(!isset($total[$k]))	
								{	
									$total[$k]=0;
								}	
								$average1 = 0;
								$divider=$_GET['month2']-$_GET['month1']+1;
								$query = $this->db->query("select ".$sum." as average from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$j.str_pad($i,2,"0",STR_PAD_LEFT)."'");
								foreach ($query->result() as $row2)
								{			
									if($row2->average==null)
									{
				//						$average1="0";
									}
									else
									{			
										$average1=$average1+($row2->average);
										$total2 = $total2 + $row2->average;
										$total[$k] = $total[$k] + $row2->average;
									}	
								}
								$k = $k + 1;
							}	
							$result2a=$result2a.number_format($total2,2).";";
							$result2a=$result2a.number_format($total2/($_GET['month2']-$_GET['month1']+1),2).";";
							$total2 =0;
					}
					else
					{
						if($j==$_GET['year1'])
						{
							for($i=$_GET['month1'];$i<=12;$i++)
							{	
								if(!isset($total[$k]))	
								{	
									$total[$k]=0;
								}	
								$average1 = 0;
								$divider=12-$_GET['month1']+1;
								$query = $this->db->query("select ".$sum." as average from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$j.str_pad($i,2,"0",STR_PAD_LEFT)."'");
								foreach ($query->result() as $row2)
								{			
									if($row2->average==null)
									{
				//						$average1="0";
									}
									else
									{			
										$average1=$average1+($row2->average);
										$total2 = $total2 + $row2->average;
										$total[$k] = $total[$k] + $row2->average;
									}	
								}
								$k = $k + 1;
							}	
							$result2a=$result2a.number_format($total2,2).";";
							$result2a=$result2a.number_format($total2/(12-$_GET['month1']+1),2).";";
							$total2 =0;
						}
						else if($j==$_GET['year2'])
						{
							for($i=1;$i<=$_GET['month2'];$i++)
							{	
								if(!isset($total[$k]))	
								{	
									$total[$k]=0;
								}	
								$average1 = 0;
								$divider=$_GET['month2'];
								$query = $this->db->query("select ".$sum." as average from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$j.str_pad($i,2,"0",STR_PAD_LEFT)."'");
								foreach ($query->result() as $row2)
								{			
									if($row2->average==null)
									{
				//						$average1="0";
									}
									else
									{
										$average1=$average1+($row2->average);
										$total2 = $total2 + $row2->average;
										$total[$k] = $total[$k] + $row2->average;
									}	
								}
								$k = $k + 1;
							}	
							$result2a=$result2a.number_format($total2,2).";";
							$result2a=$result2a.number_format($total2/$_GET['month2'],2).";";
							$total2 =0;
						}
						else
						{
							for($i=1;$i<=12;$i++)
							{	
								if(!isset($total[$k]))	
								{	
									$total[$k]=0;
								}	
								$average1 = 0;
								$divider=12;
								$query = $this->db->query("select ".$sum." as average from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$j.str_pad($i,2,"0",STR_PAD_LEFT)."'");
								foreach ($query->result() as $row2)
								{			
									if($row2->average==null)
									{
				//						$average1="0";
									}
									else
									{			
										$average1=$average1+($row2->average);
										$total2 = $total2 + $row2->average;
										$total[$k] = $total[$k] + $row2->average;
									}	
								}
								$k = $k + 1;
							}	
							$result2a=$result2a.number_format($total2,2).";";
							$result2a=$result2a.number_format($total2/12,2).";";
							$total2 =0;
						}				
					}	
				}

			}


			for($j=$_GET['year1'];$j<=$_GET['year2'];$j++)
			{
				if($_GET['year2']==$_GET['year1'])
				{	
//					$total3 = 0;
					$l = 0;
					for($i=$_GET['month1'];$i<=$_GET['month2'];$i++)
					{	
						$total3 = $total3 + $total[$l];
						$l = $l + 1;
					}	
					$result2a=$result2a.number_format($total3,2).";";
					$result2a=$result2a.number_format($total3/($_GET['month2']-$_GET['month1']+1),2).";";
				}
				else
				{	
					if($j==$_GET['year1'])
					{
//						$total3 = 0;
						$l = 0;
						for($i=$_GET['month1'];$i<=12;$i++)
						{	
							$total3 = $total3 + $total[$l];
							$l = $l + 1;
						}	
						$result2a=$result2a.number_format($total3,2).";";
						$result2a=$result2a.number_format($total3/(12-$_GET['month1']+1),2).";";
						$total3 = 0;
					}
					else if($j==$_GET['year2'])
					{
						for($i=1;$i<=$_GET['month2'];$i++)
						{	
							$total3 = $total3 + $total[$l];
							$l = $l + 1;
						}	
						$result2a=$result2a.number_format($total3,2).";";
						$result2a=$result2a.number_format($total3/(12-$_GET['month1']+1),2).";";
						$total3 = 0;
					}
					else
					{
						for($i=1;$i<=12;$i++)
						{	
							$total3 = $total3 + $total[$l];
							$l = $l + 1;
						}	
						$result2a=$result2a.number_format($total3,2).";";
						$result2a=$result2a.number_format($total3/(12-$_GET['month1']+1),2).";";
						$total3 = 0;
					}				
				}	
			}

			$result2a="|".rtrim($result2a, ";");
			$result2a=str_replace(".00","",$result2a);

		}	
		echo $result2."|".$labels.$datasets.$result2a;		
	}


	public function getTotal()
	{
		$result="";
		$total = 0;
		$average = 0;
		
		$id_channel = explode(",", $_GET['id_channel']);
				
		$id_dist = explode(",", $_GET['id_dist']);

		$type = $_GET['type'];
		
		if($type=="1")
		{
			$sum="sum(qty_sales+retur_qty)";
		}
		else
		{
			$sum="sum(sales_value+retur_value)";
		}			

		$pharma="";
		if (strpos($_GET['id_channel'], '6') !== false)
		{
			$pharma=$pharma."'1',";				
		}			
		if (strpos($_GET['id_channel'], '1') !== false || strpos($_GET['id_channel'], '2') !== false || strpos($_GET['id_channel'], '3') !== false || strpos($_GET['id_channel'], '4') !== false || strpos($_GET['id_channel'], '5') !== false || strpos($_GET['id_channel'], '7') !== false || strpos($_GET['id_channel'], '8') !== false)
		{
			$pharma=$pharma."'0',";				
		}			
		$pharma=$pharma."''";

		$type2 = $_GET['type2'];

		if($type2=="1")
		{
			$where="";
		}
		else
		{	
			$where="id_cust not in (select id_cust from customer_redistribution where id_dist in (".$_GET['id_dist'].")) and ";
		}

		$id_custarray = array();
		foreach ($id_channel as &$value)
		{
			$id_cust2="";
			if($value==6)
			{
				if($type2=="1")
				{
					$query2 = $this->db->query("select distinct id_cust from customer b where ".$where." is_pharmachain=1 and id_dist in (2) and group_customer not in ('DAYA MUDA AGUNG','KIMIA FARMA TRADING','KIMIA FARMA DISTRIBU','TRI SAPTAJAYA','ENSEVAL PUTERA')");
				}
				else
				{
					$query2 = $this->db->query("select distinct id_cust from customer b where ".$where." is_pharmachain=1 and id_dist in (".$_GET['id_dist'].")");
				}					
			}
			else
			{		
				if($type2=="1")
				{
					$query2 = $this->db->query("select distinct id_cust from channel a, customer b where ".$where." a.id_channel=b.id_channel and is_pharmachain=0 and b.id_dist in (2) and big='".$value."' and group_customer not in ('DAYA MUDA AGUNG','KIMIA FARMA TRADING','KIMIA FARMA DISTRIBU','TRI SAPTAJAYA','ENSEVAL PUTERA')");
				}
				else
				{
					$query2 = $this->db->query("select distinct id_cust from channel a, customer b where ".$where." a.id_channel=b.id_channel and is_pharmachain=0 and b.id_dist in (".$_GET['id_dist'].") and big=".$value);
				}					
			}	
			foreach ($query2->result() as $row3)
			{			
				$id_cust2=$id_cust2."'".$row3->id_cust."',";				
			}
			$id_cust2=$id_cust2."''";
			
			$id_custarray[$value]=$id_cust2;

		}


		for($j=$_GET['year1'];$j<=$_GET['year2'];$j++)
		{

			$total = 0;
			$average = 0;
			foreach ($id_channel as &$value)
			{
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
		
		$result2="";
		if($type2=="1")
		{
			foreach (array_keys($id_dist, 2, true) as $key) {
				unset($id_dist[$key]);
			}			
			
			foreach ($id_dist as &$value) 
			{
				if($value=="1")
				{
					$keyword="'XXX'";
				}					
				else if($value=="3")
				{
					$keyword="'DAYA MUDA AGUNG'";
				}					
				else if($value=="4")
				{
					$keyword="'KIMIA FARMA DISTRIBU','KIMIA FARMA TRADING'";
				}					
				else if($value=="5")
				{
					$keyword="'TRI SAPTAJAYA'";
				}					
				else if($value=="6")
				{
					$keyword="'ENSEVAL PUTERA'";
				}					
				$id_cust="";
				$query = $this->db->query("select distinct id_cust from channel a, customer b where is_pharmachain in (".$pharma.") and a.id_channel=b.id_channel and b.id_dist in (2) and group_customer in (".$keyword.") and a.big in (".$_GET['id_channel'].")");
				foreach ($query->result() as $row2)
				{
					$id_cust=$id_cust."'".$row2->id_cust."',";				
				}
				$id_cust=$id_cust."''";

				$total = 0;
				$average = 0;

				for($j=$_GET['year1'];$j<=$_GET['year2'];$j++)
				{

					$total = 0;
					$average = 0;
					//foreach ($id_channel as &$value)
					{
						if($_GET['year1']==$_GET['year2'])
						{
							$divider=$_GET['month2']-$_GET['month1']+1;
							$query = $this->db->query("select ".$sum." as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period between '".$j.str_pad($_GET['month1'],2,"0",STR_PAD_LEFT)."' and '".$j.str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."'");
						}
						else
						{		
							if($j==$_GET['year1'])
							{
								$divider=12-$_GET['month1']+1;
								$query = $this->db->query("select ".$sum." as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cus.") and period between '".$j.str_pad($_GET['month1'],2,"0",STR_PAD_LEFT)."' and '".$j."12'");
							}				
							else if($j==$_GET['year2'])
							{
								$divider=$_GET['month2'];
								$query = $this->db->query("select ".$sum." as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period between '".$j."01' and '".$j.str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."'");
							}				
							else
							{
								$divider=12;				
								$query = $this->db->query("select ".$sum." as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and substr(period,1,4)='".$j."'");
							}				
						}	
						foreach ($query->result() as $row2)
						{			
							if($row2->total==null)
							{
								$result2=$result2."0;0;";
							}
							else
							{			
								$result2=$result2.number_format($row2->total,2).";".number_format($row2->total/$divider,2).";";
								$total = $total + $row2->total;
								$average = $average + ($row2->total/$divider);
							}	
						}
					}
					$result2=$result2.number_format($total,2).";".number_format($average,2).";";
				}
			}	


		}			
		
		
//		echo $result."|".$result2;;
		echo $result;
	}	

	public function getTotal3()
	{
		$result="";

		$id_dist = explode(",", $_GET['id_dist']);

		$pharma="";
		if (strpos($_GET['id_channel'], '6') !== false)
		{
			$pharma=$pharma."'1',";				
		}			
		if (strpos($_GET['id_channel'], '1') !== false || strpos($_GET['id_channel'], '2') !== false || strpos($_GET['id_channel'], '3') !== false || strpos($_GET['id_channel'], '4') !== false || strpos($_GET['id_channel'], '5') !== false || strpos($_GET['id_channel'], '7') !== false || strpos($_GET['id_channel'], '8') !== false)
		{
			$pharma=$pharma."'0',";				
		}			
		$pharma=$pharma."''";

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

		$type2 = $_GET['type2'];

		if($type2=="1")
		{
			$where="";
		}
		else
		{	
			$where="id_cust not in (select id_cust from customer_redistribution where id_dist in (".$_GET['id_dist'].")) and ";
		}

		foreach ($id_channel as &$value) 
		{	

			$id_cust="";
			if($value==6)
			{
				if($type2=="1")
				{
					$query = $this->db->query("select distinct id_cust from customer b where ".$where." is_pharmachain=1 and id_dist in (2) and group_customer not in ('DAYA MUDA AGUNG','KIMIA FARMA TRADING','KIMIA FARMA DISTRIBU','TRI SAPTAJAYA','ENSEVAL PUTERA')");
				}
				else
				{
					$query = $this->db->query("select distinct id_cust from customer b where ".$where." is_pharmachain=1 and id_dist in (".$_GET['id_dist'].")");
				}					

			}
			else
			{		
				if($type2=="1")
				{
					$query = $this->db->query("select distinct id_cust from channel a, customer b where ".$where." a.id_channel=b.id_channel and is_pharmachain=0 and b.id_dist in (2) and big='".$value."' and group_customer not in ('DAYA MUDA AGUNG','KIMIA FARMA TRADING','KIMIA FARMA DISTRIBU','TRI SAPTAJAYA','ENSEVAL PUTERA')");
				}
				else
				{
					$query = $this->db->query("select distinct id_cust from channel a, customer b where ".$where." a.id_channel=b.id_channel and is_pharmachain=0 and b.id_dist in (".$_GET['id_dist'].") and big='".$value."'");
				}					
			}	
			foreach ($query->result() as $row2)
			{
				$id_cust=$id_cust."'".$row2->id_cust."',";				
			}
			$id_cust=$id_cust."''";
//			$id_cust=rtrim($id_cust,",");

			for($j=$_GET['month1'];$j<=$_GET['month2'];$j++)
			{
				$query = $this->db->query("select ".$sum." as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$_GET['year'].str_pad($j,2,"0",STR_PAD_LEFT)."'");
				foreach ($query->result() as $row2)
				{			
					if($row2->total==null)
					{
						$result=$result."0;";
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


		$total2 = array();
		$total2[0] = 0;
		$total2[1] = 0;
		$total2[2] = 0;
		$total2[3] = 0;
		$total2[4] = 0;
		$total2[5] = 0;
		$total2[6] = 0;
		$total2[7] = 0;
		$total2[8] = 0;
		$total2[9] = 0;
		$total2[10] = 0;
		$total2[11] = 0;
		$result2="";
		if($type2=="1")
		{
			$result2="|";
			foreach (array_keys($id_dist, "2", true) as $key) {
				unset($id_dist[$key]);
			}			
			
			foreach ($id_dist as &$value) 
			{
				if($value=="1")
				{
					$keyword="'XXX'";
				}					
				else if($value=="3")
				{
					$keyword="'DAYA MUDA AGUNG'";
				}					
				else if($value=="4")
				{
					$keyword="'KIMIA FARMA DISTRIBU','KIMIA FARMA TRADING'";
				}					
				else if($value=="5")
				{
					$keyword="'TRI SAPTAJAYA'";
				}					
				else if($value=="6")
				{
					$keyword="'ENSEVAL PUTERA'";
				}					
				$id_cust="";
				$query = $this->db->query("select distinct id_cust from channel a, customer b where is_pharmachain in (".$pharma.") and a.id_channel=b.id_channel and b.id_dist in (2) and group_customer in (".$keyword.") and a.big in (".$_GET['id_channel'].")");
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
							$result2=$result2."0;";
						}
						else
						{			
							$result2=$result2.number_format($row2->total,2).";";
							$total2[$j-1] = $total2[$j-1] + $row2->total;
						}	
					}
				}	
			}
			for($j=$_GET['month1'];$j<=$_GET['month2'];$j++)
			{
				$result2=$result2.number_format($total2[$j-1]+$total[$j-1],2).";";
			}
			$result2=rtrim($result2, ";");
			$result2=str_replace(".00","",$result2);
			
		}

		echo $result.$result2;
	}	

	public function getTotal2()
	{
		$id_dist = explode(",", $_GET['id_dist']);

		$pharma="";
		if (strpos($_GET['id_channel'], '6') !== false)
		{
			$pharma=$pharma."'1',";				
		}			
		if (strpos($_GET['id_channel'], '1') !== false || strpos($_GET['id_channel'], '2') !== false || strpos($_GET['id_channel'], '3') !== false || strpos($_GET['id_channel'], '4') !== false || strpos($_GET['id_channel'], '5') !== false || strpos($_GET['id_channel'], '7') !== false || strpos($_GET['id_channel'], '8') !== false)
		{
			$pharma=$pharma."'0',";				
		}			
		$pharma=$pharma."''";

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

		$type2 = $_GET['type2'];

		if($type2=="1")
		{
			$where="";
		}
		else
		{	
			$where="id_cust not in (select id_cust from customer_redistribution where id_dist in (".$_GET['id_dist'].")) and ";
		}

		foreach ($id_channel as &$value) 
		{
			$id_cust="";
			if($value==6)
			{
				if($type2=="1")
				{
					$query = $this->db->query("select distinct id_cust from customer b where ".$where." is_pharmachain=1 and id_dist in (2) and group_customer not in ('DAYA MUDA AGUNG','KIMIA FARMA TRADING','KIMIA FARMA DISTRIBU','TRI SAPTAJAYA','ENSEVAL PUTERA')");
				}
				else
				{
					$query = $this->db->query("select distinct id_cust from customer b where ".$where." is_pharmachain=1 and id_dist in (".$_GET['id_dist'].")");
				}					
			}
			else
			{		
				if($type2=="1")
				{
					$query = $this->db->query("select distinct id_cust from channel a, customer b where ".$where." a.id_channel=b.id_channel and is_pharmachain=0 and b.id_dist in (2) and big='".$value."' and group_customer not in ('DAYA MUDA AGUNG','KIMIA FARMA TRADING','KIMIA FARMA DISTRIBU','TRI SAPTAJAYA','ENSEVAL PUTERA')");
				}
				else
				{
					$query = $this->db->query("select distinct id_cust from channel a, customer b where ".$where." a.id_channel=b.id_channel and is_pharmachain=0 and b.id_dist in (".$_GET['id_dist'].") and big=".$value);
				}					
			}	
			foreach ($query->result() as $row2)
			{
				$id_cust=$id_cust."'".$row2->id_cust."',";				
			}
			$id_cust=$id_cust."''";

			$result[$value-1] = 0;
			$result2[$value-1] = 0;
			$result4[$value-1] = 0;
			$query = $this->db->query("select ".$sum."/".$_GET['month2']." as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and substr(period,1,4)='".$_GET['year2']."' and period between '".$_GET['year2']."01' and '".$_GET['year2'].str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."'");
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


		$resulta=array();
		$result2a=array();
		$result3a="";
		$result5a="";
		$result6a="";
		$result4a=array();
//		$average1 = 0;
//		$average2 = 0;
		if($type2=="1")
		{
			foreach (array_keys($id_dist, "2", true) as $key) {
				unset($id_dist[$key]);
			}			
			
			foreach ($id_dist as &$value) 
			{
				if($value=="1")
				{
					$keyword="'XXX'";
				}					
				else if($value=="3")
				{
					$keyword="'DAYA MUDA AGUNG'";
				}					
				else if($value=="4")
				{
					$keyword="'KIMIA FARMA DISTRIBU','KIMIA FARMA TRADING'";
				}					
				else if($value=="5")
				{
					$keyword="'TRI SAPTAJAYA'";
				}					
				else if($value=="6")
				{
					$keyword="'ENSEVAL PUTERA'";
				}					
				$id_cust="";
				$query = $this->db->query("select distinct id_cust from channel a, customer b where is_pharmachain in (".$pharma.") and a.id_channel=b.id_channel and b.id_dist in (2) and group_customer in (".$keyword.") and a.big in (".$_GET['id_channel'].")");
				foreach ($query->result() as $row2)
				{
					$id_cust=$id_cust."'".$row2->id_cust."',";				
				}
				$id_cust=$id_cust."''";


				$resulta[$value-1] = 0;
				$result2a[$value-1] = 0;
				$result4a[$value-1] = 0;
				$query = $this->db->query("select ".$sum."/".$_GET['month2']." as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and substr(period,1,4)='".$_GET['year2']."' and period between '".$_GET['year2']."01' and '".$_GET['year2'].str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."'");
				foreach ($query->result() as $row2)
				{			
					if($row2->total==null)
					{
						$resulta[$value-1]=0;
					}
					else
					{			
						$resulta[$value-1]=$row2->total;
						$average2 = $average2 + $row2->total;
					}	
				}
				$query = $this->db->query("select ".$sum."/".(12-$_GET['month1']+1)." as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period between '".$_GET['year1'].str_pad($_GET['month1'],2,"0",STR_PAD_LEFT)."' and '".$_GET['year1']."12'");
				foreach ($query->result() as $row2)
				{			
					if($row2->total==null)
					{
						if($resulta[$value-1]==0)
						{	
							$result2a[$value-1]=0;
							$result4a[$value-1]=0;
						}
						else
						{	
							$result2a[$value-1]=100;						
							$result4a[$value-1]=number_format($resulta[$value-1],2);
						}
					}
					else
					{				
						$average1 = $average1 + $row2->total;
						$result2a[$value-1]=number_format($resulta[$value-1]*100/$row2->total,2);
						$result4a[$value-1]=number_format($resulta[$value-1]-$row2->total,2);
					}
				}
				$result3a=$result3a.$result2a[$value-1].";";
				$result5a=$result5a.$result4a[$value-1].";";

			}
			if($average1==0)
			{
				$result6a="|".$result3a."0;".$result5a.number_format($average2-$average1,2).";";
			}
			else
			{
				$result6a="|".$result3a.number_format($average2*100/$average1,2).";".$result5a.number_format($average2-$average1,2).";";
			}	
			$result6a=rtrim($result6a, ";");
			$result6a=str_replace(".00","",$result6a);
			unset($result2a);
			unset($result4a);
			unset($resulta);
			
//			echo $result6;

		}
		echo $result6.$result6a;

	}	

}
