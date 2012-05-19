<?php

namespace backboneit\cxf\validation;

/**
 * A validator wraping an oldstyle Contao callback, which is used as
 * #doValidation($varValue) substitute. The callback is an array consisting of
 * a class name at index 0 and a method name at index 1. To invoke the callback
 * the System#import($strClass) method is emulated and the method is called on
 * the imported instance.
 * 
 * The callback gets passed the value and this validator instance to access
 * validator configuration and setup possible messages. 
 * 
 * This is a legacy class. It should not be used for new projects!
 * 
 * @author Oliver Hoff <oliver@hofff.com>
 */
class LegacyContaoCallbackDelegateValidator extends CallbackDelegateValidator {
	
	/**
	 * @var object The imported callback instance.
	 * @transient
	 */
	protected $objInstance;
	
	/**
	 * Sets up the configuration for this instance.
	 * 
	 * @param array $arrConfig Initial configuration.
	 */
	protected function __construct(array $arrConfig = null) {
		parent::__construct($arrConfig);
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\cxf\validation\AbstractValidator#doValidation($varValue)
	 */
	protected function doValidation($varValue) {
		$this->import();
		return call_user_func(
			array($this->objInstance, $this->arrConfig[self::CONFIG_CALLBACK][1]),
			$varValue,
			$this
		);
	}
	
	/**
	 * Imports the callback instance in old Contao System#import($strClass)
	 * style.
	 */
	protected function import() {
		if(isset($this->objInstance))
			return;
		
		$strClass = $this->arrConfig[self::CONFIG_CALLBACK][0];
		if(method_exists($strClass, 'getInstance')) { //in_array('getInstance', get_class_methods($strClass))) {
			$this->objInstance = call_user_func(array($strClass, 'getInstance'));
		} else {
			$this->objInstance = new $strClass();
		}
	}
	
}
