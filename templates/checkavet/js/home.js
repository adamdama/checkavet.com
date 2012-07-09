jQuery.validator.addMethod("UKPostcode", function(value, element) {
	return this.optional(element) || /^ ?(([BEGLMNSWbeglmnsw][0-9][0-9]?)|(([A-PR-UWYZa-pr-uwyz][A-HK-Ya-hk-y][0-9][0-9]?)|(([ENWenw][0-9][A-HJKSTUWa-hjkstuw])|([ENWenw][A-HK-Ya-hk-y][0-9][ABEHMNPRVWXYabehmnprvwxy])))) ?[0-9][ABD-HJLNP-UW-Zabd-hjlnp-uw-z]{2}$/.test(value);
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