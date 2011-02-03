<?php
class Jaded_ModelTest extends PHPUnit_Framework_TestCase
{
	public function testConstruct_NoArgs_ConstructsModelWithDefaultDefAndStore()
	{
		$oModel = new ModelTester();
		$this->assertInstanceOf('ModelDefinitionTester', $oModel->getModelDefinition());
		$this->assertInstanceOf('ModelStoreTester', $oModel->getModelStore());

		$this->assertEquals('some default', $oModel->getDefaultField());
	}

	public function testConstruct_DefAndStoreExplicitlyGiven_ConstructsModelWithGivenDefAndStore()
	{
		$oDef = new ModelDefinitionTester();
		$oStore = new ModelStoreTester();

		$oModel = new ModelTester(null, $oDef, $oStore);
		$this->assertSame($oDef, $oModel->getModelDefinition());
		$this->assertSame($oStore, $oModel->getModelStore());
	}

	public function testConstruct_FromArray_ConstructsUsingGivenValues()
	{
		$oModel = new ModelTester(array(
			'idfield'      => 123,
			'multikey'     => 456,
			'name'         => 'myname',
			'defaultfield' => 'mydefault',
		));

		$this->assertEquals(123, $oModel->getIdField());
		$this->assertEquals(456, $oModel->getMultiKey());
		$this->assertEquals('myname', $oModel->getName());
		$this->assertEquals('mydefault', $oModel->getDefaultField());
	}

	public function testConstruct_FromModel_ConstructsUsingGivenModelValuesDefAndStore()
	{
		$oModel1 = new ModelTester(array(
			'idfield'      => 123,
			'multikey'     => 456,
			'name'         => 'myname',
			'defaultfield' => 'mydefault',
		));

		$oModel2 = new ModelTester($oModel1);

		$this->assertEquals(123, $oModel2->getIdField());
		$this->assertEquals(456, $oModel2->getMultiKey());
		$this->assertEquals('myname', $oModel2->getName());
		$this->assertEquals('mydefault', $oModel2->getDefaultField());
	}

	public function testSet_SetValues_ReturnsCorrectValues()
	{
		$oModel = new ModelTester();
		$oModel->setIdField(123)
			->setMultikey(456)
			->setName('myname')
			->setDefaultField('mydefault');

		$this->assertEquals(123, $oModel->getIdField());
		$this->assertEquals(456, $oModel->getMultiKey());
		$this->assertEquals('myname', $oModel->getName());
		$this->assertEquals('mydefault', $oModel->getDefaultField());
	}

	public function testIsIdentified_ModelNotFullyIdentified_ReturnsFalse()
	{
		$oModel = new ModelTester(array(
			'idfield' => 123,
		));

		$this->assertFalse($oModel->isIdentified());
	}

	public function testIsIdentified_ModelFullyIdentified_ReturnsTrue()
	{
		$oModel = new ModelTester(array(
			'idfield'  => 123,
			'multikey' => 456,
		));

		$this->assertTrue($oModel->isIdentified());
	}

	public function testCreate_CallsModelStore()
	{
		$oStore = $this->getMock('ModelStoreTester', array('create'));
		$oModel = new ModelTester(null, null, $oStore);
		
		$oStore->expects($this->once())
			->method('create')
			->with($oModel);

		$oModel->create();
	}

	public function testDelete_CallsModelStore()
	{
		$oStore = $this->getMock('ModelStoreTester', array('delete'));
		$oModel = new ModelTester(null, null, $oStore);
		
		$oStore->expects($this->once())
			->method('delete')
			->with($oModel);

		$oModel->delete();
	}

	public function testLoad_CallsModelStore()
	{
		$oStore = $this->getMock('ModelStoreTester', array('load'));
		$oModel = new ModelTester(null, null, $oStore);
		
		$oStore->expects($this->once())
			->method('load')
			->with($oModel);

		$oModel->load();
	}

	public function testUpdate_CallsModelStore()
	{
		$oStore = $this->getMock('ModelStoreTester', array('update'));
		$oModel = new ModelTester(null, null, $oStore);
		
		$oStore->expects($this->once())
			->method('update')
			->with($oModel);

		$oModel->update();
	}

	public function testGetAnInvalidField_ThrowsException()
	{
		$oModel = new ModelTester();
		$this->setExpectedException('Jaded_Model_Exception');
		$oModel->getNoField();
	}

	public function testSetAnInvalidField_ThrowsException()
	{
		$oModel = new ModelTester();
		$this->setExpectedException('Jaded_Model_Exception');
		$oModel->setNoField('foo');
	}
}
