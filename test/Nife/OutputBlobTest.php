<?php

class Nife_OutputBlobTest extends TOGoS_SimplerTest_TestCase
{
	public function echoSomeStuff() {
		echo "Some ";
		echo "stuff\n";
	}
	
	protected $blob;
	
	public function setUp() {
		$this->blob = new Nife_OutputBlob(array($this,'echoSomeStuff'));
	}
	
	public function testStringifyOutputBlob() {
		$this->assertEquals("Some stuff\n", (string)$this->blob);
	}

	public function testEchoOutputBlob() {
		ob_start();
		$this->blob->writeTo( Nife_Util::getEchoFunction() );
		$this->assertEquals("Some stuff\n", ob_get_clean());
	}
	
	public function testWriteOutputBlob() {
		$coll = new Nife_Collector();
		$this->blob->writeTo( $coll );
		$this->assertEquals( array("Some stuff\n"), $coll->getItems() );
	}
}
