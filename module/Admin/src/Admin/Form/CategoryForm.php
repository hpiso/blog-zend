<?php

namespace Admin\Form;

use Zend\Form\Form;

class CategoryForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('category');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Nom de l\'article',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'name' => 'slug',
            'type' => 'Text',
            'options' => array(
                'label' => 'Slug',
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