<?php

/**
 * Represents results of a query.  This object may discard results
 * after they have been read.  Methods should be called in a specific
 * order in order to ensure that the needed data has not been
 * discarded.  If a discarded piece of data is requested, an exception
 * must be thrown.
 *
 * The proper order of usage is:
 * - getAffectedRowCount / getLastInsertId
 * - getRows or iterate over the QueryResult itself
 * - hasMoreResults
 * - nextResult
 */
interface Nife_DBC_QueryResult implements Iterator
{
	/**
	 * @return int for queries that modifiy the DB, the number of affected rows,
	 *   0 for pure selects, and null if unknown.
	 */
	public function getAffectedRowCount();
	
	/**
	 * If new records with auto-incremented IDs were added, this should return
	 * the latest such ID.  Null should be returned otherwise.
	 */
	public function getLastInsertId();
	
	/**
	 * @returns array an array of associative arrays, one per result row;
	 *   should return an empty array if the query returned no rows.
	 */
	public function getRows(); 
	
	/**
	 * Return true if there is another result set after this one
	 * (which can be gotten with nextResult()
	 */
	public function hasMoreResults();
	
	/**
	 * For queries that return multiple result sets, this should return
	 * the next one.  It should return null if this is the last result
	 * set.
	 */
	public function nextResult();
	
	// __destruct should release any resources still held, e.g. buffered rows
}
