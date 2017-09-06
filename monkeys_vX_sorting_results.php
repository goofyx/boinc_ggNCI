	<?php

  echo "START MONKEYS_SORTING_FILES\n";
  
   $plik_lock = "/home/boincadm/gcc/pid_goofyxGrid/monkeys_vX_sorting_files.lock";
  if (file_exists($plik_lock)){
   exit;
  }
  
  $plik = file_put_contents( $plik_lock, "LOCK" );
  
  $katalog_zrodlowy = "/home/boincadm/gcc/sample_results_analyzed";
  $katalog_docelowy = "/home/boincadm/dane_goofyx_grid/gcc/archiwum";
  
  $licznik = 0;
  foreach( new directoryiterator( $katalog_zrodlowy ) as $plik )
  {
   if(!$plik->isDot())
   {
     if (filesize($katalog_zrodlowy."/".$plik) > 0 )
     {   
       $skladowe_nazwy = explode( "_", $plik->getFileName() );    
       $skladowe_serii = explode( "-", $skladowe_nazwy[2] );    
     //  $katalog_pliku = $katalog_docelowy."/".date('Y_m_d')."_".$skladowe_nazwy[0]."/".$skladowe_nazwy[1]."/".$skladowe_serii[1]."/".$skladowe_serii[0];
       $katalog_pliku = $katalog_docelowy."/".$skladowe_nazwy[0]."_".date('Y_m_d')."/".$skladowe_nazwy[1]."/".$skladowe_serii[1]."/".$skladowe_serii[0];
       if (!file_exists($katalog_pliku)){
	if (!mkdir( $katalog_pliku, 0777, true )){
	    echo "Błąd tworzenia katalogu: ".$katalog_pliku."\n";
	}
       }
       
       if (file_exists( $katalog_pliku."/".$plik->getFileName() ) ){
         unlink( $katalog_zrodlowy."/".$plik );
       } else {
       
         if (!rename($katalog_zrodlowy."/".$plik, $katalog_pliku."/".$plik->getFileName() ) )
         {       
	      echo "Błąd kopiowania/przenoszenia pliku: ".plik." do: ".$katalog_pliku."/".$plik->getFileName()."\n";
         } else {        
               $licznik++;
	//     echo "Przeniesiono plik nr.: ".$licznik." o nazwie: ".$plik."\n";
         }
       }
     } else {
       unlink($katalog_zrodlowy."/".$plik);
  //      echo "Skasowano pusty plik: ".$plik."\n";
     }
   }  
  }
  
  echo "plików: ".$licznik."\n";
  unlink($plik_lock);
  
  echo "KONIEC MONKEYS_SORTING_FILES\n";

?>
