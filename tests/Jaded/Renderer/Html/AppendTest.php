<?php
class Jaded_Renderer_Html_AppendTest extends PHPUnit_Framework_TestCase
{
	protected $sTemplatePath = 'tests/fixtures/templates';
	protected $sTemplate = '/test/template';
	protected $sFooterTemplate = '/chrome/html_renderer_footer';

	public function testRender_CorrectStringRendered()
	{
		$aData = array(
			'sType' => 'first',
		);
		$aHeaders = array(
			'Header-The-First'  => 'value1',
			'Header-The-Second' => 'value2',
		);
		$sExpected = "this has been rendered. Footer {$aData['sType']} template.";

		$oBaseRenderer = $this->getMock('Jaded_Renderer', array('render'));
		$oBaseRenderer->expects($this->once())
			->method('render')
			->with($this->sTemplate, $aData, $aHeaders)
			->will($this->returnCallback(array($this, 'renderSubTemplate')));

		$oAppend = new Jaded_Renderer_Html_Append($this->sTemplatePath, $oBaseRenderer, $this->sFooterTemplate);

		ob_start();
		$oAppend->render($this->sTemplate, $aData, $aHeaders);
		$sResult = ob_get_clean();

		$this->assertEquals($sExpected, $sResult);
	}

	public function renderSubTemplate()
	{
		print 'this has been rendered. ';
	}
}
