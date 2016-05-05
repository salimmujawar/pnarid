<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-header">
	<h2>SMS partner</h2>
</div>
<div class="static-page">
	<div class="bs-example" data-example-id="basic-forms">
		<div id="cmsFormSuccess" class="alert alert-success"
			style="display: none;">
			<strong>Thanks!</strong> for you valuable feedback.
		</div>
		<div id="cmsFormError" class="alert alert-danger"
			style="display: none;">
			<strong>Error! </strong> <span id="cancelErr">Please correct the
				errors.</span>
		</div>
		<form id="smsForm" class="form-horizontal" method="post" action="/admin/rides/sms_partner/<?php echo (!empty($booking_details->b_id)) ? $vendor_details->vendor_id . '/' . $booking_details->b_id : ''; ?>">

                
		<div id="vendorPhoneBlock"
			class="form-group">
			<label for="cmsSlug" class="col-sm-2 control-label">Vendor Phone: *</label>
			<div class="col-sm-10">
				<div class="input-group">
                                    <input name="vendor_phone" value="<?php echo (!empty($vendor_details->phone)) ? $vendor_details->phone : ''; ?>"/>
				</div>
				<span id="vendorPhoneSpan" class="help-block"></span>
			</div>

		</div>
		
		<div id="cmsTitleBlock"
			class="form-group">
			<label for="cmsTitle" class="col-sm-2 control-label">Booking ID: *</label>
			<div class="col-sm-10">
				<div class="input-group">
                                     <?php echo (!empty($booking_details->order_id)) ? $booking_details->order_id : ''; ?>
				</div>
				<span id="bookingIdSpan" class="help-block"></span>
			</div>
		
		</div>
		
		<div class="row pull-right">
			<a class="btn btn-default" href="/admin/rides">Cancel</a>
			<button id="cmsSubmit" type="submit" name="submit" class="btn btn-success">
				<span class="glyphicon glyphicon-send"></span> Send
			</button>
		</div>
		<br/><br/>
		</form>
	</div>
</div>