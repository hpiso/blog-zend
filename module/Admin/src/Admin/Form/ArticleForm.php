<?php

namespace Admin\Form;

use Zend\InputFilter;
use Zend\Form\Element;
use Zend\Form\Form;

class ArticleForm extends Form
{
    public function __construct($name = null, $categories)
    {
        // we want to ignore the name passed
        parent::__construct('article');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'title',
            'required' => true,
            'type' => 'Text',
            'options' => array(
                'label' => 'Title',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));

        $file = new Element\File('image');
        $file->setLabel('Image')
            ->setAttribute('id', 'image');
        $this->add($file);



        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'required' => true,
            'name' => 'category_id',
            'options' => array(
                'label' => 'Category',
                'value_options' => $categories
            ),
        ));

        $this->add(array(
            'name' => 'slug',
            'required' => true,
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
            'required' => true,
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

//        $this->addInputFilter();
    }

//    public function addInputFilter()
//    {
//        $inputFilter = new InputFilter\InputFilter();
//        // File Input
//        $fileInput = new InputFilter\FileInput('image');
//        $fileInput->setRequired(true);
//        $fileInput->getFilterChain()->attachByName(
//            'filerenameupload',
//            array(
//                'target'    => '/data/tmpuploads/avatar.png',
//                'randomize' => true,
//            )
//        );
//        $inputFilter->add($fileInput);
//
//        $this->setInputFilter($inputFilter);
//    }
}