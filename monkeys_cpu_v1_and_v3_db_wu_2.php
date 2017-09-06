<?php

  if (empty($argv[1])) die("Brak parametru nr_aplikacja\n");
    
  $nr_aplikacji = $argv[1];

  $plik_lock = "/home/boincadm/gcc/pid_goofyxGrid/monkeys_cpu_".$nr_aplikacji."_db_wu_2.lock";
  if (file_exists($plik_lock)){
   exit;
  }  
  $plik = file_put_contents( $plik_lock, "LOCK" );

  echo "START MONKEYS_cpu_".$nr_aplikacji."_DB_WU\n";
  
  
  $db_generator1 = new mysqli("localhost", "boincadm","boincadm_Haslo123", "monkeys_vX_generators");
  if ($db_generator1->connect_error) {
     die("Błąd połaczenia db_generator1: ".$db_generator1->connect_error);
  }

  $katalog_domowy = "/home/boincadm/gcc/";  

  $sql = "SELECT * FROM `generator_".$nr_aplikacji."_cpu` WHERE `nastepna` <= `max_serii` limit 0, 1";  
  $wynik_seria = $db_generator1->query($sql);
   
  if ($wynik_seria->num_rows > 0) 
  {
    $seriaDB = $wynik_seria->fetch_assoc();
    
    //echo $seriaDB["seria"]." <-> ".$seriaDB["nastepna"]." <-> ".$seriaDB["ilosc_znakow"]." <-> ".$seriaDB["ilosc_wu"]."\n";
   
    
    $seria = $seriaDB["seria"].".".$seriaDB["nastepna"].'-L';
//    $ilosc_znakow = $seriaDB["ilosc_znakow"];

    $ilosc_wu_start =  1;
    $ilosc_wu_koniec = $seriaDB["ilosc_wu"];
    $ilosc_wu_seria =  $ilosc_wu_koniec;

    $ilosc_slow = 3600000000;
    $czas_przerwy = 0;

if ($nr_aplikacji == 'v1'){
    $jakie_losowanie = 1; 
  } elseif ($nr_aplikacji == 'v3') {
    $jakie_losowanie = 2; 
  }  else {
    unlink($plik_lock);
    die("Błędny nr_aplikacji_cpu: ".$nr_aplikacji);
  }   
    
    $waznosc_wu_dni = 5;
    $waznosc_wu_sekundy = $waznosc_wu_dni * 24 * 60 * 60;

    $punkty = 10;
    
    $nazwa_pliku_templatki = "monkeys_".$nr_aplikacji."_cpu_wu_".$seria; 
    $zawartosc_pliku_templatki = 
      "<file_info>
	<number>0</number>
       </file_info>
       <workunit>
	<file_ref>
	  <file_number>0</file_number>
	  <open_name>monkeys_".$nr_aplikacji.".in</open_name>
	  <copy_file/>
	</file_ref>
	<target_nresults>1</target_nresults>
	<min_quorum>1</min_quorum>
	<rsc_memory_bound>100000000</rsc_memory_bound>
	<rsc_disk_bound>100000000</rsc_disk_bound>
	<rsc_fpops_est>10000000.000000</rsc_fpops_est>
	<rsc_fpops_bound>1e20</rsc_fpops_bound>
	<credit>".$punkty."</credit>
       </workunit>";
 //   $plik_6 = file_put_contents( $katalog_domowy."templates/".$nazwa_pliku_templatki."6", $zawartosc_pliku_templatki );	
    $plik_7 = file_put_contents( $katalog_domowy."templates/".$nazwa_pliku_templatki."7", $zawartosc_pliku_templatki );
    $plik_8 = file_put_contents( $katalog_domowy."templates/".$nazwa_pliku_templatki."8", $zawartosc_pliku_templatki );
    $plik_9 = file_put_contents( $katalog_domowy."templates/".$nazwa_pliku_templatki."9", $zawartosc_pliku_templatki );
    $plik_10 = file_put_contents( $katalog_domowy."templates/".$nazwa_pliku_templatki."10", $zawartosc_pliku_templatki );
    $plik_11 = file_put_contents( $katalog_domowy."templates/".$nazwa_pliku_templatki."11", $zawartosc_pliku_templatki );
    $plik_12 = file_put_contents( $katalog_domowy."templates/".$nazwa_pliku_templatki."12", $zawartosc_pliku_templatki );
    $plik_13 = file_put_contents( $katalog_domowy."templates/".$nazwa_pliku_templatki."13", $zawartosc_pliku_templatki );


    foreach (range( $ilosc_wu_start, $ilosc_wu_koniec ) as $liczba) {
	
//	echo "1. Rozpoczęto generowanie WU : ".$liczba." na ".$ilosc_wu_koniec."\n";
     for($ilosc_znakow=7;$ilosc_znakow<=13;$ilosc_znakow++){	
   //  for($ilosc_znakow=9;$ilosc_znakow<=9;$ilosc_znakow++){	

	$nazwa_pliku_wu = "monkeys_".$nr_aplikacji."_cpu_".$seria.$ilosc_znakow."_".str_pad($liczba, 6, 0, STR_PAD_LEFT)."_".$ilosc_wu_seria;
//	echo "  ".$nazwa_pliku_wu."\n ";

	$plik = file_put_contents( $katalog_domowy."download_temp/".$nazwa_pliku_wu, "".$ilosc_znakow." ".$ilosc_slow." ".$czas_przerwy." ".$jakie_losowanie );	

	$polecenie = "bin/stage_file /home/boincadm/gcc/download_temp/".$nazwa_pliku_wu;
	exec( $polecenie );
	$polecenie = "./bin/create_work --delay_bound ".$waznosc_wu_sekundy." -appname monkeys_".$nr_aplikacji."_cpu -wu_name ".$nazwa_pliku_wu." --max_error_results 1 --max_success_results 1 -wu_template templates/".$nazwa_pliku_templatki.$ilosc_znakow." -result_template templates/monkeys_".$nr_aplikacji."_cpu_result ".$nazwa_pliku_wu;
	exec( $polecenie );
	
      }

//	echo "2. Zakończono generowanie WU : ".$liczba." na ".$ilosc_wu_koniec."\n";
		
    }
    
    //update nastepny   
    $sql = "UPDATE `generator_".$nr_aplikacji."_cpu` SET `nastepna`= '".++$seriaDB["nastepna"]."' WHERE `seria`= '".$seriaDB["seria"]."'";  
    echo $sql;
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
echo "KONIEC MONKEYS_cpu_".$nr_aplikacji."_DB_WU\n";


?>

