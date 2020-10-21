<?php

class uye extends Controller  {
	
	
	function __construct() {
		parent::KutuphaneYukle(array("view","form","bilgi","Pagination","Captcha"));
		
	$this->Modelyukle('uye');
	Session::init();
	
	
	}	
	

	
	function giris() {
		
	
	$this->view->goster("sayfalar/giris");
		
	} // GİRİŞ SAYFASI
		
	function hesapOlustur() {
		
	
	$this->view->goster("sayfalar/uyeol",
	array("kaynak"=> $this->Captcha->kodolustur("auto")));
		
	} // HESAP OLUŞTUR SAYFASI
	
	function kayitkontrol() {
	
	if ($_POST) :		
	$ad=$this->form->get("ad")->bosmu();
	$soyad=$this->form->get("soyad")->bosmu();
	$mail=$this->form->get("mail")->bosmu();
	$sifre=$this->form->get("sifre")->bosmu();
	$sifretekrar=$this->form->get("sifretekrar")->bosmu();
	$telefon=$this->form->get("telefon")->bosmu();
	$guvenlik=$this->form->get("guvenlik")->bosmu();	
	$this->form->GercektenMailmi($mail);	
	$sifre=$this->form->SifreTekrar($sifre,$sifretekrar);
	

	
	if (!empty($this->form->error)) :
	

	$this->view->goster("sayfalar/uyeol",
	array("hata" => $this->form->error));
		
	elseif ($guvenlik!=Session::get("kod")) :
	

	$this->view->goster("sayfalar/uyeol",
	array(
	"bilgi" =>$this->bilgi->hata("Güvenlik kod hatalıdır.","/uye/hesapOlustur",3)));
	
	
	else:
	

	
	$sonuc=$this->model->Ekleİslemi("uye_panel",
	array("ad","soyad","mail","sifre","telefon"),
	array($ad,$soyad,$mail,$sifre,$telefon));
	
		if ($sonuc):
	
	
		$this->view->goster("sayfalar/uyeol",
		array("bilgi" =>$this->bilgi->basarili("KAYIT BAŞARILI","/uye/giris",2)));
		
		
		
		else:
		
		$this->view->goster("sayfalar/uyeol",
		array("bilgi" => 
		$this->bilgi->uyari("danger","Kayıt esnasında hata oluştu")));
		
		
		
		
		endif;
	
	endif;
		
		else:	
	
	$this->bilgi->direktYonlen("/");
	endif;
	
	
		
	} 	// KAYIT KONTROL		
	
	function cikis() {
			
			Session::destroy();			
			$this->bilgi->direktYonlen("/magaza");
		
	} // ÇIKIŞ	
	
	function giriskontrol() {
	if ($_POST) :		
		
		if ($_POST["giristipi"]=="uye"):
		
	
	$ad=$this->form->get("ad")->bosmu();
	$sifre=$this->form->get("sifre")->bosmu();
	
	
	if (!empty($this->form->error)) :
	$this->view->goster("sayfalar/giris",
	array("bilgi" => $this->bilgi->uyari("danger","Ad ve şifre boş olamaz")));
	
	
	else:	
	$sifre=$this->form->sifrele($sifre);
	$sonuc=$this->model->GirisKontrol("uye_panel","ad='$ad' and sifre='$sifre' and durum=1");
	
		if ($sonuc): 
		
	
			$this->bilgi->direktYonlen("/uye/panel");
			
			Session::init();
			Session::set("kulad",$sonuc[0]["ad"]);	
			Session::set("uye",$sonuc[0]["id"]); // üyenin id'si taşıcam	
									// 10 skfjsmfj5754154hfdsf
								//$this->form->sifrele($sifre);	
			
		else:
		
			$this->view->goster("sayfalar/giris",
			array("bilgi" => 
			$this->bilgi->uyari("danger","Kullanıcı adı veya şifresi hatalıdır")));		
		
		endif;
	
	endif; //hatanın endifi
	
		
			elseif ($_POST["giristipi"]=="yon"):
		
		
	
	$AdminAd=$this->form->get("AdminAd")->bosmu();
	$Adminsifre=$this->form->get("Adminsifre")->bosmu();
	
	
	if (!empty($this->form->error)) :
	$this->view->goster("YonPanel/sayfalar/index",
	array("bilgi" => $this->bilgi->uyari("danger","Ad ve şifre boş olamaz")));
	
	
	else:	
	$Adminsifre=$this->form->sifrele($Adminsifre);
	$sonuc=$this->model->GirisKontrol("yonetim","ad='$AdminAd' and sifre='$Adminsifre'");
	
		if ($sonuc): 
		
	
			$this->bilgi->direktYonlen("/panel/siparisler");
			
			Session::init();
			Session::set("AdminAd",$sonuc[0]["ad"]);	
			Session::set("Adminid",$sonuc[0]["id"]); // üyenin id'si taşıcam	
									// 10 skfjsmfj5754154hfdsf
								//$this->form->sifrele($sifre);	
			
		else:
		
			$this->view->goster("YonPanel/sayfalar/index",
			array("bilgi" => 
			$this->bilgi->uyari("danger","Kullanıcı adı veya şifresi hatalıdır")));		
		
		endif;
	
	endif; //hatanın endifi
		
		
			endif;
	
		else:	
	
	$this->bilgi->direktYonlen("/");
	endif;
	
	
	
		
	} // GİRİŞ KONTROL	
		
