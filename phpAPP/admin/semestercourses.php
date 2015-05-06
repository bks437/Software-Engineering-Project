<?php
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: index.php");
	}
	include("../../connect/database.php");
	$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());
		$result=pg_query('SELECT c_id,numb,name,section,professor FROM DDL.Course');
		//=pg_execute($dbconn,"courses",array($_POST[semester].$_POST[year],$_POST[studentstart],$_POST[studentend],$_POST[facultystart],$_POST[facultyend]));
		$addall=pg_query('SELECT c_id FROM DDL.Course');
?>
<!DOCTYPE html>
<html>
<head>
	<title>CS4320 - Group G</title>
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<script type="text/javascript" src="../../js/ajax.js"></script>
	<script type="text/javascript">
			function addcourse(course,action){
		if(action=="Wants"){
			var e = document.getElementById(course);
			var grade = e.options[e.selectedIndex].value;
			console.dir(grade);
		}
		var xmlHttp = xmlHttpObjCreate();
		if(!xmlHttp){
			alert("This browser doesn't support this action");
			return
		}

		xmlHttp.onload = function(){
			var response = xmlHttp.responseText;
			var change = document.getElementById(course);
			console.dir(response);
			// document.getElementById('selected').innerHTML = JSON.parse(response);
			$('#'+action+course).removeClass("adding");
			if(response==0){
				console.dir("added");
				console.dir($('#'course).addClass("added"));
			}
			else
				$('#'course).addClass("remove");
		}
		$('#'+action+course).addClass("adding");
		var reqURL = "addcoures.php?action="+action+"&course="+course;
	    xmlHttp.open("GET", reqURL, true);
	    xmlHttp.send();

	}
		function addall(){
		<? while($add=pg_fetch_array($addall,null,PGSQL_ASSOC)){
			echo "addcourse(\"$add[c_id]\",\"add\");";
			}

		?>
		}

		function removecourse(course,action){
	if(action=="Wants"){
		var e = document.getElementById(course);
		var grade = e.options[e.selectedIndex].value;
		console.dir(grade);
	}
	var xmlHttp = xmlHttpObjCreate();
	if(!xmlHttp){
		alert("This browser doesn't support this action");
		return
	}

	xmlHttp.onload = function(){
		var response = xmlHttp.responseText;
		var isnert = document.getElementById('selected');
		console.dir(response);
		document.getElementById('selected').innerHTML = JSON.parse(response);
	}
	document.getElementById('selected').innerHTML = 'adding...';
	var reqURL = "addcoures.php?action="+action+"&course="+course;
    xmlHttp.open("GET", reqURL, true);
    xmlHttp.send();

	}
		function removeall(){
			<? $addall=pg_query('SELECT c_id FROM DDL.Course');
			while($add=pg_fetch_array($addall,null,PGSQL_ASSOC)){
			echo "addcourse(\"$add[c_id]\",\"remove\");";
			}

		?>

		}

		</script>
</head>
<body>
	<!-- Header/Footer -->

		<div class="header shadowheader">
			<h1>Add Semester Courses</h1>
		</div>

		<div class="footer shadowfooter">
			<h4>Copyright &copy; Group G - Computer Science Department</h4>
		</div>
		<button onclick="addall()">Add all</button> &nbsp<button onclick="removeall()">REMOVE</button><br>
<?
	while( $line = pg_fetch_array($result, null, PGSQL_ASSOC)){
		$i=0;
		//foreach ($line as $col_value){
		echo "<div class=\"coursewidth1\" id=\"".$line[c_id]."\">";
		echo "\t\t<div class=\"name\">$line[name]</div>\n";
		echo "\t\t<div class=\"numb\">$line[numb]</div>\n";
		echo "<div >$line[professor]</div>";
		//}
		echo "<button class=\"button courseml\" onclick=\"addcourse('$line[c_id]','add')\">Add</button>";
		echo "<button class=\"button courseml\" onclick=\"removecourse('$line[c_id]','remove')\">Remove</button></div>";
		echo "\t<br>\n";
		// foreach( $basicinfo as $col_value ){
		// 	if($i==0){
		// 		$i++;
		// 		continue;
		// 	}
		// 		echo "\t\t$col_value &nbsp\n";
		// 	}
		// echo "<button onclick=\"addcourse('$basicinfo[c_id]','add')\">ADD</button>&nbsp<button onclick=\"addcourse('$basicinfo[c_id]','remove')\">REMOVE</button>";
		// echo "\t<br>\n";
	}
?>

			<button onclick="window.location.href='createcourse.php'">Create a new course</button>
			<button onclick="window.location.href='index.php'">Finish</button>
		<div id="selected"></div>
	</body>
</html>
