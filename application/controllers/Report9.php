<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report9 extends CI_Controller {

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
		$this->load->view('report9',(array)$output);
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

	public function getTotal3()
	{

		$month = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec");
		$colour = array('#0275d8','#888888','#d11141','#00b159','#00aedb','#f37735','#ffc425','#e43b22');

		$distributor = array();

		$query = $this->db->query("select id_dist, code from distributor order by id_dist");
		$i = 0;
		foreach ($query->result() as $row2)
		{
			$distributor[$i] = $row2->code;	
			$i = $i + 1;
		}

		$result="";
		$graph ="";
		$total = array();
		$total2 = array();
				
		$id_dist = explode(",", $_GET['id_dist']);

		$report = array('Buy from PPG','Sales to Trade','Closing Stock','Opening Stock','AO','DOI (in days)','Actual Stock Report');


		foreach ($id_dist as &$value)
		{

			$labels="{\"labels\": [";	
			$datasets="\"datasets\": [";

			for($l=0;$l<=6;$l++)
			{

			$response=$report[$l];
			//$colour = '#'.str_pad(dechex(rand(0x000000, 0x777777)), 6, 0, STR_PAD_LEFT);
			$datasets=$datasets."{";
			$datasets=$datasets."\"label\":\"".$response."\",";
				$datasets=$datasets."\"borderCapStyle\":\"square\",";
				$datasets=$datasets."\"borderDash\": [],";
				$datasets=$datasets."\"borderDashOffset\": 0.0,";
				$datasets=$datasets."\"borderJoinStyle\": \"miter\",";
				$datasets=$datasets."\"pointBorderColor\":\"".$colour[$l]."\",";
				$datasets=$datasets."\"pointBackgroundColor\":\"".$colour[$l]."\",";
				$datasets=$datasets."\"pointBorderWidth\": 2,";
				$datasets=$datasets."\"borderWidth\": 2,";
				$datasets=$datasets."\"pointHoverRadius\": 6,";
				$datasets=$datasets."\"pointHoverBackgroundColor\":\"".$colour[$l]."\",";
				$datasets=$datasets."\"pointHoverBorderColor\": \"".$colour[$l]."\",";
				$datasets=$datasets."\"pointHoverBorderWidth\": 2,";
				$datasets=$datasets."\"pointRadius\": 2,";
				$datasets=$datasets."\"pointHitRadius\": 2,";
				$datasets=$datasets."\"lineTension\":0.1,";
				$datasets=$datasets."\"spanGaps\": true,";
				$datasets=$datasets."\"fill\":true,";
				$datasets=$datasets."\"borderColor\":\"".$colour[$l]."\",";
				$datasets=$datasets."\"backgroundColor\":\"".$colour[$l]."33\",";


				$datasets=$datasets."\"data\": [";
				$k=0;
				for($i=$_GET['year1'];$i<=$_GET['year2'];$i++)
				{	
					if($l==0)
					{
						$id_cust="";
						$query = $this->db->query("select distinct id_cust from customer_redistribution where id_dist in (".$value.")");
						foreach ($query->result() as $row2)
						{
							$id_cust=$id_cust."'".$row2->id_cust."',";				
						}
						$id_cust=$id_cust."''";
						$id_cust=rtrim($id_cust,",");
					}					
					else if($l==1)
					{
						$id_cust="";
						$query = $this->db->query("select distinct id_cust from channel a, customer b where a.id_channel=b.id_channel and b.id_dist in (".$value.") and a.big in (".$_GET['id_channel'].")");
						foreach ($query->result() as $row2)
						{
							$id_cust=$id_cust."'".$row2->id_cust."',";				
						}
						$id_cust=$id_cust."''";
						$id_cust=rtrim($id_cust,",");
					}					
					else if($l==4)
					{
						$id_cust="";
						$query = $this->db->query("select distinct id_cust from channel a, customer b where id_cust not in (select distinct id_cust from customer_redistribution where id_dist in (".$value.")) and a.id_channel=b.id_channel and b.id_dist in (".$value.") and a.big in (".$_GET['id_channel'].")");
						foreach ($query->result() as $row2)
						{
							$id_cust=$id_cust."'".$row2->id_cust."',";				
						}
						$id_cust=$id_cust."''";
						$id_cust=rtrim($id_cust,",");
					}					

					if($l<=1)
					{	
						if($_GET['year2']==$_GET['year1'])
						{
								$total2[$l]=0;
								for($j=$_GET['month1'];$j<=$_GET['month2'];$j++)
								{
									if($l==0)	$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))	
									{
										$total[$l][$k]=0;
									}	
									$query = $this->db->query("select sum(sales_value+retur_value) as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'");
									foreach ($query->result() as $row2)
									{			
										if($row2->total==null)
										{
											$result=$result."0;";
											$total[$l][$k] = 0;
											$datasets=$datasets."\"0\",";
										}
										else
										{			
											$result=$result.number_format($row2->total,2).";";
											$total[$l][$k] = $row2->total;
											$datasets=$datasets."\"".($total[$l][$k]/1000000)."\",";
											$total2[$l] = $total2[$l] + $total[$l][$k];
										}	
									}
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/($_GET['month2']-$_GET['month1']+1),2).";";
						}
						else
						{		
							if($i==$_GET['year1'])
							{	
								$total2[$l]=0;
								for($j=$_GET['month1'];$j<=12;$j++)
								{
									if($l==0)	$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))	
									{
										$total[$l][$k]=0;
									}	
									$query = $this->db->query("select sum(sales_value+retur_value) as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'");
									foreach ($query->result() as $row2)
									{			
										if($row2->total==null)
										{
											$result=$result."0;";
											$total[$l][$k] = 0;
											$datasets=$datasets."\"0\",";
										}
										else
										{			
											$result=$result.number_format($row2->total,2).";";
											$total[$l][$k] = $row2->total;
											$datasets=$datasets."\"".($total[$l][$k]/1000000)."\",";
											$total2[$l] = $total2[$l] + $total[$l][$k];
										}	
									}
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/(13-$_GET['month1']),2).";";
								
							}	
							else if($i==$_GET['year2'])
							{	
								$total2[$l]=0;
								for($j=1;$j<=$_GET['month2'];$j++)
								{
									if($l==0)	$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))
									{	
										$total[$l][$k]=0;
									}	
									$query = $this->db->query("select sum(sales_value+retur_value) as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'");
									foreach ($query->result() as $row2)
									{			
										if($row2->total==null)
										{
											$result=$result."0;";
											$total[$l][$k] = 0;
											$datasets=$datasets."\"0\",";
										}
										else
										{			
											$result=$result.number_format($row2->total,2).";";
											$total[$l][$k] = $row2->total;
											$datasets=$datasets."\"".($total[$l][$k]/1000000)."\",";
											$total2[$l] = $total2[$l] + $total[$l][$k];
										}	
									}
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/$_GET['month2'],2).";";
							}
							else
							{
								$total2[$l]=0;
								for($j=1;$j<=12;$j++)
								{
									if($l==0)	$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))
									{	
										$total[$l][$k]=0;
									}	
									$query = $this->db->query("select sum(sales_value+retur_value) as total from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'");
									foreach ($query->result() as $row2)
									{			
										if($row2->total==null)
										{
											$result=$result."0;";
											$total[$l][$k] = 0;
											$datasets=$datasets."\"0\",";
										}
										else
										{			
											$result=$result.number_format($row2->total,2).";";
											$total[$l][$k] = $row2->total;
											$datasets=$datasets."\"".($total[$l][$k]/1000000)."\",";
											$total2[$l] = $total2[$l] + $total[$l][$k];
										}	
									}
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/12,2).";";
							}					
						}	
					}	
					else if($l==2)
					{
						if($_GET['year2']==$_GET['year1'])
						{
								$total2[$l]=0;
								for($j=$_GET['month1'];$j<=$_GET['month2'];$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))	
									{	
//										$total[$l][$k]=0;
									}	
									$total[$l][$k]=$total[0][$k]-$total[1][$k];
									$datasets=$datasets."\"".($total[$l][$k]/1000000)."\",";
									$total2[$l] = $total2[$l] + $total[$l][$k];
									$result=$result.number_format($total[$l][$k],2).";";
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/($_GET['month2']-$_GET['month1']+1),2).";";
						}
						else
						{	
							if($i==$_GET['year1'])
							{	
								$total2[$l]=0;
								for($j=$_GET['month1'];$j<=12;$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))	
									{	
//										$total[$l][$k]=0;
									}	
									$total[$l][$k]=$total[0][$k]-$total[1][$k];
									$datasets=$datasets."\"".($total[$l][$k]/1000000)."\",";
									$total2[$l] = $total2[$l] + $total[$l][$k];
									$result=$result.number_format($total[$l][$k],2).";";
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/(13-$_GET['month1']),2).";";
								
							}	
							else if($i==$_GET['year2'])
							{	
								$total2[$l]=0;
								for($j=1;$j<=$_GET['month2'];$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))
									{	
//										$total[$l][$k]=0;
									}	
									$total[$l][$k]=$total[0][$k]-$total[1][$k];
									$datasets=$datasets."\"".($total[$l][$k]/1000000)."\",";
									$total2[$l] = $total2[$l] + $total[$l][$k];
									$result=$result.number_format($total[$l][$k],2).";";
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/$_GET['month2'],2).";";
							}
							else
							{
								$total2[$l]=0;
								for($j=1;$j<=12;$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))
									{	
//										$total[$l][$k]=0;
									}	
									$total[$l][$k]=$total[0][$k]-$total[1][$k];
									$datasets=$datasets."\"".($total[$l][$k]/1000000)."\",";
									$total2[$l] = $total2[$l] + $total[$l][$k];
									$result=$result.number_format($total[$l][$k],2).";";
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/12,2).";";
							}					
						}	
					}
					else if($l==3)
					{
						if($_GET['year2']==$_GET['year1'])
						{
								$total2[$l]=0;
								for($j=$_GET['month1'];$j<=$_GET['month2']-1;$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))	
									{	
										$total[$l][$k]=0;
									}	
									$total[$l][$k]=$total[2][$k+1];
									$datasets=$datasets."\"".($total[$l][$k]/1000000)."\",";
									$total2[$l] = $total2[$l] + $total[$l][$k];
									$result=$result.number_format($total[$l][$k],2).";";
									$k = $k + 1;
								}
								$total[$l][$k]="0";
