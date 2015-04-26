<?php
	session_start();
	//Redirect if user is not logged in to login page
	// if(!isset($_SESSION['username'])){
	// 	header("Location: index.php");
	// }	
	//connect to database
		include("../../connect/database.php");
	//if cannot connect return error
	if(isset($_POST[create])){
		//echo $_POST[semester].$_POST[year];
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());
		pg_prepare($dbconn,"Semester",'INSERT INTO DDL.Semester VALUES ($1,$2,$3,$4,$5)');
		$result=pg_execute($dbconn,"Semester",array($_POST[semester].$_POST[year],$_POST[studentstart],$_POST[studentend],$_POST[facultystart],$_POST[facultyend]));
		if(!$result){
			echo "failed";
		}
		else{
			$_SESSION[semester]= $_POST[semester].$_POST[year];
			header("Location: semestercourses.php");
		}

	}
?>			

<!DOCTYPE html>
<html>
	<head>
		<title>Add Semester</title>
		<link rel="stylesheet" type="text/css" href="../css/style.css">		
		<script src="../js/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="../js/javascript.js"></script>
	</head>
	<body>
		<form action="#" method="POST">
			<label class="leftlabel">Which semester is this for?</label><br>
			<input type="radio" name="semester" value="fs" id="fall" checked>Fall</input>
			<input type="radio" name="semester" value="sp" id = "spring">Spring</input>
			<input type="radio" name="semester" value="su" id="summer">Summer</input><br>
			<label class="leftlabel">Which year?</label><br>
			<input type="radio" name="year" value=<? echo "\"".date("y")."\"";?> id="thisyear" checked><? echo date("y");?></input>
			<input type="radio" name="year" value=<? echo "\"".(date("y")+1)."\"";?> id="nextyear"><? echo date("y")+1;?></input><br>
			<label class="leftlabel">When can students start to apply for this semester?</label>
			<input type="date" name="studentstart"><br>
			<label class="leftlabel">When is the last day for students to apply?</label>
			<input type="date" name="studentend"><br>
			<label class="leftlabel">When can faculty view applications for this semester?</label>
			<input type="date" name="facultystart" required><br>
			<label class="leftlabel">When is the last day for faculty to view applications?</label>
			<input type="date" name="facultyend"><br>
			<input type="submit" name="create" value="Create Semester">
		</form>

	</body>
</html>
