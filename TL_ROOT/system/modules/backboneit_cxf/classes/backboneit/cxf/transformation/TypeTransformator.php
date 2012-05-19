<?php

namespace backboneit\cxf\transformation;

/**
 * Transforms a PHP value into a specific PHP type.
 * 
 * @author Oliver Hoff <oliver@hofff.com>
 */
class TypeTransformator extends AbstractTransformator {
	
	/**
	 * @var string Name of configuration variable, that sets target type the
	 * 		transformed values should have.
	 */
	const CONFIG_TARGET_TYPE = 'targetType';
	
	

	/**
	 * Sets up the configuration for this instance.
	 * 
	 * @param array $arrConfig Initial configuration.
	 */
	public function __construct(array $arrConfig = null) {
		parent::__construct($arrConfig);
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\cxf\transformation\AbstractTransformator#doTransformation($varValue)
	 */
	protected function doTransformation($varValue) {
		switch($this->arrConfig[self::CONFIG_TARGET_TYPE]) {
			case 's':
			case 'string':
				return strval($varValue);
				
			case 'i':
			case 'integer':
				return intval($varValue);
				
			case 'f':
			case 'fp':
			case 'float':
			case 'double':
				return floatval($varValue);
				
			case 'b':
			case 'bool':
			case 'boolean':
				return !!$varValue;
				
			case 'null':
				return null;
				
			case 'a':
			case 'array':
				return is_array($varValue) ? $varValue : (array) $varValue;
				
			default: // TODO: Should this be thrown at setConfig?
					// Or should it simple return the value itself?
				throw new InvalidArgumentException(sprintf('Unknown target type: %s', $this->arrConfig[self::CONFIG_TARGET_TYPE]), 1300);
		}
	}
	
}
