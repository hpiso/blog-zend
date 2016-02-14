<?php

namespace Admin\Form;

use Zend\Form\Form;

class SettingForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('setting');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'pagination',
            'type' => 'Select',
            'options' => array(
                'label' => 'Nombre d\'article par page',
                'value_options' => array(
                    '3'  => '3',
                    '5'  => '5',
                    '10' => '10',
                    '15' => '15',
                    '20' => '20',
                ),
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'name' => 'navbarColor',
            'type' => 'Text',
            'options' => array(
                'label' => 'Couleur de la barre de navigation',
            ),
            'attributes' => array(
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'id' => 'submitbutton',
                'class' => 'btn btn-success'
            ),
        ));
    }
}