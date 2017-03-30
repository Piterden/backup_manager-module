<?php namespace Defr\BackupManagerModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\Streams\Platform\Model\BackupManager\BackupManagerDumpsEntryModel;
use Defr\BackupManagerModule\Dump\Console\DumpCommand;
use Defr\BackupManagerModule\Dump\Console\ListCommand;
use Defr\BackupManagerModule\Dump\Contract\DumpRepositoryInterface;
use Defr\BackupManagerModule\Dump\DumpModel;
use Defr\BackupManagerModule\Dump\DumpRepository;

class BackupManagerModuleServiceProvider extends AddonServiceProvider
{

    protected $bindings = [
        BackupManagerDumpsEntryModel::class => DumpModel::class,
    ];

    protected $singletons = [
        DumpRepositoryInterface::class => DumpRepository::class,
    ];

    protected $routes = [
        'admin/backup_manager'             => 'Defr\BackupManagerModule\Http\Controller\Admin\DumpsController@index',
        'admin/backup_manager/create'      => 'Defr\BackupManagerModule\Http\Controller\Admin\DumpsController@create',
        'admin/backup_manager/edit/{id}'   => 'Defr\BackupManagerModule\Http\Controller\Admin\DumpsController@edit',
        'admin/backup_manager/info/{id}'   => 'Defr\BackupManagerModule\Http\Controller\Admin\DumpsController@info',
        'admin/backup_manager/delete/{id}' => 'Defr\BackupManagerModule\Http\Controller\Admin\DumpsController@delete',
    ];

    protected $commands = [
        DumpCommand::class,
        ListCommand::class,
    ];
}
