<?php
  if (empty($argv[1])) die("Brak parametru nr_aplikacja\n");
    
  $nr_aplikacji = $argv[1];
  $id_aplikacji = 0;
  $prog_generowania = 250000;


	include( "monkeys_db_projekt.php" );
	include( "monkeys_katalogi.php" );
  
  if ($nr_aplikacji == 'v1'){
    $id_aplikacji = 5; 
  } elseif ($nr_aplikacji == 'v3') {
    $id_aplikacji = 7; 
  } else {
    die("Błędny nr_aplikacji: ".$nr_aplikacji);
  }
  
  echo "START MONKEYS_".$nr_aplikacji."_GENERATOR\n";
  
 
  $db_projekt = new mysqli($db_projekt_serwer, $db_projekt_user, $db_projekt_haslo, $db_projekt_baza);
  if ($db_projekt->connect_error)  {
    die("Błąd połaczenia db_projekt: ".$db_projekt->connect_error);
  }         

  
  $sql = "select count(1) from result where appid = '".$id_aplikacji."' and server_state = '2'";  
  $wynik = $db_projekt->query($sql);
   
  if ($wynik->num_rows > 0) 
  {
    $nie_wyslanych = $wynik->fetch_assoc();
    if ($nie_wyslanych["count(1)"] < $prog_generowania ){    
      system( "php ".$katalog_domowy."/monkeys_v1_and_v3_db_wu_2.php ".$nr_aplikacji );  
    } else {
      echo "Ilosc WU dla Monkeys_".$nr_aplikacji.":".$nie_wyslanych["count(1)"]."\n";    
    }        
  }
   
  $db_projekt->close();
  

  echo "KONIEC MONKEYS_".$nr_aplikacji."_GENERATOR\n";
?>