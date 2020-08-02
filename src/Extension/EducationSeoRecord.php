<?php

namespace Education\Cwp\Extension;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\View\ArrayData;
use SilverStripe\Lumberjack\Model\Lumberjack;
use SilverStripe\SiteConfig\SiteConfig;
use InvalidArgumentException;
use SilverStripe\Control\Controller;

/**
 * Adds social meta tags to a record.
 *
 */
class EducationSeoRecord extends DataExtension
{
    private static $db = [
        'MetaDCType'   => "Enum('Collection, Dataset, Event, Image, InteractiveResource, MovingImage, PhysicalObject, Service, Software, Sound, StillImage, Text', 'Text')",
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $metaDCTypeField = DropdownField::create('MetaDCType', 'Dublin Core type',
            $this->owner->dbObject('MetaDCType')->enumValues());

        $fields->addFieldToTab('Root.Metadata', $metaDCTypeField);
    }

    /**
     * Return all the meta data on the page. This performs all the logic and
     * fallbacks if values are not provided.
     *
     * @return ArrayData
     */
    public function getMetaData()
    {
        $config = SiteConfig::current_site_config();

        if ($this->owner->Parent() && $this->owner->Parent()->hasExtension(Lumberjack::class)) {
            $type = 'article';
        } else {
            $type = 'website ';
        }

        $templateData = new ArrayData([
            'MetaDCType'   => ($this->owner->MetaDCType) ? $this->owner->MetaDCType : 'Text',
            'MetaFacebook'   => ($config->FacebookURL) ?: '',
            'MetaURL'        => $this->owner->AbsoluteLink(),
            'ContentLocale' => Controller::curr()->ContentLocale,
            'MetaType'       => $type,
            'MetaSite'       => $config->Title,
            'MetaLastEdited' => date('c', $this->owner->dbObject('LastEdited')->getTimestamp()),
            'MetaPublished'  => date('c', $this->owner->dbObject('Created')->getTimestamp()),
            'FeaturedImage' => ($this->owner->hasMethod('FeaturedImage')) ? $this->owner->FeaturedImage() : null
        ]);

        if (!$templateData->MetaKeywords) {
            try {
                $keywords = $this->owner->getManyManyComponents('Terms');

                if ($keywords->count()) {
                    $tags = implode(', ', $keywords->map('ID', 'Name')->values());

                    $templateData->setField('MetaKeywords', $tags);
                }
            } catch (InvalidArgumentException $e) {
                // no keywords
            }
        }

        return $templateData;
    }
}
