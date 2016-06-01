$(document).ready(function() {
        $('#signinPassword').bind('keypress', function(e){            
            if(e.which === 13) { // return
               $('#signIn').trigger('click');
            }
        });
        
        $('#signupMobile').bind('keypress', function(e){             
            if(e.which === 13) { // return
               $('#signUp').trigger('click');
            }
        });
        
        
	$('.journeyType').click(function() {
		var $jType   = $('input[name=journeyType]:checked', '#journeyStep1Form');
		$('#journeyLocal').val('');
		$('#journeyDrop').attr('data-validate', 'required');
		switch($jType.val()) {
			case 'local':
					$('#journeyDropBlock').hide();
					$('#journeyDrop').attr('data-validate', '');
				break;
			case 'airport':
					$('#journeyDropBlock').show();
				break;
			default:
					$('#journeyDropBlock').show();
				break;
		}
	});
	
	$('.selectpicker').selectpicker({
		size: 4,
		dropupAuto: true,		
	});	
	$('#journeyTime').selectpicker('val', valid_time);
	
	$('#journeyPickup').change(function() {		
		var $jType   = $('input[name=journeyType]:checked', '#journeyStep1Form');
		if($jType.val() == 'local') {
			$('#journeyLocal').val($(this).val());
		}		
	});
	
	$("a[data-toggle='tab']").click(function(e){
		e.preventDefault();		
		if( $(this).parent().hasClass('disabled') ) {
			return false;
		}else{
			location.hash = $(this).attr("href");
		}		
	});
	  //setForm2();	
	$('.fare_details').click(function() {
		 $(this).next('.pop_details').toggle();		
	});
	 $('#datepick').datetimepicker({
		 format: 'DD-MM-YYYY',
		 useCurrent: true,
		 defaultDate: current_date,
		 //minDate: current_date,
		 minDate: current_date
	 });
	 /*$('#timepick').datetimepicker({
		 format: 'LT',
		 
	 });*/
	// Tab links
	$(".tablink").on('click', function (e) {
		e.preventDefault();		
		var thistab = this;
		var	current_rel = thistab.getAttribute("data-rel");		
		if ( $(this).hasClass('disabled') ) {			
			return false;
		}
	});
	
	function validateTime() {
		var $jDate   = $('#journeyDate');		
		var $jTime   = $('#journeyTime');
		var $dateNow = new Date(current_date).getTime();
		var myDate = $jDate.val();
		var chunks = myDate.split('-');
		var formattedDate = chunks[1]+'-'+chunks[0]+'-'+chunks[2];		
		var $postDate = new Date(formattedDate).getTime();		
		if($dateNow == $postDate) {			
			var timePosted = new Date(formattedDate + ' '+ $jTime.val()).getHours();
			var timeNow = new Date(current_date + ' '+ valid_time).getHours();			
			if (timePosted < timeNow)
			{
				$('#journeyTimeBlock').addClass('has-error');
				$('#journeyTimeSpan').show();
				$('#journeyTimeSpan').html('Time should be greated that 2hrs from now.');	
				return false;
			}			
		}
		return true;
	}
	
	$('#step-1').click(function() {
		resetFormErrors('journeyStep1Form');	
		var submitForm = validateForm('journeyStep1Form');		
		//date time validation
		var dtValidation = validateTime();
		
		if(submitForm && dtValidation) {			
			var $jPickup = $.trim($('#journeyPickup :selected').text());
			var $jDrop   = $.trim($('#journeyDrop :selected').text());
			var $jType   = $.trim($("input[type='radio'][name='journeyType']:checked").val());
                        //var $jTrip   = $.trim($("input[type='radio'][name='journeyTrip']:checked").val());
			
			$jPickup = ($jPickup != 'Location') ? $jPickup : '';
			$jDrop   = ($jDrop != 'Location') ? $jDrop : '';
			
			var $seoTitle = '';
			var $seoUrl = '';
			if ($jDrop =='') {
				$seoTitle = 'Car on rent for ' + $jPickup;
				$seoUrl   = siteUrl + $jType + '/car-search/' + $jPickup ;
			}else {
				$seoTitle = 'Car on rent from ' + $jPickup + ' to ' + $jDrop;
				$seoUrl   = siteUrl + $jType + '/car-search/' + $jPickup + '-to-' + $jDrop;
			}
			
			myApp.showPleaseWait();
			search_rides(1);
			ChangeUrl($seoTitle, $seoUrl.toLowerCase().replace(' ', '-'));
			$('#page-h1').html($seoTitle + ': ');
			location.hash = '#date';			
		}
		
	});
	
	/*Step2*/
	
	$('#car_list').on('click', '.button_select_car', function(){
		$('#journeyStep2FormError').hide();
		var key = $(this).attr('id');		
		if(!$('#paying_' + key).val()) {
			$('#journeyStep2FormError').show();
		}else{
			var $chekoutPage = siteUrl + 'checkout';
			var $seoTitle = 'Pinaride - Checkout';
			you_pay(key);
			ChangeUrl($seoTitle, $chekoutPage.toLowerCase().replace(' ', '-'));
			location.hash = '#vehicle';
		}
	});
	
	/*Booking Step3*/
	$('#existing').change(function() {
	    if(this.checked) {
	       $('#bookLoginForm').show();
	       $('#bookSignupForm').hide();
	    }else{
	    	$('#bookLoginForm').hide();
	    	$('#bookSignupForm').show();
	    }
	});
	
	$('#coupon').change(function() {
	    if(this.checked) {
	       $('#couponForm').show();	       
	    }else{
	    	$('#couponForm').hide();	    	
	    }
	});
	
	$('#bookLogin').click(function() {
		 resetFormErrors('bookLoginForm');		 
		 var $email	    = $('#bookEmail1');
		 var $pass      = $('#bookPassword1');		 		 
		 var submitForm = validateForm('bookLoginForm');
		 if(submitForm) {
			 myApp.showPleaseWait();
			 $.ajax({
				 url: siteUrl + "user/login",
				 type: "POST",
				 data: {email: $email.val(), password: $pass.val(), book: true},
				 success: function (data) {
					 myApp.hidePleaseWait();
					 data = $.parseJSON(data);					 
					 //if there is an error
					 if(data.hasOwnProperty('error_msg') || data.hasOwnProperty('error_res')){
						 $('#bookFormError').show();
						 if(data.hasOwnProperty('error_res')) {
							 $('#bookFormError').html('<strong>Failed!</strong> ' + data.error_res);
						 }else{
							 $.each(data.error_msg, function(k) {						
								var field_id = 'book' + ucFirst(k);							
								$('#' + field_id + 'Block').addClass('has-error');
								$('#' + field_id + 'Span').show();
								$('#' + field_id + 'Span').html(data.error_msg[k]);							
							 });
						 } 
						 
					 }else {
						 window.location.reload();
					 }
				 },
				 error: function () {
					 
				 }
				 
			 });
		 }	 
	});
	
	$('#bookSignup').click(function() {
		 resetFormErrors('bookSignupForm');
		 var $name	    = $('#bookName');
		 var $email	    = $('#bookEmail');
		 var $pass      = $('#bookPassword');
		 var $mobile    = $('#bookMobile');
		 var $address    = $('#bookLandmark');	
		 var submitForm = validateForm('bookSignupForm');
		 
		 if(submitForm) {
                        myApp.showPleaseWait();
			$.ajax({
				 url: siteUrl + "user/signup",
				 type: "POST",
				 data: {name: $name.val(), email: $email.val(), password: $pass.val(), mobile: $mobile.val(), address: $address.val(), book: true},
				 success: function (data) {
					 data = $.parseJSON(data);					 
					 //if there is an error
					 if(data.hasOwnProperty('error_msg')){
                                                myApp.hidePleaseWait();
						 $('#bookFormError').show();
						 $.each(data.error_msg, function(k) {						
							var field_id = 'book' + ucFirst(k);							
							$('#' + field_id + 'Block').addClass('has-error');
							$('#' + field_id + 'Span').show();
							$('#' + field_id + 'Span').html(data.error_msg[k]);
						 });
						 
					 }else if(data.result == "success") {
						 window.location.reload();
					 }
				 },
				 error: function () {
					 
				 }
				 
			 });			 
		 }
	});
	
	$('#applyCoupon').click(function() {
		resetFormErrors('couponForm');
		 var $coupon    = $('#couponCode');		
		 var submitForm = validateForm('couponForm');
		 
		 if(submitForm) {
			 $.ajax({
				 url: siteUrl + "coupon/apply",
				 type: "POST",
				 data: {code: $coupon.val()},
				 success: function (data) {
					 data = $.parseJSON(data);					 
					 //if there is an error
					 if(data.hasOwnProperty('error_msg')){
						 $.each(data.error_msg, function(k) {						
							var field_id = 'coupon' + ucFirst(k);							
							$('#' + field_id + 'Block').addClass('has-error');
							$('#' + field_id + 'Span').show();
							$('#' + field_id + 'Span').html(data.error_msg[k]);
						 });
						 
					 }else if(data.result == "success") {
						 var reduce = data.json_data.reduce;
						 var total  = 0;
						 
						 if($('#payBal').val() > 0) { 
							 total = $('#payAdvance').val();
						 }else{
							 total = $('#payTotal').val();
						 }
						 
						 if(total > 0) {
							 $('#youPay').html('<del class="discount">You pay: Rs. ' + parseInt(total) + '/-</del>');
							 $('#nowYouPay').html('Now you pay: Rs. ' + parseInt(total - reduce) + '/-');
							 $('#payAdvance').val(parseInt(total - reduce));
						 }
						 
					 }
				 },
				 error: function () {
					 
				 }
			 });
		 }
	});
	
	$('#payNow').click(function() {		
		if($('#bookSignupForm').length) {
			validateForm('bookSignupForm');
		}else{
			 var $payTotal   = $('#payTotal');
			 var $payBasic   = $('#payBasic');
			 var $payAdvance = $('#payAdvance');
			 var $payBalance = $('#payBal');
                         var $payPickup = $('#pickupAddr');
                         if($payPickup.val() == '') {
                            $('#pickupAddrBlock').addClass('has-error');
                            $('#pickupAddrSpan').show();
                            $('#pickupAddrSpan').html('Please fill the pickup address');
                             return false;
                         }
                         
                         myApp.showPleaseWait();
			 $.ajax({
				 url: siteUrl + "booking/paynow",
				 type: "POST",
				 data: {total: $payTotal.val(), pickup: $payPickup.val(), advance: $payAdvance.val(), basic: $payBasic.val(), bal: $payBalance.val()},
				 success: function (data) {
					 data = $.parseJSON(data);					 
					 //if there is an error
					 if(data.hasOwnProperty('error_msg')){
                                                myApp.hidePleaseWait();
                                                $('#bookError').fadeIn(500, function(){
                                                    $('#bookError').fadeOut(3000);
                                                });
						 $.each(data.error_msg, function(k) {						
							var field_id = 'coupon' + ucFirst(k);							
							$('#' + field_id + 'Block').addClass('has-error');
							$('#' + field_id + 'Span').show();
							$('#' + field_id + 'Span').html(data.error_msg[k]);
						 });
						 
					 }else if(data.result == "success") {
						 window.location = siteUrl + 'pg-post';					 
					 }
				 },
				 error: function () {
					 
				 }
			 });
		}
	});
});

