<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EventReport extends CI_Controller
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

        $query = $this->db->query("SELECT name from user where id_user='" . $this->session->userdata('id_user') . "'");
        foreach ($query->result() as $row2) {
            $GLOBALS['agency'] = $row2->name;
        }

        $query = $this->db->query("select a.name, a.id_group, description from user a, groups b where a.id_group=b.id and a.id_group IN (20,15,19,12,7,6,5,4,3,2)");
        foreach ($query->result() as $row2) {
            if ($row2->id_group == 20) {
                $GLOBALS['agency-grp'] = $row2->description;
            } else if ($row2->id_group == 19) {
                $GLOBALS['otc'] = $row2->name;
                $GLOBALS['otc-grp'] = $row2->description;
            } else if ($row2->id_group == 15) {
                $GLOBALS['kae-grp'] = $row2->description;
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

        if(isset($_GET['id_event'])==true)
        {
            $k = 0;
            if (isset($_GET['id']) == true) {
                $query = $this->db->query("select id_product_group, participant_actual, booth_actual, DATE_FORMAT(booth_date,'%d/%m/%Y') as booth_date, DATE_FORMAT(trophy_date,'%d/%m/%Y') as trophy_date, trophy_actual, transportation_actual, gimmick_actual, sample_actual, spg_actual, DATE_FORMAT(transportation_date,'%d/%m/%Y') as transportation_date, b.nodoc, event_date, b.active, id_product_group, participant_est, booth_account, spg, b.title0, b.title1, b.approver0, b.approver1, event_name, location, booth_bank, booth_name, booth_est, booth_phone, trophy, trophy_est, sales_est, sample_est, gimmick, transportation_est, DATE_FORMAT(b.updated_date1,'%d-%M-%Y') as updated_date1, DATE_FORMAT(b.created_date,'%d-%M-%Y') as created_date, event_name, b.note1, b.state, b.requested_by from event_report b, event_otc a where a.id_event=b.id_event and id_report=". $_GET['id']);
                foreach ($query->result() as $row2) {
                    $data = array(
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
						'product' => $row2->id_product_group,
                    'participant_actual' => $row2->participant_actual,
                    'transportation_date' => $row2->transportation_date,
                    'trophy_date' => $row2->trophy_date,
                    'booth_date' => $row2->booth_date,
                    'sample_actual' => $row2->sample_actual,
                    'booth_actual' => $row2->booth_actual,
                    'trophy_actual' => $row2->trophy_actual,
                    'transportation_actual' => $row2->transportation_actual,
                    'gimmick_actual' => $row2->gimmick_actual,
                    'spg_actual' => $row2->spg_actual,
                    );
                    $k = $k + 1;
                }
            }

            if ($k == 0) {

                $query = $this->db->query("select nodoc, event_date, active, id_product_group, participant_est, booth_account, spg, title0, title1, approver0, approver1, event_name, location, booth_bank, booth_name, booth_est, booth_phone, trophy, trophy_est, sales_est, sample_est, gimmick, transportation_est, DATE_FORMAT(updated_date1,'%d-%M-%Y') as updated_date1, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, event_name, note1, state, requested_by from event_otc where id_event=" . $_GET['id_event']);
                foreach ($query->result() as $row2) {
                    $data = array(
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
                        'state' => "1",
                        'created_date' => date("d-m-Y"),						
                        'updated_date1' => "",						
						'note1' => "",
						'approver1' => "",
						'approver0' => "",
						'title1' => "",
						'title0' => "",
                    );
                    $k = $k + 1;
                }

                $query = $this->db->query("select max(nodoc)+1 as nodoc from event_report where year='" . date("Y") . "'");
                foreach ($query->result() as $row2) {
                    if ($row2->nodoc == null) {
                        $nodoc = "0001";
                    } else {
                        $nodoc = str_pad($row2->nodoc, 4, "0", STR_PAD_LEFT);
                    }
                }

                $data = array_merge($data,array('participant_actual' => "0"));
                $data = array_merge($data,array('transportation_date' => date("d/m/Y")));
                $data = array_merge($data,array('trophy_date' => date("d/m/Y")));
                $data = array_merge($data,array('booth_date' => date("d/m/Y")));
                $data = array_merge($data,array('sample_actual' => "0"));
                $data = array_merge($data,array('booth_actual' => "0"));
                $data = array_merge($data,array('trophy_actual' => "0"));
                $data = array_merge($data,array('transportation_actual' => "0"));
                $data = array_merge($data,array('gimmick_actual' => "0"));
                $data = array_merge($data,array('spg_actual' => "0"));
            }

            $data = array_merge($data, array('actual1' => "0"));
            $data = array_merge($data, array('est1' => "0"));
            $data = array_merge($data, array('description1' => ""));
            $data = array_merge($data, array('actl_date1' => ""));
            $i = 0;
            if (isset($_GET['id']) == true) {
                $query = $this->db->query("select description, actual, est, DATE_FORMAT(actual_date,'%d/%m/%Y') as actual_date from budget_event_report where id_parent=" . $_GET['id']);
                foreach ($query->result() as $row2) {
                    $cost_text = "actual" . ($i + 1);
                    $description_text = "description" . ($i + 1);
                    $date_text = "actl_date" . ($i + 1);
                    $est_text = "est" . ($i + 1);
                    $data = array_merge($data, array($date_text => $row2->actual_date));
                    $data = array_merge($data, array($cost_text => $row2->actual));
                    $data = array_merge($data, array($est_text => $row2->est));
                    $data = array_merge($data, array($description_text => $row2->description));
                    $i = $i + 1;

                }
            }
            $data = array_merge($data, array('budget' => $i));			
            if ($i == 0) {
				$query = $this->db->query("select budget, description from budget_event where id_parent=".$_GET['id_event']);
				foreach ($query->result() as $row2)
				{
                    $cost_text = "actual" . ($i + 1);
                    $description_text = "description" . ($i + 1);
                    $date_text = "actl_date" . ($i + 1);
                    $est_text = "est" . ($i + 1);
                    $data = array_merge($data, array($date_text => date("d/m/Y")));
                    $data = array_merge($data, array($cost_text => "0"));
                    $data = array_merge($data, array($est_text => $row2->budget));
                    $data = array_merge($data, array($description_text => $row2->description));
					$i = $i + 1;

				}	
				$data = array_merge($data, array('budget'=>$i));


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
                    'url' => $this->uri->uri_string() . "?id=" . $_GET['id_event'],
                    'id' => $_GET['id_event']);

                $this->load->view('login', $data2);
            } else {
                if ($jumlah == 1) {
                    $this->load->view('event-report', $data);
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

    public function delete()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

        $this->db->where('id_parent', $_GET['id']);
        $this->db->delete("budget_event_report");

        $this->db->where('id_report', $_GET['id']);
        $this->db->delete("event_report");
        echo "This data has been deleted";
    }

    public function updateState5()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

        $this->db->set('state', "7", false);
        $this->db->where('id_report', $_GET['id']);
        $this->db->update("event_report");

        echo "This data has been Rejected";
    }

    public function updateState6()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

        $this->db->set('state', "1", false);
        $this->db->where('id_report', $_GET['id']);
        $this->db->update("event_report");

        $this->db->set('review', '1', false);
        $this->db->where('id_report', $_GET['id']);
        $this->db->update("event_report");

        echo "This data has been Review";
    }

    public function updateState4()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

        $this->db->set('active', $_GET['active'], false);
        $this->db->where('id_report', $_GET['id']);
        $this->db->update("event_report");
    }

    public function updateState()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

        $state = 0;
        $query = $this->db->query("SELECT state FROM event_report where id_report=" . $_GET['id']);
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
        $query = $this->db->query("SELECT sum(replace(actual,'.','')) AS amount FROM budget_event_report where id_parent=" . $_GET['id']);
        foreach ($query->result() as $row2) {
            $amount = $row2->amount;
        }

        /*$query = $this->db->query("SELECT email FROM user WHERE active=1 and id_group=20");
        foreach ($query->result() as $row2) {
            $agency = $agency . ";" . $row2->email;
        }*/

        if ($state == 1) {
            $query = $this->db->query("SELECT email FROM user WHERE active=1 and id_user=" . $this->session->userdata('id_user'));
            foreach ($query->result() as $row2) {
                $agency = $row2->email;
            }
        } else {
            $query = $this->db->query("select email from event_report a, user b where approver0=name and id_report=" . $_GET['id']);
            foreach ($query->result() as $row2) {
                $agency = $row2->email;
            }
        }

        $query = $this->db->query("SELECT email, id_group FROM user WHERE active=1 and id_group IN (20,7,6,5,4,3,2,15,19)");
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

        $query = $this->db->query("SELECT a.name, email, id_group FROM user a, event_report b WHERE id_report=".$_GET['id']." and a.active=1 and id_group IN (19) and id_regency=id_product_group");
        foreach ($query->result() as $row2) {
			if ($row2->id_group == 19) {
                $GLOBALS['otc'] = $row2->name;
                $otc = $row2->email;
            }
        }


        $query = $this->db->query("SELECT c.code, (replace(booth_actual,'.','')+(spg_actual*250000)+replace(transportation_actual,'.','')+replace(trophy_actual,'.','')+(gimmick_actual*10000)) as total, review, nodoc, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, note1, state, b.name FROM event_report a, user b, product_group c WHERE b.id_regency=c.id_group and a.requested_by=b.id_user AND id_report=" . $_GET['id']);
        foreach ($query->result() as $row2) {
            $nodoc = date("Y", strtotime($row2->created_date))."/".$row2->code."-OTC-BTL/" . date("m", strtotime($row2->created_date)) . "/" . $row2->nodoc;
            $note1 = $row2->note1;
            $total = $row2->total;
//            $event_name = $row2->event_name;
//            $event_date = $row2->event_date;
//            $location = $row2->location;
            $created_by = $row2->name;
            $state = $row2->state;
            $review = $row2->review;
        }

        if ($state == 1) {
            $email = $otc;
        } else if ($state == 2) {
            $email = "";
            $email2 = $agency;
            $email3 = $otc;
        }

        if ($state == 2) {
            $this->db->set('state', '6', false);
        } else {
            $this->db->set('state', 'state+1', false);
        }
        $this->db->where('id_report', $_GET['id']);
        $this->db->update("event_report");

        if ($state == 1) {
            $this->db->set('approver0', "'" . $GLOBALS['agency'] . "'", false);
            $this->db->set('title0', "'" . $GLOBALS['agency-grp'] . "'", false);
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
        $this->db->where('id_report', $_GET['id']);
        $this->db->update("event_report");

        if ($state < 2) {
            $this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
//            $this->email->cc("yudhi_h_utama@yahoo.com");
            $this->email->to($email);
//            $this->email->cc($ma);
            $this->email->subject('Please Approve Event OTC Report with No ' . $nodoc);
            $content_html = "<table style='border: 1px solid black;'><tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'><strong>Event Name</strong></td><td style='border: 1px solid black;'><strong>Location</strong></td><td style='border: 1px solid black;'><strong>Event Date</strong></td><td style='border: 1px solid black;'><strong>Cost Estimation</strong></td><td style='border: 1px solid black;'><strong>Created By</strong></td></tr>";
            $content_html = $content_html . "<tr style='text-align:center;border: 1px solid black;'><td style='border: 1px solid black;'>" . $event_name . "</td><td style='border: 1px solid black;'>" . $location . "</td><td style='border: 1px solid black;'>" . $event_date . "</td><td style='border: 1px solid black;'>" . ($amount + $total) . "</td><td style='border: 1px solid black;'>" . $created_by . "</td></tr></table>";
            $content_html = $content_html . "<br><br>";
            $content_html = $content_html . "Please Click this link to <a href='" . base_url() . "index.php/EventReport?id=" . $_GET['id'] . "&access=19'>Approve or Review or Reject</a>";
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
            $this->email->to($email2);
//            $this->email->cc($ma);
            $this->email->subject('Event OTC Report with No ' . $nodoc . ' has been Approved by ' . $email3);
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
        $query = $this->db->query("SELECT sum(replace(actual,'.','')) AS amount FROM budget_event_report where id_parent=" . $_GET['id']);
        foreach ($query->result() as $row2) {
            $amount = $row2->amount;
        }

        $query = $this->db->query("SELECT email FROM user WHERE active=1 and id_user=" . $this->session->userdata('id_user'));
        foreach ($query->result() as $row2) {
            $agency = $row2->email;
        }

        $query = $this->db->query("SELECT email, id_group FROM user WHERE active=1 and id_group IN (20,7,6,5,4,3,2,15,19)");
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

        $query = $this->db->query("SELECT a.name, email, id_group FROM user a, event_report b WHERE id_report=".$_GET['id']." and a.active=1 and id_group IN (19) and id_regency=id_product_group");
        foreach ($query->result() as $row2) {
			if ($row2->id_group == 19) {
                $GLOBALS['otc'] = $row2->name;
                $otc = $row2->email;
            }
        }

        $query = $this->db->query("SELECT c.code, (replace(booth_actual,'.','')+(spg_actual*250000)+replace(transportation_actual,'.','')+replace(trophy_actual,'.','')+(gimmick_actual*10000)) as total, review, nodoc, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, note1, state, b.name FROM event_report a, user b, product_group c WHERE b.id_regency=c.id_group and a.requested_by=b.id_user AND id_report=" . $_GET['id']);
        foreach ($query->result() as $row2) {
            $nodoc = date("Y", strtotime($row2->created_date)) . "/".$row2->code."-OTC-BTL/" . date("m", strtotime($row2->created_date)) . "/" . $row2->nodoc;
            $note1 = $row2->note1;
            $total = $row2->total;
//            $event_name = $row2->event_name;
//            $event_date = $row2->event_date;
//            $location = $row2->location;
            $created_by = $row2->name;
            $state = $row2->state;
            $review = $row2->review;
        }

        if ($state == 2) {
            $note = $note1;
            $email2 = $agency;
            $email3 = $otc;
        }

        $data = array(
            'state' => "7");
        $this->db->where('id_report', $_GET['id']);
        $this->db->update("event_report", $data);

        if ($state >= 2) {
            $this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
            $this->email->to($email2);
            $this->email->subject('Event OTC Report with No ' . $nodoc . ' has been Rejected by ' . $email3);
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
        $query = $this->db->query("SELECT sum(replace(actual,'.','')) AS amount FROM budget_event_report where id_parent=" . $_GET['id']);
        foreach ($query->result() as $row2) {
            $amount = $row2->amount;
        }

        $query = $this->db->query("SELECT email FROM user WHERE active=1 and id_user=" . $this->session->userdata('id_user'));
        foreach ($query->result() as $row2) {
            $agency = $row2->email;
        }

        $query = $this->db->query("SELECT email, id_group FROM user WHERE active=1 and id_group IN (20,7,6,5,4,3,2,15,19)");
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

        $query = $this->db->query("SELECT a.name, email, id_group FROM user a, event_report b WHERE id_report=".$_GET['id']." and a.active=1 and id_group IN (19) and id_regency=id_product_group");
        foreach ($query->result() as $row2) {
			if ($row2->id_group == 19) {
                $GLOBALS['otc'] = $row2->name;
                $otc = $row2->email;
            }
        }

        $query = $this->db->query("SELECT c.code, (replace(booth_actual,'.','')+(spg_actual*250000)+replace(transportation_actual,'.','')+replace(trophy_actual,'.','')+(gimmick_actual*10000)) as total, review, nodoc, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, note1, state, b.name FROM event_report a, user b, product_group c WHERE b.id_regency=c.id_group and a.requested_by=b.id_user AND id_report=" . $_GET['id']);
        foreach ($query->result() as $row2) {
            $nodoc = date("Y", strtotime($row2->created_date)) . "/".$row2->code."-OTC-BTL/" . date("m", strtotime($row2->created_date)) . "/" . $row2->nodoc;
            $note1 = $row2->note1;
            $total = $row2->total;
//            $event_name = $row2->event_name;
//            $event_date = $row2->event_date;
//            $location = $row2->location;
            $created_by = $row2->name;
            $state = $row2->state;
            $review = $row2->review;
        }

        if ($state == 2) {
            $note = $note1;
            $email2 = $agency;
            $email3 = $otc;
        }

        $this->db->set('state', '1', false);
        $this->db->where('id_report', $_GET['id']);
        $this->db->update("event_report");

        $this->db->set('review', '1', false);
        $this->db->where('id_report', $_GET['id']);
        $this->db->update("event_report");

        $data = array(
            'approver1' => '',
            'approver0' => '',
            'title1' => '',
            'title0' => '',
        );

        $this->db->where('id_report', $_GET['id']);
        $this->db->update("event_report", $data);

        if ($state >= 2) {
            $this->email->from('esponsorship@onetpi.co.id', 'Taisho E-Sponsorship Administrator');
            $this->email->to($email2);
            $this->email->subject($email3 . ' Request to review Event OTC Report with No ' . $nodoc);
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

 
	public function getProduct()
	{
		$result="[";
		$query = $this->db->query("SELECT DISTINCT id_group, name  FROM product_group where id_group=".$_GET['id']." and id_group in (select id_regency from user where id_group=19) ORDER BY NAME");
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id_group."\",\"name\":\"".$row2->name."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}
 
 
   public function add()
    {
        if ($this->session->userdata('id_user')) {
            $this->getAuditTrail();
        }

		$booth_date = explode('/', $this->input->post('booth_date'));
        $booth_date2 = $booth_date[2].'-'.$booth_date[1].'-'.$booth_date[0];

		$trophy_date = explode('/', $this->input->post('trophy_date'));
        $trophy_date2 = $trophy_date[2].'-'.$trophy_date[1].'-'.$trophy_date[0];

		$transportation_date = explode('/', $this->input->post('transportation_date'));
        $transportation_date2 = $transportation_date[2].'-'.$transportation_date[1].'-'.$transportation_date[0];

        $i = 0;
        $j = 0;

        $data = array(
            'id_event' => $this->input->post('id_event'),
            'participant_actual' => str_replace('.','',$this->input->post('participant_actual')),
            'booth_actual' => $this->input->post('booth_actual'),
            'booth_date' => $booth_date2,
            'note1' => $this->input->post('note1'),
            'requested_by' => $this->input->post('requested_by'),
            'trophy_date' => $trophy_date2,
            'trophy_actual' => $this->input->post('trophy_actual'),
            'spg_actual' => $this->input->post('spg_actual'),
            'transportation_actual' => $this->input->post('transportation_actual'),
            'transportation_date' => $transportation_date2,
            'gimmick_actual' => $this->input->post('gimmick_actual'),
            'nodoc' => $this->input->post('nodoc2'),
            'sample_actual' => $this->input->post('sample_actual')
        );
        if (empty($this->input->post('id_parent'))) {
            $this->db->insert("event_report", $data);
            $id_hcp = $this->db->insert_id();
        } else {
            $this->db->where('id_report', $this->input->post('id_parent'));
            $this->db->update("event_report", $data);
            $id_hcp = $this->input->post('id_parent');

            $query = $this->db->query("select id_budget from budget_event_report where id_parent=" . $id_hcp . " order by id_budget");
            foreach ($query->result() as $row2) {
                $id_budget[] = $row2->id_budget;
                $j = $j + 1;
            }

        }

        //


        $cost = $this->input->post('actual');
        $description = $this->input->post('description');
        $actual_date = $this->input->post('actl_date');

        $k = 0;
        foreach ($description as $a) 
		{
			$actual_date2 = explode('/', $actual_date[$k]);
			$actual_date3 = $actual_date2[2].'-'.$actual_date2[1].'-'.$actual_date2[0];

            $data3 = array(
                'actual' => $cost[$k],
                'id_parent' => $id_hcp,
                'description' => $description[$k],
                'actual_date' => $actual_date3
				
            );
            if (empty($id_budget[0 + $k])) {
                $this->db->insert("budget_event_report", $data3);
            } else {
                $this->db->where('id_budget', $id_budget[0 + $k]);
                $this->db->update("budget_event_report", $data3);
            }
            $k = $k + 1;
        }
        if ($j > $k) {
            for ($l = ($k + 0); $l < $j; $l++) {
                $this->db->where('id_budget', $id_budget[$l]);
                $this->db->delete('budget_event_report');
            }
        }

        //Charge Product

        redirect(base_url() . "index.php/EventReport?id_event=".$this->input->post('id_event')."&id=".$id_hcp);

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
		$type = "";
		$query = $this->db->query("select distinct file_type from attachment where type=12 and id_parent=".$_GET['id']." and file_type in (1,2,3,5,7,8,9) order by file_type");
		foreach ($query->result() as $row2)
		{
			$type = $type.$row2->file_type.",";	
		}

        echo $type;
    }

    public function getAttachment()
    {

        $type = 0;

		$query = $this->db->query("select distinct file_type from attachment where type=12 and id_parent=".$_GET['id']." and file_type in (1,2,3,5,7,8,9,10) order by file_type");
		foreach ($query->result() as $row2)
		{
			$type = $type + $row2->file_type;	
		}

        $result = "";
        $file_type = array("1" => "Kuitansi Booth / Sewa Tempat","2" => "Kuitansi Trophy","3" => "Kuitansi Transportation","5" => "Kuitansi Biaya Lain","6" => "Faktur","7" => "Photo Event (Mandatory)","8" => "Bukti Transfer Booth / Sewa Tempat","9" => "Bukti Transfer SPG","10" => "Bukti Transfer PIC RBW");
        $query = $this->db->query("select id_attachment, file_name, file_type from attachment where type=12 and id_parent=" . $_GET['id'] . " order by file_type");
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
            if (($this->session->userdata('id_group') == 20) && $_GET['state'] == "1") {
                $result = $result . "<a href='javascript:deleteAttachment(" . $row2->id_attachment . ")'><i class='fa fa-times fa-2x' aria-hidden='true'></i></a>";
            }
            $result = $result . "</div>
			</div>";
        }
        if($type<7)
        {
        $result=$result."<div class='row'>
        <div
        class='col-xs-1'
        style='border-left:1px solid black;width:400px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;color:red'
        >".strpos($type,"7")."x
        &nbsp;Please submit Photo Event
        </div></div>";
        }
        echo $result;

    }

    public function getSKUPIC()
    {

        $result = "0";
        $query = $this->db->query("select count(*) as jumlah from event_sku where qty_actual=0 and id_event=" . $_GET['id']);
        foreach ($query->result() as $row2) {
			if($row2->jumlah>0)
			{
			}	
			else
			{
				$result = $result + 1;
			}
        }

        $query = $this->db->query("select count(*) as jumlah from event_pic where pic_actual=0 and id_event=" . $_GET['id']);
        foreach ($query->result() as $row2) {
			if($row2->jumlah>0)
			{
			}	
			else
			{
				$result = $result + 1;
			}
        }

        echo $result;

    }

    public function getSKU()
    {

        $result = "0";
        $query = $this->db->query("select sum(cust_cost*qty_actual) as total from event_sku where id_event=".$_GET['id']);
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
            'type' => "12",
            'file_type' => $this->input->post('file_type'),
            'id_parent' => $this->input->post('id_parent'),
        );
        $this->db->insert("attachment", $data);
    }

}