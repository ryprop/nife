<?php

class {#projectNamespace}_Dispatcher
{
	protected $config;
	public function __construct( {#projectNamespace}_Config $config ) {
		$this->config = $config;
	}
	
	public function handleRequest( $path ) {
		// Some demonstration routes; remove and replace with your own
		if( $path == '/' ) {
			return Nife_Util::httpResponse( 200,
				"Welcome to {#projectName}!\n".
				"This code was generated from Nife's new project template.\n".
				"You probably want to change it.\n".
				"See also: /hello/".rawurlencode('{#projectName}')."\n"
			);
		} else if( preg_match('<^/hello/(.*)$>', $path, $matchData) ) {
			return Nife_Util::httpResponse( 200, "Hello, ".rawurldecode($matchData[1]).'!' );
		} else {
			return Nife_Util::httpResponse( 404, "I don't know about $path!" );
		}
	}
}
