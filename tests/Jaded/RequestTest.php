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

	public function testMethod_DefaultMethod_ReturnsGet()
	{
		$oRequest = new Jaded_Request();
		self::assertEquals(Jaded_Request::MethodGet, $oRequest->getMethod());
	}
 
	public function testMethod_SetInvalidMethod_ThrowsException()
	{
		$oRequest = new Jaded_Request();
		$this->setExpectedException('Jaded_Exception');
		$oRequest->setMethod('some_unknown_method');
	}

	/**
	 * @dataProvider dataProvider_RequestMethods
	 */
	public function testMethod_SetValidMethod_ReturnsSetMethod($sMethod, $sExpectedMethod, $bIsGet, $bIsPost, $bIsPut, $bIsDelete)
	{
		$oRequest = new Jaded_Request();
		$oRequest->setMethod($sMethod);
		self::assertEquals($sExpectedMethod, $oRequest->getMethod());
		self::assertEquals($bIsGet, $oRequest->isGet());
		self::assertEquals($bIsPost, $oRequest->isPost());
		self::assertEquals($bIsPut, $oRequest->isPut());
		self::assertEquals($bIsDelete, $oRequest->isDelete());
	}

	public function dataProvider_RequestMethods()
	{
		return array(
			array(Jaded_Request::MethodGet, Jaded_Request::MethodGet, true, false, false, false),
			array(Jaded_Request::MethodPost, Jaded_Request::MethodPost, false, true, false, false),
			array(Jaded_Request::MethodPut, Jaded_Request::MethodPut, false, false, true, false),
			array(Jaded_Request::MethodDelete, Jaded_Request::MethodDelete, false, false, false, true),
			array('gEt', Jaded_Request::MethodGet, true, false, false, false),
		);
	}
}
?>