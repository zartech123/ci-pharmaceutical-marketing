<?php 

//if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "/home/crmtaisho/public_html/application/third_party/PHPExcel.php";

class ReportCustomerSales
{	
	public function __construct()
	{
		$servername = "localhost";
		$username = "crmtaisho_taisho";
		$database = "crmtaisho_taisho";
		$password = "@b4d)S7ph1";
		$link = new mysqli($servername, $username, $password, $database);
		ini_set('memory_limit','1024M');

		if ($link->connect_error) {
			die("Connection failed: " . $link->connect_error);
		}

		$filename="ReportCustomerSales";

		unlink('/home/crmtaisho/public_html/assets/uploads/'.$filename.'.txt');

		if (isset($_SERVER['argv'])) 
		{
			$id_product = $_SERVER['argv'][1];
			$id_channel = $_SERVER['argv'][2];
			$id_dist2 = $_SERVER['argv'][3];
			$y1=$_SERVER['argv'][4];
			$y2=$_SERVER['argv'][5];
			$m1=$_SERVER['argv'][6];
			$m2=$_SERVER['argv'][7];

		}

		/*echo $y1;
		echo $y2;
		echo $m1;
		echo $m2;
		echo $id_product;
		echo $id_channel;
		echo $id_dist;*/
		$sql = "update job set state=1 where id_job=4";
		mysqli_query($link, $sql);

		$result2="<table border=1 class='table table-sm table-bordered table-striped' style='font-size:12px'>";
						
		$id_dist = explode(",", $id_dist2);

		$sum="sum(sales_value+retur_value)";
		
		$channel = array("1 HOSPITAL", "2 PHARMACY", "3 DRUGSTORE", "4 INSTITUTION", "5 MTC", "6 PHARMA CHAIN", "7 GT & OTHERS", "8 PBF","TOTAL");
		$distributor = array();

		$sql="select id_dist, code from distributor order by id_dist";
		if($result = mysqli_query($link, $sql))
		{
			$i = 0;
			while($row2 = mysqli_fetch_array($result))
			{	
				$distributor[$i] = $row2['code'];	
				$i = $i + 1;
			}
		}
		
		$result2 = $result2."<tr><th scope='col' style='text-align:center'>Customer Code</th><th scope='col' style='text-align:center'>Customer Name</th>";
		foreach ($id_dist as &$value)
		{
			$result2 = $result2."<th scope='col' style='text-align:center'>".$distributor[$value-1]."</th>";
		}
		foreach ($id_dist as &$value)
		{
			$result2 = $result2."<th scope='col' style='text-align:center'>".$distributor[$value-1]."</th>";
		}
		$result2=$result2."</tr>";
			
//		$sql="select distinct a.id_cust_profile, a.name from customer_profile a, customer_profile_cust b, channel c, customer d where b.id_cust=d.id_cust and a.id_cust_profile=b.id_cust_profile and c.id_channel=d.id_channel and d.id_dist in (".$id_dist2.") and c.big in (".$id_channel.") order by type, name limit 100";
		$sql="select distinct a.id_cust_profile, a.name from customer_profile a limit 100";
		if($result = mysqli_query($link, $sql))
		{
			while($row2 = mysqli_fetch_array($result))
			{
				$result2=$result2."<tr>";
				$result2=$result2."<td>".$row2['id_cust_profile']."</td>";
				$result2=$result2."<td>".$row2['name']."</td>";
				foreach ($id_dist as &$value)
				{
					$result2=$result2."<td>";
					/*$i = 0;
					$sql2="select id_cust2, a.name as customer_name, c.name as branch_name, d.name as channel_name, city from customer a, customer_profile_cust b, branch c, channel d where a.id_channel=d.id_channel and a.id_branch=c.id_branch and a.id_cust=b.id_cust and a.id_dist='".$value."' and b.id_cust_profile='".$row2['id_cust_profile']."'";
					if($result3 = mysqli_query($link, $sql2))
					{
						while($row3 = mysqli_fetch_array($result3))
						{
							if($i==0)
							{
								$result2=$result2."<table border=1 width=100%>";
								$result2=$result2."<tr>";
								$result2=$result2."<td width='15%' style='text-align:center'>Identity</td>";
								$result2=$result2."<td width='40%' style='text-align:center'>Name</td>";
								$result2=$result2."<td width='15%' style='text-align:center'>City</td>";
								$result2=$result2."<td width='15%' style='text-align:center'>Branch</td>";
								$result2=$result2."<td width='15%' style='text-align:center'>Channel</td>";
								$result2=$result2."</tr>";
							}						
							$result2=$result2."<tr>";
							$result2=$result2."<td>".$row3['id_cust2']."</td>";
							$result2=$result2."<td>".$row3['customer_name']."</td>";
							$result2=$result2."<td>".$row3['city']."</td>";
							$result2=$result2."<td>".$row3['branch_name']."</td>";
							$result2=$result2."<td>".$row3['channel_name']."</td>";
							$result2=$result2."</tr>";
							$i = $i + 1;
						}	
					}
					if($i>0)
					{
						$result2=$result2."</table>";
					}*/	
					$result2=$result2."</td>";
				}

				foreach ($id_dist as &$value)
				{
					$sql2="select sum(sales_value+retur_value) as average from invoice_sum_profile where id_dist='".$value."' and id_product in (".$id_product.") and period between '".$y1.str_pad($m1,2,"0",STR_PAD_LEFT)."' and '".$y2.str_pad($m2,2,"0",STR_PAD_LEFT)."' and id_cust_profile='".$row2['id_cust_profile']."'";
					if($result3 = mysqli_query($link, $sql2))
					{
						while($row3 = mysqli_fetch_array($result3))
						{
							$result2=$result2."<td>".$row3['average']."</td>";
						}	
					}
				}	
				$result2=$result2."</tr>";
			}	
		}	
		
		$result2=$result2."</table>";

//		echo $result2."|".$labels.$datasets;
		
		$sql = "update job set state=0 where id_job=4";
		mysqli_query($link, $sql);

//		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//		$objWriter->save('/home/crmtaisho/public_html/assets/uploads/'.$filename.'.xlsx');

		$myfile = fopen('/home/crmtaisho/public_html/assets/uploads/'.$filename.'.txt', "w") or die("Unable to open file!");
		$txt = "John Doe\n";
		fwrite($myfile, $result2);
		fclose($myfile);
	}	
 		
}

$reportcustomersales = new ReportCustomerSales;


?>