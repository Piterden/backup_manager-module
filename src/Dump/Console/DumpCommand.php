<?php namespace Defr\BackupManagerModule\Dump\Console;

use Anomaly\Streams\Platform\Addon\Command\GetAddon;
use Defr\BackupManagerModule\Dump\Command\CreateDump;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputOption;

/**
 * Artisan make dump command class
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
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
    protected $description = 'Connection dump command';

    /**
     * Run the command
     *
     * @throws \Exception
     */
    public function fire()
    {
        $start = microtime();

        $connection = $this->input->getOption('connection');
        $tables     = $this->input->getOption('tables');

        if (!$addon = $this->input->getOption('addon'))
        {
            throw new \Exception('Addon not set!');
        }

        if (!$addon = $this->dispatch(new GetAddon($addon)))
        {
            throw new \Exception('Addon not found!');
        }

        if (!$path = $this->dispatch(new CreateDump($connection, $tables, $addon)))
        {
            throw new \Exception('Error dump creation!');
        }

        $size = str_replace('&nbsp;', ' ', filesize_for_humans(filesize($path)));
        $time = microtime() - $start;

        $this->info('Dump created successfully!');
        $this->warn("File path: `{$path}`");
        $this->info("Size: {$size}. Time: {$time} sec.");
    }

    /**
     * Gets the options of a command
     *
     * @return array The options.
     */
    protected function getOptions()
    {
        return [
            ['connection', null, InputOption::VALUE_OPTIONAL, 'DB connection to use.'],
            ['tables', null, InputOption::VALUE_OPTIONAL, 'Tables to include in the dump.'],
            ['addon', null, InputOption::VALUE_OPTIONAL, 'Addon, in dot notation.'],
        ];
    }
}
