<?php

namespace Education\Cwp\Extension;

use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

class ImageFormFactoryExtension extends DataExtension
{
    public function updateFormFields(FieldList $fields, $controller, $name, $context)
    {
        $fields->dataFieldByName('Title')->setDescription('Not displayed, for images with captions use alt fields');

        /** @var File $record */
        $record = $context['Record'];

        if ($record && $record instanceof Image) {
            $fields->insertAfter(
                'Title',
                TextField::create('AltText', 'Alt Text')->setMaxLength(255)
            );
        }
    }
}
