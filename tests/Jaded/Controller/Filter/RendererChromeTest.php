<?php
class Jaded_Controller_Filter_RendererChromeTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		Jaded_Config::save();
		Jaded_Config::set('renderer.html.header', '/some/chrome/header.php');
		Jaded_Config::set('renderer.html.footer', '/some/chrome/footer.php');
	}

	public function tearDown()
	{
		Jaded_Config::restore();
	}

	public function testFilter_HeaderAndFooterSet_ReturnsHeaderAndFooter()
	{
		$oRequest = new Jaded_Request();
		$oResponse = new Jaded_Response();
		$oController = $this->getMock('Jaded_Controller', array('preProcess','process','postProcess'));

		$oFilter = new Jaded_Controller_Filter_RendererChrome($oController);
		$oFilter->dispatch($oRequest, $oResponse);

		self::assertEquals('/some/chrome/header.php', $oResponse->getTemplate('header'));
		self::assertEquals('/some/chrome/footer.php', $oResponse->getTemplate('footer'));
	}

	public function testFilter_HeaderOnlySet_ReturnsHeader()
	{
		Jaded_Config::set('renderer.html.footer', null);

		$oRequest = new Jaded_Request();
		$oResponse = new Jaded_Response();
		$oController = $this->getMock('Jaded_Controller', array('preProcess','process','postProcess'));

		$oFilter = new Jaded_Controller_Filter_RendererChrome($oController);
		$oFilter->dispatch($oRequest, $oResponse);

		self::assertEquals('/some/chrome/header.php', $oResponse->getTemplate('header'));
		self::assertNull($oResponse->getTemplate('footer'));
	}

	public function testFilter_FooterOnlySet_ReturnsFooter()
	{
		Jaded_Config::set('renderer.html.header', null);

		$oRequest = new Jaded_Request();
		$oResponse = new Jaded_Response();
		$oController = $this->getMock('Jaded_Controller', array('preProcess','process','postProcess'));

		$oFilter = new Jaded_Controller_Filter_RendererChrome($oController);
		$oFilter->dispatch($oRequest, $oResponse);

		self::assertNull($oResponse->getTemplate('header'));
		self::assertEquals('/some/chrome/footer.php', $oResponse->getTemplate('footer'));
	}
}
