<?php

class  Pagination {
	
	public $limit,$toplamsayfa,$sayfam;
	
	
function paginationOlustur($verisayisi,$mevcutsayfa,$adet){
	    
		$this->gosterilecekadet=$adet;
		
		$this->toplamsayfa=ceil($verisayisi / $this->gosterilecekadet);
		
		$this->sayfam=is_numeric($mevcutsayfa) ? $this->sayfam=$mevcutsayfa : $this->sayfam=1;
		if($this->sayfam<1) $this->sayfam=1;
		if($this->sayfam > $this->toplamsayfa) $this->sayfam=$this->toplamsayfa;
		$this->limit= ($this->sayfam -1) * $this->gosterilecekadet;
}
	
public static function numaralar($toplamsayfa,$link){
	echo '<nav aria-label="Page navigation example ">
                    
                    <ul class="pagination mx-auto border border-dark  bg-gradient-mvc mt-1">';
					
					for ($s=1; $s<=$toplamsayfa; $s++) :
					echo '<li class="page-item m-1 ">
					<a class="page-link" href="'.URL.$link.$s.'">'.$s.'</a>
					
					</li>';
					
					endfor;
                    
               echo'</ul>
                    </nav>';  
}
	
}




?>