<?php

namespace backboneit\util;

/**
 * Abstract base class for serializable objects.
 * 
 * I'm highly undecided about this mechanism!
 * TODO: Comments are highly demanded!
 * 
 * @author Oliver Hoff <oliver@hofff.com>
 */
abstract class SerializableObject implements \Serializable {

	/**
	 * Any data a class wants to be serialized for an instance, should be added
	 * to this instance.
	 * The parent method should be invoked as the first command in the method!
	 * Although this is not required, if the overriding class is directly
	 * derived from this class or do not wish parent data to be serialized.
	 * (The latter could result in damaged objects when unserialized.)
	 * 
	 * To avoid collisions with parent properties use the following convention.
	 * 
	 * Single value:
	 * $arrData[__CLASS__] = $varMyData;
	 * 
	 * Multiple ordered values:
	 * $arrData[__CLASS__] = array($varMyDataPartOne, $varMyDataPartTwo);
	 * 
	 * Multiple named values:
	 * $arrData[__CLASS__]['mydata1'] = $varMyDataPartOne;
	 * $arrData[__CLASS__]['mydata2'] = $varMyDataPartTwo;
	 * 
	 * @param array $arrData A reference to the array containing the data to be
	 * 		serialized.
	 */
	protected function collectSerializationData(array &$arrData) {	
	}
	
	/**
	 * This method is called, when the state of the object has to be
	 * reconstructed from serialized data.
	 * 
	 * The parent method should be invoked as the first command in the method!
	 * Although this is not required, if the overriding class is directly
	 * derived from this class or do not wish parent data to be unserialized,
	 * e.g. when calling a constructor.
	 * (The latter could result in damaged objects.)
	 * 
	 * @param array $arrData The data array retrieved from serialized state.
	 */
	protected function restoreSerializedState(array $arrData) {
	}
	
	/* (non-PHPdoc)
	 * @see http://www.php.net/manual/en/serializable.serialize.php
	 */
	public function serialize() {
		$arrData = array();
		$this->collectSerializationData($arrData);
		return serialize($arrData);
	}
	
	/* (non-PHPdoc)
	 * @see http://www.php.net/manual/en/serializable.unserialize.php
	 */
	public function unserialize($strSerialized) {
		$this->restoreSerializedState(unserialize($strSerialized));
	}
	
}