<?php

  echo "START DELETE WRONG RECORD MONKEYS_v1_ANALYZER\n";
  
  include( "monkeys_db_trafienia.php" );
  
  $db_trafienia = new mysqli($db_trafienia_serwer, $db_trafienia_user, $db_trafienia_haslo, "monkeys_v3_trafienia", $db_trafienia_port); 
  if ($db_trafienia->connect_error) {
    die("Błąd połaczenia db_trafienia: ".$db_trafienia->connect_error);
  }
  
  for($ilosc_znakow=7;$ilosc_znakow<=13;$ilosc_znakow++){	
	  $db_trafienia ->query("delete FROM `trafienia_L".$ilosc_znakow."` WHERE length(`trafienia_L".$ilosc_znakow."`.`wyraz_losowany`) < ".$ilosc_znakow.";"); 
  }

  $db_trafienia->close(); 
  echo "KONIEC DELETE WRONG RECORD MONKEYS_v1_ANALYZER\n";





  echo "START DELETE WRONG RECORD MONKEYS_v3_ANALYZER\n";
  $db_trafienia = new mysqli($db_trafienia_serwer, $db_trafienia_user, $db_trafienia_haslo, "monkeys_v3_trafienia", $db_trafienia_port);
  if ($db_trafienia->connect_error) {
    die("Błąd połaczenia db_trafienia: ".$db_trafienia->connect_error);
  }
  
  for($ilosc_znakow=7;$ilosc_znakow<=13;$ilosc_znakow++){	
	  $db_trafienia ->query("delete FROM `trafienia_L".$ilosc_znakow."` WHERE length(`trafienia_L".$ilosc_znakow."`.`wyraz_losowany`) < ".$ilosc_znakow.";"); 
  }

  $db_trafienia->close(); 
  echo "KONIEC DELETE WRONG RECORD MONKEYS_v3_ANALYZER\n";

?>
