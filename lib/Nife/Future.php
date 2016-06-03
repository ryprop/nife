<?php

/**
 * Accessor for a value that may not be available yet.
 */
interface Nife_Future
{
	/**
	 * Is the future's value available, yet?  i.e., can you guarantee
	 * that get() won't have to wait on anything if called right now?
	 */
	public function isReady();
	/**
	 * Wait for the future's value to become available and return it.
	 */
	public function get();
	
	// __invoke should be an alias for get()
	// __toString should not wait for or use the value
	// __destruct should cancel any work being done
}

if( function_exists('class_alias') ) class_alias('Nife_Future','Nife_Futures_Future',true);
