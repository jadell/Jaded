<?php
/**
 * Sets the configured header and footer
 */
class Jaded_Controller_Filter_RendererChrome extends Jaded_Controller_Filter_PreProcessor
{
	protected function preProcess(Jaded_Request $oRequest, Jaded_Response $oResponse)
	{
		$oResponse->setTemplate('header', Jaded_Config::get('renderer.html.header'));
		$oResponse->setTemplate('footer', Jaded_Config::get('renderer.html.footer'));
	}
}
