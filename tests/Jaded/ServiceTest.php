<?php
class Jaded_ServiceTest extends PHPUnit_Framework_TestCase
{
	public function testSingleton_ReturnsRequestedService()
	{
		$oService = Jaded_Service::instance('ServiceTester');
		$this->assertType('ServiceTester', $oService);
	}

	public function testSingleton_CalledMoreThanOnce_ReturnsSingleton()
	{
		$oService = Jaded_Service::instance('ServiceTester');
		$oService2 = Jaded_Service::instance('ServiceTester');
		$this->assertSame($oService, $oService2);
	}

	public function testSingleton_CalledWithNonServiceClass_ThrowsException()
	{
		$this->setExpectedException('Jaded_Service_Exception');
		$oDef = Jaded_Service::instance(__CLASS__);
	}
}
