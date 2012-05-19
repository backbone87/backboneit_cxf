<?php

namespace backboneit\cxf\validation;

/**
 * A validator validates a PHP value.
 * A validator instance must be serializable.
 * A validator instance has a transient (not serialized) state about its last
 * validation.
 * 
 * @author Oliver Hoff <oliver@hofff.com>
 */
interface Validator extends \Serializable {
	
	/**
	 * @var integer Validation level error. Recommended behavior when
	 * 		validation was not successful: Stop prosecution of the underlying
	 * 		action and display the message to the user in a noteable way.
	 */
	const VALIDATION_LEVEL_ERROR	= 1;
	
	/**
	 * @var integer Validation level warning. Recommended behavior when
	 * 		validation was not successful: Continue prosecution of the
	 * 		underlying action depending on the users preferences and display the
	 * 		message to the user in a noteable way.
	 */
	const VALIDATION_LEVEL_WARNING	= 2;
	
	/**
	 * @var integer Validation level info. Recommended behavior when validation
	 * 		was not successful: Continue prosecution of the underlying action
	 * 		and display the message to the user.
	 */
	const VALIDATION_LEVEL_INFO		= 4;
	
	
	
	/**
	 * Resets this validators current state and validates the given value
	 * according to this validators configuration.
	 * 
	 * @throws InvalidArgumentException If the type of passed value can not be
	 * 		handled by this validator.
	 * @throws RuntimeException If the passed value could not be validated by
	 * 		this validator for any reason.
	 * 
	 * @param mixed $varValue The value to be validated.
	 */
	public function validate($varValue);
	
	/**
	 * Tells whether the last checked value passed the validation or not.
	 * 
	 * @throws LogicException If no internal state is available, i.e. no
	 * 		previous call to #validate($varValue) was made.
	 * 
	 * @return boolean If the last checked value passed the validation true,
	 * 		otherwise false.
	 */
	public function isValid();
	
	/**
	 * Returns a message that describes the reason why the last value did not
	 * pass validation. If the value has passed the validation returns null.
	 *  
	 * @throws LogicException If no internal state is available, i.e. no
	 * 		previous call to #validate($varValue) was made.
	 * 
	 * @return string|null The, possibly empty, error message or null, if there
	 * 		was no error.
	 */
	public function getMessage();
	
	/**
	 * Returns the validation level of this validator. For ease of use take a
	 * look at the VALIDATION_LEVEL_* constants.
	 * 
	 * @return integer The validation level.
	 */
	public function getValidationLevel();
	
	/**
	 * Resets the validator state.
	 */
	public function reset();
	
	/**
	 * Supports client side validation
	 */
	public function supportsClientSideValidation();

	/**
	 * Enables client side validation.
	 * 
	 * @return JavaScriptObject The JavaScript object of type Validator to be
	 * 		used as callback, when the value has changed and needs to be
	 * 		(re)validated.
	 */
	public function enableClientSideValidation();
	
}
