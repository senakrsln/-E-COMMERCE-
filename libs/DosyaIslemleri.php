<?php

class DosyaIslemleri   {	
	public $oku,$sorgu,$sonuc,$verileritut,$gecici,$resimvarmi=false;	
	public $error=array(),$nodevalue=array(),$nodename=array(),$verilerdizi=array(),$sutunlardizi=array();	
		
	function __construct() {
		$this->oku = new DOMDocument();	
		$this->oku->preserveWhiteSpace=false;			
	}		
		
	function VerileriAyikla($name,$yol,array $elementler) {
		if ($this->oku->load($_FILES[$name]["tmp_name"])):
			$this->sorgu= new DOMXPath($this->oku);
			$this->sonuc= $this->sorgu->query($yol);
			if ($this->sonuc->length!=0):
				for ($a=0; $a<$this->sonuc->length; $a++):
					foreach ($elementler as  $deger):
						$desen="/[*]+/";
						$hamhali=preg_replace($desen,"",$deger,-1,$sayi);
						if ($sayi>0):
							@$this->gecici.="'".$this->oku->getElementsByTagName($hamhali)->item($a)->nodeValue."',";	
						else:
							@$this->gecici.=$this->oku->getElementsByTagName($deger)->item($a)->nodeValue.",";	
						endif;
					endforeach;
					$this->gecici=rtrim($this->gecici,",");
					@$this->verileritut.="(".$this->gecici."),";	
					@$this->gecici="";
				endfor;
				$this->verileritut=rtrim($this->verileritut,",");
				return $this->verileritut;	
			else:
				$this->error[]="Sorgu hatası, elemanlara ulaşılamadı";
			endif;
		else:
			$this->error[]="Yüklenen dosya açılamadı";
		endif;					
	} // XML DOSYA VERİ AYIKLAMA
		
	function JsonVerileriAyikla($name) {		
		$veriler=json_decode(file_get_contents($_FILES[$name]["tmp_name"]),true);		
		if (json_last_error()===JSON_ERROR_NONE):		
			foreach ($veriler as $value) :			
				$keys=array_keys($value);
				foreach ($keys as $key) :
					$desen="/[*]+/";
			    	$hamhali=preg_replace($desen,"",$key,-1,$sayi);
					if ($sayi>0):
						@$this->gecici.="'".$value[$key]."',";	
					else:
						@$this->gecici.=$value[$key].",";	
					endif;
				endforeach;
				$this->gecici=rtrim($this->gecici,",");
				@$this->verileritut.="(".$this->gecici."),";	
				@$this->gecici="";
			endforeach;
			$this->verileritut=rtrim($this->verileritut,",");
			return $this->verileritut;
		else:		
			$this->error[]="Yüklenen JSON dosyası açılamadı";
		endif;			
	}	 // jJSON DOSYA VERİ AYIKLAMA		
		
	function TopluGuncellemeXml($name,$yol) {
		if ($this->oku->load($_FILES[$name]["tmp_name"])):
			$this->sorgu= new DOMXPath($this->oku);
			$this->sonuc= $this->sorgu->query($yol);
			if ($this->sonuc->length!=0):
				foreach ($this->sonuc as $element):
					foreach ($element->childNodes as $node):
						if ($node->nodeName=="res1" || $node->nodeName=="res2" || $node->nodeName=="res3" ):
							$this->resimvarmi=true;
						endif;
						$this->nodevalue[]=$node->nodeValue;					
						$this->nodename[]=$node->nodeName;
					endforeach;
					$this->verilerdizi[]=$this->nodevalue;
					$this->sutunlardizi[]=$this->nodename;
					unset($this->nodevalue);
					unset($this->nodename);
				endforeach;
			else:
				$this->error[]="Sorgu hatası, elemanlara ulaşılamadı";
			endif;
		else:
			$this->error[]="Yüklenen dosya açılamadı";
		endif;		
	} // XML TOPLU VERİ GÜNCELLEME
		
	function TopluGuncellemeJson($name) {					
		$veriler=json_decode(file_get_contents($_FILES[$name]["tmp_name"]),true);
		if (json_last_error()===JSON_ERROR_NONE):
			foreach ($veriler as $value) :
			$keys=array_keys($value);
				foreach ($keys as $key) :
					if ($key=="res1" || $key=="res2" || $key=="res3" ):
						$this->resimvarmi=true;
					endif;
					$this->nodevalue[]=$value[$key];					
					$this->nodename[]=$key;				
				endforeach;
				$this->verilerdizi[]=$this->nodevalue;
				$this->sutunlardizi[]=$this->nodename;
				unset($this->nodevalue);
				unset($this->nodename);
			endforeach;
		else:
			$this->error[]="Yüklenen JSON dosyası açılamadı";
		endif;	
	}	 // JSON TOPLU VERİ GÜNCELLEME
		
	function TopluSilmeXml($name,$yol) {
		if ($this->oku->load($_FILES[$name]["tmp_name"])):
			$this->sorgu= new DOMXPath($this->oku);
			$this->sonuc= $this->sorgu->query($yol);
			if ($this->sonuc->length!=0):
				foreach ($this->sonuc as $element):
					foreach ($element->childNodes as $node):
						$this->verilerdizi[]=$node->nodeValue;			
					endforeach;
				endforeach;
				return join (",",$this->verilerdizi);	
			else:
				$this->error[]="Sorgu hatası, elemanlara ulaşılamadı";
			endif;
		else:
			$this->error[]="Yüklenen dosya açılamadı";
		endif;		
	} // XML TOPLU VERİ SİLME
		
	function TopluSilmeJson($name) {			
		$veriler=json_decode(file_get_contents($_FILES[$name]["tmp_name"]),true);
		if (json_last_error()===JSON_ERROR_NONE):
			foreach ($veriler as $value) :
				$keys=array_keys($value);
				foreach ($keys as $key) :				
					$this->verilerdizi[]=$value[$key];	
				endforeach;
			endforeach;
			return join (",",$this->verilerdizi);	
		else:
			$this->error[]="Yüklenen JSON dosyası açılamadı";
		endif;	
	} // JSON TOPLU VERİ SİLME
		
}
?>