<?php

class Database extends PDO {


	protected $dizi=array();
	protected $dizi2=array();
	
	
	function __construct() {
			
parent::__construct('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',DB_USER,DB_PASS);
	
		$this->bilgi= new Bilgi();
		
		
	}
	
	
	function Ekle($tabloisim,$sutunadlari,$veriler) {		
		
		$sutunsayi=count($sutunadlari);	
		for ($i=0; $i<$sutunsayi; $i++) :		
		$this->dizi[]='?';
		endfor;
		
		$sonVal=join (",",$this->dizi);					
		$sonhal=join (",",$sutunadlari);		
		
		$sorgu=$this->prepare('insert into '.$tabloisim.' ('.$sonhal.') 	
		VALUES('.$sonVal.')'); 
		
		
		if ($sorgu->execute($veriler)) : 
		return true;	
		else:		
		return false;	
		
		endif;
		
		
	} // ekleme 
	
	function topluEkle($tabloisim,$sutunadlari,$sonVal) {					
		$sonhal=join (",",$sutunadlari);
		$sorgu=$this->prepare('insert into '.$tabloisim.' ('.$sonhal.') VALUES '.$sonVal);		
		if ($sorgu->execute()) : 
			return true;	
		else:		
			return false;		
		endif;		
	} // toplu ekleme 
	
	function listele($tabloisim,$kosul=false) {
		
		
		if ($kosul==false) :
		
		$sorgum="select * from ".$tabloisim;
		
		else:
		
		$sorgum="select * from ".$tabloisim." ".$kosul;
												
		endif;
		
		$son=$this->prepare($sorgum);
		$son->execute();
		
		return $son->fetchAll();
		
		
	} // listeleme
	
	function spesifiklistele($sorgu,$kosul=false) {
		
		
		if ($kosul==false) :
		
		$sorgum="select ".$sorgu;
		
		else:
		
		$sorgum="select * from ".$tabloisim." ".$kosul;
												
		endif;
		
		$son=$this->prepare($sorgum);
		$son->execute();
		
		return $son->fetchAll();
		
		
	} // spesifik listeleme
	
	function teklistele($sutun,$kosul) {

	
		$son=$this->prepare("select " .$sutun. " ".$kosul);
		$son->execute();
		$veri=$son->fetch(PDO::FETCH_ASSOC);
		return $veri[$sutun];
		
		
	} //tekli listeleme
		
	function sil($tabloisim,$kosul) {
		
		$sorgum=$this->prepare("delete from ".$tabloisim. ' where '.$kosul);
		
		if ($sorgum->execute()) :
		
		return true;	
		else:		
		return false;		
		
		endif;
		
	} // silme	
	
	function guncelle($tabloisim,$sutunlar,$veriler,$kosul) {
		
		
		foreach ($sutunlar as $deger) :
		
		$this->dizi2[]=$deger."=?";
		
		endforeach;
		
		$sonSutunlar=join (",",$this->dizi2);			
		
		
		
	$sorgum=$this->prepare("update ".$tabloisim." set ".$sonSutunlar." where ".$kosul);	
		

	if ($sorgum->execute($veriler)) :
		
		return true;	
		else:		
		return false;		
		
		endif;


		
	} // güncelleme	
	
	function arama($tabloisim,$kosul) {
		
		
		$sorgum="select * from ".$tabloisim." where ".$kosul;							
		
		
		$son=$this->prepare($sorgum);
		$son->execute();
		
		return $son->fetchAll();
				
		
		
	} // arama		
	
	function giriskontrol($tabloisim,$kosul) {
		
		
		$sorgum="select * from ".$tabloisim." where ".$kosul;
		$son=$this->prepare($sorgum);
		$son->execute();
		
		if ($son->rowCount()>0) :
		
		return $son->fetchAll();
		
		else:
		
		return false;
		
		
		endif;
		

		
	} // giriş kontrol
	
	function siparisTamamla($veriler=array()) {
		

		
		$sorgu=$this->prepare('insert into siparisler (siparis_no,adresid,uyeid,urunad,urunadet,urunfiyat,toplamfiyat,odemeturu,durum,tarih) 	
		VALUES(?,?,?,?,?,?,?,?,?,?)'); 
		
		
		$sorgu->execute($veriler);
		
		
		
	}
		
	function sistembakim ($deger) {
		$sorgu=$this->prepare('SHOW TABLES');
		
		
		if ($sorgu->execute()) : 
			$tablolar=$sorgu->fetchAll();
		
				    foreach ($tablolar as $tabloadi):
		
					$this->query("REPAIR TABLE ".$tabloadi["Tables_in_".$deger.""]);
					$this->query("OPTIMIZE TABLE ".$tabloadi["Tables_in_".$deger.""]); 
	
					
				

					endforeach; 
					$tarih=date("d.m.Y-H:i");
					$zamanguncelle=$this->prepare("update ayarlar set bakimzaman='$tarih'");
					$zamanguncelle->execute();			
					return true;
			
		else:		
		return false;	
		
		endif;
		
	
		
	
		
		 
			
		
		
	}//SİSTEM BAKIM
			
	function veritabaniyedek ($deger) {
		$tables=array();
		
		$sorgu=$this->prepare('SHOW TABLES');
		if($sorgu->execute()): $durum=true; else: $durum=false; endif;
		
		
		while($row=$sorgu->fetch(PDO::FETCH_ASSOC)):
		$tables[]=$row["Tables_in_".$deger.""];
		
		endwhile;
		
		$return="SET NAMES utf8;";
		
		foreach ($tables as $tablo):
		$result=$this->prepare('select * from $tablo');
		$result->execute();
		$numColumns=$result->columnCount();
		
		$return.="DROP TABLE IF EXIST $tablo;";
		
		$result2=$this->prepare("SHOW CREATE TABLE $tablo");
		$result2->execute();
		$row2=$result2->fetch(PDO::FETCH_ASSOC);
		$return.="\n\n".$row2["Create Table"].";\n\n";
		
		
		for ($i=0; $i<$numColumns; $i++):
		
			while ($row = $result->fetch(PDO::FETCH_NUM)):
				$return.="INSERT INTO $tablo VALUES(";
		
		
					for($a=0; $a<$numColumns; $a++):
		
		if(isset($row[$a])): $return.='"'.$row[$a].'"'; else: $return.='""'; endif;
		if($a< ($numColumns-1)): $return.=',';  endif;
		
		
					endfor;
		
		
		
		
		
		
		
		$return.= ");\n";
		
		
			endwhile;
				
		
		
		
		
		
		endfor;
		
				$return.= "\n\n\n";
		endforeach;
		
			if($durum): 
					$tarih=date("d.m.Y-H:i");
					$zamanguncelle=$this->prepare("update ayarlar set yedekzaman='$tarih'");
					$zamanguncelle->execute();
		
		
		endif;
				
		
		return [$durum,$return] ;
	
		
	
		
	
		
		 
			
		
		
	} //veritabanı yedek
	
	function sayfalamaAdet($tabload){
		$cek=$this->prepare("select COUNT(*) AS toplam from ". $tabload);
		$cek->execute();
		$son=$cek->fetch(PDO::FETCH_ASSOC);
		
		return $son["toplam"];
		
		
	} //SAYFALAMA TOPLAM ADET
	
    function joinislemi($istenilenveriler,$tablolar,$kosul) {
	/*
	 $sorgum="select
		ana_kategori.ad As anakatad,
		cocuk_kategori.ad As cocukkatad,
		alt_kategori.ad As altad,
		alt_kategori.id As altid
		from
		ana_kategori JOIN cocuk_kategori JOIN alt_kategori
		ON
		(ana_kategori.id=cocuk_kategori.ana_kat_id) AND(cocuk_kategori.id=alt_kategori.cocuk_kat_id)
		AND 
		alt_kategori.ad LIKE '%Çamaşır%'";
	
	*/
		
		$sonveriler=join (",",$istenilenveriler);
		$tablolar=join (" JOIN ",$tablolar);
		
	
	
	    $sorgum="select
		".$sonveriler."
		from
		".$tablolar."
		ON ". $kosul;
		
	
		
	
	
		$son=$this->prepare($sorgum);
		$son->execute();
		
		return $son->fetchAll();
				
		
		
	} // JOIN


	
}




?>