<?php

/**
 * Represents a value that may not be available yet.
 */
interface Nife_Futures_Future
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
	
	// __toString should not wait for or use the value
	// __destruct should cancel any work being done
}
