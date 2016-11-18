<?php

class Nife_CatBlobTest extends PHPUnit_Framework_TestCase
{
	protected $tempBuffer = array();
	public function appendToTempBuffer( $thing ) {
		$this->tempBuffer[] = $thing;
	}
	
	protected function assertTempBufferEquals( $what ) {
		$this->assertSame( $what, implode('', $this->tempBuffer) );
	}
	
	protected function assertBlobEquals( $str, $blob ) {
		$this->assertSame( $str, (string)$blob );
		$blob->writeTo( array($this,'appendToTempBuffer') );
		$this->assertTempBufferEquals( $str );
	}
	
	public function setUp() {
		$this->tempBuffer = array();
	}
	
	public function testEmptyCatBlob() {
		$emptyBlob = new Nife_CatBlob( array() );
		$this->assertSame( 0, $emptyBlob->getLength() );
		$this->assertBlobEquals( '', $emptyBlob );
	}
	
	public function testStringyCatBlob() {
		$stringyBlob = new Nife_CatBlob( array('foo', 'bar', 'baz') );
		$this->assertSame( 9, $stringyBlob->getLength() );
		$this->assertBlobEquals( 'foobarbaz', $stringyBlob );
	}

	public function testNestedCatBlob() {
		$stringyBlob = new Nife_CatBlob( array('foo', 'bar', 'baz') );
		$nestyBlob = new Nife_CatBlob( array('foo', $stringyBlob, 'baz') );
		$this->assertSame( 15, $nestyBlob->getLength() );
		$this->assertBlobEquals( 'foofoobarbazbaz', $nestyBlob );
	}
	
	protected function echoGarbageForever() {
		while( true ) echo "DONALD DRUMPF\n";
	}
	
	public function testInfiniteCatBlob() {
		$infiniBlob = new Nife_OutputBlob( array($this,'echoGarbageForever') );
		$infiniCat = new Nife_CatBlob( array('foo', 'bar', $infiniBlob, 'socks') );
		$this->assertNull( $infiniCat->getLength() );
	}
}
