<?php

class Nife_Future_FiftySevenFuture implements Nife_Futures_Future
{
	public function isReady() { return true; }
	public function get() { return 57; }
}

class Nife_Future_OldFutureTest extends TOGoS_SimplerTest_TestCase
{
	public function testInstanceOf() {
		$x = new Nife_Future_ConstantFuture(38);
		$this->assertTrue( $x instanceof Nife_Futures_Future );
		$this->assertTrue( $x instanceof Nife_Future ); // Same thing!
		$this->assertEquals( 38, $x->get() ); // As long as we're here
	}
	
	public function testInstanceOf57() {
		$x = new Nife_Future_FiftySevenFuture();
		$this->assertTrue( $x instanceof Nife_Futures_Future );
		$this->assertTrue( $x instanceof Nife_Future ); // Same thing!
		$this->assertEquals( 57, $x->get() ); // As long as we're here
	}
}
