<?php


include("test/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect: ' . pg_last_error());
		if(strcmp($_GET[action],"add")==0){
			pg_prepare($dbconn,"add", "UPDATE DDL.applicant_applies_for_semester set ta_rank=$1 where semester=$2 AND username=$3") or die('error! ' . pg_last_error());
			$result = pg_execute($dbconn,"add",array($_GET[rank],$_GET[semester],$_GET[applicant]))or die('error! ' . pg_last_error());

		}
		$returnObject=array();
		pg_prepare($dbconn,"search_name", "SELECT P.username, P.fname, P.lname FROM DDL.Person P JOIN DDL.applicant_applies_for_semester aafs Using(username) where aafs.ta_rank IS NULL AND aafs.semester='FS15'") or die('error! ' . pg_last_error());
		$result = pg_execute($dbconn,"search_name",array())or die('error! ' . pg_last_error());
		while( $name = pg_fetch_array($result, null, PGSQL_ASSOC)){
			array_push($returnObject, array("username"=>$name[username], "fname"=>$name['fname'],"lname"=>$name['lname']));
			// 	foreach( $name as $col_value ){
			// 			echo "\t\t$col_value &nbsp\n";
			// 	}
			// 	echo "\t<br>\n";
			// }
			// while ($result->fetch()) {
			// array_push($returnObject, array("House_number"=>$houseNumber, "Suite"=>$suiteNumber,"Street"=>$street,"city"=>$city,"Zipcode"=>$zipcode));
			//printf ("houseNumber: %s suiteNumber: %s street: %s city: %s zipcode: %s\n <br>", $houseNumber, $suiteNumber, $street, $city, $zipcode);
	    }
    	echo json_encode($returnObject);
	    pg_close($dbconn);
?>