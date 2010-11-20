<?php
/**
 * Class to handle displaying the results in a response
 */
interface Jaded_Renderer
{
	//////////////////////////////////////////////////////////////////////
	// PUBLIC ///////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Render the view with the given information
	 * This should actually output the rendered string (and headers, etc.)
	 * @param string $sTemplate
	 * @param array  $aData
	 * @param array  $aHeaders
	 */
	public function render($sTemplate, $aData, $aHeaders);
}
