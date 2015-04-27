<?php
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: index.php");
	}	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Administrator Page</title>
	</head>
	<body>
	<!--Add ranking score-->
	<button type="button" >Add ranking scores</button><br>
	<!--Assign TA to course-->
	<button type="button">Assign TA(s) to course(s)</button><br>
	<!--insert course-->
	<button type="button" onclick="window.location.href='adminActions/semester.php'">Add a new semester</button><br>
	<button type="button" onclick="window.location.href='adminActions/addprofessor.php'">Add a new professor</button><br>
	</body>
</html>
