<?php namespace Defr\BackupManagerModule\Dump\Console;

use Defr\BackupManagerModule\Dump\Command\MakeDump;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class DumpCommand extends Command
{
    use DispatchesJobs;

    /**
     * Command signature
     *
     * @var        string
     */
    protected $signature = "db:dump";

    /**
     * Command name
     *
     * @var        string
     */
    protected $name = 'DB Dump';

    /**
     * Command description
     *
     * @var        string
     */
    protected $description = 'Database dump command';

    /**
     * Run the command
     */
    public function fire()
    {
        if ($path = $this->dispatch(new MakeDump()))
        {
            $this->info('Dump created successfully!');
            $this->warn($path);
        }
    }
}
