<?php
class Jaded_RouterTest extends PHPUnit_Framework_TestCase
{
	public function testSingleton_ReturnsRequestedService()
	{
		$oRouter = Jaded_Router::instance();
		$this->assertType('Jaded_Router', $oRouter);
	}

	public function testSingleton_CalledMoreThanOnce_ReturnsSingleton()
	{
		$oRouter = Jaded_Router::instance();
		$oRouter2 = Jaded_Router::instance();
		$this->assertSame($oRouter, $oRouter2);
	}

	public function testMap_FirstRouteMatches_RequestFilledFromFirstRoute()
	{
		$sUri = '/some/test/uri';
		$sController = 'TestController';
		$sParam1 = 'first param';
		$sParam2 = '123';
		$oRequest = new Jaded_Request();
		$oRouter = new Jaded_Router();

		$oRoute1 = $this->getMock('Jaded_Router_Route', array('map'));
		$oRoute1->expects($this->once())
			->method('map')
			->with($sUri)
			->will($this->returnValue(array(
				'controller' => $sController,
				'param1'     => $sParam1,
				'param2'     => $sParam2,
			)));

		$oRoute2 = $this->getMock('Jaded_Router_Route', array('map'));
		$oRoute2->expects($this->once())
			->method('map')
			->with($sUri)
			->will($this->returnValue(null));

		$oRouter->setRoute($oRoute1);
		$oRouter->setRoute($oRoute2);

		$oRequest = $oRouter->map($sUri, $oRequest);
		$this->assertEquals($sController, $oRequest->getControllerName());
		$this->assertEquals($sParam1, $oRequest->getParam('param1'));
		$this->assertEquals($sParam2, $oRequest->getParam('param2'));
	}

	public function testMap_LatestRouteMatches_RequestFilledFromLatestRoute()
	{
		$sUri = '/some/test/uri';
		$sController = 'TestController';
		$sParam1 = 'first param';
		$sParam2 = '123';
		$oRequest = new Jaded_Request();
		$oRouter = new Jaded_Router();

		$oRoute1 = $this->getMock('Jaded_Router_Route', array('map'));
		$oRoute1->expects($this->once())
			->method('map')
			->with($sUri)
			->will($this->returnValue(array(
				'controller' => $sController,
				'param1'     => $sParam1,
				'param2'     => $sParam2,
			)));

		$oRoute2 = $this->getMock('Jaded_Router_Route', array('map'));
		$oRoute2->expects($this->never())
			->method('map');

		$oRouter->setRoute($oRoute2);
		$oRouter->setRoute($oRoute1);

		$oRequest = $oRouter->map($sUri, $oRequest);
		$this->assertEquals($sController, $oRequest->getControllerName());
		$this->assertEquals($sParam1, $oRequest->getParam('param1'));
		$this->assertEquals($sParam2, $oRequest->getParam('param2'));
	}
}
?>