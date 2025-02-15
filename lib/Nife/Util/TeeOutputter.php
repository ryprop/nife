<?php

class Nife_Util_TeeOutputter
{
	protected $outputs;
	/**
	 * @param $outputs foreachable collection of outputters (string ->{*} void)
	 */
	public function __construct($outputs) {
		foreach( $outputs as $output ) {
			if( !is_callable($output) ) throw new Exception("TeeOutputter: " . (string)$output . " not callable");
		}
		$this->outputs = $outputs;
	}
	
	/** @api */
	public function __invoke( $thing ) {
		if( $thing instanceof Nife_Blob ) {
			$thing->writeTo( $this );
		} else {
			foreach( $this->outputs as $out ) {
				call_user_func($out, $thing);
			}
		}
	}
}
