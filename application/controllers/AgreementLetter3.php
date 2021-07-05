<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AgreementLetter3 extends CI_Controller {

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
		if(isset($_GET['id_sc'])==true)
		{				
			$k = 0;
			$id_sc="";
			if(isset($_GET['id'])==true)
			{				
				$query = $this->db->query("SELECT DATE_FORMAT(created_date,'%d-%M-%Y') as created_date, id_sc, event_title, nodoc2, event_description, fee, DATE_FORMAT(event_date,'%d/%m/%Y') as event_date, doctor, event_venue, doctor, event_start_time, event_end_time, DATE_FORMAT(event_start_date,'%d/%m/%Y') as event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') as event_end_date FROM agreement_letter3 where id_tl=".$_GET['id']);
				foreach ($query->result() as $row2)
				{
					$id_sc = $row2->id_sc;
					$data = array(
						'fee' => $row2->fee,
						'event_title' => $row2->event_title,
						'event_description' => $row2->event_description,
						'doctor' => $row2->doctor,
						'nodoc2' => $row2->nodoc2,
						'event_date' => date("d/m/Y"),
						'event_start_date' => $row2->event_start_date,
						'event_end_date' => $row2->event_end_date,
						'event_start_time' => $row2->event_start_time,
						'event_end_time' => $row2->event_end_time,
						'event_venue' => $row2->event_venue,
						'created_date'=>$row2->created_date
					);
					$k = $k + 1;
				}
				/*$query = $this->db->query("select DATE_FORMAT(created_date,'%d-%M-%Y') as created_date from scientific where id_sc=".$id_sc);
				foreach ($query->result() as $row2)
				{
					$data = array_merge($data, array('created_date'=>$row2->created_date));
				}*/
			}

			if($k==0)
			{
				$nodoc = "0001";	
				$max = 0;
				$max2 = 0;
				$query = $this->db->query("select max(nodoc2)+1 as nodoc from agreement_letter2 where year='".date("Y")."'");
				foreach ($query->result() as $row2)
				{
					$max = $row2->nodoc;
				}
				if($max==null)	$max=0;

				$query = $this->db->query("select max(nodoc2)+1 as nodoc from agreement_letter3 where year='".date("Y")."'");
				foreach ($query->result() as $row2)
				{
					$max2 = $row2->nodoc;
				}
				if($max2==null)	$max2=0;
				//if($max>0 && $max2>0)
				if($max==0 && $max2==0)
				{
				}
				else	
				{
					if($max2<$max)
					{
						$nodoc = str_pad($max,4,"0",STR_PAD_LEFT);
					}
					else
					{
						$nodoc = str_pad($max2,4,"0",STR_PAD_LEFT);
					}
				}	

				$k=0;	
				$query = $this->db->query("SELECT event_start_time, name_hcp, topic, event_agenda, fee_hcp, DATE_FORMAT(b.created_date,'%d-%M-%Y') as created_date, event_end_time, event_venue, DATE_FORMAT(event_start_date,'%d/%m/%Y') AS event_start_date, DATE_FORMAT(event_end_date,'%d/%m/%Y') AS event_end_date FROM scientific c, scientific_hcp b WHERE c.id_sc=b.id_sc and id_sc_hcp=".$_GET['id_sc']);
				foreach ($query->result() as $row2)
				{
					$data = array(
						'fee' => $row2->fee_hcp,
						'doctor' => $row2->name_hcp,
						'event_start_date' => $row2->event_start_date,
						'event_end_date' => $row2->event_end_date,
						'event_start_time' => $row2->event_start_time,
						'event_date' => date("d/m/Y"),
						'event_title' => $row2->topic,
						'event_description' => $row2->event_agenda,
						'nodoc2' => $nodoc,
						'created_date' => date("d-M-Y"),
						'event_end_time' => $row2->event_end_time,
						'event_venue' => $row2->event_venue
					);
					$k = $k + 1;
				}
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
					$this->load->view('agreement-letter3',$data);
				}
				else
				{
					$this->load->view('info2');
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

		$doctor2 = "";
		$query = $this->db->query("SELECT name FROM doctor where id_doctor=".$this->input->post('doctor'));
		foreach ($query->result() as $row2)
		{
			$doctor2=$row2->name;
		}

		$data = array(
			'id_sc' => $this->input->post('id_sc'),
			'event_date' => $event_date2,
			'event_title' => $this->input->post('event_title'),
			'event_description' => $this->input->post('event_description'),
			'doctor' => $this->input->post('doctor'),
			'nodoc2' => $this->input->post('nodoc2'),
			'event_start_date' => $start_date2,
			'fee' => $this->input->post('fee'),
			'event_end_date' => $end_date2,
			'event_start_time' => $this->input->post('event_start_time'),
			'event_end_time' => $this->input->post('event_end_time'),
			'event_venue' => $this->input->post('event_venue')
        );
		if(empty($this->input->post('id_parent')))
		{
			$this->db->insert("agreement_letter3",$data);
			$id_tl = $this->db->insert_id();
		}
		else
		{
			$this->db->where('id_tl', $this->input->post('id_parent'));
			$this->db->update("agreement_letter3",$data);
			$id_tl = $this->input->post('id_parent');
		}


		$query = $this->db->query("SELECT created_date FROM agreement_letter3 where id_sc=".$this->input->post('id_sc'));
		foreach ($query->result() as $row2)
		{
			$created_date=$row2->created_date;
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
		$section->addText('Dear dr., '.$doctor2,'rStyle2','Paragraph3');
        $section->addText('HEALTH CARE PROFESSIONAL - SPEAKER SERVICES AGREEMENT','rStyle5','Paragraph3');
        $section->addText('Thank you for agreeing to provide the speaker services to PT Taisho Pharmaceutical Indonesia, Tbk ("TAISHO") as follows:','rStyle2','Paragraph3');

		$styleTable = array('borderSize' => 1, 'borderColor' => 'OOOOOO', 'cellMargin' => 80);

		$PHPWord->addTableStyle('table2', $styleTable, $styleTable);

		$table2 = $section->addTable('table2');
    	$table2->addRow();
        $table2->addCell(6834)->addText('Presentation Subject /Event Title: ','rStyle','Paragraph');
        $table2->addCell(10000)->addText($this->input->post('event_title'),'rStyle4','Paragraph');
    	$table2->addRow();
        $table2->addCell(6834)->addText('Description of Services    : ','rStyle','Paragraph');
        $table2->addCell(10000)->addText('You will prepare and present a talk on '.$this->input->post('event_description'),'rStyle4','Paragraph');
    	$table2->addRow();
		$table2->addCell(6834)->addText('Date & Time  : ','rStyle','Paragraph');

		$end = $end_date2;
		$start = $start_date2;
		$datediff = strtotime($end) - strtotime($start);
		$datediff = floor($datediff/(60*60*24));
		$tgl = "";
		$cell = $table2->addCell(10000);
		for($i = 0; $i < $datediff + 1; $i++){
			$tgl = date("Y-m-d", strtotime($start . ' + ' . $i . 'day')). " ".$this->input->post('event_start_time')." - ".$this->input->post('event_end_time');
			$cell->addText($tgl,'rStyle4','Paragraph');
		}        
    	$table2->addRow();
        $table2->addCell(6834)->addText('Location  : ','rStyle','Paragraph');
        $table2->addCell(10000)->addText($this->input->post('event_venue'),'rStyle4','Paragraph');
		$section->addText('','rStyle','Paragraph');
		$section->addText('TAISHO now wishes to formalize our discussions relating to the Services on the terms of this letter (Agreement).','rStyle2','Paragraph3');
		$section->addText('Services','rStyle5','Paragraph3');
		$section->addText('You agree to provide the Services on the terms of this Agreement and to use all reasonable care and skill in providing the Services. Without limiting the above, you agree to provide the Services in accordance with all applicable laws, regulatory and professional requirements, including TAISHO code of conduct and IPMG Code of Pharmaceutical Marketing Practices in Indonesia and Indonesian Code of Medical Ethics (Kode Etik Kedokteran Indonesia).','rStyle2','Paragraph3');
		$section->addText('Briefing','rStyle5','Paragraph3');
		$section->addText('You acknowledge that TAISHO is obliged to ensure compliance with the Code and that TAISHO needs to review your presentation in advance to ensure that the additional obligations applying to pharmaceutical companies are appropriately addressed. A summary of the key Code requirements include:','rStyle2','Paragraph3');
		$section->addText('- TAISHO support of the presentation should be acknowledged for transparency and to avoid misleading the audience (e.g. by including "Sponsored by Taisho Pharmaceutical" on the first page)','rStyle2','Paragraph');
		$section->addText('- For TAISHO promotional meetings, all data presented on TAISHO products must be consistent with the approved indications and consistent with the products marketing authorization. You may respond to unsolicited questions regarding an off-label or unlicensed use in your own experience, but you must first disclose that the product is not approved for that use and that the response is your opinion rather than TAISHO','rStyle2','Paragraph');
		$section->addText('- All information, claims and comparisons about medicinal products must be accurate, balanced, fair and objective and must not be misleading;','rStyle2','Paragraph');
		$section->addText('- All information, claims or comparisons must be referenced or capable of substantiation;','rStyle2','Paragraph');
		$section->addText('- All jokes and pictures must be in good taste and not able to cause offence to the audience; and','rStyle2','Paragraph'); 
		$section->addText('- Any third party owned content must be used in accordance with applicable copyright laws or customary scientific practice.','rStyle2','Paragraph');
		$section->addText('- To comply with the Codes and the Regulations, you acknowledged that there is an obligation to report any sponsorship received by and/or given to you as a HCP, to Indonesia\'s Corruption Eradication Commission (Komisi Pemberantasan Korupsi / KPK Indonesia) and Ministry of Health of the Republic of Indonesia.','rStyle2','Paragraph');
		$section->addText('- Following above regulation, advance written approval must be obtained by authorized person of HCP\'s employer.','rStyle2','Paragraph3');
		$section->addText('- TAISHO will receive all supporting evidence for above reporting obligation.','rStyle2','Paragraph3');
		$section->addText('By signing this Agreement, you confirm that TAISHO has briefed you on the Code specific requirements and that you agree to comply with these requirements in providing the Services.','rStyle2','Paragraph3');
		$section->addText('Fees','rStyle5','Paragraph3');
		
		$textrun = $section->createTextRun('Paragraph3');
		$textrun->addText('In exchange for you providing the Services in accordance with this Agreement, TAISHO will transfer into your nominated bank account, an honorarium fee of IDR ',array('name'=>'Calibri','size'=>'10'));
		$textrun->addText($this->input->post('fee'),array('bold'=>true,'name'=>'Calibri','size'=>'10'));
		$textrun->addText(', net withholding tax. Except for withholding tax which will be paid by TAISHO in addition in accordance with applicable laws, you are responsible for all other taxes relating to such payments.',array('name'=>'Calibri','size'=>'10'));
		
		$section->addText('TAISHO will also pay and organise directly your reasonable travel, subsistence meal or accommodation expenses in providing the Services. All expenses must be consistent with TAISHO travel policy, the Codes and the Regulations and be organised by TAISHO directly.','rStyle2','Paragraph3');
		$section->addText('No other payment, gifts, or anything value of money shall be given to you other than the fees and facility to support your Service as stipulated in this Agreement.','rStyle2','Paragraph3');
		$section->addText('No Inducement or Conflict of Interest','rStyle5','Paragraph3');
		$section->addText('Honorarium and expenses paid to you under this Agreement constitute fair market value for the Services. They do not carry any obligation to prescribe, supply, administer, recommend or buy TAISHO products and they do not constitute any reward for past or future business.','rStyle2','Paragraph3');
		$section->addText('You confirm that you have no conflict of interest (including no conflict of interest with your employer, any government agency or other third party) which would prevent you from providing the Services in accordance with this Agreement and that you have obtained all necessary employer, institution, organization or governmental consents to provide the Services.','rStyle2','Paragraph3'); 
		$section->addText('Without limiting the above, each party acknowledges that applicable laws prohibit, among other things, bribery and the direct or indirect payment of money or anything of value to any government official, political party or candidate for political purposes or for obtaining or retaining business. By signing this Agreement, you confirm that you are not aware of any inappropriate inducement which would conflict with the requirements of the Codes and the Regulations or any applicable anti-bribery or anti-corruption laws.','rStyle2','Paragraph3');
		$section->addText('Intellectual Property','rStyle5','Paragraph3');
		$section->addText('Except as necessary in connection with the TAISHO meetings at which you have agreed to provide the Services, TAISHO will not otherwise use, copy or disclose your name, likeness, photograph or presentation slides without your prior consent.','rStyle2','Paragraph3');
		$section->addText('Nothing in this Agreement affects ownership of either party\'s intellectual property rights used in connection with the Services, which will continue to be owned by the party that created or introduced the rights. This means that in relation to the Services, you will continue to own any speaker slides that you provide to TAISHO and that TAISHO will continue to own any pre-approved speaker slides, confidential information or other intellectual property rights provided to you. ','rStyle2','Paragraph3');
		$section->addText('You agree to provide TAISHO a copy of all presentation or other materials used in connection with the Services for records keeping purposes. ','rStyle2','Paragraph3');
		$section->addText('Confidentiality and Privacy','rStyle5','Paragraph3');
		$section->addText('You agree to maintain the confidentiality of any business, product, customer or personnel information of TAISHO or its affiliates disclosed to you or otherwise obtained by you in connection with this Agreement (Confidential Information). You agree to use the Confidential Information solely to perform your obligations under this Agreement and will not disclose it to any third party without TAISHO prior written consent. These confidentiality obligations do not apply to any information which is publicly available (other than through a breach by you of this Agreement), which TAISHO has pre-approved for use at the meeting or which is required to be disclosed by law. As soon as possible following termination of this Agreement, you agree to return all Confidential Information that is in your possession. ','rStyle2','Paragraph3');
		$section->addText('TAISHO respects your privacy in accordance with all applicable laws and regulations. If you provide personal information to TAISHO, TAISHO will only use, disclose and store this data in connection with the Services, for its record-keeping purposes and in connection with its activities that are related to the Services or the disease area in which you have expertise.','rStyle2','Paragraph3');
		$section->addText('Any provision that can reasonably be inferred as continuing or is expressly stated to continue shall continue in full force and effect, including but not limited to provisions on "Confidentiality and Privacy" and "Intellectual Property".','rStyle2','Paragraph3');
		$section->addText('The Parties hereto fully understand and acknowledge the existence of the Law of the Republic of Indonesia No. 24 of 2009 regarding National Flag, Language, Coat of Arms, and Anthem (the "Law 24/2009") which requires any agreement involving an Indonesian party to be executed in the Indonesian language.  Therefore, the Parties hereby agree that the execution of this Agreement in the English language only, shall not be deemed as a bad faith intention of the Parties not to comply with Law 24/2009.  The Parties agree to immediately enter into, execute and sign the Indonesian language agreement upon request of one of the Parties.  Such Indonesian language agreement shall be deemed effective as of the date of this Agreement as if it was executed on the date hereof.  In the event of any inconsistency between the English language text and the Indonesian language text or should there be any dispute on the meaning or interpretation of certain provisions, the Parties hereby agree that the English language text shall prevail.  Neither of the Parties shall bring any claim against the other on the basis of non-compliance with Law 24/2009.','rStyle2','Paragraph3');
		$section->addText('To indicate your acceptance of the terms of this Agreement, please sign and return the duplicate original copy to','rStyle3','Paragraph');
		$section->addText('PT Taisho Pharmaceutical Indonesia Tbk.','rStyle','Paragraph');
		$section->addText('Wisma Tamara Lantai 10, Jl. Jend. Sudirman Kav. 24, Jakarta 12920','rStyle2','Paragraph');
		$section->addText('Attn.: Nurmala Sari','rStyle2','Paragraph');
		$section->addText('Email: nurmala.sari@ma.taisho.co.id','rStyle2','Paragraph');
		$section->addText('Fax  : +62 21 520 6735','rStyle2','Paragraph3');
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
		$section->addText('I agree to provide the Services to TAISHO on the terms of this Agreement and have obtained all necessary employer, institution, organization or governmental consents to provide the Services.','rStyle2','Paragraph3');
		$section->addTextBreak();
		$section->addText('Signature :	_______________________________________________','rStyle2','Paragraph3');
		$section->addTextBreak();
		$section->addText('Name      :	_______________________________________________','rStyle2','Paragraph3');
		$section->addTextBreak();
		$section->addText('Title     :	_______________________________________________','rStyle2','Paragraph3');
		$section->addTextBreak();
		$section->addText('Date      :	_______________________________________________','rStyle2','Paragraph3');

		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$objWriter->save(APP_PATH.'assets/uploads/AgreementLetter-SERF-'.date("Y",strtotime($created_date)).'-SA-'.date("m",strtotime($created_date)).'-'.$this->input->post('nodoc2').'.docx');


		redirect(base_url()."index.php/AgreementLetter3?id_sc=".$this->input->post('id_sc')."&id=".$id_tl);
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
