<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EventMonthly extends CI_Controller {

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
		if($this->session->userdata('id_group')==22 || $this->session->userdata('id_group')==23 || $this->session->userdata('id_group')==25)
		{
			$query = $this->db->query("select a.id_event, f.name, event_date, event_name, format(sum(price*qty_actual),0) as actual_sales, format(100*(booth_actual + spg_actual + transportation_actual + trophy_actual + (gimmick_actual * 10000))/sum(cust_cost_actual*qty_actual),2) as ratio, if(b.bundling=1,'YES','NO') as bundling, format(sum(cust_cost*qty_est),0) as target, format(sum(cust_cost_actual*qty_actual),0) as actual, format((sum(cust_cost_actual*qty_actual)*100/sum(cust_cost*qty_est)),2) as ach from event_report a, event_otc b, area_event c, event_sku d, product e, area_event f, event_pic g where b.state=6 and g.id_event=a.id_event and g.id_user='".$this->session->userdata('id_user')."' and b.id_area=f.id_area and e.id_product=d.id_product and a.id_event=d.id_event and a.id_event=b.id_event and b.id_area=c.id_area and event_date like '\'".$_GET['month']."/%' group by a.id_event");
		}	
		else if($this->session->userdata('id_group')==15)
		{
			$query = $this->db->query("select a.id_event, f.name, event_date, event_name, format(sum(price*qty_actual),0) as actual_sales, format(100*(booth_actual + spg_actual + transportation_actual + trophy_actual + (gimmick_actual * 10000))/sum(cust_cost_actual*qty_actual),2) as ratio, if(b.bundling=1,'YES','NO') as bundling, format(sum(cust_cost*qty_est),0) as target, format(sum(cust_cost_actual*qty_actual),0) as actual, format((sum(cust_cost_actual*qty_actual)*100/sum(cust_cost*qty_est)),2) as ach from event_report a, event_otc b, area_event c, event_sku d, product e, area_event f where b.state=6 and b.id_area=f.id_area and e.id_product=d.id_product and a.id_event=d.id_event and a.id_event=b.id_event and b.id_area=c.id_area and b.requested_by='".$this->session->userdata('id_user')."' event_date like '\'".$_GET['month']."/%' group by a.id_event");
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
				$query = $this->db->query("select a.id_event, f.name, event_date, event_name, format(sum(price*qty_actual),0) as actual_sales, format(100*(booth_actual + spg_actual + transportation_actual + trophy_actual + (gimmick_actual * 10000))/sum(cust_cost_actual*qty_actual),2) as ratio, if(b.bundling=1,'YES','NO') as bundling, format(sum(cust_cost*qty_est),0) as target, format(sum(cust_cost_actual*qty_actual),0) as actual, format((sum(cust_cost_actual*qty_actual)*100/sum(cust_cost*qty_est)),2) as ach from event_report a, event_otc b, area_event c, event_sku d, product e, area_event f where b.id_area=f.id_area and e.id_product=d.id_product and a.id_event=d.id_event and a.id_event=b.id_event and b.id_area=c.id_area and a.id_event in ('".$id_event."') and event_date like '\'".$_GET['month']."/%' group by a.id_event");
			}
			else
			{
				$query = $this->db->query("select a.id_event, f.name, event_date, event_name, format(sum(price*qty_actual),0) as actual_sales, format(100*(booth_actual + spg_actual + transportation_actual + trophy_actual + (gimmick_actual * 10000))/sum(cust_cost_actual*qty_actual),2) as ratio, if(b.bundling=1,'YES','NO') as bundling, format(sum(cust_cost*qty_est),0) as target, format(sum(cust_cost_actual*qty_actual),0) as actual, format((sum(cust_cost_actual*qty_actual)*100/sum(cust_cost*qty_est)),2) as ach from event_report a, event_otc b, area_event c, event_sku d, product e, area_event f where b.id_area=f.id_area and e.id_product=d.id_product and a.id_event=d.id_event and a.id_event=b.id_event and b.id_area=c.id_area and event_date like '\'".$_GET['month']."/%' group by a.id_event");
			}				
		}	
		else
		{
			$query = $this->db->query("select a.id_event, f.name, event_date, event_name, format(sum(price*qty_actual),0) as actual_sales, format(100*(booth_actual + spg_actual + transportation_actual + trophy_actual + (gimmick_actual * 10000))/sum(cust_cost_actual*qty_actual),2) as ratio, if(b.bundling=1,'YES','NO') as bundling, format(sum(cust_cost*qty_est),0) as target, format(sum(cust_cost_actual*qty_actual),0) as actual, format((sum(cust_cost_actual*qty_actual)*100/sum(cust_cost*qty_est)),2) as ach from event_report a, event_otc b, area_event c, event_sku d, product e, area_event f where b.state=6 and b.id_area=f.id_area and e.id_product=d.id_product and a.id_event=d.id_event and a.id_event=b.id_event and b.id_area=c.id_area and event_date like '\'".$_GET['month']."/%' group by a.id_event");
		}	

			$i = 0;
			$id_event = 0;
			foreach ($query->result() as $row2)
			{
				$id_event = $row2->id_event;
				$data = array(
					'area' => $row2->name,
					'month' => $row2->event_date,
					'event_name' => $row2->event_name,
					'actual_sales' => $row2->actual_sales,
					'cost_ratio' => $row2->ratio,
					'bundling' => $row2->bundling,
					'target' => $row2->target,
					'actual' => $row2->actual,
					'team' => "",
					'pic' => "",
					'ach' => $row2->ach
                );
				
				$team = "";
				$pic = "";
                $query2 = $this->db->query("SELECT b.name as team, c.name as pic FROM event_pic a, user b, groups c WHERE b.id_group=c.id and a.id_user=b.id_user and id_event='".$id_event."'");
                foreach ($query2->result() as $row3)
                {
					$team = $team.$row3->team."/";
					$pic = $pic.$row3->pic."/";
				}	
				
				$team = rtrim($team, "/");
				$pic = rtrim($pic, "/");
				$data = array_merge($data, array('team'=>$team));
				$data = array_merge($data, array('pic'=>$pic));
                
//				$data = array_merge($data, array('id_tl2'=>"0"));
				array_push($data2['kpk'],$data);
			}	
			$this->load->view('event-monthly',$data2);
	}



}
