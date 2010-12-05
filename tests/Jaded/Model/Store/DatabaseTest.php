<?php
class Jaded_Model_Store_DatabaseTest extends PHPUnit_Framework_TestCase
{
	protected $oStore = null;
	protected $aDefault = array(
		'tableid'     => 1,
		'name'        => 'Test1',
		'createddate' => '2010-10-27 20:53:32',
		'ranking'     => 321,
	);

	public static function setUpBeforeClass()
	{
		$oDb = new Jaded_Db_Pdo('mysql://jaded:jaded@localhost/jaded_test');
		Jaded_Db::set('testdb', $oDb);
	}

	public function setUp()
	{
		$this->oStore = Jaded_Model_Store::instance('StoreDatabaseTesterStore');

		try {
			Jaded_Db::conn('testdb')->execute('TRUNCATE testtable');
			Jaded_Db::conn('testdb')->execute('INSERT INTO testtable (tableid, name, createddate, ranking) VALUES (?,?,?,?)',
				array_values($this->aDefault));
		} catch (Exception $e) {
			$this->markTestSkipped("Could not connect to test database.");
		}
	}

	public function testLoad_ModelNotIdentified_ThrowsException()
	{
		$oModel = new StoreDatabaseTester();
		$this->setExpectedException('Jaded_Model_Exception');
		$this->oStore->load($oModel);
	}

	public function testLoad_ModelIdentified_ModelDataLoadedFromDb()
	{
		$oModel = new StoreDatabaseTester(array(
			'tableid' => $this->aDefault['tableid']
		));
		$this->oStore->load($oModel);
		$this->assertEquals($this->aDefault['tableid'],     $oModel->getTableId());
		$this->assertEquals($this->aDefault['name'],        $oModel->getName());
		$this->assertEquals($this->aDefault['createddate'], $oModel->getCreatedDate());
		$this->assertEquals($this->aDefault['ranking'],     $oModel->getRanking());
	}

	public function testLoad_ModelIdentifiedNotInDb_ThrowsException()
	{
		$oModel = new StoreDatabaseTester(array(
			'tableid' => $this->aDefault['tableid']+1000
		));
		$this->setExpectedException('Jaded_Model_Exception');

		$this->oStore->load($oModel);
	}

	public function testCreate_ModelFullyIdentified_ThrowsException()
	{
		$oModel = new StoreDatabaseTester(array('tableid' => 3));
		$this->setExpectedException('Jaded_Model_Exception');
		$this->oStore->create($oModel);
	}

	public function testCreate_ModelNotIdentified_CreateModelAndUpdatesIdField()
	{
		$aModelValues = array(
			'name'         => 'Tester Name',
			'createddate'  => '2010-10-28 20:51:32',
			'ranking'      => 123,
		);
		$oModel = new StoreDatabaseTester($aModelValues);

		$oModel->create();
		$iExpectedId = 2;
		$iActualId = $oModel->getTableId();
		$this->assertEquals($iExpectedId, $iActualId);

		$aExpected = $aModelValues;
		$aExpected['tableid'] = $iActualId;
		$aActual = Jaded_Db::conn('testdb')->getRow('SELECT * FROM testtable WHERE tableid=?', array($iActualId));
		$this->assertEquals($aExpected, $aActual);
	}

	public function testDelete_ModelNotIdentified_ThrowsException()
	{
		$oModel = new StoreDatabaseTester();
		$this->setExpectedException('Jaded_Model_Exception');
		$this->oStore->delete($oModel);
	}

	public function testDelete_ModelIdentified_ModelDataRemovedFromDb()
	{
		$oModel = new StoreDatabaseTester(array(
			'tableid' => $this->aDefault['tableid']
		));
		$this->oStore->delete($oModel);
		
		$aExpected = array();
		$aActual = Jaded_Db::conn('testdb')->getRow('SELECT * FROM testtable WHERE tableid=?', array($this->aDefault['tableid']));
		$this->assertEquals($aExpected, $aActual);
	}

	public function testUpdate_ModelNotIdentified_ThrowsException()
	{
		$oModel = new StoreDatabaseTester();
		$this->setExpectedException('Jaded_Model_Exception');
		$this->oStore->update($oModel);
	}

	public function testUpdate_ModelIdentified_ModelDataUpdatedInDb()
	{
		$aExpected = array(
			'tableid' => $this->aDefault['tableid'],
			'name'        => 'New Name',
			'createddate' => '2001-01-27 02:35:23',
			'ranking'     => 123,
		);

		$oModel = new StoreDatabaseTester($aExpected);
		$this->oStore->update($oModel);
		
		$aActual = Jaded_Db::conn('testdb')->getRow('SELECT * FROM testtable WHERE tableid=?', array($this->aDefault['tableid']));
		$this->assertEquals($aExpected, $aActual);
	}
}
