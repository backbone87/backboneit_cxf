<?php

namespace backboneit\cxf\validation;

/**
 * A validator wraping a PHP callback, which is used as doValidation substitute.
 * The callback gets passed the value and this validator instance to access
 * validator configuration and setup possible messages. 
 * 
 * The passed callback must be serializable, which is always true for function
 * names and static method calls and has to be ensured by the programmer for
 * method calls on object instances and closures. Closures are not serializable
 * as of PHP 5.3.
 * 
 * @author Oliver Hoff <oliver@hofff.com>
 */
class CallbackDelegateValidator extends AbstractValidator {
	
	/**
	 * @var string Name of configuration variable, that sets the callback to use
	 * 		for delegation of validation work.
	 */
	const CONFIG_CALLBACK = 'callback';
	
	
	
	/**
	 * Sets up the configuration for this instance.
	 * 
	 * @param array $arrConfig Initial configuration.
	 */
	public function __construct(array $arrConfig = null) {
		parent::__construct($arrConfig);
	}
	
	/**
	 * Sets the validation message. See base class and interface for more
	 * information on validation messages.
	 * 
	 * @param string $strMessage The message to be set.
	 */
	public function setMessage($strMessage) {
		$this->strMessage = (string) $strMessage;
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\cxf\validation\AbstractValidator#doValidation($varValue)
	 */
	protected function doValidation($varValue) {
		return call_user_func($this->arrConfig[self::CONFIG_CALLBACK], $varValue, $this);
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\cxf\validation\AbstractValidator#compileMessage($strMessage)
	 */
	protected function compileMessage($strMessage) {
		return $this->strMessage;
	}
	
}
