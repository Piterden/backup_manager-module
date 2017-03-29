<?php namespace Defr\BackupManagerModule\Dump\Console;

use Defr\BackupManagerModule\Dump\Command\GetDumps;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class ListCommand extends Command
{
    use DispatchesJobs;

    /**
     * Command signature
     *
     * @var string
     */
    protected $signature = 'dump:list';

    /**
     * Command name
     *
     * @var string
     */
    protected $name = 'Dumps list';

    /**
     * Command description
     *
     * @var string
     */
    protected $description = 'List available dumps in DB';

    /**
     * Run the command
     */
    public function fire()
    {
        $dumps = $this->dispatch(new GetDumps());

        $this->table(
            ['ID', 'Created', 'Updated', 'Path to the Dump File', 'Dump Size'],
            $dumps->map(function ($dump)
            {
                return [
                    $dump->getId(),
                    $dump->getCreatedAt(),
                    $dump->getUpdatedAt(),
                    $dump->getPath(),
                    strip_tags($dump->getPresenter()->getSize()),
                ];
            })
        );
    }
}
