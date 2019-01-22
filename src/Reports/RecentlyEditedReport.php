<?php

namespace Education\Cwp\Reports;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\DateField;
use SilverStripe\Reports\Report;

class RecentlyEditedReport extends Report
{

    public function title()
    {
        return 'Recently edited pages';
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
            $start = explode('/', $params['Since']);
            $start = $start[2] . '-'. $start[1] .'-'. $start[0];
            $records = $records->filter([
                "LastEdited:GreaterThanEqual" => $start
            ]);
        }

        return $records;
    }

    public function columns()
    {
        return array(
            "Title" => array(
                "title" => "Title",
            ),
            "LastEdited" => [
                "title" => 'Last Edited'
            ],
            "Link" => [
                'title' => 'Link',
                'link' => true
            ]
        );
    }
}
