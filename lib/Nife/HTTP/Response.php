<?php

interface Nife_HTTP_Response
{
	/**
	 * @return int status code, e.g. 404
	 */
	public function getStatusCode();
	/**
	 * @return int status text, e.g. 'Not Found'
	 */
	public function getStatusText();
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
