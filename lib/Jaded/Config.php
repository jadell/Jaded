<?php
/**
 * Store configuration for a Jaded application
 */
class Jaded_Config
{
	protected static $aConfigStack = array();

	protected $aConfig = array();

	//////////////////////////////////////////////////////////////////////
	// PUBLIC STATIC ////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Retrieve a set config value
	 * @param string $sKey
	 * @param mixed $mDefault
	 * @return mixed
	 */
	public static function get($sKey, $mDefault=null)
	{
		return $oConfig = self::current()->_get($sKey, $mDefault);
	}

	/**
	 * Set a config value
	 * @param string $sKey
	 * @param mixed $mValue
	 */
	public static function set($sKey, $mValue)
	{
		$oConfig = self::current()->_set($sKey, $mValue);
	}

	/**
	 * Load config values from a file
	 * File expected in .ini format
	 * @param string $sFileName
	 * @param boolean $bBlankSlate
	 */
	public static function loadFile($sFileName, $bBlankSlate=false)
	{
		if ($bBlankSlate) {
			self::push(new Jaded_Config());
		}

		$aConfig = parse_ini_file($sFileName, true);
		foreach ($aConfig as $sSection => $aValues) {
			foreach ($aValues as $sKey => $sValue) {
				self::set("{$sSection}.{$sKey}", $sValue);
			}
		}
	}

	/**
	 * Save the current state of the config so it can be restored later
	 */
	public static function save()
	{
		$oConfig = self::current();
		$oNewConfig = clone $oConfig;
		self::push($oNewConfig);
	}

	/**
	 * Restore to the previously saved config state
	 */
	public static function restore()
	{
		if (count(self::$aConfigStack) > 1) {
			self::pop();
		}
	}

	//////////////////////////////////////////////////////////////////////
	// PROTECTED STATIC /////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Return the top config on the stack
	 * Create one if none exists
	 * @return Jaded_Config
	 */
	protected static function current()
	{
		if (count(self::$aConfigStack) < 1) {
			$oConfig = new Jaded_Config();
			self::push($oConfig);
		}
		return self::$aConfigStack[0];
	}

	/**
	 * Push a config onto the stack
	 * @param Jaded_Config $oConfig
	 */
	protected static function push($oConfig)
	{
		array_unshift(self::$aConfigStack, $oConfig);
	}

	/**
	 * Pop a config off the stack
	 */
	protected static function pop()
	{
		array_shift(self::$aConfigStack);
	}

	//////////////////////////////////////////////////////////////////////
	// PROTECTED ////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Retrieve a set config value
	 * @param string $sKey
	 * @param mixed $mDefault
	 * @return mixed
	 */
	protected function _get($sKey, $mDefault=null)
	{
		return isset($this->aConfig[$sKey]) ? $this->aConfig[$sKey] : $mDefault;
	}

	/**
	 * Set a config value
	 * @param string $sKey
	 * @param mixed $mValue
	 */
	protected function _set($sKey, $mValue)
	{
		$this->aConfig[$sKey] = $mValue;
	}
}
