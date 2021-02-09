<?php

namespace Education\Cwp\Tasks;

use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DB;
use SilverStripe\Security\LoginAttempt;

class CleanLoginAttempts extends BuildTask
{
    protected $title = 'Clean Login Attempts';

    protected $description = 'Delete all login attempts which could prevent user logins';

    protected $enabled = true;

    private static $segment = 'CleanLoginAttempts';

    public function run($request)
    {
        $feedback = LoginAttempt::get();
        $count = $feedback->count();

        foreach ($feedback as $form) {
            $form->delete();
        }

        echo ''. $count . ' attempts removed.' . PHP_EOL;

        $lockouts = DB::query('SELECT COUNT(*) FROM Member WHERE LockedOutUntil IS NOT NULL')->value();

        DB::query('UPDATE Member SET LockedOutUntil = NULL');

        echo ''. $lockouts . ' lockouts reset.' . PHP_EOL;
    }
}
