<?php

namespace Education\Cwp\Extension;

use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DB;
use SilverStripe\View\Parsers\URLSegmentFilter;

/**
 * Adds a URL Segment to TaxonomyTerm
 */
class EducationTaxonomyTermExtension extends DataExtension
{
    private static $db = [
        'URLSegment' => 'Varchar(200)'
    ];

    public function onBeforeWrite()
    {
        if (!$this->owner->URLSegment && $this->owner->Name) {
            $filter = URLSegmentFilter::create();

            $this->owner->URLSegment = $filter->filter($this->owner->Name);
        }

        if (!$this->owner->Sort)
        {
            $this->owner->Sort = DB::query(sprintf(
                'SELECT MAX(Sort) FROM TaxonomyTerm WHERE ParentID = %s',
                (int) $this->owner->ParentID
            ))->value() + 1;
        }
    }
}
