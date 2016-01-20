<?php

namespace Blog\Controller;

use Admin\Controller\BaseController;
use Zend\View\Model\ViewModel;

class IndexController extends BaseController
{

    public function indexAction()
    {
        $articles = $this->getEntityManager()->getRepository('Blog\Entity\Article')->findAll();

        return new ViewModel([
            'articles' => $articles
        ]);
    }
}