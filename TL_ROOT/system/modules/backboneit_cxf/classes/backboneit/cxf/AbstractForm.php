<?php

class AbstractForm implements Form {
	
	protected $objRootPalette;
	
	public function __construct() {
		$objRootPalette = new Palette();
	}
	
	public function addWidget(Widget $objWidget);
	
	public function getTemplate();
	
	public function getRootPalette();
	
}