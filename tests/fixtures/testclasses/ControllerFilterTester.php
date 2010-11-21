<?php
class ControllerFilterTester extends Jaded_Controller_Filter
{
	public $bDoPreProcess = true;
	public $bDoProcess = true;
	public $bDoPostProcess = true;

	public function preProcess(Jaded_Request $oRequest, Jaded_Response $oResponse){}
	public function postProcess(Jaded_Request $oRequest, Jaded_Response $oResponse){}
}
