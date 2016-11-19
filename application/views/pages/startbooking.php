<script type="text/javascript">
	var current_date = '<?php echo $current_date;?>';
	var current_time = '<?php echo $current_time;?>';
	var valid_time = '<?php echo $valid_time;?>';
</script>
<?php $user = isLogin();?>
<?php
$isLogin = FALSE; 
if(is_object($user) && empty($user->first_name)) {
	$isLogin = TRUE;
} ?>
<!-- Nav tabs -->
<h1 id="page-h1"><?php echo (!empty($h1_tag)) ? $h1_tag . ': ' : ''; ?></h1>
<ul id="myTabs" class="nav nav-tabs" role="tablist">
    <li role="presentation"
        class="tablink disabled"
        data-rel="1"><a href="#date" aria-controls="date" role="tab"
                    data-toggle="tab">1. Date</a></li>

    <li role="presentation" class="tablink disabled"
        data-rel="2"><a href="#vehicle" aria-controls="vehicle" role="tab"
                    data-toggle="tab">2. Vehicle</a></li>
    <li role="presentation"
        class="tablink active"
        data-rel="3"><a href="#checkout" aria-controls="checkout" role="tab"
                    data-toggle="tab">3. Checkout</a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
<div role="tabpanel"
		class="tab-pane active"
		id="checkout">
		<div class="row">
			<div class="col-md-6">
				<h3>Traveler Details</h3>
				<hr />            
            <?php if(is_object($user) && empty($user->first_name)) { ?>
            <div class="col-sm-offset-2 ">
					<input id="existing" type="checkbox" name="existing"
						value="existing" /> Existing user
				</div>
				<form id="bookLoginForm" class="form-horizontal"
					style="display: none;">
					<div id="bookFormError" class="alert alert-danger"
						style="display: none;">
						<strong>Failed!</strong> Please correct the errors.
					</div>
					<div id="bookEmail1Block" class="form-group">
						<label for="bookEmail1" class="col-sm-2 control-label">Email:</label>
						<div class="col-sm-offset-2 ">
							<div class="input-group">
								<span class="input-group-addon"> <span
									class="glyphicon glyphicon-envelope"></span>
								</span> <input type="text" class="form-control"
									data-validate="required, Email" name="bookEmail1"
									id="bookEmail1" maxlength="50" placeholder="Enter Email"
									value="" />

							</div>
							<span id="bookEmail1Span" class="help-block"></span>
						</div>
					</div>
					<div id="bookPassword1Block" class="form-group">
						<label for="bookPassword1" class="col-sm-2 control-label">Password:</label>
						<div class="col-sm-offset-2 ">
							<div class="input-group">
								<span class="input-group-addon"> <span
									class="glyphicon glyphicon-lock"></span>
								</span> <input type="password" class="form-control"
									data-validate="required" name="bookPassword1"
									id="bookPassword1" maxlength="50" placeholder="Enter Password"
									value="" />

							</div>
							<span id="bookPassword1Span" class="help-block"></span>
						</div>
					</div>
					<div class="col-sm-offset-2">
						<button id="bookLogin" type="button" class="btn btn-danger">Login</button>
					</div>
				</form>

				<form id="bookSignupForm" class="form-horizontal">
					<div id="bookSignupFormError" class="alert alert-danger"
						style="display: none;">
						<strong>Failed!</strong> Please correct the errors.
					</div>
					<div id="bookEmailBlock" class="form-group">
						<label for="bookEmail" class="col-sm-2 control-label">Email:</label>
						<div class="col-sm-offset-2 ">
							<div class="input-group">
								<span class="input-group-addon"> <span
									class="glyphicon glyphicon-envelope"></span>
								</span> <input type="text" class="form-control"
									data-validate="required, Email" name="bookEmail" id="bookEmail"
									maxlength="50" placeholder="Enter E-mail" value="" />

							</div>
							<span id="bookEmailSpan" class="help-block"></span>
						</div>
					</div>
					<div id="bookPasswordBlock" class="form-group">
						<label for="bookPassword" class="col-sm-2 control-label">Password:</label>
						<div class="col-sm-offset-2 ">
							<div class="input-group">
								<span class="input-group-addon"> <span
									class="glyphicon glyphicon-lock"></span>
								</span> <input type="password" class="form-control"
									data-validate="required" name="bookPassword" id="bookPassword"
									maxlength="50" placeholder="Enter Password" value="" />

							</div>
							<span id="bookPasswordSpan" class="help-block"></span>
						</div>
					</div>
					<div id="bookNameBlock" class="form-group">
						<label for="bookName" class="col-sm-2 control-label">Name:</label>
						<div class="col-sm-offset-2 ">
							<div class="input-group">
								<span class="input-group-addon"> <span
									class="glyphicon glyphicon-user"></span>
								</span> <input type="text" class="form-control"
									data-validate="required" name="bookName" id="bookName"
									maxlength="50" placeholder="Enter Name" value="" />

							</div>
							<span id="bookNameSpan" class="help-block"></span>
						</div>
					</div>
					<div id="bookMobileBlock" class="form-group">
						<label for="bookMobile" class="col-sm-2 control-label">Mobile:</label>
						<div class="col-sm-offset-2 ">
							<div class="input-group">
								<span class="input-group-addon"> <span
									class="glyphicon glyphicon-phone"></span>
								</span> <input type="text" class="form-control"
									data-validate="required" name="bookMobile" id="bookMobile"
									maxlength="50" placeholder="Enter Mobile number" value="" />                                                                        
							</div>
							<span id="bookMobileSpan" class="help-block"></span>
						</div>
					</div>

					<!--div id="bookLandmarkBlock" class="form-group">
						<label for="bookLandmark" class="col-sm-2 control-label">Pickup:</label>
						<div class="col-sm-offset-2 ">
							<div class="input-group">
								<span class="input-group-addon"> <span
									class="glyphicon glyphicon-globe"></span>
								</span> <input type="text" class="form-control"
									data-validate="required" name="bookLandmark" id="bookLandmark"
									maxlength="50" placeholder="Enter Landmark (Optional)" value="" />

							</div>
							<span id="bookLandmarkSpan" class="help-block"></span>
						</div>
					</div-->
					<div class="col-sm-offset-2">
						<button type="button" id="bookSignup" class="btn btn-danger">Register</button>
					</div>
				</form>
            <?php }else{ ?>
            <dl>
					<dt>Name:</dt>
					<dd><?php echo $user->first_name . ' ' .$user->last_name;?></dd>
					<dt>Email:</dt>
					<dd><?php echo $user->email;?></dd>
					<dt>Mobile:</dt>
					<dd><?php echo $user->phone;?></dd>
					<dt>Landmark:</dt>
					<dd> <?php echo $user->address;?></dd>
				</dl>           
            <?php }?>
         </div>
			<div class="col-md-6">
				<h3>Booking Details</h3>
				<hr />
                                <div id="bookError" style="display:none;" class="alert alert-danger" role="alert">Oh snap! Change a few things up and try submitting again.</div>
				<h4 id="rideName"><?php echo (!empty($ride_details['car_model'])) ? $ride_details['car_model'] : '';?></h4>
				<span id="fromTo">
					<?php echo (!empty($cust_query['journeySaddr']))?'From '.$cust_query['journeySaddr']:'';?>
					<?php echo (!empty($cust_query['journeyDaddr']))?' to ' . $cust_query['journeyDaddr']:'';?> 
				</span> 
                                <br/>
                                <span id="bookType">
					<?php echo (!empty($ride_details['category']))?'( ' . $ride_details['category'] . ' ) ':'';?> 
				</span>
                                <br/>
                                <span>
					Total distance charged <?php echo (!empty($ride_details['distance']))? $ride_details['distance'] . ' km.':'';?> 
				</span>
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
							<td id="bookDate"><?php echo (!empty($cust_query['journeyDate']))? $cust_query['journeyDate'] :'';?> </td>
							<td id="bookTime"><?php echo (!empty($ride_sess['time']))? $ride_sess['time'] :'';?> </td>
							<td id="bookDay"><?php echo (!empty($ride_details['days']))? $ride_details['days']  :'1';?> </td>
							<td id="bookCars">1</td>
						</tr>
					</tbody>
				</table>
				<table class="table">
					<thead>
						<tr>
							<th>Basic Amount</th>
							<?php if(APPLY_SERVICE_TAX) {?>
								<th>Service Tax</th>
							<?php } ?>
							<th>Total Amount</th>
							<th>Advance</th>
							<th>Balance</th>
						</tr>
					</thead>
					<tbody>
                                            <?php
                                                //print_r($ride_details);
                                                ?>
						<tr>
							<td id="basicAmt"><?php echo (!empty($ride_details['base_fare']))? money_format('%!i', $ride_details['base_fare']):'';?></td>
							<?php if(APPLY_SERVICE_TAX) {?>
								<td id="serviceTax"><?php echo (!empty($ride_details['tax']))?money_format('%!i',$ride_details['tax']):'';?></td>
							<?php } ?>
							<td id="bookTotal"><?php echo (!empty($ride_details['base_fare']))?money_format('%!i',$ride_details['base_fare']):'';?></td>
							<td id="bookAdvance"><?php echo (!empty($ride_details['advance']))?money_format('%!i',$ride_details['advance']):'';?></td>
							<td id="bookBal"><?php echo (isset($ride_details['payment']))?money_format('%!i',($ride_details['base_fare'] - $ride_details['payment'])):'';?></td>
						</tr>
                                                <tr>
                                                    <td colspan="4">
                                                         <div id="info-box" class="alert alert-info" role="alert">                
                                                            <strong>*Note: </strong>
                                                            <?php if($ride_details['journey'] == 'out') { ?>
                                                            <br/> * Driver allowance 250/- not included.
                                                            <?php } ?>
                                                            <br/>* Extra km, Toll & State Tax, Parking & Airport Entry not included.
                                                            <br/>* Pay advance to book the ride and rest amount pay direct to driver.

                </div>
                                                    </td>
                                                </tr>
					</tbody>
				</table>
				<hr />
             <?php if(is_object($user) && !empty($user->first_name)) { ?> 
             	<?php if(!empty($valid_ride['advance']) && !empty($ride_sess['code']) && !empty($ride_sess['reduce'])) {
             		echo '<span> <strong>Coupon applied: ' . $ride_sess['code'] .'</strong><span>';
             	}else{?>          
                                <!--div class="input-group">
					<input id="coupon" class="" type="checkbox" name="coupon"
						value="coupon" /> &nbsp;Apply Coupon <label
						class="glyphicon glyphicon-scissors"></label>
				</div>
				<form id="couponForm" class="form-inline" style="display: none;">
					<div id="couponCodeBlock" class="form-group">
						<label for="couponCode">Code: </label> <input type="text"
							class="form-control" data-validate="required" name="couponCode"
							id="couponCode" placeholder="Coupon" />

					</div>
					<button type="button" id="applyCoupon" class="btn btn-default">Apply</button>
					<span id="couponCodeSpan" class="help-block"
						style="color: #a94442;"></span>
				</form-->
				<?php } ?>
                                <div id="pickupAddrBlock" class="form-group">
                                    <label for="pickupAddr">Pickup: </label> <input type="text"
                                            class="form-control" data-validate="required" name="pickupAddr"
                                            id="pickupAddr" placeholder="Pickup location" />
                                    <span id="pickupAddrSpan" class="help-block"></span>
                                </div>
                                <div id="pickupTimeBlock" class="form-group">
                                    <label for="pickupTime">Time: </label> 
                                    
                                    <select class="form-control selectpicker" data-live-search="true" data-validate="required"
								name="pickupTime" id="pickupTime">

								<option value="">--:--</option>
                                                <?php 
                                                        $selectedTime = '';
                                                        if(isset($ride_sess['time'])) {
                                                                $selectedTime = $ride_sess['time'];
                                                        }
                                                        $selTimeStr = '';
                                                                        foreach($time as $key => $val){
                                                                                $selTimeStr = ($selectedTime == $val)?'selected':'';
                                                                                echo '<option '.$selTimeStr.' value="'.$val.'">'. $val."</option>";							
                                                                        }
                                                                ?>
                                          </select>
                                    <span id="pickupTimeSpan" class="help-block"></span>
                                </div>
                                
			<?php } ?>	
                        
			<input id="payBasic" type="hidden" name="payBasic" value="<?php echo (!empty($ride_details['base_fare']))?$ride_details['base_fare']:'';?>" /> <input
					id="payAdvance" type="hidden" name="payAdvance"
					value="<?php echo (!empty($ride_details['advance']))?$ride_details['advance']:'';?>" />
				<input id="payBal" type="hidden" name="payBal"
					value="<?php echo (isset($ride_details['base_fare']))?($ride_details['base_fare'] - $ride_details['advance']):'';?>" />
				<input id="payTotal" type="hidden" name="payTotal"
					value="<?php echo (!empty($ride_details['base_fare']))?$ride_details['base_fare']:'';?>" />
                                <input id="payProduct" type="hidden" name="payProduct"
					value="<?php echo (!empty($product))?$product:'';?>" />
                                <input id="payAmount" type="hidden" name="payAmount"
					value="<?php echo $ride_details['payment']; ?>" />
				<h4 id="youPay">
					<?php if(!empty($valid_ride['advance']) && !empty($ride_sess['code']) && !empty($ride_sess['reduce'])) {
						echo '<del class="discount">You pay: Rs. '.money_format('%!i',$valid_ride['advance']). '/-</del>';
					}else {
						echo (!empty($valid_ride['advance']))?'You pay: '.money_format('%!i', $valid_ride['advance']):'';
					}?>
				</h4>
				<h4 id="nowYouPay">
					<?php if(!empty($valid_ride['advance']) && !empty($ride_sess['code']) && !empty($ride_sess['reduce'])) {
						echo 'Now you pay: Rs. ' .($valid_ride['advance']  - $ride_sess['reduce']) . '/-';						
					}else{
						//echo (!empty($valid_ride['advance']))?money_format('%!i', $valid_ride['advance']):'';
					}?>
				</h4>
             <?php if(is_object($user) && !empty($user->first_name)) { ?>
            	<button id="payNow" type="button"
					class="btn btn-danger btn-lg">Pay Now Rs. <?php echo $ride_details['payment']; ?></button>
            <?php } ?>
         </div>
		</div>
	</div>
</div>
