<?php

namespace Education\Cwp\Form\GridField;

use SilverStripe\View\ArrayData;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;

class GridFieldEditButtonNewWindow implements GridField_ColumnProvider, GridField_ActionProvider
{
    protected $url;

    protected $getVar = 'id';

    protected $extraClass = [
        'grid-field__icon-action--hidden-on-hover' => true,
        'font-icon-edit' => true
    ];

    public function __construct($url, $getVar = null)
    {
        $this->url = $url;

        if ($getVar) {
            $this->getVar = $getVar;
        }
    }

    public function getExtraData($gridField, $record, $columnName)
    {
        return [
            "classNames" => "font-icon-edit action-detail"
        ];
    }

    /**
     * Get the extra HTML classes to add for edit buttons
     *
     * @return string
     */
    public function getExtraClass()
    {
        return implode(' ', array_keys($this->extraClass));
    }


    /**
     * Add a column 'Delete'
     *
     * @param GridField $gridField
     * @param array $columns
     */
    public function augmentColumns($gridField, &$columns)
    {
        if (!in_array('Actions', $columns)) {
            $columns[] = 'Actions';
        }
    }

    /**
     * Return any special attributes that will be used for FormField::create_tag()
     *
     * @param GridField $gridField
     * @param DataObject $record
     * @param string $columnName
     * @return array
     */
    public function getColumnAttributes($gridField, $record, $columnName)
    {
        return ['class' => 'grid-field__col-compact'];
    }

    /**
     * Add the title
     *
     * @param GridField $gridField
     * @param string $columnName
     * @return array
     */
    public function getColumnMetadata($gridField, $columnName)
    {
        if ($columnName == 'Actions') {
            return ['title' => ''];
        }
        return [];
    }

    /**
     * Which columns are handled by this component
     *
     * @param GridField $gridField
     * @return array
     */
    public function getColumnsHandled($gridField)
    {
        return ['Actions'];
    }

    /**
     * Which GridField actions are this component handling.
     *
     * @param GridField $gridField
     * @return array
     */
    public function getActions($gridField)
    {
        return [];
    }


    public function getColumnContent($gridField, $record, $columnName)
    {
        // No permission checks, handled through GridFieldDetailForm,
        // which can make the form readonly if no edit permissions are available.

        $data = new ArrayData(array(
            'Link' => Controller::join_links($this->url, '?'. $this->getVar . '='. $record->ID),
            'ExtraClass' => $this->getExtraClass()
        ));

        return sprintf('
            <a class="grid-field__icon-action %s action action-detail edit-link" href="%s" target="_blank" onclick="return false;">
                <span class="sr-only">Edit</span>
            </a>',
            $data->ExtraClass,
            $data->Link
        );
    }

    public function handleAction(GridField $gridField, $actionName, $arguments, $data)
    {
    }
}
