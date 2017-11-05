<?php

  echo "START MONKKES_V3_ANALYSERS\n";
  include( "monkeys_katalogi.php" );  
  system( "php ".$katalog_domowy."/monkeys_v1_and_v3_analyser.php v3 6" );
  system( "php ".$katalog_domowy."/monkeys_v1_and_v3_analyser.php v3 7" );
  system( "php ".$katalog_domowy."/monkeys_v1_and_v3_analyser.php v3 8" );
  system( "php ".$katalog_domowy."/monkeys_v1_and_v3_analyser.php v3 9" );
  system( "php ".$katalog_domowy."/monkeys_v1_and_v3_analyser.php v3 10" );
  system( "php ".$katalog_domowy."/monkeys_v1_and_v3_analyser.php v3 11" );
  system( "php ".$katalog_domowy."/monkeys_v1_and_v3_analyser.php v3 12" );
  system( "php ".$katalog_domowy."/monkeys_v1_and_v3_analyser.php v3 13" );
  echo "KONIEC MONKKES_V3_ANALYSERS\n";

?>