//								$labels=$labels."\"".$i."-".$month[$_GET['month2']]."\",";
								$datasets=$datasets."\"".$total[$l][$k]."\",";
								$result=$result.number_format($total[$l][$k],2).";";
								$result=$result.number_format($total2[$l]/($_GET['month2']-$_GET['month1']+1),2).";";
						}
						else
						{	
							if($i==$_GET['year1'])
							{	
								$total2[$l]=0;
								for($j=$_GET['month1'];$j<=11;$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))	
									{	
										$total[$l][$k]=0;
									}	
									$total[$l][$k]=$total[2][$k+1];
									$datasets=$datasets."\"".($total[$l][$k]/1000000)."\",";
									$total2[$l] = $total2[$l] + $total[$l][$k];
									$result=$result.number_format($total[$l][$k],2).";";
									$k = $k + 1;
								}
								$total[$l][$k]="0";
//								$labels=$labels."\"".$i."-".$month[11]."\",";
								$datasets=$datasets."\"".$total[$l][$k]."\",";
								$result=$result.number_format($total[$l][$k],2).";";
								$result=$result.number_format($total2[$l]/(13-$_GET['month1']),2).";";
								
							}	
							else if($i==$_GET['year2'])
							{	
								$total2[$l]=0;
								for($j=1;$j<=$_GET['month2']-1;$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))
									{	
										$total[$l][$k]=0;
									}	
									$total[$l][$k]=$total[2][$k+1];
									$datasets=$datasets."\"".($total[$l][$k]/1000000)."\",";
									$total2[$l] = $total2[$l] + $total[$l][$k];
									$result=$result.number_format($total[$l][$k],2).";";
									$k = $k + 1;
								}
