<?php

//definicje array'ów
require_once("../inc/badges.inc");

//tworzenie tabeli z odznakami 
  
  echo "<!DOCTYPE html>";
  echo "<html>";
  
  echo "<head>";
  echo "<title>Badges list</title>";
  
  echo "<style>";
    
    echo "table, th, td {";
      echo "border: 1px solid black;";
      echo "border-collapse: collapse;";
      echo "text-align:center;";
    echo "}";
    echo "th, td {";
      echo "padding: 5px;";
      echo "text-align: middle;";
    echo "}";
    
    echo "table#t01 tr:nth-child(even) {";
      echo "background-color: #9999FF;";
    echo "}";
    echo "table#t01 tr:nth-child(odd) {";
      echo "background-color: #fff;";
    echo "}";   
    
  echo "</style>";
    
  echo "</head>";   // class=\"mainnav\">
  
  echo "<body>";
  
  $polozenie = "middle";  
  echo "<table align=\"center\" id=\"t01\">";
  
    echo "<caption>GoofyxGrid@home - Badges list</caption>";
	 echo "<tr>";	    
	    echo "<td><b>level</b></td>";
	    echo "<td><b>credits</b></td>";

  foreach ($badges_projects as $projekt) {
	    echo "<td><i>".$projekt["name"]."</i></td>";
  }
  
	 echo "</tr>";
  
  
  for ($i = 0; $i < count($badge_levels); $i++){
      echo "<tr>";	
	  $j = $i + 1;
	  $lvl = "Lvl.".$j;
	  echo "<td>".$lvl."</td>";
	  echo "<td>".$badge_level_names[ $i ]."</td>";
	  
	  foreach ($badges_projects as $projekt) {
	    $obrazek = "./img/".$projekt["short_name"].$badge_images[ $i ];
	    $tekst = $projekt["name"]." - ".$lvl;
	  
	    echo "<td><img align=\"middle\" src=".$obrazek." alt="."\"".$tekst."\""."></img></td>";
	  }	  
	  
      echo "</tr>"."\n";
  }



  
  echo "</table>";

  echo "</body>";
  echo "</html>";

  
page_tail();  

?>