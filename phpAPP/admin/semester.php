<!DOCTYPE html>
<html>
<head>
	<title>CS4320 - Group G</title>
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<script src="../../js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="../../js/courses.js"></script>
	<script src="../../js/ajax.js"></script>
</head>
<body>
	<!-- Header/Footer -->

		<div class="header shadowheader">
			<h1>Add Semester</h1>
		</div>

		<div class="footer shadowfooter">
			<h4>Copyright &copy; Group G - Computer Science Department</h4>
		</div>
<?php
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: index.php");
	}	
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
	<div class="centerplssemester">
		<br><br>
		<form action="#" method="POST">			
			<label class="floatleft">Which semester is this for?</label>
			<div class="floatright">
				<input type="radio" name="semester" value="fs" id="fall" checked>Fall</input>
				<input type="radio" name="semester" value="sp" id = "spring">Spring</input>
				<input type="radio" name="semester" value="su" id="summer">Summer</input>
				<br>
			</div>
				<br>
			<label class="floatleft">Which year?</label>
			<div class="floatright">
				<input type="radio" name="year" value=<? echo "\"".date("y")."\"";?> id="thisyear" checked><? echo date("y");?></input>
				<input type="radio" name="year" value=<? echo "\"".(date("y")+1)."\"";?> id="nextyear"><? echo date("y")+1;?></input>
			</div>
				<br><br>
			<label class="floatleft">When can students start to apply for this semester?</label>
			<input class="floatright" type="date" name="studentstart">
				<br><br>
			<label class="floatleft">When is the last day for students to apply?</label>
			<input class="floatright" type="date" name="studentend">
				<br><br>
			<label class="floatleft">When can faculty view applications for this semester?</label>
			<input class="floatright" type="date" name="facultystart" required>
				<br><br>
			<label class="floatleft">When is the last day for faculty to view applications?</label>
			<input class="floatright" type="date" name="facultyend">
				<br><br>
			<div align="center">
				<input type="submit" name="create" value="Create Semester">
			</div>
				<br>
				<br>
		</form>
	</div>
</body>
</html>
