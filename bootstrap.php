<?php
error_reporting(E_ALL | E_STRICT);

define('JADED_ROOTPATH', dirname(__FILE__));
define('JADED_LIBPATH', JADED_ROOTPATH.'/lib');

require_once(JADED_LIBPATH.'/Jaded/Autoloader.php');
require_once(JADED_LIBPATH.'/Jaded/Autoloader/Finder.php');
require_once(JADED_LIBPATH.'/Jaded/Autoloader/Finder/Pear.php');

$oJadedAutoloader = new Jaded_Autoloader();
$oJadedAutoloader->register(new Jaded_Autoloader_Finder_Pear(JADED_LIBPATH));
$oJadedAutoloader->register(new Jaded_Autoloader_Finder_Pear('/usr/share/php'));
$oJadedAutoloader->init();
?>
