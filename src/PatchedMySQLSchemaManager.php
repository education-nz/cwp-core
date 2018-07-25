<?php

namespace Education\Cwp;

use SilverStripe\ORM\Connect\MySQLSchemaManager;
use SilverStripe\ORM\Connect\DatabaseException;

class PatchedMySQLSchemaManager extends MySQLSchemaManager
{
    public function renameTable($oldTableName, $newTableName)
    {
        if (!$this->hasTable($oldTableName)) {
            return false;
        }

        try {
            $this->query("ALTER TABLE \"$oldTableName\" RENAME \"$newTableName\"");
        } catch (DatabaseException $e) {
            // don't break the build if we had some issue renaming.
            // usually this is just for obsolete or old tables anyway.
        }
    }
}
