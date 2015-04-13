$(document).ready(function () {   /* We may not need js for courses. keeping this page blank just incase we do */
    $("#").change(function() {
        if ($(this).val() == "") {
            $("#").hide();
            $("#").hide();
            $("#").show();
            $("#").show();
		}
		else if ($(this).val() == "")  {
			$("#").show();
            $("#").show();
            $("#").hide();
            $("#").hide();
		}
		else {
			$("#").hide();
            $("#").hide();
            $("#").hide();
            $("#").hide();
		} 
	}); 
});