<?php
class Jaded_Model_DefinitionTest extends PHPUnit_Framework_TestCase
{
	public function testSingleton_ReturnsRequestedModelDefinition()
	{
		$oDef = Jaded_Model_Definition::instance('ModelDefinitionTester');
		$this->assertInstanceOf('ModelDefinitionTester', $oDef);
	}

	public function testSingleton_CalledMoreThanOnce_ReturnsSingleton()
	{
		$oDef = Jaded_Model_Definition::instance('ModelDefinitionTester');
		$oDef2 = Jaded_Model_Definition::instance('ModelDefinitionTester');
		$this->assertSame($oDef, $oDef2);
	}

	public function testSingleton_CalledWithNonDefinitionClass_ThrowsException()
	{
		$this->setExpectedException('Jaded_Model_Exception');
		$oDef = Jaded_Model_Definition::instance(__CLASS__);
	}

	public function testGetDefaults_ReturnsDefaultValues()
	{
		$oDef = Jaded_Model_Definition::instance('ModelDefinitionTester');
		$this->assertEquals($oDef->aDefaultValues, $oDef->getDefaults());
	}

	public function testGetFieldMap_ReturnsFieldMap()
	{
		$oDef = Jaded_Model_Definition::instance('ModelDefinitionTester');
		$this->assertEquals($oDef->aFieldMap, $oDef->getFieldMap());
	}

	public function testIsModelIdentified_NotIdentified_ReturnsFalse()
	{
		$oModel = $this->getMock('Jaded_Model', array('getidfield', 'getmultikey'), array(), '', false);
		$oModel->expects($this->once())
			->method('getidfield')
			->will($this->returnValue(123));
		$oModel->expects($this->once())
			->method('getmultikey')
			->will($this->returnValue(null));

		$oDef = Jaded_Model_Definition::instance('ModelDefinitionTester');
		$this->assertFalse($oDef->isModelIdentified($oModel));
	}

	public function testIsModelIdentified_Identified_ReturnsTrue()
	{
		$oModel = $this->getMock('Jaded_Model', array('getidfield', 'getmultikey'), array(), '', false);
		$oModel->expects($this->once())
			->method('getidfield')
			->will($this->returnValue(123));
		$oModel->expects($this->once())
			->method('getmultikey')
			->will($this->returnValue(456));

		$oDef = Jaded_Model_Definition::instance('ModelDefinitionTester');
		$this->assertTrue($oDef->isModelIdentified($oModel));
	}

	public function testGetAutoKey_NoAutoKey_ReturnsAutoIncrementKeyField()
	{
		$oDef = Jaded_Model_Definition::instance('ModelDefinitionTester');
		$this->assertEquals('idfield', $oDef->getAutoKey());
	}

	public function testInternalFieldName_FieldDoesNotExist_ReturnsNull()
	{
		$oDef = Jaded_Model_Definition::instance('ModelDefinitionTester');
		$this->assertNull($oDef->getInternalField('non_existent_field'));
	}

	public function testInternalFieldName_InternalFieldNameGiven_ReturnsNull()
	{
		$oDef = Jaded_Model_Definition::instance('ModelDefinitionTester');
		$this->assertNull($oDef->getInternalField('key_part'));
	}

	public function testInternalFieldName_ExternalFieldNameGiven_ReturnsInternalFieldName()
	{
		$oDef = Jaded_Model_Definition::instance('ModelDefinitionTester');
		$this->assertEquals('key_part', $oDef->getInternalField('multikey'));
	}

	public function testGetKeys_ReturnsKeyFields()
	{
		$oDef = Jaded_Model_Definition::instance('ModelDefinitionTester');
		$this->assertEquals($oDef->aKeyFields, $oDef->getKeys());
	}
}
