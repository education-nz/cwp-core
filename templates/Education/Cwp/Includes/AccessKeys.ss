<section id="access-keys" class="visuallyhidden"><a id="access-keys-link" class="visuallyhidden"></a>
    <div class="section-heading">Access Keys</div>
    <ul>
        <% with $SiteConfig %>
            <% if $AccessKeyForListOfAccessKeys %><li><a href="$AccessKeyForListOfAccessKeys.Link" accesskey="0">Accessibility</a></li><% end_if %>
            <% if $AccessKeyForHome %><li><a href="$AccessKeyForHome.Link" accesskey="1">Home</a></li><% end_if %>
            <% if $AccessKeyForSiteMap %><li><a href="$AccessKeyForSiteMap.Link" accesskey="2">Site Map</a></li><% end_if %>
            <% if $AccessKeyForAboutThisSite %><li><a href="$AccessKeyForAboutThisSite.Link" accesskey="4">About this site</a></li><% end_if %>
            <% if $AccessKeyForLegal %><li><a href="$AccessKeyForLegal.Link" accesskey="8">Legal and privacy</a></li><% end_if %>
            <% if $AccessKeyForContact %><li><a href="$AccessKeyForContact.Link" accesskey="9">Contact</a></li><% end_if %>
            <% if $AccessKeyForLinkToUs %><li><a href="$AccessKeyForLinkToUs.Link" accesskey="/">Link to us</a></li><% end_if %>
            <li><a href="#main-content-link" accesskey="[">Skip to main content</a></li>
        <% end_with %>
    </ul>
</section> <!-- // end access-keys \\ -->
