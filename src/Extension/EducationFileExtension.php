<?php

namespace Education\Cwp\Extension;

use SilverStripe\ORM\DataExtension;

class EducationFileExtension extends DataExtension
{
    private static $db = [
        'AltText' => 'Varchar(255)'
    ];

    public function getFontAwesomeIconClass()
    {
        switch (strtolower($this->owner->getExtension())) {
            case 'pdf':
                return 'fa-file-powerpoint-o';
            case 'xls':
            case 'xlsx':
                return 'fa-file-excel-o';
            case 'doc':
            case 'docx':
                return 'fa-file-word-o';
            case 'ppt':
            case 'pptx':
                return 'fa-file-powerpoint-o';
            case 'txt':
            case 'md':
                return 'fa-file-text-o';
        }

        $category = $this->owner->appCategory();

        switch ($category) {
            case 'archive':
                return 'fa-file-zip-o';
            case 'audio':
                return 'fa-file-audio-o';
            case 'document':
                return 'fa-file-o';
            case 'image':
            case 'image/supported':
                return 'fa-file-image-o';
            case 'flash':
            case 'video':
                return 'fa-film';
        }

        return 'fa-file-o';
    }
}
