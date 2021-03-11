<?php

namespace Education\Cwp\Extension;

use Page;
use SilverStripe\Control\Director;
use SilverStripe\Core\Convert;
use SilverStripe\Core\Extension;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\SiteConfig\SiteConfig;

class EducationControllerExtension extends Extension
{
    /**
     * This is only used for page-utils
     *
     * @return string
     */
    public function getEncodedAbsoluteURL()
    {
        $url = Director::absoluteURL($this->owner->Link(), true);

        return urlencode($url);
    }

    /**
     * This is only used for page-utils
     *
     * @param int $limit
     *
     * @return bool|string
     */
    public function getEncodedTitle($limit = 200)
    {
        $title = $this->owner->Title;

        if ($limit) {
            $title = substr($title, 0, $limit);
        }

        $title = urlencode($title);

        if ($limit) {
            $title = substr($title, 0, $limit);
        }

        return $title;
    }

    /**
     * This is only used for page-utils
     *
     * @param int $limit
     *
     * @return bool|string
     */
    public function getEncodedSummary($limit = 1024)
    {
        $summary = $this->owner->Intro ? $this->owner->Intro : Convert::html2raw($this->owner->Content);

        if ($limit) {
            $summary = substr($summary, 0, $limit);
        }

        $summary = urlencode($summary);

        if ($limit) {
            $summary = substr($summary, 0, $limit);
        }

        return $summary;
    }

    public function PageCacheKey(): string
    {
        return md5(Page::get()->max('LastEdited') . '-' .  Page::get()->count());
    }

    public function NewsCacheKey(): string
    {
        $pages = Page::get()->filter([
            'ClassName' => [
                'Education\\\\Core\\\\Model\\\\EducationNewsPage',
                'CWP\\\\CWP\\\\PageTypes\\\\NewsPage'
            ]
        ]);

        return md5($pages->max('LastEdited') . '-' .  $pages->count());
    }

    public function SiteConfigCacheKey(): string
    {
        return md5(
            SiteConfig::current_site_config()->ID . '-' .
                SiteConfig::current_site_config()->dbObject('LastEdited')->getTimestamp()
        );
    }

    public function AlgoliaApplicationID()
    {
        if (class_exists('Wilr\SilverStripe\Algolia\Service\AlgoliaService')) {
            $service = Injector::inst()->get('Wilr\SilverStripe\Algolia\Service\AlgoliaService');

            return $service->applicationId;
        }
    }

    public function AlgoliaApiKey()
    {
        if (class_exists('Wilr\SilverStripe\Algolia\Service\AlgoliaService')) {
            $service = Injector::inst()->get('Wilr\SilverStripe\Algolia\Service\AlgoliaService');

            return $service->searchApiKey;
        }
    }

    public function AlgoliaIndex()
    {
        if (class_exists('Wilr\SilverStripe\Algolia\Service\AlgoliaService')) {
            $service = Injector::inst()->get('Wilr\SilverStripe\Algolia\Service\AlgoliaService');

            if (!function_exists('array_key_first')) {
                function array_key_first(array $arr) {
                    foreach($arr as $key => $unused) {
                        return $key;
                    }
                    return NULL;
                }
            }

            $first = array_key_first($service->indexes);

            return $service->environmentizeIndex($first);
        }
    }
}
