$(document).ready(function() {	 
	$('#login').click(function(e){
		 resetFormErrors('loginForm');		 
		 var $email	    = $('#loginEmail');
		 var $pass      = $('#loginPassword');		 		 
		 var submitForm = validateForm('loginForm');
		 
		 if(submitForm) {
			 $.ajax({
				 url: siteUrl + "user/login",
				 type: "POST",
				 data: {email: $email.val(), password: $pass.val()},
				 success: function (data) {
					 data = $.parseJSON(data);					 
					 //if there is an error
					 if(data.hasOwnProperty('error_msg') || data.hasOwnProperty('error_res')){
						 $('#loginFormError').show();
						 if(data.hasOwnProperty('error_res')) {
							 $('#loginFormError').html('<strong>Failed!</strong> ' + data.error_res);
						 }else{
							 $.each(data.error_msg, function(k) {						
								var field_id = 'loginForm' + ucFirst(k);							
								$('#' + field_id + 'Block').addClass('has-error');
								$('#' + field_id + 'Span').show();
								$('#' + field_id + 'Span').html(data.error_msg[k]);							
							 });
						 } 
						 
					 }else {
						 document.location.href="/";
					 }
				 },
				 error: function () {
					 
				 }
				 
			 });
		 }
		
	 });
});