<?php
/**
 * Filter request and response before and after handing off to a controller
 */
abstract class Jaded_Controller_Filter extends Jaded_Controller
{
	protected $oController = null;

	protected $bDoPreProcess = true;
	protected $bDoProcess = true;
	protected $bDoPostProcess = true;

	////////////////////////////////////////////////////////////////////////////////
	// ABSTRACT ///////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Called during dispatch() before process()
	 * @param Jaded_Request $oRequest
	 * @param Jaded_Response $oResponse
	 */
	abstract protected function preProcess(Jaded_Request $oRequest, Jaded_Response $oResponse);

	/**
	 * Called during dispatch() after process()
	 * @param Jaded_Request $oRequest
	 * @param Jaded_Response $oResponse
	 */
	abstract protected function postProcess(Jaded_Request $oRequest, Jaded_Response $oResponse);

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

	////////////////////////////////////////////////////////////////////////////////
	// PROTECTED //////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Pass control to the next controller or filter
	 * @param Jaded_Request $oRequest
	 * @param Jaded_Response $oResponse
	 */
	protected function process(Jaded_Request $oRequest, Jaded_Response $oResponse)
	{
		if ($this->bDoPreProcess) {
			$this->preProcess($oRequest, $oResponse);
		}

		if ($this->bDoProcess) {
			$this->oController->dispatch($oRequest, $oResponse);
		}

		if ($this->bDoPostProcess) {
			$this->postProcess($oRequest, $oResponse);
		}
	}
}
