<!DOCTYPE html>
<html>
<head>	
	<title>CS4320 - Group G</title>
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<script src="../../js/jquery-1.11.2.min.js"></script>
</head>
<body>
	<!-- Header/Footer -->

		<div class="header shadowheader">
			<h1>Request TA</h1>
		</div>

		<div class="footer shadowfooter">
			<h4>Copyright &copy; Group G - Computer Science Department</h4>
		</div>
		
	<!-- Close Window -->
			
		<div align="center">
			<br><br>
			<input type="button" value="Close this window" onclick="self.close()">
			<br><br>
		</div>
<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "prof"){
		header("Location: ../../index.php");
	}

	$username = $_SESSION['username'];	
	//get student username		
	$username3 = $_GET['username2'];
			//connect to database

	include("../../connect/database.php");
		//if cannot connect return error
	$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());
	$semeterresult=pg_query($dbconn,'SELECT name FROM DDL.Semester WHERE facultystart<current_date AND facultyend>current_date')or die('error4 ' . pg_last_error());
	$semester = pg_fetch_array($semeterresult, null, PGSQL_ASSOC);

	if(!isset($semester[name])){
		header("Location: ../../index.php");
	}

	//search for the applicant to request    
	pg_prepare($dbconn,"search_TA", "SELECT ta_username from DDL.professor_wants_ta where ta_username=$1 and professor=$2")or die('error! ' . pg_last_error());
	$result1 = pg_execute($dbconn,"search_TA",array($username3, $username));
	$result2= pg_fetch_array($result1)[0];

	//retrieve first and last names of the applicant	
	pg_prepare($dbconn,"search_name", "SELECT P.fname, P.lname FROM DDL.person P where P.username=$1") or die('error! ' . pg_last_error());
	$result = pg_execute($dbconn,"search_name",array($username3));
	$name=pg_fetch_array($result);
	$whole_name = $name['fname']." ".$name['lname'];
	
	echo "<div align=\"center\">";
	//if has not request this applicant
	if($result2[ta_username] != $username3) {
		pg_prepare($dbconn,"insert_requestTA",'INSERT INTO DDL.professor_wants_ta values ($1,$2,$3)')or die('error! ' . pg_last_error());
		$result3 = pg_execute($dbconn,"insert_requestTA",array($username3, $username,$_GET[course]));
		echo "You have successfully requested "."<b>".$whole_name."</b>"." as your TA."."<br/>"."<br/>";
	}

	//if already requested this applicant
	elseif ($result2 == $username3){
		echo "You have already requested "."<b>".$whole_name."</b>"." as your TA."."<br/>"."<br/>";
	}
	echo "</div>";
	pg_close($dbconn);
?>
</body>
</html>