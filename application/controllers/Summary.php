<?php 

//if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Summary
{

		public function __construct()
		{
			$servername = "localhost";
			$username = "crmtaisho_taisho";
			$database = "crmtaisho_taisho";
			$password = "@b4d)S7ph1";
			$link = new mysqli($servername, $username, $password, $database);
//			ini_set('memory_limit','768M');

//			echo "xxx";
			if ($link->connect_error) {
				die("Connection failed: " . $link->connect_error);
			}

			$sql = "truncate table invoice_sum";
			if(mysqli_query($link, $sql))						
			{
			}
			else
			{
				echo "Error Truncate";
			}				

			$sql = "truncate table additional_customer";
			if(mysqli_query($link, $sql))						
			{
			}
			else
			{
				echo "Error Truncate";
			}				

/*			$sql = "truncate table customer_profile";
			if(mysqli_query($link, $sql))						
			{
			}
			else
			{
				echo "Error Truncate";
			}				*/

			/*$sql = "truncate table customer_profile_cust";
			if(mysqli_query($link, $sql))						
			{
			}
			else
			{
				echo "Error Truncate";
			}*/				

			$sql = "truncate table invoice_profile";
			if(mysqli_query($link, $sql))						
			{
			}
			else
			{
				echo "Error Truncate";
			}				

			$sql = "truncate table invoice_sum_profile";
			if(mysqli_query($link, $sql))						
			{
			}
			else
			{
				echo "Error Truncate";
			}				


			$sql = "update job set state=1 where id_job=1";
			mysqli_query($link, $sql);

			$sql2 = "insert into invoice_sum (qty_sales, sales_value, sales_discount, retur_qty, retur_value, retur_discount, id_cust, id_product, period) SELECT sum(qty_sales), sum(sales_value), sum(sales_discount), sum(retur_qty), sum(retur_value), sum(retur_discount), id_cust, id_product, substring(period,1,6) FROM invoice group by id_cust, substring(period,1,6), id_product";
			if(mysqli_query($link, $sql2))						
			{
			}				
			else
			{
				echo "Error Insert";
			}


			$sql2 = "insert into additional_customer (id_cust, period) select id_cust, min(period) from invoice_sum group by id_cust";
			if(mysqli_query($link, $sql2))						
			{
			}				
			else
			{
				echo "Error Insert";
			}

			
			$sql3 = "select distinct c.id_cust_profile, id_cust from customer a, channel b, customer_profile c where a.group_customer=c.profile_name and a.id_channel=b.id_channel and big not in (5) and trim(group_customer) not in ('','Not assigned','-','(blank)','NON GROUP') and a.id_cust_profile=0 and type=1";
			if($result3 = mysqli_query($link, $sql3))
			{
				while($row3 = mysqli_fetch_array($result3))
				{
					$sql2 = "update customer set id_cust_profile='".$row3['id_cust_profile']."' where id_cust='".$row3['id_cust']."'";
					if(mysqli_query($link, $sql2))
					{
					}				
					else
					{
						echo "Error Insert";
					}
				}
			}	


			$sql3 = "select distinct c.id_cust_profile, id_cust from customer a, channel b, customer_profile c where a.group_customer=c.profile_name and a.id_channel=b.id_channel and big not in (5) and trim(group_customer) not in ('','Not assigned','-','(blank)','NON GROUP') and a.id_cust_profile=0 and type=1";
			if($result3 = mysqli_query($link, $sql3))
			{
				while($row3 = mysqli_fetch_array($result3))
				{
					$sql2 = "update customer set id_cust_profile='".$row3['id_cust_profile']."' where id_cust='".$row3['id_cust']."'";
					if(mysqli_query($link, $sql2))						
					{
					}				
					else
					{
						echo "Error Insert";
					}
				}
			}	
			
			$sql3 = "select distinct b.id_cust_profile, id_cust from customer a, customer_profile b where trim(a.npwp)=b.profile_name and length(npwp)=20 and replace(replace(npwp,'.',''),'-','') not like concat('%',id_cust2,'%') and a.id_cust_profile=0 and type=2";
			if($result3 = mysqli_query($link, $sql3))
			{
				while($row3 = mysqli_fetch_array($result3))
				{
					$sql2 = "update customer set id_cust_profile='".$row3['id_cust_profile']."' where id_cust='".$row3['id_cust']."'";
					if(mysqli_query($link, $sql2))						
					{
					}				
					else
					{
						echo "Error Insert";
					}
				}
			}	


			$sql3 = "select distinct npwp from customer where length(npwp)=20 and id_cust_profile=0";
			if($result3 = mysqli_query($link, $sql3))
			{
				while($row3 = mysqli_fetch_array($result3))
				{
					$sql2 = "select distinct name from customer where npwp='".$row3['npwp']."' limit 1";
					if($result2 = mysqli_query($link, $sql2))
					{
						while($row2 = mysqli_fetch_array($result2))
						{
							$sql4 = "insert into customer_profile (type, profile_name, master_name) values ('2','".$row3['npwp']."','".$row2['name']."')";
							if(mysqli_query($link, $sql4))						
							{
							}				
							else
							{
								echo "Error Insert";
							}
						}	
					}
				}	
			}	

			$sql2 = "insert into invoice_profile (qty_sales, sales_value, sales_discount, retur_qty, retur_value, retur_discount, id_cust, period, id_product, id_cust_profile, id_dist) SELECT qty_sales, sales_value, sales_discount, retur_qty, retur_value, retur_discount, a.id_cust, period, id_product, id_cust_profile, c.id_dist FROM invoice_sum a, customer c where a.id_cust=c.id_cust and id_cust_profile<>0";
			if(mysqli_query($link, $sql2))						
			{
			}				
			else
			{
				echo "Error Insert";
			}

			$sql2 = "insert into invoice_sum_profile (qty_sales, sales_value, sales_discount, retur_qty, retur_value, retur_discount, id_cust_profile, id_product, period, id_dist) SELECT sum(qty_sales), sum(sales_value), sum(sales_discount), sum(retur_qty), sum(retur_value), sum(retur_discount), id_cust_profile, id_product, period, id_dist FROM invoice_profile group by id_cust_profile, period, id_product, id_dist";
			if(mysqli_query($link, $sql2))						
			{
			}				
			else
			{
				echo "Error Insert";
			}

			$sql = "update job set state=0 where id_job=1";
			mysqli_query($link, $sql);

			$sql = "analyze table invoice_sum";
			mysqli_query($link, $sql);

			$sql = "analyze table invoice_sum_profile";
			mysqli_query($link, $sql);

		}		
	
}


$summary = new Summary;

?>