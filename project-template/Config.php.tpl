<?php

class {#projectNamespace}_Config
{
	protected $settings;
	protected $components;
	
	public function __construct( array $settings ) {
		$this->settings = $settings;
		$this->components = array();
	}
	
	public function getComponent( $name ) {
		if( !isset($this->components[$name]) ) {
			$componentClassName = "{#projectNamespace}_{$name}";
			$this->components[$name] = new $componentClassName($this);
		}
		return $this->components[$name];
	}
}
