<?php
/**
 * Exceptions dealing with Models
 */
class Jaded_Model_Exception extends Jaded_Exception
{
	const BadDefinitionType = 0;
	const BadStoreType = 1;
	const InvalidMethod = 2;
	const ModelIdentified = 3;
	const ModelNotIdentified = 4;
}
?>