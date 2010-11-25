<?php
/**
 * Sets request parameters in the request
 */
class Jaded_Controller_Filter_SetRequestParams extends Jaded_Controller_Filter_PreProcessor
{
	protected function preProcess(Jaded_Request $oRequest, Jaded_Response $oResponse)
	{
		foreach ($_REQUEST as $sKey => $sValue) {
			$oRequest->setParam($sKey, $sValue);
		}
	}
}
