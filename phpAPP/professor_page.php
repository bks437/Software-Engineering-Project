<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username'])){
		header("Location: index.php");
	}	
	//if data has been submitted

	//if searching using course number
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
					echo "<td><b>Student UserName</b></td>";
					echo "<td><b>Student Info</b></td>";
					echo "<td><b>Add Comments</b></td>";
					echo "<td><b>View Resume</b></td>";
					echo "<td><b>Request this applicant as TA</b></td>";
					
				echo "</tr>";

			$i=1;
			while($row = pg_fetch_array($result)) {
				$student = $row['ta_username'];
				echo "<tr>";
					echo "<td>$student</td>";
					echo "<td><a href=\"stu_info.php?ta_username=Value\">Student Info</a></td>";
					echo "<td><a href=\"add_comment.php?ta_username=Value\">Add Comments</a></td>";
					echo "<td><a href=\"view_resume.php?ta_username=Value\">View Resume</a></td>";
					echo "<td><a href=\"request_as_ta.php?ta_username=Value\">Request as TA</a></td>";
				echo "</tr>";	
			$i++; 									
			}	
		}

	}	


	//if search by applicant name
	if (isset($_POST['ASearch'])) {

		//connect to database
		include("../phpSQL/test/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());

		//find applicant userID based on provided first name and/or last name;
		if($_POST['applicant_fName']) {

			//if both first name and last name are searched
			if($_POST['applicant_lName']) {

				$applicant_fName = $_POST['applicant_fName'];
				$applicant_lName = $_POST['applicant_lName'];
				$username_find = "SELECT P.username from DDL.person P where lower(P.fname) = lower('$applicant_fName') AND lower(P.lname) = lower('$applicant_lName');";
				$result= pg_query($dbconn, $username_find)or die('error! ' . pg_last_error());
			
			}

			//if only first name is searched
			else {

				$applicant_fName = $_POST['applicant_fName'];
				$username_find = "SELECT P.username from DDL.person P where lower(P.fname) = lower('$applicant_fName');";
				$result= pg_query($dbconn, $username_find)or die('error! ' . pg_last_error());
			}
		}

		//if only last name is searched
		elseif ($_POST['applicant_lName']){
				$applicant_lName = $_POST['applicant_lName'];
				$username_find = "SELECT P.username from DDL.person P where lower(P.lname) = lower('$applicant_lName');";
				$result= pg_query($dbconn, $username_find)or die('error! ' . pg_last_error());
				
		}	
		else{
			$result = false;
			echo "Wrong! Both first name and last name can not be empty!".'<br/><br/><br/>';
		}


		if ($result == false) {
			$_SESSION['form_search']=false;
		}	
		else {

			if(pg_num_rows($result)!=0) {

				$search_result = pg_fetch_array($result)[0];
					echo "username is:".$search_result.'<br/>';
					echo "arrar size is:".(pg_num_rows($result)).'<br/>';

				//find courseIDs wanted by the TA searched for;
				$query = "SELECT wtt.c_id FROM DDL.wants_to_teach wtt  where wtt.ta_username = '$search_result' ORDER by c_id;";
				$result= pg_query($dbconn, $query)or die('error! ' . pg_last_error());
		
				//display result in tables with link to course info;
				echo "<table border ='1'>";
					echo "<tr>";
						echo "<td>Course ID</td>";
						echo "<td>Course Info</td>";

					echo "</tr>";

				$num_rows = pg_num_rows($result);
				echo "number of rows:".$num_rows;
				$i=1;
				while($row = pg_fetch_array($result)) {
					$course = $row['c_id'];
					echo "<tr>";
						echo "<td>$course</td>";
						echo "<td><a href=\"#\">Course Info</td>";
					echo "</tr>";	
				}
			}		

			else{
				echo "No matching data found!";
			}
		}	

	}
		
	//go to home page
	if (isset($_POST['homepage'])) {
		header("Location: ../phpSQL/homepage.php");
	}

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
				<label for="applicantName" > Enter the name of applicant you would like to search: </label>
				<input type="text" name="applicant_fName" id="applicantSearch" placeholder = "John"></input><br>
				<input type="text" name="applicant_lName" id="applicantSearch" placeholder = "Doe"></input><br>
				<button type="submit" name="ASearch" value="search by applicant">Applicant Search</button>
		</div>
		<!--comment on applicants of their choosing
					button in generated table to add to comment of person-->

		 <!-- Go to homepage -->

		<div >
				<label for="homepage">Go to home page</label><br>

				<input type="submit" name="homepage" value="Go to home page"></input>
		
		</div>	


	</body>
</html>
