$(document).ready(function () {
    $("#type").change(function() {
        if ($(this).val() == "graduate") {
            $("#years").hide();
            $("#degrees").hide();
            $("#programs").show();
            $("#advisors").show();
			$("#click").show();
		}
		else if ($(this).val() == "undergraduate")  {
			$("#years").show();
            $("#degrees").show();
            $("#programs").hide();
            $("#advisors").hide();
			$("#click").show();
		}
		else {
			$("#years").hide();
            $("#degrees").hide();
            $("#programs").hide();
            $("#advisors").hide();
			$("#click").hide();
		} 
	}); 
});