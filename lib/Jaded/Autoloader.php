<?php
/**
 * Class for automatically finding and loading classes
 */
class Jaded_Autoloader
{
	protected $aFinders = array();

	//////////////////////////////////////////////////////////////////////
	// PUBLIC ///////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Register this autoloader as an spl_autoloader
	 */
	public function init()
	{
		spl_autoload_register(array($this, 'load'));
	}

	/**
	 * Find and load the given class
	 * @param string $sClassname
	 * @todo Cache the classname => file path mapping so we don't have to look it up every time
	 */
	public function load($sClassname)
	{
		foreach ($this->aFinders as $oFinder) {
			$sFilename = $oFinder->find($sClassname);
			if ($sFilename != null) {
				require_once($sFilename);
				return;
			}
		}
	}

	/**
	 * Register a class finder
	 * Finders will be run LIFO
	 * @param Jaded_Autoloader_Finder $oFinder
	 */
	public function register(Jaded_Autoloader_Finder $oFinder)
	{
		array_unshift($this->aFinders, $oFinder);
	}
}
?>
