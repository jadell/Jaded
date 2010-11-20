<?php
/**
 * Collects together several Controller Filters to apply to the given controller
 */
abstract class Jaded_Controller_Filter_Chain extends Jaded_Controller_Filter
{
	/**
	 * List of filters to apply to the controller
	 * First listed will be the outermost filter,
	 * last will be the innermost.
	 * Override in concrete classes
	 */
	protected $aFilters = array();

	////////////////////////////////////////////////////////////////////////////////
	// PUBLIC /////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Wrap the given controller in the filters
	 * @param Jaded_Controller $oController
	 */
	public function __construct(Jaded_Controller $oController)
	{
		$aFilters = array_reverse($this->aFilters);
		foreach ($aFilters as $sFilterType) {
			$oController = new $sFilterType($oController);
		}
		parent::__construct($oController);
	}

	protected function preProcess(Jaded_Request $oRequest, Jaded_Response $oResponse){}
	protected function postProcess(Jaded_Request $oRequest, Jaded_Response $oResponse){}
}
