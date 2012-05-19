<?php

namespace backboneit\cxf\validation;

/**
 * An abstract base class for ease of validator creation.
 * 
 * @author Oliver Hoff <oliver@hofff.com>
 */
abstract class AbstractValidator extends \backboneit\util\SerializableConfiguration implements Validator {
	
	/**
	 * @var string Name of configuration variable, that sets validation level,
	 * 		which determines how critical a not passed validation is.
	 */
	const CONFIG_VALIDATION_LEVEL = 'validationLevel';
	
	/**
	 * TODO: Comments required: Is there only one possible message per validator?
	 * 
	 * @var string Name of configuration variable, that contains the message to
	 * 		return, if the validation did not pass. Depending on the concrete
	 * 		implementation sprintf placeholders can be used within the message.
	 */
	const CONFIG_MESSAGE = 'message';
	
	
	
	/**
	 * @var boolean The result of the last validation, if any.
	 * @transient
	 */
	private $blnValid;
	
	/**
	 * @var string The message associated with the last validation, if any.
	 * @transient
	 */
	protected $strMessage;
	
	/**
	 * Sets up the configuration for this instance.
	 * 
	 * @param array $arrConfig Initial configuration.
	 */
	protected function __construct(array $arrConfig = null) {
		parent::__construct($arrConfig);
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\cxf\validation\Validator#validate($varValue)
	 */
	public function validate($varValue) {
		$this->reset();
		if(!$this->canHandle($varValue))
			throw new InvalidArgumentException(sprintf('Can not handle value: %s', $varValue), 1000);
		try {
			if($this->doValidation($varValue)) {
				$this->blnValid = true;
			} else {
				$this->blnValid = false;
				$this->strMessage = $this->compileMessage(strval($this->arrConfig[self::CONFIG_MESSAGE]));
			}
		} catch(Exception $e) {
			throw new RuntimeException(sprintf('An error occured while validation of value: %s.', $varValue), 1001, $e);
		}
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\cxf\validation\Validator#isValid()
	 */
	public function isValid() {
		if(isset($this->blnValid)) {
			return $this->blnValid;
		} else {
			throw new LogicException('No internal state.', 1002);
		}
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\cxf\validation\Validator#getMessage()
	 */
	public function getMessage() {
		if($this->isValid()) {
			return null;
		} else {
			return new ValidationMessage($this->strMessage, $this->getValidationLevel());
		}
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\cxf\validation\Validator#getValidationLevel()
	 */
	public function getValidationLevel() {
		return $this->arrConfig[self::CONFIG_VALIDATION_LEVEL];
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\cxf\validation\Validator#reset()
	 */
	public function reset() {
		unset($this->blnValid, $this->strError);
	}
	
	/**
	 * Checks if this validator can handle the given value.
	 * 
	 * TODO: Should this pulled up to the Validator interface?
	 * 
	 * @param mixed $varValue The value to be checked.
	 * 
	 * @return boolean If this validator can handle the value true, otherwise
	 * 		false.
	 */
	public function canHandle($varValue) {
		return true;
	}
	
	/**
	 * Executes the validation process on the given value.
	 * 
	 * @throws Exception Validation failure for any reason.
	 * 
	 * @return boolean If the passed value is valid true, otherwise false.
	 */
	protected abstract function doValidation($varValue);
	
	/**
	 * Generates the message to be displayed, if the last checked value did not
	 * pass the validation.
	 * 
	 * This implementation returns the given string.
	 * 
	 * Subclasses may override this method for futher processing, e.g. sprintf()
	 * some configuration settings into the message.
	 * 
	 * @param string $strMessage The configuration message set or the empty
	 * 		string if no message is set.
	 */
	protected function compileMessage($strMessage) {
		return $strMessage;
	}
	
}
