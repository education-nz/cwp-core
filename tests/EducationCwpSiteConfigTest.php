<?php

namespace Education\GoogleAnalytics\Tests;

use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Forms\FieldList;
use Silverstripe\SiteConfig\SiteConfig;

class EducationCwpSiteConfigTest extends FunctionalTest
{
    protected $usesDatabase = true;

    public function testCMSFields()
    {
        $config = SiteConfig::current_site_config();

        $this->assertInstanceOf(FieldList::class, $config->getCMSFields());
    }
}
