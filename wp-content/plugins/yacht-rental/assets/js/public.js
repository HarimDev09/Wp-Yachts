jQuery(document).ready(function($) {
    // Handle booking form submission
    $('#gy-booking-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var responseContainer = $('#gy-booking-response');
        
        // Show processing message
        responseContainer.html('<p>' + gy_public_vars.processing + '</p>').removeClass('error success');
        
        // Validate hour selection
        if ($('#gy-booking-hour').val() === '') {
            responseContainer.html('<p class="error">' + gy_public_vars.select_hour + '</p>').addClass('error');
            return;
        }
        
        // Submit form via AJAX
        $.ajax({
            url: gy_public_vars.ajaxurl,
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    responseContainer.html('<p class="success">' + response.message + '</p>').addClass('success');
                    form[0].reset();
                } else {
                    responseContainer.html('<p class="error">' + response.message + '</p>').addClass('error');
                }
            },
            error: function() {
                responseContainer.html('<p class="error">' + gy_public_vars.error_message + '</p>').addClass('error');
            }
        });
    });
    
    // Initialize date picker (minimum date = today)
    var today = new Date().toISOString().split('T')[0];
    $('#gy-booking-date').attr('min', today);
});