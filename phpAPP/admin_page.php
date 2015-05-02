<?php
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: ../index.php");
	}	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Administrator Page</title>
			<script src="../js/jquery-1.11.2.min.js"></script>
			<script src="../js/ajax.js"></script>
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
				divObj.innerHTML= "<div id=\""+responseObject[i].username+"\">"+responseObject[i].fname +" "+ responseObject[i].lname+" <input type=\"number\" id=\""+responseObject[i].username+"rank\" placeholder=\"rank\"><button onclick=\"updateranking('"+responseObject[i].username+"','FS15')\">Add Rank</button></div><br>";
				for(i=1;i<responseObject.length;i++){
					divObj.innerHTML= divObj.innerHTML+"<div id=\""+responseObject[i].username+"\">"+responseObject[i].fname +" "+ responseObject[i].lname+" <input type=\"number\" id=\""+responseObject[i].username+"rank\" placeholder=\"rank\"><button onclick=\"updateranking('"+responseObject[i].username+"','FS15')\">Add Rank</button></div><br>";
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
				divObj.innerHTML= "<div id=\""+responseObject[i].username+"\">"+responseObject[i].fname +" "+ responseObject[i].lname+" <input type=\"number\" id=\""+responseObject[i].username+"rank\" placeholder=\"rank\"><button onclick=\"updateranking('"+responseObject[i].username+"','FS15')\">Add Rank</button></div><br>";
				for(i=1;i<responseObject.length;i++){
					divObj.innerHTML= divObj.innerHTML+"<div id=\""+responseObject[i].username+"\">"+responseObject[i].fname +" "+ responseObject[i].lname+" <input type=\"number\" id=\""+responseObject[i].username+"rank\" placeholder=\"rank\"><button onclick=\"updateranking('"+responseObject[i].username+"','FS15')\">Add Rank</button></div><br>";
				}
				}
				var reqURL = "assign.php";
				//document.getElementById(user+'test').innerHTML = 'removing...';
			    xmlHttp.open("GET", reqURL, true);
			    xmlHttp.send();

			}
			</script>
	</head>

	<body align='center' onload="init()">

<div id="rank">

</div>
		
		<form method="POST" action="adminActions/search.php">	
				<br/>
				<br/>
				<br/>
			<div align='center'> 
				
			 	<button type="submit" name="view_all" value="view all">View all applicants/courses</button><br>
			</div>
				<br/>
				<br/>
			<div align='center'>
				
				<input type="text" name="courseNumb" id="courseSearch" placeholder = "CS1050"></input><br>
				<button type="submit" name="CSearch" value="search by course">Course Search</button><br>
			</div>
				<br/>
				<br/>
			<div align='center'>
				
				<input type="text" name="applicant_fName" id="applicantSearch" placeholder = "first name"></input><br>
				<input type="text" name="applicant_lName" id="applicantSearch" placeholder = "last name"></input><br>
				<button type="submit" name="ASearch" value="search by applicant">Applicant Search</button><br>
			</div>
				<br/>
				<br/>
		</form>

		<!--insert course-->
		<form method="POST" action="adminActions/addcourses.php">	
			<button type="submit" name="addCourse" value="add new course">Add new course</button>
			<br>
			<br>
			<br>
		</form>

		<button type="button" onclick="window.location.href='adminActions/semester.php'">Add a new semester</button>
			<br>
			<br>
			<br>

		<button type="button" onclick="window.location.href='adminActions/addprofessor.php'">Add a new professor</button>
			<br>
			<br>
			<br>
		<button type="button" onclick="window.location.href='../../phpSQL/logout.php'">Log out</button>
	</body>
</html>