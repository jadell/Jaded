<?php
class Jaded_Controller_Filter_SetRequestParamsTest extends PHPUnit_Framework_TestCase
{
	public function testFilter_SetsRequestParams()
	{
		$aParams = array(
			'param1' => 123,
			'another' => 'this is the value',
		);

		$oRequest = new Jaded_Request();
		$oResponse = new Jaded_Response();
		$oController = $this->getMock('Jaded_Controller', array('preProcess','process','postProcess'));

		$oFilter = new Jaded_Controller_Filter_SetRequestParams($oController);

		$_REQUEST = $aParams;
		$oFilter->dispatch($oRequest, $oResponse);

		foreach ($aParams as $sKey => $sValue) {
			$this->assertEquals($sValue, $oRequest->getParam($sKey));
		}
	}
}
