<?php namespace Defr\BackupManagerModule\Dump\Command;

use Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface;
use Defr\BackupManagerModule\Dump\Contract\DumpRepositoryInterface;
use Illuminate\Filesystem\Filesystem;

/**
 * Class for get dumps from the filesystem
 *
 * @package defr.module.backup_manager
 *
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 */
class GetDumps
{

    /**
     * Handle the command
     *
     * @param  Filesystem                 $files    The files
     * @param  DumpRepositoryInterface    $dumps    The dumps
     * @param  SettingRepositoryInterface $settings The settings
     * @return DumpCollection
     */
    public function handle(
        Filesystem $files,
        DumpRepositoryInterface $dumps,
        SettingRepositoryInterface $settings
    )
    {
        $path = base_path(env(
            'DUMPS_PATH',
            $settings->value('defr.module.backup_manager::dump_path', 'dumps')
        ));

        $list    = $files->glob($path.'/*sql.json');
        $entries = [];

        foreach ($list as $path)
        {
            /* @var DumpInterface $entry */
            $entry = [
                'path'    => $path,
                'content' => json_decode($files->get($path), true),
            ];

            $entries[$path] = $entry;
        }

        return $dumps->sync($entries);
    }
}
