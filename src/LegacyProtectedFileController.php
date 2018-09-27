<?php

namespace Education\Cwp;

use SilverStripe\Assets\Storage\ProtectedFileController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Assets\File;
use SilverStripe\ORM\DB;

class LegacyProtectedFileController extends ProtectedFileController
{
    protected function parseFilename(HTTPRequest $request)
    {
        $filename = '';
        $next = $request->param('Filename');
        while ($next) {
            $filename = $filename ? File::join_paths($filename, $next) : $next;
            $next = $request->shift();
        }
        if ($extension = $request->getExtension()) {
            $filename = $filename . "." . $extension;
        }

        // if we're in this method then either we've reviewed a protected file
        // or it's a 404. This is a bit of a hack but let's check File_Versions
        // for the correct file URL and redirect to that..
        $id = DB::query(sprintf(
            "SELECT RecordID FROM File_Versions WHERE FileFilename = '%s'",
            $filename
        ))->value();

        if ($id) {
            $file = File::get()->byId($id);

            if ($file && !$this->request->getVar('r')) {
                header("Location: ". $file->getAbsoluteURL() . '?r=1');
                exit();
            }
        }

        return $filename;
    }
}
