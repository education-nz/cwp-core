<?php

namespace Education\Cwp\Extension;

use SilverStripe\Control\Director;
use SilverStripe\Core\Extension;

class SecuredControllerExtension extends Extension
{
    public function onAfterInit()
    {
        $this->setExtraHeaders();
    }

    public function setExtraHeaders()
    {
        $response = $this->owner->getResponse();

        if ($response && $this->owner->supportsCSP()) {
            $knownDomains = 'https://*.education.govt.nz https://*.cwp.govt.nz';

            $base = rtrim(Director::absoluteBaseURL(), '/');
            if (strpos($knownDomains, $base) === false) {
                $knownDomains .= ' '. $base;
            }

            $baseWithSlash = rtrim(Director::absoluteBaseURL(), '/') . '/';
            if (strpos($knownDomains, $baseWithSlash) === false) {
                $knownDomains .= ' '. $baseWithSlash;
            }

            // if the base URL is using https then allow http as a version to
            // prevent errors as certain things (PDF rendering) require https.
            if (strpos($base, 'http:') === false) {
                $knownDomainsInsecure = $knownDomains . ' '. str_replace('https:', 'http:', $base);
            } else {
                $knownDomainsInsecure = $knownDomains;
            }

            // phpcs:disable
            $csp = "default-src $knownDomains www.google.com www.gstatic.com 'unsafe-inline' 'unsafe-eval' data:;";
            $csp .= " base-uri $knownDomains;";
            $csp .= " frame-ancestors $knownDomains;";
            $csp .= " style-src 'unsafe-inline' $knownDomains https://*.typography.com https://maxcdn.bootstrapcdn.com https://*.fontawesome.com https://fonts.googleapis.com https://*.gstatic.com https://api.addressfinder.io https://tagmanager.google.com https://optimize.google.com;";
            $csp .= " script-src 'unsafe-inline' $knownDomains https://player.vimeo.com https://script.crazyegg.com https://code.jquery.com https://staticcdn.co.nz https://snap.licdn.com https://www.google.com https://*.doubleclick.net https://www.googleadservices.com https://*.fontawesome.com https://connect.facebook.net http://script.crazyegg.com https://*.crazyegg.com https://*.gstatic.com https://api.addressfinder.io https://www.googletagmanager.com https://fonts.googleapis.com https://*.google-analytics.com http://*.google-analytics.com http://tagmanager.google.com https://optimize.google.com http://*.hotjar.com https://*.hotjar.com https://code.jquery.com 'unsafe-eval';";
            $csp .= " img-src $knownDomainsInsecure 'self' data: https://googleads.g.doubleclick.net https://stats.g.doubleclick.net https://*.amazonaws.com https://www.google.co.nz https://p.adsymptotic.com https://www.google.com https://px.ads.linkedin.com https://*.facebook.com https://*.google-analytics.com http://*.google-analytics.com https://*.swagger.io https://optimize.google.com https://*.hotjar.com;";
            $csp .= " font-src $knownDomains https://*.fontawesome.com https://*.typography.com https://maxcdn.bootstrapcdn.com https://fonts.gstatic.com http://*.hotjar.com https://*.hotjar.com;";
            $csp .= " object-src $knownDomains 'self';";
            $csp .= " frame-src $knownDomainsInsecure 'self' https://www.facebook.com https://bid.g.doubleclick.net https://www.google.com data: https://*.youtube-nocookie.com https://player.vimeo.com https://*.youtube.com https://optimize.google.com https://www.googletagmanager.com/ns.html https://*.hotjar.com;";
            $csp .= " child-src $knownDomains https://*.youtube-nocookie.com https://player.vimeo.com http://player.vimeo.com https://*.youtube.com  https://optimize.google.com https://www.googletagmanager.com/ns.html https://*.hotjar.com;";
            $csp .= " connect-src $knownDomains https://api.addressfinder.io https://www.google-analytics.com/ http://*.hotjar.com:* https://*.hotjar.com:* ws://*.hotjar.com wss://*.hotjar.com;";
            $csp .= " form-action $knownDomainsInsecure https://www.facebook.com 'self';";
            // phpcs:enable

            $this->owner->invokeWithExtensions('updateExtraHeaders', $csp);

            $response->addHeader('Content-Security-Policy', $csp);
        }

        if ($response) {
            $headersToSet = [
                'Expect-CT' => 'max-age=86400',
                'X-Frame-Options' => 'SAMEORIGIN',
                'X-XSS-Protection' => '1; mode=block',
                'X-UA-Compatible' => 'IE=edge',
                'X-Content-Type-Options' => 'nosniff'
            ];

            if (!Director::isDev()) {
                $headersToSet['Strict-Transport-Security'] = 'max-age=15768000; includeSubDomains';
            }

            foreach ($headersToSet as $header => $value) {
                $response->addHeader($header, $value);
            }
        }
    }

    public function supportsCSP()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $agent = strtolower($_SERVER['HTTP_USER_AGENT']);

            if (strpos($agent, 'safari') !== false) {
                $split = explode('version/', $agent);

                if (isset($split[1])) {
                    $version = trim($split[1]);
                    $versions = explode('.', $version);

                    if (isset($versions[0]) && $versions[0] <= 5) {
                        return false;
                    }
                }
            }

            return true;
        }

        return false;
    }
}
