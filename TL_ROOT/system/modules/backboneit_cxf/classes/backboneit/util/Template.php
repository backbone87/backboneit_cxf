<?php

class Template implements Renderable {
	
	private $strTemplateFile;
	
	private $arrVars;
	
	public function __constructor($strTemplateFile) {
		$this->strTemplateFile = $strTemplateFile;
	}
	
	public function __get($varKey) {
		return $this->arrVars[$varKey];
	}
	
	public function __set($varKey, $varValue) {
		$this->arrVars[$varKey] = $varValue;
	}
	
	public function __isset($varKey) {
		return isset($this->arrVars[$varKey]);
	}
	
	public function __unset($varKey) {
		unset($this->arrVars[$varKey]);
	}
	
	public function getVars() {
		return $this->arrVars;
	}
	
	public function setVars(array $arrVars) {
		$this->arrVars = $arrVars;
	}
	
	public function render() {
		ob_start();
		include $this->strTemplateFile;
		return ob_get_clean();
	}
	
	public static function renderTemplateFile($strTemplateFile, array $arrVars = null) {
		ob_start();
		include $this->strTemplateFile;
		return ob_get_clean();
	}
	
}
