$(document).ready(function() {
	function callShow() {
		$('#userinfo-wrap').hide();
		$('#helplineBox').slideToggle();
	}
	
	function menuShow() {
		$('#helplineBox').hide();
		$('#userinfo-wrap').slideToggle();
	}
	$('#callus').click(function() {
		callShow();
	});
	$('#menu-btn').click(function(){
		menuShow();
	});
	$('#section').click(function(){
		if($('body').innerWidth() < 767){
			$('#helplineBox').slideUp();
			$('#userinfo-wrap').slideUp();
		}		
	});
	 //Reset Sign In
	 $('#signinModal').on('show.bs.modal', function (e) {
		 resetFormErrors('signinForm');
		 clearFormData('signinForm');		 
	 });
	 
	 //User Sign Up
	 $('#signIn').click(function(e){
		 resetFormErrors('signinForm');		 
		 var $email	    = $('#signinEmail');
		 var $pass      = $('#signinPassword');		 		 
		 var submitForm = validateForm('signinForm');
		 
		 if(submitForm) {
			 $.ajax({
				 url: siteUrl + "user/login",
				 type: "POST",
				 data: {email: $email.val(), password: $pass.val()},
				 success: function (data) {
					 data = $.parseJSON(data);					 
					 //if there is an error
					 if(data.hasOwnProperty('error_msg') || data.hasOwnProperty('error_res')){
						 $('#signinFormError').show();
						 if(data.hasOwnProperty('error_res')) {
							 $('#signinFormError').html('<strong>Failed!</strong> ' + data.error_res);
						 }else{
							 $.each(data.error_msg, function(k) {						
								var field_id = 'signin' + ucFirst(k);							
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
	 
	 //User Sign Up
	 $('#signUp').click(function(e){
		 resetFormErrors('signUpForm');
		 var $name	    = $('#signupName');
		 var $email	    = $('#signupEmail');
		 var $pass      = $('#signupPassword');
		 var $mobile    = $('#signupMobile');		 
		 var submitForm = validateForm('signUpForm');
		 
		 if(submitForm) {
			 $.ajax({
				 url: siteUrl + "user/signup",
				 type: "POST",
				 data: {name: $name.val(), email: $email.val(), password: $pass.val(), mobile: $mobile.val()},
				 success: function (data) {
					 data = $.parseJSON(data);					 
					 //if there is an error
					 if(data.hasOwnProperty('error_msg')){
						 $('#signUpFormError').show();
						 $.each(data.error_msg, function(k) {						
							var field_id = 'signup' + ucFirst(k);							
							$('#' + field_id + 'Block').addClass('has-error');
							$('#' + field_id + 'Span').show();
							$('#' + field_id + 'Span').html(data.error_msg[k]);
						 });
						 
					 }else {
						 $('#signUpForm').fadeOut(500, function(){
				                $('#signUpFormSuccess').show();
				          });
					 }
				 },
				 error: function () {
					 
				 }
				 
			 });
		 }
		
	 });
	 
	 //Reset Sign Up
	 $('#registerModal').on('show.bs.modal', function (e) {
		 resetFormErrors('signUpForm');
		 clearFormData('signUpForm');		 
	 });

});

var myApp;
myApp = myApp || (function () {
    var pleaseWaitDiv = $('<div class="modal fade" id="pleaseWaitDialog" tabindex="-1" role="dialog" aria-labelledby="pleaseWaitDialogModalLabel" aria-hidden="true"><div class="vertical-alignment-helper"><div class="modal-dialog vertical-align-center"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="signinModalLabel">Processing.....</h4></div><div class="modal-body"><div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"><span class="sr-only">80% Complete</span></div></div></div></div></div></div></div>');
    return {
        showPleaseWait: function() {
            pleaseWaitDiv.modal();
        },
        hidePleaseWait: function () {
            pleaseWaitDiv.modal('hide');
        },

    };
})();

/**
 * Validate a form
 * @param formName
 */
function validateForm(formName) {
	var submitForm = true;
	$.each($('input, select , textarea', '#' + formName),function(k){
		var $element    = $(this);
		var attr_id    =  $element.attr('id');
		var validation =  $element.attr('data-validate');
		
		if(validation != undefined && validation.length > 0 && $('#' + attr_id).is(':visible')) {
			var rules   = validation.split(',');
			var isValid = true; 
			for(var i = 0; i < rules.length; i++) {
				var validMethod = ucFirst($.trim(rules[i]));				
				switch(validMethod) {
					case "Required":
						isValid = isRequired($element);
						break;
					case "Email":
						isValid = isEmail($element);
						break;
					case "Char":
						isValid = isCharater($element);
						break;
					case "Numeric":
						isValid = isNumeric($element);
						break;		
					case "Alphanumeric":
						isValid = isAlphanumeric($element);
						break;	
					case "Mobile":
						isValid = isMobile($element);
						break;	
					case "Password":
						isValid = isPassword($element);
						break;													
					default:
						break;
				}				
			}	
			if(!isValid) {
				$('#' + attr_id + 'Block').addClass('has-error');
				$('#' + attr_id + 'Span').show();
				submitForm = false;
			}

		}
		
	});
	
	return submitForm;
}

/**
 * Reset form 
 * @param formName
 */
function resetFormErrors(formName){
	$('#' + formName).show();
	$('#' + formName +'Success').hide();
	$('#' + formName +'Error').hide();
	$.each($('input, select ,textarea', '#' + formName),function(k){		
		var attr_id = $(this).attr('id');
		$('#' + attr_id + 'Block').removeClass('has-error');
		$('#' + attr_id + 'Span').hide();
	});
}

/**
 * 
 * @param formName
 */
function clearFormData(formName) {
	$('#' + formName).show();
	$('#' + formName +'Success').hide();
	$('#' + formName +'Error').hide();
	$.each($('input, select ,textarea', '#' + formName),function(k){		
		$(this).val('');		
	});
}

/**
 * 
 * @param $element
 * @param $length
 * @returns {Boolean}
 */
function isLength($element, $length) {
	var $value   = $element.val();
	var $errSpan = $element.attr('id');
	if($value != undefined && $value.length > $length) {
		return true;
	}
	$('#' + $errSpan + 'Span').html('This field must be at least ' + $length + ' in length');
	return false;
}

/**
 * 
 * @param $element
 * @returns {Boolean}
 */

function isRequired($element) {
	var $value   = $element.val();
	var $errSpan = $element.attr('id');
	if($value != undefined && $value.length > 0) {
		return true;
	}
	$('#' + $errSpan + 'Span').html('This is required');
	return false;
}

/**
 * 
 * @param $element
 * @returns {Boolean}
 */
function isNumeric($element) {
	var $value = $element.val();
	var $errSpan = $element.attr('id');
	var numericExpression = /^[0-9]+$/;
	
	if($value.match(numericExpression)){
	    return true;
	}
	$('#' + $errSpan + 'Span').html('Should be Numeric');
	return false;	
}


/**
 * 
 * @param $element
 * @returns {Boolean}
 */
function isAlphanumeric($element) {
	var $value = $element.val();
	var $errSpan = $element.attr('id');
	var numericExpression = /^[a-z0-9]+$/;
	
	if($value.match(numericExpression)){
	    return true;
	}
	$('#' + $errSpan + 'Span').html('Should be Alphanumeric');
	return false;	
}

/**
 * 
 * @param $element
 * @returns {Boolean}
 */
function isPassword($element) {
	var $value = $element.val();
	var $errSpan = $element.attr('id');
	var numericExpression = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,20}$/;
	
	if($value.match(numericExpression)){
	    return true;
	}
	$('#' + $errSpan + 'Span').html('Password must be greater than 6 character, atleat 1 number and 1 special character');
	return false;	
}


/**
 * 
 * @param $element
 * @returns {Boolean}
 */
function isCharater($element) {
	var $value = $element.val();
	var $errSpan = $element.attr('id');
	var charExpression = /^[a-zA-Z ]+$/;	
	if($value.match(charExpression)){
	    return true;
	}
	$('#' + $errSpan + 'Span').html('Should be Character');
	return false;	
}


/**
 * 
 * @param $element
 * @returns {Boolean}
 */
function isEmail($element) {
	var $value = $element.val();
	var $errSpan = $element.attr('id');
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($value))
    {
      return (true);
    }
	$('#' + $errSpan + 'Span').html('Invalid Email Id');
	return false;	
}


/**
 * 
 * @param $element
 * @returns {Boolean}
 */
function isMobile($element) {	
	var $value = $element.val();
	var $errSpan = $element.attr('id');
	//var mobileExpression = /^\d{10}$/;
	var mobileExpression = /^([0|\+[0-9]{1,5})?([0-9]{12})$/;
	if($value.match(mobileExpression)){
	    return true;
	}
	$('#' + $errSpan + 'Span').html('Invalid Mobile number');
	return false;	
}


/**
 * 
 * @param string
 * @returns
 */
function ucFirst(string) {
	return string.substring(0, 1).toUpperCase() + string.substring(1).toLowerCase();
}


Number.prototype.formatMoney = function(c, d, t){
	var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };
 
function ChangeUrl(title, url) {
	if (typeof (history.pushState) != "undefined") {
        var obj = { Title: title, Url: url };
        history.pushState(obj, obj.Title, obj.Url);
        document.title = obj.Title;
    } else {
        console.log("Browser does not support HTML5.");
    }
}