<?php

  echo "START MONKEYS_PRZEZUT\n";
  
  include( "monkeys_katalogi.php" );  
  
  $plik_lock = $katalog_pid."/monkeys_vX_przezut.lock";
  if (file_exists($plik_lock)){
   exit;   
  }
  $plik = file_put_contents( $plik_lock, "LOCK" );
 
  $katalog_zrodlowy = $katalog_sr;
  $katalog_docelowy = $katalog_doAnalizy;
  
  echo $katalog_zrodlowy."/*"."\n";
  
  $wyniki = glob($katalog_zrodlowy."/*");
  $ilosc_wynikow = count($wyniki);	
  echo "Ilość wyników: ".$ilosc_wynikow."\n";
  
  $licznik = 0;
 
  
  foreach( $wyniki as $plik )
  {
		if ( (!strcmp($plik,'.')==0) &&
      	    (!strcmp($plik,'..')==0) )
	   {
		   
	$sam_plik = basename( $plik );
	
       if (file_exists( $katalog_docelowy."/".$sam_plik ) ){
         unlink( $katalog_zrodlowy."/".$sam_plik );
       } else {
       
         if (!copy($katalog_zrodlowy."/".$sam_plik, $katalog_docelowy."/".$sam_plik ) )
         {       
	      echo "Błąd kopiowania/przenoszenia pliku: ".$sam_plik." do: ".$katalog_docelowy."/".$sam_plik."\n";
         } else {       
			unlink($katalog_zrodlowy."/".$sam_plik);
			$licznik++;
         }
	   }
	   	 
    echo "plików: ".$licznik." / ".$ilosc_wynikow." <->".$sam_plik."\n";
	 
   }  
  }
  
  echo "plików: ".$licznik."\n";
  unlink($plik_lock);
  
  echo "KONIEC MONKEYS_PRZEZUT\n";

?>
