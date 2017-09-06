<?php


  if (empty($argv[1])) die("Brak parametru nr_aplikacja\n");
    
  $nr_aplikacji = $argv[1];
  $id_aplikacji = 0;
  $prog_generowania = 150000;
  
  if ($nr_aplikacji == 'v2'){
    $id_aplikacji = 6; 
  } elseif ($nr_aplikacji == 'v4') {
    $id_aplikacji = 8; 
  } elseif ($nr_aplikacji == 'v2_cpu'){
    $id_aplikacji = 10; 
  } elseif ($nr_aplikacji == 'v4_cpu') {
    $id_aplikacji = 12; 
  } else {
    die("Błędny nr_aplikacji: ".$nr_aplikacji);
  }
    
  echo "START MONKEYS_".$nr_aplikacji."_GENERATOR\n";
  
 
  $db_projekt = new mysqli("localhost", "boincadm", "boincadm_Haslo123", "gcc");
  if ($db_projekt->connect_error)  {
    die("Błąd połaczenia db_projekt: ".$db_projekt->connect_error);
  }         

  
  $sql = "select count(1) from result where appid = '".$id_aplikacji."' and server_state = '2'";  
  $wynik = $db_projekt->query($sql);
   
  if ($wynik->num_rows > 0) 
  {
    $nie_wyslanych = $wynik->fetch_assoc();
    if ($nie_wyslanych["count(1)"] < $prog_generowania ){    
      system( "php /home/boincadm/gcc/monkeys_v2_and_v4_db_wu.php ".$nr_aplikacji );  
    } else {
      echo "Ilosc WU dla Monkeys_".$nr_aplikacji.":".$nie_wyslanych["count(1)"]."\n";    
    }        
  }
   
  $db_projekt->close();
  

  echo "KONIEC MONKEYS_".$nr_aplikacji."_GENERATOR\n";
?>
