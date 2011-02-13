<?php
$sTestRoot = dirname(__FILE__);
require_once("{$sTestRoot}/../bootstrap.php");
$oJadedAutoloader->register(new Jaded_Autoloader_Finder_Pear('/usr/share/php'));
$oJadedAutoloader->register(new Jaded_Autoloader_Finder_Recursive("{$sTestRoot}/fixtures/testclasses"));
