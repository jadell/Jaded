<?php
class ModelDefinitionTester extends Jaded_Model_Definition
{
	public $aFieldMap = array(
		'idfield'      => 'idfield',
		'multikey'     => 'key_part',
		'name'         => 'name',
		'defaultfield' => 'default_field',
	);

	public $aKeyFields = array(
		'idfield'  => 'auto',
		'multikey' => 'key',
	);

	public $aDefaultValues = array(
		'defaultfield' => 'some default',
	);
}
?>