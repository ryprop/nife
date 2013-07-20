<?php

/**
 * Represents an HTTP request, as seen by the request handler
 */
interface Nife_HTTP_Request
{
	/**
	 * @return string name of method being requested, e.g. 'GET' or 'POST'
	 */
	public function getMethod();
	/**
	 * @return string full URI of the resource being requested.
	 */
	public function getUri();
	/**
	 * @return array of header name => value.
	 * Headers with multiple values should be represented by joining the values with a ", ".
	 * Header names should be normalized to lower-case.
	 * Headers implying transport information (transfer-encoding, content-length, etc) should be omitted.
	 */
	public function getHeaders();
	/**
	 * @return Nife_Blob
	 **/
	public function getContent();
}
