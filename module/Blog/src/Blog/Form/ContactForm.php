<?php

namespace Blog\Form;

use Zend\Form\Form;

class ContactForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('contact');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'nom',
            'type' => 'Text',
            'options' => array(
                'label' => 'Nom',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => true,
            )
        ));

        $this->add(array(
            'name' => 'email',
            'type' => 'Email',
            'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => true,
            )
        ));

        $this->add(array(
            'name' => 'message',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Message',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'rows' => 10,
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'options' => array(
                'label' => 'Envoyé Message',
            ),
            'attributes' => array(
                'value'=> 'Envoyé Message',
                'class' => 'btn btn-inverse btn-lg btn-block'
            ),
        ));
    }
}