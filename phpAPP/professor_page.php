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

		if(!$_POST['courseNumb']){
			$result = false;
			echo "Wrong! Course number can not be empty!".'<br/><br/><br/>';
		}
		
		else{

			$courseNumb = $_POST['courseNumb'];

			//find applicants who want to teach this course
			$search_username = "SELECT wtt.ta_username FROM DDL.wants_to_teach wtt where wtt.c_id =(SELECT C.c_id FROM DDL.course C where C.numb= $1)";
			pg_prepare($dbconn, 'namesearch', $search_username)or die('error! ' . pg_last_error());
			$result = pg_execute($dbconn, 'namesearch', array($courseNumb));

			if ($result == false) {
				$_SESSION['form_search']=false;
			}
			else {

				if(pg_num_rows($result)>0) {
					//display results in tables with link to student info and to add comments;
					$result_table = "<table align='center' border ='1'>";
						$result_table .= "<tr align='center'>";
						$result_table .= "<th width='150px'><b>First Name</b></a></th>";//<a href=\"".$_SERVER['PHP_SELF']."?sort=Student First Name\">
						$result_table .= "<th width='150px'><b>Last Name</b></th>";
						$result_table .= "<th width='150px'><b>Username</b></th>";
						$result_table .= "<th width='450px'><b>Actions</b></th>";
						$result_table .= "</tr>";

						$actions = '<a href="stu_info.php?username=Value">Student info</a> | <a href="add_comments.php?ta_username=Value">Add Comments</a> |
						<a href="view_resume.php?ta_username=Value">View Resume</a> | <a href="request_TA.php?ta_username=Value">Request as TA</a>';

						while($row = pg_fetch_array($result)) {
							$username = $row[0];
							$person = pg_query($dbconn, "SELECT P.fname, P.lname FROM DDL.person P where P.username='$username'");

							while($name=pg_fetch_array($person)){
								$fname = $name['fname'];
								$lname = $name['lname'];			
								$action = str_replace("Value", $username, $actions);

								$result_table .= "<tr align='center'>";
								$result_table .= "<td>$fname</td>";
								$result_table .= "<td>$lname</td>";
								$result_table .= "<td>$username</td>";
								$result_table .= "<td>&nbsp;$action</td>";
								$result_table .= "</tr>";	
							}				
						}	
					$result_table .= "</table></tr></tr>";
				}
				else{
					$result_table = "<p>No matching data found!</p>";
				}
			
				echo $result_table;
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
		if(!$_POST['applicant_lName'] and !$_POST['applicant_fName'] ){
			$result = false;
			echo "Wrong! Both first name and last name can not be empty!".'<br/><br/><br/>';
		}
		else {
		
			$applicant_fName = $_POST['applicant_fName'];
			$applicant_lName = $_POST['applicant_lName'];
			$username_find = "SELECT P.username from DDL.person P where lower(P.fname) = lower($1) OR lower(P.lname) = lower($2);";
			pg_prepare($dbconn, 'userfind',$username_find);
			$result= pg_execute($dbconn, 'userfind',array($applicant_fName,$applicant_lName))or die('error! ' . pg_last_error());
		}

		if ($result == false) {
			$_SESSION['form_search']=false;
		}	

		//if applicant found
		elseif(pg_num_rows($result)==1) {

				//get the applicant username	
				$search_result = pg_fetch_array($result)[0];

				//find courseIDs wanted by the applicant;
				$id_list = "SELECT wtt.c_id FROM DDL.wants_to_teach wtt where wtt.ta_username = $1";
				pg_prepare($dbconn, 'idsearch', $id_list)or die('error! ' . pg_last_error());
				$result=pg_execute($dbconn,'idsearch',array($search_result));

				if ($result == false) {
				$_SESSION['form_search']=false;
				}
				else {
					if(pg_num_rows($result)>0) {

						//display result in tables with link to course info;
						$result_table = "<table align='center' border ='1'>";
						$result_table .= "<tr align='center'>";
						$result_table .= "<td width='150px'><b>Course Number</b></td>";
						$result_table .= "<td width='450px'><b>Course Name</b></td>";
						$result_table .= "</tr>";

						//for each courseID get the numb and name
						while($id=pg_fetch_array($result)){

							$course_info = pg_query($dbconn, "SELECT numb, name FROM DDL.course C where C.c_id='$id[0]' ORDER by numb")or die('error! ' . pg_last_error());

							while($info=pg_fetch_array($course_info)){
							$courseNumb = $info['numb'];
							$courseName = $info['name'];
							$result_table .= "<tr align='center'>";
								$result_table .= "<td>$courseNumb</td>";
								$result_table .= "<td>$courseName</td>";
							$result_table .= "</tr></tr></tr></tr>";	
							}
						}			
						$result_table .= "</table>";
					}		
					
					else{
						$result_table = "<p>No matching data found!</p>";
					}
				}	
				echo $result_table;						
			}
		elseif(pg_num_rows($result)==0){
			echo "No record found!";
		}
		elseif(pg_num_rows($result)>1){
			echo "Error! Multiple students found!";
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
				<button type="submit" name="CSearch" value="search by course">Course Search</button><br><br>
		</div>
		<div>
				<label for="applicantName" > Enter the name of applicant you would like to search: </label>
				<input type="text" name="applicant_fName" id="applicantSearch" placeholder = "first name"></input>
				<input type="text" name="applicant_lName" id="applicantSearch" placeholder = "last name"></input><br>
				<button type="submit" name="ASearch" value="search by applicant">Applicant Search</button><br><br>
		</div>
		<!--comment on applicants of their choosing
					button in generated table to add to comment of person-->

		 <!-- Go to homepage -->

		<div >
				<label for="homepage">Go to home page</label><br>
				<input type="submit" name="homepage" value="Go to home page"><br><br></input>
		</div>	

	</body>
</html>
