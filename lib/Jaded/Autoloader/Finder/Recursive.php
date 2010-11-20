<?php
/**
 * Matches a class to a file name found in directory hierarchy (SomeClass => path/to/SomeClass.php)
 */
class Jaded_Autoloader_Finder_Recursive implements Jaded_Autoloader_Finder
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
		$sFileName = "{$sClassname}.php";
		$sMatch = "/{$sFileName}$/";
		$oDirectory = new RecursiveDirectoryIterator($this->sBasePath);
		$oIterator = new RecursiveIteratorIterator($oDirectory);
		$oRegex = new RegexIterator($oIterator, $sMatch, RegexIterator::GET_MATCH);
		foreach ($oRegex as $sFileName => $sCur) {
			return $sFileName;
		}
		return null;
	}
}
