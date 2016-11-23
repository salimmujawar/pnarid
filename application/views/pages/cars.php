<!-- Nav tabs -->
<h1 id="page-h1"><?php echo (!empty($h1_tag)) ? $h1_tag . ': ' : ''; ?></h1>
<ul id="myTabs" class="nav nav-tabs" role="tablist">
    <li role="presentation"
        class="tablink disabled"
        data-rel="1"><a href="#date" aria-controls="date" role="tab"
                    data-toggle="tab">1. Date</a></li>

    <li role="presentation" class="tablink active"
        data-rel="2"><a href="#vehicle" aria-controls="vehicle" role="tab"
                    data-toggle="tab">2. Vehicle</a></li>
    <li role="presentation"
        class="tablink disabled"
        data-rel="3"><a href="#checkout" aria-controls="checkout" role="tab"
                    data-toggle="tab">3. Checkout</a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content">	
    <div role="tabpanel"
         class="tab-pane active"
         id="vehicle">
        <div class="row">

        </div>
        <div class="list_wrapper">

            <div id="journeyStep2FormError" class="alert alert-danger"
                 style="display: none;">
                <strong>Error!</strong> <span id="Step2Errors">Please select a ride
                    and payment(Full or Advance).</span>
            </div>

            <div id="no_result" class="alert alert-danger" role="alert" <?php echo (sizeof($ride_data) == 0) ? "" : "style='display:none; margin-top:20px'"; ?>>
                <strong>No Rides found!</strong>
                Please contact us at <?php echo CALL_US; ?> for help.
            </div>

            <?php if (sizeof($ride_data) > 0) { ?>
            <h3>From <?php echo $searchQuery['from']; ?>, to <?php echo $searchQuery['to']; ?>, <?php echo (!empty($number_days))?' for '. $number_days . ' days':'';?> total distance charged <?php echo $searchQuery['total_distance']; ?> km </h3>
                <div id="info-box" class="alert alert-info" role="alert">                
                    <strong>*Note: </strong>Driver allowance 250/- not included.<br/>Extra km, Toll Tax, State Tax, Parking & Airport Entry not included.

                </div>
            <form action="/booking/start" method="post" onsubmit="return bookNow();">
            <table class="table table-hover"> 
                <thead> 
                    <tr> 
                        <th>Car</th> <th>Category</th> <th>Fare(Rs.)</th> <th>Advance(Rs.)</th> <th></th> 
                    </tr> 
                </thead> 
                <tbody> 
                    <?php foreach ($ride_data as $key => $val) { 
                        if(!empty($val['ride_id'])) {?>
                    <tr> 
                        <th scope="row"><div class="picture left">
                                    <?php
                                    $img_url = 'assets/images/cars/';
                                    if (!empty($val['url'])) {
                                        $img_url .= $val['url'];
                                    } else {
                                        $img_url .= 'car-default-200x150.png';
                                    }
                                    ?>
                                    <img class="car_image img-polaroid"
                                         src="<?php echo base_url($img_url); ?>"
                                         width="100" alt="">
                                    <?php echo $val['car_model']; ?>
                                    
                                </div>
                            
                        </th> 
                        <?php 
                            $fare = addslashes(json_encode($val));
                        ?>
                        <td>
                            <?php echo $val['category']; ?>
                            <input type="hidden" id="ride_details_<?php echo $val['ride_id']; ?>" name="ride_details_<?php echo $val['ride_id']; ?>" value='<?php echo $fare; ?>'/>
                            <input type="hidden" id="product_<?php echo $val['ride_id']; ?>" name="product_<?php echo $val['ride_id']; ?>" value='<?php echo $val['ride_id']; ?>'/>
                        </td> 
                        
                        <td>Rs. <?php echo $val['base_fare']; ?>/-</td> 
                        <td><input type="radio" name="fare_<?php echo $val['ride_id']; ?>" onclick="javascript: setRide(<?php echo $val['ride_id']; ?>, <?php echo $val['advance']; ?>);" value='<?php echo $val['advance']; ?>'/> Rs. <?php echo $val['advance']; ?>/-</td> 
                        <td><div class="booknow">
                                    <input class="btn btn-danger button_select_car" type="submit" value="Book Now">                          
                                </div></td>
                    </tr> 
                    <?php } 
                    }?>
                    
                </tbody> 
            </table>
                <input type="hidden" name="selected_ride" id="selected_ride" value=""/>
                <input type="hidden" name="ride_details" id="ride_details" value=""/>
                <input type="hidden" name="product" id="product" value=""/>
                <input type="hidden" name="fare" id="fare" value=""/>
                </form>
            <?php } ?>
        </div>
    </div>
