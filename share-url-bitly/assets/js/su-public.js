(function($) {
    $(".su-copy-class").mouseout(function() {
        $(this).find('.su_tooltiptext').html("Click to Copy");
    });

    $('body').on('click', '.su-copy-class', function(event) {
        event.preventDefault();
        var $url = $(this).find('.copy_bitly_link').text();
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($url).select();
        document.execCommand("copy");
        $temp.remove();
        $(this).find('.su_tooltiptext').html("Copied: " + $url);
    });

    $('body').on('click', '.generate_bitly', function(event) {
        event.preventDefault();
        var $su_generate_button = $(this);
        var su_post_id = $su_generate_button.attr('data-post_id');
        if (!su_post_id) {
            $su_generate_button.addClass('generate_bitly_disable');
        }
        $.ajax({
            url: suJS.ajaxurl,
            data: {
                action: 'generate_su_bitly_url_via_ajax',
                post_id: su_post_id
            },
            method: 'POST',
            beforeSend: function() {
                $su_generate_button.addClass('generate_bitly_disable');
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status) {
                    $su_generate_button.closest('td').html(data.bitly_link_html);
                } else {
                    alert(data.message ? data.message : 'An error occurred');
                }
            },
            error: function(error) {
                alert('An error occurred');
                $su_generate_button.removeClass('generate_bitly_disable');
            },
            complete: function() {
                $su_generate_button.removeClass('generate_bitly_disable');
            }
        });
    });
})(jQuery);
