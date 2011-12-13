$.validator.addMethod("UKPostcode", function(value, element) {
	return this.optional(element) || /^(([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9]?[A-Za-z])))) [0-9][A-Za-z]{2}))$/.test(value);
}, "Please enter a valid UK postcode");
	
$(document).ready(function(e) {
	
	var validator1 = $('#vetsearch-module-form').validate({
		errorPlacement: function(error, element) {
			error.appendTo( element.parent().parent() );
			$(error).addClass("error-bubble");
		}
	});
	
	var validator2 = $('#servicessearch-module-form').validate({
		errorPlacement: function(error, element) {
			error.appendTo( element.parent().parent() );
			$(error).addClass("error-bubble");
		}
	});
	
	var validator3 = $('#leavefeedback-module-form').validate({
		errorPlacement: function(error, element) {
			error.appendTo( element.parent().parent() );
			$(error).addClass("error-bubble");
		}
	});
});