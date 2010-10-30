<?php
class Jaded_ConfigTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		Jaded_Config::save();
	}

	public function tearDown()
	{
		Jaded_Config::restore();
	}

	public function testSetAndRetrieve_ReturnsSetValue()
	{
		$sKey = "test.key";
		$sValue = "testvalue";

		Jaded_Config::set($sKey, $sValue);
		$this->assertEquals($sValue, Jaded_Config::get($sKey));
	}

	public function testRetrieve_ValueNotSet_ReturnsNull()
	{
		$sKey = "test.key";
		$this->assertNull(Jaded_Config::get($sKey));
	}

	public function testRetrieve_GivenDefault_ReturnsDefault()
	{
		$sKey = "test.key";
		$sDefault = "mydefault";
		$this->assertEquals($sDefault, Jaded_Config::get($sKey, $sDefault));
	}

	public function testSaveAndRestore()
	{
		$sKey = "test.key";
		$sOriginal = "original";
		$sNew = "new hawtness";

		Jaded_Config::set($sKey, $sOriginal);
		Jaded_Config::save();
		$this->assertEquals($sOriginal, Jaded_Config::get($sKey));

		Jaded_Config::set($sKey, $sNew);
		$this->assertEquals($sNew, Jaded_Config::get($sKey));

		Jaded_Config::restore();
		$this->assertEquals($sOriginal, Jaded_Config::get($sKey));
	}

	public function testLoadFromFile_ConfigValuesLoadedFromGivenFile()
	{
		$sConfigFile = "tests/fixtures/test.conf";
		Jaded_Config::loadFile($sConfigFile);

		$this->assertEquals("somevalue", Jaded_Config::get("test.key1"));
		$this->assertEquals("yavalue", Jaded_Config::get("test.anotherkey"));
		$this->assertEquals("123", Jaded_Config::get("anothersection.somevalue"));
	}

	public function testLoadFromFile_BlankCOnfig_ConfigValueLoadedIntoEmptyConfig()
	{
		$sKey = "test.key_not_in_files";
		$sValue = "value not in file";
		Jaded_Config::set($sKey, $sValue);

		$sConfigFile = "tests/fixtures/test.conf";
		Jaded_Config::loadFile($sConfigFile, true);
		$this->assertEquals("somevalue", Jaded_Config::get("test.key1"));
		$this->assertEquals("yavalue", Jaded_Config::get("test.anotherkey"));
		$this->assertEquals("123", Jaded_Config::get("anothersection.somevalue"));
	
		$this->assertNull(Jaded_Config::get($sKey));
		Jaded_Config::restore();
		$this->assertEquals($sValue, Jaded_Config::get($sKey));
	}
}
?>
