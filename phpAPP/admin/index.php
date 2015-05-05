<?php
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: ../index.php");
	}
			include("../../connect/database.php");

		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());
		$semeterresult=pg_query($dbconn,'SELECT name FROM DDL.Semester WHERE studentstart<current_date AND facultyend>current_date')or die('error4 ' . pg_last_error());
	$semester = pg_fetch_array($semeterresult, null, PGSQL_ASSOC);
	if(isset($semester[name]))
		$_SESSION[Semester]=$semester[name];
	
		pg_prepare($dbconn,"course", "SELECT c_id,numb from DDL.Course")or die('error! ' . pg_last_error());
		$courses=pg_execute($dbconn,"course",array());

		pg_close($dbconn);
?>

<!DOCTYPE html>
<html>
	<head>
	<title>CS4320 - Group G</title>
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
			<script src="../../js/jquery-1.11.2.min.js"></script>
			<script src="../../js/ajax.js"></script>
			<script>
			function updateranking(user,semester){

					var e = document.getElementById(user+'rank');
					var rank = e.value;
					console.dir(rank);

				var xmlHttp = xmlHttpObjCreate();
				if(!xmlHttp){
					alert("This browser doesn't support this action");
					return
				}

				xmlHttp.onload = function(){
					var response = xmlHttp.responseText;
					var isnert = document.getElementById("rank");
					console.dir(response);

				// Get div object
					var divObj = document.getElementById('rank');

				// We used JSON.parse to turn the JSON string into an object
					var responseObject = JSON.parse(response);

				// This is our object
				console.dir(responseObject);

				// We can use that object like so:
				var i=0;
				divObj.innerHTML= "<div id=\""+responseObject[i].username+"\">"+responseObject[i].fname +" "+ responseObject[i].lname+" <div class=\"floatright\"> <input type=\"number\" id=\""+responseObject[i].username+"rank\" placeholder=\"rank\"><button onclick=\"updateranking('"+responseObject[i].username+"','FS15')\">Add Rank</button></div></div><br>";
				for(i=1;i<responseObject.length;i++){
					divObj.innerHTML= divObj.innerHTML+"<div id=\""+responseObject[i].username+"\">"+responseObject[i].fname +" "+ responseObject[i].lname+" <div class=\"floatright\"> <input type=\"number\" id=\""+responseObject[i].username+"rank\" placeholder=\"rank\"><button onclick=\"updateranking('"+responseObject[i].username+"','FS15')\">Add Rank</button></div></div><br>";
				}
				}
				var reqURL = "assign.php?action=add&rank="+rank+"&semester="+semester+"&applicant="+user;
				document.getElementById(user+'rank').innerHTML = 'removing...';
			    xmlHttp.open("GET", reqURL, true);
			    xmlHttp.send();
				//$.post('assign.php',
				// {
				// 	action:"add",
				// 	rank: rank,
				// 	semester: semester,
				// 	applicant: user
				// }, function(json){
				// 	$("#app2test").html("<div id=\"app2test\"></div>");
				// 	$.each(JSON.parse(json), function(idx, obj){
				// 		var pattern = /[0-9]{4}-[0-9]{2}-[0-9]{2}/;
				// 		$("#app2test").append("<h3>" + obj.Content.substring(0,10) + "..." + "\t|\t" + pattern.exec(obj.Date) + "</h3>");
				// 		$("#app2test").append("<div id=\"announcement" + idx + "\"></div>");
				// 		$("#announcement" + idx).append("<p>" + obj.Content + "</p>");
				// 		});
				// });

			}



			function init(){
				var xmlHttp = xmlHttpObjCreate();
				if(!xmlHttp){
					alert("This browser doesn't support this action");
					return
				}

				xmlHttp.onload = function(){
					var response = xmlHttp.responseText;
					var isnert = document.getElementById('rank');
					console.dir(response);

				// Get div object
					var divObj = document.getElementById('rank');

				// We used JSON.parse to turn the JSON string into an object
					var responseObject = JSON.parse(response);

				// This is our object
				console.dir(responseObject);

				// We can use that object like so:
				var i=0;
				divObj.innerHTML= "<div id=\""+responseObject[i].username+"\">"+responseObject[i].fname +" "+ responseObject[i].lname+" <div class=\"floatright\"> <input type=\"number\" id=\""+responseObject[i].username+"rank\" placeholder=\"rank\"><button onclick=\"updateranking('"+responseObject[i].username+"','FS15')\">Add Rank</button></div></div><br>";
				for(i=1;i<responseObject.length;i++){
					divObj.innerHTML= divObj.innerHTML+"<div id=\""+responseObject[i].username+"\">"+responseObject[i].fname +" "+ responseObject[i].lname+" <div class=\"floatright\"> <input type=\"number\" id=\""+responseObject[i].username+"rank\" placeholder=\"rank\"><button onclick=\"updateranking('"+responseObject[i].username+"','FS15')\">Add Rank</button></div></div><br>";
				}
				}
				var reqURL = "assign.php";
				//document.getElementById(user+'test').innerHTML = 'removing...';
			    xmlHttp.open("GET", reqURL, true);
			    xmlHttp.send();

			}
			</script>
	</head>
