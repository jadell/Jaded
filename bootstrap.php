<?php
error_reporting(E_ALL | E_STRICT);

$sJadedRootPath = dirname(__FILE__);
$sJadedLibPath = "{$sJadedRootPath}/lib";

require_once("{$sJadedLibPath}/Jaded/Autoloader.php");
require_once("{$sJadedLibPath}/Jaded/Autoloader/Finder.php");
require_once("{$sJadedLibPath}/Jaded/Autoloader/Finder/Pear.php");

$oJadedAutoloader = new Jaded_Autoloader();
$oJadedAutoloader->register(new Jaded_Autoloader_Finder_Pear($sJadedLibPath));
$oJadedAutoloader->init();

Jaded_Config::set('jaded.rootpath', $sJadedRootPath);
Jaded_Config::set('jaded.libpath',  $sJadedLibPath);
