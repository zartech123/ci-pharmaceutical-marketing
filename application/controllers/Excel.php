<?php 

//if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "/home/crmtaisho/public_html/application/third_party/PHPExcel.php";

class Excel extends PHPExcel  
{

		public function __construct()
		{
			$servername = "localhost";
			$username = "crmtaisho_taisho";
			$database = "crmtaisho_taisho";
			$password = "@b4d)S7ph1";
			$link = new mysqli($servername, $username, $password, $database);
			ini_set('memory_limit','1024M');

//			echo "xxx";
			if ($link->connect_error) {
				die("Connection failed: " . $link->connect_error);
			}

			$id_upload="0";

//			echo $_SERVER['argv'][1]."xxx";
			if (isset($_SERVER['argv'])) 
			{
				$id_upload=$_SERVER['argv'][1];
			}

			$type="0";
			$file="";
			$id_dist="0";
			$is_npwp="1";
			$sql = "SELECT id_upload, type, file, id_dist FROM upload where state in (0,3) and id_upload='".$id_upload."'";
			if($result = mysqli_query($link, $sql))
			{
				while($row = mysqli_fetch_array($result))
				{
					$type=$row['type'];
					$file=$row['file'];
					$id_dist=$row['id_dist'];
					$id_upload=$row['id_upload'];
				}
			}
			
			$tmpfname = "/home/crmtaisho/public_html/assets/uploads/".$file;
			//echo $tmpfname;
			try 
			{
				$sql = "update upload set state=1 where id_upload='".$id_upload."'";
				mysqli_query($link, $sql);						
//				$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
//				$cacheSettings = array( 'memoryCacheSize' => '768MB');
//				PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
				$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
				$excelReader->setReadDataOnly(true);
				$excelObj = $excelReader->load($tmpfname);
				$worksheet = $excelObj->getSheet(0);
				$lastRow = $worksheet->getHighestRow();

				$sql2 = "INSERT INTO letter (content, id_upload) values (".$lastRow.",'".$id_upload."')";
				mysqli_query($link, $sql2);			

			} 
			catch(Exception $e) 
			{
				print_r($e);
				//echo('Error loading file "'.$tmpfname.'": '.$e->getMessage());
			}
			
			if($type=="1")
			{	
				$array_cust = array();
				$sql = "SELECT id_cust2 FROM customer";
				if($result = mysqli_query($link, $sql))
				{
					while($row = mysqli_fetch_array($result))
					{
						array_push($array_cust,$row['id_cust2']);
					}
				}	
	//			print_r ($array_cust);
				
				$array_branch = array();
				$sql2 = "SELECT id_branch, id_branch2 FROM branch where id_dist='".$id_dist."'";
				if($result2 = mysqli_query($link, $sql2))
				{
					while($row2 = mysqli_fetch_array($result2))
					{
						$array_branch[$row2['id_branch']]=$row2['id_branch2'];
					}
				}	

				$array_channel = array();
				$sql2 = "SELECT id_channel, trim(id_channel2) as id_channel2 FROM channel where id_dist='".$id_dist."'";
				if($result2 = mysqli_query($link, $sql2))
				{
					while($row2 = mysqli_fetch_array($result2))
					{
						$array_channel[$row2['id_channel']]=$row2['id_channel2'];
					}
				}	

				for ($row = 2; $row <= $lastRow; $row++) 
				{
					$id_cust2=trim($worksheet->getCell('A'.$row)->getValue());
					$name=str_replace("'","\'",trim($worksheet->getCell('B'.$row)->getValue()));
					$address=str_replace("'","\'",trim($worksheet->getCell('C'.$row)->getValue()));
					$id_channel=trim($worksheet->getCell('D'.$row)->getValue());
					$id_branch=trim($worksheet->getCell('F'.$row)->getValue());
					$phone=trim($worksheet->getCell('H'.$row)->getValue());
					$fax=trim($worksheet->getCell('I'.$row)->getValue());
					$city=trim($worksheet->getCell('J'.$row)->getValue());
					$postcode=trim($worksheet->getCell('K'.$row)->getValue());
					$npwp=trim($worksheet->getCell('L'.$row)->getValue());
					$group=trim($worksheet->getCell('M'.$row)->getValue());
					//$id_dist="2";
					if(in_array($id_cust2,$array_cust))
					{
						$sql = "update customer set city='".$city."', address='".$address."', phone2='".$phone."', fax='".$fax."', postcode2='".$postcode."', id_channel='".array_search($id_channel,$array_channel)."' where id_cust2='".$id_cust2."'";
						if(mysqli_query($link, $sql))						
						{
						}
					}
					else	
					{
						$npwp2 = preg_replace('/\./', '', $npwp);
						$npwp3 = preg_replace('/\-/', '', $npwp2);
						if(trim($npwp3)=="000000000000000" || $npwp3=="(blank)" || $npwp3=="")
						{
							$is_npwp="0";
//							$npwp="01.".substr($id_cust2,0,3).".".substr($id_cust2,3,3).".".substr($id_cust2,6,1)."-".substr($id_cust2,7,3).".000";
							$npwp="";
						}						
						$sql = "INSERT INTO customer (id_cust2, name, address, id_branch, phone2, fax, postcode2, npwp, city, id_dist, id_channel, group_customer, id_upload, is_npwp) VALUES ('".$id_cust2."', '".$name."', '".$address."','".array_search($id_branch,$array_branch)."', '".$phone."', '".$fax."', '".$postcode."', '".$npwp."', '".$city."', '".$id_dist."', '".array_search($id_channel,$array_channel)."', '".$group."', '".$id_upload."', '".$is_npwp."')";
						if(mysqli_query($link, $sql))						
						{
						}
						else
						{
							if(array_search($id_branch,$array_branch)=="")
							{
								$sql2 = "insert into pending_upload (id, type, id_upload) values ('".$id_branch."','1','".$id_upload."')";
								if(mysqli_query($link, $sql2))						
								{
								}
							}								

							if(array_search($id_channel,$array_channel)=="")
							{
								$sql2 = "insert into pending_upload (id, type, id_upload) values ('".$id_channel."','4','".$id_upload."')";
								if(mysqli_query($link, $sql2))						
								{
								}
							}								

	//						echo array_search($id_cust2,$array_cust);
							echo "INSERT INTO customer (id_cust2, name, address, id_branch, phone2, fax, postcode2, npwp, city, id_dist, id_channel, group_customer) VALUES ('".$id_cust2."', '".$name."', '".$address."','".array_search($id_branch,$array_branch)."', '".$phone."', '".$fax."', '".$postcode."', '".$npwp."', '".$city."', '".$id_dist."', '".$id_channel."', '".$group."');";
						}						
						
					}		
				}
				$sql = "update upload set state=2 where id_upload='".$id_upload."'";
				mysqli_query($link, $sql);						

				$sql = "update customer set npwp=concat(substr(npwp,1,2),'.',substr(npwp,3,3),'.',substr(npwp,6,3),'.',substr(npwp,9,1),'-',substr(npwp,10,3),'.',substr(npwp,13,3)) where npwp not like '%.%'";				
				mysqli_query($link, $sql);						
			}
			else if($type=="2")
			{	
				$array_cust = array();
				$sql = "SELECT id_cust, id_cust2 FROM customer";
				if($result = mysqli_query($link, $sql))
				{
					while($row = mysqli_fetch_array($result))
					{
						$array_cust[$row['id_cust']]=$row['id_cust2'];
					}
				}	
				
				$array_branch = array();
				$sql2 = "SELECT id_branch, id_branch2 FROM branch where id_dist='".$id_dist."'";
				if($result2 = mysqli_query($link, $sql2))
				{
					while($row2 = mysqli_fetch_array($result2))
					{
						$array_branch[$row2['id_branch']]=$row2['id_branch2'];
					}
				}

				$array_product = array();
				$sql3 = "SELECT id_product, id_product3 FROM product_dist where id_dist='".$id_dist."'";
				if($result3 = mysqli_query($link, $sql3))
				{
					while($row3 = mysqli_fetch_array($result3))
					{
						$array_product[$row3['id_product']]=$row3['id_product3'];
					}
				}	
//				print_r ($array_product);
				
				for ($row = 2; $row <= $lastRow; $row++) 
				{
					$id_product2=trim($worksheet->getCell('B'.$row)->getValue());
					$qty_sales=str_replace(",","",trim($worksheet->getCell('D'.$row)->getValue()));
					$sales_value=trim($worksheet->getCell('E'.$row)->getValue());
					$sales_disc=trim($worksheet->getCell('F'.$row)->getValue());
					$retur_qty=trim($worksheet->getCell('G'.$row)->getValue());
					$retur_value=trim($worksheet->getCell('H'.$row)->getValue());
					$retur_disc=trim($worksheet->getCell('I'.$row)->getValue());
					$period=trim($worksheet->getCell('J'.$row)->getValue());
					if(strlen($period)==7)
					{
						$period = substr_replace($period, '0', 4, 0);
					}						
					$id_cust2=trim($worksheet->getCell('K'.$row)->getValue());
					$id_branch=trim($worksheet->getCell('L'.$row)->getValue());
					$invoice_no=trim($worksheet->getCell('N'.$row)->getValue());
					//$id_dist="2";
						
						$id_product3 = array_search($id_product2,$array_product);
						if(trim($id_product3)=="")
						{
							$sql3 = "SELECT id_product FROM product_dist where id_product3='".$id_product2."'";
							if($result3 = mysqli_query($link, $sql3))
							{
								while($row3 = mysqli_fetch_array($result3))
								{
									$id_product3 = $row3['id_product'];
								}	
							}	
						}							
							
						$sql = "INSERT INTO invoice (id_product, qty_sales, sales_value, sales_discount, retur_qty, retur_value, retur_discount, period, id_cust, id_branch, invoice_no, id_dist, id_upload) VALUES ('".$id_product3."', '".$qty_sales."', '".$sales_value."', '".$sales_disc."', '".$retur_qty."', '".$retur_value."', '".$retur_disc."', '".$period."', '".array_search($id_cust2,$array_cust)."','".array_search($id_branch,$array_branch)."', '".$invoice_no."', '".$id_dist."', '".$id_upload."')";
						if(mysqli_query($link, $sql))						
						{
						}
						else
						{
							if(trim(array_search($id_branch,$array_branch))=="")
							{
								$sql2 = "insert into pending_upload (id, type, id_upload) values ('".$id_branch."','1','".$id_upload."')";
								if(mysqli_query($link, $sql2))						
								{
								}
							}								

							if(trim(array_search($id_cust2,$array_cust))=="")
							{
								$sql2 = "insert into pending_upload (id, type, id_upload) values ('".$id_cust2."','2','".$id_upload."')";
								if(mysqli_query($link, $sql2))						
								{
								}
							}
								
							if(trim(array_search($id_product2,$array_product))=="")
							{
								$sql2 = "insert into pending_upload (id, type, id_upload) values ('".$id_product2."','3','".$id_upload."')";
								if(mysqli_query($link, $sql2))						
								{
								}
							}								
	//						echo array_search($id_product2,$array_product).$id_product2;
							$sql = "'INSERT INTO invoice (id_product, qty_sales, sales_value, sales_discount, retur_qty, retur_value, retur_discount, period, id_cust, id_branch, invoice_no, id_dist, id_upload) VALUES ('".array_search($id_product2,$array_product)."', '".$qty_sales."', '".$sales_value."', '".$sales_disc."', '".$retur_qty."', '".$retur_value."', '".$retur_disc."', '".$period."', '".array_search($id_cust2,$array_cust)."','".array_search($id_branch,$array_branch)."', '".$invoice_no."', '".$id_dist."', '".$id_upload."')'";
							$sql2 = "INSERT INTO letter (content, id_upload) values (".$sql.",'".$id_upload."')";
							mysqli_query($link, $sql2);			
						}
						
				}
				$sql = "update upload set state=2 where id_upload='".$id_upload."'";
				mysqli_query($link, $sql);						

			}
			else if($type=="3")
			{					
				$array_branch = array();
				$sql2 = "SELECT id_branch, id_branch2 FROM branch";
				if($result2 = mysqli_query($link, $sql2))
				{
					while($row2 = mysqli_fetch_array($result2))
					{
						$array_branch[$row2['id_branch']]=$row2['id_branch2'];
					}
				}

				$array_product = array();
				$sql3 = "SELECT id_product, id_product3 FROM product_dist where id_dist='".$id_dist."'";
				if($result3 = mysqli_query($link, $sql3))
				{
					while($row3 = mysqli_fetch_array($result3))
					{
						$array_product[$row3['id_product']]=$row3['id_product3'];
					}
				}	
//				print_r ($array_product);
				
				for ($row = 2; $row <= $lastRow; $row++) 
				{
					$id_branch=trim($worksheet->getCell('A'.$row)->getValue());
					$id_product2=trim($worksheet->getCell('D'.$row)->getValue());
					$kemasan=trim($worksheet->getCell('F'.$row)->getValue());
					$price=trim($worksheet->getCell('G'.$row)->getValue());
					$batch_no=trim($worksheet->getCell('H'.$row)->getValue());
					$exp_date=trim($worksheet->getCell('I'.$row)->getValue());
					$qty=trim($worksheet->getCell('J'.$row)->getValue());
					$stock_baik=trim($worksheet->getCell('L'.$row)->getValue());
					$stock_rusak=trim($worksheet->getCell('M'.$row)->getValue());
					$stock_titip=trim($worksheet->getCell('N'.$row)->getValue());
					$stock_konsi=trim($worksheet->getCell('O'.$row)->getValue());
					$bdp=trim($worksheet->getCell('P'.$row)->getValue());
					$klasprod=trim($worksheet->getCell('Q'.$row)->getValue());
					$month=trim($worksheet->getCell('S'.$row)->getValue());
					$year=trim($worksheet->getCell('T'.$row)->getValue());
					$co_date=trim($worksheet->getCell('U'.$row)->getValue());
					//$id_dist="2";

					$id_product3 = array_search($id_product2,$array_product);
					if($id_product3=="")
					{
						$sql3 = "SELECT id_product FROM product_dist where id_product3='".$id_product2."'";
						if($result3 = mysqli_query($link, $sql3))
						{
							while($row3 = mysqli_fetch_array($result3))
							{
								$id_product3 = $row3['id_product'];
							}	
						}
					}							

						//$expArray = explode('/', $exp_date);
						//$exp_date = $expArray[2].'-'.str_pad($expArray[0],2,"0",STR_PAD_LEFT).'-'.str_pad($expArray[1],2,"0",STR_PAD_LEFT);
						//$coArray = explode('/', $co_date);
						//$co_date = $coArray[2].'-'.str_pad($coArray[0],2,"0",STR_PAD_LEFT).'-'.str_pad($coArray[1],2,"0",STR_PAD_LEFT);
						
						

					//id_branch, id_product, kemasan, price, batch_no, exp_date, qty, stock_baik, stock_rusak, stock_titip, stock_konsi, bdp, klasprod, period, co_date, id_upload 
						
						$sql = "INSERT INTO stock (id_dist, id_branch, id_product, kemasan, price, batch_no, exp_date, qty, stock_baik, stock_rusak, stock_titip, stock_konsi, bdp, klasprod, period, co_date, id_upload ) VALUES ('".$id_dist."','".array_search($id_branch,$array_branch)."', '".$id_product3."', '".$kemasan."', '".$price."', '".$batch_no."','".PHPExcel_Style_NumberFormat::toFormattedString($exp_date,'YYYY-MM-DD' )."', '".$qty."', '".$stock_baik."', '".$stock_rusak."','".$stock_titip."', '".$stock_konsi."', '".$bpd."', '".$klasprod."', '".$year.str_pad($month,2,"0",STR_PAD_LEFT)."','".PHPExcel_Style_NumberFormat::toFormattedString($co_date,'YYYY-MM-DD' )."', '".$id_upload."')";
						if(mysqli_query($link, $sql))						
						{
						}
						else
						{
							if(trim(array_search($id_branch,$array_branch))=="")
							{
								$sql2 = "insert into pending_upload (id, type, id_upload) values ('".$id_branch."','1','".$id_upload."')";
								if(mysqli_query($link, $sql2))						
								{
								}
							}								
								
							if(trim(array_search($id_product2,$array_product))=="")
							{
								$sql2 = "insert into pending_upload (id, type, id_upload) values ('".$id_product2."','3','".$id_upload."')";
								if(mysqli_query($link, $sql2))						
								{
								}
							}								
	//						echo array_search($id_product2,$array_product).$id_product2;
							$sql = "'INSERT INTO stock (id_product, qty_sales, sales_value, sales_discount, retur_qty, retur_value, retur_discount, period, id_cust, id_branch, invoice_no, id_dist, id_upload) VALUES ('".array_search($id_product2,$array_product)."', '".$qty_sales."', '".$sales_value."', '".$sales_disc."', '".$retur_qty."', '".$retur_value."', '".$retur_disc."', '".$period."', '".array_search($id_cust2,$array_cust)."','".array_search($id_branch,$array_branch)."', '".$invoice_no."', '".$id_dist."', '".$id_upload."')'";
							$sql2 = "INSERT INTO letter (content, id_upload) values (".$sql.",'".$id_upload."')";
							mysqli_query($link, $sql2);			
						}
						
				}
				$sql = "update upload set state=2 where id_upload='".$id_upload."'";
				mysqli_query($link, $sql);						

			}
		}
	
}


$excel = new Excel;

?>