<body onload="init()">
	<!-- Header/Footer -->

		<div class="header shadowheader">
			<h1>Admin Page</h1>
		</div>

		<div class="footer shadowfooter">
			<h4>Copyright &copy; Group G - Computer Science Department</h4>
		</div>
	
	<!-- View Apps/Home/Logout -->
	
		<div class="centeradminlogout">
			<br>				
			<!--<input class="home" type="submit" name="submit" value="Home" onclick="window.location.href ='../index.php'">-->
			<input class="fixadminlogout logout" type="submit" name="submit" value="Logout" onclick="window.location.href ='../../phpSQL/logout.php'">
		</div>
			<br>
				<div class="centerplsadmin" id="rank"></div>
			<br>
		<form method="POST" action="search.php">
			<div class="centerplsadmin">	
				<label class="floatleft">Search by Course Number: </label>
				<div class="floatright">
					<select type="text" name="courseNumb" id="courseSearch">
 					<option value="courseNumb">Select</option>
					<!--<option value="cs1050">CS1050</option>
					<option value="cs2050">CS2050</option>
					<option value="cs2830">CS2830</option>
					<option value="cs3050">CS3050</option>
					<option value="cs3330">CS3330</option>
					<option value="cs3380">CS3380</option>
					<option value="cs3530">CS3530</option>
					<option value="cs4320">CS4320</option>
					<option value="cs4380">CS4380</option>
					<option value="cs4610">CS4610</option>
					<option value="cs4830">CS4830</option> -->

					<?php
					while( $course = pg_fetch_array($courses, null, PGSQL_ASSOC)){
						echo "<option value=\"$course[c_id]\">$course[numb]</option>";
					}

					?>
				</select>
					<button type="submit" name="CSearch" value="search by course">Search</button>
						<br>
				</div>					
					<br><br>
				<label class="floatleft">Search by Applicant: </label>
				<div class="floatright">
					<input type="text" name="applicant_fName" id="applicantSearch" placeholder = "First Name"></input>
					<input type="text" name="applicant_lName" id="applicantSearch" placeholder = "Last Name"></input>
					<button type="submit" name="ASearch" value="search by applicant">Search</button>
						<br>
				</div>						
			</div>
		</form>

		<!--insert course-->
		<form method="POST" action="createcourses.php">
			<div class="centerplsadmin">
				<br><br>
				<label class="floatleft">Add a new:</label>
					<div class="floatright">
						<button type="submit" name="addCourse" value="add new course">Course</button>
		</form>		
						<button type="button" onclick="window.location.href='semester.php'">Semester</button>
						<button type="button" onclick="window.location.href='addprofessor.php'">Professor</button>
					</div>
			</div>
			
		<!-- View Apps -->
		
		<div class="centeradminapps">
			<br>
			<br>
			<form method="POST" action="search.php">
				<button type="submit" name="view_all" value="view all">View All Applicants/Courses</button>
			</form>	
		</div>
	</body>
</html>
