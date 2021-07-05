<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock extends CI_Controller {

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
		$this->load->view('stock',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('stock');
			$crud->set_subject('Atock');
			$crud->columns('id_upload','batch_no','id_dist','id_branch','product_group','id_product','kemasan','price','exp_date','qty','stock_baik','stock_rusak','stock_titip','stock_konsi','bdp','period','co_date');
			$crud->fields('batch_no','id_dist','id_branch','id_product','price','period','qty','stock_baik','stock_rusak','stock_titip','stock_konsi','bdp','period','co_date');
			$crud->required_fields('batch_no','id_dist','id_branch','id_product','price','period','qty','stock_baik','stock_rusak','stock_titip','stock_konsi','bdp','period','co_date');
			$crud->set_relation('id_dist','distributor','code');
			$crud->set_relation('id_branch','branch','name',null,'name');
			$state = $crud->getState();
			$crud->set_relation('id_product','product','name_product',null,'name_product');
			$crud->unset_read();
			$crud->unset_print();
			$crud->unset_edit();
			$crud->unset_delete();
			$crud->unset_clone();
			//$crud->field_type("period","date");
			$crud->field_type("stock_baik","integer");
			$crud->field_type("stock_rusak","integer");
			$crud->field_type("stock_titip","integer");
			$crud->field_type("stock_konsi","integer");
			$crud->field_type("price","integer");
			$crud->field_type("qty","integer");
			$crud->display_as('id_upload','ID Upload');
			$crud->display_as('batch_no','Bath No');
			$crud->display_as('id_product','Product');
			$crud->display_as('id_dist','Distributor');
			$crud->display_as('id_branch','Branch');
			$crud->display_as('stock_baik','Stock Baik');
			$crud->display_as('bdp','BDP');
			$crud->display_as('stock_rusak','Stock Rusak');
			$crud->display_as('stock_titip','Stock Titip');
			$crud->display_as('stock_konsi','Stock Konsi');
			$crud->display_as('qty','Quantity');
			$crud->display_as("exp_date","Expired Date");
			$crud->display_as("co_date","Cust Offer Date");
			$crud->display_as("product_group","Product Group");
			$crud->set_lang_string('form_update_changes','Update');
			$crud->set_lang_string('form_update_and_go_back','Update & Return');
			$crud->set_lang_string('form_save_and_go_back','Save & Return');
			$crud->set_lang_string('form_upload_delete','Delete');
            $crud->callback_column('product_group',array($this,'_callback_product_group'));

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


    public function _callback_product_group($value, $row)
    {
        $name = "";
		$query = $this->db->query("SELECT name from product a, product_group b where a.id_group=b.id_group and a.id_product='".$row->id_product."'");
		foreach ($query->result() as $row2)		{
            $name = $row2->name;
		}

        return $name;
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
