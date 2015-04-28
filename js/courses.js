function addclass(course,action){
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
		var reqURL = "addcourse.php?action="+action+"&course="+course+"&grade="+grade;
	    xmlHttp.open("GET", reqURL, true);
	    xmlHttp.send();

	}
function removeclass(course,action){
		if(action=="WantsRemove"){
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
			var remove = document.getElementById('selected');
			console.dir(response);
			document.getElementById('selected').innerHTML = JSON.parse(response);
		}
		document.getElementById('selected').innerHTML = 'removing...';
		var reqURL = "removecourse.php?action="+action+"&course="+course+"&grade="+grade;
	    xmlHttp.open("GET", reqURL, true);
	    xmlHttp.send();

	}