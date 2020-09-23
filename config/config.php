<?php
$this_file = str_replace('\\','/',__FILE__);
$doc_root = $_SERVER['DOCUMENT_ROOT'];


$srvRoot = str_replace('config/config.php','',$this_file);
$webRoot = str_replace('/var/www/html/leave','',$srvRoot);

defined('WEB_ROOT') ? null: define('WEB_ROOT', $srvRoot);
defined('SRV_ROOT') ? null: define('SRV_ROOT', $webRoot);



