<?php

namespace Education\Cwp\Extension;

use SilverStripe\Core\Extension;

class DateExtension extends Extension
{
    /**
     * Use PHP format methods rather than ICU.
     */
    public function FormatPHP($format)
    {
        return date($format, $this->owner->getTimestamp());
    }
}
