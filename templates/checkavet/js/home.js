jQuery.validator.addMethod("UKPostcode", function(value, element) {
	return this.optional(element) || /^(([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9]?[A-Za-z])))) [0-9][A-Za-z]{2}))$/.test(value);
}, "Please enter a valid UK postcode");
	
jQuery(document).ready(function(e) {
	
	var examplePhrase1 = 'EG: BN3 3DD';
	var examplePhrase2 = 'EG: example@example.com';
	
	var validator1 = jQuery('#vetsearch-module-form').submit(function(e) {
		if(jQuery('#mod-vetsearch-postcode').value == examplePhrase1)
			jQuery('#mod-vetsearch-postcode').value = '';
	}).validate({
		errorPlacement: function(error, element) {
			error.appendTo( element.parent().parent() );
			jQuery(error).addClass("error-bubble");
		}
	});
	
	var validator2 = jQuery('#servicessearch-module-form').submit(function(e) {
		if(jQuery('#mod-servicessearch-postcode').value == examplePhrase1)
			jQuery('#mod-servicessearch-postcode').value = '';
	}).validate({
		errorPlacement: function(error, element) {
			error.appendTo( element.parent().parent() );
			jQuery(error).addClass("error-bubble");
		}
	});
	
	var validator3 = jQuery('#leavefeedback-module-form').submit(function(e) {
		if(jQuery('#mod-leavefeedback-email').value == examplePhrase2)
			jQuery('#mod-leavefeedback-email').value = '';
	}).validate({
		errorPlacement: function(error, element) {
			error.appendTo( element.parent().parent() );
			jQuery(error).addClass("error-bubble");
		}
	});
});