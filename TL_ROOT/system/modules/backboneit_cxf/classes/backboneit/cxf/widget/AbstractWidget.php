<?php

namespace backboneit\cxf\widget;

use backboneit\util\Template as Template;

/**
 * An abstract base class for ease of widget creation.
 * 
 * @author Oliver Hoff <oliver@hofff.com>
 */
abstract class AbstractWidget extends \backboneit\util\SerializableConfiguration implements Widget {
	
	/**
	 * @var string Name of configuration variable, that sets the template to be
	 * 		used for rendering.
	 */
	const CONFIG_TEMPLATE = 'template';
	
	
	
	/**
	 * @var string The name of this widget.
	 */
	private $strName;
	
	/**
	 * @var array The validators attached to this widget.
	 */
	protected $arrValidators = array();
	
	/**
	 * @var array The transformators attached to this widget.
	 */
	protected $arrTransformators = array();
	
	/**
	 * @var boolean The result of the validation of this widgets submitted
	 * 		value, if any.
	 * @transient
	 */
	protected $blnValid;
	
	/**
	 * @var array Any messages associated with this widgets processing.
	 * @transient
	 */
	protected $arrMessages;
	
	/**
	 * Sets up the configuration for this instance.
	 * 
	 * @param string $strName The name of this widget.
	 * @param array $arrConfig Initial configuration.
	 */
	protected function __construct($strName, array $arrConfig = null) {
		parent::__construct($arrConfig);
		$this->strName = (string) $strName;
	}
	
	/* (non-PHPdoc)
	 * @see \backboneit\util\SerializableObject#collectSerializationData($arrData)
	 */
	protected function collectSerializationData(array &$arrData) {
		parent::collectSerializationData($arrData);
		$arrData[__CLASS__] = array(
			$this->strName,
			$this->arrValidators,
			$this->arrTransformators
		);
	}
	
	/* (non-PHPdoc)
	 * @see \backboneit\util\SerializableObject#restoreSerializedState($arrData)
	 */
	protected function restoreSerializedState(array $arrData) {
		parent::restoreSerializedState($arrData);
		list(
			$this->strName,
			$this->arrValidators,
			$this->arrTransformators
		) = $arrData[__CLASS__];
	}
	
	public function getName() {
		return $this->strName;
	}
	
	public function isValid() {
		return $this->blnValid;
	}
	
	public function isSubmitted() {
		return isset($_GET[$this->strName]);
	}
	
	public function addTransformator(\backboneit\cxf\transformation\Transformator $objTransformator) {
		$this->arrTransformators[] = $objTransformator;
	}
	
	public function addValidator(\backboneit\cxf\validation\Validator $objValidator) {
		$this->arrValidators[] = $objValidator;
	}
	
	public function validate() {
		foreach($this->arrValidators as $objValidator) {
			$objValidator->validate($this);
			if($objValidator->hasErrors()) {
				$this->blnValid = false;
				$this->arrErrors[] = $objValidator->getError();
			}
		}
	}

	public function render() {
		$objTemplate = new Template($this->arrConfig[self::CONFIG_TEMPLATE]);
		$this->compile($objTemplate);
		return $objTemplate->render();
	}
	
	protected abstract function compile(Template $objTemplate);
	
}
