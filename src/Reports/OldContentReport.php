<?php

namespace Education\Cwp\Reports;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\DataObject;
use SilverStripe\Reports\Report;
use SilverStripe\Versioned\Versioned;

class OldContentReport extends Report
{
    protected $title = "Old Content";

    protected $sort = 200;

    protected $description = 'Display oldest content on the website.';

    public function sourceRecords($params = null)
    {
        $query = SiteTree::get()
            ->where('LastEdited IS NOT NULL')
            ->sort("\"SiteTree\".\"LastEdited\" ASC")
            ->limit(100);

        $query->setDataQueryParam([
            'Versioned.mode' => 'stage',
            'Versioned.stage' => Versioned::LIVE
        ]);

        return $query;
    }

    public function columns()
    {
        return array(
            "Title" => array(
                "title" => "Title", // todo: use NestedTitle(2)
                "link" => true,
            ),
            "Breadcrumbs" => array(
                'title' => 'Section'
            ),
            "LastEdited" => array(
                "title" => "Last Updated"
            )
        );
    }
}
