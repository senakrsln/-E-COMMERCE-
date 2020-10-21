<?php

class  Controller {
	
	
	function __construct() {
			
		$this->view = new View();
		$this->form = new Form();
		$this->bilgi = new Bilgi();
		$this->Upload = new Upload();
	}
	
	// ihtyiacımız olan model'i dahil ediyoruz
	public function Modelyukle($name) {
		
		$yol='model/'.$name.'_model.php';
		
		if (file_exists($yol)) :
		
		require $yol;
		
		$modelsinifName=$name.'_model';
		
		$this->model= new $modelsinifName();
		
		endif;
		
		
	}
	
	function KutuphaneYukle(array $ad){
		
		foreach ($ad as $deger):
		
		$this->$deger = new $deger();
		
		endforeach;
		
			
		
	}
	
	
}




?>