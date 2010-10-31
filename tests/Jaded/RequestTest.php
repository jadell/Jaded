<?php
class Jaded_RequestTest extends PHPUnit_Framework_TestCase
{
	public function testGetParam_ParamNotSet_ReturnsNull()
	{
		$oRequest = new Jaded_Request();
		$sName = 'someparam';

		$this->assertNull($oRequest->getParam($sName));
	}

	public function testGetParam_ParamSet_ReturnsSetValue()
	{
		$oRequest = new Jaded_Request();
		$sName = 'someparam';
		$sValue = 'some value';
		$oRequest->setParam($sName, $sValue);

		$this->assertEquals($sValue, $oRequest->getParam($sName));
	}

	public function testControllerName_SetControllerName_ReturnsName()
	{
		$oRequest = new Jaded_Request();
		$sController = 'my_controller';
		$oRequest->setControllerName($sController);

		$this->assertEquals($sController, $oRequest->getControllerName());
	}
}
?>