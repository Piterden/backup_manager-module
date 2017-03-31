<?php

if (!function_exists('human_filesize'))
{

    /**
     * Humanize the filesizes
     *
     * @param  integer  $bytes    The bytes
     * @param  integer  $decimals The decimals
     * @return string
     */
    function human_filesize($bytes, $decimals = 2)
    : string
    {
        $size   = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).@$size[$factor];
    }
}
