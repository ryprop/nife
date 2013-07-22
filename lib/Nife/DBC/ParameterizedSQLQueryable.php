<?php

/**
 * An alternative to Nife_DBC_Queryable for cases where a
 * string+parameters is more convenient than a Query object.
 * Most adapters will probably implement both interfaces.
 */
interface Nife_DBC_ParameterizedSQLQueryable
{
	/**
	 * @param string $q SQL statement with {curlyBraceEnclosed} parameter names
	 * @param array $params parameters to escape and substitute into $q
	 * @return Nife_DBC_QueryResult
	 */
	public function psQuery( $q, array $params=array() );
}
