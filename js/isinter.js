$(document).ready(function () {
    $("#status").change(function() {
        if ($(this).val() == "international") {
            $("#interinfo").show();
            $("#testinfo").hide();
            $("#test_schedule").hide();
            $("#disqualified").hide();
            $("#autoqualified").hide();
            $("#newstudent").hide();
            $("#onita").hide();
            $("#click").hide();
			$("#home").hide();
		}
		else if ($(this).val() == "noninternational")  {
			$("#interinfo").hide();
			$("#testinfo").hide();
			$("#test_schedule").hide();
			$("#disqualified").hide();
			$("#autoqualified").show();
			$("#newstudent").hide();
			$("#onita").hide();
			$("#click").show();
			$("#home").hide();
		}
		else{
			$("#interinfo").hide();
			$("#testinfo").hide();
			$("#testinfo2").hide();
			$("#test_schedule").hide();
			$("#disqualified").hide();
			$("#autoqualified").hide();
			$("#newstudent").hide();
			$("#onita").hide();
			$("#click").hide();
			$("#home").hide();
		} 
	}); 
});
$(document).ready(function () {
    $("#speaktest").change(function() {
        if ($(this).val() == "passed") {
			$("#interinfo").show();
            $("#testinfo").show();
			$("#testinfo2").show();
            $("#test_schedule").hide();
            $("#disqualified").hide();
            $("#autoqualified").hide();
            $("#newstudent").show();
            $("#onita").show();
            $("#click").show();
			$("#home").hide();
        }
        else if ($(this).val() == "scheduled")  {
	        $("#interinfo").show();
			$("#testinfo").hide();
			$("#testinfo2").hide();
			$("#test_schedule").show();
			$("#disqualified").hide();
			$("#autoqualified").hide();
			$("#newstudent").show();
			$("#onita").show();
			$("#click").show();
			$("#home").hide();
        }
	    else if ($(this).val() == "notscheduled")  {
            $("#interinfo").show();
            $("#testinfo").hide();
			$("#testinfo2").hide();
            $("#test_schedule").hide();
            $("#disqualified").show();
            $("#autoqualified").hide();
            $("#newstudent").hide();
            $("#onita").hide();
            $("#click").hide();
			$("#home").show();
        }
        else{
            $("#interinfo").show();
            $("#testinfo").hide();
			$("#testinfo2").hide();
            $("#test_schedule").hide();
            $("#disqualified").hide();
            $("#autoqualified").hide();
            $("#newstudent").hide();
            $("#onita").hide();
            $("#click").hide();
			$("#home").hide();
        } 
    });
});