<!-- Nav tabs -->
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
<h1 id="page-h1"><?php echo (!empty($h1_tag))?$h1_tag . ': ':'';?></h1>
<ul id="myTabs" class="nav nav-tabs" role="tablist">
	<li role="presentation"
		class="tablink <?php echo (empty($ride_sess['step']))?'active':'';?> <?php echo (isset($ride_sess['step']) && $ride_sess['step'] == 0)?'active':'';?>"
		data-rel="1"><a href="#date" aria-controls="date" role="tab"
		data-toggle="tab">1. Date</a></li>
		<?php
			$step2 = 'disabled';
			if (!empty($ride_sess['step'])  && $ride_sess['step'] == 1) {
				$step2 = 'active';
			}else if(!empty($ride_sess['step'])  && $ride_sess['step'] > 1) {
				$step2 = '';
			} 
		?>
	<li role="presentation" class="tablink <?php echo $step2;?>"
		data-rel="2"><a href="#vehicle" aria-controls="vehicle" role="tab"
		data-toggle="tab">2. Vehicle</a></li>
	<li role="presentation"
		class="tablink <?php echo (isset($ride_sess['step'])  && $ride_sess['step'] == 2)?'active':'disabled';?>"
		data-rel="3"><a href="#checkout" aria-controls="checkout" role="tab"
		data-toggle="tab">3. Checkout</a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
	<!-- Dates panes -->
	<div role="tabpanel"
		class="tab-pane <?php echo (empty($ride_sess['step']))?'active':'';?> <?php echo (isset($ride_sess['step']) && $ride_sess['step'] == 0)?'active':'';?>"
		id="date">
		<div class="col-md-6">
			<div id="journeyStep1FormError" class="alert alert-danger"
				style="display: none;">
				<strong>Failed!</strong> Please correct the errors.
			</div>
                    <form id="journeyStep1Form" class="form-horizontal" method="post" action="/search/cars" onsubmit="return step1Click();">				
                            <div id="journeyRouteBlock" class="form-group">
					<label for="journeyRoute" class="col-sm-2 control-label">Trip: </label>
					<div class="col-sm-10">
                                                <?php
                                                $checkedRoute = '';            
                                                if (isset($ride_sess['trip'])) {
                                                    $checkedRoute = $ride_sess['trip'];
                                                } 
                                                ?>						  
                                                <label class="radio-inline"> <input type="radio"
							name="journeyRoute"
							<?php echo ($checkedRoute == 'round')?'checked':'';?>
							class="journeyType" value="round" checked/>Round
						</label> 
                                                <!--label class="radio-inline"> <input id="journeyRoute" type="radio"
							name="journeyRoute"
							<?php echo ($checkedRoute == 'one-way')?'checked':'';?>
							class="journeyType" value="one-way"  />One Way
						</label-->                                                 
						<span id="journeyRouteSpan" class="help-block"></span>
					</div>
				</div>
				<div id="journeySaddrBlock" class="form-group">
					<label for="journeySaddr" class="col-sm-2 control-label">Pickup: </label>
					<div class="col-sm-10">
						<div class='input-group'>
							<span class="input-group-addon"> <span
								class="glyphicon glyphicon-map-marker"></span>
							</span>                                                    
                                                <input type="text" class="form-control"
                                                    data-validate="required" name="journeySaddr" id="journeySaddr"
                                                    value="" maxlength="2048" placeholder="Pickup location"/>
                                                <input type="hidden" name="saddrLat"  value="" class="controls" id="saddrLat"/>
                                                <input type="hidden" name="saddrLng"  value="" class="controls" id="saddrLng"/>
						</div>
						<span id="journeySaddrSpan" class="help-block"></span>
					</div>
				</div>
				<?php
					$showDrop = TRUE;
					if (!empty($ride_sess['type']) && $ride_sess['type'] != 'outstation') {
						$showDrop = FALSE;
					} 
				?>
				<?php //if ( $showDrop ) {?>				
					<div id="journeyDaddrBlock" class="form-group" style="<?php echo (!$showDrop) ? 'display:none' : '';?>">
						<label for="journeyDaddr" class="col-sm-2 control-label">Drop: </label>
						<div class="col-sm-10">
							<div class='input-group'>
								<span class="input-group-addon"> <span
									class="glyphicon glyphicon-map-marker"></span>
								</span> 
                                                    <input type="text" class="form-control"
                                                    data-validate="required" name="journeyDaddr" id="journeyDaddr"
                                                    value="" maxlength="2048" placeholder="Drop location"/>
                                                    <input type="hidden" name="daddrLat"  value="" class="controls" id="daddrLat"/>
                                                    <input type="hidden" name="daddrLng"  value="" class="controls" id="daddrLng"/>
	
							</div>
							<span id="journeyDaddrSpan" class="help-block"></span>
						</div>
					</div>
				<?php //} ?>
				<div id="journeyDateBlock" class="form-group">
					<label for="journeyDate" class="col-sm-2 control-label">Date: </label>
					<div class="col-sm-10">
            	<?php
		            $selectedDate = '';
		            if (isset($ride_sess['date'])) {
		            	$selectedDate = $ride_sess['date'];
		            } 
		            ?>	
             	 <div class='input-group date' id='datepick'>
							<span class="input-group-addon"> <span
								class="glyphicon glyphicon-calendar"></span>
							</span> <input type='text' class="form-control"
								data-validate="required" name="journeyDate" id="journeyDate"
								value="<?php echo $selectedDate; ?>" />

						</div>
						<span id="journeyDateSpan" class="help-block"></span>
					</div>
				</div>
                            <div id="journeyDateBlock" class="form-group">
					<label for="journeyDate" class="col-sm-2 control-label">Return Date: </label>
					<div class="col-sm-10">
            	<?php
		            $selectedDate = '';
		            if (isset($ride_sess['date'])) {
		            	$selectedDate = $ride_sess['date'];
		            } 
		            ?>	
             	 <div class='input-group date' id='returndatepick'>
							<span class="input-group-addon"> <span
								class="glyphicon glyphicon-calendar"></span>
							</span> <input type='text' class="form-control"
								data-validate="required" name="journeyReturndt" id="journeyReturndt"
								value="<?php echo $selectedDate; ?>" />

						</div>
						<span id="journeyDateSpan" class="help-block"></span>
					</div>
				</div>				

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" id="step-1" class="btn btn-danger btn-lg" value="Find Rates"/>
					</div>
				</div>
			</form>
		</div>	
		<div class="col-md-6 bestCarRentalPrices">
			<h2>Popular rental: </h2>
			<ul>
				<li><a
					href="<?php echo base_url('/car-on-rent/mumbai-darshan');?>"
					 > 
					<span class="image"><img src="<?php echo base_url('assets/images/mumbaidarshan_120X120.jpg');?>"
								alt="Car on rent for mumbai darshan">
					</span> 
					 <span class="best-car"> 						   
							<!-- span class="passengers bags"> 4 Adults, ₹ 1,600</span--> 
							<span class="price"><span>Car on rent for</span></span> 
                                                        <span class="carclass">Mumbai Darshan</span> 
							<span class="btn btn-primary">Select</span>
					</span>
				</a></li>
				<li><a
					href="<?php echo base_url('/car-on-rent/mumbai-to-mahabaleshwar');?>"
					 > 
					<span class="image"><img src="<?php echo base_url('assets/images/Mahableshwar_120X120.png');?>"
								alt="Car on rent for mahabaleshwar">
					</span> 
					 <span class="best-car"> 						    
							<!-- span class="passengers bags"> 4 Adults, ₹ 1,600</span--> 
							<span class="price"><span>Car on rent for</span></span> 
                                                        <span class="carclass">Mahabaleshwar</span>
							<span class="btn btn-primary">Select</span>
					</span>
				</a></li>
				<li><a
					href="<?php echo base_url('/car-on-rent/mumbai-to-khandala');?>"
					 > 
					<span class="image"><img src="<?php echo base_url('assets/images/khandala_120X120.jpg');?>"
								alt="Car on rent for khandala">
					</span> 
					 <span class="best-car"> 						   
							<!-- span class="passengers bags"> 4 Adults, ₹ 1,600</span--> 
							<span class="price"><span>Car on rent for</span></span> 
                                                        <span class="carclass">Khandala</span> 
							<span class="btn btn-primary">Select</span>
					</span>
				</a></li>
				<li><a
					href="<?php echo base_url('/car-on-rent/mumbai-to-imagica');?>"
					 >
					<span class="image"><img src="<?php echo base_url('assets/images/imagica_120X120.jpg');?>"
								alt="Car on rent for imagica">
					</span> 
					 <span class="best-car"> 						   
							<!-- span class="passengers bags"> 4 Adults, ₹ 1,600</span--> 
							<span class="price"><span>Car on rent for</span></span> 
                                                        <span class="carclass">Imagica</span> 
							<span class="btn btn-primary">Select</span>
					</span>
				</a></li>
				<li><a
					href="<?php echo base_url('/car-on-rent/mumbai-to-alibaug');?>"
					 > 
					<span class="image"><img src="<?php echo base_url('assets/images/alibaug_120X120.jpg');?>"
								alt="Car on rent for alibaug">
					</span> 
					 <span class="best-car"> 						   
							<!-- span class="passengers bags"> 4 Adults, ₹ 1,600</span--> 
							<span class="price"><span>Car on rent for</span></span> 
                                                        <span class="carclass">Alibaug</span>
							<span class="btn btn-primary">Select</span>
					</span>
				</a></li>
				<li><a
					href="<?php echo base_url('/car-on-rent/mumbai-to-kolad');?>"
					 >
					<span class="image"><img src="<?php echo base_url('assets/images/kolad_120X120.jpg');?>"
								alt="Car on rent for kolad">
					</span> 
					 <span class="best-car"> 						   
							<!-- span class="passengers bags"> 4 Adults, ₹ 1,600</span--> 
							<span class="price"><span>Car on rent for</span></span> 
                                                        <span class="carclass">Kolad</span> 
							<span class="btn btn-primary">Select</span>
					</span>
				</a></li>
			</ul>
		</div>
		<?php //if (!empty($cms)) {?>	
		<!-- Content -->
		<div class="clearfix"></div>
		<div class="row">
                    <h2>We Offer:</h2><hr/>
			<p><?php //echo $cms->content;?>
                         Are you looking for a safe and comfortable vehicle for your next family trip? Hopefully you are at the right place. Here at “Pin A Ride” we offer our riders a pleasant journey that they could never forget in their lifetime at the least price that no one can offer.
                        </p>
                        <p><br/>
                        We have 24*7 cab facility to pick you up at where you are and to drop you at your destination without any hustle. The major hotspots in Maharashtra from where you can avail our offers are Mumbai, Pune, Shirdi, Lonavia, Darshan, Mahabaleshwar, Nashik, Khandala etc. So you choose the location, we make you feel comfortable with our luxury service.There are varieties of vehicle from which you can hire one until you complete your journey. And for your convenience we have made our car booking services easier than ever. Most importantly you can avail our services at best prices and that would definitely fits your budget, because we treat our customers as king.
                        </p>
                        <p><br/>
                        We are most familiar for our Airport pickup and drop with wide variety of vehicles. We can make you catch your auspicious occasions within the city without any delay. This is why our cheapest car rental services are very famous among the Mumbai civilians. We have made many to feel happy with our services, give a chance to make you feel the same.
                        </p>
		</div>
		<!-- Content -->
		<?php //} ?>
		<!-- We Offer -->
		<div class="clearfix"></div>
		<div class="row we_offer">
                    <br/>
		  <div class="text-center col-xs-6 col-sm-3">
		  	<img class="img-thumbnail" alt="Indica on rental" src="<?php echo base_url('assets/images/cars/indica-215x127.jpg')?>" data-holder-rendered="true" />
		  	<h2>Economy</h2>
		  </div>
		  <div class="text-center col-xs-6 col-sm-3">
		  	<img class="img-thumbnail" alt="Etios on rental" src="<?php echo base_url('assets/images/cars/swift-215x127.png')?>" data-holder-rendered="true" />
		  	<h2>Sedan</h2>
		  </div>
		  <div class="text-center col-xs-6 col-sm-3">
		  	<img class="img-thumbnail" alt="Innova on rental" src="<?php echo base_url('assets/images/cars/inova-215x127.png')?>" data-holder-rendered="true" />
		  	<h2>Family</h2>
		  </div>
                    
		</div>		
		<!-- We Offer -->			
	</div>
	<!-- Dates panes -->
	<div role="tabpanel"
		class="tab-pane <?php echo (isset($ride_sess['step']) &&  $ride_sess['step'] == 1)?'active':'';?>"
		id="vehicle">
		<div class="row">
	
		</div>
		<div class="list_wrapper">
			<script type="text/javascript">
      	 	var s_ride_id = '<?php echo (isset($ride_sess['ride_id']))?$ride_sess['ride_id']:0;?>';
      	 	var s_vr      = '<?php echo (isset($ride_sess['vr_id']))?$ride_sess['vr_id']:0;?>';
      	 	var s_days    = '<?php echo (isset($ride_sess['days']))?$ride_sess['days']:0;?>';
      	 	var s_pay	  = '<?php echo (isset($ride_sess['pay']))?$ride_sess['pay']:0;?>';
      	 	var s_type	  = '<?php echo (isset($ride_sess['type']))?$ride_sess['type']:'outstation';?>';
      	 </script>
			<div id="journeyStep2FormError" class="alert alert-danger"
				style="display: none;">
				<strong>Error!</strong> <span id="Step2Errors">Please select a ride
					and payment(Full or Advance).</span>
			</div>
			
			<div id="no_result" class="alert alert-info" role="alert" <?php echo (sizeof($ride_data) == 0)?"":"style='display:none; margin-top:20px'";?>>
				<strong>No Rides found!</strong>
				Please contact us at <?php echo CALL_US;?> for help.
			</div>
			
			<ul id="car_list" class="carlist clist">
         	<?php if(sizeof($ride_data) > 0 && is_array($ride_data)) {?>
         		<?php foreach($ride_data as $key => $val) {?>
         			<li class="clearfix">
					<div class="data_wrapper">
						<div class="picture left">
							<?php 
								$img_url = 'assets/images/cars/';
								if (!empty($val['url'])) {
									$img_url .= $val['url'];	
								} else {
									$img_url .= 'car-default-200x150.png';
								}
							?>
							<img class="car_image img-polaroid"
								src="<?php echo base_url( $img_url );?>"
								width="100" alt="">
						</div>
						<div class="details clearfix">
                                                    <h2 class="car_name"><?php echo $val['ride_name']; ?></h2> <span>(<?php echo $val['desc']; ?>) </span>
							<span class="avail no text-danger hidden">Not Available</span> <input
								id="ride_id_<?php echo $val['vr_id']; ?>" type="hidden"
								value="<?php echo $val['ride_id']; ?>"> <input
								id="vr_id_<?php echo $val['vr_id']; ?>" type="hidden"
								value="<?php echo $val['vr_id']; ?>">
							<ul class="car_properties" id="car_properties_17">
								<li class="glyphicon glyphicon-user"><span class="eq_value"><?php echo $val['seats']; ?></span></li>								
								&nbsp;<li class="glyphicon"><span class="eq_value"><i class="kmicon"></i><?php echo $val['per_km']; ?>Rs./km</span></li>
                                                                <?php if(isset($ride_sess['type']) && $ride_sess['type'] == 'local') { ?>
                                                                &nbsp;<li class="glyphicon"><span class="eq_value"><i class="glyphicon glyphicon-time"></i>8hrs./80km</span></li>
                                                                <?php } ?>
							</ul>
							<!-- Button trigger modal -->
							<a href="#" data-toggle="modal" data-target="#detailModal">
							  Details
							</a>		

						</div>
					</div>
					<div class="price_wrapper">						
						<span class="car_count"> 
							<?php 
								$select_days = FALSE;
								if(!empty($ride_sess['days']) && $ride_sess['ride_id'] == $val['ride_id']) {
									$select_days = TRUE;
								}
							?>	
							<?php 
							$select_pay = FALSE;
								if(!empty($ride_sess['pay']) && $ride_sess['ride_id'] == $val['ride_id']) {
									$select_pay = TRUE;
								}
							?>	
							<select class="inline form-control"
								id="paying_<?php echo $val['vr_id']; ?>" name="paying"
								onchange="paying(<?php echo $val['vr_id']; ?>)">
									<option
										<?php echo ($select_pay && $ride_sess['pay'] == 'full')?'selected':'';?>
										value="full">full</option>
									<option
										<?php echo ($select_pay && $ride_sess['pay'] == 'advance')?'selected':'';?>
										value="advance">advance</option>
							</select> 
							<?php if(!empty($ride_sess['type']) && $ride_sess['type'] != 'local') {?>					
							<select id="days_<?php echo $val['vr_id']; ?>" name="car_count"
							class="inline form-control car_count"
							onchange="numDays(<?php echo $val['vr_id']; ?>);">
								<option
									<?php echo ($select_days && $ride_sess['days'] == 1)?'selected':'';?>
									value="1">1 day</option>
								<option
									<?php echo ($select_days && $ride_sess['days'] == 2)?'selected':'';?>
									value="2">2 day</option>
								<option
									<?php echo ($select_days && $ride_sess['days'] == 3)?'selected':'';?>
									value="3">3 day</option>
								<option
									<?php echo ($select_days && $ride_sess['days'] == 4)?'selected':'';?>
									value="4">4 day</option>
								<option
									<?php echo ($select_days && $ride_sess['days'] == 5)?'selected':'';?>
									value="5">5 day</option>
								<option
									<?php echo ($select_days && $ride_sess['days'] == 6)?'selected':'';?>
									value="6">6 day</option>
								<option
									<?php echo ($select_days && $ride_sess['days'] == 7)?'selected':'';?>
									value="7">7 day</option>
								<option
									<?php echo ($select_days && $ride_sess['days'] == 8)?'selected':'';?>
									value="8">8 day</option>
								<option
									<?php echo ($select_days && $ride_sess['days'] == 9)?'selected':'';?>
									value="9">9 day</option>
								<option
									<?php echo ($select_days && $ride_sess['days'] == 10)?'selected':'';?>
									value="10">10 day</option>
						</select>
							<?php }else {?>
								<input type="hidden" name="rideLocalDay<?php echo $val['vr_id']; ?>" id="rideLocalDay<?php echo $val['vr_id']; ?>" value="1" />
							<?php } ?>
					   
						</span>
						<div class="clearfix"></div>
						<div class="pric-l">
						<!-- span class="inline car_price">You paying</span--> 
						<span class="car_price_int"> 
							<?php
								$label_full = $val['full'];
								if($select_days && $select_pay) {
									$label_full = round($val['full'] * $ride_sess['days']);
								}                                                                 
							?>
							<label class="inline" id="labelPay_<?php echo $val['vr_id']; ?>">Rs. <?php echo money_format('%!i', $label_full); ?>/-</label>
						</span>
						</div>
						
						<div class="booknow">
							<input id="<?php echo $val['vr_id']; ?>"
							class="btn btn-danger button_select_car" type="button"
							value="Book Now"> <input
							id="base_full_<?php echo $val['vr_id']; ?>" type="hidden"
							value="<?php echo $val['full']; ?>"> <input
							id="base_advance_<?php echo $val['vr_id']; ?>" type="hidden"
							value="<?php echo $val['advance']; ?>"> 
						</div>
						<div class="clearfix"></div>
							<!-- Price details Modal -->
							<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        <h4 class="modal-title" id="myModalLabel">Fare Details</h4>
							      </div>
							      <div class="modal-body">
							      	<?php if(!empty($ride_sess['type']) && $ride_sess['type'] == 'local') {?>							      
								       	<b>Fare Details</b><br/> 							       	
									       	Basic Fare :   <?php echo money_format('%!i', $label_full);?>/-<br/>
									       	Total Fare :  <?php echo money_format('%!i', $label_full);?>/-<br>
									       	Minimum	charged hour / distance per day : 8 Hours / 80 Kms <br>							       	
										<br>
										<b>If you will use car/cab more than 8 hours / 80 kms , extra
											charges as follows: </b><br> After 8 Hours / 80 Kms : <br>
                                                                                        + <label class="WebRupee">Rs</label> <?php echo $val['per_km']; ?> / Km <br/>
                                                                                        + 100/ Hour <br>
                                                                                        
										<br>
									<?php }elseif(!empty($ride_sess['type']) && $ride_sess['type'] == 'outstation') { ?>
                                                                                <b>Fare Details</b><br/> 							       	
                                                                                Approx. Roundtrip distance :  <?php echo $val['distance'];?> Kms.<br/>							       	
                                                                                        Minimum charged distance :  <?php echo OUTSTATION_DEFAULT_KM; ?> Kms / Day  <br/>							       	
                                                                                <br>
                                                                                <b>If you will use car/cab more than 1 day (s) and <?php echo $val['distance'];?> Kms , extra charges as follows:  </b><br/>                                                                                           
                                                                                    + <label class="WebRupee">Rs</label> <?php echo $val['per_km']; ?> / Km <br/>        
                                                                                    + <label class="WebRupee">Rs</label>  300 per day  driver charges. <br/>
                                                                                        
                                                                                <br>
                                                                        <?php } ?>
									<b>Terms &amp; Conditions:</b><br> » One day means a one
									calendar day ( from midnight 12 to midnight 12 ).<br>» Toll
									taxes, parkings, state taxes paid by customer wherever is
									applicable.<br>» For all calculations distance from pick up
									point to the drop point & back to pick up point will be
									considered.<br />  
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
							      </div>
							    </div>
							  </div>
							</div>	

					</div>
				</li>
         		<?php } ?>
         	<?php } ?>

         </ul>
		</div>
	</div>
	<div role="tabpanel"
		class="tab-pane <?php echo (isset($ride_sess['step'])  &&  $ride_sess['step'] == 2)?'active':'';?>"
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
						<button id="bookLogin" type="button" class="btn btn-danger">Submit</button>
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
						<button type="button" id="bookSignup" class="btn btn-danger">Submit</button>
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
				<h4 id="rideName"><?php echo (!empty($valid_ride['ride_name'])) ? $valid_ride['ride_name'] : '';?></h4>
				<span id="fromTo">
					<?php echo (!empty($valid_ride['pickup']))?'From '.$valid_ride['pickup']:'';?>
					<?php echo (!empty($valid_ride['drop']))?' to ' . $valid_ride['drop']:'';?> 
				</span> <span id="bookType">
					<?php echo (!empty($ride_sess['type']))?'( ' . $ride_sess['type'] . ' ) ':'';?> 
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
							<td id="bookDate"><?php echo (!empty($ride_sess['date']))? $ride_sess['date'] :'';?> </td>
							<td id="bookTime"><?php echo (!empty($ride_sess['time']))? $ride_sess['time'] :'';?> </td>
							<td id="bookDay"><?php echo (!empty($ride_sess['days']))? $ride_sess['days']  :'';?> </td>
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
						<tr>
							<td id="basicAmt"><?php echo (!empty($valid_ride['basic']))? money_format('%!i', $valid_ride['basic']):'';?></td>
							<?php if(APPLY_SERVICE_TAX) {?>
								<td id="serviceTax"><?php echo (!empty($valid_ride['tax']))?money_format('%!i',$valid_ride['tax']):'';?></td>
							<?php } ?>
							<td id="bookTotal"><?php echo (!empty($valid_ride['total']))?money_format('%!i',$valid_ride['total']):'';?></td>
							<td id="bookAdvance"><?php echo (!empty($valid_ride['advance']))?money_format('%!i',$valid_ride['advance']):'';?></td>
							<td id="bookBal"><?php echo (isset($valid_ride['balance']))?money_format('%!i',$valid_ride['balance']):'';?></td>
						</tr>
					</tbody>
				</table>
				<hr />
             <?php if(is_object($user) && !empty($user->first_name)) { ?> 
             	<?php if(!empty($valid_ride['advance']) && !empty($ride_sess['code']) && !empty($ride_sess['reduce'])) {
             		echo '<span> <strong>Coupon applied: ' . $ride_sess['code'] .'</strong><span>';
             	}else{?>          
	            <div class="input-group">
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
				</form>
				<?php } ?>
                                <div id="pickupAddrBlock" class="form-group">
                                    <label for="pickupAddr">Pickup: </label> <input type="text"
                                            class="form-control" data-validate="required" name="pickupAddr"
                                            id="pickupAddr" placeholder="Pickup location" />
                                    <span id="pickupAddrSpan" class="help-block"></span>
                                </div>
			<?php } ?>	
                        
			<input id="payBasic" type="hidden" name="payBasic" value="<?php echo (!empty($valid_ride['basic']))?$valid_ride['basic']:'';?>" /> <input
					id="payAdvance" type="hidden" name="payAdvance"
					value="<?php echo (!empty($valid_ride['advance']))?$valid_ride['advance']:'';?>" />
				<input id="payBal" type="hidden" name="payBal"
					value="<?php echo (isset($valid_ride['balance']))?$valid_ride['balance']:'';?>" />
				<input id="payTotal" type="hidden" name="payTotal"
					value="<?php echo (!empty($valid_ride['total']))?$valid_ride['total']:'';?>" />
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
					class="btn btn-danger btn-lg">Pay Now</button>
            <?php } ?>
         </div>
		</div>
	</div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBH1jCjCG1Jd1SAUV1j97lLXjCAkFN9h4o&libraries=places"></script>
