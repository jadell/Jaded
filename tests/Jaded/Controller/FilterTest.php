<?php
class Jaded_Controller_FilterTest extends PHPUnit_Framework_TestCase
{
	public function testFilter_ProcessCallsNextController()
	{
		$oRequest = new Jaded_Request();
		$oResponse = new Jaded_Response();

		$oController = $this->getMock('Jaded_Controller', array('dispatch', 'process'));
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

		$oController = $this->getMock('Jaded_Controller', array('dispatch', 'process'));
		$oController->expects($this->once())
			->method('dispatch')
			->with($oRequest, $oResponse);

		$oInnerFilter = new ControllerFilterTester($oController);
		$oOuterFilter = new ControllerFilterTester($oInnerFilter);
		$oOuterFilter->dispatch($oRequest, $oResponse);
	}

	public function testProcessFlags_NoPreProcess_DoesNotCallPreProcess()
	{
		$oRequest = new Jaded_Request();
		$oResponse = new Jaded_Response();
		$oController = $this->getMock('Jaded_Controller', array('dispatch', 'process'));
		$oController->expects($this->once())
			->method('dispatch')
			->with($oRequest, $oResponse);

		$oFilter = $this->getMock('ControllerFilterTester', array('preProcess','postProcess'), array($oController));

		$oFilter->bDoPreProcess = false;
		$oFilter->expects($this->never())
			->method('preProcess');
		$oFilter->expects($this->once())
			->method('postProcess')
			->with($oRequest, $oResponse);

		$oFilter->dispatch($oRequest, $oResponse);
	}

	public function testProcessFlags_NoPostProcess_DoesNotCallPostProcess()
	{
		$oRequest = new Jaded_Request();
		$oResponse = new Jaded_Response();
		$oController = $this->getMock('Jaded_Controller', array('dispatch', 'process'));
		$oController->expects($this->once())
			->method('dispatch')
			->with($oRequest, $oResponse);

		$oFilter = $this->getMock('ControllerFilterTester', array('preProcess','postProcess'), array($oController));

		$oFilter->bDoPostProcess = false;
		$oFilter->expects($this->once())
			->method('preProcess')
			->with($oRequest, $oResponse);
		$oFilter->expects($this->never())
			->method('postProcess');

		$oFilter->dispatch($oRequest, $oResponse);
	}

	public function testProcessFlags_NoProcess_DoesNotCallDispatchOnNextController()
	{
		$oRequest = new Jaded_Request();
		$oResponse = new Jaded_Response();
		$oController = $this->getMock('Jaded_Controller', array('dispatch', 'process'));
		$oController->expects($this->never())
			->method('dispatch');

		$oFilter = $this->getMock('ControllerFilterTester', array('preProcess','postProcess'), array($oController));

		$oFilter->bDoProcess = false;
		$oFilter->expects($this->once())
			->method('preProcess')
			->with($oRequest, $oResponse);
		$oFilter->expects($this->once())
			->method('postProcess')
			->with($oRequest, $oResponse);

		$oFilter->dispatch($oRequest, $oResponse);
	}
}
