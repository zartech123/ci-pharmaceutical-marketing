<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConfirmationLetterHCP extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
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
		$id_hcp2="";
		if(isset($_GET['id'])==true)
		{				
			$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, id_hcp2, letter, DATE_FORMAT(letter_date,'%d/%m/%Y') as letter_date, doctor, event_name, facility, event_venue, nodoc2, event_institution, doctor, event_address, event_start_time, event_end_time, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date, DATE_FORMAT(event_date,'%d/%m/%Y') as event_date FROM confirmation_letter_hcp where id_cl=".$_GET['id']);
			foreach ($query->result() as $row2)
			{
				$id_hcp2 = $row2->id_hcp2;
				$data = array(
					'event_institution' => $row2->event_institution,
					'event_address' => $row2->event_address,
					'nodoc2' => $row2->nodoc2,
					'event_name' => $row2->event_name,
					'facility' => $row2->facility,
					'event_date' => date("d/m/Y"),
					'letter_date' => $row2->letter_date,
					'letter' => $row2->letter,
					'doctor' => $row2->doctor,
					'event_start_date' => $row2->event_start_date,
					'event_end_date' => $row2->event_end_date,
					'event_venue' => $row2->event_venue,
					'created_date'=>$row2->created_date
				);
			}
			/*$query = $this->db->query("select DATE_FORMAT(created_date,'%d-%M-%Y') as created_date from hcp2 where id_hcp2=".$id_hcp2);
			foreach ($query->result() as $row2)
			{
				$data = array_merge($data, array('created_date'=>$row2->created_date));
			}*/
			$this->load->view('confirmation-letter-hcp',$data);
		}	
		else
		{

			if(isset($_GET['id_hcp2'])==true)
			{				
				$query = $this->db->query("select max(nodoc2)+1 as nodoc from confirmation_letter_hcp where year='".date("Y")."'");
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

				$id_hcp1 = "";
				$query = $this->db->query("SELECT doctor, id_hcp1, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, event_name, event_venue, event_institution, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date FROM hcp2 where id_hcp2=".$_GET['id_hcp2']);
				foreach ($query->result() as $row2)
				{
					$data = array(
						'event_institution' => $row2->event_institution,
						'nodoc2' => $nodoc,
						'event_name' => $row2->event_name,
						'doctor' => $row2->doctor,
						'event_date' => date("d/m/Y"),
						'created_date' => date("d-M-Y"),
						'event_start_date' => $row2->event_start_date,
						'event_end_date' => $row2->event_end_date,
						'facility' => "",
						'letter_date' => "",
						'letter' => "",
						'event_venue' => $row2->event_venue
					);
					$id_hcp1 = $row2->id_hcp1;
				}

				$facility = "";
				$query = $this->db->query("SELECT sponsor_type FROM budget_hcp2 WHERE local_amount>0 and id_parent='".$_GET['id_hcp2']."'");
				foreach ($query->result() as $row2)
				{
					$facility = $facility.$row2->sponsor_type.", ";
				}
				$facility=rtrim($facility);
				$facility=rtrim($facility, ",");

				$data = array_merge($data, array('facility'=>$facility));

				$query = $this->db->query("SELECT event_address FROM hcp1 WHERE id_hcp1=".$id_hcp1);
				foreach ($query->result() as $row2)
				{
					$data = array_merge($data, array('event_address'=>$row2->event_address));
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
						$this->load->view('confirmation-letter-hcp',$data);
					}
					else
					{
						$this->load->view('info2');
					}				
				}	

			}	
		}	
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

		$letter_date = explode('/', $this->input->post('letter_date'));
        $letter_date2 = $letter_date[2].'-'.$letter_date[1].'-'.$letter_date[0];

		$doctor2 = "";
		$query = $this->db->query("SELECT name FROM doctor where id_doctor=".$this->input->post('doctor'));
		foreach ($query->result() as $row2)
		{
			$doctor2=$row2->name;
		}


		$query = $this->db->query("select DATE_FORMAT(created_date,'%d-%M-%Y') as created_date from hcp2 where id_hcp2=".$this->input->post('id_hcp2'));
		foreach ($query->result() as $row2)
		{
			$created_date=$row2->created_date;
		}

		$data = array(
			'id_hcp2' => $this->input->post('id_hcp2'),
			'event_institution' => $this->input->post('event_institution'),
			'event_address' => $this->input->post('event_address'),
			'nodoc2' => $this->input->post('nodoc2'),
			'event_name' => $this->input->post('event_name'),
			'facility' => $this->input->post('facility'),
			'event_date' => $event_date2,
			'letter_date' => $letter_date2,
			'letter' => $this->input->post('letter'),
			'doctor' => $this->input->post('doctor'),
			'event_start_date' => $start_date2,
			'event_end_date' => $end_date2,
			'event_venue' => $this->input->post('event_venue')
        );
		if(empty($this->input->post('id_parent')))
		{
			$this->db->insert("confirmation_letter_hcp",$data);
			$id_ol = $this->db->insert_id();
		}
		else
		{
			$this->db->where('id_cl', $this->input->post('id_parent'));
			$this->db->update("confirmation_letter_hcp",$data);
			$id_ol = $this->input->post('id_parent');
		}

		$query = $this->db->query("SELECT created_date FROM confirmation_letter_hcp where id_hcp2=".$this->input->post('id_hcp2'));
		foreach ($query->result() as $row2)
		{
			$created_date=$row2->created_date;
		}

		$hospital = "";
		$query = $this->db->query("SELECT name FROM hospital where id_hospital=".$this->input->post('event_institution'));
		foreach ($query->result() as $row2)
		{
			$hospital = $row2->name;
		}

