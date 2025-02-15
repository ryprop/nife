<?php

class Nife_HTTP_BasicResponse implements Nife_HTTP_Response
{
	protected $statusCode;
	protected $statusText;
	protected $headers;
	protected $content;
	public function __construct( $statusCode, $statusText, array $headers, Nife_Blob $content=null ) {
		$this->statusCode = (int)$statusCode;
		$this->statusText = (string)$statusText;
		$this->headers = $headers;
		$this->content = $content;
	}
	
	public function getStatusCode() {  return $this->statusCode;  }
	public function getStatusText() {  return $this->statusText;  }
	public function getHeaders() {  return $this->headers;  }
	public function getContent() {  return $this->content;  }
}
