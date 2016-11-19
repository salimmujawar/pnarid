<h1>Car Rental: Mumbai Darshan</h1>
<hr/>
<script type="text/javascript">
	var current_date = '<?php echo $current_date;?>';
	
</script>
<form action="/booking/start" method="post">
    <?php foreach ($rides as $val) { ?>
        <div class="radio">
            <label>                
                <div class="picture left">
                    <img class="car_image img-polaroid"
                         src="<?php echo base_url('assets/images/cars/' . $val->url); ?>"
                         width="100" alt=""> 

                </div>
                <input type="radio" name="ride_id" id="ride_id_<?php echo $val->p_id; ?>" value="<?php echo $val->p_id; ?>" checked>
                <?php echo 'Rs. ' . $val->amount . '/- (' . $val->description . ')'; ?>
            </label>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-xs-4">            

            <div class='input-group date' id='datepick'>
                <label>Date:</label>
                <span class="input-group-addon"> <span
                        class="glyphicon glyphicon-calendar"></span>
                </span> <input type='text' class="form-control"
                               data-validate="required" name="journeyDate" placeholder="Journey date" id="journeyDate"
                               value="" />

            </div>
            <span id="journeyDateSpan" class="help-block"></span>

        </div>
    </div>
    <input type="hidden" name="custom_package" value="<?php echo $val->journey; ?>" />
    <button type="submit" class="btn btn-danger btn-lg">Book Now</button>
</form>
<h2>Mumbai Darshan places covered are: </h2>
<div class="container">
    <div class="row">
        <div class="col-xs-6">
            <ul class="list-group">
                <li class="list-group-item">	Siddhivinayak Temple	</li>
                <li class="list-group-item">	Gateway of India	</li>                
                <li class="list-group-item">	Taj Mahal Hotel	</li>
                <li class="list-group-item">	Haji Ali Dargha	</li>
                <li class="list-group-item">	Nariman Point	</li>
                <li class="list-group-item">	Prince of Wales Museum	</li>

            </ul>
        </div>
        <div class="col-xs-6">
            <ul class="list-group">
                <li class="list-group-item">	Jehangir Art Gallery	</li>
                <li class="list-group-item">	Marine Drive	</li>
                <li class="list-group-item">	Taraporewala Aquarium	</li>
                <li class="list-group-item">	Chowpathy Beach	</li>
                <li class="list-group-item">	And enroute - Church Gate	</li>
                <li class="list-group-item">	Victoria Terminus or CST (Chatrapati Shivaji Terminus). 	</li>

            </ul>
        </div>
    </div>
</div>  