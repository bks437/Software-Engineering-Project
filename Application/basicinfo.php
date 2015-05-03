<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "applicant"){
		header("Location: ../index.php");
	}
	//if data has been submitted
	if(isset($_POST['submit'])){
		//connect to database
		$_SESSION[grad]=$_POST[selection];

		include("../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());

		//if(date("y-m-d") <= "2015-05-01"）{
			pg_prepare($dbconn, 'basicinfo', 'INSERT INTO DDL.is_an_applicant(username,id,gpa,grad_date,email,phone,gato)
				VALUES ($1,$2,$3,$4,$5,$6,$7)');
			$result = pg_execute($dbconn, 'basicinfo', array($_SESSION['username'],$_POST['id'],$_POST['gpa'],$_POST['agd'],$_POST['email'],$_POST['phone'],$_POST['gato']));
			if($result==false){
				$_SESSION['insert']=false;
			}
			else
				header("Location: isinter.php");
		//}
		//else{
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
</head>
<body>
	<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">

	<!-- Header/Footer -->

		<div class="header shadowheader">
			<h1>Step 1: Basic Information</h1>
		</div>

		<div class="footer shadowfooter">
			<h4>Copyright &copy; Group G - Computer Science Department</h4>
		</div>
	
	<!-- Home/Logout -->
	
		<div class="centerhomelogout">
			<br>
			<!--<input class="home" type="submit" name="submit" value="Home" onclick="window.location.href ='../phpSQL/home.php'">-->
			<input class="logout" type="submit" name="submit" value="Logout" onclick="window.location.href ='../phpSQL/logout.php'">
		</div>
			
	<!-- Personal / Student Information / GATO -->

		
			<div class="centerpls">
				<p>
					<label class="floatleft" for="phone">Phone Number: </label>
					<input class="floatright" type="text" size="22" name="phone" id="phone" <?php if($_SESSION['insert']==false) echo "value=\"".$_POST[phone]."\"";?> placeholder="(123)-456-7890" required></input>
					<br>
				</p>
				<p>
					<label class="floatleft" for="id">Student ID:</label>
					<input class="floatright" type="text" size="22" name="id" id="id" <?php if($_SESSION['insert']==false) echo "value=\"".$_POST['id']."\"";?> placeholder ="12345678" maxlength = "8" required></input>
					<br>
				</p>
				<p>
					<label class="floatleft" for="email">Mizzou Email Address:</label>
					<input class="floatright" type="text" size="22" name="email" id="email" <?php if($_SESSION['insert']==false) echo "value=\"".$_POST['email']."\"";?> placeholder="student123@mail.missouri.edu" colums="50" required></input>
					<br>
				</p>
				<p>
					<label class="floatleft" for="gpa">GPA:</label>
					<input class="floatright" type = "text" size="22" name="gpa" id="gpa" <?php if($_SESSION['insert']==false) echo "value=\"".$_POST['gpa']."\"";?> placeholder="3.00" required></input>
					<br>
				</p>
				<p>
					<label class="floatleft" for="AGD">Anticipated Graduation Date:</label>
					<input class="floatright" type="date" size="22" name="agd" id="agd" <?php if($_SESSION['insert']==false) echo "value=\"".$_POST['agd']."\"";?> placeholder="mm/yyyy" required></input>
					<br>
				</p>
				<p>
					<label class="floatleft" for="gato">Have you attended the GATO?</label>
					<select class="floatright" name="gato">
						<option value="y" <? if($_POST['gato']=='y') echo "selected";?> >Yes</option>
						<option value="n" <? if($_POST['gato']=='n') echo "selected";?> selected>No</option>
					</select>
						<br>
					<label class="smallgato" for="gato">(Graduate Assistant Teaching Orientation)</label>
						<br>
				</p>
				<p>
					<label class="floatleft">What position are you applying for?</label>
					<div class="tapla floatright">
						<input type="radio" name="selection" value="ta" id="ta" checked>TA</input>
						<input type="radio" name="selection" value="pla" id="pla">PLA</input>
					</div>
						<br>
				</p>
			</div>

	<!-- Next page/step -->

			<div class="centerpls">
				<p class="floatright" id="click">
					<input  type="submit" name="submit" value="Proceed to the next step">
				</p>
			</div>
		</form>

</body>
</html>