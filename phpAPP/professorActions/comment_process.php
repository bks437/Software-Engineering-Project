<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "prof"){
		header("Location: ../../index.php");
	}

	if(isset($_POST['add_comments'] )){
		
		$username = $_SESSION['username'];			  
		//connect to database
		include("../../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());

		//get username and comments
		$username3=$_POST['username3'];
		$comments=$_POST['comments'];

		//search for username in table
		pg_prepare($dbconn,"search_comment", "SELECT ta_username from DDL.comments where ta_username=$1")or die('error! ' . pg_last_error());
		$result1 = pg_execute($dbconn,"search_comment",array($username3));
		$result2= pg_fetch_array($result1)[0];

		//retrieve first and last names of applicant
		pg_prepare($dbconn,"search_name", "SELECT P.fname, P.lname FROM DDL.person P where P.username=$1") or die('error! ' . pg_last_error());
		$result = pg_execute($dbconn,"search_name",array($username3));
		$name=pg_fetch_array($result);
		$whole_name = $name['fname']." ".$name['lname'];

		//if no comments found for this applicant, insert comments
		if($result2 != $username3) {
			pg_prepare($dbconn,"insertComm",'INSERT INTO DDL.comments values ($1,$2,$3)')or die('error! ' . pg_last_error());
			$result3 = pg_execute($dbconn,"insertComm",array($username, $username3, $comments));
			echo "You have successfully added comments to "."<b>".$whole_name."<b>"."<br/>"."<br/>";
		}

		//if there are already comments for this applicant, update comments
		elseif ($result2 == $username3){
			pg_prepare($dbconn,"updateComm",'UPDATE DDL.comments SET comment=$1 where professor=$2 and ta_username=$3')or die('error! ' . pg_last_error());
			$result3 = pg_execute($dbconn,"updateComm",array($comments, $username, $username3));
			echo "You have successfully updated comments to "."<b>".$whole_name."<b>"."<br/>"."<br/>";
		}
	}
 	pg_close($dbconn);

?>


<html>
<body>
	<input type="button" value="Close this window" onclick="self.close()">

</body>
</html>

