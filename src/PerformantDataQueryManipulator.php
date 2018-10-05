<?php

namespace Education\Cwp;

use SilverStripe\ORM\DataQueryManipulator;
use SilverStripe\ORM\DataQuery;
use SilverStripe\ORM\Queries\SQLSelect;

/**
 * MySQL Distinct (the default behaviour on SQLSelect) is very slow with
 * multiple joins plus any ORDER BY. What this means is ModelAdmin interfaces
 * with loads of records grind to a halt. We can fix this using several steps:
 *
 * - make sure the sort column is listed as an index.
 * - apply this manipulator to the list.
 *
 * HOW TO USE:
 *
 * $list = $list->alterDataQuery(function($query) {
 *       return $query->pushQueryManipulator(new PerformantDataQueryManipulator());
 * });
 */
class PerformantDataQueryManipulator implements DataQueryManipulator
{
    /**
     * Invoked prior to getFinalisedQuery()
     *
     * @param DataQuery $dataQuery
     * @param array $queriedColumns
     * @param SQLSelect $sqlSelect
     */
    public function beforeGetFinalisedQuery(DataQuery $dataQuery, $queriedColumns = [], SQLSelect $sqlSelect)
    {

    }

    /**
     * Invoked after getFinalisedQuery()
     *
     * @param DataQuery $dataQuery
     * @param array $queriedColumns
     * @param SQLSelect $sqlQuery
     */
    public function afterGetFinalisedQuery(DataQuery $dataQuery, $queriedColumns = [], SQLSelect $sqlQuery)
    {
        $sqlQuery->setDistinct(false);
        $sqlQuery->setGroupBy('ID');
    }
}
