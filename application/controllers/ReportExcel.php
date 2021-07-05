<?php 

//if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "/home/crmtaisho/public_html/application/third_party/PHPExcel.php";

class ReportExcel extends PHPExcel  
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

		$filename="DetailReportNonActiveOutlet";

		unlink('/home/crmtaisho/public_html/assets/uploads/'.$filename.'.xlsx');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel
			->getProperties()
			->setCreator("E-Sponsorship Administrator")
			->setLastModifiedBy("E-Sponsorship Administrator");
			
		$objPHPExcel->setActiveSheetIndex(0);
		$sheet = $objPHPExcel->getActiveSheet();	

		$month= array(
			'Jan',
			'Feb',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'Sept',
			'Oct',
			'Nov',
			'Dec'
		);

		$headerColumns= array(
			'Product Group',
			'Customer Code',
			'Customer Name',
			'Channel',
			'Customer Address',
			'Branch Name'
		);

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

		/*echo $y1;
		echo $y2;
		echo $m1;
		echo $m2;
		echo $id_product;
		echo $id_channel;
		echo $id_dist;*/
		$sql = "update job set state=1 where id_job=2";
		mysqli_query($link, $sql);

		for($j=$y1;$j<=$y2;$j++)
		{
			if($y2==$y1)
			{
				array_push($headerColumns, "YTD Dec ".$j);
				array_push($headerColumns, "AVE SALES ".$j);
				array_push($headerColumns, "Active ".$j);
				array_push($headerColumns, "Non Active During L3M ".$y2);
				array_push($headerColumns, "Non Active During L6M ".$y2);
				for($i=$m1;$i<=$m2;$i++)
				{
					array_push($headerColumns, $month[$i-1]." ".$y1);
				}
			}
			else
			{	
				if($j==$y1)
				{	
					for($m=$y1;$m <= $y2; $m++)
					{	
						array_push($headerColumns, "YTD Dec ".$m);
						array_push($headerColumns, "AVE SALES ".$m);
						array_push($headerColumns, "Active ".$m);
					}	
					array_push($headerColumns, "Non Active During L3M ".$y2);
					array_push($headerColumns, "Non Active During L6M ".$y2);
					array_push($headerColumns, "Non Active During Jan ".($y2-1)." Until Present");
					for($i = $m1;$i<=12;$i++)
					{
						array_push($headerColumns, $month[$i-1]." ".$j);
					}
				}	
				else if($j==$y2)
				{	
					for($i = 1;$i<=$m2;$i++)
					{
						array_push($headerColumns, $month[$i-1]." ".$j);
					}
				}	
				else
				{	
					for($i=1;$i<=12;$i++)
					{
						array_push($headerColumns, $month[$i-1]." ".$j);
					}
				}	
			}	
		}	


		foreach ($headerColumns as $columnKey => $headerColumn) 
		{
			$sheet->setCellValueByColumnAndRow($columnKey, 1, $headerColumn);
		}
		$objPHPExcel->getActiveSheet()->getStyle('A1:'.$sheet->getHighestColumn().'1')->getFont()->setBold(true);
		$style = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);
		$objPHPExcel->getActiveSheet()->getStyle('A1:'.$sheet->getHighestColumn().'1')->applyFromArray($style);
		/*$sheet->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('428bca');
		$sheet->getStyle('B1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('428bca');
		$sheet->getStyle('C1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('428bca');
		$sheet->getStyle('D1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('428bca');
		$sheet->getStyle('E1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('428bca');
		$sheet->getStyle('F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('428bca');
		$sheet->getStyle('G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('428bca');*/


		$result  = "";
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
						

		$sum="sum(sales_value+retur_value)";
		
		$id_cust="";
		$id_group="";

		$character = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		
		$channel = array("1 HOSPITAL", "2 PHARMACY", "3 DRUGSTORE", "4 INSTITUTION", "5 MTC", "6 PHARMA CHAIN", "7 GT & OTHERS", "8 PBF","TOTAL");
		
		$k = 0;
		for($i=$y1;$i<=$y2;$i++)
		{	
			if($y1==$y2)
			{
				for($j=$m1;$j<=$m2;$j++)
				{
					$period[$k] = $i.str_pad($j,2,"0",STR_PAD_LEFT);
					$k = $k + 1;
				}	
			}
			else
			{
				if($i==$y1)
				{
					for($j=$m1;$j<=12;$j++)
					{	
						$period[$k] = $i.str_pad($j,2,"0",STR_PAD_LEFT);
						$k = $k + 1;
					}	
				}
				else if($i==$y2)
				{
					for($j=1;$j<=$m2;$j++)
					{	
						$period[$k] = $i.str_pad($j,2,"0",STR_PAD_LEFT);
						$k = $k + 1;
					}	
				}
				else
				{
					for($j=1;$j<=12;$j++)
					{	
						$period[$k] = $i.str_pad($j,2,"0",STR_PAD_LEFT);
						$k = $k + 1;
					}	
				}				
			}				
		}	

		$data = array();
		$data2 = array();

		//if($id_dist!="")
		//{
		//}			
		//else
		//{	
			$sql="select sum(sales_value+retur_value) as total, a.id_cust, id_cust2, period, b.name, b.address, big, d.name as branch_name, e.id_group, f.name as group_name from invoice_sum a, customer b, channel c, branch d, product e, product_group f where e.id_group=f.id_group and a.id_product=e.id_product and b.id_channel=c.id_channel and b.id_branch=d.id_branch and a.id_cust=b.id_cust and a.id_product in (".$id_product.") and b.id_dist in (2) and c.big in (".$id_channel.") and period between '".$y1.str_pad(1,2,"0",STR_PAD_LEFT)."' and '".$y2.str_pad($m2,2,"0",STR_PAD_LEFT)."' group by e.id_group, a.id_cust, period";
		//}	
