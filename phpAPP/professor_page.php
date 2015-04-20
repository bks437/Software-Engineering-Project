<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username'])){
		header("Location: index.php");
	}	
	//if data has been submitted

	//if searching using course number
	if(isset($_POST['CSearch'] )){


	if(isset($_POST['CSearch'] )){

		//connect to database
		include("../phpSQL/test/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());


		$courseNumb = $_POST['courseNumb'];

		//find applicants who want to teach this course
		$query = "SELECT wtt.ta_username FROM DLL.wants_to_teach wtt where wtt.c_id =$courseNumb ORDER by ta_username;";
		$result = pg_query($dbconn, $query)or die('error! ' . pg_last_error());

		if ($result == false) {
			$_SESSION['form_search']=false;
		}
		else {

			//display results in tables with link to student info and to add comments;
			echo "<table border ='1'>";
				echo "<tr>";
					echo "<td><b>Student Name</b></td>";
					echo "<td><b>Student Info</b></td>";
					echo "<td><b>Add Comments</b></td>";
					
				echo "</tr>";

			$i=1;
			while($row = pg_fetch_array($result)) {
				$student = $row['ta_username'];
				echo "<tr>";
					echo "<td>$student</td>";
					echo "<td><a href=\"#\">Student Info</td>";
					echo "<td><a href=\"#\">Add Comments</td>";
				echo "</tr>";	

			$i++; 								
			}	
		}

	}	


	//if search by applicant name
	elseif (isset($_POST['ASearch'])) {

		//connect to database
		include("../phpSQL/test/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());

		//find applicant userID based on provided name;
		$applicantName = $_POST['applicantName'];

		// need to work this out using a full name
		$username_find = "SELECT P.username from DLL.person P where P.fname = '$applicantName';"; 
		$result= pg_query($dbconn, $username_find)or die('error! ' . pg_last_error());

		//find courseIDs wanted by the TA searched for;
		$query = "SELECT wtt.c_id FROM DLL.wants_to_teach wtt  where wtt.ta_username = '$result' ORDER by c_id;";
		$result= pg_query($dbconn, $query)or die('error! ' . pg_last_error());
		
		if ($result == false) {
			$_SESSION['form_search']=false;
		}
		else {

			//display result in tables with link to course info;
			echo "<table border ='1'>";
				echo "<tr>";
					echo "<td>Course ID</td>";
					echo "<td>Course Info</td>";

				echo "</tr>";

			$i=1;
			while($row = pg_fetch_array($result)) {
				$course = $row['c_id'];
				echo "<tr>";
					echo "<td>$course</td>";
					echo "<td><a href=\"#\">Course Info</td>";
				echo "</tr>";	

			$i++; 								
			}	
		}
	}
	

//	else {
//		header("Location: professor_page.php");
//		pg_close($dbconn);	
//	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Professor Page</title>
</head>
<body>

	<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
		<!--request TA for course
				button in generated table to enter entry into request table-->
		<!--view all TA applicants base on selected parameters
				code below-->
		<div>
				<label for="courseNumb" > Enter the course number you would like to see TA applicants: </label>
				<input type="text" name="courseNumb" id="courseSearch" placeholder = "CS1050"></input><br>
				<button type="submit" name="CSearch" value="search by course">Course Search</button>
		</div>
		<div>
				<label for="applicantName" > Enter the course you would like to see TA applicants: </label>
				<input type="text" name="applicantName" id="applicantSearch" placeholder = "John Doe"></input><br>
				<button type="submit" name="ASearch" value="search by applicant">Applicant Search</button>
		</div>
		<!--comment on applicants of their choosing
					button in generated table to add to comment of person-->
	</body>
</html>
