<?php
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: ../index.php");
	}	
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Administrator Page</title>
	</head>
	<body align='center'>
		
		<form method="POST" action="adminActions/search.php">	
				<br/>
				<br/>
				<br/>
			<div align='center'> 
				
			 	<button type="submit" name="view_all" value="view all">View all applicants/courses</button><br>
			</div>
				<br/>
				<br/>
			<div align='center'>
				
				<input type="text" name="courseNumb" id="courseSearch" placeholder = "CS1050"></input><br>
				<button type="submit" name="CSearch" value="search by course">Course Search</button><br>
			</div>
				<br/>
				<br/>
			<div align='center'>
				
				<input type="text" name="applicant_fName" id="applicantSearch" placeholder = "first name"></input><br>
				<input type="text" name="applicant_lName" id="applicantSearch" placeholder = "last name"></input><br>
				<button type="submit" name="ASearch" value="search by applicant">Applicant Search</button><br>
			</div>
				<br/>
				<br/>
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
		<button type="button" onclick="window.location.href='../../phpSQL/logout.php'">Log out</button>
	</body>
</html>