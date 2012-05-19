<?php

namespace backboneit\cxf\validation;

/**
 * A value passes this validators validation, if its string representation has
 * at least CONFIG_MIN_LENGTH characters and at most CONFIG_MAX_LENGTH
 * characters.
 * 
 * The value is converted to a string via strval function and the length is
 * determined according to the UTF-8 encoding.
 * Arrays are not converted to strings. Instead the length of each array element
 * is summed up. Nested arrays are handled recursively.
 * 
 * TODO: Determine length according to Contao system settings encoding.
 * 
 * @author Oliver Hoff <oliver@hofff.com>
 */
class LengthValidator extends AbstractValidator {
	
	/**
	 * @var string Name of configuration variable, that sets the minimum length
	 * 		the value is allowed to have to pass the validation. Defaults to 0.
	 */
	const CONFIG_MIN_LENGTH = 'minLength';
	
	/**
	 * @var string Name of configuration variable, that sets the maximum length
	 * 		the value is allowed to have to pass the validation. Defaults to
	 * 		PHP_INT_MAX.
	 */
	const CONFIG_MAX_LENGTH = 'maxLength';
	
	
	
	/**
	 * Sets up the configuration for this instance.
	 * 
	 * @param array $arrConfig Initial configuration.
	 */
	protected function __construct(array $arrConfig = null) {
		parent::__construct($arrConfig);
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\cxf\validation\AbstractValidator#canHandle($varValue)
	 */
	public function canHandle($varValue) {
		try {
			array_walk_recursive((array) $varValue, function() {
				if(!is_string(strval($varValue)))
					throw new Exception('FATALEST ERROR!!!');
			});
			return true;
			
		} catch(Exception $e) {
			return false;
		}
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\cxf\validation\AbstractValidator#doValidation($varValue)
	 */
	protected function doValidation($varValue) {
		$intLength = 0;
		array_walk_recursive((array) $varValue, function($varValue) use($intLength) {
			$intLength += utf8_strlen(strval($varValue));
		});
		
		$intMin = max(0, intval($this->arrConfig[self::CONFIG_MIN_LENGTH]));
		$intMax = isset($this->arrConfig[self::CONFIG_MAX_LENGTH])
			? max(1, $intMin, intval($this->arrConfig[self::CONFIG_MAX_LENGTH]))
			: PHP_INT_MAX;
		
		return $intLength >= $intMin && $intLength <= $intMax;
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\cxf\validation\AbstractValidator#generateMessage($strMessage)
	 */
	protected function generateMessage($strMessage) {
		return sprintf($strMessage,
			$this->arrConfig[self::CONFIG_MIN_LENGTH],
			$this->arrConfig[self::CONFIG_MAX_LENGTH]
		);
	}
	
}
