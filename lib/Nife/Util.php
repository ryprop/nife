<?php

/*
 * Static utility functions to help with MVC thingies
 */
class Nife_Util
{
	public static function blob( $thing ) {
		if( $thing instanceof Nife_Blob ) {
			return $thing;
		} else if( is_scalar($thing) ) {
			return new Nife_StringBlob($thing);
		} else {
			throw new Exception("Don't know how to turn ".var_export($thing,true)." into a blob.");
		}
	}
	
	/**
	 * Return default status text for a status code.
	 * If you don't like these, pass status text explicitly.
	 */
	public static function statusCodeText( $statusCode ) {
		switch( $statusCode ) {
		case 200: return 'Feeling Groovy';
		case 204: return 'Feeling Empty';
		case 400: return 'You Messed Up';
		case 404: return 'Not Found';
		case 500: return 'I Messed Up';
			// etc
		default: return 'I know not what is happening, but good afternoon';
		}
	}
	
	/**
	 * Convenience method for creating an HTTP Response.
	 * @param $status status code or "<code> <text>" string
	 * @param $content string or Blob representing response content
	 * @param $typeOrHeaders string containing value of content-type header, or array of headers
	 */
	public static function httpResponse( $status, $content, $typeOrHeaders='text/plain; charset=utf-8' ) {
		if( is_int($status) ) {
			$statusCode = $status;
			$statusText = self::statusCodeText($statusCode); // 
		} else if( preg_match('/^(\d+)\s+(.+)$/', $status, $bif) ) {
			$statusCode = (int)$bif[1];
			$statusText = $bif[2];
		} else {
			throw new Exception("Status must be an integer or '<code> <text>' string; got ".var_export($status,true));
		}
		
		$content = self::blob($content);
		
		if( is_array($typeOrHeaders) ) {
			$headers = $typeOrHeaders;			
		} else if( is_string($typeOrHeaders) ) {
			$headers = array('content-type' => $typeOrHeaders);
		} else {
			throw new Exception("type/headers parameter must be a string or array");
		}
		
		return new Nife_HTTP_BasicResponse($statusCode, $statusText, $headers, $content);
	}
	
	public static function output( $thing ) {
		if( is_scalar($thing) ) {
			echo $thing;
		} else if( $thing instanceof Nife_Blob ) {
			$thing->writeTo( array('Nife_Util','output') );
		} else {
			throw new Exception("Don't know how to write ".var_export($thing,true)." to output.");
		}
	}
	
	public static function outputResponse( Nife_HTTP_Response $res ) {
		$statusLine = $res->getStatusCode()." ".$res->getStatusText();
		header( "HTTP/1.0 $statusLine" );
		header( "Status: $statusLine" );
		foreach( $res->getHeaders() as $k => $v ) {
			$lk = strtolower($k);
			if( $lk == 'content-length' ) continue;
			if( strpos($lk, 'transfer-') === 0 ) continue;
			header("$k: $v");
		}
		$content = $res->getContent();
		if( ($contentLength = $content->getLength()) !== null ) {
			header("Content-Length: $contentLength");
		}
		self::output($content);
	}
}
