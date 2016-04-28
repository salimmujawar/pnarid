$(document).ready(function() {
	$('#cancelSubmit').click(function() {		
		resetFormErrors('cancelForm');	
		var submitForm = validateForm('cancelForm');
		if(submitForm) {
			myApp.showPleaseWait();
			var $cancelEmail     = $('#cancelEmail');
			var $cancelOrderId   = $('#cancelOrderid');
			var $cancelReason    = $('#cancelReason');
			 
			 $.ajax({
				 url: siteUrl + "booking/cancel_order",
				 type: "POST",
				 data: {email: $cancelEmail.val(), orderid: $cancelOrderId.val(), reason: $cancelReason.val()},
				 success: function (data) {
					 myApp.hidePleaseWait();
					 data = $.parseJSON(data);					 
					 //if there is an error
					 if(data.hasOwnProperty('error_msg') || data.hasOwnProperty('error_resp')){
						 if(data.hasOwnProperty('error_resp')) {
							 $('#cancelFormError').show();
							 $('#cancelErr').html(data.error_resp);
						 }else{
							 $.each(data.error_msg, function(k) {						
								var field_id = 'cancel' + ucFirst(k);							
								$('#' + field_id + 'Block').addClass('has-error');
								$('#' + field_id + 'Span').show();
								$('#' + field_id + 'Span').html(data.error_msg[k]);
							 }); 
						 }
						 
						 
					 }else if(data.result == "success") {
						 resetFormErrors('cancelForm');	
						 clearFormData('cancelForm');	
						 $('#cancelFormSuccess').show();
					 }
				 },
				 error: function () {
					 myApp.hidePleaseWait();
				 }
			 });
		}
	});
});