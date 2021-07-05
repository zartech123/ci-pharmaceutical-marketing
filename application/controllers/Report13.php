<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report13 extends CI_Controller {

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
		$this->load->view('report13');
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
					$query = $this->db->query("select ".$sum."/".$divider." as average from invoice_sum where id_product in (".$_GET['id_product'].") and id_cust in (".$id_cust.") and substr(period,1,4)='".$j."' and period<='".$j.str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."' and period>='".$j.str_pad($_GET['month1'],2,"0",STR_PAD_LEFT)."'");
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
		$total3 = 0;
		$total4 = array();
		$total5 = array();
		$total6 = array();
		$total7 = array();
		$total8 = array();
		$total9 = array();

		$distributor = array();
		$query2 = $this->db->query("SELECT id_dist, code from distributor order by code");
		$i = 0;
		foreach ($query2->result() as $row2)
		{	
			$distributor[$row2->id_dist] = $row2->code;
			$i = $i + 1;
		}
		$result="<table border=1 class='table table-sm table-bordered table-striped' style='font-size:12px'>";
		$total = array();
		$total2 = array();
		$id_cust2 = array();
		
		$id_channel = explode(",", $_GET['id_channel']);
				
		$id_dist = explode(",", $_GET['id_dist']);

		$id_custarray = array();

		$channel = array("1 HOSPITAL", "2 PHARMACY", "3 DRUGSTORE", "4 INSTITUTION", "5 MTC", "6 PHARMA CHAIN", "7 GT & OTHERS", "8 PBF","TOTAL");

		$result=$result."<thead><tr>";
		$result=$result."<th scope='col' style='text-align:center' colspan=".(2+sizeof($id_dist)).">TOTAL COVERED OUTLET</td>";
		$i = 0;
		foreach ($id_dist as &$value2)
		{		
			if($i<sizeof($id_dist)-1)
			{	
				$result=$result."<th scope='col' style='text-align:center;background-color:#5bc0de;color:white' colspan=".(sizeof($id_dist)-$i).">OVERLAP to ".$distributor[$value2]."</th>";
				$result=$result."<th scope='col' style='text-align:center' colspan=".(sizeof($id_dist)-($i+1)).">% OVERLAP to ".$distributor[$value2]."</th>";
				$result=$result."<th scope='col' style='text-align:center' colspan=".(sizeof($id_dist)-($i+1)).">DEDICATED</th>";
			}	
			$i = $i + 1;
		}	
		$result=$result."<th scope='col' style='text-align:center;background-color:green;color:white' colspan=".(sizeof($id_dist)-1).">DEDICATED</th>";
		$result=$result."</tr>";
		$result=$result."<tr>";
		$result=$result."<th scope='col' style='text-align:center'>Channel</th>";
		$result=$result."<th scope='col' style='text-align:center'>Universal</th>";
		foreach ($id_dist as &$value2)
		{		
			$result=$result."<th scope='col' style='text-align:center'>".$distributor[$value2]."</th>";
		}
		$j = 0;
		foreach ($id_dist as &$value3)
		{	
			if($j<sizeof($id_dist)-1)
			{	
				$i = 0;
				foreach ($id_dist as &$value2)
				{		
					if($i>=$j)
					{	
						$result=$result."<th scope='col' style='text-align:center;background-color:#5bc0de;color:white'>".$distributor[$value2]."</th>";
					}	
					$i = $i + 1;
				}
				$i = 0;
				foreach ($id_dist as &$value2)
				{		
					if($i>$j)
					{	
						$result=$result."<th scope='col' style='text-align:center;'>".$distributor[$value2]."</th>";
					}	
					$i = $i + 1;
				}
				$i = 0;
				foreach ($id_dist as &$value2)
				{		
					if($i>$j)
					{	
						$result=$result."<th scope='col' style='text-align:center;'>".$distributor[$value2]."</th>";
					}	
					$i = $i + 1;
				}
			}	
			$j = $j + 1;
		}	
		foreach ($id_dist as &$value2)
		{		
			if($value2!="2")
			{
				$result=$result."<th scope='col' style='text-align:center;background-color:green;color:white'>".$distributor[$value2]."</th>";
			}	
		}
		$result=$result."</tr></thead><tbody>";
		foreach ($id_channel as &$value)
		{
			$result=$result."<tr>";
			$result=$result."<td>".$channel[$value-1]."</td>";
			$query = $this->db->query("select outlet as total from universal where big in (".$value.")");
			foreach ($query->result() as $row2)
			{			
				if($row2->total==null)
				{
					$result=$result."<td>0</td>";
				}
				else
				{			
					$result=$result."<td>".number_format($row2->total,0)."</td>";
				}	
				$total3 = $total3 + $row2->total;
			}
			foreach ($id_dist as &$value2)
			{		
				$id_cust="";
				if($value==6)
				{
					if($value2!=2)
					{	
						$query = $this->db->query("select distinct id_cust_profile from customer a, channel b where is_pharmachain=1 and id_cust_profile<>0 and a.id_channel=b.id_channel and a.id_dist='".$value2."'");
					}
					else
					{
						$query = $this->db->query("select distinct id_cust_profile from customer a, channel b where is_pharmachain=1 and id_cust_profile<>0 and a.id_channel=b.id_channel and a.id_dist='".$value2."' and group_customer not in ('DAYA MUDA AGUNG','KIMIA FARMA TRADING','KIMIA FARMA DISTRIBU','TRI SAPTAJAYA','ENSEVAL PUTERA')");
					}						
				}
				else
				{	
					if($value2!=2)
					{	
						$query = $this->db->query("select distinct id_cust_profile from customer a, channel b where is_pharmachain=0 and id_cust_profile<>0 and a.id_channel=b.id_channel and a.id_dist='".$value2."' and big='".$value."'");
					}
					else
					{
						$query = $this->db->query("select distinct id_cust_profile from customer a, channel b where is_pharmachain=0 and id_cust_profile<>0 and a.id_channel=b.id_channel and a.id_dist='".$value2."' and big='".$value."' and group_customer not in ('DAYA MUDA AGUNG','KIMIA FARMA TRADING','KIMIA FARMA DISTRIBU','TRI SAPTAJAYA','ENSEVAL PUTERA')");
					}						
				}	
				foreach ($query->result() as $row2)
				{
					$id_cust=$id_cust."'".$row2->id_cust_profile."',";				
				}
				$id_cust=$id_cust."''";
				$id_cust2[$value2][$value]=$id_cust;

				if($value==6)
				{
					if($value2!=2)
					{	
						$query = $this->db->query("select count(distinct id_cust) as total from customer a, channel b where is_pharmachain=1 and a.id_channel=b.id_channel and a.id_dist='".$value2."'");
					}
					else
					{
						$query = $this->db->query("select count(distinct id_cust) as total from customer a, channel b where is_pharmachain=1 and a.id_channel=b.id_channel and a.id_dist='".$value2."' and group_customer not in ('DAYA MUDA AGUNG','KIMIA FARMA TRADING','KIMIA FARMA DISTRIBU','TRI SAPTAJAYA','ENSEVAL PUTERA')");
					}						
				}
				else
				{
					if($value2!=2)
					{	
						$query = $this->db->query("select count(distinct id_cust) as total from customer a, channel b where is_pharmachain=0 and a.id_channel=b.id_channel and a.id_dist='".$value2."' and big='".$value."'");
					}
					else
					{
						$query = $this->db->query("select count(distinct id_cust) as total from customer a, channel b where is_pharmachain=0 and a.id_channel=b.id_channel and a.id_dist='".$value2."' and big='".$value."' and group_customer not in ('DAYA MUDA AGUNG','KIMIA FARMA TRADING','KIMIA FARMA DISTRIBU','TRI SAPTAJAYA','ENSEVAL PUTERA')");
					}						
				}					
				if(!isset($total[$value2][$value]))
				{
					$total[$value2][$value]=0;
				}
				foreach ($query->result() as $row2)
				{			
					if($row2->total==null)
					{
						$result=$result."<td style='text-align:right'>0</td>";
					}
					else
					{			
						$result=$result."<td style='text-align:right'>".number_format($row2->total,0)."</td>";
						$total[$value2][$value]=$row2->total;
					}	
				}
				if(!isset($total4[$value2]))
				{
					$total4[$value2]=0;
				}					
				$total4[$value2] = $total4[$value2] + $row2->total;
			}	
			$j = 0;
			foreach ($id_dist as &$value3)
			{	
				if($j<sizeof($id_dist)-1)
				{	
					$i = 0;
					foreach ($id_dist as &$value2)
					{	
						if(!isset($total5[$value3][$value2]))
						{
							$total5[$value3][$value2]=0;
						}					
						if($i==$j)
						{
							$result=$result."<td style='text-align:right;background-color:#5bc0de;color:white'>".number_format($total[$value2][$value],0)."</td>";
							$total5[$value3][$value2] = $total5[$value3][$value2] + $total[$value2][$value];
							$total2[$value2][$value]=$total[$value2][$value];
						}					
						else if($i>$j)
						{
							if($value==6)
							{
								$query = $this->db->query("select count(distinct id_cust_profile) as total from customer a, channel b where is_pharmachain=1 and id_cust_profile<>0 and a.id_channel=b.id_channel and a.id_dist='".$value2."' and id_cust_profile in (".$id_cust2[$value2-$i+$j][$value].")");
							}
							else
							{
								$query = $this->db->query("select count(distinct id_cust_profile) as total from customer a, channel b where is_pharmachain=0 and id_cust_profile<>0 and a.id_channel=b.id_channel and a.id_dist='".$value2."' and big='".$value."' and id_cust_profile in (".$id_cust2[$value2-$i+$j][$value].")");
							}								
							foreach ($query->result() as $row2)
							{			
								if($row2->total==null)
								{
									$result=$result."<td style='text-align:right;background-color:#5bc0de;color:white'>0</td>";
									$total2[$value2][$value]=0;
								}
								else
								{			
									$result=$result."<td style='text-align:right;background-color:#5bc0de;color:white'>".number_format($row2->total,0)."</td>";
									$total2[$value2][$value]=$row2->total;
								}	
							}
							$total5[$value3][$value2] = $total5[$value3][$value2] + $row2->total;
						}					
						$i = $i + 1;			
					}	
					$i = 0;
					foreach ($id_dist as &$value2)
					{	
						if(!isset($total6[$value3][$value2]))
						{
							$total6[$value3][$value2]=0;
						}					
						if($i>$j)
						{	
							if(($total2[$value2][$value]+$total[$value2][$value])==0)
							{
								$result=$result."<td style='text-align:right'>0 %</td>";
								$total6[$value3][$value2] = 0;
							}						
							else
							{	
								$result=$result."<td style='text-align:right'>".number_format(($total2[$value2][$value]*100/($total2[$value2][$value]+$total[$value2][$value])),0)." %</td>";					
								$total6[$value3][$value2] = $total5[$value3][$value2]*100/($total5[$value3][$value2]+$total4[$value2]);
							}	
						}					
						$i = $i + 1;			
					}	
					$i = 0;
					foreach ($id_dist as &$value2)
					{	
						if(!isset($total7[$value3][$value2]))
						{
							$total7[$value3][$value2]=0;
						}					
						if(!isset($total9[$value2]))
						{
							$total9[$value2]=0;
						}					
						if($i>$j)
						{	
							$result=$result."<td style='text-align:right'>".number_format($total[$value2][$value]-$total2[$value2][$value],0)."</td>";					
							$total7[$value3][$value2]=$total7[$value3][$value2]+ ($total[$value2][$value]-$total2[$value2][$value]);
							$total8[$value2][$value]=$total[$value2][$value]-$total2[$value2][$value];
							$id_cust="";
							if($value==6)
							{
								$query = $this->db->query("select distinct id_cust_profile from customer a, channel b where is_pharmachain=1 and id_cust_profile<>0 and a.id_channel=b.id_channel and a.id_dist='".$value2."' and id_cust_profile not in (select distinct id_cust_profile from customer a, channel b where a.id_channel=b.id_channel and a.id_dist='".$id_dist[$j]."')");
							}
							else
							{
								$query = $this->db->query("select distinct id_cust_profile from customer a, channel b where is_pharmachain=0 and id_cust_profile<>0 and a.id_channel=b.id_channel and a.id_dist='".$value2."' and big='".$value."' and id_cust_profile not in (select distinct id_cust_profile from customer a, channel b where a.id_channel=b.id_channel and a.id_dist='".$id_dist[$j]."' and big='".$value."')");
							}								
							foreach ($query->result() as $row2)
							{
								$id_cust=$id_cust."'".$row2->id_cust_profile."',";				
							}
							$id_cust=$id_cust."''";
							$id_cust2[$value2][$value]=$id_cust;
							$total[$value2][$value]=$total[$value2][$value]-$total2[$value2][$value];
						}					
						$i = $i + 1;			
					}	
					
				}	
				$j = $j + 1;
			}	
			foreach ($id_dist as &$value2)
			{
				if($value2!="2")
				{
					$result=$result."<td style='text-align:right;background-color:green;color:white'>".number_format($total8[$value2][$value],0)."</td>";					
				}							
			}
			$result=$result."</tr>";
		}	
		$result=$result."<tr>";
		$result=$result."<th scope='col' style='text-align:center'>TOTAL</th>";
		$result=$result."<th scope='col' style='text-align:right'>".number_format($total3,0)."</th>";
		foreach ($id_dist as &$value2)
		{		
			$result=$result."<th scope='col' style='text-align:right;'>".number_format($total4[$value2],0)."</th>";
		}
		$j = 0;
		foreach ($id_dist as &$value3)
		{	
			if($j<sizeof($id_dist)-1)
			{	
				$i = 0;
				foreach ($id_dist as &$value2)
				{		
					if($i>=$j)
					{	
						$result=$result."<th scope='col' style='text-align:right;background-color:#5bc0de;color:white'>".number_format($total5[$value3][$value2],0)."</th>";
					}	
					$i = $i + 1;
				}
				$i = 0;
				foreach ($id_dist as &$value2)
				{		
					if($i>$j)
					{	
						$result=$result."<th scope='col' style='text-align:right;'>".number_format($total6[$value3][$value2],0)." %</th>";
					}	
					$i = $i + 1;
				}
				$i = 0;
				foreach ($id_dist as &$value2)
				{		
					if($i>$j)
					{	
						$result=$result."<th scope='col' style='text-align:right;'>".number_format($total7[$value3][$value2],0)."</th>";
						$total9[$value2] = $total7[$value3][$value2];
					}	
					$i = $i + 1;
				}
			}	
			$j = $j + 1;
		}	
		foreach ($id_dist as &$value2)
		{
			if($i>$j)
			{	
				$result=$result."<th scope='col' style='text-align:right;background-color:green;color:white'>".number_format($total9[$value2],0)."</th>";
			}	
			$i = $i + 1;
		}
		$result=$result."</tr>";
		$result=$result."</tbody>";
		$result=$result."</table>";
//		echo $result;

		$labels2="{\"labels\": [";	
		$datasets2="\"datasets\": [";
		
		$datasets2=$datasets2."{";
		$datasets2=$datasets2."\"label\":\"\",";
		$datasets2=$datasets2."\"backgroundColor\": [\"#d11141\",\"#00b159\",\"#0275d8\",\"#f37735\",\"#888888\"],";
		$datasets2=$datasets2."\"borderColor\": [\"#d11141\",\"#00b159\",\"#0275d8\",\"#f37735\",\"#888888\"],";
		$datasets2=$datasets2."\"borderWidth\": 0,";

		$datasets2=$datasets2."\"data\": [";


		$labels3="{\"labels\": [";	
		$datasets3="\"datasets\": [";
		
		$datasets3=$datasets3."{";
		$datasets3=$datasets3."\"label\":\"\",";
		$datasets3=$datasets3."\"backgroundColor\": [\"#d11141\",\"#00b159\",\"#0275d8\",\"#f37735\",\"#888888\"],";
		$datasets3=$datasets3."\"borderColor\": [\"#d11141\",\"#00b159\",\"#0275d8\",\"#f37735\",\"#888888\"],";
		$datasets3=$datasets3."\"borderWidth\": 0,";

		$datasets3=$datasets3."\"data\": [";

		$labels="{\"labels\": [";	
		$datasets="\"datasets\": [";
		
		$datasets=$datasets."{";
		$datasets=$datasets."\"label\":\"\",";
		$datasets=$datasets."\"backgroundColor\": [\"#d11141\",\"#00b159\",\"#0275d8\",\"#f37735\",\"#888888\"],";
		$datasets=$datasets."\"borderColor\": [\"#d11141\",\"#00b159\",\"#0275d8\",\"#f37735\",\"#888888\"],";
		$datasets=$datasets."\"borderWidth\": 0,";

		$datasets=$datasets."\"data\": [";

		$j = 0;
		foreach ($id_dist as &$value2)
		{		
			$labels=$labels."\"".$distributor[$value2]."\",";
			$labels2=$labels2."\"".$distributor[$value2]."\",";
			$labels3=$labels3."\"".$distributor[$value2]."\",";
			$datasets=$datasets."\"".$total4[$value2]."\",";
			$datasets2=$datasets2."\"".$total5[$id_dist[0]][$value2]."\",";
			if($j<sizeof($id_dist)-1)
			{	
				$datasets3=$datasets3."\"".$total5[$value2][$value2]."\",";
			}	
			else
			{
				$datasets3=$datasets3."\"".$total7[$id_dist[$j-1]][$value2]."\",";
			}				
			$j = $j + 1;
		}	


		$datasets=rtrim($datasets,",");
		$datasets=$datasets."]";
		$datasets=$datasets."},";

		$datasets2=rtrim($datasets2,",");
		$datasets2=$datasets2."]";
		$datasets2=$datasets2."},";

		$datasets3=rtrim($datasets3,",");
		$datasets3=$datasets3."]";
		$datasets3=$datasets3."},";

		//$colour = array('#d11141','#00b159','#00aedb','#f37735','#ffc425','#e43b22');




//		$datasets=$datasets."\"data\": [\"".$data[0]."\",\"".$data[1]."\",\"".$data[2]."\",\"".$data[3]."\",\"".$data[4]."\"]}";

		$labels2=rtrim($labels2,",");
		$datasets2=rtrim($datasets2,",");
		$labels2=$labels2."],";	
		$datasets2=$datasets2."]}";

		$labels3=rtrim($labels3,",");
		$datasets3=rtrim($datasets3,",");
		$labels3=$labels3."],";	
		$datasets3=$datasets3."]}";

		$labels=rtrim($labels,",");
		$datasets=rtrim($datasets,",");
		$labels=$labels."],";	
		$datasets=$datasets."]}";
		echo $result."|".$labels.$datasets."|".$labels2.$datasets2."|".$labels3.$datasets3;



	}	

}
