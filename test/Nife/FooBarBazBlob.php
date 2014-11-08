<?php

class Nife_FooBarBazBlob extends Nife_AbstractBlob
{
	public function getLength() {
		return 9;
	}
	
	public function writeTo( $callback ) {
		call_user_func( $callback, 'Foo' );
		call_user_func( $callback, 'Bar' );
		call_user_func( $callback, 'Baz' );
	}
}
