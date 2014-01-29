<?php

/**
 * A queryable that knows how to build queries for itself
 */
class Nife_DBC_SQLQueryable extends Nife_DBC_Queryable
{
	/**
	 * @param string $q SQL statement with {curlyBraceEnclosed} parameter names
	 * @param array $params parameters to escape and substitute into $q
	 * @return Nife_DBC_Query
	 */
	public function prepare( $q, array $params=array() );
}
