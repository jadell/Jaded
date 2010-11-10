<?php
/**
 * Prepend an html template to the given rendered template
 */
class Jaded_Renderer_Html_Prepend extends Jaded_Renderer_Html
{
	protected $oRenderer = null;
	protected $sPrependTemplate = '';

	//////////////////////////////////////////////////////////////////////
	// PUBLIC ///////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Build the renderer
	 * @param string $sTemplatePath
	 * @param Jaded_Renderer $oRenderer
	 * @param string $sPrependTemplate
 	 */
	public function __construct($sTemplatePath, $oRenderer, $sPrependTemplate)
	{
		$this->oRenderer = $oRenderer;
		$this->sPrependTemplate = $sPrependTemplate;
		parent::__construct($sTemplatePath);
	}

	/**
	 * Render the view with the given information
	 * This should actually output the rendered string (and headers, etc.)
	 * @param string $sTemplate
	 * @param array  $aData
	 * @param array  $aHeaders
	 */
	public function render($sTemplate, $aData, $aHeaders)
	{
		$this->renderTemplate($this->sPrependTemplate, $aData);
		$this->oRenderer->render($sTemplate, $aData, $aHeaders);
	}
}
?>