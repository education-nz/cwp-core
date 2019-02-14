<?php

namespace Education\Cwp\Reports;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\DateField;
use SilverStripe\Reports\Report;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Control\HTTPRequest;

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

        if (empty($params)) {
            $request = Injector::inst()->get(HTTPRequest::class);
            $params = $request->requestVar('filters') ?: [];
        }

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
