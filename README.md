# Backup Manager
## Streams Platform Addon. `backup_manager-module` for PyroCMS.

   > **Requires `"minimum-stability": "dev"` flag in `composer.json`**

A graphical user interface (GUI), allowing you to backup PyroCMS database by addon.

### Features
* Backup your database (_full DB only with artisan command_);
* Select addons you would like to create a backup of;
* Easily restore database and tables;
* Storing data in JSON format.

***

## Download
Clone repository into `addons/{app_reference}/defr/backup_manager-module` folder, or add this module to your PyroCMS project manually uploading files.

### Alternative way
Add to `composer.json`:
```js
    "require": {
    
        // ...,
        
        "defr/backup_manager-module": "dev-master"
    },
    
    "repositories": [
        
        // ...,
        
        {
            "url": "https://github.com/Piterden/backup_manager-module",
            "type": "git"
        }
    ],
```

Run `composer update` command.

***

## Installation
After placing files in correct place, you will need to install migrations using the PyroCMS Control Panel or simply run one of following commands:
```bash
$ php artisan module:install backup_manager
```
or
```bash
$ php artisan addon:install defr.module.backup_manager
```
A new menu item will appear in your admin navigation.

***

## Usage

### Create a backup from Conrol Panel
* Click the menu item "Backup Manager".
* Then click the button "Create a dump".
  - Select DB connection in modal.
  - Enter the name of the backup you are to create.
  - Select addon to backup.
* Press save and you are done.

### Restore a backup
* Click the menu item "Backup Manager".
* In the table, click restore button of backup you would like to restore.

***

## Using artisan

### Creating a dump
```bash
$ php artisan db:dump
```

 - Usage:
    db:dump [options]

 - Options:
    --connection[=CONNECTION]  DB connection to use.
    --tables[=TABLES]          Tables to include in the dump.
    --addon[=ADDON]            Addon, in dot notation.

     > Without any options it will create dump of all tables

### Dumps listing
```bash
$ php artisan dump:list
```
 
 - Usage:
    dump:list

***
