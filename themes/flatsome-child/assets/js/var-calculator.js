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
        const $preciousMetal = $('select#pa_precious-metal');
        const $caratsWeight = $('select#pa_carats-weight');
        const $ringSize = $('select#pa_ring-size');
        if ($preciousMetal.length > 0) {
            formData.precious_metal = $preciousMetal.val();
        }

        if ($caratsWeight.length > 0) {
            formData.carat_weight = $caratsWeight.val();
        }

        if ($ringSize.length > 0) {
            formData.ring_size = $ringSize.val();
        }

        $.ajax({
            type: 'POST',
            url: wc_add_to_cart_params.ajax_url,
            data: formData,
            success: function(response) {
                if(response.success) {
                    console.log('AJAX Response:', response);
                    let finalPrice = parseFloat(response.data.final_price);
                    if (!isNaN(finalPrice)) {
                        // Format the price without .00 and add spaces for thousands
                        let formattedPrice = formatPrice(finalPrice);
                        $('#calculated-price').html('$' + formattedPrice);
                } else {
                    $('#calculated-price').html('Error calculating price');
                        console.error('Invalid final price:', response.data.final_price);
                }
            } else {
                    $('#calculated-price').html('Error calculating price');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                console.error('AJAX Error Status:', status);
                console.error('AJAX Error Details:', xhr);
                $('#calculated-price').html('Error calculating price');
            }
        });
    }

    function formatPrice(price) {
        // Remove the decimals if .00
        let formattedPrice = price.toFixed(2);
        formattedPrice = formattedPrice.replace(/\.00$/, '');
        // Add space for thousands
        formattedPrice = formattedPrice.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
        return formattedPrice;
    }

    $('form.variations_form').on('change', 'select', function() {
        calculateFinalPrice();
    });
});
