<% if MetaData %>
    <% with MetaData %>
        <meta name="description" content="$MetaDesc.ATT" />
        <meta name="keywords" content="$MetaKeywords.ATT">
        <meta name="author" content="$MetaAuthor.ATT">

        <meta property="og:title" content="<% if $MetaTitle %>$MetaTitle.ATT<% else %>$Title.ATT<% end_if %>" />
        <meta property="og:site_name" content="$SiteConfig.Title.ATT"/>
        <meta property="og:url" content="$AbsoluteLink.ATT" />
        <meta property="og:description" content="$MetaDescription.ATT" />
        <meta property="og:type" content="$MetaType.ATT" />
        <meta property="og:locale" content="$ContentLocale.ATT" />
        <meta property="fb:app_id" content="$SiteConfig.FacebookURL.ATT" />

        <!-- Dublin Core Meta Tags -->
        <link rel="schema.dcterms" href="http://purl.org/dc/terms/"  />
        <meta name="dcterms.title" content="$MetaTitle.ATT – $SiteConfig.Title.ATT<% if $SiteConfig.Tagline %> – $SiteConfig.Tagline.ATT<% end_if %>"  />
        <meta name="dcterms.type" content="$MetaDCType.ATT"  />
        <meta name="dcterms.subject" content="$MetaKeywords.ATT"  />
        <meta name="dcterms.creator" content="$MetaAuthor.ATT" />
        <meta name="dcterms.language" content="en-NZ" >
        <meta name="dcterms.created" content="$MetaPublished"  />
        <meta name="dcterms.modified" content="$MetaPublished"  />

        <!-- Published Information -->
        <meta property="article:published_time" content="$MetaPublished"  />
        <meta property="article:modified_time" content="$MetaLastEdited"  />

        <% if $FeaturedImage %>
            <meta property="og:image" content="$FeaturedImage.getAbsoluteURL.ATT"/>
            <meta property="og:image:height" content="$FeaturedImage.Height"/>
            <meta property="og:image:width" content="$FeaturedImage.Width"/>
        <% else_if $SiteConfig.DefaultFeaturedOGImage %>
            <meta property="og:image" content="$SiteConfig.DefaultFeaturedOGImage.getAbsoluteURL"/>
            <meta property="og:image:height" content="$SiteConfig.DefaultFeaturedOGImage.Height"/>
            <meta property="og:image:width" content="$SiteConfig.DefaultFeaturedOGImage.Width"/>
        <% end_if %>
    <% end_with %>
<% end_if %>
