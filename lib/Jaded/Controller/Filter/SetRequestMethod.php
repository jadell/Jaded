<?php
/**
 * Sets the HTTP request method
 */
class Jaded_Controller_Filter_SetRequestMethod extends Jaded_Controller_Filter
{
	protected function preProcess(Jaded_Request $oRequest, Jaded_Response $oResponse)
	{
		$oRequest->setMethod($_SERVER['REQUEST_METHOD']);
	}

	protected function postProcess(Jaded_Request $oRequest, Jaded_Response $oResponse){}
}
