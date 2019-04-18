jQuery(document).ready(function($) {
    $(document).on('click', '#smfw_an1 .notice-dismiss', function(event) {
        data = {
            action : 'ft_supplier_dismiss_admin_notice',
        };

    $.post(ajaxurl, data, function (response) {
            console.log(response, 'DONE!');
        });
    });
});
