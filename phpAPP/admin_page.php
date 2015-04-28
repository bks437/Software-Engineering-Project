<?php
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: ../../index.php");
	}	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Administrator Page</title>
	</head>
	<body>
		<!--Add ranking score-->
		<form method="POST" action="adminActions/add_rank.php">	
			<button type="submit" name="addrank" value="add rank scores">Add ranking scores</button>
			<br>
			<br>
			<br>
		</form>

		<!--Assign TA to course-->
		<form method="POST" action="adminActions/assign_ta.php">	
			<button type="submit" name="assignTA" value="assign TA">Assign TA(s) to course(s)</button>
			<br>
			<br>
			<br>
		</form>

		<!--insert course-->
		<form method="POST" action="adminActions/addcourses.php">	
			<button type="submit" name="addCourse" value="add new course">Add new course</button>
			<br>
			<br>
			<br>
		</form>

		<button type="button" onclick="window.location.href='adminActions/semester.php'">Add a new semester</button>
			<br>
			<br>
			<br>

		<button type="button" onclick="window.location.href='adminActions/addprofessor.php'">Add a new professor</button>
			<br>
			<br>
			<br>
		<button type="button" onclick="window.location.href='../../phpSQL/home.php'">Add a new professor</button>
	</body>
</html>
