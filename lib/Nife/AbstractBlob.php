<?php

/**
 * Basic implementation for a blob
 */
abstract class Nife_AbstractBlob implements Nife_Blob
{
	public function getLength() { return null; }
	public function __toString() { return Nife_Util::stringifyBlob($this); }
}
