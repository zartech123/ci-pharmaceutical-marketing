<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class InviteHCP extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
		$this->load->library('session');
	}

	public function _user_output($output = null)
	{
		$this->load->view('invite_hcp',(array)$output);
	}

	
	public function index()
	{
		try{
			date_default_timezone_set('Asia/Jakarta');

			$crud = new Grocery_CRUD();
			if($this->session->userdata('id_user'))	$this->getAuditTrail();
			$crud->set_theme('bootstrap');
			$crud->set_table('attendance_hcp');
			$crud->set_subject('HCP Attendance List');
                        
            if($this->uri->segment(4)!=null)
            {
				$crud->where('attendance_hcp.id_hcp1',$this->uri->segment(4));
            }
  			$crud->set_relation('id_hcp1','hcp1','nodoc2');
            $crud->columns('id_hcp1','name','position','type');
			$crud->fields('id_hcp1','name','position','type');
			if($this->uri->segment(6)!=null)
			{
				$crud->unset_delete();
				$crud->unset_edit();
				$crud->unset_add();
			}
			$crud->unset_read();
			$crud->unset_print();
            $crud->unset_clone();
			$crud->display_as('id_hcp1','No Docs');
			$crud->set_lang_string('form_update_changes','Update');
			$crud->set_lang_string('form_update_and_go_back','Update & Return');
			$crud->set_lang_string('form_save_and_go_back','Save & Return');
			$crud->set_lang_string('form_upload_delete','Delete');

            $crud->callback_add_field('id_hcp1', function () 
            {
				$query2 = $this->db->query("SELECT nodoc FROM hcp1 where id_hcp1='".$this->uri->segment(4)."'");
				$nodoc="";
				foreach ($query2->result() as $row2)
				{						
					$nodoc=$row2->nodoc;
				}

				return $nodoc.'<input type="text" value='.$this->uri->segment(4).' name="id_hcp1" style="visibility:hidden">';
            });


            $crud->callback_edit_field('id_hcp1', function () 
            {
				$query2 = $this->db->query("SELECT nodoc FROM hcp1 where id_hcp1='".$this->uri->segment(4)."'");
				$nodoc="";
				foreach ($query2->result() as $row2)
				{						
					$nodoc=$row2->nodoc;
				}

				return $nodoc.'<input type="text" value='.$this->uri->segment(4).' name="id_hcp1" style="visibility:hidden">';
            });

			$output = $crud->render();
    		if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
			{	
//				$this->load->view('menu_admin.html');
				$this->_user_output($output);
			}	
			else
			{
				redirect("/Login");
			}


		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	
	//		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}
}
