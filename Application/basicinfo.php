<?php

	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username'])){
		header("Location: index.php");
	}	
	//if data has been submitted
	if(isset($_POST['submit'])){
		$_SESSION[grad]=$_POST[selection];
		//connect to database
		include("../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());
		pg_prepare($dbconn, 'basicinfo', 'INSERT INTO DDL.is_an_applicant(username,id,gpa,grad_date,email,phone,gato) 
			VALUES ($1,$2,$3,$4,$5,$6,$7)');
		$result = pg_execute($dbconn, 'basicinfo', array($_SESSION['username'],$_POST[id],$_POST[gpa],$_POST[agd],$_POST[email],$_POST[phone],$_POST[gato])); 
		if($result==false){
			$_SESSION[insert]=false;
		}
		else
			header("Location: isinter.php");
	}
?>

<!DOCTYPE html>
<html>
	<!--ADD ANY USEFUL TIPS, otherwise ... DO NOT FUCK WITH THE COMMENTS. please and thank you.-->
<head>
	<title>CS4320 - Group G</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">		
	<script src="../js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="../js/javascript.js"></script>
</head>
<body>

	<!-- Header/Footer -->
		
		<div class="header shadowheader">			
			<h1>Step 1: Basic Information</h1>		
		</div>			
		
		<div class="footer shadowfooter">			
			<h4>Copyright &copy; Group G - Computer Science Department</h4>		
		</div>		
	
	<!-- Personal -->
		<form name="basicinfo" action="basicinfo.php" method="POST">
			<div class="personal centerpls">
<!-- 				<p class="firstname centerdisplay">
					<label class="leftlabel" for="fname" >First name: </label> 
					<input class="niceinput" type="text" size="22" name="fname" id="fname" placeholder="John"></input>
					<br>
				</p>
				<p class="lastname centerdisplay">
					<label class="leftlabel" for="lname">Last name: </label>
					<input class="niceinput" type="text" size="22" name="lname" id="lname" placeholder="Doe"></input>
					<br>
				</p> -->
				<p class="phonenumber centerdisplay">
					<label class="leftlabel" for="phone">Phone Number: </label>
					<input class="niceinput" type="text" size="22" name="phone" id="phone" <?php if($_SESSION[insert]==false) echo "value=\"".$_POST[phone]."\"";?> placeholder="(123)-456-7890"></input>
					<br>
				</p>
			</div>
			
	<!-- Student Information -->
			
			<div class="studentinfo centerpls">
				<p class="studentid centerdisplay">
					<label class="leftlabel" for="id">Student ID:</label>
					<input class="niceinput" type="text" size="22" name="id" id="id" <?php if($_SESSION[insert]==false) echo "value=\"".$_POST[id]."\"";?> placeholder ="12345678" maxlength = "8" ></input>
					<br>
				</p>
				<p class="emailaddress centerdisplay">
					<label class="leftlabel" for="email">Mizzou Email Address:</label>
					<input class="niceinput" type="text" size="22" name="email" id="email"  <?php if($_SESSION[insert]==false) echo "value=\"".$_POST[email]."\"";?> placeholder="student123@mail.missouri.edu" colums="50"></input>
					<br>
				</p>
				<p class="thegpa centerdisplay">
					<label class="leftlabel" for="gpa">GPA:</label>
					<input class="niceinput" type = "text" size="22" name="gpa" id="gpa" <?php if($_SESSION[insert]==false) echo "value=\"".$_POST[gpa]."\"";?> placeholder="3.00"></input>
					<br>
				</p>
				<p class="theagd centerdisplay">
					<label class="leftlabel" for="AGD">Anticipated Graduation Date:</label>
					<input class="niceinput" type="date" size="22" name="agd" id="agd" <?php if($_SESSION[insert]==false) echo "value=\"".$_POST[agd]."\"";?> placeholder="mm/yyyy"></input>
					<br>
				</p>
			</div>

	<!-- GATO -->	
		
			<div class="gato centerpls">
				<p class="thegato centerdisplay">
					<label class="leftlabel" for="gato">Have you attended the GATO?</label>
					<select name="gato">
						<option value="y"<? if($_POST['gato']=='y') echo "selected";?>>Yes</option>
						<option value="n" <? if($_POST['gato']!='y') echo "selected";?>>No</option>						
					</select>
					<label for="gato">(Graduate Assistant Teaching Orientation)</label>
						<br>
				</p>
				<p class="theposition centerdisplay">
					<label class="leftlabel">What position are you applying for?</label>
					<input type="radio" name="selection" value="ta" id="ta" checked>TA</input>
					<input type="radio" name="selection" value="pla" id="pla">PLA</input>
				</p>
			</div>
			
		<!-- Next page/step -->
			
			<h3>
				<div class="centerpls">
				<p class="centerdisplay nextbutton" id="click">
					<!--<label for"nextpage">Click here to go to the next page:</label>-->
					<input  type="submit" name="submit" value="Proceed to the next step">
				</p>
				</div>
			</h3>
		</form>
		
</body>
