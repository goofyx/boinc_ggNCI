<?php

  echo "START MONKEYS_SORTING_FILES\n";
  
  include( "monkeys_katalogi.php" );  
  
  
  $katalog_zrodlowy = $katalog_srAnalyzed;
  $katalog_docelowy = $katalog_archives_results;
  
  $licznik = 0;
  foreach( new directoryiterator( $katalog_zrodlowy ) as $plik )
  {
   if(!$plik->isDot())
   {
     if (filesize($katalog_zrodlowy."/".$plik) > 0 )
     {   
		
       $skladowe_nazwy = explode( "_", $plik->getFileName() );    
       $skladowe_serii = explode( "-", $skladowe_nazwy[2] );    
       $katalog_pliku = $katalog_docelowy."/".$skladowe_nazwy[0]."_".date('Y_m_d')."/".$skladowe_nazwy[1]."/".$skladowe_serii[1]."/".$skladowe_serii[0];
       if (!file_exists($katalog_pliku)){
	if (!mkdir( $katalog_pliku, 0777, true )){
	    echo "Błąd tworzenia katalogu: ".$katalog_pliku."\n";
	}
       }
       
       if (file_exists( $katalog_pliku."/".$plik->getFileName() ) ){
         unlink( $katalog_zrodlowy."/".$plik );
       } else {
       
         if (!copy($katalog_zrodlowy."/".$plik, $katalog_pliku."/".$plik->getFileName() ) )
         {       
	      echo "Błąd kopiowania/przenoszenia pliku: ".plik." do: ".$katalog_pliku."/".$plik->getFileName()."\n";
         } else {        
            $licznik++;
			unlink($katalog_zrodlowy."/".basename($plik));
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
  
  
  echo "KONIEC MONKEYS_SORTING_FILES\n";

?>
