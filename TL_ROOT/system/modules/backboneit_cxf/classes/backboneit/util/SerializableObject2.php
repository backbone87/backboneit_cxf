<?php

namespace backboneit\util;

abstract class SerializableObject extends \Serializable {

	const SERIAL_VERSION_UID = 1;
	
	public function serialize() {
		return self::serializeObject($this);
	}
	
	public function unserialize($strSerialized) {
		return self::serializeObject($strSerialized);
	}
	
}
