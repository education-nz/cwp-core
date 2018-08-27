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
/**
 * Adds social meta tags to a record.
 *
 */
class EducationSeoRecord extends DataExtension
{
    private static $db = [
        'MetaTitle'    => 'Text',
        'MetaKeywords' => 'Text',
        'MetaDCType'   => "Enum('Collection, Dataset, Event, Image, InteractiveResource, MovingImage, PhysicalObject, Service, Software, Sound, StillImage, Text', 'Text')",
        'MetaAuthor'   => 'Text',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeFieldFromTab('Root.Main', 'Metadata');

        $metaKeywordsField = TextField::create('MetaKeywords', 'Meta keywords')
            ->setRightTitle('Seperate keywords with a comma eg. keyword1, keyword2, keyword3.');

        $fields->addFieldToTab('Root.Metadata', $metaKeywordsField);

        $metaDescField = TextField::create('MetaDescription', 'Meta description');
        $fields->addFieldToTab('Root.Metadata', $metaDescField);

        $metaTitleField = TextField::create('MetaTitle', 'Override page title')
            ->setRightTitle('This only applies to the page title in the Meta Data.');

        $fields->addFieldToTab('Root.Metadata', $metaTitleField);

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
            'MetaTitle'    => ($this->owner->MetaTitle) ? strip_tags($this->owner->MetaTitle) : $this->owner->Title,
            'MetaKeywords' => ($this->owner->MetaKeywords) ? strip_tags($this->owner->MetaKeywords) : '',
            'MetaDCType'   => ($this->owner->MetaDCType) ? $this->owner->MetaDCType : 'Text',
            'MetaAuthor'   => ($this->owner->MetaAuthor) ? $this->owner->MetaAuthor : 'New Zealand Ministry of Education',
            'MetaDesc'     => ($this->owner->MetaDescription) ? $this->owner->MetaDescription : $this->owner->Introduction,
            'MetaFacebook'   => ($config->FacebookURL) ?: '',
            'MetaURL'        => $this->owner->AbsoluteLink(),
            'MetaType'       => $type,
            'MetaSite'       => $config->Title,
            'MetaLastEdited' => date('c', $this->owner->dbObject('LastEdited')->getTimestamp()),
            'MetaPublished'  => date('c', $this->owner->dbObject('Created')->getTimestamp())
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
