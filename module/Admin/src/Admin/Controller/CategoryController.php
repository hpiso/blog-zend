<?php

namespace Admin\Controller;

use Admin\Form\ArticleForm;
use Blog\Entity\Article;
use Zend\View\Model\ViewModel;


class CategoryController extends BaseController
{

    public function indexAction()
    {
        $categories = $this->getEntityManager()->getRepository('Blog\Entity\Category')->findAll();

        return new ViewModel([
            'categories' => $categories
        ]);
    }


}