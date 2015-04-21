<!DOCTYPE html>
<html>
	<head>
		<title>Resume</title>
	</head>
<body>	
	<?php
			session_start();

			//Redirect if user is not logged in to login page
			if(!isset($_SESSION['username'])){
				header("Location: index.php");
			}
			
			//connect to database
			include("test/database.php");
			//if cannot connect return error
			$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
					or die('Could not connect: ' . pg_last_error());
					
			if(isset($_POST['file'])){
				$resume = $_POST['resume'];

			$result = pg_prepare($dbconn, "upload", 'INSERT INTO DDL.is_an_applicant(resume) VALUES($1) WHERE username = $2');
			$result = pg_execute($dbconn, "upload", array($resume, $_SESSION['username']); 

			pg_close($dbconn);
	?>

	<br>
	<div align="center">
        <a href="logout.php">Click here to Logout</a><br>
	</div>

</body>
</html>
