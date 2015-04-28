<?php 
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: ../../index.php");
	}	

	if (isset($_POST['submit'])){

		include("../../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());

		//search applicant username 
		$applicant_fName = $_POST['firstname'];
		$applicant_lName = $_POST['lastname'];
		$score = $_POST['rankscore'];

		pg_prepare($dbconn, 'userfind',"SELECT P.username from DDL.person P where lower(P.fname) = lower($1) AND lower(P.lname) = lower($2);");
		$result= pg_execute($dbconn, 'userfind',array($applicant_fName,$applicant_lName))or die('error! ' . pg_last_error());
		$username_find=pg_fetch_array($result);
		
		//if only one username found 
		if(pg_num_rows($result)==1) {
		
			$score_find = "SELECT iaa.ta_rank from DDL.is_an_applicant iaa where iaa.username = $1;";
			pg_prepare($dbconn, 'scorefind',$score_find);
			$result= pg_execute($dbconn, 'scorefind',array($username_find[0]))or die('error! ' . pg_last_error());

			//if no score found for this applicant, insert score
			if ($score_find == "") {
				pg_prepare($dbconn,"insertScore",'INSERT INTO DDL.is_an_applicant values ($1) where username=$2')or die('error! ' . pg_last_error());
				$newscore = pg_execute($dbconn,"insertScore",array($score, $username_find));
				if($newscore){
					echo "You have successfully added ranking score to "."<b>".$$applicant_fName." ".$$applicant_fName."<b>"."<br/>"."<br/>";
				}
				else{
					echo "Some error occured!";
				}
			}		

			//if there are already score for this applicant, update score
			else {
				pg_prepare($dbconn,"updateScore",'UPDATE DDL.is_an_applicant SET ta_rank=$1 where username=$2')or die('error! ' . pg_last_error());
				$updatescore = pg_execute($dbconn,"updateScore",array($score, $username_find[0]));
				if($updatescore){
					echo "You have successfully updated ranking score to "."<b>".$applicant_fName." ".$applicant_lName."."."<b>"."<br/>"."<br/>";
				}
				else{
					echo "Some error occured!";
				}
			}
		}		

		//if multiple users with the same name
		elseif(pg_num_rows($result)>1){
			echo "Error! Multiple students found! Please narrow down your search criteria!";
		}

		//if username not found	
		else{
			echo "No record found!";
		}
		
		pg_close($dbconn);

	}			


?>


<html>
<body>
	<input type="button" value="Close this window" onclick="self.close()">

</body>
</html>
