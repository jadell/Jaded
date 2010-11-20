<?php
/**
 * Matches a class to a file name based on directory hierarchy (Some_Class => Some/Class.php)
 */
class Jaded_Autoloader_Finder_Pear implements Jaded_Autoloader_Finder
{
	protected $sBasePath = '';

	//////////////////////////////////////////////////////////////////////
	// PUBLIC ///////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Set the finder's base path
	 * @param string $sBasePath
	 */
	public function __construct($sBasePath)
	{
		$this->sBasePath = $sBasePath;
	}

	/**
	 * Determine a file path based on a class name
	 * @param string $sClassname
	 * @param string path to file containing class
	 */
	public function find($sClassname)
	{
		$sFilePath = str_replace('_','/', $sClassname) . '.php';
		$sFilePath = "{$this->sBasePath}/{$sFilePath}";
		return file_exists($sFilePath) ? $sFilePath : null;
	}
}
