<?php
/**
 * Handle a Request and format a Response
 */
abstract class Jaded_Controller
{
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
	 * Called during dispatch() before postProcess()
	 * @param Jaded_Request $oRequest
	 * @param Jaded_Response $oResponse
	 */
	abstract protected function process(Jaded_Request $oRequest, Jaded_Response $oResponse);

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
	 * Run this controller, modifying the request and response appropriately
	 * @param Jaded_Request $oRequest
	 * @param Jaded_Response $oResponse
	 */
	public function dispatch(Jaded_Request $oRequest, Jaded_Response $oResponse)
	{
		if ($this->bDoPreProcess) {
			$this->preProcess($oRequest, $oResponse);
		}

		if ($this->bDoProcess) {
			$this->process($oRequest, $oResponse);
		}

		if ($this->bDoPostProcess) {
			$this->postProcess($oRequest, $oResponse);
		}
	}
}
?>