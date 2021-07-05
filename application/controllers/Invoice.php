<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
		$this->load->library('session');
		$this->load->library('user_agent');
	}

	public function _user_output($output = null)
	{
		$this->load->view('invoice',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('invoice');
			$crud->set_subject('Invoice');
			$crud->columns('id_upload','invoice_no','id_dist','id_channel','id_cust','name_cust','address','id_branch','city','id_product','product_group','period','qty_sales','sales_value','sales_discount','retur_qty','retur_value','retur_discount','gross');
			$crud->fields('invoice_no','id_dist','id_branch','id_cust','id_product','period','qty_sales','sales_value','sales_discount','retur_qty','retur_value','retur_discount');
			$crud->required_fields('invoice_no','id_dist','id_branch','id_cust','id_product','period','qty_sales','sales_value','sales_discount','retur_qty','retur_value','retur_discount');
			$crud->set_relation('id_dist','distributor','code');
			$state = $crud->getState();
			if($state=="edit")
			{	
				$crud->set_relation('id_branch','branch','name',null,'name');
				$crud->set_relation('id_cust','customer','id_cust2',null,'id_cust2');
			}				
			else
			{
				$crud->set_relation('id_branch','branch','name',array('id_dist'=>'0'),'name');
				$crud->set_relation('id_cust','customer','id_cust2',array('id_dist'=>'0'),'id_cust2');
			}				
			$crud->set_relation('id_product','product','name_product',null,'name_product');
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_edit();
			$crud->unset_delete();
			$crud->unset_clone();
			//$crud->field_type("period","date");
			$crud->field_type("qty_sales","integer");
			$crud->field_type("sales_value","integer");
			$crud->field_type("sales_discount","integer");
			$crud->field_type("retur_qty","integer");
			$crud->field_type("retur_value","integer");
			$crud->field_type("retur_discount","integer");
			$crud->field_type("invoice_no","integer");
			$crud->display_as('id_product','Product');
			$crud->display_as('id_dist','Distributor');
			$crud->display_as('id_branch','Branch');
			$crud->display_as('id_channel','Channel');
			$crud->display_as('id_cust','Customer Code');
			$crud->display_as('invoice_no','Invoice No');
			$crud->display_as('name_cust','Customer Name');
			$crud->display_as('gross','Gross Sales');
			$crud->display_as("qty_sales","Sales Quantity");
			$crud->display_as("id_upload","ID Upload");
			$crud->display_as("sales_value","Sales (IDR)");
			$crud->display_as("sales_discount","Sales Discount (IDR)");
			$crud->display_as("retur_qty","Retur Quantity");
			$crud->display_as("product_group","Product Group");
			$crud->display_as("retur_value","Retur (IDR)");
			$crud->display_as("retur_discount","Retur Discount");
			$crud->display_as("no_invoice","No Invoice");
			$crud->set_lang_string('form_update_changes','Update');
			$crud->set_lang_string('form_update_and_go_back','Update & Return');
			$crud->set_lang_string('form_save_and_go_back','Save & Return');
			$crud->set_lang_string('form_upload_delete','Delete');
            $crud->callback_column('name_cust',array($this,'_callback_name_cust'));
            $crud->callback_column('address',array($this,'_callback_address'));
            $crud->callback_column('city',array($this,'_callback_city'));
            $crud->callback_column('product_group',array($this,'_callback_product_group'));
            $crud->callback_column('gross',array($this,'_callback_gross'));
            $crud->callback_column('id_channel',array($this,'_callback_channel'));

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
				if($jumlah==1)
				{
					$this->load->view('menu_admin.html');
					$this->_user_output($output);
				}
				else
				{
					$this->load->view('info2');
				}				
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


    public function _callback_name_cust($value, $row)
    {
        $name = "";
		$query = $this->db->query("SELECT name from customer where id_cust='".$row->id_cust."'");
		foreach ($query->result() as $row2)		{
            $name = $row2->name;
		}

        return $name;
    }

    public function _callback_address($value, $row)
    {
        $address = "";
		$query = $this->db->query("SELECT address from customer where id_cust='".$row->id_cust."'");
		foreach ($query->result() as $row2)		{
            $address = $row2->address;
		}

        return $address;
    }

    public function _callback_channel($value, $row)
    {
        $channel = "";
		$big = array('1' => '1 HOSPITAL', '2' => '2 PHARMACY','3' => '3 DRUGSTORE', '4' => '4 INSTITUTION','5' => '5 MTC','6' => '6 PHARMA CHAIN','7' => '7 GT&OTHERS','8' => '8 PBF');
		$query = $this->db->query("SELECT big from customer a, channel b where a.id_channel=b.id_channel and id_cust='".$row->id_cust."'");
		foreach ($query->result() as $row2)		{
            $channel = $big[$row2->big];
		}

        return $channel;
    }

    public function _callback_gross($value, $row)
    {

        return $row->qty_sales+$row->retur_qty;
    }

    public function _callback_city($value, $row)
    {
        $city = "";
		$query = $this->db->query("SELECT city from customer where id_cust='".$row->id_cust."'");
		foreach ($query->result() as $row2)		{
            $city = $row2->city;
		}

        return $city;
    }

    public function _callback_product_group($value, $row)
    {
        $name = "";
		$query = $this->db->query("SELECT name from product a, product_group b where a.id_group=b.id_group and a.id_product='".$row->id_product."'");
		foreach ($query->result() as $row2)		{
            $name = $row2->name;
		}

        return $name;
    }

	public function getCustomer()
	{
		$result="[";
		$query = $this->db->query("SELECT distinct id_cust as id, name  FROM customer WHERE id_dist=".$_GET['id_dist']);
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id."\",\"name\":\"".$row2->name."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}


	public function getBranch()
	{
		$result="[";
		$query = $this->db->query("SELECT distinct id_branch as id, name  FROM branch WHERE id_dist=".$_GET['id_dist']);
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id."\",\"name\":\"".$row2->name."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}

}