function numDays(key){
	paying(key);
}

function paying(key) {
	var full    = $('#base_full_' + key).val();
	var advance = $('#base_advance_' + key).val();
	var pay     = $('#paying_' + key).val();	
	var days    = $('#days_' + key).val();
	var daysVal = '';
	var $jType   = $('input[name=journeyType]:checked', '#journeyStep1Form');
	if($jType.val() == 'local') {
		daysVal = $('#rideLocalDay').val();
                days = 1;
	}else {
		daysVal = days;
	}
	if(pay == "full") {
		$('#labelPay_' + key).html('Rs.' + parseInt(full * days) + '/-');
	}else if(pay == "advance") {
		$('#labelPay_' + key).html('Rs.' + parseInt(advance * days) + '/-');
	}
}

function setForm2() {
	if(s_vr > 0) {
		search_rides(2);
		$(".tablink[data-rel=1],[data-rel=2]").removeClass("disabled");
	}	
}

function select_ride() {
	$('#paying_' + s_vr).val(s_pay);
	$('#days_' + s_vr).val(s_days);
	paying(s_vr);
	you_pay(s_vr);
}

function search_rides($step) {
	var $jType   = $('input[name=journeyType]:checked', '#journeyStep1Form');
        var $jTrip   = $('input[name=journeyRoute]:checked', '#journeyStep1Form');
	var $jPickup = $('#journeyPickup');
	var $jDrop   = $('#journeyDrop');
	var $jDate   = $('#journeyDate');
	var $jDay    = $('#journeyDay');
	var $jTime   = $('#journeyTime');
	var $dropVal = '';
	var $Url     = '';
	var $Title   = ''; 
	if ($jType.val() == 'local') {
		$dropVal = $('#journeyLocal').val();
	}else {
		$dropVal = $jDrop.val();
	}	
	//$Url = 
	//ChangeUrl('', '');
	$.ajax({
		 url: siteUrl + "search/rides",
		 type: "POST",
		 contentType: "application/x-www-form-urlencoded",				 
		 data: {type: $jType.val(), trip: $jTrip.val(), pickup: $jPickup.val(), drop: $dropVal, date: $jDate.val(),day: $jDay.val(), time: $jTime.val(), step: $step},
		 success: function (data) {
			 data = $.parseJSON(data);
			 myApp.hidePleaseWait();
			 //if there is an error
			 if(data.hasOwnProperty('error_msg') || data.hasOwnProperty('error_res')){
				 $('#journeyStep1FormError').show();
				 if(data.hasOwnProperty('error_res')) {
					 $('#journeyStep1FormError').html('<strong>Failed!</strong> ' + data.error_res);
				 }else{
					 $.each(data.error_msg, function(k) {						
						var field_id = 'journey' + ucFirst(k);							
						$('#' + field_id + 'Block').addClass('has-error');
						$('#' + field_id + 'Span').show();
						$('#' + field_id + 'Span').html(data.error_msg[k]);							
					 });
				 } 
				 
			 }else {
				 $('#no_result').hide();
				 $('#car_list').show();
				 $(".tablink[data-rel=1],[data-rel=2]").removeClass("disabled");
				 $('#myTabs a[href="#vehicle"]').tab('show');
				 if(data.hasOwnProperty('result') && data.result == 'not_found') {
					 $('#no_result').show();
					 $('#car_list').hide();
					 return false;
				 }
				 /*if($step ==1) {
					 $(".tablink[data-rel=1],[data-rel=2]").removeClass("disabled");
					 $('#myTabs a[href="#vehicle"]').tab('show');
				 }*/
				 var rides_li = ''; 
				 var jsonData = '';
				 jsonData = data.json_data;	
				 var ride_days = '';
				 $.each(JSON.parse(jsonData), function(key, val){	
					 ride_days = '';
					 var $jType   = $('input[name=journeyType]:checked', '#journeyStep1Form');
					 if($jType.val() != "local") {
						 ride_days = '<select id="days_'+ val.vr_id +'" name="car_count" class="form-control car_count" onchange="numDays('+ val.vr_id +');">\
							 				<option value="1">1 day</option>\
							 				<option value="2">2 day</option>\
											<option value="3">3 day</option>\
											<option value="4">4 day</option>\
											<option value="5">5 day</option>\
											<option value="5">6 day</option>\
											<option value="5">7 day</option>\
											<option value="5">8 day</option>\
											<option value="5">9 day</option>\
											<option value="5">10 day</option>\
							 			</select>';
			         }else {
			        	 ride_days = '<input type="hidden" name="rideLocalDay'+ val.vr_id +'" id="rideLocalDay'+ val.vr_id +'" value="1" />';
			         }
					 var car_img_url = 'assets/images/cars/';
					 if (val.url != '' && val.url != null) {
						 car_img_url += val.url;  
					 }else{
						 car_img_url += 'car-default-200x150.png';
					 }
					 rides_li += '<li class="clearfix" id="li_car_17">\
					   <div class="data_wrapper">\
						  <div class="picture left">\
							 <img class="car_image img-polaroid" src="'+siteUrl + car_img_url +'" width="100" alt="">\
						  </div>\
						  <div class="details clearfix">\
							 <h2 class="car_name">' + val.ride_name + '</h2> <span>(' + val.desc + ')</span>\
							 <span class="avail no text-danger hidden">Not Available</span>\
							 <input id="ride_id_'+ val.vr_id +'" type="hidden" value="'+ val.ride_id +'">\
							 <input id="vr_id_'+ val.vr_id +'" type="hidden" value="'+ val.vr_id +'">\
							 <ul class="car_properties" id="car_properties_17">\
								<li class="glyphicon glyphicon-user"><span class="eq_value">' + val.seats + '</span></li>\
								<li class="glyphicon "><span class="eq_value"><i class="kmicon"></i>' + val.per_km + 'Rs./km</span></li>\
							 </ul>\
							 <a href="#" data-toggle="modal" data-target="#detailModal">Details</a>\
						  </div>\
					   </div>\
					   <div class="price_wrapper"><span class="car_count"> <select class="form-control" id="paying_'+ val.vr_id +'" name="paying" onchange="paying('+ val.vr_id +')"><option value="full">full</option><option value="advance">advance</option></select>'+ ride_days +'</span>\
					   <div class="clearfix"></div>\
					   <div class="pric-l">\
					   <span class="car_price_int"> <label id="labelPay_'+val.vr_id+'">Rs. '+ val.full +'/-</label></span></div>\
					    <div class="booknow">\
					    <input id="'+val.vr_id+'" class="btn btn-danger button_select_car" type="button" value="Book Now">\
					    <input id="base_full_'+ val.vr_id +'" type="hidden" value="'+ val.full +'">\
					    <input id="base_advance_'+ val.vr_id +'"  type="hidden" value="'+ val.advance +'">\
					   </div>\
						  <div class="clearfix"></div>\
						  <!-- Price details Modal -->\
							<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">\
							  <div class="modal-dialog" role="document">\
							    <div class="modal-content">\
							      <div class="modal-header">\
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
							        <h4 class="modal-title" id="myModalLabel">Fare Details</h4>\
							      </div>\
							      <div class="modal-body">';							    
						  
							      	if($jType.val() == 'local') {							      
							      		rides_li += '<b>Fare Details</b><br/>' +
									       	'Basic Fare :   ' + val.full + '/-<br/>'+
									       	'Total Fare :  ' + val.full + '/-<br>' +
									       	'Minimum	charged hour / distance per day : 8 Hours / 80 Kms <br><br>' +
										'<b>If you will use car/cab more than 8 hours / 80 kms , extra' +
											'charges as follows: </b><br> After 8 Hours / 80 Kms : <br>' +
										'+ <label class="WebRupee">Rs</label> ' + val.per_km + ' / Km <br> + 100/ Hour <br><br>';
									 }else if($jType.val() == 'outstation') {
										 rides_li += '<b>Fare Details</b><br/>' + 							       	
								       			'Approx. Roundtrip distance :  ' + val.distance + 'Kms.<br/>' +							       	
								       			'Minimum charged distance :  300 Kms / Day  <br/> <br>' +
								       			'<b>If you will use car/cab more than 1 day (s) and ' + val.distance + ' Kms , extra charges as follows:  </b><br/>' + 								       			
								       			'+ <label class="WebRupee">Rs</label> ' + val.per_km + ' / Km <br/>'+
                                                                                        '+ <label class="WebRupee">Rs</label>  300 per day  driver charges. <br/><br>';
								       			
							       	}
							      	rides_li += '<b>Terms &amp; Conditions:</b><br> » One day means a one' +
											'calendar day ( from midnight 12 to midnight 12 ).<br>» Toll' +
											'taxes, parkings, state taxes paid by customer wherever is' +
											'applicable.<br>» For all calculations distance from pick up' +
											'point to the drop point & back to pick up point will be' +
											'considered.<br />' +  
									      '</div>' +
									      '<div class="modal-footer">' +
									        '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +        
									      '</div>' +
									    '</div>' +
									  '</div>' +
									'</div>';	
					rides_li += '<div class="car_availability"></div>\
					   </div>\
					</li>';
				 });
				 $('#car_list').html(rides_li);			 	 
				 //calling callback after rendering HTML
				 if(s_vr > 0) {
					 select_ride();
				 }
			 }
		 },
		 error: function () {
			 
		 }
		 
	 });
}


