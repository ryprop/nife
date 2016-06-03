<?php

class Nife_HTTP_FancyRequestTest extends PHPUnit_Framework_TestCase
{
	public function testABigOne() {
		$req = new Nife_HTTP_FancyRequest('GET', '/', 'foo=bar&&');
		$this->assertEquals('GET', $req->getMethod());
		$this->assertEquals('/', $req->getPathInfo());
		$this->assertEquals('foo=bar&&', $req->getQueryString());
		$this->assertEquals(null, $req->getContent());
		$this->assertEquals(array('foo'=>'bar'), $req->getParameters());
	}
}
