<?php

namespace backboneit\cxf\widget;

/**
 * This interface represents a widget. A widget is any human interface for
 * collecting a piece of data. For example one or more HTML inputs or a fully
 * customized JavaScript driven interface method.
 * 
 * @author Oliver Hoff <oliver@hofff.com>
 */
interface Widget extends \Serializable, \backboneit\cxf\Renderable, \backboneit\cxf\FormComponent {
	
	/**
	 * If this is a named widget, this method returns the name of this widget.
	 * If this is a unnamed widget, returns null.
	 * 
	 * @return string The name of this widget, or null if unnamed.
	 */
	public function getName();
	
	/**
	 * Tells whether a value for this widget was submitted within the last
	 * request.
	 * 
	 * @return boolean If a value was submitted true, otherwise false.
	 */
	public function isSubmitted();
	
	/**
	 * Get the value of this widget with all transformations, implementation
	 * specific or attached to this widget, applied.
	 * 
	 * @return mixed The value of this widget.
	 */
	public function getValue();
	
	/**
	 * Get the raw value of this widget, this is the value without any
	 * implementation specific transformations or any transformations of this
	 * widgets transformators applied.
	 * 
	 * @return mixed The raw value of this widget.
	 */
	public function getRawValue();
	
	/**
	 * Attaches a new transformator to this widget.
	 * 
	 * @param \backboneit\cxf\transformation\Transformator $objTransformator The
	 * 		transformator to be attached.
	 */
	public function addTransformator(\backboneit\cxf\transformation\Transformator $objTransformator);
	
	/**
	 * Attaches a new validator to this widget.
	 * 
	 * @param \backboneit\cxf\validation\Validator $objValidator The validator
	 * 		to be attached.
	 */
	public function addValidator(\backboneit\cxf\validation\Validator $objValidator);
		
	/**
	 * Validates this widgets value against this widgets implementation specific
	 * validation method, if any, and against all attached validators.
	 */
	public function validate();
	
	/**
	 * Tells whether the value of this widget is valid according to this widgets
	 * implementation specific validation method, if any, and to all to this
	 * widget attached validators.
	 * 
	 * @throws LogicException If no validation information is available, i.e. no
	 * 		previous call to #validate() was made.
	 * 
	 * @return boolean If this widgets value is valid, otherwise false.
	 */
	public function isValid();
	
	/**
	 * Returns an possibly empty array of any messages, e.g. validation
	 * messages, associated with the widgets current state.
	 * 
	 * @return array The messages of this widgets.
	 */
	public function getMessages();
	
}
