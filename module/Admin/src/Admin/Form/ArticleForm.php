<?php

namespace Admin\Form;

use Zend\Form\Form;

class ArticleForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('article');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'title',
            'type' => 'Text',
            'options' => array(
                'label' => 'Title',
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
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'name' => 'content',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Contenu',
            ),
            'attributes' => array(
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'state',
            'type' => 'Checkbox',
            'options' => array(
                'label' => 'Actif',
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Ajouter',
                'id' => 'submitbutton',
                'class' => 'btn btn-success'
            ),
        ));
    }
}