<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EventSKU extends CI_Controller {

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
		$this->load->view('event_sku',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
						
			$crud->set_theme('bootstrap');
			$crud->set_table('event_sku');
			$crud->set_subject('EVENT SKU');
			$crud->required_fields('id_event','id_product','cust_cost','dist_cost','qty_est');
			if($this->uri->segment(8)=="2")
			{
				$crud->columns('id_product','price','het','cust_cost','dist_cost','qty_est','cust_cost_actual','dist_cost_actual','qty_actual','total1','total2','total3','margin');
				$crud->edit_fields('id_event','qty_actual','cust_cost_actual','dist_cost_actual');
				$crud->add_fields('id_event','id_product','cust_cost_actual','dist_cost_actual','qty_actual');
				$crud->display_as('total1','Qty x HNA + PPN (Actual)');
				$crud->display_as('total2','Qty x Harga Konsumen (Actual)');
				$crud->display_as('total3','Qty x Harga Tempat Pengambilan Produk (Actual)');
				$crud->set_rules('cust_cost_actual','Harga Konsumen (Actual)','callback_check_cost_actual|required');
			}
			else
			{
				$crud->columns('id_product','price','het','cust_cost','dist_cost','qty_est','total1','total2','total3','margin');
				$crud->fields('id_event','id_product','cust_cost','dist_cost','qty_est');
				$crud->display_as('total1','Qty x HNA + PPN (Estimasi)');
				$crud->display_as('total2','Qty x Harga Konsumen (Estimasi)');
				$crud->display_as('total3','Qty x Harga Tempat Pengambilan Produk (Estimasi)');
				$crud->set_rules('cust_cost','Harga Konsumen (Estimasi)','callback_check_cost|required');
			}	
//			$crud->set_relation('id_event','event_otc','event_name','id_event='.$this->uri->segment(3));
			$crud->set_relation('id_product','product','{name_product}',"id_group in (select id_product_group from event_otc where id_event=".$this->uri->segment(4).")");
			
            if($this->uri->segment(4)!=null)
            {
				$crud->where('event_sku.id_event',$this->uri->segment(4));
			}			
//			$crud->unset_delete();
            $crud->unset_read();
			$crud->field_type('id_event','hidden',$this->uri->segment(4));
			if(($this->session->userdata('id_group')==15 || $this->session->userdata('id_group')==10) && $this->uri->segment(6)=="1")
			{
			}
			else if($this->session->userdata('id_group')==20 && $this->uri->segment(6)=="1")
			{
				$crud->unset_delete();
//				$crud->unset_add();
			}
			else
			{
				$crud->unset_edit();
				$crud->unset_delete();
				$crud->unset_add();
			}				
			$crud->unset_print();
			$crud->unset_clone();
			$crud->field_type('cust_cost_actual','integer');
			$crud->field_type('dist_cost_actual','integer');
			$crud->field_type('cust_cost','integer');
			$crud->field_type('dist_cost','integer');
			$crud->field_type('qty_actual','integer');
			$crud->field_type('qty_est','integer');
			$crud->display_as('id_product','Product');
			$crud->display_as('cust_cost_actual','Harga Konsumen (Actual)');
			$crud->display_as('dist_cost_actual','Harga Tempat Pengambilan Produk (Actual)');
			$crud->display_as('cust_cost','Harga Konsumen (Estimasi)');
			$crud->display_as('dist_cost','Harga Tempat Pengambilan Produk (Estimasi)');
			$crud->display_as('qty_est','Qty Terjual (Estimasi)');
			$crud->display_as('qty_actual','Qty Terjual (Actual)');
			$crud->display_as('id_event','Event OTC');
			$crud->display_as('price','HNA + PPN');
			$crud->display_as('margin','Margin (%)');
			$crud->display_as('het','HET');
            $crud->callback_column('price',array($this,'_callback_price'));
            $crud->callback_column('het',array($this,'_callback_het'));
            $crud->callback_column('cust_cost',array($this,'_callback_cust_cost'));
            $crud->callback_column('dist_cost',array($this,'_callback_dist_cost'));
            $crud->callback_column('cust_cost_actual',array($this,'_callback_cust_cost_actual'));
            $crud->callback_column('dist_cost_actual',array($this,'_callback_dist_cost_actual'));
			
			if($this->uri->segment(8)=="2")
			{
				$crud->callback_column('total1',array($this,'_callback_total1_actual'));
				$crud->callback_column('total2',array($this,'_callback_total2_actual'));
				$crud->callback_column('total3',array($this,'_callback_total3_actual'));
				$crud->callback_column('margin',array($this,'_callback_margin_actual'));
			}
			else
			{
				$crud->callback_column('total1',array($this,'_callback_total1'));
				$crud->callback_column('total2',array($this,'_callback_total2'));
				$crud->callback_column('total3',array($this,'_callback_total3'));
				$crud->callback_column('margin',array($this,'_callback_margin'));
			}				
			$crud->set_lang_string('form_update_changes','Update');
			$crud->set_lang_string('form_update_and_go_back','Update & Return');
			$crud->set_lang_string('form_save_and_go_back','Save & Return');
			$crud->set_lang_string('form_upload_delete','Delete');

			$output = $crud->render();
			$jumlah = 0;
			$query = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and replace(page,'List','')='Event' and (id_group like '".$this->session->userdata('id_group').",%' or id_group like '%,".$this->session->userdata('id_group')."' or id_group like '%,".$this->session->userdata('id_group').",%' or id_group='".$this->session->userdata('id_group')."')");
			foreach ($query->result() as $row2)
			{
				$jumlah = $row2->jumlah;
				if($jumlah==0 && isset($_GET['access']))
				{
					$query2 = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and replace(page,'List','')='Event' and (id_group like '".$_GET['access'].",%' or id_group like '%,".$_GET['access']."' or id_group like '%,".$_GET['access'].",%' or id_group='".$_GET['access']."')");
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
					$this->_user_output($output);
//					$this->load->view('event_pic',$data);
				}
				else
				{
					$this->load->view('info2');
				}				
			}	

			/*$output = $crud->render();
    		if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
			{	
//				$this->load->view('menu_admin.html');
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

	public function _callback_price($value, $row)
	{
		$price = "";
		$query = $this->db->query("SELECT price FROM product a, event_sku b where a.id_product=b.id_product and id_event_sku=".$row->id_event_sku);
		foreach ($query->result() as $row2)
		{
			$price = $row2->price;	
		}

		return number_format($price,0,'.',',');
	}

	public function _callback_total1($value, $row)
	{
		$price = "0";
		$query = $this->db->query("SELECT price FROM product a, event_sku b where a.id_product=b.id_product and id_event_sku=".$row->id_event_sku);
		foreach ($query->result() as $row2)
		{
			$price = $row2->price;	
		}

		return number_format($price*$row->qty_est,0,'.',',');
	}

	public function _callback_total1_actual($value, $row)
	{
		$price = "0";
		$query = $this->db->query("SELECT price FROM product a, event_sku b where a.id_product=b.id_product and id_event_sku=".$row->id_event_sku);
		foreach ($query->result() as $row2)
		{
			$price = $row2->price;	
		}

		return number_format($price*$row->qty_actual,0,'.',',');
	}

	public function _callback_het($value, $row)
	{
		$het = "";
		$query = $this->db->query("SELECT het FROM product a, event_sku b where a.id_product=b.id_product and id_event_sku=".$row->id_event_sku);
		foreach ($query->result() as $row2)
		{
			$het = $row2->het;	
		}

		return number_format($het,0,'.',',');
	}

	public function _callback_total2($value, $row)
	{
		return number_format($row->cust_cost*$row->qty_est,0,'.',',');
	}

	public function _callback_total2_actual($value, $row)
	{
		return number_format($row->cust_cost_actual*$row->qty_actual,0,'.',',');
	}

	function check_cost($post_array) 
	{		
		if($_POST['cust_cost']>=$_POST['dist_cost']) 
		{
     		return TRUE;
     	}
     	else
     	{
	    	$this->form_validation->set_message('check_cost', 'Harga Konsumen (Estimasi) < Harga Tempat Pengambilan Barang (Estimasi)');
	    	return FALSE;
     	}	
    }

	function check_cost_actual($post_array) 
	{		
		if($_POST['cust_cost_actual']>=$_POST['dist_cost_actual']) 
		{
     		return TRUE;
     	}
     	else
     	{
	    	$this->form_validation->set_message('check_cost_actual', 'Harga Konsumen (Actual) < Harga Tempat Pengambilan Barang (Actual)');
	    	return FALSE;
     	}	
    }

	public function _callback_total3($value, $row)
	{
		return number_format($row->dist_cost*$row->qty_est,0,'.',',');
	}

	public function _callback_total3_actual($value, $row)
	{
		return number_format($row->dist_cost_actual*$row->qty_actual,0,'.',',');
	}

	public function _callback_margin($value, $row)
	{
		if($row->cust_cost==0 || $row->qty_est==0)
		{
			return "0";
		}
		else
		{
			return number_format((($row->cust_cost*$row->qty_est)-($row->dist_cost*$row->qty_est))*100/($row->cust_cost*$row->qty_est),2,'.',',');
		}	
	}

	public function _callback_margin_actual($value, $row)
	{
		if($row->cust_cost_actual==0 || $row->qty_actual==0)
		{
			return "0";
		}
		else
		{
			return number_format((($row->cust_cost_actual*$row->qty_actual)-($row->dist_cost_actual*$row->qty_actual))*100/($row->cust_cost_actual*$row->qty_actual),2,'.',',');
		}
	}

	public function _callback_cust_cost($value, $row)
	{
		return number_format($row->cust_cost,0,'.',',');
	}

	public function _callback_dist_cost($value, $row)
	{
		return number_format($row->dist_cost,0,'.',',');
	}

	public function _callback_cust_cost_actual($value, $row)
	{
		return number_format($row->cust_cost_actual,0,'.',',');
	}

	public function _callback_dist_cost_actual($value, $row)
	{
		return number_format($row->dist_cost_actual,0,'.',',');
	}
}
