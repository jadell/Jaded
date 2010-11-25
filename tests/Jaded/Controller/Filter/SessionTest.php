<?php
class Jaded_Controller_Filter_SessionTest extends PHPUnit_Framework_TestCase
{
	public function testFilter_InitializesAndClosesSession()
	{
		$oRequest = new Jaded_Request();
		$oResponse = new Jaded_Response();
		$oController = $this->getMock('Jaded_Controller', array('preProcess','process','postProcess'));

		$oSession = $this->getMock('Jaded_Session', array('open', 'close', 'destroy', 'setParam', 'getParam'));
		$oSession
			->expects($this->once())
			->method('open');
		$oSession
			->expects($this->once())
			->method('close');
		$oRequest->setSession($oSession);

		$oFilter = new Jaded_Controller_Filter_Session($oController);
		$oFilter->dispatch($oRequest, $oResponse);
	}
}
