<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConfirmationLetterHCO extends CI_Controller {

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
		$id_hco="";
		if(isset($_GET['id'])==true)
		{				
			$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, tembusan, id_hco, leader, event_organizer, letter, DATE_FORMAT(letter_date,'%d/%m/%Y') as letter_date, event_name, event_venue, nodoc2, event_institution, event_address, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date, DATE_FORMAT(event_date,'%d/%m/%Y') as event_date FROM confirmation_letter_hco where id_cl=".$_GET['id']);
			foreach ($query->result() as $row2)
			{
				$id_hco = $row2->id_hco;
				$data = array(
					'event_institution' => $row2->event_institution,
					'event_address' => $row2->event_address,
					'nodoc2' => $row2->nodoc2,
					'event_organizer' => $row2->event_organizer,
					'event_name' => $row2->event_name,
					'tembusan' => $row2->tembusan,
					'event_date' => date("d/m/Y"),
					'letter_date' => $row2->letter_date,
					'letter' => $row2->letter,
					'leader' => $row2->leader,
					'event_start_date' => $row2->event_start_date,
					'event_end_date' => $row2->event_end_date,
					'event_venue' => $row2->event_venue,
					'created_date'=>$row2->created_date
				);
			}
			/*$query = $this->db->query("select DATE_FORMAT(created_date,'%d-%M-%Y') as created_date from hco where id_hco=".$id_hco);
			foreach ($query->result() as $row2)
			{
				$data = array_merge($data, array('created_date'=>$row2->created_date));
			}*/
			$this->load->view('confirmation-letter-hco',$data);
		}	
		else
		{
			if(isset($_GET['id_hco'])==true)
			{				
				$query = $this->db->query("select max(nodoc2)+1 as nodoc from confirmation_letter_hco where year='".date("Y")."'");
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
				$id_hco = "";
				$query = $this->db->query("SELECT id_hco, DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, event_organizer, event_name, event_venue,  DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date FROM hco where id_hco=".$_GET['id_hco']);
				foreach ($query->result() as $row2)
				{
					$data = array(
						'event_institution' => "",
						'nodoc2' => $nodoc,
						'leader' => "",
						'event_name' => $row2->event_name,
						'event_date' => date("d/m/Y"),
						'created_date' => date("d-M-Y"),
						'event_start_date' => $row2->event_start_date,
						'event_end_date' => $row2->event_end_date,
						'letter_date' => "",
						'tembusan' => "",
						'letter' => "",
						'event_address' => "",
						'event_organizer' => $row2->event_organizer,
						'letter' => "",
						'event_venue' => $row2->event_venue
					);
					$id_hco = $row2->id_hco;
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
						$this->load->view('confirmation-letter-hco',$data);
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

	public function word()
	{


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

		$query = $this->db->query("select DATE_FORMAT(created_date,'%d-%M-%Y') as created_date from hco where id_hco=".$this->input->post('id_hco'));
		foreach ($query->result() as $row2)
		{
			$created_date=$row2->created_date;
		}

		$data = array(
			'id_hco' => $this->input->post('id_hco'),
			'event_institution' => $this->input->post('event_institution'),
			'event_address' => $this->input->post('event_address'),
			'nodoc2' => $this->input->post('nodoc2'),
			'event_name' => $this->input->post('event_name'),
			'leader' => $this->input->post('leader'),
			'event_organizer' => $this->input->post('event_organizer'),
			'letter_date' => $letter_date2,
			'letter' => $this->input->post('letter'),
			'tembusan' => $this->input->post('tembusan'),
			'event_date' => $event_date2,
			'event_start_date' => $start_date2,
			'event_end_date' => $end_date2,
			'event_venue' => $this->input->post('event_venue')
        );
		if(empty($this->input->post('id_parent')))
		{
			$this->db->insert("confirmation_letter_hco",$data);
			$id_ol = $this->db->insert_id();
		}
		else
		{
			$this->db->where('id_cl', $this->input->post('id_parent'));
			$this->db->update("confirmation_letter_hco",$data);
			$id_ol = $this->input->post('id_parent');
		}

		$query = $this->db->query("SELECT created_date FROM confirmation_letter_hco where id_hco=".$this->input->post('id_hco'));
		foreach ($query->result() as $row2)
		{
			$created_date=$row2->created_date;
		}
		//		echo "<script>window.close();</script>";

		$hospital = "";
		$query = $this->db->query("SELECT name FROM hospital where id_hospital=".$this->input->post('event_institution'));
		foreach ($query->result() as $row2)
		{
			$hospital = $row2->name;
		}

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
		$PHPWord->addParagraphStyle('Paragraph5', array('indentation' => array('left' => 60, 'right' => 60, 'hanging' => 360), 'align' => 'both','spaceAfter' => 0, 'spaceBefore' => 0));
		$table->addCell(12440)->addImage(APP_PATH.'assets/img/header.png', array('align'=>'center'));
		$table->addRow();
		$table->addCell(12440)->addText('Head Office: Wisma Tamara 10th Fl, Jl. Jend. Sudirman Kav. 24, Jakarta 12920, INDONESIA','rStyle4','Paragraph4');
		$table->addRow();
		$table->addCell(12440)->addText('Phone: +62 21 520 6720, Fax: +62 21 520 6735','rStyle4','Paragraph4');
		$table->addRow();
		$table->addCell(12440)->addText('Technical Operations: Jl. Raya Bogor Km. 38, Cilangkap, Tapos (Depok) 16458, INDONESIA','rStyle4','Paragraph4');
		$table->addRow();
		$table->addCell(12440)->addText('Phone: +62 21 875 2583 / 875 2584, Fax: +62 21 875 2585','rStyle4','Paragraph4');

		$section->addText('Jakarta, '.$event_date2,'rStyle2','Paragraph3');
		$section->addText('No. '.date("Y",strtotime($created_date)).'/HCO/'.date("m",strtotime($created_date)).'/'.$this->input->post('nodoc2'),'rStyle2','Paragraph3');
		$section->addText('Kepada Yth.','rStyle','Paragraph');
		$section->addText($this->input->post('leader').' '.$this->input->post('event_organizer'),'rStyle','Paragraph');
		$section->addText($this->input->post('event_address'),'rStyle','Paragraph3');
		$section->addText('Tembusan:','rStyle','Paragraph');
		$section->addText($this->input->post('tembusan'),'rStyle','Paragraph3');
		$section->addText('PERIHAL: KONFIRMASI SPONSOSHIP '.$this->input->post('event_name'),'rStyle','Paragraph2');
		$section->addText('Dengan hormat,','rStyle2','Paragraph3');
		$section->addText('Kami merujuk pada surat '.$this->input->post('letter').' tertanggal '.$letter_date2.', dan melalui surat ini, PT Taisho Pharmaceutical Indonesia, Tbk. hendak memberikan konfirmasi mengenai partisipasi kami sebagai sponsor dalam kegiatan sebagai berikut:','rStyle2','Paragraph3');

		$textrun = $section->createTextRun('Paragraph3');
		$textrun->addText($this->input->post('event_name'),array('italic'=>true,'bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' yang akan diadakan di ',array('italic'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText($this->input->post('event_venue'),array('italic'=>true,'bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(', pada tanggal ',array('italic'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText($start_date2.' - '.$end_date2,array('italic'=>true,'bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' ("Kegiatan") berupa:',array('name'=>'Calibri','size'=>'10'));
		
		$i = 1;
		$query = $this->db->query("SELECT local_amount, sponsor_type FROM budget_hco where local_amount>0 and id_parent=".$this->input->post('id_hco'));
		foreach ($query->result() as $row2)
		{
			$section->addText($i.'.  '.$row2->sponsor_type.' sebesar Rp '.$row2->local_amount,'rStyle2','Paragraph5');
			$i = $i + 1;
		}
		$query = $this->db->query("SELECT exchange, foreign_amount, sponsor_type FROM budget_hco a, hco b WHERE a.id_parent=b.id_hco AND foreign_amount>0 and id_parent=".$this->input->post('id_hco'));
		foreach ($query->result() as $row2)
		{
			$section->addText($i.'.  '.$row2->sponsor_type.' sebesar '.$row2->exchange.' '.$row2->foreign_amount,'rStyle2','Paragraph5');
			$i = $i + 1;
		}
		$section->addText('','rStyle','Paragraph');
		
		$textrun = $section->createTextRun('Paragraph3');
		$textrun->addText('Dalam rangka memenuhi ketentuan Peraturan Menteri Kesehatan tentang Sponsorship bagi Tenaga Kesehatan, Kode Etik IPMG dan peraturan perundang-undangan lainnya yang berlaku, mohon agar ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($hospital,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' / ', array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($this->input->post('event_organizer'),array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' memastikan bahwa:',array('name'=>'Calibri','size'=>'10'));

		$textrun = $section->createTextRun('Paragraph3');
		$textrun->addText('1. ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($hospital,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' / ', array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($this->input->post('event_organizer'),array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' tidak memiliki konflik kepentingan sehubungan dengan partisipasi PT Taisho Pharmaceutical Indonesia, Tbk. sebagai sponsor Kegiatan.',array('name'=>'Calibri','size'=>'10'));
		
		$section->addText('2. Isi/agenda dari Kegiatan (isi ceramah, materi yang dibagikan atau aktivitas pada waktu Kegiatan) tetap bersifat ilmiah dan seluruh jumlah sponsorship dari PT Taisho Pharmaceutical Indonesia, Tbk. tidak digunakan untuk pembayaran aktivitas yang bersifat hiburan atau aktivitas sosial lainnya yang tidak bersifat keilmuan.','rStyle2','Paragraph3');
		
		$textrun = $section->createTextRun('Paragraph3');
		$textrun->addText('3. Besaran sponsorship yang dikenakan kepada kami sesuai dengan unit cost yang berlaku pada ', array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($hospital,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' / ', array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($this->input->post('event_organizer'),array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText('.', array('name'=>'Calibri','size'=>'10'));
		
		$textrun = $section->createTextRun('Paragraph3');
		$textrun->addText('4. Dalam hal ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($hospital,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' / ', array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($this->input->post('event_organizer'),array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' memberikan hadiah untuk aktivitas adu cepat menjawab pertanyaan (kuis), pertanyaan tersebut tetap bersifat ilmiah dan bentuk hadiah yang akan diberikan sesuai dengan Kode Etik IPMG yang berlaku.',array('name'=>'Calibri','size'=>'10'));

		$section->addText('5. Aktivitas-aktivitas yang diadakan oleh sponsor-sponsor lain tidak diselenggarakan pada saat yang bersamaan dengan sesi kegiatan ilmiah utama agar tujuan utama dari Kegiatan tetap tercapai.','rStyle2','Paragraph3');

		$textrun = $section->createTextRun('Paragraph3');
		$textrun->addText('6. Nomor rekening yang tertera dalam Formulir Partisipasi adalah rekening resmi atas nama ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($hospital,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' / ', array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($this->input->post('event_organizer'),array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText('.  Jika nomor rekening yang tertera dalam Formulir Partisipasi bukanlah rekening resmi, dan mohon agar ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($hospital,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' / ', array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($this->input->post('event_organizer'),array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' segera memberitahukan kami secara tertulis detil rekening resmi selambat-lambatnya dalam (satu) hari kerja setelah surat ini diterima.',array('name'=>'Calibri','size'=>'10'));
		
		$textrun = $section->createTextRun('Paragraph3');
		$textrun->addText('Dalam hal ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($hospital,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' / ', array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($this->input->post('event_organizer'),array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' menunjuk tenaga kesehatan/HCP menjadi pembicara dan/atau moderator, maka ', array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($hospital,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' / ', array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($this->input->post('event_organizer'),array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' bertanggung jawab untuk mengurus surat penugasan/perizinan dari tempat kerja tenaga kesehatan/HCP tersebut dan mampu memberikan salinan surat tugas/surat izin kepada PT Taisho Pharmaceutical Indonesia Tbk sewaktu-waktu diminta.',array('name'=>'Calibri','size'=>'10'));

		$textrun = $section->createTextRun('Paragraph3');
		$textrun->addText('Kami selalu mendukung kepatuhan pada peraturan perundang-undangan yang berlaku, dan dengan demikian dukungan kami kepada ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($hospital,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' / ', array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($this->input->post('event_organizer'),array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText('  dalam bentuk sponsorship tidak akan mempengaruhi independensi ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($hospital,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' / ', array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($this->input->post('event_organizer'),array('bold'=>true,'name'=>'Calibri','size'=>'10'));		
		$textrun->addText(' dalam memberikan pelayanan kesehatan, menuliskan resep, atau memberikan anjuran penggunaan barang terkait produk farmasi PT Taisho Pharmaceutical Indonesia, Tbk.',array('name'=>'Calibri','size'=>'10'));
		
		$textrun = $section->createTextRun('Paragraph3');
		$textrun->addText('Dalam hal pihak lain ditunjuk sebagai penyelenggara Kegiatan, maka sesuai dengan Kode Etik IPMG yang berlaku kami berhak melakukan audit atas pihak ketiga penyelenggara tersebut (termasuk melakukan audit lapangan, meminta dokumen legalitas dan surat pernyataan dari pihak ketiga penyelenggara) untuk memastikan bahwa pihak ketiga penyelenggara tersebut bukanlah perpanjangan tangan dari pihak lain yang bukan ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($hospital,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' / ', array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($this->input->post('event_organizer'),array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText('.  Kami secara tegas dilarang untuk mengirimkan pembayaran partisipasi sponsorship kami ke rekening pihak lain selain ke rekening resmi atas nama ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($hospital,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' / ', array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($this->input->post('event_organizer'),array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText('.', array('name'=>'Calibri','size'=>'10'));
		
		$textrun = $section->createTextRun('Paragraph3');
		$textrun->addText('Laporan rekapitulasi kegiatan sponsorship akan kami sampaikan setiap bulannya kepada Komisi Pemberantasan Korupsi (KPK) dengan tembusan kepada Kementerian Kesehatan (Kemenkes). ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($hospital,array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' / ', array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($this->input->post('event_organizer'),array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(' diharapkan untuk juga memenuhi kewajiban pelaporan dengan menyampaikan laporan penerimaan sponsorship yang diterimanya kepada KPK dan Kementerian Kesehatan secara tepat waktu.  Pada tanggal surat ini, laporan tersebut harus disampaikan kepada KPK paling lambat 30 (tiga puluh) hari kerja setelah menerima sponsorship.',array('name'=>'Calibri','size'=>'10'));

		$section->addText('Mohon agar Bapak/Ibu berkenan untuk menandatangani lembar penerimaan pada halaman berikut di kolom tanda tangan yang tersedia dan mengembalikannya kepada kami ke alamat Head Office kami yang tertera pada kop surat ini.','rStyle2','Paragraph3');
		$section->addText('Terima kasih atas perhatian Bapak/Ibu.','rStyle2','Paragraph3');
		$section->addText('Hormat kami,','rStyle2','Paragraph3');
		$section->addTextBreak();
		$section->addTextBreak();
		$query = $this->db->query("SELECT name FROM user where id_group=3 and active=1");
		foreach ($query->result() as $row2)
		{
			$section->addText($row2->name,'rStyle2','Paragraph');
		}
		$section->addText('Commercial Director','rStyle','Paragraph3');
		$section->addTextBreak();
		$section->addTextBreak();
		$section->addText('LEMBAR PENERIMAAN SURAT PT TAISHO PHARMACEUTICAL INDONESIA, TBK. NO. '.date("Y",strtotime($created_date)).'/HCO/'.date("m",strtotime($created_date)).'/'.$this->input->post('nodoc2').' TERTANGGAL '.$event_date2.' PERIHAL KONFIRMASI SPONSOSHIP '.$this->input->post('event_name'),'rStyle','Paragraph');
		$section->addTextBreak();
		$section->addText('Mengetahui/Menerima:','rStyle2','Paragraph');
		$section->addTextBreak();
		$section->addTextBreak();
		$section->addText('Nama:','rStyle2','Paragraph');
		$section->addText($this->input->post('leader').' '.$this->input->post('event_organizer'),'rStyle','Paragraph');
		$section->addTextBreak();
		$section->addTextBreak();
		$section->addPageBreak();
		$section->addText('Mengetahui,','rStyle2','Paragraph');
		$section->addTextBreak();
		$section->addTextBreak();
		$section->addText('Nama:','rStyle2','Paragraph');
		$section->addText('Direktur '.$hospital.' / Pengurus '.$hospital,'rStyle','Paragraph');
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');

		$objWriter->save(APP_PATH.'assets/uploads/ConfirmationLetter-'.date("Y",strtotime($created_date)).'-HCO-'.date("m",strtotime($created_date)).'-'.$this->input->post('nodoc2').'.docx');
//		$objWriter->save('C:\xampp\htdocs\taisho\assets\uploads\ConfirmationLetterHCO'.$this->input->post('nodoc2').'.docx');

		redirect(base_url()."index.php/ConfirmationLetterHCO?id_hco=".$this->input->post('id_hco')."&id=".$id_ol);

	}




}
