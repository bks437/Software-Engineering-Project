<?php
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: ../../index.php");
	}

	if (isset($_POST['submit'])){

		$username = $_SESSION['username'];
		//connect to database
		include("../../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());

		//search applicant username
		$username4 = $_POST['username3'];
		$score = $_POST['rankscore'];

		$score_find = 'SELECT iaa.ta_rank from DDL.is_an_applicant iaa where iaa.username = $1';
		pg_prepare($dbconn, 'scorefind',$score_find);
		$result= pg_execute($dbconn, 'scorefind',array($username4))or die('error! ' . pg_last_error());

		if($result == false){
			echo "No record found!";
		}

		else {

			//if no score found for this applicant, insert score
			if ($score_find == "") {
				pg_prepare($dbconn,"insertScore",'INSERT INTO DDL.is_an_applicant values ($1) where username=$2')or die('error! ' . pg_last_error());
				$newscore = pg_execute($dbconn,"insertScore",array($score, $username4));
				if($newscore){
					echo "You have successfully added ranking score to "."<b>".$applicant_fName." ".$applicant_fName."<b>"."<br/>"."<br/>";
				}
				else{
					echo "Some error occured!";
				}
			}

			//if there are already score for this applicant, update score
			else {
				pg_prepare($dbconn,"updateScore",'UPDATE DDL.is_an_applicant SET ta_rank=$1 where username=$2')or die('error! ' . pg_last_error());
				$updatescore = pg_execute($dbconn,"updateScore",array($score, $username4));
				if($updatescore){
					echo "You have successfully updated ranking score to "."<b>".$username4."."."<b>"."<br/>"."<br/>";
				}
				else{
					echo "Some error occured!";
				}
			}
		}
	}
	else {

		header("Location: index.php");
	}

		pg_close($dbconn);
?>


<html>
<body>
	<input type="button" value="Close this window" onclick="self.close()">

</body>
</html>
