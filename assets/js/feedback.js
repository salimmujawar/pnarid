$(document).ready(function() {
	var text_max = 250;
    $('#feedbackTextLength').html(text_max + ' characters remaining');

    $('#feedbackMessage').keyup(function() {
        var text_length = $('#feedbackMessage').val().length;
        var text_remaining = text_max - text_length;

        $('#feedbackTextLength').html(text_remaining + ' characters remaining');
    });
    $('#feedbackSubmit').click(function() {
    	resetFormErrors('feedbackForm');
    	if (!$("input[name='feedbackScore']:checked").val()) {
    		$('#feedbackScoreSpan').html('Please select a score');
    		$('#feedbackScoreBlock').addClass('has-error');
		}    		
		var submitForm = validateForm('feedbackForm');
		if(submitForm) {
			myApp.showPleaseWait();
			var $feedbackName     = $('#feedbackName');
			var $feedbackEmail    = $('#feedbackEmail');
			var $feedbackMobile   = $('#feedbackMobile');
			var $feedbackCategory = $('#feedbackCategory');
			var $feedbackScore    = $("input[name='feedbackScore']");
			var $feedbackMessage  = $('#feedbackMessage');
			 $.ajax({
				 url: siteUrl + "user/feedback_submit",
				 type: "POST",
				 data: {name: $feedbackName.val(), email: $feedbackEmail.val(), mobile: $feedbackMobile.val(), category: $feedbackCategory.val(), score: $feedbackScore.val(), message: $feedbackMessage.val()},
				 success: function (data) {
					 myApp.hidePleaseWait();
					 data = $.parseJSON(data);					 
					 //if there is an error
					 if(data.hasOwnProperty('error_msg') || data.hasOwnProperty('error_resp')){
						 if(data.hasOwnProperty('error_resp')) {
							 $('#feedbackFormError').show();
							 $('#feedbackErr').html(data.error_resp);
						 }else{
							 $.each(data.error_msg, function(k) {						
								var field_id = 'feedback' + ucFirst(k);							
								$('#' + field_id + 'Block').addClass('has-error');
								$('#' + field_id + 'Span').show();
								$('#' + field_id + 'Span').html(data.error_msg[k]);
							 }); 
						 }
						 
						 
					 }else if(data.result == "success") {	
						 resetFormErrors('feedbackForm');	
						 clearFormData('feedbackForm');	
						 $('#feedbackFormSuccess').show();
					 }
				 },
				 error: function () {
					 myApp.hidePleaseWait();
				 }
			 });
		}
    });
	
});