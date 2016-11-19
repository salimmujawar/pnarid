$(document).ready(function () {
    $('#bookSignup').click(function () {
        resetFormErrors('bookSignupForm');
        var $name = $('#bookName');
        var $email = $('#bookEmail');
        var $pass = $('#bookPassword');
        var $mobile = $('#bookMobile');
        var $address = $('#bookLandmark');
        var submitForm = validateForm('bookSignupForm');

        if (submitForm) {
            myApp.showPleaseWait();
            $.ajax({
                url: siteUrl + "user/signup",
                type: "POST",
                data: {name: $name.val(), email: $email.val(), password: $pass.val(), mobile: $mobile.val(), address: $address.val(), book: true},
                success: function (data) {
                    data = $.parseJSON(data);
                    //if there is an error
                    if (data.hasOwnProperty('error_msg')) {
                        myApp.hidePleaseWait();
                        $('#bookFormError').show();
                        $.each(data.error_msg, function (k) {
                            var field_id = 'book' + ucFirst(k);
                            $('#' + field_id + 'Block').addClass('has-error');
                            $('#' + field_id + 'Span').show();
                            $('#' + field_id + 'Span').html(data.error_msg[k]);
                        });

                    } else if (data.result == "success") {
                        window.location.reload();
                    }
                },
                error: function () {

                }

            });
        }
    });

    $('#payNow').click(function () {
        if ($('#bookSignupForm').length) {
            validateForm('bookSignupForm');
        } else {
            var $payTotal = $('#payTotal');
            var $payBasic = $('#payBasic');
            var $payAdvance = $('#payAdvance');
            var $payBalance = $('#payBal');
            var $payProduct = $('#payProduct');
            var $payPickup = $('#pickupAddr');
            var $pickupTime = $('#pickupTime');

            if ($payPickup.val() == '') {
                $('#pickupAddrBlock').addClass('has-error');
                $('#pickupAddrSpan').show();
                $('#pickupAddrSpan').html('Please fill the pickup address');
                return false;
            }

            myApp.showPleaseWait();
            $.ajax({
                url: siteUrl + "booking/paynow",
                type: "POST",
                data: {total: $payTotal.val(), pickup: $payPickup.val(), advance: $payAdvance.val(), basic: $payBasic.val(), bal: $payBalance.val(), pickuptime: $pickupTime.val(), product: $payProduct.val()},
                success: function (data) {
                    data = $.parseJSON(data);
                    //if there is an error
                    if (data.hasOwnProperty('error_msg')) {
                        myApp.hidePleaseWait();
                        $('#bookError').fadeIn(500, function () {
                            $('#bookError').fadeOut(3000);
                        });
                        $.each(data.error_msg, function (k) {
                            var field_id = 'coupon' + ucFirst(k);
                            $('#' + field_id + 'Block').addClass('has-error');
                            $('#' + field_id + 'Span').show();
                            $('#' + field_id + 'Span').html(data.error_msg[k]);
                        });

                    } else if (data.result == "success") {
                        window.location = siteUrl + 'pg-post';
                    }
                },
                error: function () {

                }
            });
        }
    });
    $('.selectpicker').selectpicker({
        size: 4,
        dropupAuto: true,
    });
    $('#pickupTime').selectpicker('val', valid_time);

    $('#existing').change(function () {
        if (this.checked) {
            $('#bookLoginForm').show();
            $('#bookSignupForm').hide();
        } else {
            $('#bookLoginForm').hide();
            $('#bookSignupForm').show();
        }
    });

    $('#bookLogin').click(function () {
        resetFormErrors('bookLoginForm');
        var $email = $('#bookEmail1');
        var $pass = $('#bookPassword1');
        var submitForm = validateForm('bookLoginForm');
        if (submitForm) {
            myApp.showPleaseWait();
            $.ajax({
                url: siteUrl + "user/login",
                type: "POST",
                data: {email: $email.val(), password: $pass.val(), book: true},
                success: function (data) {
                    myApp.hidePleaseWait();
                    data = $.parseJSON(data);
                    //if there is an error
                    if (data.hasOwnProperty('error_msg') || data.hasOwnProperty('error_res')) {
                        $('#bookFormError').show();
                        if (data.hasOwnProperty('error_res')) {
                            $('#bookFormError').html('<strong>Failed!</strong> ' + data.error_res);
                        } else {
                            $.each(data.error_msg, function (k) {
                                var field_id = 'book' + ucFirst(k);
                                $('#' + field_id + 'Block').addClass('has-error');
                                $('#' + field_id + 'Span').show();
                                $('#' + field_id + 'Span').html(data.error_msg[k]);
                            });
                        }

                    } else {
                        window.location.reload();
                    }
                },
                error: function () {

                }

            });
        }
    });

});
