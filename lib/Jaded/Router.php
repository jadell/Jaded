<?php
/**
 * Maps request URIs to controllers
 */
class Jaded_Router
{
	protected static $oInstance = null;

	protected $aRoutes = array();

	////////////////////////////////////////////////////////////////////////////////
	// PUBLIC STATIC //////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Returns instance of the router
	 * @return Jaded_Router
	 */
	public static function instance()
	{
		if (self::$oInstance == null) {
			self::$oInstance = new Jaded_Router();
		}
		return self::$oInstance;
	}

	////////////////////////////////////////////////////////////////////////////////
	// PUBLIC /////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Return a request object that maps to the given URI
	 * @param string $sUri
	 * @param Jaded_Request $oRequest
	 * @return Jaded_Request
	 */
	public function map($sUri, Jaded_Request $oRequest)
	{
		foreach ($this->aRoutes as $oRoute) {
			$aMap = $oRoute->map($sUri);
			if (is_array($aMap)) {
				foreach ($aMap as $sVar => $mVal) {
					if ($sVar == 'controller') {
						$oRequest->setControllerName($mVal);
					} else {
						$oRequest->setParam($sVar, $mVal);
					}
				}
				break;
			}
		}
		return $oRequest;
	}

	/**
	 * Set a route to handle mapping
	 * Routes are checked in the reverse order they are set
	 * @param Jaded_Router_Route $oRoute
	 */
	public function setRoute($oRoute)
	{
		array_unshift($this->aRoutes, $oRoute);
	}
}
