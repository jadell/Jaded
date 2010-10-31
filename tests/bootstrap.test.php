<?php
$sTestRoot = dirname(__FILE__);
require_once("{$sTestRoot}/../bootstrap.php");

Jaded_Config::set('jaded.pearpath', '/usr/share/php');
$oJadedAutoloader->register(new Jaded_Autoloader_Finder_Pear(Jaded_Config::get('jaded.pearpath')));

$oJadedAutoloader->register(new Jaded_Autoloader_Finder_Recursive("{$sTestRoot}/fixtures/testclasses"));
?>