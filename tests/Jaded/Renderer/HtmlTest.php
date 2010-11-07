<?php
class Jaded_Renderer_HtmlTest extends PHPUnit_Framework_TestCase
{
	protected $oRenderer = null;
	protected $sTemplatePath = 'tests/fixtures/templates';
	protected $sTemplate = '/html_renderer_template';

	public function setup()
	{
		$oRenderer = $this->getMock('Jaded_Renderer_Html', array('renderHeaders'), array($this->sTemplatePath));
		$this->oRenderer = $oRenderer;
	}

	public function testRender_CorrectStringRendered()
	{
		$aData = array(
			'sType' => 'first',
		);
		$aHeaders = array(
			'Header-The-First'  => 'value1',
			'Header-The-Second' => 'value2',
		);

		$this->oRenderer
			->expects($this->once())
			->method('renderHeaders')
			->with($aHeaders);

		$sExpected = "This is my {$aData['sType']} template.";
		$sResult = $this->renderTemplate($this->sTemplate, $aData, $aHeaders);
		$this->assertEquals($sExpected, $sResult);
	}

	protected function renderTemplate($sTemplate, $aData, $aHeaders)
	{
		ob_start();
		$this->oRenderer->render($sTemplate, $aData, $aHeaders);
		$sRendered = ob_get_clean();
		return $sRendered;
	}
}
?>