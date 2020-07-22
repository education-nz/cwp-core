<?php

namespace Education\Cwp\Extension;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

class ImageFormFactoryExtension extends DataExtension
{
    public function updateFormFields(FieldList $fields)
    {
        $fields->dataFieldByName('Title')->setDescription('Not displayed, for images with captions use alt fields');

        $fields->insertAfter(
            'Title',
            TextField::create('AltText', 'Alt Text')->setMaxLength(255)
        );
    }
}
