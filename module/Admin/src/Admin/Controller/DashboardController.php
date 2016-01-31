<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;

class DashboardController extends BaseController
{

    public function indexAction()
    {
        $articles = $this->getEntityManager()->getRepository('Blog\Entity\Article')->findAll();
        $comments = $this->getEntityManager()->getRepository('Blog\Entity\Comment')->findAll();
        $categories = $this->getEntityManager()->getRepository('Blog\Entity\Category')->findAll();

        return new ViewModel([
            'articles'   => $articles,
            'comments'   => $comments,
            'categories' => $categories
        ]);
    }

}