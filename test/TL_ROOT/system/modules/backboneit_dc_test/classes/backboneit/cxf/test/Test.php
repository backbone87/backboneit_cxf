<?php

use backboneit\cxf\Form;
use backboneit\cxf\widget\TextWidget;
use backboneit\cxf\validation\LengthValidator;

$objForm = new Form('SOME_FORM');

$objName = new TextWidget('name');
$objName->setConfig(array(
	Widget::CONFIG_LABEL => 'Name',
	Widget::CONFIG_DESCRIPTION => 'Bitte Namen eingeben',
	Widget::CONFIG_TEMPLATE => System::getRessourceLoader()->getTemplate('my_template.tpl')
));
$objName->addValidator(new LengthValidator(array(
	LengthValidator::CONFIG_MIN_LENGTH => 5,
	LengthValidator::CONFIG_MAX_LENGTH => 16,
	// what if we have only one restriction? criples the message? no!
	// the message is bound to the configuration! so it is known to use the right message!
	// there is no default message on this level. there could be different default messages
	// for different configurations on factory level.
	AbstractValidator::CONFIG_MESSAGE => 'Bitte mindestens %s und höchstens %s Zeichen eingeben.'
)));
$objForm->addWidget($objName);

$objButton = new SubmitButton('send');
$objButton->setConfig(array(
	AbstractButton::CONFIG_LABEL => 'Absenden',
	AbstractButton::CONFIG_DESCRIPTION => 'Sendet das Formular ab.'
));
$objForm->addButton($objButton);

echo $objForm->render();
