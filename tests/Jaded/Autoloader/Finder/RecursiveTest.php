<?php
@include_once('vfsStream/vfsStream.php');

class Jaded_Autoloader_Finder_RecursiveTest extends PHPUnit_Framework_TestCase
{
	protected $oFinder = null;

	public function setUp()
	{
		if (!class_exists('vfsStream', false)) {
			$this->markTestSkipped('vfsStream not installed.');
		}
		vfsStream::setup('lib/path');
		vfsStreamWrapper::getRoot()->getChild('path')->addChild(vfsStream::newDirectory('dir1'));
		vfsStreamWrapper::getRoot()->getChild('path')->addChild(vfsStream::newDirectory('dir2'));
		vfsStreamWrapper::getRoot()->getChild('path/dir1')->addChild(vfsStream::newDirectory('1A'));
		vfsStreamWrapper::getRoot()->getChild('path/dir2')->addChild(vfsStream::newDirectory('2A'));
		vfsStreamWrapper::getRoot()->getChild('path/dir2')->addChild(vfsStream::newDirectory('2B'));
		vfsStreamWrapper::getRoot()->getChild('path/dir2/2B')->addChild(vfsStream::newFile('ConcreteClass.php'));

		$this->oFinder = new Jaded_Autoloader_Finder_Recursive(vfsStream::url('lib/path'));
	}

	public function testFind_NoFileFoundInPath_ReturnsNull()
	{
		$this->assertNull($this->oFinder->find("FakeClass"));
	}

	public function testFind_FileFoundInPath_ReturnsFilePath()
	{
		$sFilePath = $this->oFinder->find("ConcreteClass");
		$this->assertEquals(vfsStream::url('lib/path/dir2/2B/ConcreteClass.php'), $sFilePath);
	}
}
