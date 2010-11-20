<?php
/**
 * Display a template as html
 */
class Jaded_Renderer_Html implements Jaded_Renderer
{
	protected $sTemplatePath = '.';

	//////////////////////////////////////////////////////////////////////
	// PUBLIC ///////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Build the renderer
	 * @param string $sTemplatePath
 	 */
	public function __construct($sTemplatePath)
	{
		$this->sTemplatePath = $sTemplatePath;
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
		$this->renderHeaders($aHeaders);
		$this->renderTemplate($sTemplate, $aData);
	}

	//////////////////////////////////////////////////////////////////////
	// PROTECTED ////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////
	
	/**
	 * Get the path to the needed template file
	 * @param string $sTemplate
	 * @return string
	 */
	protected function getTemplateFile($sTemplate)
	{
		return "{$this->sTemplatePath}{$sTemplate}.php";
	}

	/**
	 * Render the headers
	 * @param array  $aHeaders
	 */
	protected function renderHeaders($aHeaders)
	{
		foreach ($aHeaders as $sHeader => $sValue) {
			header("{$sHeader}: {$sValue}");
		}
	}

	/**
	 * Render the template
	 * @param string $sTemplate
	 * @param array  $aData
	 */
	protected function renderTemplate($sTemplate, $aData)
	{
		$sTemplateFile = $this->getTemplateFile($sTemplate);
		extract($aData);
		require($sTemplateFile);
	}
}
