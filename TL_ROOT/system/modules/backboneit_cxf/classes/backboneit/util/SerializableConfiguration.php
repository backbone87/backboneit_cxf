<?php

namespace backboneit\util;

/**
 * This class' instances are configurable and serializable.
 * The main purpose of this class is to serve as a base for various
 * implementations of the Configurable and Serializable interfaces.
 * 
 * @author Oliver Hoff <oliver@hofff.com>
 */
class SerializableConfiguration extends SerializableObject implements Configurable {
	
	/**
	 * @var array The current configuartion of this instance.
	 */
	protected $arrConfig;
	
	/**
	 * Sets up the configuration for this instance.
	 * 
	 * @param array $arrConfig Initial configuration.
	 */
	protected function __construct(array $arrConfig = null) {
		$this->setConfig((array) $arrConfig);
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\util\SerializableObject#collectSerializationData($arrData)
	 */
	protected function collectSerializationData(array &$arrData) {
		$arrData[__CLASS__] = $this->arrConfig;
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\util\SerializableObject#restoreSerializedState($arrData)
	 */
	protected function restoreSerializedState(array $arrData) {
		$this->arrConfig = $arrData[__CLASS__];
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\util\Configurable#resetConfig($arrConfig)
	 */
	public function resetConfig() {
		$this->arrConfig = null;
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\util\Configurable#setConfig($arrConfig)
	 */
	public function setConfig(array $arrConfig) {
		$this->arrConfig = (array) $arrConfig;
	}
	
	/* (non-PHPdoc)
	 * @see backboneit\util\Configurable#getConfig()
	 */
	public function getConfig() {
		return $this->arrConfig;
	}
	
}
