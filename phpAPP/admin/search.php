<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: ../../index.php");
	}


	//if data has been submitted and if searching using course number
	$username = $_SESSION['username'];

	if(isset($_POST['view_all'] )){

		//connect to database
		include("../../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());


		pg_prepare($dbconn, 'searchall', "SELECT * FROM DDL.wants_to_teach order by wants_to_teach.ta_username")or die('error! ' . pg_last_error());
		$result = pg_execute($dbconn, 'searchall', array());
		if ($result == false) {
			$_SESSION['search_all']=false;
		}
		else{

			//if usernames found
			if(pg_num_rows($result)>0) {

				//display results in tables with links to actions:
				//table headers
				$result_table = "<table align='center' border ='1'>";
					$result_table .= "<tr align='center'>";
					$result_table .= "<th width='150px'><b>Student Name</b></a></th>";
					$result_table .= "<th width='150px'><b>Course Applied</b></th>";
					$result_table .= "<th width='450px'><b>Actions</b></th>";
					$result_table .= "</tr>";

					//links to actions
					while($row = pg_fetch_array($result)) {
						$username1 = $row['ta_username'];
						$courseId=$row['c_id'];
						$person = pg_query($dbconn, "SELECT P.fname, P.lname FROM DDL.person P where P.username='$username1'");
						$course = pg_query($dbconn, "SELECT course.numb from DDL.course where course.c_id =$courseId");

						//add each row
						while($name=pg_fetch_array($person)){
							$fname = $name['fname'];
							$lname = $name['lname'];
							while($courseNumb=pg_fetch_array($course)){

								$actions ="<a href=\"stu_info.php?username2=$username1\" target=\"_blank\">Student info</a> |
										   <a href=\"view_comments.php?username2=$username1\" target=\"_blank\">View comments</a> |
										   <a href=\"add_rank.php?username2=$username1\" target=\"_blank\">Add/Change ranking score</a> |
										   <a href=\"assign_TA.php?username2=$username1&course=$courseNumb[0]\" target=\"_blank\">Assign/Remove as TA/PLA</a> ";

							$result_table .= "<tr align='center'>";
							$result_table .= "<td>$fname $lname</td>";
							$result_table .= "<td>$courseNumb[0]</td>";
							$result_table .= "<td>&nbsp;$actions</td>";
							$result_table .= "</tr>";
							}
						}
					}
				$result_table .= "</table><br/><br/><br/>";
			}

			else{
				$result_table = "<p align='center'>No matching data found!</p><br/><br/><br/>";
			}

			echo $result_table;

		}
		pg_close($dbconn);
	}

	if(isset($_POST['CSearch'] )){

		//connect to database
		include("../../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());

		if(!$_POST['courseNumb']){
			$result = false;
			echo "<p align='center'><br/><br/>Wrong! Course number can not be empty!</p>".'<br/><br/><br/>';
		}

		else{

			$courseNumb = $_POST['courseNumb'];

			//find usernames who want to teach this course
			$search_username = "SELECT wtt.ta_username FROM DDL.wants_to_teach wtt where wtt.c_id IN (SELECT C.c_id FROM DDL.course C where C.numb= $1)";
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
							$person = pg_query($dbconn, "SELECT P.fname, P.lname FROM DDL.person P where P.username='$username1'");
							$actions ="<a href=\"stu_info.php?username2=$username1\" target=\"_blank\">Student info</a> |
											   <a href=\"view_comments.php?username2=$username1\" target=\"_blank\">View comments</a> |
											   <a href=\"add_rank.php?username2=$username1\" target=\"_blank\">Add/Change ranking score</a> |
											   <a href=\"assign_TA.php?username2=$username1&course=$courseNumb\" target=\"_blank\">Assign/Remove as TA/PLA</a> ";

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
					$result_table = "<p align='center'><br/><br/>No matching data found!</p><br/><br/><br/>";
				}

				echo $result_table;
			}
		}
		pg_close($dbconn);
	}


	//if data has been submitted and search using applicant name
	if (isset($_POST['ASearch'])) {

		//connect to database
		include("../../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());

		//if no names are provided
		if(!$_POST['applicant_lName']) {

			if(!$_POST['applicant_fName'] ) {
				$result = false;
				echo "<p align='center'><br/><br/>Wrong! Both first name and last name can not be empty!</p>".'<br/><br/>';
			}
			else {
				//search applicant username using only first name
				$applicant_fName = $_POST['applicant_fName'];
				$username_find = "SELECT P.username from DDL.person P where lower(P.fname) = lower($1)";
				pg_prepare($dbconn, 'fnamefind',$username_find);
				$result= pg_execute($dbconn, 'fnamefind',array($applicant_fName))or die('error! ' . pg_last_error());
			}
		}
		else {
			if(!$_POST['applicant_fName'] ) {
				//search applicant username using only last name
				$applicant_lName = $_POST['applicant_lName'];
				$username_find = "SELECT P.username from DDL.person P where lower(P.lname) = lower($1)";
				pg_prepare($dbconn, 'lnamefind',$username_find);
				$result= pg_execute($dbconn, 'lnamefind',array($applicant_lName))or die('error! ' . pg_last_error());
			}
			else{
				//search applicant username using both first name and last name
				$applicant_fName = $_POST['applicant_fName'];
				$applicant_lName = $_POST['applicant_lName'];
				$username_find = "SELECT P.username from DDL.person P where lower(P.fname) = lower($1) AND lower(P.lname) = lower($2);";
				pg_prepare($dbconn, 'userfind',$username_find);
				$result= pg_execute($dbconn, 'userfind',array($applicant_fName,$applicant_lName))or die('error! ' . pg_last_error());
			}
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
					$result_table = "<p align='center'>No matching data found!</p><br/><br/><br/>";
				}
			}
			echo $result_table;
		}

		//if username not found
		elseif(pg_num_rows($result)==0){
			echo "<p align='center'>No record found!</p>";
		}

		//if multiple users with the same name
		elseif(pg_num_rows($result)>1){
			echo "<p align='center'>Error! Multiple students found!</p>";
		}
		pg_close($dbconn);
	}

	//go to home page
	if (isset($_POST['homepage'])) {
		header("Location: ../../phpSQL/home.php");
	}

?>

<html>
<body>
	<form method="POST" action="../admin_page.php">
		<div align='center'>
			<br>
			<br>
			<button  name="admin_page" value="Go back to admin page" onclick="window.location.href='index.php'"> Go back to admin page</button>
		</div>
	</form>

</body>
</html>
