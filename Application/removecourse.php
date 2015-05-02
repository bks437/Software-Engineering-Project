<?php
	sleep(3);
	session_start();

	//connect to database
	//include("../connect/database.php");
	include("test/database.php");

	//if cannot connect return error
	$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
			or die('Could not connect: ' . pg_last_error());
	$result=false;
	if(strcmp($_GET[action],"Taught")==0){
		pg_prepare($dbconn,"TaughtRemove",'DELETE FROM DDL.has_taught AS ht WHERE ht.ta_username = $1 AND ht.c_id = $2');
		$result = pg_execute($dbconn,"TaughtRemove",array($_SESSION[username],$_GET[course]));
	}
	elseif(strcmp($_GET[action],"Teaching")==0){
		pg_prepare($dbconn,"TeachingRemove",'DELETE FROM DDL.are_teaching AS at WHERE at.ta_username = $1 AND at.c_id = $2');
		$result = pg_execute($dbconn,"TeachingRemove",array($_SESSION[username],$_GET[course]));
	}
	elseif(strcmp($_GET[action],"Wants")==0){
		pg_prepare($dbconn,"WantsRemove",'DELETE FROM DDL.wants_to_teach AS wtt WHERE wtt.ta_username = $1 AND wtt.c_id = $2');
		$result = pg_execute($dbconn,"WantsRemove",array($_SESSION[username],$_GET[course]));
	}
	if(!$result)
		echo json_encode($_GET[action]." Remove failed ".pg_last_error());
	else
		echo json_encode(0);
	pg_close($dbconn);
?>