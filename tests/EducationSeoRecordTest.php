<?php

namespace Education\GoogleAnalytics\Tests;

use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Forms\FieldList;
use Silverstripe\SiteConfig\SiteConfig;
use Page;

class EducationSeoRecordTest extends FunctionalTest
{
    public function testCMSFields()
    {
        $page = new Page();
        $editor = $page->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $editor);
        $this->assertNotNull($editor->dataFieldByName('MetaDCType'));
    }

    public function testRendersOnPage()
    {
        $page = new Page();
        $page->MetaDCType = 'Service';
        $page->write();
        $page->publishRecursive();

        $body = $this->get($page->Link());
        $this->assertContains(
            '<meta name="dcterms.type" content="Service"', $body->getBody()
        );
    }
}
