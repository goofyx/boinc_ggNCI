<?php

  echo "START DELETE WRONG RECORD MONKEYS_v2_ANALYZER\n";
  
  include( "monkeys_db_trafienia.php" );
  
  $db_trafienia = new mysqli($db_trafienia_serwer, $db_trafienia_user, $db_trafienia_haslo, "monkeys_v3_trafienia", $db_trafienia_port); 
  if ($db_trafienia->connect_error) {
    die("Błąd połaczenia db_trafienia: ".$db_trafienia->connect_error);
  }

  $db_trafienia ->query("delete FROM `trafienia` WHERE zgodnosc < 6;"); 
  $db_trafienia->close(); 
  echo "KONIEC DELETE WRONG RECORD MONKEYS_v2_ANALYZER\n";





  echo "START DELETE WRONG RECORD MONKEYS_v4_ANALYZER\n";
  $db_trafienia = new mysqli($db_trafienia_serwer, $db_trafienia_user, $db_trafienia_haslo, "monkeys_v3_trafienia", $db_trafienia_port); 
  if ($db_trafienia->connect_error) {
    die("Błąd połaczenia db_trafienia: ".$db_trafienia->connect_error);
  }

  $db_trafienia ->query("delete FROM `trafienia` WHERE zgodnosc < 6;"); 
  $db_trafienia->close(); 
  echo "KONIEC DELETE WRONG RECORD MONKEYS_v4_ANALYZER\n";

?>
