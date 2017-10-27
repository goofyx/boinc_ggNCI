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
  
  foreach( new directoryiterator( $katalog_zrodlowy ) as $plik )
  {
   if(!$plik->isDot())
   {       
       if (file_exists( $katalog_docelowy."/".$plik->getFileName() ) ){
         unlink( $katalog_zrodlowy."/".$plik->getFileName() );
       } else {
       
         if (!copy($katalog_zrodlowy."/".$plik->getFileName(), $katalog_docelowy."/".$plik->getFileName() ) )
         {       
	      echo "Błąd kopiowania/przenoszenia pliku: ".$plik->getFileName()." do: ".$katalog_docelowy."/".$plik->getFileName()."\n";
         } else {       
			unlink($katalog_zrodlowy."/".$plik->getFileName());
         }
	   }
   }  
  }
  
  echo "plików: ".$licznik."\n";
  unlink($plik_lock);
  
  echo "KONIEC MONKEYS_PRZEZUT\n";

?>
