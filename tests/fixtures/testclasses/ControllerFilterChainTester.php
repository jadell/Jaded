<?php
class ControllerFilterChainTester extends Jaded_Controller_Filter_Chain
{
	protected $aFilters = array(
		'FilterChainTester1',
		'FilterChainTester2'
	);
}

class FilterChainTester1 extends Jaded_Controller_Filter
{
	public function preProcess(Jaded_Request $oRequest, Jaded_Response $oResponse)
	{
		$oRequest->setParam('Param1', 'set by filter 1');
	}

	public function postProcess(Jaded_Request $oRequest, Jaded_Response $oResponse){}
}

class FilterChainTester2 extends Jaded_Controller_Filter
{
	public function preProcess(Jaded_Request $oRequest, Jaded_Response $oResponse){}

	public function postProcess(Jaded_Request $oRequest, Jaded_Response $oResponse)
	{
		$oRequest->setParam('Param2', 'set by filter 2');
	}
}
