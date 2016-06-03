<?php

class Nife_Future_ConstantFuture
implements Nife_Future
{
	protected $value;
	
	/**
	 * @param mixed $value the value that get() will return.
	 */
	public function __construct( $value ) {
		$this->value = $value;
	}
	
	public function isReady() {
		return true;
	}
	
	public function get() {
		return $this->value;
	}
	
	public function __invoke() {
		return $this->get();
	}
}
