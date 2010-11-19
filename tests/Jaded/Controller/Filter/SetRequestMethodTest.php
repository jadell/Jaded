<?php
class Jaded_Controller_Filter_SetRequestMethodTest extends PHPUnit_Framework_TestCase
{
	public function testFilter_SetsTheCorrectRequestMethod()
	{
		$sMethod = Jaded_Request::MethodPost;

		$oRequest = new Jaded_Request();
		$oResponse = new Jaded_Response();
		$oController = $this->getMock('Jaded_Controller', array('preProcess','process','postProcess'));

		$oFilter = new Jaded_Controller_Filter_SetRequestMethod($oController);

		$_SERVER['REQUEST_METHOD'] = $sMethod;
		$oFilter->dispatch($oRequest, $oResponse);

		$this->assertEquals($sMethod, $oRequest->getMethod());
	}
}
?>