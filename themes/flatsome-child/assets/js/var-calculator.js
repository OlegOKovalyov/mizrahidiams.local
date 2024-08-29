jQuery(document).ready(function($) {

    // Change option values for Carats Weight from 2-0, 2-5, 3-0... to 2.0, 2.5, 3.0...
    var caratMin = parseFloat($('#carat_min').val());
    var caratMax = parseFloat($('#carat_max').val());
    var $select = $('#pa_carats-weight');

    if ($select.length && caratMin && caratMax) {
        $select.find('option').each(function() {
            var value = parseFloat($(this).val().replace('-', '.'));
            if (value < caratMin || value > caratMax) {
                $(this).remove();
            }
        });
    }

    $('#pa_carats-weight option').each(function() {
        let value = $(this).val();

        // Check whether the value with a dash and change the dash to a decimal point
        if (value.includes('-')) {
            let formattedValue = value.replace('-', '.');
            $(this).val(formattedValue);
        }
    });

    // Dinamic calculation the variable product price on Single Product
    function calculateFinalPrice() {
        $('#calculated-price').html('Loading...');

        let formData = {
            action: 'calculate_price',
            product_id: $('input[name="product_id"]').val()
        };

        // Check if each variation attribute element is present before adding it to formData
        if ($('select#pa_precious-metal').length > 0) {
            formData.precious_metal = $('select#pa_precious-metal').val();
        }

        if ($('select#pa_carats-weight').length > 0) {
            formData.carat_weight = $('select#pa_carats-weight').val();
        }

        if ($('select#pa_ring-size').length > 0) {
            formData.ring_size = $('select#pa_ring-size').val();
        }

        /*let formData = {
            action: 'calculate_price',
            product_id: $('input[name="product_id"]').val(),
            precious_metal: $('select#pa_precious-metal').val(),
            carat_weight: $('select#pa_carats-weight').val(),
            ring_size: $('select#pa_ring-size').val()
        };*/

        console.log(formData); // Debugging - verification of transmitted data

        $.ajax({
            type: 'POST',
            url: wc_add_to_cart_params.ajax_url,
            data: formData,
            success: function(response) {
                if(response.success) {
                    console.log('AJAX Response:', response); // Налагодження відповіді сервера
                    console.log(response);
                    let finalPrice = parseFloat(response.data.final_price);
                    if (!isNaN(finalPrice)) {
                        $('#calculated-price').html('$' + finalPrice.toFixed(2));
                } else {
                    $('#calculated-price').html('Error calculating price');
                        console.error('Invalid final price:', response.data.final_price);
                }
            } else {
                    $('#calculated-price').html('Error calculating price');
                    // console.error(response.data.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr); // Налагодження помилок AJAX
                console.error('AJAX Error:', error); // Налагодження помилок AJAX
                $('#calculated-price').html('Error calculating price');
                console.error('AJAX Error:', error); // Debugging - AJAX error output
            }
        });
    }

    $('form.variations_form').on('change', 'select', function() {
        calculateFinalPrice();
    });
});