	//*********** ÜYENİN PANELİNİ SAĞLAYAN FONKSİYONLAR
	
	function Yorumsil () {
		
		if ($_POST) :	
		
		echo $this->model->Silmeİslemi("yorumlar", "id=".$_POST["yorumid"]);
		
		else:	
	
		$this->bilgi->direktYonlen("/");
		endif;
		
	} // YORUM SİL
	
	function adresSil () {
		
		if ($_POST) :	
		
		echo $this->model->Silmeİslemi("adresler", "id=".$_POST["adresid"]);
		
		endif;
		
	} // ADRES SİL
	
	function YorumGuncelle()  {
		
		if ($_POST) :
		/*$_POST["yorum"];
		$_POST["yorumid"];	*/	
		
		// function Guncelleİslemi($tabloisim,$sutunlar,$veriler,$kosul) {
		
		echo $this->model->Guncelleİslemi("yorumlar",
		array("icerik","durum"),
		array($_POST["yorum"],"0"),"id=".$_POST["yorumid"]);
		
		
		else:	
	
		$this->bilgi->direktYonlen("/");
		endif;
		
		
	} // YORUM GÜNCELLE
	
	function AdresGuncelle()  {
		
		if ($_POST) :
		
		echo $this->model->Guncelleİslemi("adresler",
		array("adres"),
		array($_POST["adres"]),"id=".$_POST["adresid"]);
		else:	
	
		$this->bilgi->direktYonlen("/");
		endif;
		
		
	} // ADRES GÜNCELLE	
	
	function Panel() {	
	
	$this->view->goster("sayfalar/panel",array(
	"siparisler" => $this->model->VerileriAl("siparisler","where uyeid=".Session::get("uye"))));		
		
	} // ANA PANEL
	
