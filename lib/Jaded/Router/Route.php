<?php
/**
 * Encapsulates a route mapping a URI to a controller
 */
interface Jaded_Router_Route
{
	////////////////////////////////////////////////////////////////////////////////
	// PUBLIC /////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Map the given URI to a controller if possible
	 * @param string $sUri
	 * @return array ('controller'=>controllername[, param1=>,[...]]) or null if no match
	 */
	public function map($sUri);
}
?>