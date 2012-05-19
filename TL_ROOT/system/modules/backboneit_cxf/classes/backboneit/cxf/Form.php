<?php

interface Form {
	
	public function addWidget(Widget $objWidget);
	
	public function getTemplate();
	
// root palette bei form contruct
//	public function setRootPalette(Palette $objPalette);
	
	public function getRootPalette();
	
	public function getValue();
	
}
