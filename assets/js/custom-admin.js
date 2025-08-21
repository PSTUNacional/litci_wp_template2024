jQuery(document).ready(function($) {
    $('.menu-order-input').on('change', function() {
        var postId = $(this).data('post-id');
        var newOrder = $(this).val();

        $.ajax({
            url: customAdminAjax.ajax_url,
            method: 'POST',
            data: {
                action: 'update_menu_order',
                post_id: postId,
                menu_order: newOrder,
                nonce: customAdminAjax.nonce
            },
            success: function(response) {
                if (response.success) {
                } else {
                }
            }
        });
    });
});

