<?php

	session_start();
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: index.php");
	}	
		//connect to database
	include("../../connect/database.php");
	//if cannot connect return error
	$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
			or die('Could not connect: ' . pg_last_error());
	$result=false;
	if(strcmp($_GET[action],"add")==0){
		pg_prepare($dbconn,"Taught",'INSERT INTO DDL.semester_has_class VALUES ($1,$2)');
		$result = pg_execute($dbconn,"Taught",array($_SESSION[semester],$_GET[course]));
	if(!$result)
		if (strpos(pg_last_error(), 'exists') !== FALSE)
			echo 0;
		else echo 1;
	else
		echo 0;
	}
	elseif(strcmp($_GET[action],"remove")==0){
		pg_prepare($dbconn,"remove",'DELETE FROM DDL.semester_has_class shc where  shc.semester = $1 AND shc.c_id=$2');
		$result = pg_execute($dbconn,"remove",array($_SESSION[semester],$_GET[course]));
		if(!$result)
		if (strpos(pg_last_error(), 'exists') !== FALSE)
			echo 0;
		else echo 1;
	else
		echo 0;
	}

	pg_close($dbconn);
?>