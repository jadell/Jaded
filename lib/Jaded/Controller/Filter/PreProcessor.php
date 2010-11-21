<?php
/**
 * Only need to define the preprocess method
 */
abstract class Jaded_Controller_Filter_PreProcessor extends Jaded_Controller_Filter
{
	protected function postProcess(Jaded_Request $oRequest, Jaded_Response $oResponse){}
}
