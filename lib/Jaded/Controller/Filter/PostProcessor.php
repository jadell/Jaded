<?php
/**
 * Only need to define the postprocess method
 */
abstract class Jaded_Controller_Filter_PostProcessor extends Jaded_Controller_Filter
{
	protected function preProcess(Jaded_Request $oRequest, Jaded_Response $oResponse){}
}
