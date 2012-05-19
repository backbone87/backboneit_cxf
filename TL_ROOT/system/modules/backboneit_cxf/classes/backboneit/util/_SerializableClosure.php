<?php

namespace backboneit\util;

class SerializableClosure extends AbstractSerializable {
	
	protected $objClosure;
	
	protected $objReflection;
	
	public function __construct(Closure $objClosure) {
		$this->objClosure = $objClosure;
		$this->objReflection = new \ReflectionFunction($objClosure);
	} 

	public function __invoke() {
		$this->objReflection->invokeArgs(func_get_args());
	}
	
	public function getClosure() {
		return $this->objClosure;
	}
	
	protected function serializeClosure() {
		
	}
	
	protected function getCode() {
		$objFile = new \SplFileObject($this->reflection->getFileName());
		$objFile->seek($this->objReflection->getStartLine() - 1);
		
		$strCode = '';
		while($objFile->next() && $objFile->key() < $this->objReflection->getEndLine())
			$strCode .= $objFile->current();
		
		$objReflection->getParameters();
		$begin = strpos($code, 'function');
		$end = strrpos($code, '}');
		$code = substr($code, $begin, $end - $begin + 1);
		
		return $code;
	}
	
	private function getParameterRegEx(\ReflectionParameter $objParam) {
		preg_quote($objParam->getName(), '@');
	}
}
