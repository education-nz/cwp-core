<?php

use SilverStripe\View\Parsers\ShortcodeParser;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Core\Convert;

ShortcodeParser::get('default')->register('current_request_uri', function ($args, $content = null, $parser = null, $t = null) {
    if (isset($_SERVER['REQUEST_URI'])) {
        return DBHTMLText::create_field('HTMLText', Convert::raw2att($_SERVER['REQUEST_URI']));
    } else {
        return '';
    }
});