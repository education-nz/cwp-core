<?php

namespace Education\Cwp\Reports;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\DateField;
use SilverStripe\Reports\Report;

class RecentlyPublishedReport extends Report
{

    public function title()
    {
        return 'Recently published pages';
    }

    public function group()
    {
        return _t(__CLASS__.'.ContentGroupTitle', "Content reports");
    }

    public function sort()
    {
        return 200;
    }

    public function parameterFields()
    {
        return new FieldList(
            DateField::create('Since')
        );
    }

    public function sourceRecords($params = null)
    {
        $records = SiteTree::get()
            ->sort("\"SiteTree\".\"LastEdited\" DESC");

        if (isset($params['Since'])) {
            $records = $records->filter([
                "LastEdited:GreaterThanOrEqual" => $params['Since'] . ' 00:00:00'
            ]);
        }

        return $records;
    }

    public function columns()
    {
        return array(
            "Title" => [
                "title" => "Title",
                'link' => true
            ],
            "LastEdited" => [
                "title" => 'Last Edited'
            ],
            "Breadcrumbs" => [
                'title' => 'Link'
            ]
        );
    }
}
