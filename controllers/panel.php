<?php

class panel extends Controller  {
	
	public $yetkikontrol,$aramadegeri;
	
	
	function __construct() {
		
		parent::KutuphaneYukle(array("view","form","bilgi","Upload","Pagination","dosyacikti","DosyaIslemleri"));
		
	$this->Modelyukle('adminpanel');
	Session::init();
		
		
	
		if (!Session::get("AdminAd") && !Session::get("Adminid")) : 

		$this->giris();
		
		exit();
		
		else:
		
		$this->yetkikontrol = new PanelHarici();
		
		endif;


	
	}	// construct	

	function giris() {
		
		if (Session::get("AdminAd") && Session::get("Adminid")) : 
		
		$this->bilgi->direktYonlen("/panel/siparisler");

		else:
		
		$this->view->goster("YonPanel/sayfalar/index");
	
		endif;
		
	} // LOGİN GİRİŞ SAYFASI	
	
	function Index() {
	
		if ($this->yetkikontrol->yoneticiYetki==2) :
		
		$this->urunler();
		
		elseif ($this->yetkikontrol->yoneticiYetki==3) :
		
		$this->uyeler();
		
		else:
		
		$this->siparisler();
		
		endif;
	
	
		
	} // VARSAYILAN OLARAK ÇALIŞIYOR

	//--------------------------------------------------------------------------------------
	
	function siparisler() {
			$this->yetkikontrol->YetkisineBak("siparisYonetim");
			
	$this->view->goster("YonPanel/sayfalar/siparis",array(
	
	"data" => $this->model->SpesifikVerial("siparis_no from siparisler")
	
	));		
		
	} // SİPARİŞLERİN ANA EKRANI	
	
	function kargoguncelle($sipno) {
			
			$this->yetkikontrol->YetkisineBak("siparisYonetim");
	$this->view->goster("YonPanel/sayfalar/siparis",array(
	
	"KargoGuncelle" => $this->model->Verial("siparisler","where siparis_no=".$sipno)
	
	));		
	
	
		
	}  // KARGO DURUM GÜNCELLEME
	
	function kargoguncelleSon() {
			$this->yetkikontrol->YetkisineBak("siparisYonetim");
				if ($_POST) :	
		
				$sipno=$this->form->get("sipno")->bosmu();
				$durum=$this->form->get("durum")->bosmu();
				
				
		$sonuc=$this->model->Guncelle("siparisler",
		array("kargodurum"),
		array($durum),"siparis_no=".$sipno);
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/siparis",
			array(
			"bilgi" => $this->bilgi->basarili("GÜNCELLEME BAŞARILI","/panel/siparisler")
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/siparis",
			array(
			"data" => $this->model->Verial("siparisler",false),
			"bilgi" => $this->bilgi->uyari("danger","Güncelleme sırasında hata oluştu.")
			 ));	
		
		endif;
				
			else:
			$this->bilgi->direktYonlen("/panel/siparisler");
				
	
				endif;
	
		
	} // KARGO DURUM GÜNCELLEME SON	
	
