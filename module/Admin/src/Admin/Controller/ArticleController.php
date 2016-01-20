<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;

class ArticleController extends BaseController
{

    public function indexAction()
    {
        $articles = $this->getEntityManager()->getRepository('Blog\Entity\Article')->findAll();

        return new ViewModel([
            'articles' => $articles
        ]);
    }

    public function addAction()
    {
        return new ViewModel();
    }

}