//								$labels=$labels."\"".$i."-".$month[$_GET['month2']]."\",";
								$total[$l][$k]="0";
								$datasets=$datasets."\"".$total[$l][$k]."\",";
								$result=$result.number_format($total[$l][$k],2).";";
								$result=$result.number_format($total2[$l]/$_GET['month2'],2).";";
							}
							else
							{
								$total2[$l]=0;
								for($j=1;$j<=11;$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))
									{	
										$total[$l][$k]=0;
									}	
									$total[$l][$k]=$total[2][$k+1];
									$datasets=$datasets."\"".($total[$l][$k]/1000000)."\",";
									$total2[$l] = $total2[$l] + $total[$l][$k];
									$result=$result.number_format($total[$l][$k],2).";";
									$k = $k + 1;
								}
//								$labels=$labels."\"".$i."-".$month[11]."\",";
								$total[$l][$k]="0";
								$datasets=$datasets."\"".$total[$l][$k]."\",";
								$result=$result.number_format($total[$l][$k],2).";";
								$result=$result.number_format($total2[$l]/12,2).";";
							}					
						}	
					}
					else if($l==4)
					{
						if($_GET['year2']==$_GET['year1'])
						{
								$total2[$l]=0;
								for($j=$_GET['month1'];$j<=$_GET['month2'];$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))	
									{	
										$total[$l][$k]=0;
									}	
									$query = $this->db->query("select count(distinct id_cust) as total from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'");
									foreach ($query->result() as $row2)
									{			
										if($row2->total==null)
										{
											$result=$result."0;";
											$total[$l][$k] = 0;
											$datasets=$datasets."\"0\",";
										}
										else
										{			
											$result=$result.number_format($row2->total,2).";";
											$total[$l][$k] = $row2->total;
											$datasets=$datasets."\"".$total[$l][$k]."\",";
											$total2[$l] = $total2[$l] + $total[$l][$k];
										}	
									}
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/($_GET['month2']-$_GET['month1']+1),2).";";
						}
						else
						{	
							if($i==$_GET['year1'])
							{	
								$total2[$l]=0;
								for($j=$_GET['month1'];$j<=12;$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))	
									{	
										$total[$l][$k]=0;
									}	
									$query = $this->db->query("select count(distinct id_cust) as total from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'");
									foreach ($query->result() as $row2)
									{			
										if($row2->total==null)
										{
											$result=$result."0;";
											$total[$l][$k] = 0;
											$datasets=$datasets."\"0\",";
										}
										else
										{			
											$result=$result.number_format($row2->total,2).";";
											$total[$l][$k] = $row2->total;
											$datasets=$datasets."\"".$total[$l][$k]."\",";
											$total2[$l] = $total2[$l] + $total[$l][$k];
										}	
									}
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/(13-$_GET['month1']),2).";";
								
							}	
							else if($i==$_GET['year2'])
							{	
								$total2[$l]=0;
								for($j=1;$j<=$_GET['month2'];$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))
									{	
										$total[$l][$k]=0;
									}	
									$query = $this->db->query("select count(distinct id_cust) as total from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'");
									foreach ($query->result() as $row2)
									{			
										if($row2->total==null)
										{
											$result=$result."0;";
											$total[$l][$k] = 0;
											$datasets=$datasets."\"0\",";
										}
										else
										{			
											$result=$result.number_format($row2->total,2).";";
											$total[$l][$k] = $row2->total;
											$datasets=$datasets."\"".$total[$l][$k]."\",";
											$total2[$l] = $total2[$l] + $total[$l][$k];
										}	
									}
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/$_GET['month2'],2).";";
							}
							else
							{
								$total2[$l]=0;
								for($j=1;$j<=12;$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))
									{	
										$total[$l][$k]=0;
									}	
									$query = $this->db->query("select count(distinct id_cust) as total from invoice_sum where sales_value>0 and id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'");
									foreach ($query->result() as $row2)
									{			
										if($row2->total==null)
										{
											$result=$result."0;";
											$total[$l][$k] = 0;
											$datasets=$datasets."\"0\",";
										}
										else
										{			
											$result=$result.number_format($row2->total,2).";";
											$total[$l][$k] = $row2->total;
											$datasets=$datasets."\"".$total[$l][$k]."\",";
											$total2[$l] = $total2[$l] + $total[$l][$k];
										}	
									}
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/12,2).";";
							}					
						}	
					}
					else if($l==5)
					{
						if($_GET['year2']==$_GET['year1'])
						{
								$total2[$l]=0;
								for($j=$_GET['month1'];$j<=$_GET['month2'];$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))	
									{	
										$total[$l][$k]=0;
									}	
									if($total[1][$k]==0)
									{
										$total[$l][$k] = 0;
									}
									else
									{			
										$total[$l][$k]=$total[2][$k]*30/$total[1][$k];
									}	
									$datasets=$datasets."\"".$total[$l][$k]."\",";
									$total2[$l] = $total2[$l] + $total[$l][$k];
									$result=$result.number_format($total[$l][$k],2).";";
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/($_GET['month2']-$_GET['month1']+1),2).";";
						}
						else
						{		
							if($i==$_GET['year1'])
							{	
								$total2[$l]=0;
								for($j=$_GET['month1'];$j<=12;$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))	
									{	
										$total[$l][$k]=0;
									}	
									if($total[1][$k]==0)
									{
										$total[$l][$k] = 0;
									}
									else
									{			
										$total[$l][$k]=$total[2][$k]*30/$total[1][$k];
									}	
									$datasets=$datasets."\"".$total[$l][$k]."\",";
									$total2[$l] = $total2[$l] + $total[$l][$k];
									$result=$result.number_format($total[$l][$k],2).";";
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/(13-$_GET['month1']),2).";";
								
							}	
							else if($i==$_GET['year2'])
							{	
								$total2[$l]=0;
								for($j=1;$j<=$_GET['month2'];$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))
									{	
										$total[$l][$k]=0;
									}	
									if($total[1][$k]==0)
									{
										$total[$l][$k] = 0;
									}
									else
									{			
										$total[$l][$k]=$total[2][$k]*30/$total[1][$k];
									}	
									$datasets=$datasets."\"".$total[$l][$k]."\",";
									$total2[$l] = $total2[$l] + $total[$l][$k];
									$result=$result.number_format($total[$l][$k],2).";";
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/$_GET['month2'],2).";";
							}
							else
							{
								$total2[$l]=0;
								for($j=1;$j<=12;$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))
									{	
										$total[$l][$k]=0;
									}	
									if($total[1][$k]==0)
									{
										$total[$l][$k] = 0;
									}
									else
									{			
										$total[$l][$k]=$total[2][$k]*30/$total[1][$k];
									}	
									$datasets=$datasets."\"".$total[$l][$k]."\",";
									$total2[$l] = $total2[$l] + $total[$l][$k];
									$result=$result.number_format($total[$l][$k],2).";";
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/12,2).";";
							}					
						}	
					}
					else if($l==6)
					{
						if($_GET['year2']==$_GET['year1'])
						{
								$total2[$l]=0;
								for($j=$_GET['month1'];$j<=$_GET['month2'];$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))	
									{	
										$total[$l][$k]=0;
									}	
									$query = $this->db->query("select sum(price*qty) as total from stock where id_dist in (".$value.") and id_product in (".$_GET['id_product'].") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'");
									foreach ($query->result() as $row2)
									{			
										if($row2->total==null)
										{
											$result=$result."0;";
											$total[$l][$k] = 0;
											$datasets=$datasets."\"0\",";
										}
										else
										{			
											$result=$result.number_format($row2->total,2).";";
											$total[$l][$k] = $row2->total;
											$datasets=$datasets."\"".($total[$l][$k]/1000000)."\",";
											$total2[$l] = $total2[$l] + $total[$l][$k];
										}	
									}
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/($_GET['month2']-$_GET['month1']+1),2).";";
						}
						else
						{	
							if($i==$_GET['year1'])
							{	
								$total2[$l]=0;
								for($j=$_GET['month1'];$j<=12;$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))	
									{	
										$total[$l][$k]=0;
									}	
									$query = $this->db->query("select sum(price*qty) as total from stock where id_dist in (".$value.") and id_product in (".$_GET['id_product'].") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'");
									foreach ($query->result() as $row2)
									{			
										if($row2->total==null)
										{
											$result=$result."0;";
											$total[$l][$k] = 0;
											$datasets=$datasets."\"0\",";
										}
										else
										{			
											$result=$result.number_format($row2->total,2).";";
											$total[$l][$k] = $row2->total;
											$datasets=$datasets."\"".($total[$l][$k]/1000000)."\",";
											$total2[$l] = $total2[$l] + $total[$l][$k];
										}	
									}
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/(13-$_GET['month1']),2).";";
								
							}	
							else if($i==$_GET['year2'])
							{	
								$total2[$l]=0;
								for($j=1;$j<=$_GET['month2'];$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))
									{	
										$total[$l][$k]=0;
									}	
									$query = $this->db->query("select sum(price*qty) as total from stock where id_dist in (".$value.") and id_product in (".$_GET['id_product'].") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'");
									foreach ($query->result() as $row2)
									{			
										if($row2->total==null)
										{
											$result=$result."0;";
											$total[$l][$k] = 0;
											$datasets=$datasets."\"0\",";
										}
										else
										{			
											$result=$result.number_format($row2->total,2).";";
											$total[$l][$k] = $row2->total;
											$datasets=$datasets."\"".($total[$l][$k]/1000000)."\",";
											$total2[$l] = $total2[$l] + $total[$l][$k];
										}	
									}
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/$_GET['month2'],2).";";
							}
							else
							{
								$total2[$l]=0;
								for($j=1;$j<=12;$j++)
								{
//									$labels=$labels."\"".$i."-".$month[$j-1]."\",";
	//								if(!isset($total[$l][$k]))
									{	
										$total[$l][$k]=0;
									}	
									$query = $this->db->query("select sum(price*qty) as total from stock where id_dist in (".$value.") and id_product in (".$_GET['id_product'].") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'");
									foreach ($query->result() as $row2)
									{			
										if($row2->total==null)
										{
											$result=$result."0;";
											$total[$l][$k] = 0;
											$datasets=$datasets."\"0\",";
										}
										else
										{			
											$result=$result.number_format($row2->total,2).";";
											$total[$l][$k] = $row2->total;
											$datasets=$datasets."\"".($total[$l][$k]/1000000)."\",";
											$total2[$l] = $total2[$l] + $total[$l][$k];
										}	
									}
									$k = $k + 1;
								}
								$result=$result.number_format($total2[$l]/12,2).";";
							}					
						}	
					}
				}
				$datasets=rtrim($datasets,",");
				$datasets=$datasets."]";
				$datasets=$datasets."},";
//				$result=$result."--;";
			}

			$labels=rtrim($labels,",");
			$datasets=rtrim($datasets,",");
			$labels=$labels."],";	
			$datasets=$datasets."]}";
			$graph = $graph."|".$labels.$datasets;
		}	
			/*for($l=0;$l<$k;$l++)
			{
				$result=$result.number_format($total[$l],2).";";
			}*/
		$result=rtrim($result, ";");
		$result=str_replace(".00","",$result);
		$result=$result.$graph;

		echo $result;
	}	

}
