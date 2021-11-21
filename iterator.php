<?php

if ($_SERVER['DOCUMENT_ROOT'] == '') {
    $_SERVER['DOCUMENT_ROOT'] = __DIR__;
}

$path = $_SERVER['DOCUMENT_ROOT'].'/docs/';

$it = new DirectoryIterator($path);
$res = [];

function iterator($it, &$res)
{
    for ($it->rewind(); $it->valid(); $it->next()) {
        if ($it->isDot()) {
            continue;
        }
        if ($it->isDir()) {
            iterator(new DirectoryIterator($it->current()->getPathName()), $res);
        } else {
            $re = '/^[0-9A-Za-z]{1,}\.ixt$/';
            //$re = '/^[-_0-9A-Za-z]{1,}\.png$/';
            $file_name = $it->current()->getFilename();
            if ( preg_match($re, $file_name) ) {
                $res[] = $file_name;
            }
        }
    }
}

iterator($it, $res);
sort($res);
print_r("<pre>");
print_r($res);
print_r("</pre>");
exit;
