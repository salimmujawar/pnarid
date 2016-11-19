function setRide(ride_id, fare) {
    $('#selected_ride').val(ride_id);
    $('#fare').val(fare);
     console.log(ride_id);
}
function bookNow() {
    var $ride   = $('#selected_ride').val();
    console.log($ride);
    if ($ride != 0) {
        if($jType != 0) {
            var $jType  = $.trim($("input[type='radio'][name='fare_" + $ride + "']:checked").val());    
            var $rideDetails = $('#ride_details_' + $ride).val();
            var $product = $('#product_' + $ride).val();            
            $('#ride_details').val($rideDetails);
            $('#product').val($product);
            
            return true;
        }
        
    }
    alert('Please select an option to book');
    
    return false;
    
}