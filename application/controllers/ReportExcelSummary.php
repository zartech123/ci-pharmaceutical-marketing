<?php 

//if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class ReportExcelSummary
{	
	public function __construct()
	{
		$servername = "localhost";
		$username = "crmtaisho_taisho";
		$database = "crmtaisho_taisho";
		$password = "@b4d)S7ph1";
		$link = new mysqli($servername, $username, $password, $database);

		$sql = "update job set state=1 where id_job=3";
		mysqli_query($link, $sql);

		$filename="SummaryReportNonActiveOutlet";

		unlink('/home/crmtaisho/public_html/assets/uploads/'.$filename.'.txt');

		$result="<table class='table table-sm table-bordered table-striped' style='font-size:12px'>";
		$result2="";
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
		
		if (isset($_SERVER['argv'])) 
		{
			$id_product = $_SERVER['argv'][1];
			$id_channel = $_SERVER['argv'][2];
			$id_dist = $_SERVER['argv'][3];
			$y1=$_SERVER['argv'][4];
			$y2=$_SERVER['argv'][5];
			$m1=$_SERVER['argv'][6];
			$m2=$_SERVER['argv'][7];

		}
				
		$sum="sum(sales_value+retur_value)";
		
		
		$id_group="";
		$big="";
		
		$channel = array("HOSPITAL", "PHARMACY", "DRUGSTORE", "INSTITUTION", "MTC", "PHARMA CHAIN", "GT & OTHERS", "PBF","TOTAL");
		
		$colspan2 = 0;
		$colspan = ($y2-$y1+1)*2+($y2-$y1)+2;
		$colspan2 = $colspan2 + $colspan;
		$result = $result."<thead><tr><th scope='col' colspan='".$colspan."' style='text-align:center'>Sales</th>";
		$colspan = ($y2-$y1+1)+1+($y2-$y1)*2;
		$colspan2 = $colspan2 + $colspan;
		$result = $result."<th scope='col' colspan='".$colspan."' style='text-align:center'>Non Active during L3M</th>";
		$colspan = ($y2-$y1+1)+1+($y2-$y1)*2;
		$colspan2 = $colspan2 + $colspan;
		$result = $result."<th scope='col' colspan='".$colspan."' style='text-align:center'>Non Active during L6M</th>";
		$colspan = ($y2-$y1+1)+1+($y2-$y1)*2;
		$colspan2 = $colspan2 + $colspan;
		$result = $result."<th scope='col' colspan='".$colspan."' style='text-align:center'>Non Active since Jan ".($y2-1)."</th></tr>";
		$result = $result."<tr><th scope='col' style='text-align:center'>Channel</th><th scope='col' style='text-align:center'>Product</th>";
		for($i=$y1;$i<=$y2;$i++)
		{	
			$result = $result."<th scope='col' style='text-align:center'>AVE ".$i."</th>";
		}	

		$k = 0;
		for($i=$y1;$i<=$y2;$i++)
		{	
			$period[$k] = $i;
			$k = $k + 1;
			if($k>1)
			{
				$result = $result."<th scope='col' style='text-align:center'>".$period[$k-1]." vs ".$period[$k-2]." (%)</th>";
			}				
		}	

		for($i=$y1;$i<=$y2;$i++)
		{	
			$result = $result."<th scope='col' style='text-align:center'>Active Transaction ".$i."</th>";
		}	

		$result = $result."<th scope='col' style='text-align:center'>No Transaction Outlet</th>";
		for($i=$y1;$i<=$y2;$i++)
		{	
			$result = $result."<th scope='col' style='text-align:center'>AVE ".$i."</th>";
		}	
		$k = 0;
		for($i=$y1;$i<=$y2;$i++)
		{	
			$period[$k] = $i;
			$k = $k + 1;
			if($k>1)
			{
				$result = $result."<th scope='col' style='text-align:center'>".$period[$k-1]." vs ".$period[$k-2]." (%)</th>";
			}				
		}	
		$k = 0;
		for($i=$y1;$i<=$y2;$i++)
		{	
			$period[$k] = $i;
			$k = $k + 1;
			if($k>1)
			{
				$result = $result."<th scope='col' style='text-align:center'>Gap ".$period[$k-1]." vs ".$period[$k-2]."</th>";
			}				
		}	

		$result = $result."<th scope='col' style='text-align:center'>No Transaction Outlet</th>";
		for($i=$y1;$i<=$y2;$i++)
		{	
			$result = $result."<th scope='col' style='text-align:center'>AVE ".$i."</th>";
		}	
		$k = 0;
		for($i=$y1;$i<=$y2;$i++)
		{	
			$period[$k] = $i;
			$k = $k + 1;
			if($k>1)
			{
				$result = $result."<th scope='col' style='text-align:center'>".$period[$k-1]." vs ".$period[$k-2]." (%)</th>";
			}				
		}	
		$k = 0;
		for($i=$y1;$i<=$y2;$i++)
		{	
			$period[$k] = $i;
			$k = $k + 1;
			if($k>1)
			{
				$result = $result."<th scope='col' style='text-align:center'>Gap ".$period[$k-1]." vs ".$period[$k-2]."</th>";
			}				
		}	

		$result = $result."<th scope='col' style='text-align:center'>No Transaction Outlet </th>";
		for($i=$y1;$i<=$y2;$i++)
		{	
			$result = $result."<th scope='col' style='text-align:center'>AVE ".$i."</th>";
		}	
		$k = 0;
		for($i=$y1;$i<=$y2;$i++)
		{	
			$period[$k] = $i;
			$k = $k + 1;
			if($k>1)
			{
				$result = $result."<th scope='col' style='text-align:center'>".$period[$k-1]." vs ".$period[$k-2]." (%)</th>";
			}				
		}	
		$k = 0;
		for($i=$y1;$i<=$y2;$i++)
		{	
			$period[$k] = $i;
			$k = $k + 1;
			if($k>1)
			{
				$result = $result."<th scope='col' style='text-align:center'>Gap ".$period[$k-1]." vs ".$period[$k-2]."</th>";
			}				
		}	
		$result = $result."</tr></thead><tbody>";

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

			if($m2<3)
			{	
				$periodl3m=($y2-1).str_pad(($m2+10),2,"0",STR_PAD_LEFT);
			}
			else
			{
				$periodl3m=$y2.str_pad(($m2-2),2,"0",STR_PAD_LEFT);
			}				

			if($m2<6)
			{	
				$periodl6m=($y2-1).str_pad(($m2+7),2,"0",STR_PAD_LEFT);
			}
			else
			{
				$periodl6m=$y2.str_pad(($m2-5),2,"0",STR_PAD_LEFT);
			}				

			$id_cust="";
			$queryl3m = "select id_cust from customer a, channel b where a.id_channel=b.id_channel and big in (".$id_channel.") and a.id_dist in (2) and id_cust not in (select id_cust from invoice_sum where id_product in (".$id_product.") and period between '".$periodl3m."' and '".$y2.str_pad($m2,2,"0",STR_PAD_LEFT)."')";
			//$result2 = mysqli_query($link, $query3);

			/*while($row3 = mysqli_fetch_array($result2))
			{
				$id_cust=$id_cust."'".$row3['id_cust']."',";				
			}
			$id_cust=$id_cust."''";*/
						
			$query3 = "select count(distinct a.id_cust) as jumlah, big, d.id_group from invoice_sum a, customer b, channel c, product d where a.id_product=d.id_product and b.id_channel=c.id_channel and a.id_cust=b.id_cust and a.id_cust in (".$queryl3m.") and period between '".$y1.str_pad(1,2,"0",STR_PAD_LEFT)."' and '".$y2.str_pad($m2,2,"0",STR_PAD_LEFT)."' group by d.id_group, big";
			$result2 = mysqli_query($link, $query3);
			while($row3 = mysqli_fetch_array($result2))
			{
				$data2l3m[$row3['id_group']][$row3['big']]=$row3['jumlah'];
			}

			$query3 = "select sum(sales_value+retur_value) as total, substring(period,1,4) as period, big, d.id_group from invoice_sum a, customer b, channel c, product d where a.id_product=d.id_product and b.id_channel=c.id_channel and a.id_cust=b.id_cust and a.id_cust in (".$queryl3m.") and period between '".$y1.str_pad(1,2,"0",STR_PAD_LEFT)."' and '".$y2.str_pad($m2,2,"0",STR_PAD_LEFT)."' group by d.id_group, big, substring(period,1,4)";
			$result2 = mysqli_query($link, $query3);
			while($row3 = mysqli_fetch_array($result2))
			{
				if($row3['period']==$y1)
				{
					$divider = 12;
				}						
				else if($row3['period']==$y2)
				{
					$divider =$m2;
				}
				else
				{
					$divider = 12;
				}								
				$datal3m[$row3['id_group']][$row3['big']][$row3['period']]=$row3['total']/$divider;
			}
			
			$id_cust="";
			$queryl6m = "select id_cust from customer a, channel b where a.id_channel=b.id_channel and big in (".$id_channel.") and a.id_dist in (2) and id_cust not in (select id_cust from invoice_sum where id_product in (".$id_product.") and period between '".$periodl6m."' and '".$y2.str_pad($m2,2,"0",STR_PAD_LEFT)."')";
			/*$result2 = mysqli_query($link, $query3);
			while($row3 = mysqli_fetch_array($result2))
			{
				$id_cust=$id_cust."'".$row3['id_cust']."',";				
			}
			$id_cust=$id_cust."''";*/

			$query3 = "select count(distinct a.id_cust) as jumlah, big, d.id_group from invoice_sum a, customer b, channel c, product d where a.id_product=d.id_product and b.id_channel=c.id_channel and a.id_cust=b.id_cust and a.id_cust in (".$queryl6m.") and period between '".$y1.str_pad(1,2,"0",STR_PAD_LEFT)."' and '".$y2.str_pad($m2,2,"0",STR_PAD_LEFT)."' group by d.id_group, big";
			$result2 = mysqli_query($link, $query3);
			while($row3 = mysqli_fetch_array($result2))
			{
				$data2l6m[$row3['id_group']][$row3['big']]=$row3['jumlah'];
			}
			
			$query3 = "select sum(sales_value+retur_value) as total, substring(period,1,4) as period, big, d.id_group from invoice_sum a, customer b, channel c, product d where a.id_product=d.id_product and b.id_channel=c.id_channel and a.id_cust=b.id_cust and a.id_cust in (".$queryl6m.") and period between '".$y1.str_pad(1,2,"0",STR_PAD_LEFT)."' and '".$y2.str_pad($m2,2,"0",STR_PAD_LEFT)."' group by d.id_group, big, substring(period,1,4)";
			$result2 = mysqli_query($link, $query3);
			while($row3 = mysqli_fetch_array($result2))
			{
				if($row3['period']==$y1)
				{
					$divider = 12;
				}						
				else if($row3['period']==$y2)
				{
					$divider =$m2;
				}
				else
				{
					$divider = 12;
				}								
				$datal6m[$row3['id_group']][$row3['big']][$row3['period']]=$row3['total']/$divider;
			}


			$id_cust="";
			$queryl12m = "select id_cust from customer a, channel b where a.id_channel=b.id_channel and big in (".$id_channel.") and a.id_dist in (2) and id_cust not in (select id_cust from invoice_sum where id_product in (".$id_product.") and period between '".($y2-1).str_pad(1,2,"0",STR_PAD_LEFT)."' and '".$y2.str_pad($m2,2,"0",STR_PAD_LEFT)."')";
			/*$result2 = mysqli_query($link, $query3);
			while($row3 = mysqli_fetch_array($result2))
			{
				$id_cust=$id_cust."'".$row3['id_cust']."',";				
			}
			$id_cust=$id_cust."''";*/
			
			$query3 = "select count(distinct a.id_cust) as jumlah, big, d.id_group from invoice_sum a, customer b, channel c, product d where a.id_product=d.id_product and b.id_channel=c.id_channel and a.id_cust=b.id_cust and a.id_cust in (".$queryl12m.") and period between '".$y1.str_pad(1,2,"0",STR_PAD_LEFT)."' and '".$y2.str_pad($m2,2,"0",STR_PAD_LEFT)."' group by d.id_group, big";
			$result2 = mysqli_query($link, $query3);
			while($row3 = mysqli_fetch_array($result2))
			{
				$data2l12m[$row3['id_group']][$row3['big']]=$row3['jumlah'];
			}

			$query3 = "select sum(sales_value+retur_value) as total, substring(period,1,4) as period, big, d.id_group from invoice_sum a, customer b, channel c, product d where a.id_product=d.id_product and b.id_channel=c.id_channel and a.id_cust=b.id_cust and a.id_cust in (".$queryl12m.") and period between '".$y1.str_pad(1,2,"0",STR_PAD_LEFT)."' and '".$y2.str_pad($m2,2,"0",STR_PAD_LEFT)."' group by d.id_group, big, substring(period,1,4)";
			$result2 = mysqli_query($link, $query3);
			while($row3 = mysqli_fetch_array($result2))
			{
				if($row3['period']==$y1)
				{
					$divider = 12;
				}						
				else if($row3['period']==$y2)
				{
					$divider =$m2;
				}
				else
				{
					$divider = 12;
				}								
				$datal12m[$row3['id_group']][$row3['big']][$row3['period']]=$row3['total']/$divider;
			}

//		if($id_dist!="")
//		{
//			$query3 = "select distinct b.id_cust, id_cust2, b.name, big, address, c.name as branch_name from channel a, customer b, branch c, customer_redistribution d where b.id_cust=d.id_cust and d.id_branch=c.id_branch and a.id_channel=b.id_channel and a.id_dist=d.id_dist and d.id_dist in (".$_GET['id_dist'].") and a.big in (".$id_channel.") order by id_cust2 limit 1000");
//		}			
//		else
//		{	
//			$query3 = "select distinct id_cust, id_cust2, b.name, big, address, c.name as branch_name from channel a, customer b, branch c where b.id_branch=c.id_branch and a.id_channel=b.id_channel and a.id_dist=b.id_dist and a.id_dist in (2) and a.big in (".$id_channel.") order by id_cust2 limit 1000");
			$query3 = "select sum(sales_value+retur_value) as total, count(distinct a.id_cust) as jumlah, substring(period,1,4) as period, big, d.id_group, e.name as group_name from invoice_sum a, customer b, channel c, product d, product_group e where e.id_group=d.id_group and a.id_product=d.id_product and b.id_channel=c.id_channel and a.id_cust=b.id_cust and a.id_product in (".$id_product.") and b.id_dist in (2) and c.big in (".$id_channel.") and period between '".$y1.str_pad(1,2,"0",STR_PAD_LEFT)."' and '".$y2.str_pad($m2,2,"0",STR_PAD_LEFT)."' group by d.id_group, big, substring(period,1,4)";
//		}	

			$result2 = mysqli_query($link, $query3);
			while($row3 = mysqli_fetch_array($result2))
			{
				$data[$row3['id_group']][$row3['big']][$row3['period']]=$row3['total'];
				$data2[$row3['id_group']][$row3['big']][$row3['period']]=$row3['jumlah'];

				if($big=="")
				{
					$id_group=$row3['id_group'];
					$big=$row3['big'];
					$result = $result."<tr><td>".$channel[$row3['big']]."</td><td>".$row3['group_name']."</td>";
				}
				if($big==$row3['big'] && $id_group==$row3['id_group'])
				{
				}
				else
				{
					for($j=0;$j<$k;$j++)
					{
						$var = $period[$j];
						if(isset($data[$id_group][$big][$var]))
						{	
							if($y1==$y2)
							{
								$divider = $m2;
							}								
							else
							{
								if($period[$j]==$y1)
								{
									$divider=12;
								}									
								else if($period[$j]==$y2)
								{
									$divider=$m2;
								}
								else
								{
									$divider=12;
								}									
							}								
							
							$result=$result."<td style='text-align:right'>".number_format($data[$id_group][$big][$var]/$divider,0)."</td>";
						}
						else
						{
							$result=$result."<td style='text-align:right'>0</td>";
						}						
					}		
					if($k>1)
					{	
						for($j=$k-1;$j>=1;$j--)
						{
							$var = $period[$j];
							$var2 = $period[$j-1];
							if($var==$y1)
							{
								$divider1 = 12;
							}						
							else if($var==$y2)
							{
								$divider1 =$m2;
							}
							else
							{
								$divider1 = 12;
							}								
							if($var2==$y1)
							{
								$divider2 = 12;
							}						
							else if($var2==$y2)
							{
								$divider2 =$m2;
							}
							else
							{
								$divider2 = 12;
							}								
							if(!isset($data[$id_group][$big][$var]))
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}
							else if(!isset($data[$id_group][$big][$var2]))
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}
							else if($data[$id_group][$big][$var]==0 || $data[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}								
							else
							{
								$result=$result."<td style='text-align:right'>".number_format(($data[$id_group][$big][$var])*100/($data[$id_group][$big][$var2]),2)."</td>";
							}								
						}						
					}	
					for($j=0;$j<$k;$j++)
					{
						$var = $period[$j];
						if(isset($data2[$id_group][$big][$var]))
						{	
							$result=$result."<td style='text-align:right'>".number_format($data2[$id_group][$big][$var],0)."</td>";
						}
						else
						{
							$result=$result."<td style='text-align:right'>0</td>";
						}						
					}						
					if(!isset($data2l3m[$id_group][$big]))
					{	
						$result = $result."<td style='text-align:right'>0</td>";
					}
					else
					{
						$result = $result."<td style='text-align:right'>".number_format($data2l3m[$id_group][$big],0)."</td>";
					}						
					for($j=0;$j<$k;$j++)
					{	
						$var = $period[$j];
						if(isset($datal3m[$id_group][$big][$var]))
						{								
							$result=$result."<td style='text-align:right'>".number_format($datal3m[$id_group][$big][$var],0)."</td>";
						}
						else
						{
							$result=$result."<td style='text-align:right'>0</td>";
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
								$result=$result."<td style='text-align:right'>0</td>";
							}
							else if(!isset($datal3m[$id_group][$big][$var2]))
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}
							else if($datal3m[$id_group][$big][$var]==0 || $datal3m[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}								
							else
							{
								$result=$result."<td style='text-align:right'>".number_format(($datal3m[$id_group][$big][$var])*100/($datal3m[$id_group][$big][$var2]),2)."</td>";
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
									$result=$result."<td style='text-align:right'>0</td>";
								}
								else
								{	
									$color="";
									if($datal3m[$id_group][$big][$var2]>0)
									{
										$color=";color:red";
									}									
									$result=$result."<td style='text-align:right".$color."'>".number_format((-1*$datal3m[$id_group][$big][$var2]),0)."</td>";
								}	
							}
							else if(!isset($datal3m[$id_group][$big][$var2]))
							{	
								$result=$result."<td style='text-align:right'>".number_format($datal3m[$id_group][$big][$var],0)."</td>";
							}
							else
							{
								$color="";
								if($datal3m[$id_group][$big][$var]<$datal3m[$id_group][$big][$var2])
								{
									$color=";color:red";
								}									
								$result=$result."<td style='text-align:right".$color."'>".number_format((($datal3m[$id_group][$big][$var])-($datal3m[$id_group][$big][$var2])),0)."</td>";
							}	
						}						
					}	
					if(!isset($data2l6m[$id_group][$big]))
					{	
						$result = $result."<td style='text-align:right'>0</td>";
					}
					else
					{
						$result = $result."<td style='text-align:right'>".number_format($data2l6m[$id_group][$big],0)."</td>";
					}						
					for($j=0;$j<$k;$j++)
					{	
						$var = $period[$j];
						if(isset($datal6m[$id_group][$big][$var]))
						{	
							$result=$result."<td style='text-align:right'>".number_format($datal6m[$id_group][$big][$var],0)."</td>";
						}
						else
						{
							$result=$result."<td style='text-align:right'>0</td>";
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
								$result=$result."<td style='text-align:right'>0</td>";
							}
							else if(!isset($datal6m[$id_group][$big][$var2]))
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}
							else if($datal6m[$id_group][$big][$var]==0 || $datal6m[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}								
							else
							{
								$result=$result."<td style='text-align:right'>".number_format(($datal6m[$id_group][$big][$var])*100/($datal6m[$id_group][$big][$var2]),2)."</td>";
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
									$result=$result."<td style='text-align:right'>0</td>";
								}
								else
								{	
									$color="";
									if($datal6m[$id_group][$big][$var2]>0)
									{
										$color=";color:red";
									}									
									$result=$result."<td style='text-align:right".$color."'>".number_format((-1*$datal6m[$id_group][$big][$var2]),0)."</td>";
								}	
							}
							else if(!isset($datal6m[$id_group][$big][$var2]))
							{	
								$result=$result."<td style='text-align:right'>".number_format($datal6m[$id_group][$big][$var],0)."</td>";
							}
							else
							{
								$color="";
								if($datal6m[$id_group][$big][$var]<$datal6m[$id_group][$big][$var2])
								{
									$color=";color:red";
								}									
								$result=$result."<td style='text-align:right".$color."'>".number_format((($datal6m[$id_group][$big][$var])-($datal6m[$id_group][$big][$var2])),0)."</td>";
							}	
						}						
					}	
					if(!isset($data2l12m[$id_group][$big]))
					{	
						$result = $result."<td style='text-align:right'>0</td>";
					}
					else
					{
						$result = $result."<td style='text-align:right'>".number_format($data2l12m[$id_group][$big],0)."</td>";
					}						
					for($j=0;$j<$k;$j++)
					{	
						$var = $period[$j];
						if(isset($datal12m[$id_group][$big][$var]))
						{	
							$result=$result."<td style='text-align:right'>".number_format($datal12m[$id_group][$big][$var],0)."</td>";
						}
						else
						{
							$result=$result."<td style='text-align:right'>0</td>";
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
								$result=$result."<td style='text-align:right'>0</td>";
							}
							else if(!isset($datal12m[$id_group][$big][$var2]))
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}
							else if($datal12m[$id_group][$big][$var]==0 || $datal12m[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}								
							else
							{
								$result=$result."<td style='text-align:right'>".number_format(($datal12m[$id_group][$big][$var])*100/($datal12m[$id_group][$big][$var2]),2)."</td>";
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
									$result=$result."<td style='text-align:right'>0</td>";
								}
								else
								{	
									$color="";
									if($datal12m[$id_group][$big][$var2]>0)
									{
										$color=";color:red";
									}									
									$result=$result."<td style='text-align:right".$color."'>".number_format((-1*$datal12m[$id_group][$big][$var2]),0)."</td>";
								}	
							}
							else if(!isset($datal12m[$id_group][$big][$var2]))
							{	
								$result=$result."<td style='text-align:right'>".number_format($datal12m[$id_group][$big][$var],0)."</td>";
							}
							else
							{
								$color="";
								if($datal12m[$id_group][$big][$var]<$datal12m[$id_group][$big][$var2])
								{
									$color=";color:red";
								}									
								$result=$result."<td style='text-align:right".$color."'>".number_format((($datal12m[$id_group][$big][$var])-($datal12m[$id_group][$big][$var2])),0)."</td>";
							}	
						}						
					}	
					$result = $result."</tr>";
					if($id_group!=$row3['id_group'])
					{
						$result = $result."<tr><td colspan=".$colspan2.">&nbsp;</td></tr>";
						$colspan = ($y2-$y1+1)*2+($y2-$y1)+2;
						$result = $result."<tr><th scope='col' colspan='".$colspan."' style='text-align:center'>Sales</th>";
						$colspan = ($y2-$y1+1)+1+($y2-$y1)*2;
						$result = $result."<th scope='col' colspan='".$colspan."' style='text-align:center'>Non Active during L3M</th>";
						$colspan = ($y2-$y1+1)+1+($y2-$y1)*2;
						$result = $result."<th scope='col' colspan='".$colspan."' style='text-align:center'>Non Active during L6M</th>";
						$colspan = ($y2-$y1+1)+1+($y2-$y1)*2;
						$result = $result."<th scope='col' colspan='".$colspan."' style='text-align:center'>Non Active since Jan ".($y2-1)."</th></tr>";
						$result = $result."<tr><th scope='col' style='text-align:center'>Channel</th><th scope='col' style='text-align:center'>Product</th>";
						for($i=$y1;$i<=$y2;$i++)
						{	
							$result = $result."<th scope='col' style='text-align:center'>AVE ".$i."</th>";
						}	

						$k = 0;
						for($i=$y1;$i<=$y2;$i++)
						{	
							$period[$k] = $i;
							$k = $k + 1;
							if($k>1)
							{
								$result = $result."<th scope='col' style='text-align:center'>".$period[$k-1]." vs ".$period[$k-2]." (%)</th>";
							}				
						}	

						for($i=$y1;$i<=$y2;$i++)
						{	
							$result = $result."<th scope='col' style='text-align:center'>Active Transaction ".$i."</th>";
						}	

						$result = $result."<th scope='col' style='text-align:center'>No Transaction Outlet</th>";
						for($i=$y1;$i<=$y2;$i++)
						{	
							$result = $result."<th scope='col' style='text-align:center'>AVE ".$i."</th>";
						}	
						$k = 0;
						for($i=$y1;$i<=$y2;$i++)
						{	
							$period[$k] = $i;
							$k = $k + 1;
							if($k>1)
							{
								$result = $result."<th scope='col' style='text-align:center'>".$period[$k-1]." vs ".$period[$k-2]." (%)</th>";
							}				
						}	
						$k = 0;
						for($i=$y1;$i<=$y2;$i++)
						{	
							$period[$k] = $i;
							$k = $k + 1;
							if($k>1)
							{
								$result = $result."<th scope='col' style='text-align:center'>Gap ".$period[$k-1]." vs ".$period[$k-2]."</th>";
							}				
						}	

						$result = $result."<th scope='col' style='text-align:center'>No Transaction Outlet</th>";
						for($i=$y1;$i<=$y2;$i++)
						{	
							$result = $result."<th scope='col' style='text-align:center'>AVE ".$i."</th>";
						}	
						$k = 0;
						for($i=$y1;$i<=$y2;$i++)
						{	
							$period[$k] = $i;
							$k = $k + 1;
							if($k>1)
							{
								$result = $result."<th scope='col' style='text-align:center'>".$period[$k-1]." vs ".$period[$k-2]." (%)</th>";
							}				
						}	
						$k = 0;
						for($i=$y1;$i<=$y2;$i++)
						{	
							$period[$k] = $i;
							$k = $k + 1;
							if($k>1)
							{
								$result = $result."<th scope='col' style='text-align:center'>Gap ".$period[$k-1]." vs ".$period[$k-2]."</th>";
							}				
						}	

						$result = $result."<th scope='col' style='text-align:center'>No Transaction Outlet </th>";
						for($i=$y1;$i<=$y2;$i++)
						{	
							$result = $result."<th scope='col' style='text-align:center'>AVE ".$i."</th>";
						}	
						$k = 0;
						for($i=$y1;$i<=$y2;$i++)
						{	
							$period[$k] = $i;
							$k = $k + 1;
							if($k>1)
							{
								$result = $result."<th scope='col' style='text-align:center'>".$period[$k-1]." vs ".$period[$k-2]." (%)</th>";
							}				
						}	
						$k = 0;
						for($i=$y1;$i<=$y2;$i++)
						{	
							$period[$k] = $i;
							$k = $k + 1;
							if($k>1)
							{
								$result = $result."<th scope='col' style='text-align:center'>Gap ".$period[$k-1]." vs ".$period[$k-2]."</th>";
							}				
						}	
						$result = $result."</tr>";
					}						
					$id_group=$row3['id_group'];
					$big=$row3['big'];
					$result = $result."<tr><td>".$channel[$row3['big']]."</td><td>".$row3['group_name']."</td>";
				}									
			}
					for($j=0;$j<$k;$j++)
					{
						$var = $period[$j];
						if(isset($data[$id_group][$big][$var]))
						{	
							if($y1==$y2)
							{
								$divider = $m2;
							}								
							else
							{
								if($period[$j]==$y1)
								{
									$divider=12;
								}									
								else if($period[$j]==$y2)
								{
									$divider=$m2;
								}
								else
								{
									$divider=12;
								}									
							}								
							
							$result=$result."<td style='text-align:right'>".number_format($data[$id_group][$big][$var]/$divider,0)."</td>";
						}
						else
						{
							$result=$result."<td style='text-align:right'>0</td>";
						}						
					}		
					if($k>1)
					{	
						for($j=$k-1;$j>=1;$j--)
						{
							$var = $period[$j];
							$var2 = $period[$j-1];
							if($var==$y1)
							{
								$divider1 = 12;
							}						
							else if($var==$y2)
							{
								$divider1 =$m2;
							}
							else
							{
								$divider1 = 12;
							}								
							if($var2==$y1)
							{
								$divider2 = 12;
							}						
							else if($var2==$y2)
							{
								$divider2 =$m2;
							}
							else
							{
								$divider2 = 12;
							}								
							if(!isset($data[$id_group][$big][$var]))
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}
							else if(!isset($data[$id_group][$big][$var2]))
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}
							else if($data[$id_group][$big][$var]==0 || $data[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}								
							else
							{
								$result=$result."<td style='text-align:right'>".number_format(($data[$id_group][$big][$var])*100/($data[$id_group][$big][$var2]),2)."</td>";
							}								
						}						
					}	
					for($j=0;$j<$k;$j++)
					{
						$var = $period[$j];
						if(isset($data2[$id_group][$big][$var]))
						{	
							$result=$result."<td style='text-align:right'>".number_format($data2[$id_group][$big][$var],0)."</td>";
						}
						else
						{
							$result=$result."<td style='text-align:right'>0</td>";
						}						
					}						
					if(!isset($data2l3m[$id_group][$big]))
					{	
						$result = $result."<td style='text-align:right'>0</td>";
					}
					else
					{
						$result = $result."<td style='text-align:right'>".number_format($data2l3m[$id_group][$big],0)."</td>";
					}						
					for($j=0;$j<$k;$j++)
					{	
						$var = $period[$j];
						if(isset($datal3m[$id_group][$big][$var]))
						{								
							$result=$result."<td style='text-align:right'>".number_format($datal3m[$id_group][$big][$var],0)."</td>";
						}
						else
						{
							$result=$result."<td style='text-align:right'>0</td>";
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
								$result=$result."<td style='text-align:right'>0</td>";
							}
							else if(!isset($datal3m[$id_group][$big][$var2]))
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}
							else if($datal3m[$id_group][$big][$var]==0 || $datal3m[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}								
							else
							{
								$result=$result."<td style='text-align:right'>".number_format(($datal3m[$id_group][$big][$var])*100/($datal3m[$id_group][$big][$var2]),2)."</td>";
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
									$result=$result."<td style='text-align:right'>0</td>";
								}
								else
								{	
									$result=$result."<td style='text-align:right;color:red'>".number_format((-1*$datal3m[$id_group][$big][$var2]),0)."</td>";
								}	
							}
							else if(!isset($datal3m[$id_group][$big][$var2]))
							{	
								$result=$result."<td style='text-align:right'>".number_format($datal3m[$id_group][$big][$var],0)."</td>";
							}
							else
							{
								$result=$result."<td style='text-align:right'>".number_format((($datal3m[$id_group][$big][$var])-($datal3m[$id_group][$big][$var2])),0)."</td>";
							}	
						}						
					}	
					if(!isset($data2l6m[$id_group][$big]))
					{	
						$result = $result."<td style='text-align:right'>0</td>";
					}
					else
					{
						$result = $result."<td style='text-align:right'>".number_format($data2l6m[$id_group][$big],0)."</td>";
					}						
					for($j=0;$j<$k;$j++)
					{	
						$var = $period[$j];
						if(isset($datal6m[$id_group][$big][$var]))
						{	
							$result=$result."<td style='text-align:right'>".number_format($datal6m[$id_group][$big][$var],0)."</td>";
						}
						else
						{
							$result=$result."<td style='text-align:right'>0</td>";
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
								$result=$result."<td style='text-align:right'>0</td>";
							}
							else if(!isset($datal6m[$id_group][$big][$var2]))
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}
							else if($datal6m[$id_group][$big][$var]==0 || $datal6m[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}								
							else
							{
								$result=$result."<td style='text-align:right'>".number_format(($datal6m[$id_group][$big][$var])*100/($datal6m[$id_group][$big][$var2]),2)."</td>";
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
									$result=$result."<td style='text-align:right'>0</td>";
								}
								else
								{	
									$result=$result."<td style='text-align:right;color:red'>".number_format((-1*$datal6m[$id_group][$big][$var2]),0)."</td>";
								}	
							}
							else if(!isset($datal6m[$id_group][$big][$var2]))
							{	
								$result=$result."<td style='text-align:right'>".number_format($datal6m[$id_group][$big][$var],0)."</td>";
							}
							else
							{
								$result=$result."<td style='text-align:right'>".number_format((($datal6m[$id_group][$big][$var])-($datal6m[$id_group][$big][$var2])),0)."</td>";
							}	
						}						
					}	
					if(!isset($data2l12m[$id_group][$big]))
					{	
						$result = $result."<td style='text-align:right'>0</td>";
					}
					else
					{
						$result = $result."<td style='text-align:right'>".number_format($data2l12m[$id_group][$big],0)."</td>";
					}						
					for($j=0;$j<$k;$j++)
					{	
						$var = $period[$j];
						if(isset($datal12m[$id_group][$big][$var]))
						{	
							$result=$result."<td style='text-align:right'>".number_format($datal12m[$id_group][$big][$var],0)."</td>";
						}
						else
						{
							$result=$result."<td style='text-align:right'>0</td>";
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
								$result=$result."<td style='text-align:right'>0</td>";
							}
							else if(!isset($datal12m[$id_group][$big][$var2]))
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}
							else if($datal12m[$id_group][$big][$var]==0 || $datal12m[$id_group][$big][$var2]==0)
							{	
								$result=$result."<td style='text-align:right'>0</td>";
							}								
							else
							{
								$result=$result."<td style='text-align:right'>".number_format(($datal12m[$id_group][$big][$var])*100/($datal12m[$id_group][$big][$var2]),2)."</td>";
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
									$result=$result."<td style='text-align:right'>0</td>";
								}
								else
								{	
									$result=$result."<td style='text-align:right;color:red'>".number_format((-1*$datal12m[$id_group][$big][$var2]),0)."</td>";
								}	
							}
							else if(!isset($datal12m[$id_group][$big][$var2]))
							{	
								$result=$result."<td style='text-align:right'>".number_format($datal12m[$id_group][$big][$var],0)."</td>";
							}
							else
							{
								$result=$result."<td style='text-align:right'>".number_format((($datal12m[$id_group][$big][$var])-($datal12m[$id_group][$big][$var2])),0)."</td>";
							}	
						}						
					}	
					$result = $result."</tr>";
//					$id_group=$row3['id_group'];
//					$big=$row3['big'];
//					$result = $result."<tr><td>".$channel[$row3['big']]."</td><td>".$row3['group_name']."</td>";
//			$result = $result."</tr>";

		
		$result=$result."</tbody>";

		$result = $result."</table>";
		//echo $result;

		$sql = "update job set state=0 where id_job=3";
		mysqli_query($link, $sql);

		$myfile = fopen('/home/crmtaisho/public_html/assets/uploads/'.$filename.'.txt', "w") or die("Unable to open file!");
		fwrite($myfile, $result);
		fclose($myfile);
	}	


 		
}

$reportexcel = new ReportExcelSummary;


?>