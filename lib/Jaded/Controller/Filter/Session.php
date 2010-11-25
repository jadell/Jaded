<?php
/**
 * Initialize the session handler and close it when done
 */
class Jaded_Controller_Filter_Session extends Jaded_Controller_Filter
{
	protected function preProcess(Jaded_Request $oRequest, Jaded_Response $oResponse)
	{
		$oRequest->getSession()->open();
	}

	protected function postProcess(Jaded_Request $oRequest, Jaded_Response $oResponse)
	{
		$oRequest->getSession()->close();
	}
}
