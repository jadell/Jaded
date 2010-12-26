<?php
/**
 * Encapsulation of model manipulation and business rules
 */
abstract class Jaded_Service
{
	/**
	 * Singleton instances of services
	 */
	protected static $aInstances = array();

	////////////////////////////////////////////////////////////////////////////////
	// PUBLIC STATIC //////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Returns an instance of the requested service
	 * @param string $sType
	 * @return Jaded_Service
	 * @throws Jaded_Service_Exception if the type requested is an invalid service
	 */
	public static function instance($sType)
	{
		if (empty(self::$aInstances[$sType])) {
			if (!is_subclass_of($sType, __CLASS__)) {
				throw new Jaded_Service_Exception("Invalid Service type [{$sType}]", Jaded_Service_Exception::InvalidType);
			}
			self::set($sType, new $sType());
		}
		return self::$aInstances[$sType];
	}

	/**
	 * Set a service instance
	 * @param string $sType
	 * @param Jaded_Service $oService
	 */
	public static function set($sType, $oService)
	{
		if ($oService !== null && !($oService instanceof self)) {
			throw new Jaded_Service_Exception("Invalid Service type [{$sType}]", Jaded_Service_Exception::InvalidType);
		}
		self::$aInstances[$sType] = $oService;
	}
}
