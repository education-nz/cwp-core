<% if $NotLastPage %>
    <% require javascript('education/cwp-core:client/js/pagination.js') %>

    <div class="pagination pagination--loadmore">
        <a title="next" href="$NextLink" class="btn pagination--more">Load More</a>
    </div>
<% end_if %>
