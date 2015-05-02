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
			var change = document.getElementById(action+course);
			console.dir(response);
			// document.getElementById('selected').innerHTML = JSON.parse(response);
			$('#'+action+course).removeClass("adding");
			if(response==0){
				console.dir("added");
				console.dir($('#'+action+course).addClass("added"));
			}
			else
				$('#'+action+course).addClass("remove");
		}
		$('#'+action+course).addClass("adding");
		var reqURL = "addcourse.php?action="+action+"&course="+course+"&grade="+grade;
	    xmlHttp.open("GET", reqURL, true);
	    xmlHttp.send();

	}
function removecourse(course,action){
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
			var change = document.getElementById(action+course);
			console.dir(response);
			// document.getElementById('selected').innerHTML = JSON.parse(response);
			$('#'+action+course).removeClass("adding");
			if(response==0){
				console.dir("removed");
				console.dir($('#'+action+course).addClass("remove"));
			}
			else
				$('#'+action+course).addClass("adding");
		}
		$('#'+action+course).addClass("adding");
		var reqURL = "removecourse.php?action="+action+"&course="+course+"&grade="+grade;
	    xmlHttp.open("GET", reqURL, true);
	    xmlHttp.send();

	}