//		echo "<script>window.close();</script>";

//		Word

        $PHPWord = $this->word; // New Word Document

		$section = $PHPWord->createSection(array('pageSizeH'=>16834,'pageSizeW'=>11909,'marginLeft'=>1440, 'marginRight'=>864, 'marginBottom'=>245,'marginTop'=>1296));

		$header = $section->createHeader();
		$table = $header->addTable();
		$table->addRow();
		$PHPWord->addFontStyle('rStyle', array('bold'=>true,'name'=>'Calibri','size'=>'10'));

		$PHPWord->addFontStyle('rStyle3', array('italic'=>true,'name'=>'Calibri','size'=>'10'));
		$PHPWord->addFontStyle('rStyle2', array('name'=>'Calibri','size'=>'10'));
		$PHPWord->addFontStyle('rStyle4', array('name'=>'Calibri','size'=>'9'));
		$PHPWord->addFontStyle('rStyle5', array('bold'=>true,'underline' => 'single','name'=>'Calibri','size'=>'10'));
		$PHPWord->addFontStyle('rStyle6', array('bold'=>true,'italic' => true,'name'=>'Calibri','size'=>'10'));
		$PHPWord->addParagraphStyle('Paragraph', array('align' => 'both','spaceAfter' => 0, 'spaceBefore' => 0));
		$PHPWord->addParagraphStyle('Paragraph2', array('align' => 'center','spaceAfter' => 200));
		$PHPWord->addParagraphStyle('Paragraph3', array('align' => 'both','spaceAfter' => 200));
		$PHPWord->addParagraphStyle('Paragraph4', array('align' => 'center','spaceAfter' => 0));

		$table->addCell(16834)->addImage(APP_PATH.'assets/img/header.png', array('align'=>'center'));
		$table->addRow();
		$table->addCell(16834)->addText('Head Office: Wisma Tamara 10th Fl, Jl. Jend. Sudirman Kav. 24, Jakarta 12920, INDONESIA','rStyle4','Paragraph4');
		$table->addRow();
		$table->addCell(16834)->addText('Phone: +62 21 520 6720, Fax: +62 21 520 6735','rStyle4','Paragraph4');
		$table->addRow();
		$table->addCell(16834)->addText('Technical Operations: Jl. Raya Bogor Km. 38, Cilangkap, Tapos (Depok) 16458, INDONESIA','rStyle4','Paragraph4');
		$table->addRow();
		$table->addCell(16834)->addText('Phone: +62 21 875 2583 / 875 2584, Fax: +62 21 875 2585','rStyle4','Paragraph4');

		$section->addText('Jakarta, '.$event_date2,'rStyle2','Paragraph3');
		$section->addText('No. '.date("Y",strtotime($created_date)).'/HCP2/'.date("m",strtotime($created_date)).'/'.$this->input->post('nodoc2'),'rStyle2','Paragraph');
		$section->addText('Kepada Yth.','rStyle','Paragraph');
		$section->addText($doctor2,'rStyle','Paragraph');
		$section->addText(''.$hospital,'rStyle','Paragraph');
		$section->addText($this->input->post('event_address'),'rStyle','Paragraph3');
		$section->addText('Tembusan: Direksi/Pimpinan '.$hospital,'rStyle','Paragraph3');
		$section->addText('Perihal: SPONSORSHIP untuk Kegiatan Ilmiah : '.$this->input->post('event_name'),'rStyle6','Paragraph2');
		$section->addText('Dengan hormat,','rStyle2','Paragraph3');

		$section->addText('Merujuk pada '.$this->input->post('letter').' '.$hospital.' tertanggal '.$letter_date2.', kami, PT Taisho Pharmaceutical Indonesia, Tbk. melalui surat ini hendak memberikan kesempatan kepada Anda sebagai perwakilan resmi yang ditunjuk '.$hospital.' untuk menghadiri kegiatan ilmiah berikut:','rStyle2','Paragraph3');

		$section->addText('Judul: '.$this->input->post('event_name'),'rStyle','Paragraph');
		$section->addText('Tempat: '.$this->input->post('event_venue').', '.$this->input->post('event_address'),'rStyle','Paragraph');
		$section->addText('Tanggal: '.$this->input->post('event_start_date').' - '.$this->input->post('event_end_date'),'rStyle','Paragraph');
		$section->addText('Jam: '.$this->input->post('event_start_time').' - '.$this->input->post('event_end_time'),'rStyle','Paragraph3');

		$textrun = $section->createTextRun('Paragraph3');
		$textrun->addText('Adapun dukungan yang akan kami berikan akan berupa ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($this->input->post('facility'),array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText('.',array('name'=>'Calibri','size'=>'10'));

		$section->addText('Kami akan selalu menghormati kode etik profesi Anda dan mematuhi Peraturan Menteri Kesehatan tentang Sponsorship bagi Tenaga Kesehatan, Kode Etik IPMG dan ketentuan peraturan perundang-undangan lainnya yang berlaku.  Oleh karena itu, dukungan kami tidak akan mempengaruhi independensi Anda dalam pemberian pelayanan kesehatan atau penulisan resep atau anjuran penggunaan barang terkait produk farmasi PT Taisho Pharmaceutical Indonesia, Tbk.','rStyle2','Paragraph3');
		$section->addText('Dukungan ini ditujukan semata-mata untuk Anda pribadi sebagai tenaga kesehatan, sehingga kami tidak akan menyediakan fasilitas tambahan kepada pasangan atau anggota keluarga.  Penyediaan tiket perjalanan, akomodasi dan pembayaran biaya registrasi wajib kami atur secara langsung dengan penyelenggara dan kami dilarang untuk mengganti biaya apapun yang Anda keluarkan secara pribadi.','rStyle2','Paragraph3');

		$textrun = $section->createTextRun('Paragraph3');
		$textrun->addText('Sehubungan dengan kewajiban pelaporan sponsorship kepada otoritas pemerintah, ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($hospital,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' sebagai penerima dukungan diwajibkan untuk menyampaikan laporan penerimaan sponsorship kepada Komisi Pemberantasan Korupsi (KPK) yang ditembuskan kepada Kementerian Kesehatan.  Anda diharapkan untuk memberikan informasi yang dibutuhkan agar institusi Anda dapat melaksanakan kewajibannya dengan tepat waktu.',array('name'=>'Calibri','size'=>'10'));

		$textrun = $section->createTextRun('Paragraph3');
		$textrun->addText('Mohon memberikan konfirmasi penerimaan dukungan beserta persetujuan atas syarat dan ketentuannya, dalam hal Anda berkenan untuk menerima penunjukkan dari ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($hospital,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' dengan menandatangani formulir terlampir dan mengembalikannya kepada kami.',array('name'=>'Calibri','size'=>'10'));


		$section->addText('PT Taisho Pharmaceutical Indonesia, Tbk. berkomitmen penuh untuk terus mendukung peningkatan pengetahuan medis dan penyakit serta penggunaan obat-obatan berkualitas untuk tenaga kesehatan Indonesia.','rStyle2','Paragraph3');
		$section->addText('Terima kasih.','rStyle2','Paragraph3');
		$section->addText('Hormat kami,','rStyle2','Paragraph3');
		$section->addTextBreak();
		$query = $this->db->query("SELECT name FROM user where id_group=3 and active=1");
		foreach ($query->result() as $row2)
		{
			$section->addText($row2->name,'rStyle2','Paragraph');
		}
		$section->addText('Commercial Director','rStyle','Paragraph');
		$section->addPageBreak();
		$section->addText('LEMBAR PERSETUJUAN','rStyle5','Paragraph2');
		$section->addText('Perihal: SPONSORSHIP untuk Kegiatan Ilmiah : '.$this->input->post('event_name'),'rStyle6','Paragraph2');
		$section->addText('','rStyle6','Paragraph');
		$section->addText('Mohon mengembalikan formulir ini kepada:','rStyle','Paragraph'); 
		$section->addText('PT Taisho Pharmaceutical Indonesia, Tbk.','rStyle2','Paragraph');
		$section->addText('Wisma Tamara, Lantai 10','rStyle2','Paragraph');
		$section->addText('Jl. Jend. Sudirman Kav.24','rStyle2','Paragraph');
		$section->addText('Jakarta 12920','rStyle2','Paragraph');
		$section->addText('U.p.: Nurmala Sari','rStyle2','Paragraph');
		$section->addText('Email: nurmala.sari@ma.taisho.co.id','rStyle2','Paragraph3');
		$section->addText('Tembusan: Direksi/Pimpinan '.$hospital.'.','rStyle','Paragraph3');    


		$textrun = $section->createTextRun('Paragraph3');
		$textrun->addText('Saya, ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($doctor2,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(', sebagai perwakilan resmi tenaga kesehatan yang ditunjuk oleh ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($hospital,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(', dengan ini menyatakan bahwa saya telah memahami dengan baik isi surat di atas dan setuju untuk menerima dukungan PT Taisho Pharmaceutical Indonesia, Tbk. serta mematuhi syarat dan ketentuan dari dukungan tersebut.',array('name'=>'Calibri','size'=>'10'));

		$section->addText('Saya menyatakan bahwa penerimaan saya atas dukungan tersebut: (i) tidak menyebabkan benturan kepentingan antara saya dengan pihak ketiga manapun; dan (ii) tidak akan mempengaruhi independensi saya dalam memberikan pelayanan kesehatan atau menuliskan resep atau memberikan anjuran penggunaan barang terkait produk farmasi PT Taisho Pharmaceutical Indonesia, Tbk.','rStyle2','Paragraph3');
		$section->addTextBreak();
		$section->addTextBreak();
		$section->addText('Tanda Tangan           : _______________________________________________','rStyle','Paragraph3');
		$section->addText('Nama Lengkap           : _______________________________________________','rStyle','Paragraph3');
		$section->addText('Tanggal                : _______________________________________________','rStyle','Paragraph3');
		$section->addText('Alamat E-mail          : _______________________________________________','rStyle','Paragraph3');
		$section->addText('Alamat Korespondensi   : _______________________________________________','rStyle','Paragraph3');
		$section->addText('HP                     : _______________________________________________','rStyle','Paragraph3');
		$section->addText('Telepon                : _______________________________________________','rStyle','Paragraph3');
		$section->addText('Faksimili              : _______________________________________________','rStyle','Paragraph3');
		$section->addText('Admistrator/Penghubung : _______________________________________________','rStyle','Paragraph3');
		$section->addText('    (Nama, HP, E-mail) ','rStyle','Paragraph3');


		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$objWriter->save(APP_PATH.'assets/uploads/ConfirmationLetter-'.date("Y",strtotime($created_date)).'-HCP2-'.date("m",strtotime($created_date)).'-'.$this->input->post('nodoc2').'.docx');



		redirect(base_url()."index.php/ConfirmationLetterHCP?id_hcp2=".$this->input->post('id_hcp2')."&id=".$id_ol);
	}

	public function getDoctor()
	{
		$result="[";
		$query = $this->db->query("select id_doctor, name from doctor where id_doctor='".$_GET['id']."' order by name");
		foreach ($query->result() as $row2)
		{			
			$result=$result."{\"id\":\"".$row2->id_doctor."\",\"name\":\"".$row2->name."\"}";
			$result=$result.",";
		}
		$result=rtrim($result, ",");
		$result=$result."]";	
		echo $result;
	}


}
