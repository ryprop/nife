<?php

/**
 * A future that generates its value when needed by calling a
 * function.
 */
class Nife_Future_LazyFuture
implements Nife_Future
{
	protected $generator;
	protected $isGenerated = false;
	protected $value = null;
	
	/**
	 * @param callable $generator a zero-argument function that will return our future's value
	 */
	public function __construct( $generator ) {
		$this->generator = $generator;
	}
	
	public function isReady() {
		return $this->isGenerated;
	}
	
	public function get() {
		if( !$this->isGenerated ) {
			$this->value = call_user_func($this->generator);
			$this->isGenerated = true;
		}
		return $this->value;
	}
	
	public function __invoke() {
		return $this->get();
	}
}