//		echo $sql;
		if($result = mysqli_query($link, $sql))
		{
			$l = 2;
			while($row3 = mysqli_fetch_array($result))
			{
				$data[$row3['id_group']][$row3['id_cust']][$row3['period']]=$row3['total'];
				$period2 = substr($row3['period'],0,4);
				if(!isset($data2[$row3['id_group']][$row3['id_cust']][$period2]))
				{
					$data2[$row3['id_group']][$row3['id_cust']][$period2] = 0;
				}

				$data2[$row3['id_group']][$row3['id_cust']][$period2]=$data2[$row3['id_group']][$row3['id_cust']][$period2]+$row3['total'];

				if($id_cust=="")
				{
					$id_cust=$row3['id_cust'];
					$id_group=$row3['id_group'];
					$sheet->setCellValueByColumnAndRow(0, $l, $row3['group_name']);
					$sheet->setCellValueByColumnAndRow(1, $l, $row3['id_cust2']);
					$sheet->setCellValueByColumnAndRow(2, $l, $row3['name']);
					$sheet->setCellValueByColumnAndRow(3, $l, $channel[$row3['big']]);
					$sheet->setCellValueByColumnAndRow(4, $l, $row3['address']);
					$sheet->setCellValueByColumnAndRow(5, $l, $row3['branch_name']);
				}	
				if($id_cust==$row3['id_cust'] && $id_group==$row3['id_group'])
				{
				}
				else
				{
					$p = 0;
					if($y1==$y2)
					{
						$sheet->setCellValueByColumnAndRow(6, $l, $data2[$id_group][$id_cust][$y1]);
						$sheet->setCellValueByColumnAndRow(7, $l, $data2[$id_group][$id_cust][$y1]/$m2);
						if($data2[$id_group][$id_cust][$y1]>0)
						{	
							$sheet->setCellValueByColumnAndRow(8, $l, "1");
						}
						else
						{
							$sheet->setCellValueByColumnAndRow(8, $l, "-");
						}		
						$l3m = "1";		
						$l6m = "1";		
						$e=$k-2;
						if($e<=0)	$e=1;
						for($n=$k;$n>=$e;$n--)
						{
							$var = $period[$n-1];
							if(isset($data[$id_group][$id_cust][$var]))
							{
								$l3m = "-";		
								$l6m = "-";		
								break;
							}								
						}							
						if($l3m=="1")
						{
							$e=$k-5;
							if($e<=0)	$e=1;
							for($n=$k;$n>=$e;$n--)
							{
								$var = $period[$n-1];
								if(isset($data[$id_group][$id_cust][$var]))
								{
									$l6m = "-";		
									break;
								}								
							}							
						}							
						$sheet->setCellValueByColumnAndRow(9, $l, $l3m);
						$sheet->setCellValueByColumnAndRow(10, $l, $l6m);
						$p = 5;
						$m = 6;
					}
					else
					{
						$m = 6;
						for($i=$y1;$i<=$y2;$i++)
						{	
							if(isset($data2[$id_group][$id_cust][$i]))
							{	
								$sheet->setCellValueByColumnAndRow($m+$p, $l, $data2[$id_group][$id_cust][$i]);
								if($i==$y1)
								{
//									$divider = 12-$m1+1;
									$divider = 12;
								}							
								else if($i==$y2)
								{
									$divider = $m2;
								}							
								else
								{
									$divider = 12;
								}							
								$sheet->setCellValueByColumnAndRow($m+$p+1, $l, $data2[$id_group][$id_cust][$i]/$divider);
								if($data2[$id_group][$id_cust][$i]>0)
								{	
									$sheet->setCellValueByColumnAndRow($m+$p+2, $l, "1");
								}
								else
								{
									$sheet->setCellValueByColumnAndRow($m+$p+2, $l, "-");
								}
							}
							else
							{	
								$sheet->setCellValueByColumnAndRow($m+$p, $l, "0");
								$sheet->setCellValueByColumnAndRow($m+$p+1, $l, "0");
								$sheet->setCellValueByColumnAndRow($m+$p+2, $l, "-");
							}	
							$p = $p + 3;
						}
						$l3m = "1";		
						$l6m = "1";		
						$e=$k-2;
						if($e<=0)	$e=1;
						for($n=$k;$n>=$e;$n--)
						{
							$var = $period[$n-1];
							if(isset($data[$id_group][$id_cust][$var]))
							{
								$l3m = "-";		
								$l6m = "-";		
								break;
							}								
						}							
						if($l3m=="1")
						{
							$e=$k-5;
							if($e<=0)	$e=1;
							for($n=$k;$n>=$e;$n--)
							{
								$var = $period[$n-1];
								if(isset($data[$id_group][$id_cust][$var]))
								{
									$l6m = "-";		
									break;
								}								
							}							
						}							
						$sheet->setCellValueByColumnAndRow($m+$p, $l, $l3m);
						$sheet->setCellValueByColumnAndRow($m+$p+1, $l, $l6m);
						if((isset($data2[$id_group][$id_cust][$y2]) && $data2[$id_group][$id_cust][$y2]>0) || (isset($data2[$id_group][$id_cust][$y2-1]) && $data2[$id_group][$id_cust][$y2-1]>0))
						{	
							$sheet->setCellValueByColumnAndRow($m+$p+2, $l, "-");
						}	
						else
						{
							$sheet->setCellValueByColumnAndRow($m+$p+2, $l, "1");
						}							
						$p = $p + 3;
					}						
					for($j=0;$j<$k;$j++)
					{
						$var = $period[$j];
						if(isset($data[$id_group][$id_cust][$var]))
						{	
							$sheet->setCellValueByColumnAndRow($m+$p+$j, $l, $data[$id_group][$id_cust][$var]);
						}
						else
						{
							$sheet->setCellValueByColumnAndRow($m+$p+$j, $l, "0");
						}						
					}						
					$l = $l + 1;
					$id_cust=$row3['id_cust'];
					$id_group=$row3['id_group'];
					$sheet->setCellValueByColumnAndRow(0, $l, $row3['group_name']);
					$sheet->setCellValueByColumnAndRow(1, $l, $row3['id_cust2']);
					$sheet->setCellValueByColumnAndRow(2, $l, $row3['name']);
					$sheet->setCellValueByColumnAndRow(3, $l, $channel[$row3['big']]);
					$sheet->setCellValueByColumnAndRow(4, $l, $row3['address']);
					$sheet->setCellValueByColumnAndRow(5, $l, $row3['branch_name']);
				}									
			}
			if($y1==$y2)
			{
				$sheet->setCellValueByColumnAndRow(6, $l, $data2[$id_group][$id_cust][$y1]);
				$sheet->setCellValueByColumnAndRow(7, $l, $data2[$id_group][$id_cust][$y1]/$m2);
				if($data2[$id_group][$id_cust][$y1]>0)
				{	
					$sheet->setCellValueByColumnAndRow(8, $l, "1");
				}
				else
				{
					$sheet->setCellValueByColumnAndRow(8, $l, "1");
				}					
				$l3m = "1";		
				$l6m = "1";		
				for($n=$k;$n>=$k-2;$n--)
				{
					$var = $period[$n-1];
					if(isset($data[$id_group][$id_cust][$var]))
					{
						$l3m = "-";		
						$l6m = "-";		
						break;
					}								
				}							
				if($l3m=="1")
				{
					for($n=$k;$n>=$k-5;$n--)
					{
						$var = $period[$n-1];
						if(isset($data[$id_group][$id_cust][$var]))
						{
							$l6m = "-";		
							break;
						}								
					}							
				}							
				$sheet->setCellValueByColumnAndRow(9, $l, $l3m);
				$sheet->setCellValueByColumnAndRow(10, $l, $l6m);
			}
			else
			{
				$m = 6;
				for($i=$y1;$i<=$y2;$i++)
				{	
					if(isset($data2[$id_group][$id_cust][$i]))
					{	
						$sheet->setCellValueByColumnAndRow($m+$p, $l, $data2[$id_group][$id_cust][$i]);
						if($i==$y1)
						{
//							$divider = 12-$m1+1;
							$divider = 12;
						}							
						else if($i==$y2)
						{
							$divider = $m2;
						}							
						else
						{
							$divider = 12;
						}							
						$sheet->setCellValueByColumnAndRow($m+$p+1, $l, $data2[$id_group][$id_cust][$i]/$divider);
						if($data2[$id_group][$id_cust][$i]>0)
						{	
							$sheet->setCellValueByColumnAndRow($m+$p+2, $l, "1");
						}
						else
						{
							$sheet->setCellValueByColumnAndRow($m+$p+2, $l, "-");
						}					
					}
					else
					{			
						$sheet->setCellValueByColumnAndRow($m+$p, $l, "0");
						$sheet->setCellValueByColumnAndRow($m+$p+1, $l, "0");
						$sheet->setCellValueByColumnAndRow($m+$p+2, $l, "-");
					}	
					$p = $p + 3;
				}
				$l3m = "1";		
				$l6m = "1";		
				for($n=$k;$n>=$k-2;$n--)
				{
					$var = $period[$n-1];
					if(isset($data[$id_group][$id_cust][$var]))
					{
						$l3m = "-";		
						$l6m = "-";		
						break;
					}								
				}							
				if($l3m=="1")
				{
					for($n=$k;$n>=$k-5;$n--)
					{
						$var = $period[$n-1];
						if(isset($data[$id_group][$id_cust][$var]))
						{
							$l6m = "-";		
							break;
						}								
					}							
				}							
				$sheet->setCellValueByColumnAndRow($m+$p, $l, $l3m);
				$sheet->setCellValueByColumnAndRow($m+$p+1, $l, $l6m);
				if((isset($data2[$id_group][$id_cust][$y2]) && $data2[$id_group][$id_cust][$y2]>0) || (isset($data2[$id_group][$id_cust][$y2-1]) && $data2[$id_group][$id_cust][$y2-1]>0))
				{	
					$sheet->setCellValueByColumnAndRow($m+$p+2, $l, "-");
				}	
				else
				{
					$sheet->setCellValueByColumnAndRow($m+$p+2, $l, "1");
				}							
				$p = $p + 3;
			}						
			for($j=0;$j<$k;$j++)
			{
				$var = $period[$j];
				if(isset($data[$id_cust][$var]))
				{	
					$sheet->setCellValueByColumnAndRow($m+$p+$j, $l, $data[$id_group][$id_cust][$var]);
				}
				else
				{
					$sheet->setCellValueByColumnAndRow($m+$p+$j, $l, "0");
				}						
			}	
		}
		
		$sql = "update job set state=0 where id_job=2";
		mysqli_query($link, $sql);

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('/home/crmtaisho/public_html/assets/uploads/'.$filename.'.xlsx');


	}	
 		
}

$reportexcel = new ReportExcel;


?>