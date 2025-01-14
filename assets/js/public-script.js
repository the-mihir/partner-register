jQuery(document).ready(function($) {
    // Open modal when clicking on partner card
    $('.partner-card').click(function() {
        var partnerId = $(this).data('partner-id');
        
        // AJAX request to get partner details
        $.ajax({
            url: partnerAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_partner_details',
                partner_id: partnerId
            },
            success: function(response) {
                $('#partner-modal-body').html(response);
                $('#partner-modal').fadeIn();
            }
        });
    });

    // Close modal when clicking on close button or outside
    $('.partner-modal-close, .partner-modal').click(function(e) {
        if (e.target === this) {
            $('#partner-modal').fadeOut();
        }
    });
});