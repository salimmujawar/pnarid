$(document).ready(function(){
    CKEDITOR.replace( 'cmsContent' );
    $('#cmsSubmit').click(function(e) {
    	//e.preventDefault();
    	resetFormErrors('cmsForm');
    	var value = CKEDITOR.instances['cmsContent'].getData();
    	if (!value) {
    		$('#cmsContentSpan').html('Please add content');
    		$('#cmsContentBlock').addClass('has-error');
		}  
		var submitForm = validateForm('cmsForm');
		if(submitForm) {			
			$('form#cmsForm').submit();
		}else{
			return false;
		}
    });
});