<?php

  if (empty($argv[1])) die("Brak parametru nr_aplikacja\n");
    
  $nr_aplikacji = $argv[1];
  $nr_aplikacji_templates = $argv[1];

	include( "monkeys_db_generator.php" );
	include( "monkeys_katalogi.php" );  
	
  $nr_aplikacji_wu =  str_replace( "_", "-", $nr_aplikacji );
  
  $plik_lock = $katalog_pid."/monkeys_".$nr_aplikacji."_db_wu.lock";
  if (file_exists($plik_lock)){
   exit;
  }  
  $plik = file_put_contents( $plik_lock, "LOCK" );


  echo "START MONKEYS_".$nr_aplikacji."_DB_WU\n";

  $db_generator1 = new mysqli($db_generator_serwer, $db_generator_user, $db_generator_haslo, "monkeys_vX_generators", $db_generator_port);
  if ($db_generator1->connect_error) {
     die("Błąd połaczenia db_generator1: ".$db_generator1->connect_error);
  }

  $sql = "SELECT * FROM `generator_".$nr_aplikacji."_nci` WHERE `nastepna` <= `max_serii` limit 0, 1";  
  $wynik_seria = $db_generator1->query($sql);
    
  if ($wynik_seria->num_rows > 0) 
  {
    $seriaDB = $wynik_seria->fetch_assoc();       
    
    
    $seria = $seriaDB["seria"].".".$seriaDB["nastepna"].'-';

	$szukane_slowo='CHRISTMAS';
    $ilosc_znakow = 9; //$seriaDB["ilosc_znakow"];
	
    $ilosc_slow = 3600;
    $czas_przerwy = 1;
    $punkty = 10;
 
    $ilosc_wu_start =  1;
    $ilosc_wu_koniec = 100000; //$seriaDB["ilosc_wu"];
    $ilosc_wu_seria =  $ilosc_wu_koniec;

    $tylkoPoczatek = 1; //$seriaDB["tylko_poczatek"];
    $ileZgodnychZnakow = 6; //$seriaDB["ilosc_zgodnych"];
    
  if ($nr_aplikacji == 'v2'){
    $jakie_losowanie = 1; 
  } elseif ($nr_aplikacji == 'v4') {
    $jakie_losowanie = 2; 
  } else {
    unlink($plik_lock);
    die("Błędny nr_aplikacji: ".$nr_aplikacji);
  }   
    
     //1-see na wu  2-seed na wyraz

    $waznosc_wu_dni = 5;
    $waznosc_wu_sekundy = $waznosc_wu_dni * 24 * 60 * 60;

    $punkty = 10;
  
    $nazwa_pliku_templatki = "monkeys_".$nr_aplikacji."_wu_".$seria.$szukane_slowo;
    $zawartosc_pliku_templatki =
      "<file_info>
	<number>0</number>
      </file_info>
      <workunit>
	<file_ref>
	  <file_number>0</file_number>
	  <open_name>monkeys_".$nr_aplikacji_templates.".in</open_name>
	  <copy_file/>
	</file_ref>
	<target_nresults>1</target_nresults>
	<min_quorum>1</min_quorum>
	<rsc_memory_bound>100000000</rsc_memory_bound>
	<rsc_disk_bound>100000000</rsc_disk_bound>
	<credit>".$punkty."</credit>
      </workunit>";
    $plik = file_put_contents( $katalog_templates."/".$nazwa_pliku_templatki, $zawartosc_pliku_templatki );

//	<rsc_fpops_est>5e9</rsc_fpops_est>
//	<rsc_fpops_bound>5e9</rsc_fpops_bound>

//exec( './bin/stop' );

    foreach (range( $ilosc_wu_start, $ilosc_wu_koniec ) as $liczba) {
	
//	echo "1. Rozpoczęto generowanie WU : ".$liczba." na ".$ilosc_wu_koniec."\n";
	
	$nazwa_pliku_wu = "monkeys_".$nr_aplikacji_wu."_".$seria.$szukane_slowo."_".str_pad($liczba, 6, 0, STR_PAD_LEFT)."_".$ilosc_wu_seria;
//	echo "  ".$nazwa_pliku_wu."\n ";

	$plik = file_put_contents( $katalog_download_temp."/".$nazwa_pliku_wu, "".$szukane_slowo." ".$ilosc_slow." ".$ileZgodnychZnakow." ".$tylkoPoczatek." ".$czas_przerwy." ".$jakie_losowanie );

	$polecenie = "./bin/stage_file ".$katalog_download_temp."/".$nazwa_pliku_wu;
	exec( $polecenie );
	$polecenie = "./bin/create_work --delay_bound ".$waznosc_wu_sekundy." -appname monkeys_".$nr_aplikacji." -wu_name ".$nazwa_pliku_wu." --max_error_results 1 --max_success_results 1 -wu_template templates/".$nazwa_pliku_templatki." -result_template templates/monkeys_".$nr_aplikacji."_result ".$nazwa_pliku_wu;
	exec( $polecenie );

	 if ($liczba % 10000 == 0){
                echo "Zrobiono: ".$liczba."\n";
        }
	
	echo "2. Zakończono generowanie WU : ".$liczba." na ".$ilosc_wu_koniec."\n";
		
    }
    
    //update nastepny   
    $sql = "UPDATE `generator_".$nr_aplikacji."_nci` SET `nastepna`= '".++$seriaDB["nastepna"]."' WHERE `seria`= '".$seriaDB["seria"]."'";  
    echo $sql;
	
	$db_generator1->close();
	  $db_generator1 = new mysqli($db_generator_serwer, $db_generator_user, $db_generator_haslo, "monkeys_vX_generators", $db_generator_port);
  if ($db_generator1->connect_error) {
     die("Błąd połaczenia db_generator1: ".$db_generator1->connect_error);
  }
	
    if ($db_generator1->query($sql) === TRUE) {
      echo "Zaktualizowano wpis dla:".$seriaDB["seria"];
    } else {
      echo "Bład aktualizacji dla: ".$seriaDB["seria"]." <-> ".$db_generator1->error;
    }
    
    $db_generator1->close();
    
  } else {
    echo "Brak WU do wygenerowania\n";
  }    


  unlink($plik_lock);
echo "KONIEC MONKEYS_".$nr_aplikacji."_DB_WU\n";


?>

