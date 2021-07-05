<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report11 extends CI_Controller {

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
		$this->load->view('report11',(array)$output);
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


	public function getTotal()
	{
		$command = "/usr/local/bin/php /home/crmtaisho/public_html/application/controllers/ReportExcel.php ".$_GET['id_product']." ".$_GET['id_channel']." ".$_GET['id_dist']." ".$_GET['year1']." ".$_GET['year2']." ".$_GET['month1']." ".$_GET['month2']." > /dev/null 2>&1 & echo $!";

		exec($command, $op);
		
		echo "";
	}

	public function getTotal2()
	{
		$command = "/usr/local/bin/php /home/crmtaisho/public_html/application/controllers/ReportExcelSummary.php ".$_GET['id_product']." ".$_GET['id_channel']." ".$_GET['id_dist']." ".$_GET['year1']." ".$_GET['year2']." ".$_GET['month1']." ".$_GET['month2']." > /dev/null 2>&1 & echo $!";

		exec($command, $op);
		
		echo "";
	}

	public function getTotal3()
	{
		$result="<table border=1>";
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

//		$id_dist = explode(",", $_GET['id_dist']);

		$sum="sum(sales_value+retur_value)";
		
		$id_group="";
		$big="";
		
		$channel = array("1 HOSPITAL", "2 PHARMACY", "3 DRUGSTORE", "4 INSTITUTION", "5 MTC", "6 PHARMA CHAIN", "7 GT & OTHERS", "8 PBF","TOTAL");
		
		$result = $result."<tr><td>Channel</td><td>Product</td>";
		for($i=$_GET['year1'];$i<=$_GET['year2'];$i++)
		{	
			$result = $result."<td>AVE ".$i."</td>";
		}	

		$k = 0;
		for($i=$_GET['year1'];$i<=$_GET['year2'];$i++)
		{	
			$period[$k] = $i;
			$k = $k + 1;
			if($k>1)
			{
				$result = $result."<td>".$period[$k-1]." vs ".$period[$k-2]." (%)</td>";
			}				
		}	

		for($i=$_GET['year1'];$i<=$_GET['year2'];$i++)
		{	
			$result = $result."<td>Active Transaction ".$i."</td>";
		}	

		$result = $result."<td>No Transaction Outlet (L3M)</td>";
		for($i=$_GET['year1'];$i<=$_GET['year2'];$i++)
		{	
			$result = $result."<td>AVE ".$i."</td>";
		}	
		$k = 0;
		for($i=$_GET['year1'];$i<=$_GET['year2'];$i++)
		{	
			$period[$k] = $i;
			$k = $k + 1;
			if($k>1)
			{
				$result = $result."<td>".$period[$k-1]." vs ".$period[$k-2]." (%)</td>";
			}				
		}	
		$k = 0;
		for($i=$_GET['year1'];$i<=$_GET['year2'];$i++)
		{	
			$period[$k] = $i;
			$k = $k + 1;
			if($k>1)
			{
				$result = $result."<td>Gap ".$period[$k-1]." vs ".$period[$k-2]."</td>";
			}				
		}	

		$result = $result."<td>No Transaction Outlet (L6M)</td>";
		for($i=$_GET['year1'];$i<=$_GET['year2'];$i++)
		{	
			$result = $result."<td>AVE ".$i."</td>";
		}	
		$k = 0;
		for($i=$_GET['year1'];$i<=$_GET['year2'];$i++)
		{	
			$period[$k] = $i;
			$k = $k + 1;
			if($k>1)
			{
				$result = $result."<td>".$period[$k-1]." vs ".$period[$k-2]." (%)</td>";
			}				
		}	
		$k = 0;
		for($i=$_GET['year1'];$i<=$_GET['year2'];$i++)
		{	
			$period[$k] = $i;
			$k = $k + 1;
			if($k>1)
			{
				$result = $result."<td>Gap ".$period[$k-1]." vs ".$period[$k-2]."</td>";
			}				
		}	

		$result = $result."<td>No Transaction Outlet </td>";
		for($i=$_GET['year1'];$i<=$_GET['year2'];$i++)
		{	
			$result = $result."<td>AVE ".$i."</td>";
		}	
		$k = 0;
		for($i=$_GET['year1'];$i<=$_GET['year2'];$i++)
		{	
			$period[$k] = $i;
			$k = $k + 1;
			if($k>1)
			{
				$result = $result."<td>".$period[$k-1]." vs ".$period[$k-2]." (%)</td>";
			}				
		}	
		$k = 0;
		for($i=$_GET['year1'];$i<=$_GET['year2'];$i++)
		{	
			$period[$k] = $i;
			$k = $k + 1;
			if($k>1)
			{
				$result = $result."<td>Gap ".$period[$k-1]." vs ".$period[$k-2]."</td>";
			}				
		}	

		$data = array();
		$data2 = array();
		$data3 = array();
		$datal3m = array();
		$data2l3m = array();
		$data3l3m = array();
		$datal6m = array();
		$data2l6m = array();
		$data3l6m = array();
		$datal12m = array();
		$data2l12m = array();
		$data3l12m = array();
		$i = 0;

			$id_cust="";
			$query3 = $this->db->query("select id_cust from customer a, channel b where a.id_channel=b.id_channel and big in (".$_GET['id_channel'].") and a.id_dist in (2) and id_cust not in (select id_cust from invoice_sum where id_product in (".$_GET['id_product'].") and period between '201701' and '".$_GET['year2'].str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."')");
			foreach ($query3->result() as $row3)
			{
				$id_cust=$id_cust."'".$row3->id_cust."',";				
			}
			$id_cust=$id_cust."''";
			
			$query3 = $this->db->query("select sum(sales_value+retur_value) as total, count(distinct a.id_cust) as jumlah, substring(period,1,4) as period, big, d.id_group, e.name as group_name from invoice_sum a, customer b, channel c, product d, product_group e where e.id_group=d.id_group and a.id_product=d.id_product and b.id_channel=c.id_channel and a.id_cust=b.id_cust and a.id_cust in (".$id_cust.") and period between '".$_GET['year1'].str_pad(1,2,"0",STR_PAD_LEFT)."' and '".$_GET['year2'].str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."' group by d.id_group, big, substring(period,1,4)");
			foreach ($query3->result() as $row3)
			{
				if($row3->period==$_GET['year1'])
				{
					$divider = 12;
				}						
				else if($row3->period==$_GET['year2'])
				{
					$divider =$_GET['month2'];
				}
				else
				{
					$divider = 12;
				}								
				$datal3m[$row3->id_group][$row3->big][$row3->period]=$row3->total/$divider;
				if(!isset($data2l3m[$row3->id_group][$row3->big]))
				{
					$data2l3m[$row3->id_group][$row3->big] = 0;
				}					
				$data2l3m[$row3->id_group][$row3->big]=$data2l3m[$row3->id_group][$row3->big] + $row3->jumlah;
			}
			

			$id_cust="";
			$query3 = $this->db->query("select id_cust from customer a, channel b where a.id_channel=b.id_channel and big in (".$_GET['id_channel'].") and a.id_dist in (2) and id_cust not in (select id_cust from invoice_sum where id_product in (".$_GET['id_product'].") and period between '201701' and '".$_GET['year2'].str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."')");
			foreach ($query3->result() as $row3)
			{
				$id_cust=$id_cust."'".$row3->id_cust."',";				
			}
			$id_cust=$id_cust."''";
			
			$query3 = $this->db->query("select sum(sales_value+retur_value) as total, count(distinct a.id_cust) as jumlah, substring(period,1,4) as period, big, d.id_group, e.name as group_name from invoice_sum a, customer b, channel c, product d, product_group e where e.id_group=d.id_group and a.id_product=d.id_product and b.id_channel=c.id_channel and a.id_cust=b.id_cust and a.id_cust in (".$id_cust.") and period between '".$_GET['year1'].str_pad(1,2,"0",STR_PAD_LEFT)."' and '".$_GET['year2'].str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."' group by d.id_group, big, substring(period,1,4)");
			foreach ($query3->result() as $row3)
			{
				if($row3->period==$_GET['year1'])
				{
					$divider = 12;
				}						
				else if($row3->period==$_GET['year2'])
				{
					$divider =$_GET['month2'];
				}
				else
				{
					$divider = 12;
				}								
				$datal6m[$row3->id_group][$row3->big][$row3->period]=$row3->total/$divider;
				if(!isset($data2l6m[$row3->id_group][$row3->big]))
				{
					$data2l6m[$row3->id_group][$row3->big] = 0;
				}					
				$data2l6m[$row3->id_group][$row3->big]=$data2l6m[$row3->id_group][$row3->big] + $row3->jumlah;
			}


			$id_cust="";
			$query3 = $this->db->query("select id_cust from customer a, channel b where a.id_channel=b.id_channel and big in (".$_GET['id_channel'].") and a.id_dist in (2) and id_cust not in (select id_cust from invoice_sum where id_product in (".$_GET['id_product'].") and period between '201701' and '".$_GET['year2'].str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."')");
			foreach ($query3->result() as $row3)
			{
				$id_cust=$id_cust."'".$row3->id_cust."',";				
			}
			$id_cust=$id_cust."''";
			
			$query3 = $this->db->query("select sum(sales_value+retur_value) as total, count(distinct a.id_cust) as jumlah, substring(period,1,4) as period, big, d.id_group, e.name as group_name from invoice_sum a, customer b, channel c, product d, product_group e where e.id_group=d.id_group and a.id_product=d.id_product and b.id_channel=c.id_channel and a.id_cust=b.id_cust and a.id_cust in (".$id_cust.") and period between '".$_GET['year1'].str_pad(1,2,"0",STR_PAD_LEFT)."' and '".$_GET['year2'].str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."' group by d.id_group, big, substring(period,1,4)");
			foreach ($query3->result() as $row3)
			{
				if($row3->period==$_GET['year1'])
				{
					$divider = 12;
				}						
				else if($row3->period==$_GET['year2'])
				{
					$divider =$_GET['month2'];
				}
				else
				{
					$divider = 12;
				}								
				$datal12m[$row3->id_group][$row3->big][$row3->period]=$row3->total/$divider;
				if(!isset($data2l12m[$row3->id_group][$row3->big]))
				{
					$data2l12m[$row3->id_group][$row3->big] = 0;
				}					
				$data2l12m[$row3->id_group][$row3->big]=$data2l12m[$row3->id_group][$row3->big] + $row3->jumlah;
			}

//		{
//			$query3 = $this->db->query("select distinct b.id_cust, id_cust2, b.name, big, address, c.name as branch_name from channel a, customer b, branch c, customer_redistribution d where b.id_cust=d.id_cust and d.id_branch=c.id_branch and a.id_channel=b.id_channel and a.id_dist=d.id_dist and d.id_dist in (".$_GET['id_dist'].") and a.big in (".$_GET['id_channel'].") order by id_cust2 limit 1000");
//		}			
//		else
//		{	
//			$query3 = $this->db->query("select distinct id_cust, id_cust2, b.name, big, address, c.name as branch_name from channel a, customer b, branch c where b.id_branch=c.id_branch and a.id_channel=b.id_channel and a.id_dist=b.id_dist and a.id_dist in (2) and a.big in (".$_GET['id_channel'].") order by id_cust2 limit 1000");
		if($_GET['id_dist']=="0")
		{	
			$query3 = $this->db->query("select sum(sales_value+retur_value) as total, count(distinct a.id_cust) as jumlah, substring(period,1,4) as period, big, d.id_group, e.name as group_name from invoice_sum a, customer b, channel c, product d, product_group e where e.id_group=d.id_group and a.id_product=d.id_product and b.id_channel=c.id_channel and a.id_cust=b.id_cust and a.id_product in (".$_GET['id_product'].") and b.id_dist in (2) and c.big in (".$_GET['id_channel'].") and period between '".$_GET['year1'].str_pad(1,2,"0",STR_PAD_LEFT)."' and '".$_GET['year2'].str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."' group by d.id_group, big, substring(period,1,4)");
		}
		else
		{
			$query3 = $this->db->query("select sum(sales_value+retur_value) as total, count(distinct a.id_cust) as jumlah, substring(period,1,4) as period, big, d.id_group, e.name as group_name from invoice_sum a, customer b, channel c, product d, product_group e, customer_redistribution f where f.id_cust=b.id_cust and e.id_group=d.id_group and a.id_product=d.id_product and b.id_channel=c.id_channel and a.id_cust=b.id_cust and a.id_product in (".$_GET['id_product'].") and f.id_dist in (".$_GET['id_dist'].") and c.big in (".$_GET['id_channel'].") and period between '".$_GET['year1'].str_pad(1,2,"0",STR_PAD_LEFT)."' and '".$_GET['year2'].str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."' group by d.id_group, big, substring(period,1,4)");
		}			
//		}	
			foreach ($query3->result() as $row3)
			{
				$data[$row3->id_group][$row3->big][$row3->period]=$row3->total;
				$data2[$row3->id_group][$row3->big][$row3->period]=$row3->jumlah;

				if($big=="")
				{
					$id_group=$row3->id_group;
					$big=$row3->big;
					$result = $result."<tr><td>".$channel[$row3->big]."</td><td>".$row3->group_name."</td>";
				}
				if($big==$row3->big && $id_group==$row3->id_group)
				{
				}
				else
				{
					for($j=0;$j<$k;$j++)
					{
						$var = $period[$j];
						if(isset($data[$id_group][$big][$var]))
						{	
							if($_GET['year1']==$_GET['year2'])
							{
								$divider = $_GET['month2'];
							}								
							else
							{
								if($period[$j]==$_GET['year1'])
								{
									$divider=12;
								}									
								else if($period[$j]==$_GET['year2'])
								{
									$divider=$_GET['month2'];
								}
								else
								{
									$divider=12;
								}									
							}								
							
							$result=$result."<td>".number_format($data[$id_group][$big][$var]/$divider,0)."</td>";
						}
						else
						{
							$result=$result."<td>0</td>";
						}						
					}		
					if($k>1)
					{	
						for($j=$k-1;$j>=1;$j--)
						{
							$var = $period[$j];
							$var2 = $period[$j-1];
							if($var==$_GET['year1'])
							{
								$divider1 = 12;
							}						
							else if($var==$_GET['year2'])
							{
								$divider1 =$_GET['month2'];
							}
							else
							{
								$divider1 = 12;
							}								
							if($var2==$_GET['year1'])
							{
								$divider2 = 12;
							}						
							else if($var2==$_GET['year2'])
							{
								$divider2 =$_GET['month2'];
							}
							else
							{
								$divider2 = 12;
							}								
							if(!isset($data[$id_group][$big][$var]))
							{	
								$result=$result."<td>0</td>";
							}
							else if(!isset($data[$id_group][$big][$var2]))
							{	
								$result=$result."<td>0</td>";
							}
							else if($data[$id_group][$big][$var]==0 || $data[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td>0</td>";
							}								
							else
							{
								$result=$result."<td>".number_format(($data[$id_group][$big][$var])*100/($data[$id_group][$big][$var2]),2)."</td>";
							}								
						}						
					}	
					for($j=0;$j<$k;$j++)
					{
						$var = $period[$j];
						if(isset($data2[$id_group][$big][$var]))
						{	
							$result=$result."<td>".number_format($data2[$id_group][$big][$var],0)."</td>";
						}
						else
						{
							$result=$result."<td>0</td>";
						}						
					}						
					if(!isset($data2l3m[$id_group][$big]))
					{	
						$result = $result."<td>0</td>";
					}
					else
					{
						$result = $result."<td>".number_format($data2l3m[$id_group][$big],0)."</td>";
					}						
					for($j=0;$j<$k;$j++)
					{	
						$var = $period[$j];
						if(isset($datal3m[$id_group][$big][$var]))
						{								
							$result=$result."<td>".number_format($datal3m[$id_group][$big][$var],0)."</td>";
						}
						else
						{
							$result=$result."<td>0</td>";
						}						
					}	
					if($k>1)
					{	
						for($j=$k-1;$j>=1;$j--)
						{
							$var = $period[$j];
							$var2 = $period[$j-1];
							if(!isset($datal3m[$id_group][$big][$var]))
							{	
								$result=$result."<td>0</td>";
							}
							else if(!isset($datal3m[$id_group][$big][$var2]))
							{	
								$result=$result."<td>0</td>";
							}
							else if($datal3m[$id_group][$big][$var]==0 || $datal3m[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td>0</td>";
							}								
							else
							{
								$result=$result."<td>".number_format(($datal3m[$id_group][$big][$var])*100/($datal3m[$id_group][$big][$var2]),2)."</td>";
							}								
						}						
					}	
					if($k>1)
					{	
						for($j=$k-1;$j>=1;$j--)
						{
							$var = $period[$j];
							$var2 = $period[$j-1];
							if(!isset($datal3m[$id_group][$big][$var]))
							{	
								if(!isset($datal3m[$id_group][$big][$var2]))
								{
									$result=$result."<td>0</td>";
								}
								else
								{	
									$result=$result."<td>".number_format((-1*$datal3m[$id_group][$big][$var2]),0)."</td>";
								}	
							}
							else if(!isset($datal3m[$id_group][$big][$var2]))
							{	
								$result=$result."<td>".number_format($datal3m[$id_group][$big][$var],0)."</td>";
							}
							else
							{
								$result=$result."<td>".number_format((($datal3m[$id_group][$big][$var])-($datal3m[$id_group][$big][$var2])),0)."</td>";
							}	
						}						
					}	
					if(!isset($data2l6m[$id_group][$big]))
					{	
						$result = $result."<td>0</td>";
					}
					else
					{
						$result = $result."<td>".number_format($data2l6m[$id_group][$big],0)."</td>";
					}						
					for($j=0;$j<$k;$j++)
					{	
						$var = $period[$j];
						if(isset($datal6m[$id_group][$big][$var]))
						{	
							$result=$result."<td>".number_format($datal6m[$id_group][$big][$var],0)."</td>";
						}
						else
						{
							$result=$result."<td>0</td>";
						}						
					}	
					if($k>1)
					{	
						for($j=$k-1;$j>=1;$j--)
						{
							$var = $period[$j];
							$var2 = $period[$j-1];
							if(!isset($datal6m[$id_group][$big][$var]))
							{	
								$result=$result."<td>0</td>";
							}
							else if(!isset($datal6m[$id_group][$big][$var2]))
							{	
								$result=$result."<td>0</td>";
							}
							else if($datal6m[$id_group][$big][$var]==0 || $datal6m[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td>0</td>";
							}								
							else
							{
								$result=$result."<td>".number_format(($datal6m[$id_group][$big][$var])*100/($datal6m[$id_group][$big][$var2]),2)."</td>";
							}								
						}						
					}	
					if($k>1)
					{	
						for($j=$k-1;$j>=1;$j--)
						{
							$var = $period[$j];
							$var2 = $period[$j-1];
							if(!isset($datal6m[$id_group][$big][$var]))
							{	
								if(!isset($datal6m[$id_group][$big][$var2]))
								{
									$result=$result."<td>0</td>";
								}
								else
								{	
									$result=$result."<td>".number_format((-1*$datal6m[$id_group][$big][$var2]),0)."</td>";
								}	
							}
							else if(!isset($datal6m[$id_group][$big][$var2]))
							{	
								$result=$result."<td>".number_format($datal6m[$id_group][$big][$var],0)."</td>";
							}
							else
							{
								$result=$result."<td>".number_format((($datal6m[$id_group][$big][$var])-($datal6m[$id_group][$big][$var2])),0)."</td>";
							}	
						}						
					}	
					if(!isset($data2l12m[$id_group][$big]))
					{	
						$result = $result."<td>0</td>";
					}
					else
					{
						$result = $result."<td>".number_format($data2l12m[$id_group][$big],0)."</td>";
					}						
					for($j=0;$j<$k;$j++)
					{	
						$var = $period[$j];
						if(isset($datal12m[$id_group][$big][$var]))
						{	
							$result=$result."<td>".number_format($datal12m[$id_group][$big][$var],0)."</td>";
						}
						else
						{
							$result=$result."<td>0</td>";
						}						
					}	
					if($k>1)
					{	
						for($j=$k-1;$j>=1;$j--)
						{
							$var = $period[$j];
							$var2 = $period[$j-1];
							if(!isset($datal12m[$id_group][$big][$var]))
							{	
								$result=$result."<td>0</td>";
							}
							else if(!isset($datal12m[$id_group][$big][$var2]))
							{	
								$result=$result."<td>0</td>";
							}
							else if($datal12m[$id_group][$big][$var]==0 || $datal12m[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td>0</td>";
							}								
							else
							{
								$result=$result."<td>".number_format(($datal12m[$id_group][$big][$var])*100/($datal12m[$id_group][$big][$var2]),2)."</td>";
							}								
						}						
					}	
					if($k>1)
					{	
						for($j=$k-1;$j>=1;$j--)
						{
							$var = $period[$j];
							$var2 = $period[$j-1];
							if(!isset($datal12m[$id_group][$big][$var]))
							{	
								if(!isset($datal12m[$id_group][$big][$var2]))
								{
									$result=$result."<td>0</td>";
								}
								else
								{	
									$result=$result."<td>".number_format((-1*$datal12m[$id_group][$big][$var2]),0)."</td>";
								}	
							}
							else if(!isset($datal12m[$id_group][$big][$var2]))
							{	
								$result=$result."<td>".number_format($datal12m[$id_group][$big][$var],0)."</td>";
							}
							else
							{
								$result=$result."<td>".number_format((($datal12m[$id_group][$big][$var])-($datal12m[$id_group][$big][$var2])),0)."</td>";
							}	
						}						
					}	
					$result = $result."</tr>";
					$id_group=$row3->id_group;
					$big=$row3->big;
					$result = $result."<tr><td>".$channel[$row3->big]."</td><td>".$row3->group_name."</td>";
				}									
			}
					for($j=0;$j<$k;$j++)
					{
						$var = $period[$j];
						if(isset($data[$id_group][$big][$var]))
						{	
							if($_GET['year1']==$_GET['year2'])
							{
								$divider = $_GET['month2'];
							}								
							else
							{
								if($period[$j]==$_GET['year1'])
								{
									$divider=12;
								}									
								else if($period[$j]==$_GET['year2'])
								{
									$divider=$_GET['month2'];
								}
								else
								{
									$divider=12;
								}									
							}								

							$result=$result."<td>".number_format($data[$id_group][$big][$var]/$divider,0)."</td>";
						}
						else
						{
							$result=$result."<td>0</td>";
						}						
					}		
					if($k>1)
					{	
						for($j=$k-1;$j>=1;$j--)
						{
							$var = $period[$j];
							$var2 = $period[$j-1];
							if(!isset($data[$id_group][$big][$var]))
							{	
								$result=$result."<td>0</td>";
							}
							else if(!isset($data[$id_group][$big][$var2]))
							{	
								$result=$result."<td>0</td>";
							}
							else if($data[$id_group][$big][$var]==0 || $data[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td>0</td>";
							}								
							else
							{
								$result=$result."<td>".number_format($data[$id_group][$big][$var]*100/$data[$id_group][$big][$var2],2)."</td>";
							}								
						}						
					}	
					for($j=0;$j<$k;$j++)
					{
						$var = $period[$j];
						if(isset($data2[$id_group][$big][$var]))
						{	
							$result=$result."<td>".number_format($data2[$id_group][$big][$var],0)."</td>";
						}
						else
						{
							$result=$result."<td>0</td>";
						}						
					}						
					$result = $result."<td>No Transaction Outlet (L3M)</td>";
					for($j=0;$j<$k;$j++)
					{	
						$var = $period[$j];
						$result = $result."<td>AVE ".$var."</td>";
					}	
					if($k>1)
					{	
						for($j=$k-1;$j>=1;$j--)
						{
							$var = $period[$j];
							$var2 = $period[$j-1];
							if(!isset($data[$id_group][$big][$var]))
							{	
								$result=$result."<td>0</td>";
							}
							else if(!isset($data[$id_group][$big][$var2]))
							{	
								$result=$result."<td>0</td>";
							}
							else if($data[$id_group][$big][$var]==0 || $data[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td>0</td>";
							}								
							else
							{
								$result=$result."<td>vs</td>";
							}								
						}						
					}	
					if($k>1)
					{	
						for($j=$k-1;$j>=1;$j--)
						{
							$var = $period[$j];
							$var2 = $period[$j-1];
							if(!isset($data[$id_group][$big][$var]))
							{	
								$result=$result."<td>0</td>";
							}
							else if(!isset($data[$id_group][$big][$var2]))
							{	
								$result=$result."<td>0</td>";
							}
							else if($data[$id_group][$big][$var]==0 || $data[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td>0</td>";
							}								
							else
							{
								$result=$result."<td>Gap</td>";
							}								
						}						
					}	
					$result = $result."<td>No Transaction Outlet (L6M)</td>";
					for($j=0;$j<$k;$j++)
					{	
						$var = $period[$j];
						$result = $result."<td>AVE ".$var."</td>";
					}	
					if($k>1)
					{	
						for($j=$k-1;$j>=1;$j--)
						{
							$var = $period[$j];
							$var2 = $period[$j-1];
							if(!isset($data[$id_group][$big][$var]))
							{	
								$result=$result."<td>0</td>";
							}
							else if(!isset($data[$id_group][$big][$var2]))
							{	
								$result=$result."<td>0</td>";
							}
							else if($data[$id_group][$big][$var]==0 || $data[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td>0</td>";
							}								
							else
							{
								$result=$result."<td>vs</td>";
							}								
						}						
					}	
					if($k>1)
					{	
						for($j=$k-1;$j>=1;$j--)
						{
							$var = $period[$j];
							$var2 = $period[$j-1];
							if(!isset($data[$id_group][$big][$var]))
							{	
								$result=$result."<td>0</td>";
							}
							else if(!isset($data[$id_group][$big][$var2]))
							{	
								$result=$result."<td>0</td>";
							}
							else if($data[$id_group][$big][$var]==0 || $data[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td>0</td>";
							}								
							else
							{
								$result=$result."<td>Gap</td>";
							}								
						}						
					}	
					$result = $result."<td>No Transaction Outlet</td>";
					for($j=0;$j<$k;$j++)
					{	
						$var = $period[$j];
						$result = $result."<td>AVE ".$var."</td>";
					}	
					if($k>1)
					{	
						for($j=$k-1;$j>=1;$j--)
						{
							$var = $period[$j];
							$var2 = $period[$j-1];
							if(!isset($data[$id_group][$big][$var]))
							{	
								$result=$result."<td>0</td>";
							}
							else if(!isset($data[$id_group][$big][$var2]))
							{	
								$result=$result."<td>0</td>";
							}
							else if($data[$id_group][$big][$var]==0 || $data[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td>0</td>";
							}								
							else
							{
								$result=$result."<td>vs</td>";
							}								
						}						
					}	
					if($k>1)
					{	
						for($j=$k-1;$j>=1;$j--)
						{
							$var = $period[$j];
							$var2 = $period[$j-1];
							if(!isset($data[$id_group][$big][$var]))
							{	
								$result=$result."<td>0</td>";
							}
							else if(!isset($data[$id_group][$big][$var2]))
							{	
								$result=$result."<td>0</td>";
							}
							else if($data[$id_group][$big][$var]==0 || $data[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td>0</td>";
							}								
							else
							{
								$result=$result."<td>Gap</td>";
							}								
						}						
					}	
			$result = $result."</tr>";

		
		$result=$result."</table>";
		echo $result;
	}	


}
