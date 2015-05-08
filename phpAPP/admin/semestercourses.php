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
	<script src="../../js/jquery-1.11.2.min.js"></script>
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
		$('#'+course).removeClass("remove");
		xmlHttp.onload = function(){
			var response = xmlHttp.responseText;
			var change = document.getElementById(course);
			console.dir(response);
			// document.getElementById('selected').innerHTML = JSON.parse(response);
			$('#'+course).removeClass("adding");
			if(response==0){
				console.dir("added");
				console.dir($('#'+course).addClass("added"));
			}
			else
				$('#'+course).addClass("error");
		}
		$('#'+course).addClass("adding");
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
	$('#'+course).removeClass("added");
		xmlHttp.onload = function(){
			var response = xmlHttp.responseText;
			var change = document.getElementById(course);
			console.dir(response);
			// document.getElementById('selected').innerHTML = JSON.parse(response);
			$('#'+course).removeClass("adding");
			if(response==0){
				console.dir("removed");
				console.dir($('#'+course).addClass("remove"));
			}
			else
				$('#'+course).addClass("error");
		}
		$('#'+course).addClass("adding");
	var reqURL = "addcoures.php?action="+action+"&course="+course;
    xmlHttp.open("GET", reqURL, true);
    xmlHttp.send();

	}
		function removeall(){
			<? $addall=pg_query('SELECT c_id FROM DDL.Course');
			while($add=pg_fetch_array($addall,null,PGSQL_ASSOC)){
			echo "removecourse(\"$add[c_id]\",\"remove\");";
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
			<br><br>
		<div class="centerplsscheader">
			<button onclick="addall()">Add All</button> &nbsp<button onclick="removeall()">Remove All</button>
				<br><br><br>
		</div>
<?
	while( $line = pg_fetch_array($result, null, PGSQL_ASSOC)){
		$i=0;
		//foreach ($line as $col_value){
		echo "<div class=\"centerplssc\">";
		echo "<div class=\"coursewidth1\" id=\"".$line[c_id]."\" style=\"height:21px\">";
		echo "<div class=\"floatleft\">$line[name]</div>\n";
		echo "<div class=\"floatright\"><div class=\"numb\">$line[numb]</div>\n";
		echo "<div class=\"floatleft\">$line[professor]</div>";
		//}
		echo "<button class=\"button courseml\" onclick=\"addcourse('$line[c_id]','add')\">Add</button>";
		echo "<button class=\"button courseml\" onclick=\"removecourse('$line[c_id]','remove')\">Remove</button></div>";
		echo "</div></div>";
		echo "\t<br>\n";
	}
?>
		<div align="center">
			<button onclick="window.location.href='createcourse.php'">Create a new course</button>
			<button onclick="window.location.href='index.php'">Finish</button>
		</div>
		<div id="selected"></div>
</body>
</html>