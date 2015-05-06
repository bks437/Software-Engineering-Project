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
			<h1>Add a Professor</h1>
		</div>

		<div class="footer shadowfooter">
			<h4>Copyright &copy; Group G - Computer Science Department</h4>
		</div>
			
	<br><br><br>
<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: ../../index.php");
	}

	$username = $_SESSION['username'];
	//connect to database
	include("../../connect/database.php");
	//if cannot connect return error
	$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());

	//get student username
	$username3 = $_GET['username2'];

	pg_prepare($dbconn, 'name', "SELECT P.fname, P.lname FROM DDL.person P where P.username=$1")or die('error! ' . pg_last_error());
	$full_name = pg_execute($dbconn, 'name', array($username3));
	while($name=pg_fetch_array($full_name)){
		$fname = $name['fname'];
		$lname = $name['lname'];
	}

	pg_prepare($dbconn, 'comments', "SELECT * FROM DDL.comments where comments.ta_username=$1")or die('error! ' . pg_last_error());
	$result = pg_execute($dbconn, 'comments', array($username3));

	if($result == false) {

		echo "<div align=\"center\">Some error has occured!</div><br><br>";

	}


	elseif (pg_num_rows($result) ==0) {
		echo "<div align=\"center\"><b>".$fname." ".$lname."</b> has no comments yet!</div><br><br>";
	}

	else{
		while($row = pg_fetch_array($result)) {
			$username = $row['ta_username'];
			$professor =$row['professor'];
			$comments = $row['comment'];
			echo "<b>".$fname." ".$lname."</b> has a comment given by <b>".$professor."</b>: ".$comments.".<br><br>";
		}
	}
	pg_close($dbconn);
?>
	<div align="center">
		<input type="button" value="Close this window" onclick="self.close()">
	</div>
</body>
</html>