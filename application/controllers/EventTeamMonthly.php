<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EventTeamMonthly extends CI_Controller {

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
		
			if($this->session->userdata('id_group')==15)
			{
				$query3 = $this->db->query("select distinct c.requested_by, a.name as team, d.name as area, e.name as position from event_report b, event_otc c, user a, area_sales d, groups e where c.state=6 and e.id=a.id_group and d.id_area=a.id_regency and a.id_user=c.requested_by and b.id_event=c.id_event and c.requested_by=".$this->session->userdata('id_user')." and event_date like '\'".$_GET['month']."/%'");
			}	
			else if($this->session->userdata('id_group')==20)
			{
				$id_event = "0";
				$query = $this->db->query("select id_event from area_event a, event_otc b where b.state=6 and a.id_area=b.id_area and (id_user like '".$this->session->userdata('id_user').",%' or id_user like '%,".$this->session->userdata('id_user')."' or id_user like '%,".$this->session->userdata('id_user').",%' or id_user='".$this->session->userdata('id_user')."')");				
				foreach ($query->result() as $row2)
				{
					$id_event = $id_event.",".$row2->id_event;					
				}
				if($id_event!="0")
				{
					$query3 = $this->db->query("select distinct c.requested_by, a.name as team, d.name as area, e.name as position from event_report b, event_otc c, user a, area_sales d, groups e where e.id=a.id_group and d.id_area=a.id_regency and a.id_user=c.requested_by and b.id_event=c.id_event and b.id_event in (".$id_event.") and event_date like '\'".$_GET['month']."/%'");
				}
				else
				{
					$query3 = $this->db->query("select distinct c.requested_by, a.name as team, d.name as area, e.name as position from event_report b, event_otc c, user a, area_sales d, groups e where e.id=a.id_group and d.id_area=a.id_regency and a.id_user=c.requested_by and b.id_event=c.id_event and event_date like '\'".$_GET['month']."/%'");
				}					
			}
			else
			{
				$query3 = $this->db->query("select distinct c.requested_by, a.name as team, d.name as area, e.name as position from event_report b, event_otc c, user a, area_sales d, groups e where c.state=6 and e.id=a.id_group and d.id_area=a.id_regency and a.id_user=c.requested_by and b.id_event=c.id_event and event_date like '\'".$_GET['month']."/%'");
			}
			
			foreach ($query3->result() as $row4)
			{
				if($this->session->userdata('id_group')==22 || $this->session->userdata('id_group')==23 || $this->session->userdata('id_group')==25)
				{
					$query = $this->db->query("select distinct a.id_event, d.name as team, e.name as area, f.name as position, event_name from event_pic a, event_report b, event_otc c, user d, regency e, groups f where c.state=6 and f.id=d.id_group and e.id_regency=d.id_regency and a.id_event=b.id_event and b.id_event=c.id_event and a.id_user=d.id_user and c.requested_by=".$this->session->userdata('id_user')." and event_date like '\'".$_GET['month']."/%' group by a.id_event order by a.id_user");
				}
				else
				{
					$query = $this->db->query("select distinct a.id_event, d.name as team, e.name as area, f.name as position, event_name from event_pic a, event_report b, event_otc c, user d, regency e, groups f where f.id=d.id_group and e.id_regency=d.id_regency and a.id_event=b.id_event and b.id_event=c.id_event and a.id_user=d.id_user and c.requested_by=".$row4->requested_by." and event_date like '\'".$_GET['month']."/%' group by a.id_event order by a.id_user");
				}	
				$i = 0;
				$id_event = 0;
				$actual2 = 0;
				$ratio2 = 0;
				foreach ($query->result() as $row2)
				{
					$id_event = $row2->id_event;

					if($row2->position=="KAE")
					{
						$data = array(
							'area' => $row4->area,
							'team' => $row2->team,
							'position' => $row2->position,
							'event_name' => $row2->event_name
						);
					}
					else
					{
						$data = array(
							'area' => $row2->area,
							'team' => $row2->team,
							'position' => $row2->position,
							'event_name' => $row2->event_name
						);
					}	
																	
					$actual = 0;
					$ratio = 0;
					$query2 = $this->db->query("select format(100*(booth_actual + spg_actual + transportation_actual + trophy_actual + (gimmick_actual * 10000))/sum(cust_cost_actual*qty_actual),2) as ratio, format(sum(qty_actual*cust_cost_actual),0) as actual, sum(qty_actual*cust_cost_actual) as actual2 from event_sku a, event_report b where a.id_event=b.id_event and a.id_event=".$id_event);
					foreach ($query2->result() as $row3)
					{
						$actual = $row3->actual;
						$ratio = $row3->ratio;
						$actual2 = $actual2 + $row3->actual2;
					}	
					$ratio2 = $ratio2 + $ratio;

					$data = array_merge($data, array('actual'=>$actual));
					$data = array_merge($data, array('ratio'=>$ratio));

					$file = "";
					$query2 = $this->db->query("select file from event_pic a, event_report b where a.id_event=b.id_event and file<>'' and a.id_event=".$id_event);
					foreach ($query2->result() as $row3)
					{
						$file = $file."<p><a href='".APP_PATH."assets/uploads/'>".$row3->file."</a></p>";
					}	

					$data = array_merge($data, array('file'=>$file));
	//				$data = array_merge($data, array('id_tl2'=>"0"));
					array_push($data2['kpk'],$data);
					$i = $i + 1;
				}	
				$data = array(
					'area' => '<b>'.$row4->area.'</b>',
					'team' => '<b>'.$row4->team.'</b>',
					'position' => '<b>'.$row4->position.'</b>',
					'event_name' => "",
					'file' => "",
					'ratio' => '<b>'.number_format($ratio2/$i,2).'</b>',
					'actual' => '<b>'.number_format($actual2,0).'</b>'
				);
				array_push($data2['kpk'],$data);
				
			}
			
			$this->load->view('event-team-monthly',$data2);
	}



}
