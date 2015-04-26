<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username'])){
		header("Location: ..\index.php");
	}	

	//if data has been submitted and if searching using course number
	if(isset($_POST['CSearch'] )){

		//connect to database
		include("../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());

		if(!$_POST['courseNumb']){
			$result = false;
			echo "Wrong! Course number can not be empty!".'<br/><br/><br/>';
		}
		
		else{

			$courseNumb = $_POST['courseNumb'];

			//find usernames who want to teach this course	
			$search_username = "SELECT wtt.ta_username FROM DLL.wants_to_teach wtt where wtt.c_id =(SELECT C.c_id FROM DLL.course C where C.numb= $1)";
			pg_prepare($dbconn, 'namesearch', $search_username)or die('error! ' . pg_last_error());
			$result = pg_execute($dbconn, 'namesearch', array($courseNumb));

			//if no username is found
			if ($result == false) {
				$_SESSION['form_search']=false;
			}
			
			else {
				//if usernames found
				if(pg_num_rows($result)>0) {

					//display results in tables with links to actions:
					//table headers 
					$result_table = "<table align='center' border ='1'>";
						$result_table .= "<tr align='center'>";
						$result_table .= "<th width='150px'><b>First Name</b></a></th>";//<a href=\"".$_SERVER['PHP_SELF']."?sort=Student First Name\">
						$result_table .= "<th width='150px'><b>Last Name</b></th>";
						$result_table .= "<th width='150px'><b>Username</b></th>";
						$result_table .= "<th width='450px'><b>Actions</b></th>";
						$result_table .= "</tr>";

						//links to actions
						while($row = pg_fetch_array($result)) {
							$username1 = $row[0];
							$person = pg_query($dbconn, "SELECT P.fname, P.lname FROM DLL.person P where P.username='$username1'");
							$actions ="<a href=\"professorActions\stu_info.php?username2=$username1\">Student info</a> | 
									   <a href=\"professorActions\add_comments.php?username2=$username1\">Add Comments</a> |
									   <a href=\"professorActions\view_resume.php?username2=$username1\">View Resume</a> | 
									   <a href=\"professorActions\\request_TA.php?username2=$username1\">Request as TA</a> ";

							//add each row
							while($name=pg_fetch_array($person)){
								$fname = $name['fname'];
								$lname = $name['lname'];			
								
								$result_table .= "<tr align='center'>";
								$result_table .= "<td>$fname</td>";
								$result_table .= "<td>$lname</td>";
								$result_table .= "<td>$username1</td>";
								$result_table .= "<td>&nbsp;$actions</td>";
								$result_table .= "</tr>";	
							}				
						}	
					$result_table .= "</table><br/><br/><br/>";
				}
				
				else{
					$result_table = "<p>No matching data found!</p><br/><br/><br/>";
				}
			
				echo $result_table;
			}	
		}
		pg_close($dbconn);
	}


	//if data has been submitted and search using applicant name
	if (isset($_POST['ASearch'])) {

		//connect to database
		include("../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());

		//if no names are provided
		if(!$_POST['applicant_lName'] and !$_POST['applicant_fName'] ){
			$result = false;
			echo "Wrong! Both first name and last name can not be empty!".'<br/><br/><br/>';
		}
		
		else {
			//search applicant username
			$applicant_fName = $_POST['applicant_fName'];
			$applicant_lName = $_POST['applicant_lName'];
			$username_find = "SELECT P.username from DDL.person P where lower(P.fname) = lower($1) OR lower(P.lname) = lower($2);";
			pg_prepare($dbconn, 'userfind',$username_find);
			$result= pg_execute($dbconn, 'userfind',array($applicant_fName,$applicant_lName))or die('error! ' . pg_last_error());
		}

		//if no username found
		if ($result == false) {
			$_SESSION['form_search']=false;
		}	

		//if username found
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
				//if course found
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
							$result_table .= "</tr>";	
						}
					}			
					$result_table .= "</table><br/><br/><br/>";
				}		
				
				//if no course found
				else{
					$result_table = "<p>No matching data found!</p><br/><br/><br/>";
				}
			}	
			echo $result_table;						
		}
		
		//if username not found	
		elseif(pg_num_rows($result)==0){
			echo "No record found!";
		}

		//if multiple users with the same name
		elseif(pg_num_rows($result)>1){
			echo "Error! Multiple students found!";
		}
		pg_close($dbconn);
	}

	//go to home page
	if (isset($_POST['homepage'])) {
		pg_close($dbconn);
		header("Location: ../phpSQL/home.php");
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