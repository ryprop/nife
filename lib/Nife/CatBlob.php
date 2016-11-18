<?php

/**
 * A blob defined as the concatenation of a bunch of other blobs (or strings)
 */
class Nife_CatBlob implements Nife_Blob
{
	protected $items;
	/*
	 * @param $items an iterable (array, IteratorAggregate, etc) of components,
	 *   which can be themselves be blobs or anything stringifyable
	 */
	public function __construct( $items ) {
		$this->items = $items;
	}
	
	protected static function itemLength($item) {
		if( $item instanceof Nife_Blob ) return $item->getLength();
		if( is_string($item) ) return strlen($item);
		return null;
	}

	public function getLength() {
		$len = 0;
		foreach( $this->items as $item ) {
			$itemLength = self::itemLength($item);
			if( $itemLength === null ) return null;
			$len += $itemLength;
		}
		return $len;
	}	
	
	public function writeTo( $callback ) {
		foreach( $this->items as $item ) {
			if( $item instanceof Nife_Blob ) $item->writeTo($callback);
			else call_user_func( $callback, (string)$item );
		}
	}
	
	public function __toString() {
		$parts = array();
		foreach( $this->items as $item ) {
			$parts[] = (string)$item;
		}
		return implode('', $parts);
	}
}
