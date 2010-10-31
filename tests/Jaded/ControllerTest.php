<?php
class Jaded_ControllerTest extends PHPUnit_Framework_TestCase
{
	protected $oController = null;
	protected $oRequest = null;
	protected $oResponse = null;

	public function setUp()
	{
		$this->oRequest = new Jaded_Request();
		$this->oResponse = new Jaded_Response();
		$this->oController = $this->getMock('ControllerTester', array('preProcess','process','postProcess'));
	}

	public function testDispatch_NoPreProcess_DoesNotCallPreProcess()
	{
		$this->oController->bDoPreProcess = false;
		$this->oController
			->expects($this->never())
			->method('preProcess');
		$this->oController
			->expects($this->once())
			->method('process')
			->with($this->oRequest, $this->oResponse);
		$this->oController
			->expects($this->once())
			->method('postProcess')
			->with($this->oRequest, $this->oResponse);

		$this->oController->dispatch($this->oRequest, $this->oResponse);
	}

	public function testDispatch_NoProcess_DoesNotCallProcess()
	{
		$this->oController->bDoProcess = false;
		$this->oController
			->expects($this->once())
			->method('preProcess')
			->with($this->oRequest, $this->oResponse);
		$this->oController
			->expects($this->never())
			->method('process');
		$this->oController
			->expects($this->once())
			->method('postProcess')
			->with($this->oRequest, $this->oResponse);

		$this->oController->dispatch($this->oRequest, $this->oResponse);
	}

	public function testDispatch_NoPostProcess_DoesNotCallPostProcess()
	{
		$this->oController->bDoPostProcess = false;
		$this->oController
			->expects($this->once())
			->method('preProcess')
			->with($this->oRequest, $this->oResponse);
		$this->oController
			->expects($this->once())
			->method('process')
			->with($this->oRequest, $this->oResponse);
		$this->oController
			->expects($this->never())
			->method('postProcess');

		$this->oController->dispatch($this->oRequest, $this->oResponse);
	}
}
?>