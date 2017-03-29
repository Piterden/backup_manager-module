<?php namespace Defr\BackupManagerModule\Dump\Table;

use Defr\BackupManagerModule\Dump\Command\GetDumps;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class for overriding table entries
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
class DumpTableEntries
{
    use DispatchesJobs;

    /**
     * Handle the command
     *
     * @param DumpFormBuilder $builder The builder
     */
    public function handle(DumpTableBuilder $builder)
    {
        $builder->getTable()->setEntries($this->dispatch(new GetDumps()));
    }
}
