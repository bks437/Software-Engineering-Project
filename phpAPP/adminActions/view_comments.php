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

		echo "Some error has occured!<br><br>";

	}


	elseif (pg_num_rows($result) ==0) {
		echo "<b>".$fname." ".$lname."</b> has no comments yet!<br><br>";
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

<html>
<body>
	<input type="button" value="Close this window" onclick="self.close()">

</body>
</html>
