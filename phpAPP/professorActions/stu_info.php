<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username'])){
		header("Location: ..\index.php");
	}

		$username3 = $_GET['username2'];

	//connect to database
		include("../../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect: ' . pg_last_error());

	//need to add the link to the student application form summary here:






	pg_close($dbconn);

?>


<html>
<body>
	<form method="POST" action="..\professor_page.php">
				
		<input type="submit" name="professor_page" value="Go back to homepage" ></input>
		
	</form>

</body>
</html>

