<?php

	include( "monkeys_db_projekt.php" );

	$db_projekt = new mysqli($db_projekt_serwer, $db_projekt_user, $db_projekt_haslo, $db_projekt_baza, $db_projekt_port);
	if ($db_projekt->connect_error)
	{
		die("Błąd połaczenia db_projekt: ".$db_projekt->connect_error);
	}
  
  
	function ResutlNameToUserName( $resultName )
	{	
		global $db_projekt;
	
		$userId = "";
		$userName = "";
	
		$sql_result = "SELECT `userid` FROM `result` where `server_state` = 5 AND `client_state` = 5 AND `name` LIKE '".$resultName."%'";
//echo $sql_result."\n";
		$resultDB_userId = $db_projekt->query($sql_result);
//echo $resultDB_userId->num_rows."\n";
		
		if ($resultDB_userId->num_rows > 0) 
		{
			$result_userId = $resultDB_userId->fetch_assoc();
			$userId = $result_userId["userid"];
			$resultDB_userId->free(); 
		}
//echo $userId."\n";
		
		if ($userId !== "") {
			$sql_user = "SELECT `name` from `user` where `id` = '".$userId."'";
//echo $sql_user."\n";
			$resultDB_userName = $db_projekt->query($sql_user);
			
			if ($resultDB_userName->num_rows > 0) 
			{
				$result_userName = $resultDB_userName->fetch_assoc();
				$userName = $result_userName["name"];
				$resultDB_userName->free(); 
			}			
		}
		
		return $userName;
	}
  

//echo time()."\n";		
//	echo ResutlNameToUserName("monkeys_v4_000051S.1-CHRISTMAS_011290_100000")."\n";
//echo time()."\n";		
?>