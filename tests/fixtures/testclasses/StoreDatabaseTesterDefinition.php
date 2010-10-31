<?php
class StoreDatabaseTesterDefinition extends Jaded_Model_Definition
{
	public $aFieldMap = array(
		'tableid'      => 'tableid',
		'name'         => 'name',
		'createddate'  => 'createddate',
		'ranking'      => 'ranking',
	);

	public $aKeyFields = array(
		'tableid' => 'auto',
	);
}
?>