<?php

class Nife_StringBlob implements Nife_Blob
{
	public function __construct( $data ) {
		$this->data = (string)$data;
	}
	
	public function getLength() {
		return strlen($this->data);
	}
	
	public function writeTo( $callback ) {
		call_user_func($callback, $this->data);
	}
	
	public function __toString() {
		return $this->data;
	}
}
