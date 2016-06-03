<?php

/**
 * In addition to regular HTTP_Request stuff,
 * - gives access to PathInfo
 * - gives access to parameters
 * - allows cloning with altered properties using #with
 */
class Nife_HTTP_FancyRequest
implements Nife_HTTP_Request
{
	protected $method;
	protected $pathInfo;
	protected $pathPrefix;
	protected $uriPrefix;
	protected $contentFuture;
	protected $headersFuture;
	protected $parametersFuture;
	protected $queryString;
	protected $superGlobals;
	
	protected static function future($v) {
		if( $v === null ) return null;
		if( $v instanceof Nife_Future ) return $v;
		return new Nife_Futures_Constant($v);
	}
	
	public function __construct( $method, $pathInfo, $queryString, $contentFuture=null, $headersFuture=null ) {
		$this->method = $method;
		$this->pathInfo = $pathInfo;
		$this->queryString = $queryString;
		$this->contentFuture = self::future($contentFuture);
		$this->headersFuture = self::future($headersFuture);
	}

	public static function fromSuperGlobals($superGlobals) {
		$req = new Nife_HTTP_FancyRequest(
			$superGlobals['SERVER']['REQUEST_METHOD'],
			isset($superGlobals['SERVER']['PATH_INFO']) ? $superGlobals['SERVER']['PATH_INFO'] : '',
			isset($superGlobals['SERVER']['QUERY_STRING']) ? $superGlobals['SERVER']['QUERY_STRING'] : '',
			new Nife_Futures_Lazy(array('Nife_HTTP_FancyRequest','readRequestContent')),
			null
		);
		$req = $req->with('superGlobals', $superGlobals);
		return $req;
	}
	
	public static function fromEnvironment() {
		$superGlobals = array();
		foreach( $GLOBALS as $k=>$v ) {
			if( $k[0] == '_' and $k != '_SESSION' ) {
				$superGlobals[substr($k,1)] = $v;
			}
		}
		return self::fromSuperGlobals($superGlobals);
	}
	
	/** @override */
	public function getMethod() {
		return $this->method;
	}
	
	public function getPathInfo() {
		return $this->pathInfo;
	}
	
	/** @override */
	public function getUri() {
		return $this->uriPrefix . $this->pathPrefix . $this->pathInfo .
			(empty($this->queryString) ? '' : '?'.$this->queryString);
	}
	
	/** @override */
	public function getContent() {
		return $this->contentFuture === null ? null : $this->contentFuture->get();
	}
	
	public function getHeaders() {
		return $this->headersFuture === null ? array() : $this->headersFuture->get();
	}
	
	public function getQueryString() {
		return $this->queryString;
	}
	
	public function getParameters() {
		if( $this->parametersFuture !== null ) return $this->parametersFuture->get();
		
		$params = array();
		if( $this->queryString ) {
			foreach( explode('&',$this->queryString) as $qsPart ) {
				if( $qsPart === '' ) continue;
				$kv = explode('=', $qsPart, 2);
				if( count($kv) == 1 ) {
					$k = $v = $kv[0];
				} else {
					list($k,$v) = $kv;
				}
				$params[$k] = $v;
			}
		}
		return $params;
	}
	
	public function getSuperGlobals() {
		return $this->superGlobals;
	}
	
	public function getParam($k, $default=null) {
		$params = $this->getParameters();
		return isset($params[$k]) ? $params[$k] : $default;
	}
	
	protected function setContent( Nife_Blob $content=null ) {
		$content = Nife_Util::blob($content);
		$this->contentFuture = new Nife_Futures_Constant($content);
	}
	
	/** Don't call this unless you're #with */
	public function _screwMeUp( array $updates ) {
		foreach( $updates as $k => $v ) {
			$setterMethod = "set".ucfirst($k);
			if( method_exists($this,$setterMethod) ) {
				$this->$setterMethod($v);
			} else if( property_exists($this, $k) ) {
				$this->$k = $v;
			} else {
				throw new Exception("No such attribute as ".get_class($this).'#'.$k);
			}
		}
	}
	
	public function with( $k, $v=null ) {
		if( !is_array($k) ) {
			return $this->with( array($k=>$v) );
		}
		
		$updates = array();
		foreach( $k as $k1=>$v1 ) {
			if( $this->$k1 === $v1 ) continue;
			$updates[$k1] = $v1;
		}
		
		if( count($updates) == 0 ) return $this;
		
		$newMe = clone $this;
		$newMe->_screwMeUp( $updates );
		return $newMe;
	}
}
