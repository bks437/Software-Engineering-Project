<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: ../../index.php");
	}

	//$username = $_SESSION['username'];
	$username3 = $_GET['username2'];

	//connect to database
	$username = $_SESSION['username'];
	//connect to database
	include("../../connect/database.php");
	//if cannot connect return error
	$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());

	//retrieve first and last names of applicant
	pg_prepare($dbconn,"search_name", "SELECT P.fname, P.lname FROM DDL.person P where P.username=$1") or die('error! ' . pg_last_error());
	$result1 = pg_execute($dbconn,"search_name",array($username3));
	$name=pg_fetch_array($result1);

	//basic data
	pg_prepare($dbconn, "info", 'SELECT * from DDL.is_an_applicant where username=$1')or die(pg_last_error($dbconn));
	$result2 =pg_execute($dbconn, "info", array($username3));
	$basic=pg_fetch_array($result2);

	//international data
	pg_prepare($dbconn, "inter", 'SELECT * from DDL.is_international where username=$1')or die(pg_last_error($dbconn));
	$result3 =pg_execute($dbconn, "inter", array($username3));
	$inter=pg_fetch_array($result3);

	//course data
	pg_prepare($dbconn, "wtt", 'SELECT * from DDL.wants_to_teach where ta_username=$1')or die(pg_last_error($dbconn));
	$result4 =pg_execute($dbconn, "wtt", array($username3));

	pg_prepare($dbconn, "at", 'SELECT * from DDL.are_teaching where ta_username=$1')or die(pg_last_error($dbconn));
	$result5 =pg_execute($dbconn, "at", array($username3));

	pg_prepare($dbconn, "it", 'SELECT * from DDL.has_taught where ta_username=$1')or die(pg_last_error($dbconn));
	$result6 =pg_execute($dbconn, "it", array($username3));

		$info_table = "<p align='center'><b>Basic Information</b></p></br>";
		$info_table .= "<table align='center' border='1px' width='400px'>";
		$info_table .= "<tr align='center'><td>user name</td><td>".$username3."</td>";
		$info_table .= "<tr align='center'><td>name</td><td>".$name['fname']." ".$name['lname']."</td></tr>";
		$info_table .= "<tr align='center'><td>id</td><td>".$basic['id']."</td></tr>";
		$info_table .= "<tr align='center'><td>email</td><td>".$basic['email']."</td></tr>";
		$info_table .= "<tr align='center'><td>phone</td><td>".$basic['phone']."</td></tr>";
		$info_table .= "<tr align='center'><td>gpa</td><td>".$basic['gpa']."</td>";
		$info_table .= "<tr align='center'><td>grad date</td><td>".$basic['grad_date']."</td></tr>";
		$info_table .= "<tr align='center'><td>gato status</td><td>".$basic['gato']."</td></tr>";
		$info_table .= "<tr align='center'><td>employer</td><td>".$basic['employer']."</td></tr>";
		$info_table .= "<tr align='center'><td>ta_rank</td><td>".$basic['ta_rank']."</td></tr>";

	if($inter['username'] !=""){
		$info_table .= "<tr align='center'><td>international</td><td>"."y"."</td></tr>";
		$info_table .= "</table><br/>";

		$info_table .= "<p color='orange'align='center'><b>International Information</b></p></br>";
		$info_table .= "<table  align='center' border='1px' width='400px' >";
		$info_table .= "<tr align='center'><td>speak taken</td><td>".$inter['speak_taken']."</td></tr>";
		$info_table .= "<tr align='center'><td>test score</td><td>".$inter['speak']."</td></tr>";
		$info_table .= "<tr align='center'><td>test date</td><td>".$inter['test_date']."</td></tr>";
		$info_table .= "<tr align='center'><td>onita</td><td>".$inter['onita']."</td></tr>";
		$info_table .= "</table><br/><br/>";
	}

	else {
		$info_table .= "<tr align='center'><td>international</td><td>"."n"."</td></tr>";
		$info_table .= "</table><br/>";
	}


		$info_table .= "<p  align='center'><b>Wants To Teach</b></p></br>";
		$info_table .= "<table  align='center' border='1px' width='400px'>";
		$info_table .= "<tr align='center'><td><b>Course</b></td><td><b>grade</b></td></tr>";
	while ($wtt = pg_fetch_array($result4)) {
		$cId = $wtt['c_id'];
		$courses = pg_query($dbconn, "SELECT * FROM DDL.course where c_id=$cId") or die('error4 ' . pg_last_error());

			while($course=pg_fetch_array($courses)){
				$courseNumb = $course['numb'];
			}
		$info_table .= "<tr align='center'><td>".$courseNumb."</td><td>".$wtt['grade']."</td></tr>";
	}
		$info_table .= "</table><br/><br/>";

		$info_table .= "<p  align='center'><b>Is Teaching</b></p></br>";
		$info_table .= "<table  align='center' border='1px' width='400px'>";
		$info_table .= "<tr align='center'><td><b>Course</b></td></tr>";
	while ($at = pg_fetch_array($result5)) {
		$cId = $at['c_id'];
		$courses = pg_query($dbconn, "SELECT * FROM DDL.course where c_id=$cId") or die('error5 '.$cId . pg_last_error());
			while($course=pg_fetch_array($courses)){
				$courseNumb = $course['numb'];
			}
		$info_table .= "<tr align='center'><td>".$courseNumb."</td>";//<td>".$at['grade']."</td></tr>";
	}
		$info_table .= "</table><br/><br/>";

		$info_table .= "<p  align='center'><b>Has Taught</b></p></br>";
		$info_table .= "<table  align='center' border='1px' width='400px'>";
		$info_table .= "<tr align='center'><td><b>Course</b></td></tr>";
	while ($ht = pg_fetch_array($result6)) {
		$cId = $ht['c_id'];
		$courses = pg_query($dbconn, "SELECT * FROM DDL.course where c_id=$cId") or die('error6 '.$cId . pg_last_error());
			while($course=pg_fetch_array($courses)){
				$courseNumb = $course['numb'];
			}
		$info_table .= "<tr align='center'><td>".$courseNumb."</td>";//<td>".$ht['grade']."</td></tr>";
	}
		$info_table .= "</table><br/><br/>";

	//echo $info_table."<br/>";
	pg_close($dbconn);

?>

<html>
<head>	
	<title>CS4320 - Group G</title>
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<script src="../../js/jquery-1.11.2.min.js"></script>
</head>
<body>
	<!-- Header/Footer -->

		<div class="header shadowheader">
			<h1>Student Info</h1>
		</div>

		<div class="footer shadowfooter">
			<h4>Copyright &copy; Group G - Computer Science Department</h4>
		</div>
		
		<?
			echo $info_table."<br/>";
		?>
		
		<div align='center'>
			<input type="button" value="Close this window" onclick="self.close()">
			<br>
			<br>
		</div>
</body>
</html>
