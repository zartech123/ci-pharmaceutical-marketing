<?php 

//if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Summary2
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

			$x = 0;
			while($x<=50000)
			{
				$sql3 = "select id_cust_profile, id_cust from customer_profile_cust limit 1";
				if($result3 = mysqli_query($link, $sql3))
				{
					while($row3 = mysqli_fetch_array($result3))
					{
						$sql = "update customer set id_cust_profile='".$row3['id_cust_profile']."' where id_cust='".$row3['id_cust']."'";
						mysqli_query($link, $sql);
					}
				}	
				$x = $x + 1;
			}				



		}		
	
}


$summary = new Summary2;

?>