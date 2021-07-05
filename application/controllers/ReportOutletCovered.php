<?php 

//if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "/home/crmtaisho/public_html/application/third_party/PHPExcel.php";

class ReportOutletCovered
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

		$filename="ReportOutletCovered";

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
		$sql = "update job set state=1 where id_job=3";
		mysqli_query($link, $sql);

		$result2="";
		$total = array();
				
		$labels="{\"labels\": [";	
		$datasets="\"datasets\": [";

		$month = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec");
		for($j=$y1;$j<=$y2;$j++)
		{
			if($y1==$y2)
			{
				for($i=$m1;$i<=$m2;$i++)
				{	
					$labels=$labels."\"".$j."-".$month[$i-1]."\",";
				}	
			}
			else
			{		
				if($j==$y1)
				{
					for($i=$m1;$i<=12;$i++)
					{	
						$labels=$labels."\"".$j."-".$month[$i-1]."\",";
					}	
				}
				else if($j==$y2)
				{
					for($i=1;$i<=$m2;$i++)
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
		
		$id_dist = explode(",", $id_dist2);

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
				$datasets=$datasets."\"fill\":true,";
				$datasets=$datasets."\"type\":\"line\",";
				$datasets=$datasets."\"yAxisID\":\"line-stacked\",";
				$datasets=$datasets."\"borderColor\":\"".$colour[$value-1]."\",";
				$datasets=$datasets."\"backgroundColor\":\"".$colour[$value-1]."33\",";


				$datasets=$datasets."\"data\": [";

			$id_cust="";
			$sql="select distinct id_cust from channel a, customer b where a.id_channel=b.id_channel and b.id_dist in (".$value.") and a.big in (".$id_channel.")";
			if($result = mysqli_query($link, $sql))
			{
				while($row2 = mysqli_fetch_array($result))
				{
					$id_cust=$id_cust."'".$row2['id_cust']."',";				
				}
			}	
			$id_cust=$id_cust."''";

			$total_awal = array();
			$sql="select distinct id_cust from invoice_sum where sales_value>0 and id_product in (".$id_product.") and id_cust in (".$id_cust.") and period between '201701' and '".$y1.str_pad(($m1),2,"0",STR_PAD_LEFT)."'";
			if($result = mysqli_query($link, $sql))
			{
				while($row2 = mysqli_fetch_array($result))
				{
					array_push($total_awal,$row2['id_cust']);
				}	
			}

			for($i=$y1;$i<=$y2;$i++)
			{	
	//			$id_cust=rtrim($id_cust,",");

				if($y2==$y1)
				{	
						for($j=$m1;$j<=$m2;$j++)
						{
							if(!isset($total[$k]))	
							{	
								$total[$k]=0;
							}	
							$sql="select distinct id_cust from invoice_sum where sales_value>0 and id_product in (".$id_product.") and id_cust in (".$id_cust.") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'";
							if($result = mysqli_query($link, $sql))
							{
								while($row2 = mysqli_fetch_array($result))
								{
									array_push($total_awal,$row2['id_cust']);
								}	
							}
							$datasets=$datasets."\"".sizeof(array_unique($total_awal))."\",";
							$result2=$result2.number_format(sizeof(array_unique($total_awal)),2).";";
							$total[$k] = $total[$k] + sizeof(array_unique($total_awal));
							$k = $k + 1;
						}
				}
				else
				{	
					if($i==$y1)
					{	
						for($j=$m1;$j<=12;$j++)
						{
							if(!isset($total[$k]))	
							{	
								$total[$k]=0;
							}	
							$sql="select distinct id_cust from invoice_sum where sales_value>0 and id_product in (".$id_product.") and id_cust in (".$id_cust.") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'";
							if($result = mysqli_query($link, $sql))
							{
								while($row2 = mysqli_fetch_array($result))
								{
									array_push($total_awal,$row2['id_cust']);
								}	
							}
							$datasets=$datasets."\"".sizeof(array_unique($total_awal))."\",";
							$result2=$result2.number_format(sizeof(array_unique($total_awal)),2).";";
							$total[$k] = $total[$k] + sizeof(array_unique($total_awal));
							$k = $k + 1;
						}
						
					}	
					else if($i==$y2)
					{	
						for($j=1;$j<=$m2;$j++)
						{
							if(!isset($total[$k]))
							{	
								$total[$k]=0;
							}	
							$sql="select distinct id_cust from invoice_sum where sales_value>0 and id_product in (".$id_product.") and id_cust in (".$id_cust.") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'";
							if($result = mysqli_query($link, $sql))
							{
								while($row2 = mysqli_fetch_array($result))
								{
									array_push($total_awal,$row2['id_cust']);
								}	
							}
							$datasets=$datasets."\"".sizeof(array_unique($total_awal))."\",";
							$result2=$result2.number_format(sizeof(array_unique($total_awal)),2).";";
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
							$sql="select distinct id_cust from invoice_sum where sales_value>0 and id_product in (".$id_product.") and id_cust in (".$id_cust.") and period='".$i.str_pad($j,2,"0",STR_PAD_LEFT)."'";
							if($result = mysqli_query($link, $sql))
							{
								while($row2 = mysqli_fetch_array($result))
								{
									array_push($total_awal,$row2['id_cust']);
								}	
							}
							$datasets=$datasets."\"".sizeof(array_unique($total_awal))."\",";
							$result2=$result2.number_format(sizeof(array_unique($total_awal)),2).";";
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
			$result2=$result2.number_format($total[$l],2).";";
		}

		$result2=rtrim($result2, ";");
		$result2=str_replace(".00","",$result2);

		$labels=rtrim($labels,",");
		$datasets=rtrim($datasets,",");
		$labels=$labels."],";	
		$datasets=$datasets."]}";

//		echo $result2."|".$labels.$datasets;
		
		$sql = "update job set state=0 where id_job=3";
		mysqli_query($link, $sql);

//		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//		$objWriter->save('/home/crmtaisho/public_html/assets/uploads/'.$filename.'.xlsx');

		$myfile = fopen('/home/crmtaisho/public_html/assets/uploads/'.$filename.'.txt', "w") or die("Unable to open file!");
		$txt = "John Doe\n";
		fwrite($myfile, $result2."|".$labels.$datasets);
		fclose($myfile);
	}	
 		
}

$reportoutletcovered = new ReportOutletCovered;


?>