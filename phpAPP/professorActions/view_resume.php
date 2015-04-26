<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username'])){
		header("Location: ..\index.php");
	}

	$username = $_SESSION['username'];	
	//get student username		
	$username3 = $_GET['username2'];
	//echo "username is: ".$username3;
	//echo "logged in as".$_SESSION['username'];

	//connect to database
		include("../../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());

	//search for resume for this student 
	pg_prepare($dbconn,"view_resume", "SELECT resume from DDL.is_an_applicant where username=$1")or die('error! ' . pg_last_error());
	$result1 = pg_execute($dbconn,"view_resume",array($username3));
	$result2= pg_fetch_array($result1)[0];  

	//search for first and last names of the applicant
	pg_prepare($dbconn,"search_name", "SELECT P.fname, P.lname FROM DDL.person P where P.username=$1") or die('error! ' . pg_last_error());
	$result = pg_execute($dbconn,"search_name",array($username3));
	$name=pg_fetch_array($result);
	$whole_name = $name['fname']." ".$name['lname'];

	//if resume not found
	if($result2 == "") {
		echo "<b>".$whole_name."<b>"." has not submitted a resume."."<br/>"."<br/>";
	}

	//if resume found
	else {
		echo $result2;			
	}

	pg_close($dbconn);

?>


<html>
<body>
	<form method="POST" action="..\professor_page.php">
				
		<input type="submit" name="professor_page" value="Go back to homepage" ></input>
		
	</form>

</body>
</html>
