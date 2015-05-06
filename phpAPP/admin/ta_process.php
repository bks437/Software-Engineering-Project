<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: ../../index.php");
	}


	$username = $_SESSION['username'];
	//connect to database
	include("../../connect/database.php");
	//if cannot connect return error
	$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());

	//get student username
	$username3 = $_POST['username3'];
	$courseNumb= $_POST['courseNumb'];

	pg_prepare($dbconn, 'name', "SELECT P.fname, P.lname FROM DDL.person P where P.username=$1")or die('error! ' . pg_last_error());
	$full_name = pg_execute($dbconn, 'name', array($username3));
	while($name=pg_fetch_array($full_name)){
		$fname = $name['fname'];
		$lname = $name['lname'];
	}

	pg_prepare($dbconn, 'course_name', "SELECT C.c_id FROM DDL.course C where C.numb=$1")or die('error! ' . pg_last_error());
	$course_info = pg_execute($dbconn, 'course_name', array($courseNumb));
	$info=pg_fetch_array($course_info);
	$courseId = $info[0];


	if(isset($_POST['assign_ta'])){


		pg_prepare($dbconn, 'assigned', "SELECT * FROM DDL.assigned_to where assigned_to.ta_username=$1 and (assigned_to.c_id=$2 or assigned_to.semester=$3)")or die('error! ' . pg_last_error());
		$result = pg_execute($dbconn, 'assigned', array($username3, $courseId, 'FS15'));

		if($result == false) {
			echo "<br/><br/><br/><p align='center'>Some error has occured!</p><br><br>";
		}

		elseif (pg_num_rows($result) ==0) {

			pg_prepare($dbconn,"assign_TA", "INSERT INTO DDL.assigned_to values ($1,$2,$3)") or die('error! ' . pg_last_error());
			$assigned = pg_execute($dbconn,"assign_TA",array($username3,'FS15', $courseNumb)) or die('error! ' . pg_last_error());

			if($assigned == false) {
				echo "<b>".$fname." ".$lname."</b> has already been assigned to a class for this semester!<br><br>";
			}

			if($assigned){
				echo "<br/><br/><br/><p align='center'>You have successfully assigned TA/PLA to <b>".$fname." ".$lname."</b> to the class <b>".$courseNumb."</b></p><br/><br/>";
			}
		}

		elseif (pg_num_rows($result) > 0) {
			echo "<br/><br/><br/><p align='center'>Sorry, but <b>".$fname." ".$lname."</b> has already been assigned as a TA/PLA to this course/semester!</p><br/><br/>";
		}
	}


	if(isset($_POST['remove_ta'])){

		pg_prepare($dbconn, 'delete', "DELETE FROM DDL.assigned_to where assigned_to.ta_username=$1 and assigned_to.c_id=$2")or die('error! ' . pg_last_error());
		$result = pg_execute($dbconn, 'delete', array($username3, $courseId));

		if($result == false) {
			echo "<br/><br/><br/><p align='center'>Some error has occured!</p><br><br>";
		}

		if ($result) {
			echo "<br/><br/><br/><p align='center'>You have successfully removed <b>".$fname." ".$lname."</b> as TA/PLA from the class <b>".$courseNumb."</b></p><br/><br/>";
			}

		else {
			echo "<br/><br/><br/><p align='center'>Some error has occured!</p><br><br>";
		}
	}
	pg_close($dbconn);
?>

<html>
<body>
	<div align="center">
		<input type="button" value="Close this window" onclick="self.close()">
	</div>
</body>
</html>
