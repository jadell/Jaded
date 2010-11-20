<?php
/**
 * Append an html template to the given rendered template
 */
class Jaded_Renderer_Html_Append extends Jaded_Renderer_Html
{
	protected $oRenderer = null;
	protected $sAppendTemplate = '';

	//////////////////////////////////////////////////////////////////////
	// PUBLIC ///////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Build the renderer
	 * @param string $sTemplatePath
	 * @param Jaded_Renderer $oRenderer
	 * @param string $sAppendTemplate
 	 */
	public function __construct($sTemplatePath, $oRenderer, $sAppendTemplate)
	{
		$this->oRenderer = $oRenderer;
		$this->sAppendTemplate = $sAppendTemplate;
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
		$this->oRenderer->render($sTemplate, $aData, $aHeaders);
		$this->renderTemplate($this->sAppendTemplate, $aData);
	}
}
