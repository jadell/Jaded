<?php
@include_once('vfsStream/vfsStream.php');

class Jaded_Autoloader_Finder_PearTest extends PHPUnit_Framework_TestCase
{
	protected $oFinder = null;

	public function setUp()
	{
		if (!class_exists('vfsStream', false)) {
			$this->markTestSkipped('vfsStream not installed.');
		}
		vfsStream::setup('lib/path/Some/Class');
		vfsStreamWrapper::getRoot()->getChild('path/Some/Class')->addChild(vfsStream::newFile('Concrete.php'));

		$this->oFinder = new Jaded_Autoloader_Finder_Pear(vfsStream::url('lib/path'));
	}

	public function testFind_NoFileFoundInPath_ReturnsNull()
	{
		$this->assertNull($this->oFinder->find("Some_Class_Fake"));
	}

	public function testFind_FileFoundInPath_ReturnsFilePath()
	{
		$sFilePath = $this->oFinder->find("Some_Class_Concrete");
		$this->assertEquals(vfsStream::url('lib/path/Some/Class/Concrete.php'), $sFilePath);
	}
}
?>