<?php
/**
 * Filter request and response before and after handing off to a controller
 */
abstract class Jaded_Controller_Filter extends Jaded_Controller
{
	protected $oController = null;

	////////////////////////////////////////////////////////////////////////////////
	// PUBLIC /////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Set the next controller in the chain
	 * @param Jaded_Controller $oController
	 */
	public function __construct(Jaded_Controller $oController)
	{
		$this->oController = $oController;
	}

	/**
	 * Pass control to the next controller or filter
	 * @param Jaded_Request $oRequest
	 * @param Jaded_Response $oResponse
	 */
	public function process(Jaded_Request $oRequest, Jaded_Response $oResponse)
	{
		$this->oController->dispatch($oRequest, $oResponse);
	}
}
