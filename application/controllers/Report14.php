<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report14 extends CI_Controller {
	private $id_dist;

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
		$this->load->library('session');
		$this->load->library('user_agent');
		if(isset($_GET['id_dist']))
		{
			$this->id_dist = $_GET['id_dist'];
		}	
	}

	public function _report_output($output = null)
	{
		$this->load->view('report14',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('customer_profile');
			$crud->set_subject('');
			$crud->columns('id_cust_profile','master_name','identity','sales');
			$crud->order_by('type,master_name');
			
			if(isset($_GET['name']))
			{
				$crud->where("master_name like '%".$_GET['name']."%'");
			}				
			$crud->unset_add();
			$crud->unset_edit();
			$crud->unset_delete();
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_clone();
			$crud->display_as('id_dist','Distributor');
			$crud->display_as('id_channel','Channel');
			$crud->display_as('id_branch','Branch');
			$crud->display_as('master_name','Customer Master');
			$crud->display_as('id_cust_profile','ID');
			$crud->display_as('id_cust2','Customer Code');
            $crud->callback_column('identity',array($this,'_callback_identity'));
            $crud->callback_column('sales',array($this,'_callback_sales'));
			$crud->set_lang_string('form_update_changes','Update');
			$crud->set_lang_string('form_update_and_go_back','Update & Return');
			$crud->set_lang_string('form_save_and_go_back','Save & Return');
			$crud->set_lang_string('form_upload_delete','Delete');

			$output = $crud->render();
			$jumlah = 0;
			$query = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and page='".$this->uri->segment(1)."' and (id_group like '".$this->session->userdata('id_group').",%' or id_group like '%,".$this->session->userdata('id_group')."' or id_group like '%,".$this->session->userdata('id_group').",%' or id_group='".$this->session->userdata('id_group')."')");
			foreach ($query->result() as $row2)
			{
				$jumlah = $row2->jumlah;
				if($jumlah==0 && isset($_GET['access']))
				{
					$query2 = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and page='".$this->uri->segment(1)."' and (id_group like '".$_GET['access'].",%' or id_group like '%,".$_GET['access']."' or id_group like '%,".$_GET['access'].",%' or id_group='".$_GET['access']."')");
					foreach ($query2->result() as $row3)
					{
						$jumlah = $row3->jumlah;
					}
				}
			}

			if(!$this->session->userdata('id_group'))
			{
				redirect("/Login");
			}
			else
			{		
				//if($jumlah==1)
				//{
//					$this->load->view('menu_admin.html');
					$this->_report_output($output);
				//}
				//else
				//{
				//	$this->load->view('info2');
				//}				
			}	

    		/*if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
			{	
				$this->load->view('menu_admin.html');
				$this->_user_output($output);
			}	
			else
			{
				redirect("/Login");
			}*/


		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	
	//		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function getAuditTrail()
	{
		$ip = $this->input->ip_address();
		
		$agent = "";
		if ($this->agent->is_browser())
		{
			$agent = $this->agent->browser().' '.$this->agent->version();
		}
		elseif ($this->agent->is_robot())
		{
			$agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
			$agent = $this->agent->mobile();
		}
		else
		{
			$agent = 'Unidentified User Agent';
		}

		$agent = $agent." ".$this->agent->platform();

		$url = current_url().'?'.$_SERVER['QUERY_STRING'];

		$agent_full = $_SERVER['HTTP_USER_AGENT'];

		$data = array(
            'page' => $url,
			'id_user' => $this->session->userdata('id_user'),
            'ip_address' => $ip,
            'user_agent' => $agent,
			'user_agent_full' => $agent_full
        );
		$this->db->insert("log_page",$data);

	}


    public function _callback_city($value, $row)
    {
		$result="";
		$query = $this->db->query("SELECT city FROM customer WHERE id_cust=".$row->id_cust);
		foreach ($query->result() as $row2)
		{			
			$result = $row2->city;
		}

        return $result;
    }

    public function _callback_identity($value, $row)
    {
		$result = "";
		
		if(isset($_GET['id_dist']) && isset($_GET['id_channel']))
		{
			$query = $this->db->query("SELECT id_cust2, city, a.name as customer_name, c.name as branch_name, d.name as channel_name, code FROM customer a, branch c, channel d, distributor e WHERE a.id_dist in (".$_GET['id_dist'].") and d.big in (".$_GET['id_channel'].") and a.id_dist=e.id_dist and a.id_branch=c.id_branch and a.id_channel=d.id_channel and id_cust_profile=".$row->id_cust_profile);
		}
		else
		{
			$query = $this->db->query("SELECT id_cust2, city, a.name as customer_name, c.name as branch_name, d.name as channel_name, code FROM customer a, branch c, channel d, distributor e WHERE a.id_dist=e.id_dist and a.id_branch=c.id_branch and a.id_channel=d.id_channel and id_cust_profile=".$row->id_cust_profile);
		}			
		$i = 0;
		foreach ($query->result() as $row2)
		{			
			if($i==0)
			{
				$result="<table class='table table-sm table-bordered table-striped' style='font-size:12px'>";
				$result = $result."<tr>";
				$result = $result."<th scope='col' style='text-align:center'>Identity Code`</th>";
				$result = $result."<th scope='col' style='text-align:center'>Identity Name`</th>";
				$result = $result."<th scope='col' style='text-align:center'>Distributor</th>";
				$result = $result."<th scope='col' style='text-align:center'>Branch</th>";
				$result = $result."<th scope='col' style='text-align:center'>Channel</th>";
				$result = $result."<th scope='col' style='text-align:center'>City</th>";
				$result = $result."</tr>";
			}				
			$result = $result."<tr>";
			$result = $result."<td>".$row2->id_cust2."</td>";
			$result = $result."<td>".$row2->customer_name."</td>";
			$result = $result."<td>".$row2->code."</td>";
			$result = $result."<td>".$row2->branch_name."</td>";
			$result = $result."<td>".$row2->channel_name."</td>";
			$result = $result."<td>".$row2->city."</td>";
			$result = $result."</tr>";
			$i = $i + 1;
		}

		if($i>0)
		{
			$result = $result."</table>";
		}	
        return $result;
    }

    public function _callback_sales($value, $row)
    {
		$result = "";
		if(isset($_GET['id_dist']) && isset($_GET['id_product']) && isset($_GET['year1']) && isset($_GET['year2']) && isset($_GET['month1']) && isset($_GET['month2']))
		{
			$query = $this->db->query("SELECT sum(sales_value+retur_value) as average, code FROM invoice_sum_profile a, distributor b WHERE id_product in (".$_GET['id_product'].") and period between '".$_GET['year1'].str_pad($_GET['month1'],2,"0",STR_PAD_LEFT)."' and '".$_GET['year2'].str_pad($_GET['month2'],2,"0",STR_PAD_LEFT)."' and a.id_dist=b.id_dist and b.id_dist in (".$_GET['id_dist'].") and id_cust_profile='".$row->id_cust_profile."' group by a.id_dist");
		}
		else
		{
			$query = $this->db->query("SELECT sum(sales_value+retur_value) as average, code FROM invoice_sum_profile a, distributor b WHERE a.id_dist=b.id_dist and id_cust_profile='".$row->id_cust_profile."' group by a.id_dist");
		}			
		$i = 0;
		foreach ($query->result() as $row2)
		{			
			if($i==0)
			{
				$result="<table class='table table-sm table-bordered table-striped' style='font-size:12px'>";
				$result = $result."<tr>";
				$result = $result."<th scope='col' style='text-align:center'>Distributor</th>";
				$result = $result."<th scope='col' style='text-align:center'>Gross Sales</th>";
				$result = $result."</tr>";
			}				
			$result = $result."<tr>";
			$result = $result."<td>".$row2->code."</td>";
			$result = $result."<td style='text-align:right'>".number_format($row2->average,0)."</td>";
			$result = $result."</tr>";
			$i = $i + 1;
		}
		if($i>0)
		{
			$result = $result."</table>";
		}	

        return $result;
    }

}
