<?php namespace Defr\BackupManagerModule\Dump\Console;

use Illuminate\Console\Command;

class DumpCommand extends Command
{

    protected $signature = 'db:dump';

    protected $name = 'Dump';

    protected $description = 'Database dump command';

    public function fire()
    {

    }
}
