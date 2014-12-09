<?php

class Nife_FileBlob implements Nife_Blob
{
	protected $file;
	public function __construct( $file ) {
		$this->file = $file;
	}
	
	public function __toString() {
		return file_get_contents($this->file);
	}
	
	public function getLength() {
		return filesize($this->file);
	}
	
	public function writeTo( $callback ) {
		$fh = fopen($this->file,'rb');
		if( $fh === false ) {
			throw new Exception("Failed to open {$this->file} for reading");
		}
		while( $data = fread($fh, 65536) ) {
			call_user_func($callback, $data);
		}
		fclose($fh);
	}
	
	public function getFile() {
		return $this->file;
	}
}
