<?php


  echo "START MONKEYS_VX_DB_SERIE\n";

  $db_generator1 = mysqli_connect("localhost:34010", "boincadm", "boincadm_Haslo123", "monkeys_vX_generators");
  if (!$db_generator1) 
{
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
  }

 
  $seria_przedrostki = range('1', '999');  //'00';
  $serie_znak = range('A','Z');
  
  //$ilosc_znakow = 6;
  $ilosc_wu     = 100000;
  $max_serii    = 10;
  
 
    //update nastepny   
foreach ( $seria_przedrostki as $seria_przedrostek){
  foreach ($serie_znak as $seria_znak) {

  echo "PRZERABIAM: ".$seria_przedrostek." / ".$seria_przedrostki." <-> seria_znak:".$seria_znak." / ".$serie_znak."\n";
  
    $sql = "INSERT INTO `generator_v1_nci` (`seria`, `nastepna`, `max_serii`, `ilosc_wu`) VALUES ( "."\"".str_pad($seria_przedrostek, 6, 0, STR_PAD_LEFT).$seria_znak."\"".", "."\"1\", "."\"".$max_serii."\"".", "."\"".$ilosc_wu."\"".");";    
    mysqli_query( $db_generator1, $sql);	
    $sql = "INSERT INTO `generator_v2_nci` (`seria`, `nastepna`, `max_serii`, `ilosc_wu`) VALUES ( "."\"".str_pad($seria_przedrostek, 6, 0, STR_PAD_LEFT).$seria_znak."\"".", "."\"1\", "."\"".$max_serii."\"".", "."\"".$ilosc_wu."\"".");";    
    mysqli_query( $db_generator1, $sql);	
    $sql = "INSERT INTO `generator_v3_nci` (`seria`, `nastepna`, `max_serii`, `ilosc_wu`) VALUES ( "."\"".str_pad($seria_przedrostek, 6, 0, STR_PAD_LEFT).$seria_znak."\"".", "."\"1\", "."\"".$max_serii."\"".", "."\"".$ilosc_wu."\"".");";    
    mysqli_query( $db_generator1, $sql);	
    $sql = "INSERT INTO `generator_v4_nci` (`seria`, `nastepna`, `max_serii`, `ilosc_wu`) VALUES ( "."\"".str_pad($seria_przedrostek, 6, 0, STR_PAD_LEFT).$seria_znak."\"".", "."\"1\", "."\"".$max_serii."\"".", "."\"".$ilosc_wu."\"".");";    
    mysqli_query( $db_generator1, $sql);
	
    $sql = "INSERT INTO `generator_v1_cpu` (`seria`, `nastepna`, `max_serii`, `ilosc_wu`) VALUES ( "."\"".str_pad($seria_przedrostek, 6, 0, STR_PAD_LEFT).$seria_znak."\"".", "."\"1\", "."\"".$max_serii."\"".", "."\"".$ilosc_wu."\"".");";    
    mysqli_query( $db_generator1, $sql);	
    $sql = "INSERT INTO `generator_v2_cpu` (`seria`, `nastepna`, `max_serii`, `ilosc_wu`) VALUES ( "."\"".str_pad($seria_przedrostek, 6, 0, STR_PAD_LEFT).$seria_znak."\"".", "."\"1\", "."\"".$max_serii."\"".", "."\"".$ilosc_wu."\"".");";    
    mysqli_query( $db_generator1, $sql);	
    $sql = "INSERT INTO `generator_v3_cpu` (`seria`, `nastepna`, `max_serii`, `ilosc_wu`) VALUES ( "."\"".str_pad($seria_przedrostek, 6, 0, STR_PAD_LEFT).$seria_znak."\"".", "."\"1\", "."\"".$max_serii."\"".", "."\"".$ilosc_wu."\"".");";    
    mysqli_query( $db_generator1, $sql);	
    $sql = "INSERT INTO `generator_v4_cpu` (`seria`, `nastepna`, `max_serii`, `ilosc_wu`) VALUES ( "."\"".str_pad($seria_przedrostek, 6, 0, STR_PAD_LEFT).$seria_znak."\"".", "."\"1\", "."\"".$max_serii."\"".", "."\"".$ilosc_wu."\"".");";    
    mysqli_query( $db_generator1, $sql);
   }
      
}
  
  mysqli_close($db_generator1);


  echo "KONIEC MONKEYS_VX_DB_SERIE\n";


?>

