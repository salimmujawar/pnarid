<?php if(!empty($book_data->order_id)) {?>
<h3>Thank You</h3>
<hr />

<div class="static-page">
	<p>
		Thank you for booking with us your Order Id <strong><?php echo $book_data->order_id; ?></strong>.
	</p>
	<h3>Booking Details</h3>
	<hr />
	<h4 id="rideName"></h4>
	<span id="fromTo"> </span> <span id="bookType"></span>
	<table class="table">
		<thead>
			<tr>
				<th>Date</th>
				<th>Time</th>
				<th>Days</th>
				<th>Cars</th>
			</tr>
		</thead>
		<tbody>
			<tr>
                  	<?php
                  		$date = date('d-M-Y', strtotime($book_data->pickup_datetime));
                  		$time = date('h:i A', strtotime($book_data->pickup_datetime));
                  	?>
                     <td id="bookDate"><?php echo $date; ?></td>
				<td id="bookTime"><?php echo $time; ?></td>
				<td id="bookDay"><?php echo $book_data->days; ?></td>
				<td id="bookCars"><?php echo $book_data->rides; ?></td>
			</tr>
		</tbody>
	</table>
	<table class="table">
		<thead>
			<tr>
				<th>Basic Amount</th>
				<th>Service Tax</th>				
				<th>Advance</th>
				<th>Balance</th>
                                <th>Total Amount</th>
                                <th><b>Amount Paid</b></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td id="basicAmt"><?php echo $book_data->basic; ?></td>
				<td id="serviceTax"><?php echo $book_data->tax; ?></td>				
				<td id="bookAdvance"><?php echo ($book_data->basic - $book_data->due); ?></td>
				<td id="bookBal"><?php echo $book_data->due; ?></td>
                                <td id="bookTotal"><?php echo $book_data->total; ?></td>
                                <td id="bookTotal"><b><?php echo $book_data->paid; ?></b></td>
			</tr>
		</tbody>
	</table>
	<p>
		<strong>Would you like to share us on: </strong>
	</p>
</div>

<!--feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog"
	aria-labelledby="feedbackModalLabel" aria-hidden="true">
	<div class="vertical-alignment-helper">
		<div class="modal-dialog vertical-align-center">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>

					</button>
					<h4 class="modal-title" id="feedbackModalLabel">YOUR FEEDBACK WILL
						HELP US SERVE YOU BETTER</h4>

				</div>
				<div class="modal-body">
					<div id="feedbackFormError" class="alert alert-danger"
						style="display: none;">
						<strong>Failed!</strong> Please correct the errors.
					</div>
					<p>On a scale of 1 to 10, how likely are you to recommend
						PinARide.com to a friend or colleague?</p>
					<form id="feedbackForm" class="form-horizontal">
					<div id="feedbackScoreBlock" class="form-group">							
							<div class="col-sm-10">
								<div class="inner-addon left-addon">
									<div class="btn-toolbar text-center" role="toolbar"
										aria-label="Toolbar with button groups">
										<div class="btn-group" role="group" aria-label="First group">
											<button type="button" class="improve score btn btn-default" value="1">1</button>
											<button type="button" class="improve score btn btn-default" value="2">2</button>
											<button type="button" class="improve score btn btn-default" value="3">3</button>
											<button type="button" class="improve score btn btn-default" value="4">4</button>
										</div>
										<div class="btn-group" role="group" aria-label="Second group">
											<button type="button" class="improve score btn btn-default" value="5">5</button>
											<button type="button" class="improve score btn btn-default" value="6">6</button>
											<button type="button" class="improve score btn btn-default" value="7">7</button>
										</div>
										<div class="btn-group" role="group" aria-label="Third group">
											<button type="button" class="improve score btn btn-default" value="8">8</button>
											<button type="button" class="satisfied score btn btn-default" value="9">9</button>
											<button type="button" class="satisfied score btn btn-default" value="10">10</button>
										</div>
									</div>
									<span
										id="feedbackScoreSpan" class="help-block"></span>
								</div>
							</div>
						</div>
						
						<div id="feedbackImproveBlock" class="form-group" style="display: none;">							
							<div class="col-sm-10">
								<div class="inner-addon left-addon">
									<select class="form-control" name="feedbackImprove"
										id="feedbackImprove">
										<option value="please select">Please select the
											area we need to improve upon</option>
										<option value="Convenience Fee">Convenience Fee</option>
										<option value="Offers and Discounts">Offers and Discounts</option>
										<option value="Site Navigation and Layout">Site Navigation and Layout</option>
										<option value="Site Load Speed">Site Load Speed</option>
										<option value="Transaction Error">Transaction Error</option>										
									</select> <span
										id="feedbackImproveSpan" class="help-block"></span>
								</div>
							</div>
						</div>
						<input type="hidden" name="feedbackName" id="feedbackName" value="<?php echo $user->first_name.' '.$user->last_name;?>"/>
						<input type="hidden" name="feedbackEmail" id="feedbackEmail" value="<?php echo $user->email;?>"/>
						<input type="hidden" name="feedbackMobile" id="feedbackMobile" value="<?php echo $user->phone;?>"/>
						<input type="hidden" name="feedbackScore" id="feedbackScore" value="0"/>
						<div class="col-sm-offset-2">
							<button type="button" id="feedback" class="btn btn-danger">Submit</button>
							<button type="button" id="feedbackSkip" class="btn btn-default">Skip</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }else{ ?>
<h3>Sorry</h3>
<hr />
<div class="static-page">
	<p>Sorry there was some technical problem, sorry for the inconvinience please contact our tech support at: <?php echo CALL_US;?></p>
</div>
<?php }?>