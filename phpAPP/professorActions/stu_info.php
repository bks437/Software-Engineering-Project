<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "prof"){
		header("Location: ../../index.php");
	}

		$username = $_SESSION['username'];	
		$username3 = $_GET['username2'];

	//connect to database
		include("../../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect: ' . pg_last_error());

	//need to add the link to the student application form summary here:

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

	$info_table = "<b>Basic Information</b></br>"; 
	$info_table .= "<table  border='1px' width='400px'>";
	$info_table .= "<tr align='center'><td>user name</td><td>".$username3."</td>";
	$info_table .= "<tr align='center'><td>name</td><td>".$name['fname']." ".$name['lname']."</td></tr>";
	$info_table .= "<tr align='center'><td>id</td><td>".$basic['id']."</td></tr>";
	$info_table .= "<tr align='center'><td>gpa</td><td>".$basic['gpa']."</td>";
	$info_table .= "<tr align='center'><td>grad date</td><td>".$basic['grad_date']."</td></tr>";
	$info_table .= "<tr align='center'><td>email</td><td>".$basic['email']."</td></tr>";
	$info_table .= "<tr align='center'><td>phone</td><td>".$basic['phone']."</td></tr>";
	$info_table .= "<tr align='center'><td>gato status</td><td>".$basic['gato']."</td></tr>";
	$info_table .= "<tr align='center'><td>employer</td><td>".$basic['employer']."</td></tr>";
	$info_table .= "<tr align='center'><td>ta_rank</td><td>".$basic['ta_rank']."</td></tr>";
	$info_table .= "</table><br/>";

	$info_table .= "<b>International Information</b></br>"; 	
	$info_table .= "<table  border='1px' width='400px'>";
	$info_table .= "<tr align='center'><td>speak taken</td><td>".$inter['speak_taken']."</td></tr>";
	$info_table .= "<tr align='center'><td>test score</td><td>".$inter['speak']."</td></tr>";
	$info_table .= "<tr align='center'><td>test date</td><td>".$inter['test_date']."</td></tr>";
	$info_table .= "<tr align='center'><td>onita</td><td>".$inter['onita']."</td></tr>";
	$info_table .= "</table><br/><br/>";

	$info_table .= "<b>Wants To Teach</b></br>"; 
	$info_table .= "<table border='1px' width='400px'>";
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

	$info_table .= "<b>Is Teaching</b></br>"; 
	$info_table .= "<table border='1px' width='400px'>";
	$info_table .= "<tr align='center'><td><b>Course</b></td><td><b>grade</b></td></tr>";
	while ($at = pg_fetch_array($result5)) {
		$cId = $wtt['c_id'];
		$courses = pg_query($dbconn, "SELECT * FROM DDL.course where c_id=$cId") or die('error5 '.$cId . pg_last_error());
			while($course=pg_fetch_array($courses)){
				$courseNumb = $course['numb'];
			}
		$info_table .= "<tr align='center'><td>".$courseNumb."</td>";//<td>".$at['grade']."</td></tr>";
	}
	$info_table .= "</table><br/><br/>";

	$info_table .= "<b>Has Taught</b></br>"; 
	$info_table .= "<table border='1px' width='400px'>";
	$info_table .= "<tr align='center'><td><b>Course</b></td><td><b>grade</b></td></tr>";
	while ($ht = pg_fetch_array($result6)) {
		$cId = $wtt['c_id'];
		$courses = pg_query($dbconn, "SELECT * FROM DDL.course where c_id=$cId") or die('error6 '.$cId . pg_last_error());
			while($course=pg_fetch_array($courses)){
				$courseNumb = $course['numb'];
			}
		$info_table .= "<tr align='center'><td>".$courseNumb."</td>";//<td>".$ht['grade']."</td></tr>";
	}
	$info_table .= "</table><br/><br/>";

	echo $info_table."<br/>";
	pg_close($dbconn);

?>

<html>
<body>
	<form method="POST" action="..\professor_page.php">
				
		<input type="submit" name="professor_page" value="Go back to homepage" ></input>
		
	</form>

</body>
</html>

