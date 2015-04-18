function addclass(course,grade,action){
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
	var reqURL = "addcourse.php?action="+action+"&username=<? echo $_SESSION[username] ?>&course="+course+"&grade="+grade;
	xmlHttp.open("GET", reqURL, true);
	xmlHttp.send();

}