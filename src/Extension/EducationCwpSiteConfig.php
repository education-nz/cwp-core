<?php

namespace Education\Cwp\Extension;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DB;
use SilverStripe\AssetAdmin\Forms\UploadField;
use Page;

class EducationCwpSiteConfig extends DataExtension
{
    private static $db = [
        'HasShield' => 'Boolean'
    ];

    private static $has_one = [
        'AccessKeyForListOfAccessKeys' => Page::class,
        'AccessKeyForHome' => Page::class,
        'AccessKeyForSiteMap' => Page::class,
        'AccessKeyForAboutThisSite' => Page::class,
        'AccessKeyForContact' => Page::class,
        'AccessKeyForLinkToUs' => Page::class,
        'AccessKeyForLegal' => Page::class,
        'DefaultFeaturedImage'    => Image::class,
        'DefaultFeaturedOGImage'  => Image::class,
    ];

    private static $owns = [
        'DefaultFeaturedOGImage',
        'DefaultFeaturedImage'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $featuredImageField = UploadField::create('DefaultFeaturedImage',
            'Default Featured Image');
        $featuredImageField->setDescription('Only appears on the homepage, landing page and header');

        $fields->addFieldToTab('Root.LogosIcons', $featuredImageField, 'Logo');

        $featuredImageField = UploadField::create('DefaultFeaturedOGImage',
            'Default Open Graph Image (site-wide)');
        $fields->addFieldToTab('Root.LogosIcons', $featuredImageField, 'Logo');

        $fields->addFieldsToTab('Root.AccessKeys', [
            TreeDropdownField::create('AccessKeyForListOfAccessKeysID', '‘Accessibility’ page ', SiteTree::class),
            TreeDropdownField::create('AccessKeyForHomeID', '‘Home’ page ', SiteTree::class),
            TreeDropdownField::create('AccessKeyForSiteMapID', '‘Site map’ page ', SiteTree::class),
            TreeDropdownField::create('AccessKeyForAboutThisSiteID', '‘About this site’ page ', SiteTree::class),
            TreeDropdownField::create('AccessKeyForContactID', '‘Contact’ page ', SiteTree::class),
            TreeDropdownField::create('AccessKeyForLinkToUsID', '‘Link to us’ page ', SiteTree::class),
            TreeDropdownField::create('AccessKeyForLegalID', '‘Legal and privacy’ page ', SiteTree::class),
        ]);

        $fields->removeByName('FacebookURL');
        $fields->removeByName('TwitterUsername');
        $fields->removeByName('GACode');
        $fields->removeByName('Translations');
    }

    public function markChanged()
    {
        DB::query(sprintf(
            'UPDATE SiteConfig SET LastEdited = NOW() WHERE ID = %s',
            $this->owner->ID
        ));
    }
}
