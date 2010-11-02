<?php
/**
 * Match a URI
 */
class Jaded_Router_Route_Dynamic implements Jaded_Router_Route
{
	protected $sRegex = null;
	protected $sRoute = null;
	protected $aOptions = array();

	////////////////////////////////////////////////////////////////////////////////
	// PUBLIC /////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Build the route
	 * @param string $sRoute
	 * @param array $aOptions
	 */
	public function __construct($sRoute, $aOptions)
	{
		if (empty($aOptions['controller'])) {
			$aRouteParts = array_values(array_filter(explode('/', $sRoute)));
			$iMatch = array_search(':controller', $aRouteParts);
			if ($iMatch === false) {
				throw new Jaded_Router_Exception('Route does not define a controller', Jaded_Router_Exception::InvalidRoute);
			}
		}

		$this->sRoute = $sRoute;
		$this->aOptions = $aOptions;
	}

	/**
	 * Map the given URI to a controller if possible
	 * @param string $sUri
	 * @return array ('controller'=>controllername[, param1=>,[...]]) or null if no match
	 */
	public function map($sUri)
	{
		$aRouteParts = array_values(array_filter(explode('/', $this->sRoute)));
		$aUriParts = array_values(array_filter(explode('/', $sUri)));
		$aMatches = $this->aOptions;

		foreach ($aRouteParts as $i => $sRoutePart) {
			$sUriPart = isset($aUriParts[$i]) ? $aUriParts[$i] : null;

			if ($sRoutePart != '*') {
				if (strpos($sRoutePart, ':') === 0) {
					$sName = substr($sRoutePart, 1);
					if ($sUriPart !== null) {
						$aMatches[$sName] = $sUriPart;
					} else if (!isset($aMatches[$sName])) {
						$aMatches = null;
						break;
					}
				} else if ($sUriPart != $sRoutePart) {
					$aMatches = null;
					break;
				}
			}
		}
		return $aMatches;
	}
}
?>