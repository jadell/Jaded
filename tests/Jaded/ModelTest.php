<?php
class Jaded_ModelTest extends PHPUnit_Framework_TestCase
{
	public function testConstruct_NoArgs_ConstructsModelWithDefaultDefAndStore()
	{
		$oModel = new ModelTester();
		$this->assertType('ModelTesterDefinition', $oModel->getModelDefinition());
		$this->assertType('ModelTesterStore', $oModel->getModelStore());

		$this->assertEquals('some default', $oModel->getDefaultField());
	}

	public function testConstruct_DefAndStoreExplicitlyGiven_ConstructsModelWithGivenDefAndStore()
	{
		$oDef = new ModelTesterDefinition();
		$oStore = new ModelTesterStore();

		$oModel = new ModelTester(null, $oDef, $oStore);
		$this->assertSame($oDef, $oModel->getModelDefinition());
		$this->assertSame($oStore, $oModel->getModelStore());
	}

	public function testConstruct_FromArray_ConstructsUsingGivenValues()
	{
		$oModel = new ModelTester(array(
			'id'           => 123,
			'secondid'     => 456,
			'name'         => 'myname',
			'defaultfield' => 'mydefault',
		));

		$this->assertEquals(123, $oModel->getId());
		$this->assertEquals(456, $oModel->getSecondId());
		$this->assertEquals('myname', $oModel->getName());
		$this->assertEquals('mydefault', $oModel->getDefaultField());
	}

	public function testConstruct_FromModel_ConstructsUsingGivenModelValuesDefAndStore()
	{
		$oModel1 = new ModelTester(array(
			'id'           => 123,
			'secondid'     => 456,
			'name'         => 'myname',
			'defaultfield' => 'mydefault',
		));

		$oModel2 = new ModelTester($oModel1);

		$this->assertEquals(123, $oModel2->getId());
		$this->assertEquals(456, $oModel2->getSecondId());
		$this->assertEquals('myname', $oModel2->getName());
		$this->assertEquals('mydefault', $oModel2->getDefaultField());
	}

	public function testIsIdentified_ModelNotFullyIdentified_ReturnsFalse()
	{
		$oModel = new ModelTester(array(
			'id'           => 123,
		));

		$this->assertFalse($oModel->isIdentified());
	}

	public function testIsIdentified_ModelFullyIdentified_ReturnsTrue()
	{
		$oModel = new ModelTester(array(
			'id'           => 123,
			'secondid'     => 456,
		));

		$this->assertTrue($oModel->isIdentified());
	}

	public function testCreate_CallsModelStore()
	{
		$oStore = $this->getMock('ModelTesterStore', array('create'));
		$oModel = new ModelTester(null, null, $oStore);
		
		$oStore->expects($this->once())
			->method('create')
			->with($oModel);

		$oModel->create();
	}

	public function testDelete_CallsModelStore()
	{
		$oStore = $this->getMock('ModelTesterStore', array('delete'));
		$oModel = new ModelTester(null, null, $oStore);
		
		$oStore->expects($this->once())
			->method('delete')
			->with($oModel);

		$oModel->delete();
	}

	public function testLoad_CallsModelStore()
	{
		$oStore = $this->getMock('ModelTesterStore', array('load'));
		$oModel = new ModelTester(null, null, $oStore);
		
		$oStore->expects($this->once())
			->method('load')
			->with($oModel);

		$oModel->load();
	}

	public function testUpdate_CallsModelStore()
	{
		$oStore = $this->getMock('ModelTesterStore', array('update'));
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

class ModelTesterDefinition extends Jaded_Model_Definition
{
	public $aFieldMap = array(
		'id'           => 'idfield',
		'secondid'     => 'other_id_field',
		'name'         => 'name',
		'defaultfield' => 'default_field',
	);

	public $aKeyFields = array(
		'id'       => 'auto',
		'secondid' => 'key',
	);

	public $aDefaultValues = array(
		'defaultfield' => 'some default',
	);
}

class ModelTesterStore extends Jaded_Model_Store
{
	public function create(Jaded_Model $oModel){}
	public function delete(Jaded_Model $oModel){}
	public function load(Jaded_Model $oModel){}
	public function update(Jaded_Model $oModel){}
}

class ModelTester extends Jaded_Model
{
	protected $sDefaultDefinition = 'ModelTesterDefinition';
	protected $sDefaultStore      = 'ModelTesterStore';
}
?>