<?php

class Nife_Future_LazyFutureTest extends PHPUnit_Framework_TestCase
{
	protected $generateCalled = 0;
	public function generateSomething() {
		$this->generateCalled += 1;
		return 100;
	}
	
	public function testIt() {
		$this->generateCalled = false;
		
		$future = new Nife_Future_LazyFuture(array($this,'generateSomething'));
		$this->assertEquals( 0, $this->generateCalled );
		$this->assertEquals( false, $future->isReady() );
		
		$this->assertEquals( 100, $future->get() );
		$this->assertEquals( 1, $this->generateCalled );
		$this->assertEquals( true, $future->isReady() );
		
		$this->assertEquals( 100, $future->get() );
		$this->assertEquals( 1, $this->generateCalled );
		$this->assertEquals( true, $future->isReady() );
	}
}
