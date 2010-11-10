<?php
class Jaded_Renderer_Html_PrependTest extends PHPUnit_Framework_TestCase
{
	protected $sTemplatePath = 'tests/fixtures/templates';
	protected $sTemplate = '/test/template';
	protected $sHeaderTemplate = '/chrome/html_renderer_header';

	public function testRender_CorrectStringRendered()
	{
		$aData = array(
			'sType' => 'first',
		);
		$aHeaders = array(
			'Header-The-First'  => 'value1',
			'Header-The-Second' => 'value2',
		);
		$sExpected = "Header {$aData['sType']} template. this has been rendered";

		$oBaseRenderer = $this->getMock('Jaded_Renderer', array('render'));
		$oBaseRenderer->expects($this->once())
			->method('render')
			->with($this->sTemplate, $aData, $aHeaders)
			->will($this->returnCallback(array($this, 'renderSubTemplate')));

		$oPrepend = new Jaded_Renderer_Html_Prepend($this->sTemplatePath, $oBaseRenderer, $this->sHeaderTemplate);

		ob_start();
		$oPrepend->render($this->sTemplate, $aData, $aHeaders);
		$sResult = ob_get_clean();

		$this->assertEquals($sExpected, $sResult);
	}

	public function renderSubTemplate()
	{
		print ' this has been rendered';
	}
}
?>