<?php
/**
 * Apply common filters needed for processing an HTTP request
 */
abstract class Jaded_Controller_Filter_CommonHttpRequest extends Jaded_Controller_Filter
{
	protected $aFilters = array(
		'Jaded_Controller_Filter_Session',
		'Jaded_Controller_Filter_SetRequestMethod',
		'Jaded_Controller_Filter_SetRequestParams',
	);
}
