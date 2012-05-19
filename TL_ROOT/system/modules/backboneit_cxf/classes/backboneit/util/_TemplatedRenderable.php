<?php

namespace backboneit\util;

/**
 * TODO: Doc
 * TODO: Makes this interface any sense? It should not be used on top level
 * instances like Form or Widget. If it would be used at this level, it could be
 * merged with Renderable and cripling therefore the flexibility of renderable.
 * Also should this return a template instance or the template file?
 * 
 * @author Oliver Hoff <oliver@hofff.com>
 */
interface TemplatedRenderable extends Renderable {

	public function getTemplate();
	
}