function you_pay(key) {
	var $pay  = $('#paying_' + key);			
	var $days = $('#days_' + key);
	var $ride = $('#ride_id_' + key);
	var $vr   = $('#vr_id_' + key);
	var $dayVal = '';
	var $jType   = $('input[name=journeyType]:checked', '#journeyStep1Form');
	if($jType.val() == 'local') {
		$dayVal = $('#rideLocalDay' + key).val();
	}else {
		$dayVal = $days.val();
	}
	$.ajax({
		url: siteUrl + "booking/index",
		 type: "POST",
		 contentType: "application/x-www-form-urlencoded",				 
		 data: {pay: $pay.val(), days: $dayVal, ride_id: $ride.val(), vr: $vr.val()},
		 success: function (data) {					 
			 data = $.parseJSON(data);					 
			 myApp.hidePleaseWait();
			 
			 if(data.hasOwnProperty('error_msg') || data.hasOwnProperty('error_res')){
				 $('#journeyStep2FormError').show();
				 if(data.hasOwnProperty('error_res')) {
					 $('#journeyStep2FormError').html('<strong>Failed!</strong> ' + data.error_res);
				 }else{
					 var error = '';
					 $.each(data.error_msg, function(k) {								
						error += data.error_msg[k] + '<br/>';							
					 });
					 $('#Step2Errors').html(error);
				 } 
				 
			 }else {
				 $(".tablink[data-rel=1],[data-rel=2],[data-rel=3]").removeClass("disabled");
				 $('#myTabs a[href="#checkout"]').tab('show');	
				 $('#rideName').html(data.json_data.ride_name);
				 $('#fromTo').html('from ' + data.json_data.pickup);
				 $('#fromTo').append(' to ' + data.json_data.drop);						 
				 $('#bookType').html('(' + data.json_data.type + ')');
				 $('#bookDate').html(data.json_data.date);
				 $('#bookTime').html(data.json_data.time);
				 $('#bookDay').html(data.json_data.days);
				 $('#bookCars').html('1');
				 $('#basicAmt').html('Rs. ' + data.json_data.basic + '/-');
				 $('#serviceTax').html('Rs. ' + data.json_data.tax + '/-');
				 $('#bookTotal').html('Rs. ' + data.json_data.total + '/-');
				 $('#bookAdvance').html('Rs. ' + data.json_data.advance + '/-');
				 $('#bookBal').html('Rs. ' + data.json_data.balance + '/-');
				 $('#payBasic').val( data.json_data.basic);						 
				 $('#payTotal').val(data.json_data.total);
				 $('#payAdvance').val(data.json_data.advance);
				 $('#payBal').val(data.json_data.balance);
				 if(data.json_data.balance == 0) {
					 $('#youPay').html('You pay: Rs. ' + data.json_data.total + '/-');
				 }else{
					 $('#youPay').html('You pay: Rs. ' + data.json_data.advance + '/-');
				 }
				 
			 }
		 },
		 error: function () {
			 
		 }
	});
}


window.onhashchange = function() {       			
	if (location.hash.length > 0) {        				  
		$('#myTabs a[href="'+location.hash+'"]').tab('show');
	} else {				
		$('#myTabs a[href="#date"]').tab('show');
	}			
}
