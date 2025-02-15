<?php

class Nife_Util_TimeoutResetter {
	protected $timeout;
	protected $logger;
	public function __construct(array $options = array()) {
		$this->timeout = isset($options['timeout']) ? $options['timeout'] : 10;
		$this->logger = isset($options['logger']) ? $options['logger'] : null;
	}
	public function __invoke($_whatever) {
		set_time_limit($this->timeout);
		if( isset($this->logger) ) {
			call_user_func($this->logger, "Resetting timeout by {$this->timeout} seconds.");
		}
	}
}
