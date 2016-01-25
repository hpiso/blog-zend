<?php

namespace Blog\Controller;

use Admin\Controller\BaseController;
use Zend\View\Model\ViewModel;

class IndexController extends BaseController
{

    public function indexAction()
    {
        $articles = $this->getEntityManager()->getRepository('Blog\Entity\Article')
            ->findBy(['state' => 1], ['date' => 'DESC']);

        $recentArticles = $this->getEntityManager()->getRepository('Blog\Entity\Article')
            ->findBy(
                ['state' => 1],
                ['date' => 'DESC'], 5
            );

        $categories = $this->getEntityManager()->getRepository('Blog\Entity\Category')->findAll();

        return new ViewModel([
            'articles'       => $articles,
            'recentArticles' => $recentArticles,
            'categories'     => $categories
        ]);
    }
}