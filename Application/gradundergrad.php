<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username'])){
		header("Location: index.php");
	}	
	//if data has been submitted
	if(isset($_POST['submit'])){
		//connect to database
		include("test/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());
		if(strcmp($_SESSION[grad],"ta")==0){
			pg_prepare($dbconn, 'grad', 'INSERT INTO DDL.is_a_grad values($1,$2,$3)');
			$result = pg_execute($dbconn, 'grad', array($_SESSION['username'],$_POST[gradpro],$_POST[advisor])); 
		}
		elseif(strcmp($_SESSION[grad],"pla")==0){
			pg_prepare($dbconn, 'ungrad', 'INSERT INTO DDL.is_an_undergrad values($1,$2,$3)') or die('Could not connect: ' . pg_last_error());;
			$result = pg_execute($dbconn, 'ungrad', array($_SESSION['username'],$_POST[program],$_POST[year]))or die('Could not connect: ' . pg_last_error());; 
		}
		if($result==false){
			$_SESSION[insert]=false;
		}
		else
			header("Location: courses.php");
	}
?>


<!DOCTYPE html>
<html>
	<!--ADD ANY USEFUL TIPS, otherwise ... DO NOT FUCK WITH THE COMMENTS. please and thank you.-->
<head>
	<title>CS4320 - Group G</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">	
	<script src="../js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="../js/gradundergrad.js"></script>
</head>
<body>

	<!-- Header/Footer -->
		
		<div class="header shadowheader">			
			<h1>Step 3: <? if(strcmp($_SESSION[grad],"ta")==0) {echo "Graduate";} else {echo "Undergraduate";}?> Information</h1>		
		</div>			
		
		<div class="footer shadowfooter">			
			<h4>Copyright &copy; Group G - Computer Science Department</h4>		
		</div>		
	
	
	<!-- Graduate/Undergraduate -->
	<form name="gradungrad" action="gradundergrad.php" method="POST">
		<div class="toppadding5 centerdisplay">
			<p class="centerpls">
				<label class="leftlabel">What type of student are you?</label>
				<select id="type" name="type">
					<option value="type">Select</option>
					<option value="graduate">Graduate</option>
					<option value="undergraduate">Undergraduate</option>
				</select>
			</p>
		</div>

	<!-- Undergraduate -->
			
		<div class="centerdisplay">
			<p class="centerpls displaynone" id="years">
				<label class="leftlabel">What level of student are you?</label>
				<select id="year" name="year">
					<option value="year">Select</option>
					<option value="freshmen">Freshmen</option>
					<option value="sophomore">Sophomore</option>
					<option value="Junior">Junior</option>
					<option value="Senior">Senior</option>
				</select>
			</p>
		</div>
			
		<div class="centerdisplay">
			<p class="centerpls displaynone" id="degrees">
				<label class="leftlabel">What degree program are you in?</label>
				<select id="program" name="program">
					<option value="program">Select</option>
					<option value="bacs">Bachelor of Arts in Computer Science</option>
					<option value="bscs">Bachelor of Science in Computer Science</option>
					<option value="bsit">Bachelor of Science in Information Technology</option>
					<option value="bscsit">Dual BS CS and BS IT</option>
					<option value="bsitmba">Dual BS IT and MBA</option>
					<option value="fastrack">Fast-Track BS and MS in Computer Science</option>
				</select>
			</p>
		</div>
			
	<!-- Graduate -->
			
		<div class="centerdisplay">
			<p class="centerpls displaynone" id="programs">
				<label class="leftlabel">What degree program are you in?</label>
				<select id="gradpro" name="gradpro">
					<option value="gradpro">Select</option>
					<option value="ms">MS</option>
					<option value="phd">PhD</option>
				</select>
			</p>
		</div>
			
		<div class="centerdisplay">
			<p class="centerpls displaynone" id="advisors">
				<label class="leftlabel">Select Advisor:</label>
				<select id="advisor" name="advisor">
					<option value="advisor">Select</option>
					<option value="yin">Yin Shang</option>
					<option value="jodie">Jodie Lenser</option>
				</select>
			</p>
		</div>
	
	<!-- Next Page -->

		<div class="centerpls">
			<p class="centerdisplay nextbutton" id="click" style="display: none">
				<input  type="submit" name="submit" value="Proceed to the next step">
			</p>			
		</div>
	</form>
		
</body>
</html>
