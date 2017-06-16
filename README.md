# Backup Manager
## Streams Platform Addon. `backup_manager-module` for PyroCMS.

A graphical user interface (GUI), allowing you to backup PyroCMS database by addon.

### Features
* Backup your database (_full DB only with artisan command_);
* Select addons you would like to create a backup of;
* Easily restore database and tables;
* Storing data in JSON format.

***

## Installation

### Step 1

Run
```bash
$ composer require defr/backup_manager-module
```

Either, add to `require` section of `composer.json`:
```json
    "defr/backup_manager-module": "~1.0.0",
```
Run `composer update` command, which will install module to the `core` folder!

### Step 2

Then you would need to install module to PyroCMS
```bash
$ php artisan module:install backup_manager
```
or
```bash
$ php artisan addon:install defr.module.backup_manager
```

## Usage

### Create a backup from Conrol Panel
* Click the menu item "Backup Manager".
* Then click the button "Create a dump".
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
