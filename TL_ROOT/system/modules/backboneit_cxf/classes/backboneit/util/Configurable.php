<?php

namespace \backboneit\util;

/**
 * A class implementing this interface is configurable with a configuration
 * array.
 * 
 * @author Oliver Hoff <oliver@hofff.com>
 */
interface Configurable {
	
	/**
	 * Resets this objects configuration.
	 */
	public function resetConfig();
	
	/**
	 * Set a configuration for this object.
	 * 
	 * @param array $arrConfig The configuration array.
	 */
	public function setConfig(array $arrConfig);
	
	/**
	 * Get the current object configuration.
	 * 
	 * @return array The configuration array.
	 */
	public function getConfig();
	
}
