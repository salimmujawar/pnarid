$(document).ready(function () {
    $('#signinPassword').bind('keypress', function (e) {
        if (e.which === 13) { // return
            $('#signIn').trigger('click');
        }
    });

    $('#signupMobile').bind('keypress', function (e) {
        if (e.which === 13) { // return
            $('#signUp').trigger('click');
        }
    });

    $('#datepick').datetimepicker({
        format: 'DD-MM-YYYY',
        useCurrent: true,
        defaultDate: current_date,
        //minDate: current_date,
        minDate: current_date
    });
    $('#returndatepick').datetimepicker({
        format: 'DD-MM-YYYY',
        useCurrent: true,
        defaultDate: current_date,
        //minDate: current_date,
        minDate: current_date
    });
    
    
});

function step1Click() {
    resetFormErrors('journeyStep1Form');	
    var submitForm = validateForm('journeyStep1Form');
    var $pickup = $.trim($('#journeySaddr').val());
    var $drop   = $.trim($('#journeyDaddr').val());
    var $jType  = $.trim($("input[type='radio'][name='journeyType']:checked").val());
    if (submitForm) {
        var $from = $pickup.split(",");
        var $to   = $drop.split(",");
        $('#journeyStep1Form').attr("action", "/search/cars?from=" + $from[0] + "&to=" + $to[0]);
        return true;
    }
    return false;
}


function initialize() {


        var defaultBounds = new google.maps.LatLngBounds(
                new google.maps.LatLng(19.075984, 72.877656)
                );
        var mumbai = new google.maps.LatLng(19.075984, 72.877656);
        var origin_input = document.getElementById('journeySaddr');
        var destination_input = document.getElementById('journeyDaddr');


        var options = {
                bounds: defaultBounds,
                //location: mumbai,
                //radius: '500',
                //types: ['(regions)'],
                types: ['geocode'],
                //types: ['(cities)'],
                componentRestrictions: {country: 'in'}
        };


        var autocomplete_origin = new google.maps.places.Autocomplete(origin_input, options);    
        var autocomplete_destination = new google.maps.places.Autocomplete(destination_input, options);
        // This will bind the map's bounds to the Autocomplete's bounds:
        //autocomplete_origin.bindTo('bounds', map);
         // Acting on Selecting a place
        google.maps.event.addListener(autocomplete_origin, 'place_changed', function() {
            var place = autocomplete_origin.getPlace();
            document.getElementById('saddrLat').value = place.geometry.location.lat();
            document.getElementById('saddrLng').value = place.geometry.location.lng();
            
        });
        // Acting on Selecting a place
        google.maps.event.addListener(autocomplete_destination, 'place_changed', function() {
            var place = autocomplete_destination.getPlace();

            document.getElementById('daddrLat').value = place.geometry.location.lat();
            document.getElementById('daddrLng').value = place.geometry.location.lng();
        });
        }

        google.maps.event.addDomListener(window, 'load', initialize);