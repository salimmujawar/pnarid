$(document).ready(function() {	 
	$('#feedbackModal').modal({show:true});
	$('.improve').click(function() {		
		$('#feedbackImproveBlock').show();		
	});
	$('.satisfied').click(function() {
		$('#feedbackImproveBlock').hide();
	});
	$('.score').click(function() {
		$('#feedbackScore').val($(this).val());
	});
	$('#feedbackSkip').click(function(){
		$('#feedbackModal').modal('hide');
	});
	$('#feedback').click(function() {
		$('#feedbackScoreSpan').hide();
		$('#feedbackImproveSpan').hide();
		var $feedbackName   = $('#feedbackName');
		var $feedbackEmail  = $('#feedbackEmail');
		var $feedbackMobile = $('#feedbackMobile');
		var $feedbackScore  = $('#feedbackScore');
		var $feedbackImprove = $('#feedbackImprove');
		if($feedbackScore.val() == 0) {
			$('#feedbackScoreBlock').addClass('has-error');
			$('#feedbackScoreSpan').show();
			$('#feedbackScoreSpan').html('Please select a score');
			return false;
		}
		if($feedbackScore.val() <= 8) {
			$('#feedbackImproveBlock').addClass('has-error');
			$('#feedbackImproveSpan').show();
			$('#feedbackImproveSpan').html('Please select a improvement');
			return false;
		}
		 $.ajax({
			 url: siteUrl + "user/feedback_submit",
			 type: "POST",
			 data: {name: $feedbackName.val(), email: $feedbackEmail.val(), mobile: $feedbackMobile.val(), score: $feedbackScore.val(), category: $feedbackImprove.val(), form: 'thankyou'},
			 success: function (data) {
				 data = $.parseJSON(data);					 
				 //if there is an error
				 if(data.hasOwnProperty('error_msg') || data.hasOwnProperty('error_res')){
					 $('#feedbackFormError').show();
					 if(data.hasOwnProperty('error_res')) {
						 $('#feedbackFormError').html('<strong>Failed!</strong> ' + data.error_res);
					 }else{
						 $.each(data.error_msg, function(k) {						
							var field_id = 'feedback' + ucFirst(k);							
							$('#' + field_id + 'Block').addClass('has-error');
							$('#' + field_id + 'Span').show();
							$('#' + field_id + 'Span').html(data.error_msg[k]);							
						 });
					 } 
					 
				 }else {
					 //window.location.reload();
					 $('#feedbackModal').modal('hide');
					 $('#feedbackScoreSpan').hide();
					 $('#feedbackImprove').hide();
				 }
			 },
			 error: function () {
				 
			 }
			 
		 });
	});
});