	function siparisarama() {	
		$this->yetkikontrol->YetkisineBak("siparisYonetim");
		if ($_POST) :
		$aramatercih=$this->form->get("aramatercih")->bosmu();
		
		$aramaverisi=$this->form->get("aramaverisi")->bosmu();
		
		
		
				if (!empty($this->form->error)) :
				
			$this->view->goster("YonPanel/sayfalar/siparis",
			array(		
			"bilgi" => $this->bilgi->hata("BİLGİ GİRİLMELİDİR.","/panel/siparisler",1)
			 ));
				
				
				else:
				
				
		if ($aramatercih=="sipno") :
				
				
			$this->view->goster("YonPanel/sayfalar/siparis",array(
	
			"data" => $this->model->arama("siparisler","siparis_no LIKE '".$aramaverisi."'")));	
			
			elseif($aramatercih=="uyebilgi"):
			
			
			$bilgicek=$this->model->arama("uye_panel",
			"id LIKE '%".$aramaverisi."%' or 
			ad LIKE '%".$aramaverisi."%'  or 
			soyad LIKE '%".$aramaverisi."%' or 
			telefon LIKE '%".$aramaverisi."%'");
			
				if ($bilgicek):
			
				$this->view->goster("YonPanel/sayfalar/siparis",array(				
				"data" => $this->model->arama("siparisler","uyeid LIKE '".$bilgicek[0]["id"]."'")				
				));		
				
				else:
				
				$this->view->goster("YonPanel/sayfalar/siparis",
				array(		
				"bilgi" => $this->bilgi->hata("HİÇBİR KRİTER UYUŞMADI.","/panel/siparisler",2)
				 ));			
				endif;
				
		endif;
				
		
		
				
				endif;
		
		
		
		else:
			$this->bilgi->direktYonlen("/panel/siparisler");		
		
		
		endif;
	
			

	
		
	} // SİPARİŞ ARAMA
	
	function siparisdetayliarama() {	
	$this->yetkikontrol->YetkisineBak("siparisYonetim");
	
				

		if ($_POST) :
			$siparis_no=$this->form->get("siparis_no",true);		
			$uyebilgi=$this->form->get("uyebilgi",true);		
			$kargodurum=$this->form->get("kargodurum",true);	
			$odemeturu=$this->form->get("odemeturu",true);	
			$durum=$this->form->get("durum",true);			
			$tarih1=$this->form->get("tarih1",true);		
			$tarih2=$this->form->get("tarih2",true);	


			if (!empty($siparis_no)) : 
				$this->aramadegeri.="<strong>Sipariş Numarası :</strong> ".$siparis_no;	
			endif;

			if (!empty($kargodurum)) : 		
					switch ($kargodurum):				
					case "0";
					$this->aramadegeri.="<strong>Kargo Durumu :</strong> Tedarik Sürecinde ";
					break;
					case "1";
					$this->aramadegeri.="<strong>Kargo Durumu :</strong> Paketleniyor ";
					break;
					case "2";
					$this->aramadegeri.="<strong>Kargo Durumu :</strong> Kargolandı ";
					break;				
					endswitch;
				endif;

			if (!empty($odemeturu)) : 
				$this->aramadegeri.="<strong>Ödeme Türü :</strong> ".$odemeturu." ";	
			endif;

			if (!empty($durum)) : 		
					switch ($durum):				
					case "0";
					$this->aramadegeri.="<strong>Sipariş Durumu :</strong> İşlemde ";
					break;
					case "1";
					$this->aramadegeri.="<strong>Sipariş Durumu :</strong> Tamamlanmış ";
					break;
					case "2";
					$this->aramadegeri.="<strong>Sipariş Durumu :</strong> İade ";
					break;		
					endswitch;
				endif; 

			if (!empty($tarih1) && !empty($tarih2)) :	
				$tarihbilgisi="and	DATE(tarih) BETWEEN  '".$tarih1."' and '".$tarih2."'";			
				$this->aramadegeri.="<strong>Başlangıç tarihi :</strong> ".$tarih1 ." <strong>Bitiş tarihi :</strong> ".$tarih2;
			endif;
		
			if (!empty($uyebilgi)) :				
				$bilgicek=$this->model->Arama("uye_panel",
				"id LIKE '%".$uyebilgi."%' or 
				ad LIKE '%".$uyebilgi."%'  or 
				soyad LIKE '%".$uyebilgi."%' or 
				telefon LIKE '%".$uyebilgi."%'");
		
						if ($bilgicek):		
						$this->view->goster("YonPanel/sayfalar/siparisdetayarama",array(			
						"data" => $this->model->Arama("siparisler",
						"uyeid='".$bilgicek[0]["id"]."' and
						siparis_no LIKE '%".$siparis_no."%' and
						kargodurum LIKE '%".$kargodurum."%' and
						odemeturu LIKE '%".$odemeturu."%' and
						durum LIKE '%".$durum."%' ".@$tarihbilgisi."
						"),
						"aramakriter" => $this->aramadegeri
						));						
						endif;

				elseif (!empty($siparis_no)) :				
				$this->view->goster("YonPanel/sayfalar/siparisdetayarama",array(				
					"data" => $this->model->Arama("siparisler","siparis_no LIKE ".$siparis_no),
					"aramakriter" => $this->aramadegeri
						));
				else:
					$this->view->goster("YonPanel/sayfalar/siparisdetayarama",array(			
						"data" => $this->model->Arama("siparisler",
						"kargodurum LIKE '%".$kargodurum."%' and
						odemeturu LIKE '%".$odemeturu."%' and
						durum LIKE '%".$durum."%' ".@$tarihbilgisi."
						"),
						"aramakriter" => $this->aramadegeri
						));	
				endif;

		else:
			$this->view->goster("YonPanel/sayfalar/siparisdetayarama",array(	
			"varsayilan" => true
			));			
		endif;
		
	} // SİPARİŞ  DETAYLI ARAMA*/
	
	function siparisExcelAl () {
		
		$this->yetkikontrol->YetkisineBak("siparisYonetim");
		$gelennumaralar=Session::get("numaralar");
		$this->model->ExcelAyarCek2("siparis_no,urunad,urunadet,urunfiyat,toplamfiyat,kargodurum,odemeturu,durum,tarih from siparisler where siparis_no IN(".$gelennumaralar.")");
		
		$this->dosyacikti->Excelaktar("SİPARİŞLER",NULL,
		array("Sipariş Numarası",
			  "Ürün Ad",
			  "Ürün Adet",
			  "Ürün Fiyat",
			  "Toplam Fiyat",
			  "Kargo Durum",
			  "Ödeme Türü",
			  "Durum",
			  "Tarih"
			  ),$this->model->icerikler[0]);
		
	}  // SİPARİŞ EXCEL ÇIKTI
	
	function siparisiade() {
			$this->yetkikontrol->YetkisineBak("siparisYonetim");
			
	$this->view->goster("YonPanel/sayfalar/siparisiade",array(
	
	"data" => $this->model->SpesifikVerial("siparis_no from siparisler where durum=2")
	
	));		
		
	} // SİPARİŞLERİN İADE EKRANI	
	
	//--------------------------------------------------------------------------------------
	
	function kategoriler() {
			$this->yetkikontrol->YetkisineBak("kategoriYonetim");
			
	$this->view->goster("YonPanel/sayfalar/kategoriler",array(
	
	"anakategori" => $this->model->Verial("ana_kategori",false),
	"cocukkategori" => $this->model->Verial("cocuk_kategori",false),
	"altkategori" => $this->model->Verial("alt_kategori",false)
	
	
	
	));		
	
	
		
	} // KATEGORİLER GELİYOR	
	
	function kategoriGuncelle($kriter,$id) {
		
	$this->yetkikontrol->YetkisineBak("kategoriYonetim");
				
	$this->view->goster("YonPanel/sayfalar/kategoriguncelleme",array(
	
	"data" => $this->model->Verial($kriter."_kategori","where id=".$id),
	"kriter" => $kriter,
	"AnakategorilerTumu" => $this->model->Verial("ana_kategori",false),
	"CocukkategorilerTumu" => $this->model->Verial("cocuk_kategori",false)
	
	));	
		
	
		
	} // KATEGORİLER GÜNCELLE	
	
	function kategoriGuncelSon() {
		
	$this->yetkikontrol->YetkisineBak("kategoriYonetim");
		
			if ($_POST) :	
				$kriter=$this->form->get("kriter")->bosmu();
				$kayitid=$this->form->get("kayitid")->bosmu();
				$katad=$this->form->get("katad")->bosmu();
				
				@$anakatid=$_POST["anakatid"];
				@$cocukkatid=$_POST["cocukkatid"];
		
				
				
				if (!empty($this->form->error)) :
				
			$this->view->goster("YonPanel/sayfalar/kategoriguncelleme",
			array(		
			"bilgi" => $this->bilgi->SweetAlert(URL."/panel/kategoriler","BAŞARISIZ","Kategori adı boş olamaz.","warning")
	));
	
			 		
				
			else:	
				
		
		
		if ($kriter=="ana") :
		
		$sonuc=$this->model->Guncelle("ana_kategori",
		array("ad"),
		array($katad),"id=".$kayitid);
				
		elseif($kriter=="cocuk") :
		
		
		$sonuc=$this->model->Guncelle("cocuk_kategori",
		array("ana_kat_id","ad"),
		array($anakatid,$katad),"id=".$kayitid);
		
	
			
		elseif($kriter=="alt") :
		
		$sonuc=$this->model->Guncelle("alt_kategori",
		array("cocuk_kat_id","ana_kat_id","ad"),
		array($cocukkatid,$anakatid,$katad),"id=".$kayitid);
		endif;
		
				
				
				
				
		
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/kategoriguncelleme",
			array(
				
				
			"bilgi" => $this->bilgi->SweetAlert(URL."/panel/kategoriler","BAŞARILI","GÜNCELLEME BAŞARILI","success")	
				
			 ));
				
		else:
		
		
		
			$this->view->goster("YonPanel/sayfalar/kategoriguncelleme",
								
			array(
			"bilgi" => $this->bilgi->SweetAlert(URL."/panel/kategoriler","BAŞARISIZ","GÜNCELLEME SIRASINDA HATA OLUŞTU.","warning")
				
			 ));	
		
		endif;
		
	
		
		endif;
		
				
			else:
			$this->bilgi->direktYonlen("/panel/kategoriler");
				
	
				endif;		
		
	
	
		
	} // KATEGORİLER GÜNCELLENENİYOR VE SON POST İŞLEMİ BURASI
	
	function kategoriSil($kriter,$id) {
	
		$this->yetkikontrol->YetkisineBak("kategoriYonetim");
	$sonuc=$this->model->Sil($kriter."_kategori","id=".$id);
	
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/kategoriler",
			array(
	"bilgi" => $this->bilgi->SweetAlert(URL."/panel/kategoriler","BAŞARILI","SİLME BAŞARILI","success")
				
		));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/kategoriler",
			array(
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/kategoriler","BAŞARISIZ","SİLME SIRASINDA HATA OLUŞTU","warning")
				
			 ));	
		
		endif;
	

	
		
	} // KATEGORİ SİL
	
	function kategoriEkle($kriter) {
		$this->yetkikontrol->YetkisineBak("kategoriYonetim");
	$this->view->goster("YonPanel/sayfalar/kategoriEkle",
	array("kriter" => $kriter,
	"AnaktegorilerTumu" => $this->model->Verial("ana_kategori",false),
	"CocukkategorilerTumu" => $this->model->Verial("cocuk_kategori",false)));		
		
		
	} // KATEGORİ EKLE
	
	function kategoriEkleSon() {
	
	$this->yetkikontrol->YetkisineBak("kategoriYonetim");
			
		
			if ($_POST) :	
				$kriter=$this->form->get("kriter")->bosmu();		
				$katad=$this->form->get("katad")->bosmu();
				
				@$anakatid=$_POST["anakatid"];
				@$cocukkatid=$_POST["cocukkatid"];
		
				
				
				if (!empty($this->form->error)) :
				
			$this->view->goster("YonPanel/sayfalar/kategoriekle",
			array(	
				
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/kategoriler","BAŞARISIZ","Kategori adı girilmelidir.","warning")
				
			
			 ));		
				
			else:	
				
		
		
		if ($kriter=="ana") :
		
		$sonuc=$this->model->Ekleme("ana_kategori",
		array("ad"),
		array($katad));
				
		elseif($kriter=="cocuk") :
		
		
		$sonuc=$this->model->Ekleme("cocuk_kategori",
		array("ana_kat_id","ad"),
		array($anakatid,$katad));
		
	
			
		elseif($kriter=="alt") :
		
		$sonuc=$this->model->Ekleme("alt_kategori",
		array("cocuk_kat_id","ana_kat_id","ad"),
		array($cocukkatid,$anakatid,$katad));
		endif;
		
				
				
				
				
		
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/kategoriekle",
			array(
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/kategoriler","BAŞARILI","EKLEME BAŞARILI","success")
			
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/kategoriekle",
			array(
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/kategoriler","BAŞARISIZ","EKLEME SIRASINDA HATA OLUŞTU.","warning")
				
			
			 ));	
		
		endif;
		
	
		
		endif;
		
				
			else:
			$this->bilgi->direktYonlen("/panel/kategoriler");
				
	
				endif;		
		
	
		
	} // KATEGORİ EKLE SON
	
	function kategoriarama() {	
		$this->yetkikontrol->YetkisineBak("kategoriYonetim");
		if ($_POST) :
		$aramatercih=$this->form->get("aramatercih")->bosmu();
		
		$aramaverisi=$this->form->get("aramaverisi")->bosmu();
		
		
		
			   	if (!empty($this->form->error)) :
				
			$this->view->goster("YonPanel/sayfalar/kategoriler",
			array(		
			"bilgi" => $this->bilgi->hata("Boş alan bırakılmamalıdır.","/panel/kategoriler",1)
			 ));
				
				
				else:
				
				
		    if ($aramatercih=="ana") :
				
			$bilgicek=$this->model->arama("ana_kategori",
			"ad LIKE '%".$aramaverisi."%'");
			
			
			elseif($aramatercih=="cocuk"):
		
		
		    $bilgicek=$this->model->joinislemi(
			array(
			"ana_kategori.ad As anakatad",
			"cocuk_kategori.ad As cocukad",
			"cocuk_kategori.id As cocukid"	
			),
			array(
			"ana_kategori",
			"cocuk_kategori"
			),
			"ana_kategori.id=cocuk_kategori.ana_kat_id AND
		
		 cocuk_kategori.ad LIKE '%".$aramaverisi."%'"
			);
			
		
		    elseif($aramatercih=="alt"):
			$bilgicek=$this->model->joinislemi(
			array(
			"ana_kategori.ad As anakatad",
			"cocuk_kategori.ad As cocukkatad",
			"alt_kategori.ad As altad",
			"alt_kategori.id As altid"	
			),
			array(
			"ana_kategori",
			"cocuk_kategori",
			"alt_kategori"
			),
			"(ana_kategori.id=cocuk_kategori.ana_kat_id) AND(cocuk_kategori.id=alt_kategori.cocuk_kat_id)
		AND 
		alt_kategori.ad LIKE '%".$aramaverisi."%'"
			);
		    
			
			endif;
			
				if ($bilgicek):
			
				$this->view->goster("YonPanel/sayfalar/kategoriler",array(				
				"kategoriaramasonuc" => $bilgicek,
				"kelime" =>	$aramaverisi,
			    "kategorimiz" =>$aramatercih
				));		
				
				else:
				
				$this->view->goster("YonPanel/sayfalar/kategoriler",
				array(		
				"bilgi" => $this->bilgi->hata("HİÇBİR KRİTER UYUŞMADI.","/panel/kategoriler",2)
				 ));			
				endif;
				
		
				
		
		
				
				endif;
		
		
		
		else:
			$this->bilgi->direktYonlen("/panel/kategoriler");		
		
		
		endif;
	
			

	
		
	} // KATEGORİ ARAMA
		
	//--------------------------------------------------------------------------------------
	
	function uyeler ($mevcutsayfa=false) {
		
		$this->yetkikontrol->YetkisineBak("uyeYonetim");
		
		$this->Pagination->paginationOlustur($this->model->sayfalama("uye_panel"),$mevcutsayfa,$this->model->tekliveri("uyelerGoruntuAdet","from ayarlar"));
		
		
		$this->view->goster("YonPanel/sayfalar/uyeler",array(
		
		"data" => $this->model->Verial("uye_panel"," LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet), 
		"toplamsayfa" => $this->Pagination->toplamsayfa,
		"toplamveri" => $this->model->sayfalama("uye_panel")
		
		));
	
	
		
	} // ÜYELER GELİYOR	
		
	function uyeguncelleSon() {
			
			$this->yetkikontrol->YetkisineBak("uyeYonetim");
			
				if ($_POST) :	
				
					$ad=$this->form->get("ad")->bosmu();
					$soyad=$this->form->get("soyad")->bosmu();
					$mail=$this->form->get("mail")->bosmu();
					$telefon=$this->form->get("telefon")->bosmu();
					//$durum=$this->form->get("durum")->bosmu();
					$uyeid=$this->form->get("uyeid")->bosmu();
					$durum=$_POST["durum"];
					
					if (!empty($this->form->error)) :
					
				$this->view->goster("YonPanel/sayfalar/uyeler",
				array(		
				"bilgi" => $this->bilgi->hata("Tüm alanlar doldurulmalıdır.","/panel/uyeler",2)
				 ));		
					
				else:	
					
			
		
		
			$sonuc=$this->model->Guncelle("uye_panel",
			array("ad","soyad","mail","telefon","durum"),
			array($ad,$soyad,$mail,$telefon,$durum),"id=".$uyeid);
					
		
			
		
			if ($sonuc): 
		
				$this->view->goster("YonPanel/sayfalar/uyeler",
				array(
				"bilgi" => $this->bilgi->basarili("GÜNCELLEME BAŞARILI","/panel/uyeler",2)
				 ));
					
			else:
			
				$this->view->goster("YonPanel/sayfalar/uyeler",
				array(
				"bilgi" => $this->bilgi->hata("GÜNCELLEME SIRASINDA HATA OLUŞTU.","/panel/uyeler",2)
				 ));	
			
			endif;
			
		
			
			endif;
			
					
				else:
				$this->bilgi->direktYonlen("/panel/uyeler");
					
		
					endif;		
			
		
		
			
		} // ÜYELER GÜNCEL SON	
	
	function uyeGuncelle($id) {
		
	$this->yetkikontrol->YetkisineBak("uyeYonetim");
				
	$this->view->goster("YonPanel/sayfalar/uyeler",array(	
	"Uyeguncelle" => $this->model->Verial("uye_panel","where id=".$id)	
	));	
		
	
		
	} // ÜYELER GÜNCELLE	
		
	function uyeSil($id) {
	$this->yetkikontrol->YetkisineBak("uyeYonetim");
		
	$sonuc=$this->model->Sil("uye_panel","id=".$id);
	
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/uyeler",
			array(
			"bilgi" => $this->bilgi->basarili("SİLME BAŞARILI","/panel/uyeler",2)
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/uyeler",
			array(
			"bilgi" => $this->bilgi->hata("SİLME SIRASINDA HATA OLUŞTU.","/panel/uyeler",2)
			 ));	
		
		endif;
	

	
		
	}  // ÜYE SİL	
		
	function uyearama($kelime=false,$mevcutsayfa=false) {	
		$this->yetkikontrol->YetkisineBak("uyeYonetim");
		
		if ($_POST || isset($kelime)) :
		
		if ($_POST): 
		$aramaverisi=$this->form->get("aramaverisi")->bosmu();
		$sorgum=!empty($this->form->error);
		else:
		$aramaverisi=$kelime;
		$sorgum=empty($kelime);
		endif;
				
		$aramaverisi=$this->form->get("aramaverisi")->bosmu();
		
		
				if ($sorgum) :
		
				
				$this->view->goster("YonPanel/sayfalar/uyeler",
				array(		
				"bilgi" => $this->bilgi->hata("KRİTER GİRİLMELİDİR.","/panel/uyeler",2)
				 ));
				
				
				else:
		    $bilgicek=$this->model->arama("uye_panel",
			"id LIKE '%".$aramaverisi."%' or 
			ad LIKE '%".$aramaverisi."%'  or 
			soyad LIKE '%".$aramaverisi."%' or 
			telefon LIKE '%".$aramaverisi."%'");
		
		    $this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("uyelerAramaAdet","from ayarlar"));
				
		
		
				if (count($bilgicek)>0):
			
				$this->view->goster("YonPanel/sayfalar/uyeler",array(
				
				"data" => $this->model->arama("uye_panel",
			"id LIKE '%".$aramaverisi."%' or 
			ad LIKE '%".$aramaverisi."%'  or 
			soyad LIKE '%".$aramaverisi."%' or 
			telefon LIKE '%".$aramaverisi."%' LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet), 
		"toplamsayfa" => $this->Pagination->toplamsayfa,
		"toplamveri" => count($bilgicek),
		"arama" => $aramaverisi
		
		
				
				));		
				
				else:
		
				
				$this->view->goster("YonPanel/sayfalar/uyeler",
				array(		
				"bilgi" => $this->bilgi->hata("HİÇBİR KRİTER UYUŞMADI.","/panel/uyeler",2)
				 ));			
				endif;
	
				
				endif;
		
		
		else:
			$this->bilgi->direktYonlen("/panel/uyeler");		
		
		
		endif;
	
			

	
		
	} // ÜYE ARAMA
	
	function uyeadresbak($id) {
		
	$this->yetkikontrol->YetkisineBak("uyeYonetim");
				
	$this->view->goster("YonPanel/sayfalar/uyeler",array(	
	"UyeadresBak" => $this->model->Verial("adresler","where uyeid=".$id)	
	));	
		
	
		
	} // ÜYE ADRESLERİ
	
	function musteriyorumlar ($mevcutsayfa=false) {
		$this->yetkikontrol->YetkisineBak("uyeYonetim");
		$this->Pagination->paginationOlustur($this->model->sayfalama("yorumlar"),$mevcutsayfa,$this->model->tekliveri("uyelerYorumAdet","from ayarlar"));
		
		
		
		
		$this->view->goster("YonPanel/sayfalar/musteriyorumlar",array(
		
		"data" => $this->model->joinislemi(
		array(
		"urunler.urunad As urunad",
		"yorumlar.*"
			
		),
		array(
		"urunler",
		"yorumlar"
		),
		"yorumlar.urunid=urunler.id order by durum asc LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet
		), 
		"toplamsayfa" => $this->Pagination->toplamsayfa,
		"toplamveri" => $this->model->sayfalama("yorumlar")
		
		));
	
	
		
	} // ÜYELERİN YORUMLARI
	
	//--------------------------------------------------------------------------------------
	
	function urunler ($mevcutsayfa=false) {
		
		$this->yetkikontrol->YetkisineBak("urunYonetim");
		$this->Pagination->paginationOlustur($this->model->sayfalama("urunler"),$mevcutsayfa,$this->model->tekliveri("urunlerGoruntuAdet","from ayarlar"));
		
		$this->view->goster("YonPanel/sayfalar/urunler",array(
		
		"data" => $this->model->Verial("urunler"," LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet), 
		"toplamsayfa" => $this->Pagination->toplamsayfa,
		"toplamveri" => $this->model->sayfalama("urunler"),
		"data2" => $this->model->Verial("alt_kategori",false),
		"AnakategorilerTumu" => $this->model->Verial("ana_kategori",false),
		"CocukkategorilerTumu" => $this->model->Verial("cocuk_kategori",false),
		
		));
		
	
	
		
	}  // ÜRÜNLER GELİYOR
	
	function urunGuncelle($id) {
		
	$this->yetkikontrol->YetkisineBak("urunYonetim");
				
	$this->view->goster("YonPanel/sayfalar/urunler",array(	
	"Urunguncelle" => $this->model->Verial("urunler","where id=".$id),
	"data2" => $this->model->Verial("alt_kategori",false),
	"AnakategorilerTumu" => $this->model->Verial("ana_kategori",false),
	"CocukkategorilerTumu" => $this->model->Verial("cocuk_kategori",false)
	));	
		
	
		
	} // ÜRÜNLER GÜNCELLE	
	
	function urunguncelleSon() {	
		$this->yetkikontrol->YetkisineBak("urunYonetim");
		
			if ($_POST) :	
			
						
				$urunad=$this->form->get("urunad")->bosmu();
				$ana_kat_id=$this->form->get("ana_kat_id")->bosmu();
				$cocuk_kat_id=$this->form->get("cocuk_kat_id")->bosmu();
				$katid=$this->form->get("katid")->bosmu();
				$kumas=$this->form->get("kumas")->bosmu();
				$uretimyeri=$this->form->get("uretimyeri")->bosmu();
				$renk=$this->form->get("renk")->bosmu();
				$fiyat=$this->form->get("fiyat")->bosmu();
				$stok=$this->form->get("stok")->bosmu();
				$durum=$this->form->Selectboxget("durum");
				$urunaciklama=$this->form->get("urunaciklama")->bosmu();
				$urunozellik=$this->form->get("urunozellik")->bosmu();
				$urunekstra=$this->form->get("urunekstra")->bosmu();
				$kayitid=$this->form->get("kayitid")->bosmu();
				
				
		
				
if ($this->Upload->uploadPostAl("res1")) : $this->Upload->UploadDosyaKontrol("res1");	endif;	

if ($this->Upload->uploadPostAl("res2")) : $this->Upload->UploadDosyaKontrol("res2");	endif;	
				
if ($this->Upload->uploadPostAl("res3")) : $this->Upload->UploadDosyaKontrol("res3");	endif;				
		
		
				
			
				
			if (!empty($this->form->error)) :
				
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(		
			"bilgi" => $this->bilgi->hata("Tüm alanlar doldurulmalıdır.","/panel/urunler",2)
			 ));
			 
			elseif (!empty($this->Upload->error)) :
				
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(		
			"bilgi" => $this->Upload->error,
			"yonlen" =>$this->bilgi->sureliYonlen(3,"/panel/urunler") 
			 ));	
		
	
				
			else:	
				
		
			
			
			$sutunlar=array("ana_kat_id","cocuk_kat_id","katid","urunad","durum","aciklama","kumas","urtYeri","renk","fiyat","stok","ozellik","ekstraBilgi");
			
			$veriler=array($ana_kat_id,$cocuk_kat_id,$katid,$urunad,$durum,$urunaciklama,$kumas,$uretimyeri,$renk,$fiyat,$stok,$urunozellik,$urunekstra);
			
			
 if ($this->Upload->uploadPostAl("res1")) :
 	$sutunlar[]="res1"; 
	$veriler[]=$this->Upload->Yukle("res1",true); 
 endif;	

 if ($this->Upload->uploadPostAl("res2")) :
 	$sutunlar[]="res2"; 
	$veriler[]=$this->Upload->Yukle("res2",true); 
 endif;	
  if ($this->Upload->uploadPostAl("res3")) :
 	$sutunlar[]="res3"; 
	$veriler[]=$this->Upload->Yukle("res3",true); 
 endif;	
			
		
	
		$sonuc=$this->model->Guncelle("urunler",
		$sutunlar,
		$veriler,"id=".$kayitid);
				
	
		
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(
			"bilgi" => $this->bilgi->basarili("ÜRÜN BAŞARIYLA GÜNCELLENDİ","/panel/urunler",2)
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(
			"bilgi" => $this->bilgi->hata("GÜNCELLEME SIRASINDA HATA OLUŞTU.","/panel/urunler",2)
			 ));	
		
		endif;
		
	
		
		endif;
		
				
			else:
			$this->bilgi->direktYonlen("/panel/urunler");
				
	
	endif;		
		
		
		
	
	
		
	} // ÜRÜNLER GÜNCEL SON
	
	function Urunekleme() {	
			$this->yetkikontrol->YetkisineBak("urunYonetim");	
	$this->view->goster("YonPanel/sayfalar/urunler",array(	
	"Urunekleme" => true,
	"data2" => $this->model->Verial("alt_kategori",false)		
	));	
		
	
		
	}	 // ÜRÜN EKLEME
	
	function urunekle() {	
		
		$this->yetkikontrol->YetkisineBak("urunYonetim");
			if ($_POST) :	
			
				$urunad=$this->form->get("urunad")->bosmu();
				$katid=$this->form->get("katid")->bosmu();
				$kumas=$this->form->get("kumas")->bosmu();
				$uretimyeri=$this->form->get("uretimyeri")->bosmu();
				$renk=$this->form->get("renk")->bosmu();
				$fiyat=$this->form->get("fiyat")->bosmu();
				$stok=$this->form->get("stok")->bosmu();
				$durum=$this->form->get("durum")->bosmu();
				$urunaciklama=$this->form->get("urunaciklama")->bosmu();
				$urunozellik=$this->form->get("urunozellik")->bosmu();
				$urunekstra=$this->form->get("urunekstra")->bosmu();
			
			$this->Upload->UploadResimYeniEkleme("res",3);
				
			
				
				if (!empty($this->form->error)) :
				
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(		
			"bilgi" => $this->bilgi->hata("Tüm alanlar doldurulmalıdır.","/panel/urunler",2)
			 ));	
			 
			 	elseif (!empty($this->Upload->error)) :
				
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(		
			"bilgi" => $this->Upload->error
			 ));	
				
