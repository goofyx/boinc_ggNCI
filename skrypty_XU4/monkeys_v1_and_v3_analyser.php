<?php


  if (empty($argv[1])) die("Brak parametru nr_aplikacja\n");
  if (empty($argv[2])) die("Brak parametru ilosc_znakow\n");
    
  $nr_aplikacji = $argv[1];
  $ile_znakow=$argv[2];
  
  include( "monkeys_db_trafienia.php" );
  include( "monkeys_db_projekt.php" );
  include( "monkeys_katalogi.php" );  
  
  echo "START MONKEYS_".$nr_aplikacji."_ANALYZER: ".$ile_znakow."\n";
  
  $ilosc_znakow=$ile_znakow;

  $katalog_zrodlowy = $katalog_sr;
  $katalog_docelowy = $katalog_srAnalyzed;
  $katalog_noUser = $katalog_srNoUser;
  
  
  $licznik = 0;
  $licznik_2 = 0;  
  $rozpoczeto = date("Y-m-d H:i:s");
  
  
   $db_trafienia = new mysqli($db_trafienia_serwer, $db_trafienia_user, $db_trafienia_haslo, "monkeys_".$nr_aplikacji."_trafienia", $db_trafienia_port);
   if ($db_trafienia->connect_error) {
     die("Błąd połaczenia db_trafienia: ".$db_trafienia->connect_error);
   }
 
 
  $db_projekt = new mysqli($db_projekt_serwer, $db_projekt_user, $db_projekt_haslo, $db_projekt_baza, $db_projekt_port);
  if ($db_projekt->connect_error)  {
    die("Błąd połaczenia db_projekt: ".$db_projekt->connect_error);
  }         
       
  $slownik = file( $katalog_domowy_skrypty.'/monkeys_'.$ile_znakow.'_en.dic' );
  foreach($slownik as $wyraz)
    $slownik[$wyraz] = 1;
        
  foreach (glob($katalog_zrodlowy."/*_".$nr_aplikacji."_*-L".$ile_znakow."*") as $filename) {
  $plik = basename($filename);
   $skladowe_nazwy = explode( "_", $plik ); 
   if ( (!strcmp($plik,'.')==0) &&
      (!strcmp($plik,'..')==0) )
   {
//          1. wczytanie pliku do array
	   $wynik_v1 = file($katalog_zrodlowy."/".$plik);
	   
	   $licznik++;
	// echo "Plik:".$plik."\n"; 
	 
	 
	if ($db_projekt->connect_error)  {
		die("Błąd połaczenia db_projekt: ".$db_projekt->connect_error);
	}
//          2. porównania ze słownikiemzapis do bazy pozostałych po explode spacji + nazwa usera
	if (count($wynik_v1) > 0) {	   
	// echo "SSSSS:".microtime(1)."\n";   	   
	   $nazwa_usera = "";	
	   $licznik_2++;
	   
	   foreach ( $wynik_v1 as $pozycja )
	   {	               
	     $pozycja_array = explode( " ", $pozycja ); 
	     $data_array = explode( "-", $pozycja_array[ 0 ] );
	     $data_nowa = $data_array[ 2 ]."-".$data_array[ 1 ]."-".$data_array[ 0 ];
	     unset($data_array);
	     	     
	     //rozpoznanie ilości znaków L5, L6, L7
	     $wyraz_slownik = "";	
	    	     
	     if ( isset( $slownik[ strtolower( $pozycja_array[ 2 ] ) ] ) )
	     {
	        $wyraz_slownik = $pozycja_array[ 2 ];
	     }
	     
	     if (!strcmp($wyraz_slownik,'')==0)
	     {	       
	       if (strcmp($nazwa_usera,'')==0)
	       { 
		  $sql = "SELECT `user`.`name` FROM `result` left join `user` on `result`.`userid` = `user`.`id` where `result`.`server_state` = 5 AND `result`.`client_state` = 5 AND `result`.`name` LIKE '%".$plik."%'";
// 	     echo "Zapytanie: ".$sql."\n";	   
		  $wynik_user = $db_projekt->query($sql);

		  if ($wynik_user->num_rows > 0) 
		  {
		    $user = $wynik_user->fetch_assoc();
		    $nazwa_usera = $user["name"];
		    $wynik_user->free();	    	       
		  }    
		 
	       }
	     
	       if (!strcmp($nazwa_usera,'')==0)
	       {		       
		  $sql = "INSERT INTO trafienia_L".$ile_znakow."( data, czas, wyraz_losowany, nazwa_user, nazwa_wu, wyraz_slownik ) VALUES ( "."\"".$data_nowa."\"".", "."\"".$pozycja_array[ 1 ]."\"".", "."\"".$pozycja_array[ 2 ]."\"".", "."\"".$nazwa_usera."\"".", "."\"".$plik."\"".", "."\"".strtolower( $wyraz_slownik )."\""." );";	        	        
//	          echo $sql."\n";	   
		  if (!$db_trafienia->query( $sql ) === TRUE ) echo "Błąd dodawanie do bazy: ".$db_trafienia->error."\n";
	       }else {
		  $nazwa_usera = "";
		  if (!copy($katalog_zrodlowy."/".$plik, $katalog_noUser."/".$plik)){       
	          }else{
				  unlink($katalog_zrodlowy."/".$plik);
			  }				  
	       }
	       
 	      }
	      unset($pozycja_array);	   
	      $wyraz_slownik = "";
	    } 

	unset($wynik_v1);
	
         /////       
    }  
      
         if (!copy($katalog_zrodlowy."/".$plik, $katalog_docelowy."/".$plik))
         {       
			echo "Błąd kopiowania/przenoszenia pliku: ".$plik." do: ".$katalog_docelowy."/".$plik."\n";
         }else{
		    unlink($katalog_zrodlowy."/".$plik);
		 }
      
         
	$nazwa_usera = "";
  }    
}  
  
//zapis danych do przerobione 
if ( $licznik > 0 ) { 

  $db_trafienia->close();
  $db_trafienia = new mysqli($db_trafienia_serwer, $db_trafienia_user, $db_trafienia_haslo, "monkeys_".$nr_aplikacji."_trafienia", $db_trafienia_port);
  if ($db_trafienia->connect_error) {
    die("Błąd połaczenia db_trafienia: ".$db_trafienia->connect_error);
  }  
  
   $sql = "INSERT INTO przerobione ( rozpoczeto, zakonczono, przerobiono, przerobiono_".$ile_znakow." ) VALUES ( "."\"".$rozpoczeto."\"".", "."\"".date("Y-m-d H:i:s")."\"".", "."\"".$licznik."\"".", "."\"".$licznik_2."\""." );";	        	        
  if ($db_trafienia->query( $sql ) === TRUE ) {
   		echo "Dodano wynik do bazy"."\n";
  } else {
     echo "Błąd dodawania przerobu do bazy: ".$db_trafienia->error."\n";
  }
  }  
  
  $db_trafienia->close();   
  $db_projekt->close();
  
  unset( $slownik );
  
  echo "KONIEC MONKEYS_".$nr_aplikacji."_ANALYZER: ".$ile_znakow."\n";

?>
