<?php

/**
 * Represents a sequence of bytes
 */
interface Nife_Blob
{
	/**
	 * Return the number of bytes in this blob, or null if the length is unknown or infinite.
	 */
	public function getLength();
	/**
	 * @param callable $callback will be passed the contents of this
	 *   blob, possibly in multiple chunks.  The total number of bytes
	 *   passed to the callback must = the value returned by
	 *   getLength(), if non-null.
	 *   When writeTo returns, all getLength() bytes should have been
	 *   written to $callback.
	 */
	public function writeTo( $callback );
	// __toString should return the blob's content as a string
}
