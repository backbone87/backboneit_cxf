<?php

namespace backboneit\util;

/**
 * Classes implementing this interface have an output into an external
 * dataformat.
 * 
 * @author Oliver Hoff <oliver@hofff.com>
 */
interface Renderable {
	
	/**
	 * Renders the output for this object.
	 * 
	 * @return string The rendered output.
	 */
	public function render();
	
}
