<?php

class Nife_UtilTest extends TOGoS_SimplerTest_TestCase
{
	public function testFooBarBazBlob() {
		$blob = new Nife_FooBarBazBlob();
		$blobString = (string)$blob;
		$this->assertEquals( "FooBarBaz", $blobString );
		$this->assertEquals( strlen($blobString), $blob->getLength() );
	}
	
	public function testEchoOutputFunction() {
		$collector = new Nife_Collector();
		$echoer = Nife_Util::getEchoFunction();
		
		$blob = new Nife_FooBarBazBlob();
		
		$this->assertTrue( Nife_Util::isEchoFunction($echoer) );
		$this->assertFalse( Nife_Util::isEchoFunction($collector) );
		
		$blob->writeTo($collector);
		$this->assertEquals( "FooBarBaz", (string)$collector );
		
		ob_start();
		$blob->writeTo( $echoer );
		$echoed = ob_get_contents();
		ob_end_clean();
		$this->assertEquals( "FooBarBaz", $echoed );
	}

	public function testTimeoutResettingOutput() {
		$log = new Nife_Collector();
		$output = new Nife_Collector();
		$tro = new Nife_Util_TeeOutputter(array(
			new Nife_Util_TimeoutResetter(array('timeout'=>10, 'logger'=>$log)),
			$output
		));
		call_user_func($tro, "Hello");
		call_user_func($tro, "World");
		$this->assertEquals("HelloWorld", (string)$output);
		$this->assertEquals("Resetting timeout by 10 seconds.Resetting timeout by 10 seconds.", (string)$log);
	}
}
