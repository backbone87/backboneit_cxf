<?php

class TextWidget extends AbstractWidget {
	
	public function getName();
	
	public function getTemplate();
	
	public function hasErrors();
	
	public function addValidator(Validator $validator);
	
	public function validate();
	
}
