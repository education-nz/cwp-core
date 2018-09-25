(function($) {
    $(document).ready(function() {
        /**
         * Load more button with progressive enhancement, if javascript is
         * enabled it requests the XHR and displays the results.
         */
        $('body').on('click', '.pagination--more', function (e) {
            e.preventDefault();

            $('.pagination').remove();
            $('.loader').show();

            var btn = $(this)

            $.get($(this).attr('href'), function(data) {
              var results = $(data).find('.results--list .result')
              var pagination = $(data).find('.pagination')

              $('.results--list').append(results);
              $('.loader').hide();

              if (pagination.length > 0) {
                $('.results--list')
                  .append(
                    pagination.wrap('<p/>').parent().html()
                  )
              }
            })
        })
    })
})(jQuery);
