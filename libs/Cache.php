<?php

class  Cache {
	
    public $dosya,$saniye,$type;
	
	
	     
	function cacheKontrol($saniye2=false)	{
	                include 'config/cache.php';
		      
		            $parcala=explode('/',$_SERVER['REQUEST_URI']);
	
         
		
		            if (in_array(end($parcala),$cacheNo)) : //Bir dizi içerisindeki verinin başka bir dizinin içerisinde var olup olmadığını sorgulama işlemi
		
		            $this->type=false;
		    
		            else:
		
		            $this->type=true;
		            endif;
		
		           
		
		  if($this->type):
		
		          
			
		 if($saniye2):
		 $this->saniye=$saniye2;	
		 else :
		 $this->saniye=$CacheSure["saniye"];	
		 endif;	
				
			
		$this->dosya=CACHEYOL.md5($_SERVER['REQUEST_URI']).".html";//Mevcut tıklanmış olan URL'yi alma işlemi  
		if (file_exists($this->dosya) && (time() - $this->saniye < filemtime($this->dosya))): //Dosyanın değişiklik zamanının döndürülmesi

         readfile($this->dosya);

         exit();

         endif;

         
		ob_start();//Bu sayfanın nereden kopyalanacağını gösteren başlangıç noktasıdır.
          
		
	
		               endif;
  }

  function cacheOlustur() {
	  
	  if ($this->type) :
	  
	  
	     $dosya=fopen($this->dosya,"w");
         fwrite($dosya,ob_get_contents());//Derlenmiş olan sayfanın tüm çıktısını elinde tutabilen komut
         fclose($dosya);
         ob_end_flush();
	  
	  endif;
  }


}



?>