$(document).ready(function() {
	var text_max = 250;
    $('#enquiryTextLength').html(text_max + ' characters remaining');

    $('#enquiryText').keyup(function() {
        var text_length = $('#enquiryText').val().length;
        var text_remaining = text_max - text_length;

        $('#enquiryTextLength').html(text_remaining + ' characters remaining');
    });
	$('#enquirySubmit').click(function() {	
		resetFormErrors('enquiryForm');	
		var submitForm = validateForm('enquiryForm');
		if(submitForm) {
			myApp.showPleaseWait();
			var $enquiryName     = $('#enquiryName');
			var $enquiryEmail    = $('#enquiryEmail');
			var $enquiryMobile   = $('#enquiryMobile');
			var $enquiryText     = $('#enquiryText');
			var $enquiryCampange = $('#enquiryCampange');
			 $.ajax({
				 url: siteUrl + "user/enquiry_submit",
				 type: "POST",
				 data: {name: $enquiryName.val(), email: $enquiryEmail.val(), mobile: $enquiryMobile.val(), text: $enquiryText.val(), campange: $enquiryCampange.val()},
				 success: function (data) {
					 myApp.hidePleaseWait();
					 data = $.parseJSON(data);					 
					 //if there is an error
					 if(data.hasOwnProperty('error_msg') || data.hasOwnProperty('error_resp')){
						 if(data.hasOwnProperty('error_resp')) {
							 $('#enquiryFormError').show();
							 $('#enquiryErr').html(data.error_resp);
						 }else{
							 $.each(data.error_msg, function(k) {						
								var field_id = 'enquiry' + ucFirst(k);							
								$('#' + field_id + 'Block').addClass('has-error');
								$('#' + field_id + 'Span').show();
								$('#' + field_id + 'Span').html(data.error_msg[k]);
							 }); 
						 }
						 
						 
					 }else if(data.result == "success") {	
						 resetFormErrors('enquiryForm');	
						 clearFormData('enquiryForm');	
						 $('#enquiryFormSuccess').show();
					 }
				 },
				 error: function () {
					 myApp.hidePleaseWait();
				 }
			 });
		}
	});
});