			else:	
				
		
				$dosyayukleme=$this->Upload->Yukle();
	
		$sonuc=$this->model->Ekleme("urunler",
		array("katid","urunad","res1","res2","res3","durum","aciklama","kumas","urtYeri","renk","fiyat","stok","ozellik","ekstraBilgi"),
		array($katid,$urunad,$dosyayukleme[0],$dosyayukleme[1],$dosyayukleme[2],$durum,$urunaciklama,$kumas,$uretimyeri,$renk,$fiyat,$stok,$urunozellik,$urunekstra));
				
	
		
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(
			"bilgi" => $this->bilgi->basarili("ÜRÜN BAŞARIYLA EKLENDİ","/panel/urunler",2)
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(
			"bilgi" => $this->bilgi->hata("EKLEME SIRASINDA HATA OLUŞTU.","/panel/urunler",2)
			 ));	
		
		endif;
		
	
		
		endif;
		
				
			else:
			$this->bilgi->direktYonlen("/panel/urunler");
				
	
	endif;		
		
		
		
	
	
		
	}	 // ÜRÜN EKLEME SON	
		
	function urunSil($id) {
	
		$this->yetkikontrol->YetkisineBak("urunYonetim");
	$sonuc=$this->model->Sil("urunler","id=".$id);
	
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(
			"bilgi" => $this->bilgi->basarili("SİLME BAŞARILI","/panel/urunler",2)
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/urunler",
			array(
			"bilgi" => $this->bilgi->hata("SİLME SIRASINDA HATA OLUŞTU.","/panel/urunler",2)
			 ));	
		
		endif;
	

	
		
	}  // ÜRÜNLER SİL	
	
	function katgoregetir($katid=false,$mevcutsayfa=false) {	
		$this->yetkikontrol->YetkisineBak("urunYonetim");
		if ($_POST) :
				
		$katid=$this->form->get("katid")->bosmu();

		
		$bilgicek=$this->model->Verial("urunler","where katid=".$katid);
		
	
			
		$this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("urunlerKategoriAdet","from ayarlar"));
		
				if ($bilgicek):
			
				$this->view->goster("YonPanel/sayfalar/urunler",array(
				
				"data" => $this->model->Verial("urunler","where katid=".$katid." LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet),
				"toplamsayfa" => $this->Pagination->toplamsayfa,
				"toplamveri" => count($bilgicek),
				"katid" => $katid,	
				"data2" => $this->model->Verial("alt_kategori",false),
				"AnakategorilerTumu" => $this->model->Verial("ana_kategori",false)
					
				));	
		
			
				
				else:
				
				$this->view->goster("YonPanel/sayfalar/urunler",
				array(		
				"bilgi" => $this->bilgi->hata("HİÇBİR KRİTER UYUŞMADI.","/panel/urunler",2)
				 ));			
				endif;
	
		elseif(isset($katid)):
		$bilgicek=$this->model->Verial("urunler","where katid=".$katid);
		
	
		$this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("urunlerKategoriAdet","from ayarlar"));
		
		
		$this->view->goster("YonPanel/sayfalar/urunler",array(
				"data" => $this->model->Verial("urunler","where katid=".$katid." LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet),
				"toplamsayfa" => $this->Pagination->toplamsayfa,
				"toplamveri" => count($bilgicek),
				"katid" => $katid,	
				"data2" => $this->model->Verial("alt_kategori",false)			
				));	
		
			
		
		
		
		else:
			$this->bilgi->direktYonlen("/panel/urunler");		
		
		
		endif;
	
			

	
		
	} // ÜRÜNLERi KATEGORİYE GÖRE GETİR	
	
	function urunarama($kelime=false,$mevcutsayfa=false) {	
		$this->yetkikontrol->YetkisineBak("urunYonetim");
		if ($_POST || isset($kelime)) :
		
		if ($_POST): 
		$aramaverisi=$this->form->get("arama")->bosmu();
		$sorgum=!empty($this->form->error);
		else:
		$aramaverisi=$kelime;
		$sorgum=empty($kelime);
		endif;
		
	
		
				if ($sorgum) :
				
				$this->view->goster("YonPanel/sayfalar/urunler",
				array(		
				"bilgi" => $this->bilgi->hata("KRİTER GİRİLMELİDİR.","/panel/urunler",2)
				 ));
				
				
				else:
				
			
			
			$bilgicek=$this->model->arama("urunler",
			"urunad LIKE '%".$aramaverisi."%' or 
			kumas LIKE '%".$aramaverisi."%'  or 
			urtYeri LIKE '%".$aramaverisi."%' or 
			stok LIKE '%".$aramaverisi."%'");
			
		$this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("urunlerAramaAdet","from ayarlar"));
		
				if (count($bilgicek)>0):
			
		
		    $this->view->goster("YonPanel/sayfalar/urunler",array(
			"data" => $this->model->arama("urunler",
			"urunad LIKE '%".$aramaverisi."%' or 
			kumas LIKE '%".$aramaverisi."%'  or 
			urtYeri LIKE '%".$aramaverisi."%' or 
			stok LIKE '%".$aramaverisi."%' LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet), 
			"toplamsayfa" => $this->Pagination->toplamsayfa,
			"toplamveri" => count($bilgicek),
			"arama" => $aramaverisi,
			"data2" => $this->model->Verial("alt_kategori",false),
			"AnakategorilerTumu" => $this->model->Verial("ana_kategori",false)
		));
				else:
				
				$this->view->goster("YonPanel/sayfalar/urunler",
				array(		
				"bilgi" => $this->bilgi->hata("HİÇBİR KRİTER UYUŞMADI.","/panel/urunler",2)
				 ));			
				endif;
	
				
				endif;
				
		else:
			$this->bilgi->direktYonlen("/panel/urunler");		
		
		
		endif;
	
			

	
		
	} // ÜRÜNLER ARAMA	
	
	function topluurunekle($son=false) {			
		$this->yetkikontrol->YetkisineBak("urunYonetim");
		if ($son):
		$tercih=$this->form->radiobutonget("dosyatercih");
			if ($tercih=="xml"):
				$this->DosyaIslemleri->VerileriAyikla("dosya","/urunler/urun",
				array("ana_kat_id","cocuk_kat_id","katid","*urunad","*res1","*res2","*res3","durum","*aciklama","*kumas","*urtYeri","*renk","fiyat","stok","*ozellik","*ekstraBilgi"));
			else:
				$this->DosyaIslemleri->JsonVerileriAyikla("dosya");
			endif;			
			if (!empty($this->Dosyaİslemleri->error)) :
				$this->view->goster("YonPanel/sayfalar/topluurunislem",
				array("bilgi" => $this->bilgi->SweetAlert(URL."/panel/urunler","BAŞARISIZ","Yüklenen XML Dosyası Açılamadı","warning")));
			else:
				$zipsonuc=$this->Upload->xmlzipresimyukleme("zipdosya");
				if (!empty($this->Upload->error)) :
					$this->view->goster("YonPanel/sayfalar/topluurunislem",
					array("bilgi" => $this->bilgi->SweetAlert(URL."/panel/urunler","BAŞARISIZ","Yüklenen Zip Dosyası Hatalı","warning")));
				else:
					$sonuc=$this->model->TopluEkleme("urunler",
					array("ana_kat_id","cocuk_kat_id","katid","urunad","res1","res2","res3","durum","aciklama","kumas","urtYeri","renk","fiyat","stok","ozellik","ekstraBilgi"),$this->DosyaIslemleri->verileritut);
					if ($sonuc):
						$this->Upload->ZipResimYuklemeSon("zipdosya",$zipsonuc);
						$this->view->goster("YonPanel/sayfalar/topluurunislem",
						array("bilgi" => $this->bilgi->SweetAlert(URL."/panel/urunler","BAŞARILI","İÇERİ AKTARIM BAŞARILI","success") ));				
					else:		
						$this->view->goster("YonPanel/sayfalar/topluurunislem",
						array("bilgi" => $this->bilgi->SweetAlert(URL."/panel/urunler","BAŞARISIZ","EKLEME SIRASINDA HATA OLUŞTU","warning") ));		
					endif;
				endif;
			endif;
		else:	
			$this->view->goster("YonPanel/sayfalar/topluurunislem",array("topluekleme" => true));
		endif;
	}	 // TOPLU ÜRÜN EKLEME
	
	function topluurunguncelleme($son=false) {
		$this->yetkikontrol->YetkisineBak("urunYonetim");
		if ($son):	
			$tercih=$this->form->radiobutonget("dosyatercih");
			if ($tercih=="xml"):
				$this->Dosyaİslemleri->TopluGuncellemeXml("dosya","/urunler/urun");
			else:	
				$this->Dosyaİslemleri->TopluGuncellemeJson("dosya");
			endif;
			if (!empty($this->Dosyaİslemleri->error)) :
				$this->view->goster("YonPanel/sayfalar/topluurunislem",
				array("bilgi" => $this->bilgi->SweetAlert(URL."/panel/urunler","BAŞARISIZ","Yüklenen  Dosya Açılamadı","warning")));
			else:
				if ($this->Dosyaİslemleri->resimvarmi):
					$zipsonuc=$this->Upload->xmlzipresimyukleme("zipdosya");
					if (!empty($this->Upload->error)) :
						$this->view->goster("YonPanel/sayfalar/topluurunislem",
						array("bilgi" => $this->bilgi->SweetAlert(URL."/panel/urunler","BAŞARISIZ","Yüklenen Zip Dosyası Hatalı","warning")));
						exit();
					endif;
				endif;	 
				$this->model->TopluislemBaslat();	
				for ($a=0; $a<count($this->Dosyaİslemleri->verilerdizi); $a++):
					$sonuc=$this->model->Guncelle("urunler",
					$this->Dosyaİslemleri->sutunlardizi[$a],
					$this->Dosyaİslemleri->verilerdizi[$a],
					"id=".$this->Dosyaİslemleri->verilerdizi[$a][0]);
					if (!$sonuc):
						$this->sorguhatasi=true;
					else:
						$this->sorguhatasi=false;
					endif;
				endfor;
				if ($this->sorguhatasi):	
					$this->model->İslemlerigerial();
				else:
					$this->model->TopluislemTamamla();
				endif;
				if (!$this->sorguhatasi): 
					if ($this->Dosyaİslemleri->resimvarmi):
						$this->Upload->ZipResimYuklemeSon("zipdosya",$zipsonuc);
					endif;
					$this->view->goster("YonPanel/sayfalar/topluurunislem",
					array("bilgi" => $this->bilgi->SweetAlert(URL."/panel/urunler","BAŞARILI","İÇERİ AKTARIM BAŞARI","success")));
				else:
					$this->view->goster("YonPanel/sayfalar/topluurunislem",
					array("bilgi" => $this->bilgi->SweetAlert(URL."/panel/urunler","BAŞARISIZ","EKLEME SIRASINDA HATA OLUŞTU","warning")));	
				endif;	
			 endif;
		else:
		$this->view->goster("YonPanel/sayfalar/topluurunislem",array("topluguncelle" => true));	
		endif;
	} // TOPLU ÜRÜN GÜNCELLEME

	function topluurunsilme($son=false) {	
		$this->yetkikontrol->YetkisineBak("urunYonetim");	
		if ($son):	
			$tercih=$this->form->radiobutonget("dosyatercih");
			if ($tercih=="xml"):
				$sonhal=$this->Dosyaİslemleri->TopluSilmeXml("dosya","/urunler/urun");
			else:	
				$sonhal=$this->Dosyaİslemleri->TopluSilmeJson("dosya");
			endif;
			if (!empty($this->Dosyaİslemleri->error)) :
				$this->view->goster("YonPanel/sayfalar/topluurunislem",
				array("bilgi" => $this->bilgi->SweetAlert(URL."/panel/urunler","BAŞARISIZ","Yüklenen  Dosya Açılamadı","warning")));
			else:		 							 
				$sonuc=$this->model->Sil("urunler","id IN($sonhal)");		
				if ($sonuc): 
					$this->view->goster("YonPanel/sayfalar/topluurunislem",
					array("bilgi" => $this->bilgi->SweetAlert(URL."/panel/urunler","BAŞARILI","ÜRÜNLER SİLİNDİ","success")));
				else:
					$this->view->goster("YonPanel/sayfalar/topluurunislem",
					array("bilgi" => $this->bilgi->SweetAlert(URL."/panel/urunler","BAŞARISIZ","EKLEME SIRASINDA HATA OLUŞTU","warning")));	
				endif;	
			 endif;	
		else:
			$this->view->goster("YonPanel/sayfalar/topluurunislem",array("toplusilme" => true));	
		endif;		
	} // TOPLU ÜRÜN SİLME
	
	//--------------------------------------------------------------------------------------
	
	function bulten ($mevcutsayfa=false) {
		
		$this->yetkikontrol->YetkisineBak("bultenYonetim");
		
		$this->Pagination->paginationOlustur($this->model->sayfalama("bulten"),$mevcutsayfa,$this->model->tekliveri("bultenGoruntuAdet","from ayarlar"));
		
		$this->view->goster("YonPanel/sayfalar/bulten",array(
		
		"data" => $this->model->Verial("bulten"," LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet), 
		"toplamsayfa" => $this->Pagination->toplamsayfa,
		"toplamveri" => $this->model->sayfalama("bulten")
		
		));
	
	
		
	}  // BÜLTEN GELİYOR
	
	function bultenExcelAl () {
		
		$this->model->ExcelAyarCek("bulten",false,"bulten");
		
		$this->dosyacikti->Excelaktar("Bültendeki Mailler",NULL,array("Mail Adresi"),$this->model->icerikler);
		
	}  // BÜLTEN EXCEL ÇIKTI
	
	function bultenTxtAl () {
		
		
		
		$this->dosyacikti->txtolustur($this->model->Verial("bulten",false));
		
	}  // BÜLTEN TXT ÇIKTI
	
	function mailSil($id) {
	
		$this->yetkikontrol->YetkisineBak("bultenYonetim");
		
		$sonuc=$this->model->Sil("bulten","id=".$id);
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/bulten",
			array(
			"bilgi" => $this->bilgi->basarili("SİLME BAŞARILI","/panel/bulten",2)
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/bulten",
			array(
			"bilgi" => $this->bilgi->hata("SİLME SIRASINDA HATA OLUŞTU.","/panel/bulten",2)
			 ));	
		
		endif;
	

	
		
	}  // BÜLTEN MAİL SİL
	
	function mailarama($kelime=false,$mevcutsayfa=false) {			
		$this->yetkikontrol->YetkisineBak("bultenYonetim");		
		if ($_POST || isset($kelime)) :		
			if ($_POST): 
				$aramaverisi=$this->form->get("arama")->bosmu();
				$sorgum=!empty($this->form->error);
			else:
				$aramaverisi=$kelime;
				$sorgum=empty($kelime);
			endif;
			if ($sorgum) :				
				$this->view->goster("YonPanel/sayfalar/bulten",
				array(		
				"bilgi" => $this->bilgi->hata("MAİL YAZILMALIDIR.","/panel/bulten",2)
				 ));				
			else:				
				$bilgicek=$this->model->arama("bulten",
				"mailadres LIKE '%".$aramaverisi."%'");		
		    	$this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("bultenGoruntuAdet","from ayarlar"));			
				if (count($bilgicek)>0):			
					$this->view->goster("YonPanel/sayfalar/bulten",array(				
					"data" => $this->model->arama("bulten",
					"mailadres LIKE '%".$aramaverisi."%' LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet), 
					"toplamsayfa" => $this->Pagination->toplamsayfa,
					"toplamveri" => count($bilgicek),
					"arama" => $aramaverisi
					));			
				else:				
					$this->view->goster("YonPanel/sayfalar/bulten",
					array(		
					"bilgi" => $this->bilgi->hata("HİÇBİR MAİL ADRESİ BULUNAMADI.","/panel/bulten",2)
					));			
				endif;				
			endif;
		else:
			$this->bilgi->direktYonlen("/panel/bulten");		
		endif;	
	} // BÜLTEN MAİL ARAMA
	
	function tarihegoregetir($tarih1=false,$tarih2=false,$mevcutsayfa=false) {			
		$this->yetkikontrol->YetkisineBak("bultenYonetim");		
		if ($_POST || (isset($tarih1) and isset($tarih2))) :
			if ($_POST): 
				$tar1=$this->form->get("tar1")->bosmu();
				$tar2=$this->form->get("tar2")->bosmu();
				$sorgum=!empty($this->form->error);
			else:
				$tar1=$tarih1;
				$tar2=$tarih2;
				$sorgum=empty($tarih1) && empty($tarih2);
			endif;		
			if ($sorgum) :				
				$this->view->goster("YonPanel/sayfalar/bulten",
				array(		
				"bilgi" => $this->bilgi->hata("TARİHLER BELİRTİLMELİDİR.","/panel/bulten",2)
				 ));
			else:
				$bilgicek=$this->model->Verial("bulten",
				"where DATE(tarih) BETWEEN '".$tar1."' and '".$tar2."' ");		
		    	$this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("bultenGoruntuAdet","from ayarlar"));
				if (count($bilgicek)>0):			
					$this->view->goster("YonPanel/sayfalar/bulten",array(				
					"data" => $this->model->Verial("bulten",
					"where DATE(tarih) BETWEEN '".$tar1."' and '".$tar2."' LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet), 
					"toplamsayfa" => $this->Pagination->toplamsayfa,
					"toplamveri" => count($bilgicek),
					"tariharama" => true,
					"tarih1" => $tar1,
					"tarih2" => $tar2
					));
				else:				
					$this->view->goster("YonPanel/sayfalar/bulten",
					array(		
					"bilgi" => $this->bilgi->hata("HİÇBİR MAİL ADRESİ BULUNAMADI.","/panel/bulten",2)
					 ));			
				endif;
			endif;
		else:
			$this->bilgi->direktYonlen("/panel/bulten");		
		endif;
	} // BÜLTEN TARİHE GÖRE ARAMA

	//--------------------------------------------------------------------------------------
	
	function sistemayar () {
		
		$this->yetkikontrol->YetkisineBak("sistemayarYonetim");
		
		$this->view->goster("YonPanel/sayfalar/sistemayar",array(
		
		"sistemayar" => $this->model->Verial("ayarlar",false),
		
		));
	
	
		
	}  // SİSTEM AYARLARI GELİYOR
	
	function ayarguncelle() {	
		
			$this->yetkikontrol->YetkisineBak("sistemayarYonetim");
		
			if ($_POST) :	
			
				$sloganust1=$this->form->get("sloganust1")->bosmu();
				$sloganalt1=$this->form->get("sloganalt1")->bosmu();
				$sloganust2=$this->form->get("sloganust2")->bosmu();
				$sloganalt2=$this->form->get("sloganalt2")->bosmu();
				$sloganust3=$this->form->get("sloganust3")->bosmu();
				$sloganalt3=$this->form->get("sloganalt3")->bosmu();
				$sayfatitle=$this->form->get("sayfatitle")->bosmu();
				$sayfaaciklama=$this->form->get("sayfaaciklama")->bosmu();
				$anahtarkelime=$this->form->get("anahtarkelime")->bosmu();
		
		
		$uyeSayfaGorAdet=$this->form->get("uyeSayfaGorAdet")->bosmu();
		$uyeSayfaAramaAdet=$this->form->get("uyeSayfaAramaAdet")->bosmu();
		$urunlerSayfaGorAdet=$this->form->get("urunlerSayfaGorAdet")->bosmu();
		$urunAramaAdet=$this->form->get("urunAramaAdet")->bosmu();
		$urunlerKategoriAdet=$this->form->get("urunlerKategoriAdet")->bosmu();
		$SiteUrunlerAdet=$this->form->get("SiteUrunlerAdet")->bosmu();
		$uyeYorumAdet=$this->form->get("uyeYorumAdet")->bosmu();
		$bultenGoruntuAdet=$this->form->get("bultenGoruntuAdet")->bosmu();
		
		
		
		
				$kayitid=$this->form->get("kayitid")->bosmu();
			
				
				if (!empty($this->form->error)) :
				
			$this->view->goster("YonPanel/sayfalar/sistemayar",
			array(		
			"bilgi" => $this->bilgi->hata("Tüm alanlar doldurulmalıdır.","/panel/sistemayar",2)
			 ));	
			 
			else:	
		
		$sonuc=$this->model->Guncelle("ayarlar",
		array("sloganUst1","sloganAlt1","sloganUst2","sloganAlt2","sloganUst3","sloganAlt3","title","sayfaAciklama","anahtarKelime","uyelerGoruntuAdet","uyelerAramaAdet","urunlerGoruntuAdet","urunlerAramaAdet","urunlerKategoriAdet","ArayuzurunlerGoruntuAdet","uyeYorumAdet","bultenGoruntuAdet"),
		array($sloganust1,$sloganalt1,$sloganust2,$sloganalt2,$sloganust3,$sloganalt3,$sayfatitle,$sayfaaciklama,$anahtarkelime,$uyeSayfaGorAdet,$uyeSayfaAramaAdet,$urunlerSayfaGorAdet,$urunAramaAdet,$urunlerKategoriAdet,$SiteUrunlerAdet,$uyeYorumAdet,$bultenGoruntuAdet),"id=".$kayitid);
				
	
		
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/sistemayar",
			array(
			"bilgi" => $this->bilgi->basarili("SİSTEM AYARLARI BAŞARIYLA GÜNCELLENDİ","/panel/sistemayar",2)
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/sistemayar",
			array(
			"bilgi" => $this->bilgi->hata("GÜNCELLEME SIRASINDA HATA OLUŞTU.","/panel/sistemayar",2)
			 ));	
		
		endif;
		
	
		
		endif;
		
				
			else:
			$this->bilgi->direktYonlen("/panel/sistemayar");
				
	
	endif;		
		
		
		
	
	
		
	}	 // SİSTEM AYARLARI GÜNCELLEME SON
	
	//--------------------------------------------------------------------------------------
	
	function sistembakim () {
		
		$this->yetkikontrol->YetkisineBak("sistembakimYonetim");
		
		$this->view->goster("YonPanel/sayfalar/bakim",array(
		
		"sistembakim" => true
		
		));
	
	
		
	}  // SİSTEM BAKIM
		
	function bakimyap () {
		
			$this->yetkikontrol->YetkisineBak("sistembakimYonetim");
			
			if ($_POST["sistembtn"]):
			
			$bakim=$this->model->bakim(DB_NAME);
		
	
				if ($bakim):
	
			$this->view->goster("YonPanel/sayfalar/bakim",
			array(
			"bilgi" => $this->bilgi->basarili("SİSTEM BAKIMI BAŞARIYLA YAPILDI","/panel/sistembakim",2)
			 ));
				
				else:
		
			$this->view->goster("YonPanel/sayfalar/bakim",
			array(
			"bilgi" => $this->bilgi->hata("BAKIM SIRASINDA HATA OLUŞTU.","/panel/sistembakim",2)
			 ));	
		
				endif;
		
		
				
			else:
			$this->bilgi->direktYonlen("/panel/sistembakim");
			
			endif;		
	
		
	} //SİSTEM BAKIM SONUÇ
	
	function veritabaniyedek () {
		
		$this->yetkikontrol->YetkisineBak("sistembakimYonetim");
		
		$this->view->goster("YonPanel/sayfalar/yedek",array(
		
		"veritabaniyedek" => true
		
		));
	
	
		
	}  // VERİTABANI YEDEK
	
	function dbyedekal($deger) {
		$this->dosyacikti->veritabaniyedekindir($deger);
		
	}
	
	function yedekal () {
		
			$this->yetkikontrol->YetkisineBak("sistembakimYonetim");
			
			if ($_POST["sistembtn"]):
			
			$yedek=$this->model->yedek(DB_NAME);
		
				$yedektercih=$this->form->radiobutonget("yedektercih");
				
			if ($yedek[0]):		
		
		if($yedektercih=="local"):
						
			
		
			$olustur=fopen(YEDEKYOL.date("d.m.Y").".sql","w+");
			fwrite($olustur,$yedek[1]);
			fclose($olustur);
			
	
			$this->view->goster("YonPanel/sayfalar/yedek",
			array(
			"bilgi" => $this->bilgi->SweetAlert(URL."/panel/veritabaniyedek","BAŞARILI","YEDEKLEME BAŞARIYLA YAPILDI","success")
				 ));
				
		
		
				
		
		
			else:
				$this->dbyedekal($yedek[1]);
		
			endif;
	
		
		
				else:
		
			$this->view->goster("YonPanel/sayfalar/yedek",
			array(
			"bilgi" => $this->bilgi->SweetAlert(URL."/panel/veritabaniyedek","BAŞARISIZ","YEDEKLEME SIRASINDA HATA OLUŞTU","warning")
				 ));	
		
		
		
		endif; 
		
				if($yedektercih=="local"):
						
			
		
			$olustur=fopen(YEDEKYOL.date("d.m.Y").".sql","w+");
			fwrite($olustur,$yedek[1]);
			fclose($olustur);
			
	
			$this->view->goster("YonPanel/sayfalar/yedek",
			array(
			"bilgi" => $this->bilgi->SweetAlert(URL."/panel/veritabaniyedek","BAŞARILI","YEDEKLEME BAŞARIYLA YAPILDI","success")
				 ));
				
		
		
				
		
		
			else:
				$this->dbyedekal($yedek[1]);
		
			endif;
	
		
		
				
			else:
			$this->bilgi->direktYonlen("/panel/veritabaniyedek");
			
			endif;		
	
		
	} //veritabanı yedek sonuç	
	
	//--------------------------------------------------------------------------------------

	/*
	function kayitkontrol() {
	
	if ($_POST) :		
	$ad=$this->form->get("ad")->bosmu();
	$soyad=$this->form->get("soyad")->bosmu();
	$mail=$this->form->get("mail")->bosmu();
	$sifre=$this->form->get("sifre")->bosmu();
	$sifretekrar=$this->form->get("sifretekrar")->bosmu();
	$telefon=$this->form->get("telefon")->bosmu();	
	$this->form->GercektenMailmi($mail);	
	$sifre=$this->form->SifreTekrar($sifre,$sifretekrar);
	

	
	if (!empty($this->form->error)) :
	

	$this->view->goster("sayfalar/uyeol",
	array("hata" => $this->form->error));
	
	
	else:
	

	
	$sonuc=$this->model->Ekleİslemi("uye_panel",
	array("ad","soyad","mail","sifre","telefon"),
	array($ad,$soyad,$mail,$sifre,$telefon));
	
		if ($sonuc):
	
	
		$this->view->goster("sayfalar/uyeol",
		array("bilgi" =>$this->bilgi->uyari("success","KAYIT BAŞARILI")));
		
		
		
		else:
		
		$this->view->goster("sayfalar/uyeol",
		array("bilgi" => 
		$this->bilgi->uyari("danger","Kayıt esnasında hata oluştu")));
		
		
		
		
		endif;
	
	endif;
		
		else:	
	
	$this->bilgi->direktYonlen("/");
	endif;
	
	
		
	} 	// KAYIT KONTROL	*/	
	
	function cikis() {
			
			Session::destroy();			
			$this->bilgi->direktYonlen("/panel/giris");
		
	} // ÇIKIŞ	
	
	function sifredegistir() {	
	
	
	$this->view->goster("YonPanel/sayfalar/sifreislemleri",array(
	"sifredegistir" => Session::get("Adminid")));	
	
		
	} // ŞİFRE DEĞİŞTİRME FORMU
	
	function sifreguncelleson() {		

	if ($_POST) :		
		
	 $mevcutsifre=$this->form->get("mevcutsifre")->bosmu();
	 $yen1=$this->form->get("yen1")->bosmu();
	 $yen2=$this->form->get("yen2")->bosmu();
	 $yonid=$this->form->get("yonid")->bosmu();
	 $sifre=$this->form->SifreTekrar($yen1,$yen2); // ŞİFRELİ YENİ HALİ ALIYORUM
	/*
	ÖNCE GELEN ŞFİREYİ SORGULAMAM LAZIM DOĞRUMU DİYE, EĞER MEVCUT ŞİFRE DOĞRU İSE	
	DEVAM EDECEK HATALI İSE İŞLEM BİTECEK
	
	*/
	
	$mevcutsifre=$this->form->sifrele($mevcutsifre);
	
	if (!empty($this->form->error)) :
		
	$this->view->goster("YonPanel/sayfalar/sifreislemleri",
	array(
	"sifredegistir" => Session::get("Adminid"),
	"bilgi" => $this->bilgi->uyari("danger","Girilen bilgiler hatalıdır.")
	 ));
	
	else:	
	
	$sonuc2=$this->model->GirisKontrol("yonetim","ad='".Session::get("AdminAd")."' and sifre='$mevcutsifre'");
	
		if ($sonuc2): 
		
				$sonuc=$this->model->Guncelle("yonetim",
				array("sifre"),
				array($sifre),"id=".$yonid);
			
				if ($sonuc): 
				
			
				$this->view->goster("YonPanel/sayfalar/sifreislemleri",
				array(
				"bilgi" => $this->bilgi->basarili("ŞİFRE DEĞİŞTİRME BAŞARILI","/panel/siparisler")
			 	));
					
						
				else:
				
				$this->view->goster("YonPanel/sayfalar/sifreislemleri",
				array(
				"sifredegistir" => Session::get("Adminid"),
				"bilgi" => $this->bilgi->uyari("danger","Şifre değiştirme sırasında hata oluştu.")
				));	
				
				endif;
			
		else:
		
		
		
		
		
			$this->view->goster("YonPanel/sayfalar/sifreislemleri",
	array(
	"sifredegistir" => Session::get("Adminid"),
	"bilgi" => $this->bilgi->uyari("danger","Mevcut şifre hatalıdır.")
	 ));
		
			
		
		endif;
	
	endif;
	
	
	else:	
	
	$this->bilgi->direktYonlen("/");
	endif;
	
	
		
	} // YÖNETİCİ ŞİFRESİNİ GÜNCELLİYOR.
	
	//--------------------------------------------------------------------------------------
	
	function yonetici () {
		$this->yetkikontrol->YetkisineBak("yoneticiYonetim");
		$this->view->goster("YonPanel/sayfalar/yonetici",array(
		
		"data" => $this->model->Verial("yonetim",false),
		
		));
	
	
		
	}  // YÖNETİCİLER GELİYOR
	
	function yonSil($id) {
	$this->yetkikontrol->YetkisineBak("yoneticiYonetim");
		
	$sonuc=$this->model->Sil("yonetim","id=".$id);
	
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/yonetici",
			array(
			"bilgi" => $this->bilgi->basarili("SİLME BAŞARILI","/panel/yonetici",2)
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/yonetici",
			array(
			"bilgi" => $this->bilgi->hata("SİLME SIRASINDA HATA OLUŞTU.","/panel/yonetici",2)
			 ));	
		
		endif;
	

	
		
	}  // YÖNETİCİ SİL
	
	function yonekle($islem) {	
		$this->yetkikontrol->YetkisineBak("yoneticiYonetim");
	if ($islem=="ilk") :
		
		$this->view->goster("YonPanel/sayfalar/yonetici",array(	
		"yoneticiekle" => true		
		));	
		
	elseif($islem=="son") :
		
		if ($_POST) :		
		
	 $yonadi=$this->form->get("yonadi")->bosmu();
	 $sif1=$this->form->get("sif1")->bosmu();
	 $sif2=$this->form->get("sif2")->bosmu();
		
		
	 	$siparisYonetim=$this->form->Checkboxget("siparisYonetim");
		$kategoriYonetim=$this->form->Checkboxget("kategoriYonetim");
		$uyeYonetim=$this->form->Checkboxget("uyeYonetim");
		$urunYonetim=$this->form->Checkboxget("urunYonetim");
		$muhasebeYonetim=$this->form->Checkboxget("muhasebeYonetim");
		$yoneticiYonetim=$this->form->Checkboxget("yoneticiYonetim");
		$bultenYonetim=$this->form->Checkboxget("bultenYonetim");
		$sistemayarYonetim=$this->form->Checkboxget("sistemayarYonetim");
		$sistembakimYonetim=$this->form->Checkboxget("sistembakimYonetim");
	 	$yetki=$this->form->Selectboxget("yetki");
	 $sifre=$this->form->SifreTekrar($sif1,$sif2); // ŞİFRELİ YENİ HALİ ALIYORUM
	/*
	ÖNCE GELEN ŞİFREYİ SORGULAMAM LAZIM DOĞRUMU DİYE, EĞER MEVCUT ŞİFRE DOĞRU İSE	
	DEVAM EDECEK HATALI İSE İŞLEM BİTECEK
	
	*/
	
	if (!empty($this->form->error)) :
		
	$this->view->goster("YonPanel/sayfalar/yonetici",
	array(
	"bilgi" => $this->bilgi->hata("Girilen bilgiler hatalıdır.","/panel/yonetici")
	 ));
	
	else:	
	

		
				$sonuc=$this->model->Ekleme("yonetim",
				array("ad","sifre","yetki","siparisYonetim","kategoriYonetim","uyeYonetim","urunYonetim","muhasebeYonetim",
					  "yoneticiYonetim","bultenYonetim","sistemayarYonetim","sistembakimYonetim"),
				array($yonadi,$sifre,$yetki,$siparisYonetim,$kategoriYonetim,$uyeYonetim,$urunYonetim,$muhasebeYonetim,
					  $yoneticiYonetim,$bultenYonetim,$sistemayarYonetim,$sistembakimYonetim));
			
				if ($sonuc): 
				
			
				$this->view->goster("YonPanel/sayfalar/yonetici",
				array(
				"bilgi" => $this->bilgi->basarili("Yeni yönetici eklendi.","/panel/yonetici")
			 	));
					
						
				else:
				
				$this->view->goster("YonPanel/sayfalar/yonetici",
				array(
				"sifredegistir" => Session::get("Adminid"),
				"bilgi" => $this->bilgi->hata("Ekleme sırasında hata oluştu.","/panel/yonetici")
				));	
				
				endif;
	
	endif;
	
	
	else:	
	
	$this->bilgi->direktYonlen("/");
	endif;
		
	endif;
		
	}	 // YÖNETİCİ EKLEME
	
	function yonguncelle($islem,$yonid=false) {	
		$this->yetkikontrol->YetkisineBak("yoneticiYonetim");
	if ($islem=="ilk") :
		
		$this->view->goster("YonPanel/sayfalar/yonetici",array(	
	        "YoneticiGuncelle" => $this->model->Verial("yonetim","where id=".$yonid)	
	        ));	
		
	elseif($islem=="son") :
		
		if ($_POST) :		
		
	 $yonadi=$this->form->get("yonadi")->bosmu();
	 
	 $yoneticiId=$this->form->get("yonid")->bosmu();
		
		$yetki=$this->form->Selectboxget("yetki");
	 	$siparisYonetim=$this->form->Checkboxget("siparisYonetim");
		$kategoriYonetim=$this->form->Checkboxget("kategoriYonetim");
		$uyeYonetim=$this->form->Checkboxget("uyeYonetim");
		$urunYonetim=$this->form->Checkboxget("urunYonetim");
		$muhasebeYonetim=$this->form->Checkboxget("muhasebeYonetim");
		$yoneticiYonetim=$this->form->Checkboxget("yoneticiYonetim");
		$bultenYonetim=$this->form->Checkboxget("bultenYonetim");
		$sistemayarYonetim=$this->form->Checkboxget("sistemayarYonetim");
		$sistembakimYonetim=$this->form->Checkboxget("sistembakimYonetim");
	 			
	if (!empty($this->form->error)) :
					
				$this->view->goster("YonPanel/sayfalar/yonetici",
				array(		
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/yonetici","BAŞARISIZ","Tüm alanlar doldurulmalıdır.","warning")
				 ));		
					
				else:
		
				$sonuc=$this->model->Guncelle("yonetim",
				array("ad","yetki","siparisYonetim","kategoriYonetim","uyeYonetim","urunYonetim","muhasebeYonetim",
					  "yoneticiYonetim","bultenYonetim","sistemayarYonetim","sistembakimYonetim"),
				array($yonadi,$yetki,$siparisYonetim,$kategoriYonetim,$uyeYonetim,$urunYonetim,$muhasebeYonetim,
					  $yoneticiYonetim,$bultenYonetim,$sistemayarYonetim,$sistembakimYonetim),"id=".$yoneticiId);
				
				if ($sonuc): 
		
				$this->view->goster("YonPanel/sayfalar/yonetici",
				array(
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/yonetici","BAŞARILI","YÖNETİCİ GÜNCELLEME BAŞARILI","success")
				 ));
					
			else:
			
				$this->view->goster("YonPanel/sayfalar/yonetici",
				array(
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/yonetici","BAŞARISIZ","GÜNCELLEME SIRASINDA HATA OLUŞTU.","warning")
				 ));	
			
			endif;
	
	endif;
	
	
	else:	
	
	$this->bilgi->direktYonlen("/panel/yonetici");
	endif;
		
	endif;
		
	}	 // YÖNETİCİ GÜNCELLE
	
	//--------------------------------------------------------------------------------------
	
	function bankabilgileri () {
		
		$this->yetkikontrol->YetkisineBak("muhasebeYonetim");
		
		$this->view->goster("YonPanel/sayfalar/bankabilgileri",array(
		
		"data" => $this->model->Verial("bankabilgileri",false)
		
		
		));
	
	
		
	} // BANKA BİLGİLERİ GELİYOR
	
	function bankaGuncelle($islem,$id=false) {
		$this->yetkikontrol->YetkisineBak("muhasebeYonetim");
	if ($islem=="ilk") :
		
	        $this->view->goster("YonPanel/sayfalar/bankabilgileri",array(	
	        "BankaGuncelle" => $this->model->Verial("bankabilgileri","where id=".$id)	
	        ));	
		
		
				
	elseif($islem=="son") :
		
		            if ($_POST) :	
				
					$banka_ad=$this->form->get("banka_ad")->bosmu();
					$hesap_ad=$this->form->get("hesap_ad")->bosmu();
					$hesap_no=$this->form->get("hesap_no")->bosmu();
					$iban_no=$this->form->get("iban_no")->bosmu();
					$bankaid=$this->form->get("bankaid")->bosmu();
					
					
					if (!empty($this->form->error)) :
					
				$this->view->goster("YonPanel/sayfalar/bankabilgileri",
				array(		
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/bankabilgileri","BAŞARISIZ","Tüm alanlar doldurulmalıdır.","warning")
				 ));		
					
				else:	
					
			
		
		
			$sonuc=$this->model->Guncelle("bankabilgileri",
			array("banka_ad","hesap_ad","hesap_no","iban_no"),
			array($banka_ad,$hesap_ad,$hesap_no,$iban_no),"id=".$bankaid);
					
		 
			
		
			if ($sonuc): 
		
				$this->view->goster("YonPanel/sayfalar/bankabilgileri",
				array(
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/bankabilgileri","BAŞARILI","HESAP GÜNCELLEME BAŞARILI","success")
				 ));
					
			else:
			
				$this->view->goster("YonPanel/sayfalar/bankabilgileri",
				array(
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/bankabilgileri","BAŞARISIZ","GÜNCELLEME SIRASINDA HATA OLUŞTU.","warning")
				 ));	
			
			endif;
			
		
			
			endif;
			
					
				else:
				$this->bilgi->direktYonlen("/panel/bankabilgileri");
					
		
					endif;		
			
		
		
		
		
		
		endif;
	
		
	} // BANKA BİLGİLERİ GÜNCELLE	
		
	function bankaSil($id) {
	
		$this->yetkikontrol->YetkisineBak("muhasebeYonetim");
	$sonuc=$this->model->Sil("bankabilgileri","id=".$id);
	
	
		if ($sonuc): 
	
			$this->view->goster("YonPanel/sayfalar/bankabilgileri",
			array(
			"bilgi" => $this->bilgi->SweetAlert(URL."/panel/bankabilgileri","BAŞARILI","SİLME BAŞARILI","success")
			 ));
				
		else:
		
			$this->view->goster("YonPanel/sayfalar/uyeler",
			array(
			"bilgi" => $this->bilgi->SweetAlert(URL."/panel/bankabilgileri","BAŞARISIZ","SİLME SIRASINDA HATA OLUŞTU","warning")
			 ));	
		
		endif;
	

	
		
	}  // BANKA BİLGİLERİ SİL			
	
	function bankaEkle($islem) {
		$this->yetkikontrol->YetkisineBak("muhasebeYonetim");
	if($islem=="ilk") :
		
	$this->view->goster("YonPanel/sayfalar/bankabilgileri",array(	
	"BankaEkle" => true));		
		
	
		
	elseif($islem=="son") :		

	if ($_POST) :		
		
	                $banka_ad=$this->form->get("banka_ad")->bosmu();
					$hesap_ad=$this->form->get("hesap_ad")->bosmu();
					$hesap_no=$this->form->get("hesap_no")->bosmu();
					$iban_no=$this->form->get("iban_no")->bosmu();
					
	
	
	                if (!empty($this->form->error)) :
		
	                $this->view->goster("YonPanel/sayfalar/bankabilgileri",
	                array(
	                       "bilgi" => $this->bilgi->SweetAlert(URL."/panel/bankabilgileri","BAŞARISIZ","Girilen bilgiler hatalıdır.","warning")
	 ));
	
	else:	
	

		
				$sonuc=$this->model->Ekleme("bankabilgileri",
				array("banka_ad","hesap_ad","hesap_no","iban_no"),
				array($banka_ad,$hesap_ad,$hesap_no,$iban_no));
			
				if ($sonuc): 
				
			
				$this->view->goster("YonPanel/sayfalar/bankabilgileri",
				array(
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/bankabilgileri","BAŞARILI","Yeni banka hesabı eklendi.","success")
			 	));
					
						
				else:
				
				$this->view->goster("YonPanel/sayfalar/bankabilgileri",
				array(
				
				"bilgi" => $this->bilgi->SweetAlert(URL."/panel/bankabilgileri","BAŞARISIZ","Ekleme sırasında hata oluştu.","warning")
				));
				
				endif;
	
	endif;
	
	
	else:	
	
	$this->bilgi->direktYonlen("/panel/bankabilgileri");
	endif;
	
	
		
	
		
		
		
		
	endif;	
				
	
		
	
		
	} // BANKA BİLGİSİ EKLE
	
	//--------------------------------------------------------------------------------------
	

	
	
}


?>