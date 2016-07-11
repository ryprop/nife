<?php

/** 
 * A blob that's implemented in terms of
 * a callback function that just outputs everything
 * to php://output.
 * 
 * Uses ob_* functions to collect output data if necessary,
 * but is smart enough to let the wrapped function simply
 * output straight to php://output when writing to the
 * echo function returned by Nife_Util::getEchoFunction().
 */
class Nife_OutputBlob implements Nife_Blob
{
	/**
	 * A function that, when called (with no arguments), outputs itself to php://output
	 * (e.g. by using a lot of 'echo' statements or 'include'ing a file)
	 */
	protected $outputtable;
	public function __construct( $outputtable ) {
		$this->outputtable = $outputtable;
	}
	public function getLength() {
		// No way to know without evaluating the template
		return null;
	}
	public function __toString() {
		ob_start();
		try {
			call_user_func($this->outputtable);
		} catch( Exception $e ) {
			ob_end_clean();
			throw $e;
		}
		return ob_get_clean();
	}
	public function writeTo( $outputFunction ) {
		if( Nife_Util::isEchoFunction($outputFunction) ) {
			call_user_func($this->outputtable);
		} else {
			call_user_func($outputFunction, $this->__toString());
		}
	}
}
