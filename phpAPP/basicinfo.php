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
	
	<!-- Personal -->
		
			<div class="personal centerpls">
				<p class="firstname centerdisplay">
					<label class="leftlabel" for="fname" >First name: </label> 
					<input class="niceinput" type="text" size="22" name="fname" id="fname" placeholder="John"></input>
					<br>
				</p>
				<p class="lastname centerdisplay">
					<label class="leftlabel" for="lname">Last name: </label>
					<input class="niceinput" type="text" size="22" name="lname" id="lname" placeholder="Doe"></input>
					<br>
				</p>
				<p class="phonenumber centerdisplay">
					<label class="leftlabel" for="phone">Phone Number: </label>
					<input class="niceinput" type="text" size="22" name="phone" id="phone" placeholder="(123)-456-7890"></input>
					<br>
				</p>
			</div>
			
	<!-- Student Information -->
			
			<div class="studentinfo centerpls">
				<p class="studentid centerdisplay">
					<label class="leftlabel" for="id">Student ID:</label>
					<input class="niceinput" type="text" size="22" name="id" id="id" placeholder ="12345678" maxlength="8" ></input>
					<br>
				</p>
				<p class="emailaddress centerdisplay">
					<label class="leftlabel" for="email">Mizzou Email Address:</label>
					<input class="niceinput" type="text" size="22" name="email" id="email" placeholder="student123@mail.missouri.edu" colums="50"></input>
					<br>
				</p>
				<p class="thegpa centerdisplay">
					<label class="leftlabel" for="gpa">GPA:</label>
					<input class="niceinput" type = "text" size="22" name="gpa" id="gpa" placeholder="3.00"></input>
					<br>
				</p>
				<p class="theagd centerdisplay">
					<label class="leftlabel" for="AGD">Anticipated Graduation Date:</label>
					<input class="niceinput" type="date" size="22" name="agd" id="agd" placeholder="mm/yyyy"></input>
					<br>
				</p>
			</div>

	<!-- GATO -->	
		
			<div class="gato centerpls">
				<p class="thegato centerdisplay">
					<label class="leftlabel" for="gato">Have you attended the GATO?</label>
					<select name="gato">
						<option value="yes" >Yes</option>
						<option value="no" selected>No</option>						
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
				<input  type="submit" name="nextpage" value="Proceed to the next step">
			</p>
			</div>
		</h3>
	</form>
	
<?PHP
	if (isset($_POST['nextpage']) == "Proceed to the next step"){
		header("Location: isinter.php");
	}
?>

</body>
</html>