<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OfferLetter2 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url','form');
        $this->load->library('word');

		$this->load->library('session');
		$this->load->library('user_agent');
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

		if($this->session->userdata('id_user'))	$this->getAuditTrail();
		if(isset($_GET['id_sc'])==true && isset($_GET['institution_hcp'])==true)
		{				
			$k = 0;
			$id_sc="";
			if(isset($_GET['id'])==true)
			{				
				$query = $this->db->query("SELECT leader, department, topic, facility, type, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, id_sc, nodoc2, event_title, event_description, event_institution, event_organizer, DATE_FORMAT(event_date,'%d/%m/%Y') as event_date, doctor, event_venue, doctor, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date, DATE_FORMAT(event_start_date2,'%d/%m/%Y') as event_start_date2, DATE_FORMAT(event_end_date2,'%d/%m/%Y') as event_end_date2 FROM offer_letter2 where id_ol=".$_GET['id']);
				foreach ($query->result() as $row2)
				{
					$data = array(
						'event_title' => $row2->event_title,
						'leader' => $row2->leader,
						'department' => $row2->department,
						'event_description' => $row2->event_description,
						'doctor' => $row2->doctor,
						'nodoc2' => $row2->nodoc2,
						'event_date' => date("d/m/Y"),
						'event_start_date' => $row2->event_start_date,
						'event_end_date' => $row2->event_end_date,
						'event_start_date2' => $row2->event_start_date2,
						'event_end_date2' => $row2->event_end_date2,
						'event_organizer' => $row2->event_organizer,
						'event_institution' => $row2->event_institution,
						'event_venue' => $row2->event_venue,
						'topic' => $row2->topic,
						'facility' => $row2->facility,
						'type' => $row2->type,
						'created_date'=>$row2->created_date
					);
					$k = $k + 1;
					$speciality = "";
					$query = $this->db->query("SELECT name, name_speciality FROM doctor a, speciality b where a.id_speciality=b.id_speciality and id_doctor=".$row2->doctor);
					foreach ($query->result() as $row2)
					{
						$speciality=$row2->name_speciality;
					}
				}
				/*$query = $this->db->query("select DATE_FORMAT(created_date,'%d-%M-%Y') as created_date from hcp1 where id_hcp1=".$id_hcp1);
				foreach ($query->result() as $row2)
				{
					$data = array_merge($data, array('created_date'=>$row2->created_date));
				}*/
			}	

			if($k==0)
			{
				$query = $this->db->query("select max(nodoc2)+1 as nodoc from offer_letter2 where year='".date("Y")."'");
				foreach ($query->result() as $row2)
				{
					if($row2->nodoc==NULL)
					{
						$nodoc = "0001";
					}
					else
					{		
						$nodoc = str_pad($row2->nodoc,4,"0",STR_PAD_LEFT);
					}	
				}

				$k=0;	
				$query = $this->db->query("SELECT distinct name_hcp, topic, DATE_FORMAT(a.created_date,'%d-%M-%Y') as created_date, event_agenda, a.institution_hcp, event_venue, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date FROM scientific_hcp a, scientific b where a.id_sc=b.id_sc and institution_hcp=".$_GET['institution_hcp']." and a.id_sc=".$_GET['id_sc']);
				foreach ($query->result() as $row2)
				{
					$data = array(
						'event_institution' => $row2->institution_hcp,
						'doctor' => $row2->name_hcp,
						'event_date' => date("d/m/Y"),
						'event_start_date' => $row2->event_start_date,
						'event_end_date' => $row2->event_end_date,
						'event_organizer' => "",
						'event_title' => $row2->event_agenda,
						'nodoc2' => $nodoc,
						'created_date' => date("d-M-Y"),
						'event_description' => "",
						'leader' => "",
						'department' => "",
						'topic' => $row2->topic,
						'event_start_date2' => "",
						'event_end_date2' => "",
						'type' => "",
						'event_venue' => $row2->event_venue
					);
					$k = $k + 1;

					$speciality = "";
					$query = $this->db->query("SELECT name, name_speciality FROM doctor a, speciality b where a.id_speciality=b.id_speciality and id_doctor=".$_GET['institution_hcp']);
					foreach ($query->result() as $row2)
					{
						$speciality=$row2->name_speciality;
					}

					$facility = "";
					$query = $this->db->query("SELECT sponsor_type FROM budget_scientific WHERE budget>0 and id_parent='".$_GET['id_sc']."'");
					foreach ($query->result() as $row2)
					{
						$facility = $facility.$row2->sponsor_type.", ";
					}
					$facility=rtrim($facility);
					$facility=rtrim($facility, ",");
					
					$facility=' the event of include '.$facility.' for 1 (one) Speaker with '.$speciality.' Qualification ';

					$data = array_merge($data, array('facility'=>$facility));

				}

//				$facility = "";
//				$query = $this->db->query("SELECT distinct sponsor_type FROM budget_scientific a, scientific b, scientific_hcp c WHERE b.id_sc=c.id_sc and budget>0 and id_parent=c.id_sc and institution_hcp='".$_GET['institution_hcp']."' and b.id_sc='".$_GET['id_sc']."'");
//				foreach ($query->result() as $row2)
//				{
//					$facility = $facility.$row2->sponsor_type.", ";
//				}
//				$facility=rtrim($facility);
//				$facility=rtrim($facility, ",");

//				$data = array_merge($data, array('facility'=>$facility));

//				$query = $this->db->query("SELECT count(*) as total FROM scientific_hcp WHERE institution_hcp='".$_GET['institution_hcp']."' and id_sc='".$_GET['id_sc']."'");
//				foreach ($query->result() as $row2)
//				{
//					$data = array_merge($data, array('hcp'=>$row2->total));
//				}

			}

				$jumlah = 0;
				$query = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and replace(page,'List','')='".$this->uri->segment(1)."' and (id_group like '".$this->session->userdata('id_group').",%' or id_group like '%,".$this->session->userdata('id_group')."' or id_group like '%,".$this->session->userdata('id_group').",%' or id_group='".$this->session->userdata('id_group')."')");
				foreach ($query->result() as $row2)
				{
					$jumlah = $row2->jumlah;
					if($jumlah==0 && isset($_GET['access']))
					{
						$query2 = $this->db->query("select count(*) as jumlah from menu a, menu_group b where a.id_menu=b.id_menu and replace(page,'List','')='".$this->uri->segment(1)."' and (id_group like '".$_GET['access'].",%' or id_group like '%,".$_GET['access']."' or id_group like '%,".$_GET['access'].",%' or id_group='".$_GET['access']."')");
						foreach ($query2->result() as $row3)
						{
							$jumlah = $row3->jumlah;
						}
					}
				}

				if(!$this->session->userdata('id_group') && !isset($_GET['access']))
				{
					$this->load->view('login');
				}
				else
				{		
					if($jumlah==1)
					{
						$this->load->view('offer-letter2',$data);
					}
					else
					{
						$this->load->view('info2');
					}				
				}	

		}	

	}


	/*public function word()
	{
        $PHPWord = $this->word; // New Word Document

		$section = $PHPWord->createSection(array('pageSizeH'=>15840,'pageSizeW'=>12440,'marginLeft'=>1440, 'marginRight'=>1440, 'marginBottom'=>288,'marginTop'=>1987));

		$header = $section->createHeader();
		$table = $header->addTable();
		$table->addRow();
		$PHPWord->addFontStyle('rStyle', array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$PHPWord->addFontStyle('rStyle3', array('italic'=>true,'name'=>'Calibri','size'=>'10'));
		$PHPWord->addFontStyle('rStyle2', array('name'=>'Calibri','size'=>'10'));
		$PHPWord->addFontStyle('rStyle4', array('name'=>'Calibri','size'=>'9'));
		$PHPWord->addParagraphStyle('Paragraph', array('align' => 'both','spaceAfter' => 0, 'spaceBefore' => 0));
		$PHPWord->addParagraphStyle('Paragraph2', array('align' => 'center','spaceAfter' => 200));
		$PHPWord->addParagraphStyle('Paragraph3', array('align' => 'both','spaceAfter' => 200));
		$PHPWord->addParagraphStyle('Paragraph4', array('align' => 'center','spaceAfter' => 0));

		$table->addCell(12440)->addImage(APP_PATH.'assets/img/header.png', array('align'=>'center'));
		$table->addRow();
		$table->addCell(12440)->addText('Head Office: Wisma Tamara 10th Fl, Jl. Jend. Sudirman Kav. 24, Jakarta 12920, INDONESIA','rStyle4','Paragraph4');
		$table->addRow();
		$table->addCell(12440)->addText('Phone: +62 21 520 6720, Fax: +62 21 520 6735','rStyle4','Paragraph4');
		$table->addRow();
		$table->addCell(12440)->addText('Technical Operations: Jl. Raya Bogor Km. 38, Cilangkap, Tapos (Depok) 16458, INDONESIA','rStyle4','Paragraph4');
		$table->addRow();
		$table->addCell(12440)->addText('Phone: +62 21 875 2583 / 875 2584, Fax: +62 21 875 2585','rStyle4','Paragraph4');
		//		$section = $PHPWord->addSection(['pageSizeH'=>11,'pageSizeW'=>8.5]);
		// Add text elements
		$section->addTextBreak();
		$section->addText('Jakarta, [tanggal]','rStyle2','Paragraph3');
		$section->addText('No. [nomor_referensi_surat]','rStyle2','Paragraph');
		$section->addText('Kepada Yth.','rStyle','Paragraph');
		$section->addText('Direksi [nama_RS]','rStyle','Paragraph');
		$section->addText('[alamat]','rStyle','Paragraph3');
		$section->addText('Dengan hormat,','rStyle2','Paragraph3');
		$section->addText('Melalui surat ini, kami, PT Taisho Pharmaceutical Indonesia, Tbk. hendak memberikan kesempatan kepada para tenaga kesehatan pada [nama RS] untuk menghadiri [jenis kegiatan ilmiah] dengan tujuan untuk [meningkatkan pengetahuan medis dan penyakit serta penggunaan obat-obatan berkualitas].  Dalam memberikan dukungan ini, kami akan memastikan bahwa semua dukungan kami diberikan tepat sasaran dan sesuai dengan ketentuan hukum yang berlaku.','rStyle2','Paragraph3');
		$section->addText('Dukungan PT Taisho Pharmaceutical Indonesia, Tbk. dalam hal ini berupa [fasilitas] yang akan diberikan kepada [jumlah] staff dokter [spesialisasi] di [nama_RS] untuk berpartisipasi dalam kegiatan ilmiah berikut:','rStyle2','Paragraph3');
		$section->addText('[judul_kegiatan_ilmiah] yang akan diadakan di [kota], pada tanggal [tanggal]','rStyle3','Paragraph2');
		$section->addText('Dalam rangka memenuhi ketentuan Peraturan Menteri Kesehatan tentang Sponsorship bagi Tenaga Kesehatan, Kode Etik IPMG dan peraturan perundang-undangan lainnya yang berlaku:','rStyle2','Paragraph3');
		$section->addText('1. Semua jenis dukungan akan kami atur secara langsung dengan penyelenggara dan kami tidak akan mengganti biaya apapun yang dikeluarkan oleh [nama_RS] atau tenaga kesehatan yang ditunjuk.','rStyle2','Paragraph');
		$section->addText('2. Kami secara tegas dilarang untuk memberikan dukungan kepada pasangan atau anggota keluarga dari tenaga kesehatan.','rStyle2','Paragraph');
		$section->addText('3. Dukungan kami kepada [nama_RS] tidak akan mempengaruhi independensi [nama_RS] maupun tenaga kesehatan yang ditunjuk dalam memberikan pelayanan kesehatan, menuliskan resep, atau memberikan anjuran penggunaan barang terkait produk farmasi PT Taisho Pharmaceutical Indonesia, Tbk.','rStyle2','Paragraph3');
		$section->addText('Sebagai bentuk kepatuhan [nama_RS] sebagai penerima dukungan pada Peraturan Menteri Kesehatan, Kode Etik IPMG dan ketentuan peraturan perundang-undangan lainnya yang berlaku, mohon agar [nama_RS] memastikan bahwa: (i) institusi [nama_RS] dan tenaga kesehatan yang ditunjuk tidak memiliki konflik kepentingan sehubungan dengan dukungan ini; dan (ii) tenaga kesehatan yang ditunjuk mengerti bahwa tujuan satu-satunya diberikannya dukungan ini adalah untuk pendidikan medis.','rStyle2','Paragraph3');
		$section->addText('Kami akan menyampaikan laporan rekapitulasi kegiatan sponsorship kepada Komisi Pemberantasan Korupsi (KPK) yang ditembuskan kepada Kementerian Kesehatan setiap bulannya.  [nama_RS] diharapkan untuk juga memenuhi kewajibannya dengan menyampaikan laporan penerimaan sponsorship yang diterima kepada KPK dan Kementerian Kesehatan secara tepat waktu.','rStyle2','Paragraph3');
		$section->addPageBreak();
		$section->addText('Jika [nama_RS] bersedia untuk menerima dukungan dari PT Taisho Pharmaceutical Indonesia, Tbk., mohon agar berkenan menerbitkan surat penunjukan/penugasan resmi yang menyebutkan nama tenaga kesehatan yang keahliannya tepat untuk menerima dukungan ini sebagai perwakilan resmi dari [nama_RS] dan memberikan salinan dari surat penunjukan tersebut kepada kami.','rStyle2','Paragraph3');
		$section->addText('PT Taisho Pharmaceutical Indonesia, Tbk. akan selanjutnya memproses dukungan berdasarkan surat penunjukan tersebut.  Salinan sertifikat kehadiran tenaga kesehatan yang ditunjuk diharapkan dapat diberikan kepada kami selambat-lambatnya empat belas (14) hari kalender setelah kegiatan ilmiah dilaksanakan.','rStyle2','Paragraph3');
		$section->addText('Terima kasih atas perhatian Bapak/Ibu.','rStyle2','Paragraph3');
		$section->addText('Hormat kami,','rStyle2','Paragraph3');		
		$section->addTextBreak();
		$section->addTextBreak();
		$section->addText('Sonny Adinugroho','rStyle2','Paragraph');
		$section->addText('Commercial Director','rStyle','Paragraph');

		// Save File
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$objWriter->save(APP_PATH.'assets\uploads\OfferLetter.docx');

	}*/

	public function getHospitalAddress()
	{
		$result="";
		$query = $this->db->query("select address  from hospital where id_hospital='".$_GET['event_institution']."'");
		foreach ($query->result() as $row2)
		{			
			$result=$row2->address;
		}
		echo $result;
	}

	public function getHospitalName()
	{
		$result="";
		$query = $this->db->query("select concat(name,' [',type,'], ',address) as name from hospital where id_hospital='".$_GET['event_institution']."'");
		foreach ($query->result() as $row2)
		{			
			$result=$row2->name;
		}
		echo $result;
	}

	public function getHospital()
	{
		$result="[";
//		$result=$result."{\"id\":\"0\",\"name\":\"\"}";
		$query = $this->db->query("select id_hospital, concat(name,' [',type,'], ',address) as name from hospital order by name");
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id_hospital."\",\"name\":\"".$row2->name."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
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

	public function add()
	{
		if($this->session->userdata('id_user'))	$this->getAuditTrail();
        $event_date = explode('/', $this->input->post('event_date'));
        $event_date2 = $event_date[2].'-'.$event_date[1].'-'.$event_date[0];

        $start_date = explode('/', $this->input->post('event_start_date'));
        $start_date2 = $start_date[2].'-'.$start_date[1].'-'.$start_date[0];

		$end_date = explode('/', $this->input->post('event_end_date'));
        $end_date2 = $end_date[2].'-'.$end_date[1].'-'.$end_date[0];

        $start_date3 = explode('/', $this->input->post('event_start_date2'));
        $start_date4 = $start_date3[2].'-'.$start_date3[1].'-'.$start_date3[0];

		$end_date3 = explode('/', $this->input->post('event_end_date2'));
        $end_date4 = $end_date3[2].'-'.$end_date3[1].'-'.$end_date3[0];

		$speciality = $this->input->post('speciality');
		$speciality2 = "";
		$speciality3 = "";

		foreach ($speciality as $a)
		{
			$speciality3 = $speciality3.$a.",";
			$query = $this->db->query("SELECT name_speciality FROM speciality where id_speciality=".$a);
			foreach ($query->result() as $row2)
			{
				$speciality2 = $speciality2.$row2->name_speciality.", ";
			}	
		}
		$speciality2 = substr_replace($speciality2 ,"",-1);
		$speciality3 = substr_replace($speciality3 ,"",-1);

		$query = $this->db->query("select distinct DATE_FORMAT(b.created_date,'%d-%M-%Y') as created_date from scientific_hcp a, scientific b where a.id_sc=b.id_sc and institution_hcp=".$this->input->post('event_institution')." and a.id_sc=".$this->input->post('id_sc'));
		foreach ($query->result() as $row2)
		{
			$created_date=$row2->created_date;
		}

		$data = array(
			'id_sc' => $this->input->post('id_sc'),
			'event_date' => $event_date2,
			'event_title' => $this->input->post('event_title'),
			'topic' => $this->input->post('topic'),
			'type' => $this->input->post('type'),
			'event_description' => $this->input->post('event_description'),
			'doctor' => $this->input->post('doctor'),
			'nodoc2' => $this->input->post('nodoc2'),
			'event_organizer' => $this->input->post('event_organizer'),
			'leader' => $this->input->post('leader'),
			'department' => $this->input->post('department'),
			'facility' => $this->input->post('facility'),
			'event_start_date' => $start_date2,
			'event_end_date' => $end_date2,
			'event_start_date2' => $start_date4,
			'event_end_date2' => $end_date4,
			'event_institution' => $this->input->post('event_institution'),
			'event_venue' => $this->input->post('event_venue')
        );


		if(empty($this->input->post('id_parent')))
		{
			$this->db->insert("offer_letter2",$data);
			$id_ol = $this->db->insert_id();
		}
		else
		{
			$this->db->where('id_ol', $this->input->post('id_parent'));
			$this->db->update("offer_letter2",$data);
			$id_ol = $this->input->post('id_parent');
		}

		$query = $this->db->query("SELECT created_date FROM offer_letter2 where id_sc=".$this->input->post('id_sc'));
		foreach ($query->result() as $row2)
		{
			$created_date=$row2->created_date;
		}
		
		$hospital_name = "";
		$query = $this->db->query("SELECT name FROM hospital where id_hospital=".$this->input->post('event_institution'));
		foreach ($query->result() as $row2)
		{
			$hospital_name = $row2->name;
		}


//------------------- Word

        $PHPWord = $this->word; // New Word Document

		$section = $PHPWord->createSection(array('pageSizeH'=>15840,'pageSizeW'=>12440,'marginLeft'=>1440, 'marginRight'=>1440, 'marginBottom'=>288,'marginTop'=>1987));

		$header = $section->createHeader();
		$table = $header->addTable();
		$table->addRow();
		$PHPWord->addFontStyle('rStyle', array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$PHPWord->addFontStyle('rStyle3', array('italic'=>true,'name'=>'Calibri','size'=>'10'));
		$PHPWord->addFontStyle('rStyle2', array('name'=>'Calibri','size'=>'10'));
		$PHPWord->addFontStyle('rStyle4', array('name'=>'Calibri','size'=>'9'));
		$PHPWord->addParagraphStyle('Paragraph', array('align' => 'both','spaceAfter' => 0, 'spaceBefore' => 0));
		$PHPWord->addParagraphStyle('Paragraph2', array('align' => 'center','spaceAfter' => 200));
		$PHPWord->addParagraphStyle('Paragraph3', array('align' => 'both','spaceAfter' => 200));
		$PHPWord->addParagraphStyle('Paragraph4', array('align' => 'center','spaceAfter' => 0));

		$table->addCell(12440)->addImage(APP_PATH.'assets/img/header.png', array('align'=>'center'));
		$table->addRow();
		$table->addCell(12440)->addText('Head Office: Wisma Tamara 10th Fl, Jl. Jend. Sudirman Kav. 24, Jakarta 12920, INDONESIA','rStyle4','Paragraph4');
		$table->addRow();
		$table->addCell(12440)->addText('Phone: +62 21 520 6720, Fax: +62 21 520 6735','rStyle4','Paragraph4');
		$table->addRow();
		$table->addCell(12440)->addText('Technical Operations: Jl. Raya Bogor Km. 38, Cilangkap, Tapos (Depok) 16458, INDONESIA','rStyle4','Paragraph4');
		$table->addRow();
		$table->addCell(12440)->addText('Phone: +62 21 875 2583 / 875 2584, Fax: +62 21 875 2585','rStyle4','Paragraph4');
		//		$section = $PHPWord->addSection(['pageSizeH'=>11,'pageSizeW'=>8.5]);
		// Add text elements
		$section->addTextBreak();
		$doc = date("Y",strtotime($created_date)).'-SERF-'.date("m",strtotime($created_date)).'/'.$this->input->post('nodoc2');
		$section->addText('Jakarta, '.$event_date2.'									'.$doc,'rStyle2','Paragraph3');
		$section->addText('To :','rStyle2','Paragraph');		
		$section->addText($this->input->post('leader').' '.$hospital_name,'rStyle2','Paragraph');
		$section->addText($this->input->post('department'),'rStyle2','Paragraph');
		$section->addText($hospital_address,'rStyle2','Paragraph');
		$section->addTextBreak();
		$section->addText('Dear Sir/Madam,','rStyle2','Paragraph');
		$section->addTextBreak();
		$section->addText('Support of Medical Education organized by '.$this->input->post('event_organizer').' in collaboration with PT Taisho Pharmaceutical Indonesia Tbk.','rStyle2','Paragraph3');
		$section->addText($this->input->post('event_organizer').' will hold a medical education event to allow the Health Care Professionals to enhance disease and medical knowledge and the quality use of medicine :','rStyle2','Paragraph3');
		$section->addText('Name of Event	: '.$this->input->post('event_title'),'rStyle2','Paragraph');
		$section->addText('Day/Date	: '.date("l",strtotime($start_date2)).'-'.date("l",strtotime($end_date2)).'/'.date("j F Y",strtotime($start_date2)).' - '.date("j F Y",strtotime($end_date2)),'rStyle2','Paragraph');
		$section->addText('Venue		: '.$this->input->post('event_venue'),'rStyle2','Paragraph3');
		$section->addText('We agree to provide the event of '.$this->input->post('event_description').' include '.$this->input->post('facility').' for 1 (one) Speaker with '.$speciality.' Qualification exclusive purpose of supporting the following event in accordance with applicable laws, regulations and industry association code.','rStyle2','Paragraph3');

		$section->addText('The details of the event as below :','rStyle2','Paragraph');
		$section->addText($this->input->post('event_description'),'rStyle2','Paragraph');
		$section->addText('Topic			: '.$this->input->post('topic'),'rStyle2','Paragraph');
//		$section->addText('Speaker			: '.$doctor2,'rStyle2','Paragraph');
		if($this->input->post('event_start_date2')==$this->input->post('event_end_date2') || $this->input->post('event_end_date2')=="00/00/0000")
		{
			$section->addText('Day/Date		: '.date("l",strtotime($start_date4)).'/'.date("j F Y",strtotime($start_date4)),'rStyle2','Paragraph');
		}
		else
		{		
			$section->addText('Day/Date		: '.date("l",strtotime($start_date4)).'-'.date("l",strtotime($end_date4)).'/'.date("j F Y",strtotime($start_date4)).' - '.date("j F Y",strtotime($end_date4)),'rStyle2','Paragraph');
		}	
		$section->addText('Venue			: '.$this->input->post('event_venue'),'rStyle2','Paragraph');
		$section->addText('Type			: '.$this->input->post('type'),'rStyle2','Paragraph3');
		$section->addText('This medical education is solely for an educational purpose and is not contingent on the purchase or recommendation of any Taisho products by the institution and/or its employees/members and is not intended to induce the institution and/or its employees/members to purchase or recommend Taisho products. This event has not been determined in a manner which takes into account any business arrangement(s) between the parties','rStyle2','Paragraph3');
		$section->addTextBreak();
		$section->addText('Yours sincerely,','rStyle2','Paragraph3');
		$section->addTextBreak();
		$section->addTextBreak();
		$query = $this->db->query("SELECT name FROM user where id_group=3 and active=1");
		foreach ($query->result() as $row2)
		{
			$section->addText('Name : '.$row2->name,'rStyle2','Paragraph');
		}
		$section->addText('Title: Commercial Director','rStyle2','Paragraph');

		// Save File
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$objWriter->save(APP_PATH.'assets/uploads/OfferLetter-'.date("Y",strtotime($created_date)).'-SERF-'.date("m",strtotime($created_date)).'-'.$this->input->post('nodoc2').'.docx');

		redirect(base_url()."index.php/OfferLetter2?id_sc=".$this->input->post('id_sc')."&institution_hcp=".$this->input->post('event_institution')."&id=".$id_ol);


	}

}
