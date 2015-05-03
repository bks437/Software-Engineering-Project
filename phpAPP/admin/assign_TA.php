
<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: ../../index.php");
	}

	//get student username
	$username3 = $_GET['username2'];
	$courseNumb= $_GET['course'];

	$username = $_SESSION['username'];
	//connect to database
	include("../../connect/database.php");
	//if cannot connect return error
	$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());

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

	pg_prepare($dbconn, 'assigned', "SELECT * FROM DDL.assigned_to where assigned_to.ta_username=$1 and assigned_to.c_id=$2")or die('error! ' . pg_last_error());
	$result = pg_execute($dbconn, 'assigned', array($username3, $courseId));

	if($result == false) {
		echo "<p align='center'>Some error has occured!</p><br><br>";
	}


?>


<html>
	<head>
		<title>Assign/Remove TA/PLA</title>
	</head>
	<body>
		<div align="center">
			</br>
			</br>
			</br>
			<?php
			 	if(pg_num_rows($result) ==0){
					$display="<b>".$fname." ".$lname."</b> is currently not assigned as TA/PLA for <b>".$courseNumb."</b><br/><br/>";
					$display.="<form action= 'ta_process.php' method='POST'>";
					$display.="<input type='hidden' name='username3' value=".$username3."></input>";
					$display.="<input type='hidden' name='courseNumb' value=".$courseNumb."></input>";
					$display.="<button type='submit' name ='assign_ta' value='assign_TA'>Assign <b>".$fname." ".$lname."</b> as TA/PLA for "."<b>".$courseNumb."</b>"."</button>";
					$display.="</form>";

				}
				elseif (pg_num_rows($result) ==1) {
					$display="<b>".$fname." ".$lname."</b> is currently assigned as TA/PLA for <b>".$courseNumb."</b><br/><br/>";
					$display.="<form action= 'ta_process.php' method='POST'>";
					$display.="<input type='hidden' name='username3' value=".$username3."></input>";
					$display.="<input type='hidden' name='courseNumb' value=".$courseNumb."></input>";
					$display.="<button type='submit' name ='remove_ta' value='remove_TA'>Remove <b>".$fname." ".$lname."</b> as TA/PLA for "."<b>".$courseNumb."</b>"."</button>";
					$display.="</form>";
				}
				echo $display;
				pg_close($dbconn);
			?>


					</br>
					</br>
			<button type="button" value="Close this window" onclick="self.close()">Close this window</button>

		</div>
	</body>
</html>
