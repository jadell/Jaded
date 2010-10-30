<?php
class Jaded_Controller_FilterTest extends PHPUnit_Framework_TestCase
{
	public function testFilter_ProcessCallsNextController()
	{
		$oRequest = new Jaded_Request();
		$oResponse = new Jaded_Response();

		$oController = $this->getMock('Jaded_Controller', array('dispatch', 'process', 'preProcess', 'postProcess'));
		$oController->expects($this->once())
			->method('dispatch')
			->with($oRequest, $oResponse);

		$oFilter = new ControllerFilterTester($oController);
		$oFilter->dispatch($oRequest, $oResponse);
	}

	public function testFilter_ChainedFilters_ProcessCallsNextController()
	{
		$oRequest = new Jaded_Request();
		$oResponse = new Jaded_Response();

		$oController = $this->getMock('Jaded_Controller', array('dispatch', 'process', 'preProcess', 'postProcess'));
		$oController->expects($this->once())
			->method('dispatch')
			->with($oRequest, $oResponse);

		$oInnerFilter = new ControllerFilterTester($oController);
		$oOuterFilter = new ControllerFilterTester($oInnerFilter);
		$oOuterFilter->dispatch($oRequest, $oResponse);
	}
}

class ControllerFilterTester extends Jaded_Controller_Filter
{
	public function preProcess(Jaded_Request $oRequest, Jaded_Response $oResponse){}
	public function postProcess(Jaded_Request $oRequest, Jaded_Response $oResponse){}
}
?>