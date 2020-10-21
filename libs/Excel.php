<?php

class  Excel {
	
	function excelal($filename='Excelaktar',$tablobasligi,array $enaltsatir=NULL,$columns=array(),$data=array())

	{

	header('Content-Encoding: UTF-8');
	header('Content-Type: text/plain; charset=utf-8');
	header('Content-disposition: attachment; filename='.$filename.'.xls');
	echo "\xEF\xBB\xBF"; // bom
	
	$sayim=count($columns);
	
	echo '<table border="1"><th style="background-color:#6f26c0" colspan="'.$sayim.'">
	
		<font color="#FDFDFD">'.$tablobasligi.'</font></th>

		<tr>';

		// BAŞLIKLARIMI OLUŞTURUYORUM

		foreach ($columns as $veri):

			echo '<td style="background-color:#ddb446">'.trim($veri)."</td>";

		endforeach;

		echo '</tr>';

		//VERİLERİMİ OLUŞTURUYORUM

		foreach ($data as $val):

			echo '<tr>';

					for($i=0; $i<$sayim; $i++):

					echo '<td>'.$val[$i]."</td>";

					endfor;			

			echo '</tr>';

		endforeach;

		if ($enaltsatir!=NULL):

			echo '<tr>';

				foreach ($enaltsatir as $veri):

					echo '<td style="background-color:#ddb446">'.trim($veri)."</td>";

				endforeach;

			echo '</tr>';

		endif;
	
	
	echo '</table>';
		
}
	
	
	function Excelaktar($tablobasligi,$altsatir,$basliklar,$icerikler) {

		$this->excelal(date("d.m.Y"),$tablobasligi,$altsatir,$basliklar,$icerikler);

	
	}

}

?>