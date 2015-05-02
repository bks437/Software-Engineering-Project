<?php
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: ../../index.php");
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
	<body onload="init()">

<div id="rank">

</div>

	<!-- <div id="app2test">
	<input type="number" id="app2rank" placeholder="rank">
	<button onclick="updateranking('app2','FS15')">Add Rank</button>
	</div>
	<div id="app3test">
	<input type="number" id="app3rank">
	<button onclick="updateranking('app3','FS15')">Add Rank</button>
	</div> -->
		<!--Add ranking score-->
		<form method="POST" action="adminActions/add_rank.php">	
			<button type="submit" name="addrank" value="add rank scores">Add ranking scores</button>
			<br>
			<br>
			<br>
		</form>

		<!--Assign TA to course-->
		<form method="POST" action="adminActions/assign_ta.php">	
			<button type="submit" name="assignTA" value="assign TA">Assign TA(s) to course(s)</button>
			<br>
			<br>
			<br>
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
		<button type="button" onclick="window.location.href='../../phpSQL/home.php'">Add a new professor</button>
	</body>
</html>
