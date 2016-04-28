$(document).ready(function() {
 	var maxField  = 10; //Input fields increment limitation
    var addButton = $('.addBtn'); //Add button selector
    var wrapper   = $('#rideDetail tbody'); //Input field wrapper
    //var newRowContent = ''; //New input field html 
    //newRowContent = $('#rideClone').clone(); // clone the temp field    
    //$('.removeRide').remove();
    //$('.cloneEle').hide();
    var x = 1; //Initial field counter is 1
    $(addButton).on('click', function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            //console.log(x);
            //console.log(newRowContent);
            var newRowContent = $.parseHTML(fieldHTML);
            /*var inputEle   = newRowContent.find('#joinusRide');
            var inputBlock = newRowContent.find('#joinusRideBlock');
            var inputSpan  = newRowContent.find('#joinusRideSpan');
            newRowContent.find('#rideClone').removeClass('cloneEle');
            
            $(inputEle).attr('id', 'joinusRide' + x);
            $(inputBlock).attr('id', 'joinusRide' + x + 'Block');
            $(inputSpan).attr('id', 'joinusRide' + x + 'Span');
            console.log(newRowContent);*/
            $('#rideDetail tbody').append(newRowContent); // Add field html            
            
        }
    });
    $(wrapper).on('click', '.removeBtn', function(e){ //Once remove button is clicked
        e.preventDefault();
        //console.log("remove");
        $(this).closest("tr").remove(); //Remove field html
        x--; //Decrement field counter
    });
    
    $('#joinUs').click(function(){   
		 resetFormErrors('joinUsForm');
		 var $name	    = $('#joinusName');
		 var $email	    = $('#joinusEmail');
		 var $pass      = $('#joinusPassword');
		 var $mobile    = $('#joinusMobile');
		 var $address   = $('#joinusAddress');
		 var $city      = $('#joinusCity');		 
		 var $rides		= [];		 
		 var $numbers    = [];
		 $("select[name='joinusRide[]'] option:selected").each(function() {
			 $rides.push( this.value );
		 });
		 
		 $("input[name='joinusNumber[]']").each(function() {
			 $numbers.push( this.value );
		 });

		 var submitForm = validateForm('joinUsForm');
    	if(submitForm) {		 	 
			 $.ajax({
				 url: siteUrl + "vendor/signup",
				 type: "POST",
				 contentType: "application/x-www-form-urlencoded",				 
				 data: {name: $name.val(), email: $email.val(), password: $pass.val(), mobile: $mobile.val(),address: $address.val(), city: $city.val(), ride: $rides, number: $numbers},
				 success: function (data) {
					 data = $.parseJSON(data);					 
					 //if there is an error
					 if(data.hasOwnProperty('error_msg') || data.hasOwnProperty('error_res')){
						 $('#joinUsFormError').show();
						 if(data.hasOwnProperty('error_res')) {
							 $('#joinUsFormError').html('<strong>Failed!</strong> ' + data.error_res);
						 }else{
							 $.each(data.error_msg, function(k) {						
								var field_id = 'joinus' + ucFirst(k);							
								$('#' + field_id + 'Block').addClass('has-error');
								$('#' + field_id + 'Span').show();
								$('#' + field_id + 'Span').html(data.error_msg[k]);							
							 });
						 } 
						 
					 }else {						 
						 resetFormErrors('joinUsForm');
						 clearFormData('joinUsForm');
						 $('#joinUsFormSuccess').show();
						 $('.extraRides').remove();
						 $('html, body').animate({
						        scrollTop: $("#joinUsFormSuccess").offset().top
						   }, 2000);
						 
					 }
				 },
				 error: function () {
					 
				 }
				 
			 });
		 }
    });
    
});