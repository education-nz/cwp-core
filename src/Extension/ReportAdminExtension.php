<?php

namespace Education\Cwp\Extension;

use SilverStripe\Reports\ReportAdmin;
use SilverStripe\Core\Extension;

class ReportAdminExtension extends Extension
{
    public function updateEditForm($form)
    {
        $gridField = $form->Fields()->dataFieldByName('Reports');

        if ($gridField) {
            $columns = $gridField->getConfig()->getComponentByType('SilverStripe\\Forms\\GridField\\GridFieldDataColumns');
            $columns->setDisplayFields(array(
                'title' => _t('SilverStripe\\Reports\\ReportAdmin.ReportTitle', 'Title'),
                'description' => 'Description'
            ));
        }
    }
}
