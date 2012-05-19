<?php

namespace backboneit\util;

final class Serializer {

	const CONSTANT_SERIAL_VERSION_UID = 'SERIAL_VERSION_UID';
	
	public static function serialize($varValue) {
		if(is_scalar($varValue)) {
			return self::serializeScalar($varValue);
		} elseif(is_object($varValue)) {
			return self::serializeObject($varValue);
		} elseif(is_array($varValue)) {
			return self::serializeArray($varValue);
		}
	}
	
	protected static function serializeScalar($varValue) {
		return serialize($varValue);
	}
	
	protected static function serializeObject(Serializable $objValue) {
		$objClass = new ReflectionClass(get_class($objValue));
//		$strHash = $blnStrict ? self::getSerialVersionHash($objClass) : '';
		return $objClass->n
	}
	
	protected static function serializeArray(array $arrValue) {
		
	}
	
//	private static function getSerialVersionHash(\ReflectionClass $objClass) {
//		$strHash = self::getSerialVersionUID($objClass);
//		while($objParent = $objClass->getParentClass()) {
//			$strHash .= self::getSerialVersionUID($objParent);
//		}
//		return md5($strHash);
//	}
//	
//	private static function getSerialVersionUID(\ReflectionClass $objClass) {
//		$strSVUID = strval($objClass->getConstant(self::CONSTANT_SERIAL_VERSION_UID));
//		if(strlen($strSVUID) >= 8) // we need at least 64bit
//			return $strSVUID;
//			
//		$objFile = new \SplFileInfo($objClass->getFileName());
//		return $objClass->getFileName() + $objFile->getMTime();
//	}
	
}
