<?php

namespace Blog\Controller;

use Admin\Controller\BaseController;
use Doctrine\ORM\EntityNotFoundException;
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

    public function showAction()
    {
        $slug = $this->params('slug');
        $article = $this->getEntityManager()->getRepository('Blog\Entity\Article')
            ->findOneBy(['slug' => $slug]);

        if (!$article) {
            throw new EntityNotFoundException('Entity Article not found');
        }

        $recentArticles = $this->getEntityManager()->getRepository('Blog\Entity\Article')
            ->findBy(
                ['state' => 1],
                ['date' => 'DESC'], 5
            );

        $categories = $this->getEntityManager()->getRepository('Blog\Entity\Category')->findAll();

        return new ViewModel([
            'recentArticles' => $recentArticles,
            'categories'     => $categories,
            'article'        => $article
        ]);
    }
}