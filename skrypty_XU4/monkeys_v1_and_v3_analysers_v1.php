<?php

  echo "START MONKKES_V1_ANALYSERS\n";
  include( "monkeys_katalogi.php" );  
  system( "php ".$katalog_domowy."/monkeys_v1_and_v3_analyser.php v1 6" );
  system( "php ".$katalog_domowy."/monkeys_v1_and_v3_analyser.php v1 7" );
  system( "php ".$katalog_domowy."/monkeys_v1_and_v3_analyser.php v1 8" );
  system( "php ".$katalog_domowy."/monkeys_v1_and_v3_analyser.php v1 9" );
  system( "php ".$katalog_domowy."/monkeys_v1_and_v3_analyser.php v1 10" );
  system( "php ".$katalog_domowy."/monkeys_v1_and_v3_analyser.php v1 11" );
  system( "php ".$katalog_domowy."/monkeys_v1_and_v3_analyser.php v1 12" );
  system( "php ".$katalog_domowy."/monkeys_v1_and_v3_analyser.php v1 13" );
  echo "KONIEC MONKKES_V1_ANALYSERS\n";

?>