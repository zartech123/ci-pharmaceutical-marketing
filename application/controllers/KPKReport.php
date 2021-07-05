<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KPKReport extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url','form');
		$this->load->library('email');

		$this->load->library('session');
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html

SELECT b.id_mer, '0' AS id_hco, '0' AS id_hcp2, '0' AS id_sc, '0' AS id_tl3, id_tl AS id_tl2, event_name, DATE_FORMAT(a.event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(a.event_end_date,'%d/%m/%Y') AS event_end_date, b.event_venue  FROM agreement_letter2 a, hcp b WHERE a.event_start_date like '".$_GET['year']."-".$_GET['month']."%' and a.id_hcp=b.id_hcp and state=6
UNION ALL
SELECT b.id_mer, '0' AS id_hco, '0' AS id_hcp2, '0' AS id_sc, id_tl AS id_tl3, '0' AS id_tl2, topic AS event_name, DATE_FORMAT(a.event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(a.event_end_date,'%d/%m/%Y') AS event_end_date, b.event_venue  FROM agreement_letter3 a, scientific b WHERE a.event_start_date like '".$_GET['year']."-".$_GET['month']."%' and a.id_sc=b.id_sc and state=6

UNION ALL
SELECT a.id_mer, '0' AS id_hco, '0' AS id_hcp2, '0' AS id_sc, '0' AS id_hcp, id_sc_hcp AS id_tl2, event_name, DATE_FORMAT(a.event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(a.event_end_date,'%d/%m/%Y') AS event_end_date, b.event_venue FROM scientific_report a, mer b WHERE a.id_mer=b.id_mer and b.state=7 and a.event_start_date like '".$_GET['year']."-".$_GET['month']."%'

	 */
	public function index()
	{
		$data2['kpk'] = array();
		$data2['month'] = $_GET['month'];
		$data2['year'] = $_GET['year'];
		if($_GET['month']=="01" || $_GET['month']=="03" || $_GET['month']=="05" || $_GET['month']=="07" || $_GET['month']=="08" || $_GET['month']=="10" || $_GET['month']=="12")
		{
			$max_date="31";
		}			
		else if($_GET['month']=="04" || $_GET['month']=="06" || $_GET['month']=="09" || $_GET['month']=="11")
		{
			$max_date="30";
		}			
		else if($_GET['month']=="02" && (($_GET['year'] % 4)==0))
		{
			$max_date="29";
		}
		else
		{
			$max_date="28";
		}			
			$query = $this->db->query("SELECT DISTINCT id_mer, id_hco, id_hcp2, id_sc, id_hcp, id_tl2, event_name, event_start_date, event_end_date, event_venue FROM (
SELECT a.id_mer, '0' AS id_hco, b.id_hcp2, '0' AS id_sc, '0' AS id_hcp, '0' AS id_tl2, b.event_name, DATE_FORMAT(b.event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(b.event_end_date,'%d/%m/%Y') AS event_end_date, b.event_venue FROM mer a, hcp_report b WHERE b.event_end_date>='".$_GET['year']."-".$_GET['month']."-01' and b.event_end_date<='".$_GET['year']."-".$_GET['month']."-".$max_date."' AND a.id_mer=b.id_mer 
UNION ALL
SELECT a.id_mer, '0' AS id_hco, '0' as id_hcp2, '0' AS id_sc, id_hcp, '0' AS id_tl2, b.event_name, DATE_FORMAT(b.event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(b.event_end_date,'%d/%m/%Y') AS event_end_date, b.event_venue FROM mer a, hcp_report2 b WHERE b.event_end_date>='".$_GET['year']."-".$_GET['month']."-01' and b.event_end_date<='".$_GET['year']."-".$_GET['month']."-".$max_date."' AND a.id_mer=b.id_mer 
UNION ALL
SELECT a.id_mer, '0' AS id_hco, '0' AS id_hcp2, b.id_sc, '0' AS id_hcp, '0' AS id_tl2, b.topic as event_name, DATE_FORMAT(a.event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(a.event_end_date,'%d/%m/%Y') AS event_end_date, b.event_venue FROM mer a, scientific_report b, budget_scientific_report c WHERE b.event_end_date>='".$_GET['year']."-".$_GET['month']."-01' and b.event_end_date<='".$_GET['year']."-".$_GET['month']."-".$max_date."' and sponsor_type like '%Institution%' and replace(actualb,'.','')>0 and b.id_report=c.id_parent AND a.id_mer=b.id_mer
UNION ALL
SELECT a.id_mer, '0' AS id_hco, '0' AS id_hcp2, b.id_sc, '0' AS id_hcp, '0' AS id_tl2, b.topic as event_name, DATE_FORMAT(a.event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(a.event_end_date,'%d/%m/%Y') AS event_end_date, b.event_venue FROM mer a, scientific_report b, budget_scientific_report c WHERE b.event_end_date>='".$_GET['year']."-".$_GET['month']."-01' and b.event_end_date<='".$_GET['year']."-".$_GET['month']."-".$max_date."' and sponsor_type like '%Association%' and replace(actualb,'.','')>0 and b.id_report=c.id_parent AND a.id_mer=b.id_mer
UNION ALL
SELECT a.id_mer, b.id_hco, '0' AS id_hcp2, '0' AS id_sc, '0' AS id_hcp, '0' AS id_tl2, b.event_name, DATE_FORMAT(a.event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(a.event_end_date,'%d/%m/%Y') AS event_end_date, b.event_venue FROM mer a, hco_report b WHERE a.event_end_date>='".$_GET['year']."-".$_GET['month']."-01' and a.event_end_date<='".$_GET['year']."-".$_GET['month']."-".$max_date."' AND a.state=7 AND a.id_mer=b.id_mer 
UNION ALL
SELECT distinct c.id_mer, '0' AS id_hco, '0' AS id_hcp2, a.id_sc, '0' AS id_hcp, a.id_sc_hcp AS id_tl2, event_name, DATE_FORMAT(c.event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(c.event_end_date,'%d/%m/%Y') AS event_end_date, b.event_venue FROM scientific_hcp a, mer b, scientific_report c WHERE c.id_mer=b.id_mer and a.id_sc=c.id_sc and a.type=2 and c.event_end_date>='".$_GET['year']."-".$_GET['month']."-01' and c.event_end_date<='".$_GET['year']."-".$_GET['month']."-".$max_date."'
) AS X");

			$i = 0;
			foreach ($query->result() as $row2)
			{
				$data = array(
					'id_mer' => $row2->id_mer,
					'event_name' => $row2->event_name,
					'event_venue' => $row2->event_venue,
					'event_start_date' => $row2->event_start_date,
					'event_end_date' => $row2->event_end_date
                );
//				$data = array_merge($data, array('month'=>$_GET['month']));
                
				$data = array_merge($data, array('registration'=>"0"));
				$data = array_merge($data, array('travel'=>"0"));
				$data = array_merge($data, array('honor'=>"0"));
				$data = array_merge($data, array('nominal'=>"0"));
				$data = array_merge($data, array('accommodation'=>"0"));
				if($row2->id_hcp2!="0")
				{
					$query2 = $this->db->query("SELECT sum(replace(actual,'.','')) as actual, kpk FROM hcp_report a, budget_hcp_report b WHERE a.id_report=b.id_parent and kpk<6 AND id_hcp2=".$row2->id_hcp2." group by kpk");
					foreach ($query2->result() as $row3)
					{
						if($row3->kpk=="1")
						{
							$data = array_merge($data, array('registration'=>$row3->actual));
						}
						else if($row3->kpk=="3")
						{
							$data = array_merge($data, array('travel'=>$row3->actual));
						}
						else if($row3->kpk=="4")
						{
							$data = array_merge($data, array('honor'=>$row3->actual));
						}
						else if($row3->kpk=="5")
						{
							$data = array_merge($data, array('nominal'=>$row3->actual));
						}
						else if($row3->kpk=="2")
						{
							$data = array_merge($data, array('accommodation'=>$row3->actual));
						}
					}
				}
				if($row2->id_hco!="0")
				{
					$query2 = $this->db->query("SELECT sum(replace(actual,'.','')) as actual, kpk FROM hco_report a, budget_hco_report b WHERE a.id_report=b.id_parent and kpk<6 AND id_hco=".$row2->id_hco." group by kpk");
					foreach ($query2->result() as $row3)
					{
						if($row3->kpk=="1")
						{
							$data = array_merge($data, array('registration'=>$row3->actual));
						}
						else if($row3->kpk=="3")
						{
							$data = array_merge($data, array('travel'=>$row3->actual));
						}
						else if($row3->kpk=="4")
						{
							$data = array_merge($data, array('honor'=>$row3->actual));
						}
						else if($row3->kpk=="5")
						{
							$data = array_merge($data, array('nominal'=>$row3->actual));
						}
						else if($row3->kpk=="2")
						{
							$data = array_merge($data, array('accommodation'=>$row3->actual));
						}
					}
				}
				if($row2->id_hcp!="0")
				{
					$query2 = $this->db->query("SELECT sum(replace(actual,'.','')) as actual, kpk FROM hcp_report2 a, budget_hcp_report2 b WHERE a.id_report=b.id_parent and kpk<6 and id_hcp=".$row2->id_hcp." group by kpk");
					foreach ($query2->result() as $row3)
					{
						if($row3->kpk=="1")
						{
							$data = array_merge($data, array('registration'=>$row3->actual));
						}
						else if($row3->kpk=="3")
						{
							$data = array_merge($data, array('travel'=>$row3->actual));
						}
						else if($row3->kpk=="4")
						{
							$data = array_merge($data, array('honor'=>$row3->actual));
						}
						else if($row3->kpk=="5")
						{
							$data = array_merge($data, array('nominal'=>$row3->actual));
						}
						else if($row3->kpk=="2")
						{
							$data = array_merge($data, array('accommodation'=>$row3->actual));
						}
					}
				}
				$data = array_merge($data, array('event_institution'=>""));
				$data = array_merge($data, array('doctor'=>""));
				$data = array_merge($data, array('id_hcp2'=>"0"));
				$data = array_merge($data, array('id_hcp'=>"0"));
				$data = array_merge($data, array('id_tl2'=>"0"));
				if($row2->id_tl2!="0")
				{
					$query2 = $this->db->query("SELECT fee_hcp, b.name as doctor, c.name as hospital FROM scientific_hcp a, doctor b, hospital c WHERE a.name_hcp=b.id_doctor and a.institution_hcp=c.id_hospital and id_sc_hcp=".$row2->id_tl2);
					foreach ($query2->result() as $row3)
					{
						$data = array_merge($data, array('honor'=>$row3->fee_hcp));
						$data = array_merge($data, array('doctor'=>$row3->doctor));
						$data = array_merge($data, array('id_tl2'=>$row2->id_tl2));
						$data = array_merge($data, array('event_institution'=>$row3->hospital));
					}
				}

				$data = array_merge($data, array('event_organizer'=>""));
				$data = array_merge($data, array('speciality'=>""));
				$data = array_merge($data, array('id_hco'=>"0"));
				if($row2->id_hco!="0")
				{
					$query2 = $this->db->query("SELECT event_organizer FROM hco_report WHERE id_hco='".$row2->id_hco."'");
					foreach ($query2->result() as $row3)
					{
						$data = array_merge($data, array('id_hco'=>$row2->id_hco));
						$data = array_merge($data, array('event_organizer'=>$row3->event_organizer));
					}
				}	

				if($row2->id_hcp2!="0")
				{
					$query2 = $this->db->query("SELECT a.id_hcp2, b.name, concat(e.name,', ',address) as address, name_speciality FROM hcp2 a, doctor b, hcp_report c, speciality d, hospital e WHERE a.event_institution=e.id_hospital and b.id_speciality=d.id_speciality and c.id_hcp2=a.id_hcp2 AND a.doctor=b.id_doctor AND a.id_hcp2='".$row2->id_hcp2."'");
					foreach ($query2->result() as $row3)
					{
						$data = array_merge($data, array('speciality'=>$row3->name_speciality));
						$data = array_merge($data, array('event_institution'=>$row3->address));
						$data = array_merge($data, array('doctor'=>$row3->name));
						$data = array_merge($data, array('id_hcp2'=>$row2->id_hcp2));
					}
				}

				if($row2->id_hcp!="0")
				{
					$query2 = $this->db->query("SELECT c.id_hcp, b.name, concat(e.name,', ',address) as address, name_speciality FROM hcp a, doctor b, hcp_report2 c, speciality d, hospital e WHERE a.event_institution=e.id_hospital and b.id_speciality=d.id_speciality and .a.id_hcp=c.id_hcp and c.hcp=b.id_doctor AND a.id_hcp='".$row2->id_hcp."'");
					foreach ($query2->result() as $row3)
					{
						$data = array_merge($data, array('speciality'=>$row3->name_speciality));
						$data = array_merge($data, array('event_institution'=>$row3->address));
						$data = array_merge($data, array('doctor'=>$row3->name));
						$data = array_merge($data, array('id_hcp'=>$row2->id_hcp));
					}
				}

				$data = array_merge($data, array('id_sc'=>"0"));
				if($row2->id_sc!="0")
				{
					$query2 = $this->db->query("SELECT kpk, sum(replace(actualb,'.','')) AS actual, sponsor_type FROM scientific_report a, budget_scientific_report b, scientific c WHERE a.id_sc=c.id_sc AND a.id_report=b.id_parent and a.id_sc='".$row2->id_sc."'");
					foreach ($query2->result() as $row3)
					{
						if($row3->kpk=="1")
						{
							$data = array_merge($data, array('registration'=>$row3->actual));
						}
						else if($row3->kpk=="3")
						{
							$data = array_merge($data, array('travel'=>$row3->actual));
						}
						else if($row3->kpk=="4")
						{
							$data = array_merge($data, array('honor'=>$row3->actual));
						}
						else if($row3->kpk=="5")
						{
							$data = array_merge($data, array('nominal'=>$row3->actual));
						}
						else if($row3->kpk=="2")
						{
							$data = array_merge($data, array('accommodation'=>$row3->actual));
						}
						if(trim($row3->sponsor_type)=="Meeting Room Rent Fee/Institution Fee")
						{
							$data = array_merge($data, array('event_organizer'=>$row3->institution_name));
							$data = array_merge($data, array('id_sc'=>$row3->id_sc));
						}
						else if(trim($row3->sponsor_type)=="Association / Organisation Fee")
						{
							$data = array_merge($data, array('event_organizer'=>$row3->assoc_name));
							$data = array_merge($data, array('id_sc'=>$row3->id_sc));
						}	
					}	
				}
				$data = array_merge($data, array('description'=>""));
				$data = array_merge($data, array('address'=>""));
				$data = array_merge($data, array('check5'=>""));
				$data = array_merge($data, array('check6'=>""));
				$data = array_merge($data, array('check7'=>""));
                $query2 = $this->db->query("SELECT description, address, speciality, check5, check6, check7 FROM kpk_report WHERE id_hcp2='".$row2->id_hcp2."' AND id_hco='".$row2->id_hco."' AND id_mer='".$row2->id_mer."' AND id_sc='".$row2->id_sc."' AND id_tl2='".$row2->id_tl2."' AND id_hcp='".$row2->id_hcp."'");
                foreach ($query2->result() as $row3)
                {
					$data = array_merge($data, array('description'=>$row3->description));
					$data = array_merge($data, array('address'=>$row3->address));
					$data = array_merge($data, array('speciality'=>$row3->speciality));
					$data = array_merge($data, array('check5'=>$row3->check5));
					$data = array_merge($data, array('check6'=>$row3->check6));
					$data = array_merge($data, array('check7'=>$row3->check7));
				}	
                array_push($data2['kpk'],$data);
				$i = $i + 1;
    		}	
			if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
			{
				$this->load->view('kpk-report',$data2);
			}
			else
			{
				$this->load->view('login');
			}	
	}

	public function add()
	{
		for($i=0;$i<$this->input->post('count');$i++)
		{
            $id_tl2 = "id_tl2-".($i+1);
            $id_hcp = "id_hcp-".($i+1);
            $id_mer = "id_mer-".($i+1);
            $id_sc = "id_sc-".($i+1);
            $id_hcp2 = "id_hcp2-".($i+1);
            $id_hco = "id_hco-".($i+1);
            $check5 = "check5-".($i+1);
            $check6 = "check6-".($i+1);
            $check7 = "check7-".($i+1);
            $desc = "description-".($i+1);
            $address = "address-".($i+1);
			$speciality = "speciality-".($i+1);
//			print_r($this->input->post($desc));
			$data = array(
				'id_tl2' => $this->input->post($id_tl2),
				'id_hcp' => $this->input->post($id_hcp),
				'id_mer' => $this->input->post($id_mer),
				'id_sc' => $this->input->post($id_sc),
				'id_hco' => $this->input->post($id_hco),
				'id_hcp2' => $this->input->post($id_hcp2),
				'description' => $this->input->post($desc),
				'check5' => $this->input->post($check5),
				'check6' => $this->input->post($check6),
				'check7' => $this->input->post($check7),
				'speciality' => $this->input->post($speciality),
				'address' => $this->input->post($address)
			);
			$j = 0;
			$id_kpk = 0;
            $query = $this->db->query("SELECT id_kpk FROM kpk_report WHERE id_hcp2=".$this->input->post($id_hcp2)." and id_hco=".$this->input->post($id_hco)." AND id_mer=".$this->input->post($id_mer)." AND id_sc=".$this->input->post($id_sc)." AND id_tl2=".$this->input->post($id_tl2)." AND id_hcp=".$this->input->post($id_hcp));
            foreach ($query->result() as $row2)
            {
				$j = $j + 1;
				$id_kpk = $row2->id_kpk;
			}
			if($j==0)
			{
				$this->db->insert("kpk_report",$data);
			}
			else
			{
				$this->db->where('id_kpk', $id_kpk);
				$this->db->update("kpk_report",$data);
			}	
		}

		redirect(base_url()."index.php/KPKReport?year=".$this->input->post('year')."&month=".$this->input->post('month'));

	}


}
