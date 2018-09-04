<% if $MoreThanOnePage %>
    <div class="pagination">
        <% if $NotFirstPage %>
            <a title="previous" href="$PrevLink" class="pagination--prev">&lt;</a>
        <% end_if %>

        <% loop $PaginationSummary(4) %>
            <% if $CurrentBool %>
                <a disabled="disabled" class="pagination--current">$PageNum</a>
            <% else %>
                <% if $Link %>
                    <a class="pagination--inactive" title="View page $PageNum of results" href="$Link">$PageNum</a>
                <% else %>
                    <a disabled="disabled" class="pagination--disabled">...</a>
                <% end_if %>
            <% end_if %>
        <% end_loop %>

        <% if $NotLastPage %>
            <a title="next" href="$NextLink" class="pagination--next">&gt;</a>
        <% end_if %>
    </div>
<% end_if %>
