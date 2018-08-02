<?php

namespace Education\Cwp\Extension;

use SilverStripe\ORM\DataExtension;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * An extension for any {@link DataObject} which sits on the {@link SiteConfig}
 *
 * When those objects are updated it triggers a last-edited change to the config
 * so that caches are updated.
 */
class SiteConfigableObjectExtension extends DataExtension
{
    public function onAfterWrite()
    {
        $config = SiteConfig::current_site_config();

        if ($config) {
            // mark as changed to update partial caches.
            $config->markChanged();
        }
    }

    public function onAfterDelete()
    {
        $config = SiteConfig::current_site_config();

        if ($config) {
            // mark as changed to update partial caches.
            $config->markChanged();
        }
    }
}
