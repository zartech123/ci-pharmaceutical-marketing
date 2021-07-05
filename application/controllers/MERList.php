<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MERList extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper(array('url','form'));

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
	 */
	public function index()
	{
		if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
		{
			$this->load->view('menu_admin.html');
			$this->load->view('merlist');
		}
		else
		{
			$this->load->view('login');
		}	
	}

	public function getList()
	{

		if($_GET['type']=="1")
		{
			$type = "Third Party";
		}	
		else if($_GET['type']=="2")
		{
			$type = "TPI";
		}	

		$result="<div class='row'>
			<div 
                class='col-xs-1' style='width:100%;text-align:left;'>
                &nbsp;&nbsp;&nbsp;&nbsp;<b>Master Event Request ".$type."</b>
			</div>
            </div>";
		$result=$result."<div class='row'>
			<div 
				class='col-xs-1' style='width:100%;height:6px'>
				&nbsp;
			</div>
            </div>";
		if($this->session->userdata('id_group')==6)
		{
			$result=$result."<div class='row'>
				<div 
					class='col-xs-1' style='width:100%'>
					&nbsp;&nbsp;&nbsp;&nbsp;<a class='btn btn-info btn-sm' href='javascript:setAddFrame(".$_GET['type'].");'>Create Form</a>
				</div>
				</div>";
		}		
		$result=$result."<div class='row'>
			<div 
				class='col-xs-1' style='width:100%;height:8px'>
				&nbsp;
			</div>
            </div>";
		$result = $result."<div class='row'>
          <div
            class='col-xs-1'
            style='width:30px;'
          >&nbsp;
          </div>
          <div
            class='col-xs-1'
            style='background-color:#5bc0de;color:white;border-left:1px solid black;border-top:1px solid black;width:160px;text-align:center;border-bottom:1px solid black;'
          >
            <b>&nbsp;Doc No&nbsp;</b>
          </div>
          <div
            class='col-xs-1'
            style='background-color:#5bc0de;color:white;border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;'
          >
            <b>&nbsp;Event Name&nbsp;</b>
          </div>
          <div
            class='col-xs-1'
            style='background-color:#5bc0de;color:white;border-left:1px solid black;border-top:1px solid black;width:250px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;'
          >
            <b>&nbsp;State&nbsp;</b>
          </div>
        </div>";
		$where = "";
		if($this->session->userdata('id_group')==6)
		{
			$where = " where state>=1 and state<=5";
		}			
		else if($this->session->userdata('id_group')==5)
		{
			$where = " where state>=2 and state<=5";
		}			
		else if($this->session->userdata('id_group')==4)
		{
			$where = " where state>=3 and state<=5";			
		}			
		else if($this->session->userdata('id_group')==3)
		{
			$where = " where state>=4 and state<=5";			
		}			
		else if($this->session->userdata('id_group')==2)
		{
			$where = " where state=5";
		}			
		$state = array("1"=>"Not Complete","2"=>"Pending Approval (Medical)","3"=>"Pending Approval (BO)","4"=>"Pending Approval (CD)","5"=>"Pending Approval (PD)","6"=>"Approved");
		$query = $this->db->query("select id_mer, type, nodoc, event_name, state from mer $where");
		foreach ($query->result() as $row2)
		{	
			$result=$result."<div class='row'>
			<div
				class='col-xs-1'
				style='width:30px;'
			>&nbsp;
			</div>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:160px;text-align:left;border-bottom:1px solid black;'
			>
				&nbsp;".$row2->nodoc."&nbsp;
			</div>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:200px;text-align:left;border-bottom:1px solid black;'
			>".$row2->event_name."
			</div>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:250px;text-align:left;border-bottom:1px solid black;border-right:1px solid black;'
			>".$state[$row2->state]."
			</div>
			<div
				class='col-xs-1'
			>
            &nbsp;<a class='btn btn-success btn-xs' href='javascript:setEditFrame(".$row2->id_mer.",".$row2->type.");'>Edit</a>
			</div>
			</div>";
		}
			$result=$result."<div class='row'>
			<div 
				class='col-xs-1' style='width:100%'>
				<hr/>
			</div>
            </div>
            ";
            
		echo $result;

	}	


}