	function yorumlarim($mevcutsayfa=false) {	
	$veriler= $this->model->VerileriAl("yorumlar","where uyeid=".Session::get("uye"));
		
		
	$this->Pagination->paginationOlustur(count($veriler),$mevcutsayfa,
	$this->model->tekliveri("uyeYorumAdet","from ayarlar"));
		
		
		
	$this->view->goster("sayfalar/panel",array(
	"yorumlar" => $this->model->VerileriAl("yorumlar","where uyeid=".Session::get("uye"). " LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet),
	"toplamsayfa" => $this->Pagination->toplamsayfa,
	"toplamveri" => count($veriler)
	
	
	));		
	
		
	} // YORUMLAR
	
	function adreslerim() {	
	
	
	$this->view->goster("sayfalar/panel",array(
	"adres" => $this->model->VerileriAl("adresler","where uyeid=".Session::get("uye"))
	
	
	));		
	
		
	} // ADRESLER
	
	function adresekle() {	
	
	
	$this->view->goster("sayfalar/panel",array(
	"adresekle" => "ekleme"
	
	
	));		
	
	} // ADRES EKLE
	
	function adresEkleSon() {		
		if ($_POST) :	
		
	$yeniadres=$this->form->get("yeniadres")->bosmu();
	$uyeid=$this->form->get("uyeid")->bosmu();
	
	
	
	if (!empty($this->form->error)) :
	$this->view->goster("sayfalar/panel",
	array(
	"adresekle" => "ekleme",
	"bilgi" => $this->bilgi->hata("Adres boş olmamalıdır.","/uye/adresekle")
	 ));
	 	
	else:	
		
	
		$sonuc=$this->model->Ekleİslemi("adresler",
		array("uyeid","adres"),
		array($uyeid,$yeniadres));
	
		if ($sonuc): 
	
			$this->view->goster("sayfalar/panel",
			array(
			"adresekle" => "tamam",
			"bilgi" => $this->bilgi->basarili("EKLEME BAŞARILI","/uye/adreslerim")
			 ));
				
		else:
		
			$this->view->goster("sayfalar/panel",
			array(
			"adresekle" => "ekleme",
			"bilgi" => $this->bilgi->hata("Kayıt esnasında hata oluştu.","/uye/adresekle")
			 ));	
		
		endif;
	
	endif;
	
	
		else:	
	
	$this->bilgi->direktYonlen("/");
	endif;
	
		
		
	}//UYE ADRES EKLİYOR
	
	function hesapayarlarim() {	
	
	
	$this->view->goster("sayfalar/panel",array(
	"ayarlar" => $this->model->VerileriAl("uye_panel","where id=".Session::get("uye"))));		
	
		
	} // HESAP AYARLARI
	
	function sifredegistir() {	
	
	
	$this->view->goster("sayfalar/panel",array(
	"sifredegistir" => Session::get("uye")));	
	
		
	} // ŞİFRE DEĞİŞTİR
	
	function siparislerim() {	
	
	$this->view->goster("sayfalar/panel",array(
	"siparisler" => $this->model->VerileriAl("siparisler","where uyeid=".Session::get("uye"))));		
	
		
	} // SİPARİŞLER
	
	function ayarGuncelle() {		
		if ($_POST) :	
		
	$ad=$this->form->get("ad")->bosmu();
	$soyad=$this->form->get("soyad")->bosmu();
	$mail=$this->form->get("mail")->bosmu();
	$telefon=$this->form->get("telefon")->bosmu();
	$uyeid=$this->form->get("uyeid")->bosmu();
	
	
	
	if (!empty($this->form->error)) :
	$this->view->goster("sayfalar/panel",
	array(
	"ayarlar" => $this->model->VerileriAl("uye_panel","where id=".Session::get("uye")),
	"bilgi" => $this->bilgi->uyari("danger","Girilen bilgiler hatalıdır.")
	 ));
	 	
	else:	
	
	
	
		$sonuc=$this->model->Guncelleİslemi("uye_panel",
		array("ad","soyad","mail","telefon"),
		array($ad,$soyad,$mail,$telefon),"id=".$uyeid);
	
		if ($sonuc): 
	
			$this->view->goster("sayfalar/panel",
			array(
			"ayarlar" => "ok",
			"bilgi" => $this->bilgi->basarili("GÜNCELLEME BAŞARILI","/uye/panel")
			 ));
				
		else:
		
			$this->view->goster("sayfalar/panel",
			array(
			"ayarlar" => $this->model->VerileriAl("uye_panel","where id=".Session::get("uye")),
			"bilgi" => $this->bilgi->uyari("danger","Güncelleme sırasında hata oluştu.")
			 ));	
		
		endif;
	
	endif;
	
	
		else:	
	
	$this->bilgi->direktYonlen("/");
	endif;
	
		
		
	} // ÜYE KENDİ AYARLARINI GÜNCELLİYOR.
	
	function sifreguncelle() {		

	if ($_POST) :		
		
	 $msifre=$this->form->get("msifre")->bosmu();
	 $yen1=$this->form->get("yen1")->bosmu();
	 $yen2=$this->form->get("yen2")->bosmu();
	 $uyeid=$this->form->get("uyeid")->bosmu();
	 $sifre=$this->form->SifreTekrar($yen1,$yen2); // ŞİFRELİ YENİ HALİ ALIYORUM
	/*
	ÖNCE GELEN ŞFİREYİ SORGULAMAM LAZIM DOĞRUMU DİYE, EĞER MEVCUT ŞİFRE DOĞRU İSE	
	DEVAM EDECEK HATALI İSE İŞLEM BİTECEK
	
	*/
	
	$msifre=$this->form->sifrele($msifre);
	
	if (!empty($this->form->error)) :
	$this->view->goster("sayfalar/panel",
	array(
	"sifredegistir" => Session::get("uye"),
	"bilgi" => $this->bilgi->uyari("danger","Girilen bilgiler hatalıdır.")
	 ));
	
	else:	
	
	
		
	$sonuc2=$this->model->GirisKontrol("uye_panel","ad='".Session::get("kulad")."' and sifre='$msifre'");
	
		if ($sonuc2): 
		
				$sonuc=$this->model->Guncelleİslemi("uye_panel",
				array("sifre"),
				array($sifre),"id=".$uyeid);
			
				if ($sonuc): 
				
			
				$this->view->goster("sayfalar/panel",
				array(
				"sifredegistir" => "ok",
				"bilgi" => $this->bilgi->basarili("ŞİFRE DEĞİŞTİRME BAŞARILI","/uye/panel")
			 	));
					
						
				else:
				
				$this->view->goster("sayfalar/panel",
				array(
				"sifredegistir" => Session::get("uye"),
				"bilgi" => $this->bilgi->uyari("danger","Şifre değiştirme sırasında hata oluştu.")
				));	
				
				endif;
			
		else:
		
		
		
		
		
			$this->view->goster("sayfalar/panel",
	array(
	"sifredegistir" => Session::get("uye"),
	"bilgi" => $this->bilgi->uyari("danger","Mevcut şifre hatalıdır.")
	 ));
		
			
		
		endif;
	
	endif;
	
	
	else:	
	
	$this->bilgi->direktYonlen("/");
	endif;
	
	
		
	} // ÜYE ŞİFRESİNİ GÜNCELLİYOR.
	
	
	//***********  ÜYENİN PANELİNİ SAĞLAYAN FONKSİYONLAR
		
	
	function siparisTamamlandi() {
		
		if ($_POST) :		
		
		
	$ad=$this->form->get("ad")->bosmu();
	$soyad=$this->form->get("soyad")->bosmu();
	$mail=$this->form->get("mail")->bosmu();
	$telefon=$this->form->get("telefon")->bosmu();
	$toplam=$this->form->get("toplam")->bosmu();
	
		
	$odeme=$this->form->get("odeme")->bosmu();	
	$adrestercih=$this->form->get("adrestercih")->bosmu();
	$odemeturu=($odeme==1) ? "Nakit" : "Kredi";
	$durum=$this->form->get("durum",true);
	$tarih=date("Y-m-d");
	
	
	if (!empty($this->form->error)) :
	$this->view->goster("sayfalar/siparisitamamla",
	array("bilgi" => $this->bilgi->uyari("danger","Bilgiler eksiksiz doldurulmalıdır")));
	
	
	else:
	
	$siparisNo=mt_rand(0,99999999);
	$uyeid=Session::get("uye");
	
	$this->model->TopluislemBaslat();
	
	
		if (isset($_COOKIE["urun"])) :
		
	
		foreach ($_COOKIE["urun"] as $id => $adet) :
		
$GelenUrun=$this->model->VerileriAl("urunler","where id=".$id);

	$birimfiyat=$GelenUrun[0]["fiyat"]*$adet;
	
	$this->model->SiparisTamamlama(
	array(
	$siparisNo,
	$adrestercih,
	$uyeid,
	$GelenUrun[0]["urunad"],
	$adet,
	$GelenUrun[0]["fiyat"],
	$birimfiyat,
	$odemeturu,
	$durum,
	$tarih
	
	));
	
		echo $this->model->Guncelleİslemi("urunler",
		array("stok"),
		array($GelenUrun[0]["stok"]-$adet),"id=".$GelenUrun[0]["id"]);
		
	endforeach;
	
	
	else:
	 // cookie  tanımlı değilse diye bir knotrol
		$this->bilgi->direktYonlen("/");
	
	endif;
	
	
	$this->model->TopluislemTamamla();
	
		
	Cookie::SepetiBosalt(); // sepeti boşalttık
		
		
	$TeslimatBilgileri=$this->model->Ekleİslemi("teslimatbilgileri",
	array("siparis_no","ad","soyad","mail","telefon"),
	array(
	$siparisNo,
	$ad,
	$soyad,
	$mail,
	$telefon	
	));
	
	
	
		if ($TeslimatBilgileri): 
		
		$this->view->goster("sayfalar/siparistamamlandi",
		array(
		"siparisno" => $siparisNo,
		"toplamtutar" => $toplam,
		"bankalar" => $this->model->VerileriAl("bankabilgileri",false)
		));	
		
		
			
		else:
		
		$this->view->goster("sayfalar/siparisitamamla",
		array("bilgi" => $this->bilgi->uyari("danger","Sipariş oluşturulurken hata oluştu")));
		
		endif;
	
	endif;
	
	
	
	else:	
	
	$this->bilgi->direktYonlen("/");
	endif;
	

	} // SİPARİŞ TAMAMLANDI
	
	
	

	
}




?>