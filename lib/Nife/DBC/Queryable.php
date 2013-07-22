<?php

/**
 * An alternative to Nife_DBC_ParameterizedSQLQueryable for cases
 * where a query object is more convenient than string+parameters
 * or where the query cannot be represented that way.
 * Most adapters will probably implement both interfaces.
 */
interface Nife_DBC_Queryable
{
	/**
	 * @param Nife_DBC_Query $q
	 * @return Nife_DBC_QueryResult
	 */
	public function query( Nife_DBC_Query $q );
}
