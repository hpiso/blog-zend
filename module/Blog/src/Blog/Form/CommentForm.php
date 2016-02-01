<?php

namespace Blog\Form;

use Zend\Form\Form;

class CommentForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('comment');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'article',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Votre nom',
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
                'label' => 'Votre Email',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'required' => true,
            )
        ));

        $this->add(array(
            'name' => 'content',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Commentaire',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'rows' => 7,
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'id' => 'submitbutton',
                'class' => 'btn btn-inverse btn-lg'
            ),
        ));
    }
}