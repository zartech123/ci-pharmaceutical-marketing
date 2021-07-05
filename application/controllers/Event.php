<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Event extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url', 'form');
        $this->load->library('email');

        $this->load->library('session');
        $this->load->library('user_agent');

        $query = $this->db->query("SELECT name from user where id_user='" . $this->session->userdata('id_user') . "'");
        foreach ($query->result() as $row2) {
            $GLOBALS['kae'] = $row2->name;
        }

        $query = $this->db->query("select a.name, a.id_group, description from user a, groups b where a.id_group=b.id and a.id_group IN (15,19,12,7,6,5,4,3,2,10)");
        foreach ($query->result() as $row2) {
            if ($row2->id_group == 19) {
                $GLOBALS['otc-grp'] = $row2->description;
            } else if ($row2->id_group == 15) {
                $GLOBALS['kae-grp'] = $row2->description;
            } else if ($row2->id_group == 10) {
                $GLOBALS['rsm-grp'] = $row2->description;
            } else if ($row2->id_group == 12) {
                $GLOBALS['cs'] = $row2->name;
                $GLOBALS['cs-grp'] = $row2->description;
            } else if ($row2->id_group == 7) {
                $GLOBALS['kam'] = $row2->name;
                $GLOBALS['kam-grp'] = $row2->description;
            } else if ($row2->id_group == 6) {
                $GLOBALS['pm'] = $row2->name;
                $GLOBALS['pm-grp'] = $row2->description;
            } else if ($row2->id_group == 5) {
                $GLOBALS['md'] = $row2->name;
                $GLOBALS['md-grp'] = $row2->description;
            } else if ($row2->id_group == 4) {
                $GLOBALS['bo'] = $row2->name;
                $GLOBALS['bo-grp'] = $row2->description;
            } else if ($row2->id_group == 3) {
                $GLOBALS['cd'] = $row2->name;
                $GLOBALS['cd-grp'] = $row2->description;
            } else if ($row2->id_group == 2) {
                $GLOBALS['pd'] = $row2->name;
                $GLOBALS['pd-grp'] = $row2->description;
            }
        }

    }
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

        //if(isset($_GET['id_mer'])==true)
        {
            $k = 0;
            if (isset($_GET['id']) == true) {
                $query = $this->db->query("select bundling, id_area, outlet, nodoc, event_date, active, id_product_group, participant_est, booth_account, spg, title0, title1, approver0, approver1, event_name, location, booth_bank, booth_name, booth_est, booth_phone, trophy, trophy_est, sales_est, sample_est, gimmick, transportation_est, DATE_FORMAT(updated_date1,'%d-%M-%Y') as updated_date1, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, event_name, note1, state, requested_by from event_otc where id_event=" . $_GET['id']);
                foreach ($query->result() as $row2) {
                    $data = array(
                        'bundling' => $row2->bundling,
                        'event_name' => $row2->event_name,
                        'active' => $row2->active,
                        'nodoc' => $row2->nodoc,
                        'requested_by' => $row2->requested_by,
                        'location' => $row2->location,
                        'event_date' => $row2->event_date,
                        'bank' => $row2->booth_bank,
                        'booth_name' => $row2->booth_name,
                        'booth_account' => $row2->booth_account,
                        'spg' => $row2->spg,
                        'product' => $row2->id_product_group,
                        'booth_est' => $row2->booth_est,
                        'booth_phone' => $row2->booth_phone,
                        'trophy' => $row2->trophy,
                        'trophy_est' => $row2->trophy_est,
                        'sales_est' => $row2->sales_est,
                        'sample_est' => $row2->sample_est,
                        'gimmick' => $row2->gimmick,
                        'transportation_est' => $row2->transportation_est,
                        'participant_est' => $row2->participant_est,
                        'state' => $row2->state,
                        'created_date' => $row2->created_date,
                        'updated_date1' => $row2->updated_date1,
                        'note1' => $row2->note1,
                        'approver1' => $row2->approver1,
                        'approver0' => $row2->approver0,
                        'title1' => $row2->title1,
                        'title0' => $row2->title0,
                        'outlet' => $row2->outlet,
                        'id_area' => $row2->id_area
                    );
                    $k = $k + 1;
                }
            }

            if ($k == 0) {

                $query = $this->db->query("select max(nodoc)+1 as nodoc from event_otc where year='" . date("Y") . "'");
                foreach ($query->result() as $row2) {
                    if ($row2->nodoc == null) {
                        $nodoc = "0001";
                    } else {
                        $nodoc = str_pad($row2->nodoc, 4, "0", STR_PAD_LEFT);
                    }
                }

                $data = array(
                    'bundling' => "",
                    'event_name' => "",
                    'created_date' => date("d-M-Y"),
                    'active' => "1",
                    'budget' => "1",
                    'nodoc' => $nodoc,
                    'requested_by' => "9",
                    'state' => "1",
                    'location' => "",
                    'id_product_group' => "0",
                    'participant_est' => "",
                    'sample_est' => "0",
                    'booth_est' => "0",
                    'booth_name' => "",
                    'booth_phone' => "",
                    'booth_account' => "",
                    'booth_bank' => "0",
                    'perticipant_est' => "0",
                    'trophy' => "0",
                    'trophy_est' => "0",
                    'transportation_est' => "0",
                    'event_date' => "",
                    'gimmick' => "0",
                    'sales_est' => "0",
                    'spg' => "0",
                    'note1' => "",
                    'approver1' => "",
                    'approver0' => "",
                    'title1' => "",
                    'title0' => "",
                    'outlet' => "",
                    'id_area' => "",
                );
            }

            $data = array_merge($data, array('budget1' => "0"));
            $data = array_merge($data, array('description1' => ""));
            $i = 0;
            if (isset($_GET['id']) == true) {
                $query = $this->db->query("select description, budget from budget_event where id_parent=" . $_GET['id']);
                foreach ($query->result() as $row2) {
                    $cost_text = "budget" . ($i + 1);
                    $description_text = "description" . ($i + 1);
                    $data = array_merge($data, array($cost_text => $row2->budget));
                    $data = array_merge($data, array($description_text => $row2->description));
                    $i = $i + 1;

                }
                $data = array_merge($data, array('budget' => $i));
            }
            if ($i == 0) {
                $data = array_merge($data, array('description1' => ""));
                $data = array_merge($data, array('budget1' => "0"));
            }

            $jumlah = 0;
            $query = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and replace(page,'List','')='" . $this->uri->segment(1) . "' and (id_group like '" . $this->session->userdata('id_group') . ",%' or id_group like '%," . $this->session->userdata('id_group') . "' or id_group like '%," . $this->session->userdata('id_group') . ",%' or id_group='" . $this->session->userdata('id_group') . "')");
            foreach ($query->result() as $row2) {
                $jumlah = $row2->jumlah;
                if ($jumlah == 0 && isset($_GET['access'])) {
                    $query2 = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and replace(page,'List','')='" . $this->uri->segment(1) . "' and (id_group like '" . $_GET['access'] . ",%' or id_group like '%," . $_GET['access'] . "' or id_group like '%," . $_GET['access'] . ",%' or id_group='" . $_GET['access'] . "')");
                    foreach ($query2->result() as $row3) {
                        $jumlah = $row3->jumlah;
                    }
                }
            }

            if (!$this->session->userdata('id_group')) {
                $user_name = "";
                $query = $this->db->query("select user_name from user a, groups b where active=1 and a.id_group=b.id and id='" . $_GET['access'] . "'");
                foreach ($query->result() as $row2) {
                    $user_name = $row2->user_name;
                }

                $data2 = array(
                    'access' => $user_name,
                    'url' => $this->uri->uri_string() . "?id=" . $_GET['id'],
                    'id' => $_GET['id']);

                $this->load->view('login', $data2);
            } else {
                if ($jumlah == 1) {
                    $this->load->view('event', $data);
                } else {
                    $this->load->view('info2');
                }
            }

            /*if($this->session->userdata('id_group')>=1 && $this->session->userdata('id_group')<=18)
        {
        $this->load->view('event',$data);
        }
        else if($_GET['access']>=1 && $_GET['access']<=18)
        {
        $this->load->view('event',$data);
        }
        else
        {
        $this->load->view('login');
        }*/
        }
    }

    public function getAuditTrail()
    {
        $ip = $this->input->ip_address();

        $agent = "";
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }

        $agent = $agent . " " . $this->agent->platform();

        $url = current_url() . '?' . $_SERVER['QUERY_STRING'];

        $agent_full = $_SERVER['HTTP_USER_AGENT'];

        $data = array(
            'page' => $url,
            'id_user' => $this->session->userdata('id_user'),
            'ip_address' => $ip,
            'user_agent' => $agent,
            'user_agent_full' => $agent_full,
        );
        $this->db->insert("log_page", $data);

    }

    public function upload_file($field)
    {
        $config['upload_path'] = APP_PATH . 'assets/img';
        $config['allowed_types'] = '*';
        $config['file_name'] = time() . $_FILES[$field]['name'];
        $filename = "";

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($field)) {
            $error = array('error' => $this->upload->display_errors());
            $filename = array('error' => $this->upload->display_errors());
        } else {
            $upload_data = $this->upload->data();
            $filename = $upload_data['file_name'];
        }

        return $filename;
    }

	public function getProduct()
	{
		$result="[";
		$query = $this->db->query("SELECT DISTINCT id_group, name  FROM product_group where id_group in (select id_regency from user where id_group=19) ORDER BY NAME");
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id_group."\",\"name\":\"".$row2->name."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}

	public function getArea()
	{
		$result="[";
		$query = $this->db->query("SELECT DISTINCT id_area, name  FROM area_event ORDER BY name");
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id_area."\",\"name\":\"".$row2->name."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}

    public function delete()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

        $this->db->where('id_parent', $_GET['id']);
        $this->db->delete("budget_event");

        $this->db->where('id_event', $_GET['id']);
        $this->db->delete("event_otc");
        echo "This data has been deleted";
    }

    public function updateState5()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

        $this->db->set('note1', "'".$_GET['note']."'", false);
        $this->db->where('id_event', $_GET['id']);
        $this->db->update("event_otc");

        $this->db->set('state', "7", false);
        $this->db->where('id_event', $_GET['id']);
        $this->db->update("event_otc");

        echo "This data has been Rejected";
    }

    public function updateState6()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

        $this->db->set('note1', "'".$_GET['note']."'", false);
        $this->db->where('id_event', $_GET['id']);
        $this->db->update("event_otc");

        $this->db->set('state', "1", false);
        $this->db->where('id_event', $_GET['id']);
        $this->db->update("event_otc");

        $this->db->set('review', '1', false);
        $this->db->where('id_event', $_GET['id']);
        $this->db->update("event_otc");

        echo "This data has been Review";
    }

    public function updateState4()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

        $this->db->set('active', $_GET['active'], false);
        $this->db->where('id_event', $_GET['id']);
        $this->db->update("event_otc");
    }

    public function updateState()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

        $state = 0;
        $query = $this->db->query("SELECT state FROM event_otc where id_event=" . $_GET['id']);
        foreach ($query->result() as $row2) {
            $state = $row2->state;
        }

        $amount = 0;
        $ma = "nurmala.sari@ma.taisho.co.id";
        $nodoc = "";
        $event_name = "";
        $event_organizer = "";
        $created_by = "";
        $event_start_date = "";
        $event_end_date = "";
        $kam = "";
        $pm = "";
        $medical = "";
        $bo = "";
        $review = "";
        $cd = "";
        $kae = "";
        $agency = "";
        $otc = "";
        $pd = "";
        $note1 = "";
        $query = $this->db->query("SELECT sum(replace(budget,'.','')) AS amount FROM budget_event where id_parent=" . $_GET['id']);
        foreach ($query->result() as $row2) {
            $amount = $row2->amount;
        }

        $query = $this->db->query("SELECT email FROM user WHERE active=1 and id_group=20");
        foreach ($query->result() as $row2) {
            $agency = $agency . "," . $row2->email;
        }

        if ($state == 1) {
            $query = $this->db->query("SELECT email FROM user WHERE active=1 and id_user=" . $this->session->userdata('id_user'));
            foreach ($query->result() as $row2) {
                $kae = $row2->email;
            }
        } else {
            $query = $this->db->query("select email from event_otc a, user b where approver0=name and id_event=" . $_GET['id']);
            foreach ($query->result() as $row2) {
                $kae = $row2->email;
            }
        }

        $query = $this->db->query("SELECT email, id_group FROM user WHERE active=1 and id_group IN (7,6,5,4,3,2,15)");
        foreach ($query->result() as $row2) {
            if ($row2->id_group == 7) {
                $kam = $row2->email;
            } else if ($row2->id_group == 6) {
                $pm = $row2->email;
            } else if ($row2->id_group == 5) {
                $medical = $row2->email;
            } else if ($row2->id_group == 4) {
                $bo = $row2->email;
            } else if ($row2->id_group == 3) {
                $cd = $row2->email;
            } else if ($row2->id_group == 2) {
                $pd = $row2->email;
            } 
        }

        $query = $this->db->query("SELECT a.name, email, id_group FROM user a, event_otc b WHERE id_event=".$_GET['id']." and a.active=1 and id_group IN (19) and id_regency=id_product_group");
        foreach ($query->result() as $row2) {
			if ($row2->id_group == 19) {
                $GLOBALS['otc'] = $row2->name;
                $otc = $row2->email;
            }
        }

        $query = $this->db->query("SELECT (replace(booth_est,'.','')+(spg*250000)+replace(transportation_est,'.','')+replace(trophy_est,'.','')+(gimmick*10000)) as total, review, nodoc, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, event_date, location, note1, state, event_name, approver0 FROM event_otc a, user b WHERE a.requested_by=b.id_user AND id_event=" . $_GET['id']);
        foreach ($query->result() as $row2) {
            $nodoc = date("Y", strtotime($row2->created_date)) . "/OTC-BTL/" . date("m", strtotime($row2->created_date)) . "/" . $row2->nodoc;
            $note1 = $row2->note1;
            $total = $row2->total;
            $event_name = $row2->event_name;
            $event_date = $row2->event_date;
            $location = $row2->location;
            $created_by = $row2->approver0;
            $state = $row2->state;
            $review = $row2->review;
        }

        if ($state == 1) {
            $email = $otc;
        } else if ($state == 2) {
            $email = "";
            $email2 = $kae.",".$otc;
            $email3 = $otc;
        }

        if ($state == 2) {
            $this->db->set('state', '6', false);
        } else {
            $this->db->set('state', 'state+1', false);
        }
        $this->db->where('id_event', $_GET['id']);
        $this->db->update("event_otc");

        if ($state == 1) {
            $this->db->set('approver0', "'" . $GLOBALS['kae'] . "'", false);
			if($this->session->userdata('id_group')==10)
			{
				$this->db->set('title0', "'" . $GLOBALS['rsm-grp'] . "'", false);
			}
			else
			{
				$this->db->set('title0', "'" . $GLOBALS['kae-grp'] . "'", false);
			}				
            $this->db->set('approver1', "'" . $GLOBALS['otc'] . "'", false);
            $this->db->set('title1', "'" . $GLOBALS['otc-grp'] . "'", false);
            if ($review == 0) {
                $this->db->set('created_date', "now()", false);

            }
        } else if ($state == 2) {
            $this->db->set('updated_date1', "now()", false);
            $this->db->set('approver1', "'" . $GLOBALS['otc'] . "'", false);
            $this->db->set('title1', "'" . $GLOBALS['otc-grp'] . "'", false);
        } else if ($state == 3) {
            $this->db->set('updated_date2', 'now()', false);
        } else if ($state == 4) {
            $this->db->set('updated_date3', 'now()', false);
        } else if ($state == 5) {
            $this->db->set('updated_date4', 'now()', false);
        }
        $this->db->where('id_event', $_GET['id']);
        $this->db->update("event_otc");

        if ($state < 2) {
            $this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
//            $this->email->cc("yudhi_h_utama@yahoo.com");
            $this->email->to($email);
            $this->email->subject('Please Approve Event OTC with No ' . $nodoc);
            $content_html = "<table style='border: 1px solid black;'><tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'><strong>Event Name</strong></td><td style='border: 1px solid black;'><strong>Location</strong></td><td style='border: 1px solid black;'><strong>Event Date</strong></td><td style='border: 1px solid black;'><strong>Cost Estimation</strong></td><td style='border: 1px solid black;'><strong>Created By</strong></td></tr>";
            $content_html = $content_html . "<tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'>" . $event_name . "</td><td style='border: 1px solid black;'>" . $location . "</td><td style='border: 1px solid black;'>" . $event_date . "</td><td style='border: 1px solid black;'>" . ($amount + $total) . "</td><td style='border: 1px solid black;'>" . $created_by . "</td></tr></table>";
            $content_html = $content_html . "<br><br>";
            $content_html = $content_html . "Please Click this link to <a href='" . base_url() . "index.php/Event?id=" . $_GET['id'] . "&access=19'>Approve or Review or Reject</a>";
            $content_html = $content_html . "<br><br>";
            $this->email->message($content_html);

            if ($this->email->send()) {
                $this->session->set_flashdata("email_sent", "Congratulation Email Send Successfully.");
            } else {
                $this->session->set_flashdata("email_sent", "You have encountered an error");
            }
        }

        if ($state >= 2) {
            $this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
//            $this->email->cc("yudhi_h_utama@yahoo.com");
            $this->email->to($email2.$agency);
            $this->email->subject('Event OTC with No ' . $nodoc . ' has been Approved by ' . $email3);
            $content_html = "<table style='border: 1px solid black;'><tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'><strong>Event Name</strong></td><td style='border: 1px solid black;'><strong>Location</strong></td><td style='border: 1px solid black;'><strong>Event Date</strong></td><td style='border: 1px solid black;'><strong>Cost Estimation</strong></td><td style='border: 1px solid black;'><strong>Created By</strong></td></tr>";
            $content_html = $content_html . "<tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'>" . $event_name . "</td><td style='border: 1px solid black;'>" . $location . "</td><td style='border: 1px solid black;'>" . $event_date . "</td><td style='border: 1px solid black;'>" . ($amount + $total) . "</td><td style='border: 1px solid black;'>" . $created_by . "</td></tr></table>";
            $content_html = $content_html . "<br><br>";
            $this->email->message($content_html);

            if ($this->email->send()) {
                $this->session->set_flashdata("email_sent", "Congratulation Email Send Successfully.");
            } else {
                $this->session->set_flashdata("email_sent", "You have encountered an error");
            }
        }

    }

    public function updateState3()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

        $amount = 0;
        $nodoc = "";
        $event_name = "";
        $event_organizer = "";
        $created_by = "";
        $event_start_date = "";
        $event_end_date = "";
        $kam = "";
        $pm = "";
        $medical = "";
        $bo = "";
        $cd = "";
        $pd = "";
        $kae = "";
        $otc = "";
        $note1 = "";
        $state = 0;
        $query = $this->db->query("SELECT sum(replace(budget,'.','')) AS amount FROM budget_event where id_parent=" . $_GET['id']);
        foreach ($query->result() as $row2) {
            $amount = $row2->amount;
        }

            $query = $this->db->query("select email from event_otc a, user b where approver0=name and id_event=" . $_GET['id']);
            foreach ($query->result() as $row2) {
                $kae = $row2->email;
            }

        $query = $this->db->query("SELECT email, id_group FROM user WHERE active=1 and id_group IN (7,6,5,4,3,2,15)");
        foreach ($query->result() as $row2) {
            if ($row2->id_group == 7) {
                $kam = $row2->email;
            } else if ($row2->id_group == 6) {
                $pm = $row2->email;
            } else if ($row2->id_group == 5) {
                $medical = $row2->email;
            } else if ($row2->id_group == 4) {
                $bo = $row2->email;
            } else if ($row2->id_group == 3) {
                $cd = $row2->email;
            } else if ($row2->id_group == 2) {
                $pd = $row2->email;
            } 
        }

        $query = $this->db->query("SELECT a.name, email, id_group FROM user a, event_otc b WHERE id_event=".$_GET['id']." and a.active=1 and id_group IN (19) and id_regency=id_product_group");
        foreach ($query->result() as $row2) {
			if ($row2->id_group == 19) {
                $otc = $row2->email;
            }
        }

        $query = $this->db->query("SELECT (replace(booth_est,'.','')+(spg*250000)+replace(transportation_est,'.','')+replace(trophy_est,'.','')+(gimmick*10000)) as total, review, nodoc, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, event_date, location, note1, state, event_name, approver0 FROM event_otc a, user b WHERE a.requested_by=b.id_user AND id_event=" . $_GET['id']);
        foreach ($query->result() as $row2) {
            $nodoc = date("Y", strtotime($row2->created_date)) . "/OTC-BTL/" . date("m", strtotime($row2->created_date)) . "/" . $row2->nodoc;
            $note1 = $row2->note1;
            $total = $row2->total;
            $event_name = $row2->event_name;
            $event_date = $row2->event_date;
            $location = $row2->location;
            $created_by = $row2->approver0;
            $state = $row2->state;
            $review = $row2->review;
        }

        if ($state == 2) {
            $note = $note1;
            $email2 = $kae;
            $email3 = $otc;
        }

        $data = array(
            'state' => "7");
        $this->db->where('id_event', $_GET['id']);
        $this->db->update("event_otc", $data);

        if ($state >= 2) {
            $this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
            $this->email->to($email2);
            $this->email->subject('Event OTC with No ' . $nodoc . ' has been Rejected by ' . $email3);
            $content_html = "<table style='border: 1px solid black;'><tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'><strong>Event Name</strong></td><td style='border: 1px solid black;'><strong>Location</strong></td><td style='border: 1px solid black;'><strong>Event Date</strong></td><td style='border: 1px solid black;'><strong>Cost Estimation</strong></td><td style='border: 1px solid black;'><strong>Created By</strong></td></tr>";
            $content_html = $content_html . "<tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'>" . $event_name . "</td><td style='border: 1px solid black;'>" . $location . "</td><td style='border: 1px solid black;'>" . $event_date . "</td><td style='border: 1px solid black;'>" . number_format(($amount + $total), 0) . "</td><td style='border: 1px solid black;'>" . $created_by . "</td></tr></table>";
            $content_html = $content_html . "<br><br>";
            $this->email->message($content_html);

            if ($this->email->send()) {
                $this->session->set_flashdata("email_sent", "Congratulation Email Send Successfully.");
            } else {
                $this->session->set_flashdata("email_sent", "You have encountered an error");
            }
        }

    }

    public function updateState2()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

        $amount = 0;
        $nodoc = "";
        $event_name = "";
        $event_organizer = "";
        $created_by = "";
        $event_start_date = "";
        $event_end_date = "";
        $kam = "";
        $pm = "";
        $medical = "";
        $bo = "";
        $cd = "";
        $pd = "";
        $kae = "";
        $otc = "";
        $note1 = "";
        $state = 0;
        $query = $this->db->query("SELECT sum(replace(budget,'.','')) AS amount FROM budget_event where id_parent=" . $_GET['id']);
        foreach ($query->result() as $row2) {
            $amount = $row2->amount;
        }

            $query = $this->db->query("select email from event_otc a, user b where approver0=name and id_event=" . $_GET['id']);
            foreach ($query->result() as $row2) {
                $kae = $row2->email;
            }

        $query = $this->db->query("SELECT email, id_group FROM user WHERE active=1 and id_group IN (7,6,5,4,3,2,15)");
        foreach ($query->result() as $row2) {
            if ($row2->id_group == 7) {
                $kam = $row2->email;
            } else if ($row2->id_group == 6) {
                $pm = $row2->email;
            } else if ($row2->id_group == 5) {
                $medical = $row2->email;
            } else if ($row2->id_group == 4) {
                $bo = $row2->email;
            } else if ($row2->id_group == 3) {
                $cd = $row2->email;
            } else if ($row2->id_group == 2) {
                $pd = $row2->email;
            } 
        }

        $query = $this->db->query("SELECT a.name, email, id_group FROM user a, event_otc b WHERE id_event=".$_GET['id']." and a.active=1 and id_group IN (19) and id_regency=id_product_group");
        foreach ($query->result() as $row2) {
			if ($row2->id_group == 19) {
                $otc = $row2->email;
            }
        }

        $query = $this->db->query("SELECT (replace(booth_est,'.','')+(spg*250000)+replace(transportation_est,'.','')+replace(trophy_est,'.','')+(gimmick*10000)) as total, review, nodoc, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, event_date, location, note1, state, event_name, approver0 FROM event_otc a, user b WHERE a.requested_by=b.id_user AND id_event=" . $_GET['id']);
        foreach ($query->result() as $row2) {
            $nodoc = date("Y", strtotime($row2->created_date)) . "/OTC-BTL/" . date("m", strtotime($row2->created_date)) . "/" . $row2->nodoc;
            $note1 = $row2->note1;
            $total = $row2->total;
            $event_name = $row2->event_name;
            $event_date = $row2->event_date;
            $location = $row2->location;
            $created_by = $row2->approver0;
            $state = $row2->state;
            $review = $row2->review;
        }

        if ($state == 2) {
            $note = $note1;
            $email2 = $kae;
            $email3 = $otc;
        }

        $this->db->set('state', '1', false);
        $this->db->where('id_event', $_GET['id']);
        $this->db->update("event_otc");

        $this->db->set('review', '1', false);
        $this->db->where('id_event', $_GET['id']);
        $this->db->update("event_otc");

        if ($state >= 2) {
            $this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
            $this->email->to($email2);
            $this->email->subject($email3 . ' Request to review Event OTC with No ' . $nodoc);
            $content_html = "<table style='border: 1px solid black;'><tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'><strong>Event Name</strong></td><td style='border: 1px solid black;'><strong>Location</strong></td><td style='border: 1px solid black;'><strong>Event Date</strong></td><td style='border: 1px solid black;'><strong>Cost Estimation</strong></td><td style='border: 1px solid black;'><strong>Created By</strong></td></tr>";
            $content_html = $content_html . "<tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'>" . $event_name . "</td><td style='border: 1px solid black;'>" . $location . "</td><td style='border: 1px solid black;'>" . $event_date . "</td><td style='border: 1px solid black;'>" . number_format(($amount + $total), 0) . "</td><td style='border: 1px solid black;'>" . $created_by . "</td></tr></table>";
            $content_html = $content_html . "<br><br>";
            $this->email->message($content_html);

            if ($this->email->send()) {
                $this->session->set_flashdata("email_sent", "Congratulation Email Send Successfully.");
            } else {
                $this->session->set_flashdata("email_sent", "You have encountered an error");
            }
        }

    }

    public function add()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

        $i = 0;
        $j = 0;

		if (empty($this->input->post('id_parent'))) 
		{
			$query = $this->db->query("select max(nodoc)+1 as nodoc from event_otc where id_product_group='".$this->input->post('product')."' and year='".date("Y")."'");
			foreach ($query->result() as $row2) {
				if ($row2->nodoc == null) {
					$nodoc = "0001";
				} else {
					$nodoc = str_pad($row2->nodoc, 4, "0", STR_PAD_LEFT);
				}
			}
		}
		else
		{
			$nodoc = $this->input->post('nodoc2');
		}			

        $data = array(
            'event_name' => $this->input->post('event_name'),
            'id_product_group' => $this->input->post('product'),
            'location' => $this->input->post('location'),
            'event_date' => $this->input->post('event_date2'),
            'participant_est' => str_replace('.','',$this->input->post('participant_est')),
            'booth_est' => $this->input->post('booth_est'),
            'booth_account' => $this->input->post('booth_account'),
            'booth_bank' => $this->input->post('bank'),
            'booth_name' => $this->input->post('booth_name'),
            'booth_phone' => $this->input->post('booth_phone'),
            'note1' => $this->input->post('note1'),
            'requested_by' => $this->input->post('requested_by'),
            'trophy' => $this->input->post('trophy'),
            'trophy_est' => $this->input->post('trophy_est'),
            'spg' => $this->input->post('spg'),
            'bundling' => $this->input->post('bundling'),
            'transportation_est' => $this->input->post('transportation_est'),
            'gimmick' => $this->input->post('gimmick'),
            'sales_est' => $this->input->post('sales_est'),
            'nodoc' => $nodoc,
            'sample_est' => $this->input->post('sample_est'),
            'id_area' => $this->input->post('area'),
            'outlet' => $this->input->post('outlet')
        );
        if (empty($this->input->post('id_parent'))) {
            $this->db->insert("event_otc", $data);
            $id_hcp = $this->db->insert_id();
        } else {
            $this->db->where('id_event', $this->input->post('id_parent'));
            $this->db->update("event_otc", $data);
            $id_hcp = $this->input->post('id_parent');

            $query = $this->db->query("select id_budget from budget_event where id_parent=" . $id_hcp . " order by id_budget");
            foreach ($query->result() as $row2) {
                $id_budget[] = $row2->id_budget;
                $j = $j + 1;
            }

        }

        //

        $cost = $this->input->post('budget');
        $description = $this->input->post('description');

        $k = 0;
        foreach ($description as $a) {
            $data3 = array(
                'budget' => $cost[$k],
                'id_parent' => $id_hcp,
                'description' => $description[$k],
            );
            if (empty($id_budget[0 + $k])) {
                $this->db->insert("budget_event", $data3);
            } else {
                $this->db->where('id_budget', $id_budget[0 + $k]);
                $this->db->update("budget_event", $data3);
            }
            $k = $k + 1;
        }
        if ($j > $k) {
            for ($l = ($k + 0); $l < $j; $l++) {
                $this->db->where('id_budget', $id_budget[$l]);
                $this->db->delete('budget_event');
            }
        }

        //Charge Product

        redirect(base_url() . "index.php/Event?id=" . $id_hcp);

    }

    public function deleteAttachment()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

        $query = $this->db->query("select file_name from attachment where id_attachment=" . $_GET['id']);
        foreach ($query->result() as $row2) {
            unlink(APP_PATH . 'assets/img/' . $row2->file_name);
            $this->db->where('id_attachment', $_GET['id']);
            $this->db->delete('attachment');
        }
    }

    public function getListAttachment()
    {
        $type = 0;
        echo $type;
    }

    public function getAttachment()
    {

        $type = 0;

        $result = "";
        $file_type = array("1" => "Others");
        $query = $this->db->query("select id_attachment, file_name, file_type from attachment where type=11 and id_parent=" . $_GET['id'] . " order by file_type");
        foreach ($query->result() as $row2) {
            $result = $result . "<div class='row'>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:240px;text-align:center;border-bottom:1px solid black;word-wrap: break-word;'
			>
				&nbsp;<a href='" . base_url() . "/assets/img/" . $row2->file_name . "' target='popup'>" . $row2->file_name . "</a>&nbsp;
			</div>
			<div
				class='col-xs-1'
				style='border-left:1px solid black;width:160px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;word-wrap: break-word;'
			>
				&nbsp;" . $file_type[$row2->file_type] . "&nbsp;
			</div>
			<div
				class='col-xs-1'
			>
			";
            if (($this->session->userdata('id_group') == 15) && $_GET['state'] == "1") {
                $result = $result . "<a href='javascript:deleteAttachment(" . $row2->id_attachment . ")'><i class='fa fa-times fa-2x' aria-hidden='true'></i></a>";
            }
            $result = $result . "</div>
			</div>";
        }
        /*if($type<14)
        {
        $result=$result."<div class='row'>
        <div
        class='col-xs-1'
        style='border-left:1px solid black;width:320px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;color:red'
        >
        &nbsp;Please submit KTP, NPWP, Bank Account & CV
        </div></div>";
        }*/
        echo $result;

    }

    public function getSKUPIC()
    {

        $result = "0";
        $query = $this->db->query("select count(*) as jumlah from event_sku where id_event=" . $_GET['id']);
        foreach ($query->result() as $row2) {
			if($row2->jumlah>0)
			{
				$result = $result + 1;
			}	
        }
        $query = $this->db->query("select count(*) as jumlah from event_pic where id_event=" . $_GET['id']);
        foreach ($query->result() as $row2) {
			if($row2->jumlah>0)
			{
				$result = $result + 1;
			}	
        }
        echo $result;

    }

    public function getPM()
    {

        $name = "0";
        $query = $this->db->query("SELECT name FROM user where active=1 and id_group IN (19) and id_regency=".$_GET['id']);
        foreach ($query->result() as $row2) {
            $name = $row2->name;
        }
        echo $name;

    }

    public function getSKU()
    {

        $result = "0";
        $query = $this->db->query("select sum(cust_cost*qty_est) as total from event_sku where id_event=" . $_GET['id']);
        foreach ($query->result() as $row2) {
            $result = $result + $row2->total;
        }
        echo $result;

    }

    public function upload()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

        $file_name = $this->upload_file('file');
        $data = array(
            'file_name' => $file_name,
            'type' => "11",
            'file_type' => $this->input->post('file_type'),
            'id_parent' => $this->input->post('id_parent'),
        );
        $this->db->insert("attachment", $data);
    }

}