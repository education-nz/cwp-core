<?php

namespace Education\Cwp\Extension;

use SilverStripe\Core\Extension;

class EducationFormFieldExtension extends Extension
{
    /**
     * Adds the ability to store HTML in a FormField label without customising
     * the form template.
     */
    public function htmlizeLabel()
    {
        $casting = $this->owner->config()->get('casting');
        $casting['Title'] = 'HTMLText';

        $this->owner->config()->set('casting', $casting);

        return $this->owner;
    }

    /**
     * Remove HTML from readonly fields.
     */
    public function onBeforeRender()
    {
        if ($this->owner->isReadonly()) {
            $this->owner->setTitle(strip_tags($this->owner->Title()));
        }
    }
}
