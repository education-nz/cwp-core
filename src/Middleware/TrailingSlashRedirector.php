<?php

namespace Education\Cwp\Middleware;

use SilverStripe\Admin\AdminRootController;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Control\Middleware\HTTPMiddleware;

/**
 * Ensure that a single trailing slash is always added to the URL.
 * URLs accessed via Ajax, contain $_GET vars, or that contain
 * an extension are ignored.
 */
class TrailingSlashRedirector implements HTTPMiddleware
{
    public function process(HTTPRequest $request, callable $delegate)
    {
        if ($request && ($request->isGET() || $request->isHEAD())) {
            $requestedUrl = $_SERVER['REQUEST_URI'];

            // don't process any requested admin URL
            if (strpos($requestedUrl, AdminRootController::admin_url()) !== false) {
                $response = $delegate($request);

                return $response;
            }

            $expectedUrl = rtrim(Director::baseURL() . $request->getURL(), '/') . '/';
            $urlPathInfo = pathinfo($requestedUrl);
            $params = $request->getVars();

            if (isset($params['url'])) {
                unset($params['url']);
            }

            if (!Director::is_ajax() &&
                !Director::is_cli() &&
                !isset($urlPathInfo['extension']) &&
                empty($params) &&
                !preg_match('/^' . preg_quote($expectedUrl, '/') . '(?!\/)/i', $requestedUrl)
            ) {
                $params = $request->getVars();
                $redirectUrl = Controller::join_links($expectedUrl, '/');
                $response = new HTTPResponse();

                return $response->redirect($redirectUrl, 301);
            }
        }

        $response = $delegate($request);

        return $response;
    }
}
