<?php

namespace Education\Cwp\Tests;

use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Forms\FieldList;
use Silverstripe\SiteConfig\SiteConfig;
use Page;

class EducationSeoRecordTest extends FunctionalTest
{
    protected static $fixture_file = 'fixtures.yml';

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

        $body = $page->renderWith('Education\Cwp\Includes\Meta');

        $this->assertContains(
            '<meta name="dcterms.type" content="Service"', $body->getBody()
        );
    }
}
