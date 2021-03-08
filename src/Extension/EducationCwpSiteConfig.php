<?php

namespace Education\Cwp\Extension;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DB;
use SilverStripe\AssetAdmin\Forms\UploadField;

class EducationCwpSiteConfig extends DataExtension
{
    private static $db = [
        'HasShield' => 'Boolean'
    ];

    private static $has_one = [
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
