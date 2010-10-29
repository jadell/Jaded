<?php
class Jaded_Db_PdoTest extends PHPUnit_Extensions_Database_TestCase
{
	public static function setUpBeforeClass()
	{
		$oDb = new Jaded_Db_Pdo('mysql://jaded:jaded@localhost/jaded_test');
		Jaded_Db::set('testdb', $oDb);
	}

	public function testGetAll_NoneMatching_ReturnsEmptyArray()
	{
		$aExpected = array();
		$aActual = Jaded_Db::conn('testdb')->getAll('SELECT * FROM testtable WHERE tableid < 1');
		$this->assertEquals($aExpected, $aActual);
	}

	public function testGetRow_ExistingRows_ReturnsArrayOfRows()
	{
		$aExpected = array(
			array(
				'tableid'     => '3',
				'name'        => 'One More Name',
				'createddate' => '2003-08-21 18:42:31',
				'ranking'     => '91',
			),
			array(
				'tableid'     => '1',
				'name'        => 'First Name',
				'createddate' => '2010-10-29 13:56:52',
				'ranking'     => '1',
			),
		);
		$aActual = Jaded_Db::conn('testdb')->getAll('SELECT * FROM testtable WHERE ranking IS NOT NULL ORDER BY ranking DESC');
		$this->assertEquals($aExpected, $aActual);
	}

	public function testGetOne_NoneExisting_ReturnsNull()
	{
		$sExpected = null;
		$sActual = Jaded_Db::conn('testdb')->getOne('SELECT name FROM testtable WHERE tableid=-1');
		$this->assertEquals($sExpected, $sActual);
	}

	public function testGetOne_OneExisting_ReturnsValue()
	{
		$sExpected = 'Another Name';
		$sActual = Jaded_Db::conn('testdb')->getOne('SELECT name FROM testtable WHERE tableid=2');
		$this->assertEquals($sExpected, $sActual);
	}

	public function testGetOne_MultipleExisting_ReturnsFirstValue()
	{
		$sExpected = 'One More Name';
		$sActual = Jaded_Db::conn('testdb')->getOne('SELECT name, tableid FROM testtable ORDER BY ranking DESC');
		$this->assertEquals($sExpected, $sActual);
	}

	public function testGetRow_NonExistingRow_ReturnsEmptyArray()
	{
		$aExpected = array();
		$aActual = Jaded_Db::conn('testdb')->getRow('SELECT * FROM testtable WHERE tableid=-1');
		$this->assertEquals($aExpected, $aActual);
	}

	public function testGetRow_ExistingRow_ReturnsArray()
	{
		$aExpected = array(
			'tableid'     => '1',
			'name'        => 'First Name',
			'createddate' => '2010-10-29 13:56:52',
			'ranking'     => '1',
		);
		$aActual = Jaded_Db::conn('testdb')->getRow('SELECT * FROM testtable WHERE tableid=1');
		$this->assertEquals($aExpected, $aActual);
	}

	public function testGetRow_MultipleRowsMatch_ReturnsArrayOfFirstRow()
	{
		$aExpected = array(
			'tableid'     => '3',
			'name'        => 'One More Name',
			'createddate' => '2003-08-21 18:42:31',
			'ranking'     => '91',
		);
		$aActual = Jaded_Db::conn('testdb')->getRow('SELECT * FROM testtable ORDER BY ranking DESC');
		$this->assertEquals($aExpected, $aActual);
	}

	public function testExecute_DataUpdatedCorrectly()
	{
		$iExpected = 1;
		$sSql = "UPDATE testtable SET name=?, ranking=? WHERE tableid=?";
		$iActual = Jaded_Db::conn('testdb')->execute($sSql, array('foo', 45, 2));
		$this->assertEquals($iExpected, $iActual);

		$aExpected = array(
			'tableid'     => '2',
			'name'        => 'foo',
			'createddate' => '1992-02-12 04:14:42',
			'ranking'     => '45',
		);
		$aActual = Jaded_Db::conn('testdb')->getRow('SELECT * FROM testtable WHERE tableid=?', array(2));
		$this->assertEquals($aExpected, $aActual);
	}

	public function testGetLastInsertId_ReturnsCorrectId()
	{
		$sSql = "INSERT INTO testtable (name, createddate, ranking) VALUE (?,?,?)";
		Jaded_Db::conn('testdb')->execute($sSql, array('foo', '2001-21-12 00:12:21', 56));
		
		$iExpected = 4;
		$iActual = Jaded_Db::conn('testdb')->getLastInsertId();
		$this->assertEquals($iExpected, $iActual);
	}

	protected function getConnection()
	{
		try {
			$pdo = new PDO('mysql:host=localhost;dbname=jaded_test', 'jaded', 'jaded');
			return $this->createDefaultDBConnection($pdo, 'testdb');
		} catch (Exception $e) {
			$this->markTestSkipped("Could not connect to test database.");
		}
	}

	protected function getDataSet()
	{
		return $this->createXMLDataSet('tests/fixtures/testdata.xml');
	}
}
?>