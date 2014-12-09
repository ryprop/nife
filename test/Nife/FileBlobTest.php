<?php

class Nife_FileBlobTest extends PHPUnit_Framework_TestCase
{
	public function testFileBlob() {
		$file = 'README.md';
		if( !file_exists($file) ) {
			$this->markTestSkipped("No README.md to test with.");
			return;
		}
		
		$fb = new Nife_FileBlob($file);
		$expectedSize = filesize($file);
		$expectedContent = file_get_contents($file);
		
		$this->assertEquals($expectedContent, (string)$fb);
		$this->assertEquals($expectedSize, $fb->getLength());
	}
}
