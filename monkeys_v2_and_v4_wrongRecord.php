<?php

  echo "START DELETE WRONG RECORD MONKEYS_v2_ANALYZER\n";
  $db_trafienia = new mysqli("localhost", "boincadm","boincadm_Haslo123", "monkeys_v2_trafienia");
  if ($db_trafienia->connect_error) {
    die("Błąd połaczenia db_trafienia: ".$db_trafienia->connect_error);
  }

  $db_trafienia ->query("delete FROM `trafienia` WHERE zgodnosc < 6;"); 
  $db_trafienia->close(); 
  echo "KONIEC DELETE WRONG RECORD MONKEYS_v2_ANALYZER\n";





  echo "START DELETE WRONG RECORD MONKEYS_v4_ANALYZER\n";
  $db_trafienia = new mysqli("localhost", "boincadm","boincadm_Haslo123", "monkeys_v4_trafienia");
  if ($db_trafienia->connect_error) {
    die("Błąd połaczenia db_trafienia: ".$db_trafienia->connect_error);
  }

  $db_trafienia ->query("delete FROM `trafienia` WHERE zgodnosc < 6;"); 
  $db_trafienia->close(); 
  echo "KONIEC DELETE WRONG RECORD MONKEYS_v4_ANALYZER\n";

?>
