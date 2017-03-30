<?php namespace Defr\BackupManagerModule\Dump\Console;

use Anomaly\Streams\Platform\Addon\Command\GetAddon;
use Defr\BackupManagerModule\Dump\Command\MakeDump;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputOption;

class DumpCommand extends Command
{
    use DispatchesJobs;

    /**
     * Command name
     *
     * @var string
     */
    protected $name = 'db:dump';

    /**
     * Command description
     *
     * @var string
     */
    protected $description = 'Database dump command';

    /**
     * Run the command
     */
    public function fire()
    {
        $start = microtime();

        $database = $this->input->getOption('database');
        $tables   = $this->input->getOption('tables');

        if ($addon = $this->input->getOption('addon'))
        {
            $addon = $this->dispatch(new GetAddon($addon));
        }

        if ($path = $this->dispatch(new MakeDump($database, $tables, $addon)))
        {
            $this->info('Dump created successfully!');
            $this->warn($path);
        }

        $this->info('Size: '.human_filesize(filesize($path))
            .'. Time: '.(microtime() - $start).' sec.');
    }

    /**
     * Gets the options of a command
     *
     * @return array The options.
     */
    protected function getOptions()
    {
        return [
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use.'],
            ['tables', null, InputOption::VALUE_OPTIONAL, 'Tables to include in the dump.'],
            ['addon', null, InputOption::VALUE_OPTIONAL, 'Addon, in dot notation.'],
        ];
    }
}
