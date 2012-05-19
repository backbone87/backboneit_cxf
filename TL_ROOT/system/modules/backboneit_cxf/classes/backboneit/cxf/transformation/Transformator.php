<?php

namespace backboneit\cxf\transformation;

/**
 * A transformator applies a transformation to a PHP value. The following
 * assumption should be true for all implementations:
 * 
 * - Transforming identical (===) values should give the same result. That means
 * a transformator is not allowed to have an internal state influencing the
 * transformation result. Though an internal state is allowed to optimize or
 * support the transformation, for example cache results for complex
 * transformations.
 * 
 * - Transforming a value and applying the same transformation again to the
 * first transformations result, the second result should be identical (===) to
 * the first transformation result.
 * 
 * 
 * @author Oliver Hoff <oliver@hofff.com>
 */
interface Transformator extends \Serializable {
	
	/**
	 * Applies the transformation to the given value and returns the resulting
	 * value.
	 * 
	 * @throws InvalidArgumentException If the type of passed value can not be
	 * 		handled by this transformator.
	 * @throws RuntimeException If the passed value could not be transformed by
	 * 		this transformator for any reason.
	 * 
	 * @param mixed $varValue The value to be transformed.
	 * 
	 * @return mixed The transformation result.
	 */
	public function transform($varValue);
	
}
