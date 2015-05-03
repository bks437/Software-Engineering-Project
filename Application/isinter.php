<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "applicant"){
		header("Location: ../index.php");
	}
	//if data has been submitted
	if(isset($_POST['submit'])){
		//connect to database
		include("../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());
		// check if it is submitted before deadline
		//if(date("y-m-d") <= "2015-05-01"）{
			if(strcmp($_POST['status'],"international")==0){
				if(strcmp($_POST['speaktest'],"passed")==0){
					$taken='y ';
					$test_date=$_POST['test_date'];
				}
				elseif(strcmp($_POST['speaktest'],"scheduled")==0){
					$taken='n ';
					$test_date=$_POST['test_date'];
				}
				pg_prepare($dbconn, 'basicinfo', 'INSERT INTO DDL.is_international (username,speak,speak_taken,test_date,onita)
					VALUES ($1,$2,$3,$4,$5)');
				$result = pg_execute($dbconn, 'basicinfo', array($_SESSION['username'],(int)$_POST['test_score'],$taken,$test_date,$_POST['onita']))or die("error: ".pg_last_error());
				if($result==false){
					$_SESSION['insert']=false;
				}
				else
					header("Location: gradundergrad.php");
			}
			else
				header("Location: gradundergrad.php");
		//}

		//after deadline
		// else{
		// 	$_SESSION['insert']=false;
		// 	header("Location: home.php");
		// }

	}
?>
<!DOCTYPE html>
<html>
	<!--ADD ANY USEFUL TIPS, otherwise ... DO NOT FUCK WITH THE COMMENTS. please and thank you.-->
<head>
	<title>CS4320 - Group G</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<script src="../js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="../js/isinter.js"></script>
</head>
<body>
	<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">

	<!-- Header/Footer -->

		<div class="header shadowheader">
			<h1>Step 2: International</h1>
		</div>

		<div class="footer shadowfooter">
			<h4>Copyright &copy; Group G - Computer Science Department</h4>
		</div>

	<!-- Home/Logout -->
	
		<div class="centerlogout">
			<br>
			<!--<input class="home" type="submit" name="submit" value="Home" onclick="window.location.href ='../phpSQL/home.php'">-->
			<input class="logout" type="submit" name="submit" value="Logout" onclick="window.location.href ='../phpSQL/logout.php'">
		</div>
	
	<!-- Int/SPEAK/ONITA -->

		<div class="centerpls">
			<p>
				<label class="floatleft">What type of student are you?</label>
				<select class="floatright" id="status" name="status" required>
					<option value="status">Select</option>
					<option value="international">International</option>
					<option value="noninternational">Non-International</option>
				</select>
				<br>
			</p>
			<p id="interinfo" style="display:none">
				<label class="floatleft">Have you passed the SPEAK Test?</label>
				<select class="floatright" id="speaktest" name="speaktest">
					<option value="select">Select</option>
					<option value="passed">Speak test passed</option>
					<option value="scheduled">Speak test scheduled</option>
					<option value="notscheduled">Speak test not scheduled</option>
				</select>
				<br>
				<label class="smallspeak">(English proficiency Test)</label>
				<br>
			</p>

			<p id="testinfo" style="display:none">
				<label class="floatleft" for="test_score">Test score:</label>
				<input class="floatright" type="text" name="test_score" maxlength="5" placeholder="100"></input>
				<br>
			</p>

			<p id="testinfo2" style="display:none">
				<label class="floatleft" for="test_date">Test date:</label>
				<input class="floatright" type="date" name="test_date" maxlength="40"></input>
				<br>
			</p>

			<p id="test_schedule" style="display:none">
				<label class="floatleft">Please provide the scheduled test date:</label>
				<input class="floatright" type="date" name="test_date" size="20" maxlength="40"></input>
				<br>
			</p>

			<p class="centertextint bigspeak" id="disqualified" style="display:none">
				<br><br>
				<b> Sorry, you do not qualify for a TA/PLA position!</b><br/><br/>
				<br><br>
			</p>

			<p class="centertextint2 bigspeak" id="autoqualified" style="display:none">
				<br><br>
				<b>You qualify for a TA/PLA position!</b>
				<br><br>
			</p>

			<p id="newstudent" style="display:none">
				<label class="floatleft">Have you finished at least one semester?</label>
				<div class="onesemester floatright" id="newstudentradio" style="display:none">
					<input type="radio" name="answer" value="Yes" checked>Yes</input>
					<input type="radio" name="answer" value="No"> No</input>
				</div>
				<br>
			</p>

			<p id="onita" style="display:none">
				<label class="floatleft">Have you attended the ONITA?</label>
				<div class="onesemester floatright" id="onitaradio" style="display:none">
					<input type="radio" name="answer" value="Yes">Yes</input>
					<input type="radio" name="answer" value="No"> No</input>
					<input type="radio" name="answer" value="Will_attend">Will attend in Aug/Jan</input>
				</div>
				<br>
			</p>
		</div>

	<!-- Go to nextpage or save data part -->

		<div class="centerpls">
			<p class="floatright" id="click" style="display: none">
				<input type="submit" name="submit" value="Proceed to the next step">
			</p>
		</div>

	<!-- Go to homepage -->

		<div class="centerpls">
			<p class="floatright" id="home" style="display: none">
				<input type="submit" name="submit" value="Proceed to the home page" onclick="window.location.href ='../phpSQL/index.php'">
			</p>
		</div>
	</form>
</body>
</html>