<?php

namespace backboneit\cxf\transformation;

/**
 * An abstract base class for ease of transformator creation.
 * 
 * @author Oliver Hoff <oliver@hofff.com>
 */
abstract class AbstractTransformator extends \backboneit\util\SerializableConfiguration implements Transformator {
	
	/**
	 * Sets up the configuration for this instance.
	 * 
	 * @param array $arrConfig Initial configuration.
	 */
	protected function __construct(array $arrConfig = null) {
		parent::__construct($arrConfig);
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\cxf\validation\Transformator#transform($varValue)
	 */
	public function transform($varValue) {
		if(!$this->canHandle($varValue))
			throw new InvalidArgumentException(sprintf('Can not handle value: %s', $varValue), 1200);
		try {
			return $this->doTransformation($varValue);
		} catch(Exception $e) {
			throw new RuntimeException(sprintf('An error occured while validation of value: %s.', $varValue), 1201, $e);
		}
	}
	
	/**
	 * Checks if this transformator can handle the given value.
	 * 
	 * TODO: Should this pulled up to the Transformator interface?
	 * 
	 * @param mixed $varValue The value to be checked.
	 * 
	 * @return boolean If this transformator can handle the value true,
	 * 		otherwise false.
	 */
	public function canHandle($varValue) {
		return true;
	}
	
	/**
	 * Executes the transformation process on the given value.
	 * 
	 * @throws Exception Transformation failure for any reason.
	 * 
	 * @return mixed The transformation result.
	 */
	protected abstract function doTransformation($varValue);
	
}
