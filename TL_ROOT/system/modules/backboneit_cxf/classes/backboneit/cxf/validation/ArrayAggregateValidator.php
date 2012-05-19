<?php

namespace backboneit\cxf\validation;

/**
 * This class wraps a Validator instance and uses it to validate an array of
 * values.
 * 
 * TODO: This class behaves always as CONFIG_IGNORE_AGGREGATE_MESSAGES is set to
 * true. Implement missing logic.
 * TODO: canHandle()
 * 
 * @author Oliver Hoff <oliver@hofff.com>
 */
class ArrayAggregateValidator extends AbstractValidator {
	
	/**
	 * @var string Name of the configuration variable that indicates if the
	 * 		aggregate validator should also be used on the values of nested
	 * 		arrays.
	 */
	const CONFIG_RECURSIVE_ARRAY_VALIDATION = 'recursiveArrayValidation';
	
	/**
	 * @var string Name of the configuration variable that tells whether to
	 * 		leave the messages of the aggregate validator unused within this
	 * 		validators message.
	 */
	const CONFIG_IGNORE_AGGREGATE_MESSAGES = 'ignoreAggregateMessages';
	
	
	
	/**
	 * @var Validator The aggregate validator to be used for element validation.
	 */
	protected $objAggregateValidator;
	
	/**
	 * @var array The messages returned by the aggregate validator.
	 * @transient
	 */
	protected $arrMessages;
	
	/**
	 * Creates a new ArrayAggregateValidator using the given Validator as
	 * aggregate to validate each array element.
	 * 
	 * @param Validator $objAggregateValidator The aggregate validator.
	 * @param array $arrConfig The validator configuration.
	 */
	public function __construct(Validator $objAggregateValidator, array $arrConfig = null) {
		parent::__construct($arrConfig);
		$this->objAggregateValidator = $objAggregateValidator;
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\util\SerializableConfiguration#collectSerializationData($arrData)
	 */
	protected function collectSerializationData(array &$arrData) {
		parent::collectSerializationData($arrData);
		$arrData[__CLASS__] = $this->objAggregateValidator;
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\util\SerializableConfiguration#restoreSerializedState($arrData)
	 */
	protected function restoreSerializedState(array $arrData) {
		parent::restoreSerializedState($arrData);
		$this->objAggregateValidator = $arrData[__CLASS__];
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\cxf\validation\AbstractValidator#doValidation($varValue)
	 */
	protected function doValidation($varValues) {
		$blnValid = true;
		$objValidator = $this->objAggregateValidator;
		$arrMessages = array();
		$objClosure;
		
		if($this->arrConfig[self::CONFIG_RECURSIVE_ARRAY_VALIDATION]) {
			$objClosure = function($varValue, $strKey) use(&$blnValid, $objValidator, &$objClosure, &$arrKeyStack) {
				if(is_array($varValue)) {
					$arrUpperMessages = $arrMessages;
					$arrMessages = array();
					
					array_walk((array) $varValue, $objClosure);
					
					$arrUpperMessages[$strKey] = $arrMessages;
					$arrMessages = &$arrUpperMessages;
					
				} else {
					$objValidator->validate($varValue);
					if($objValidator->isValid())
						return;
						
					$blnValid = false;
					$arrMessages[$varKey] = $objValidator->getMessage();
				}
			};
			
		} else {
			$objClosure = function($varValue, $varKey) use(&$blnValid, $objValidator, &$arrMessages) {
				$objValidator->validate($varValue);
				if($objValidator->isValid())
					return;
					
				$blnValid = false;
				$arrMessages[$varKey] = $objValidator->getMessage();
			};
		}
		
		$this->arrMessages = $arrMessages;
		array_walk((array) $varValues, $objClosure);
		
		return $blnValid;
	}
	
}
