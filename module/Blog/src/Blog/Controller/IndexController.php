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

        return new ViewModel([
            'articles'       => $articles,
            'categories'     => $this->getWidgetElements()['categories'],
            'recentArticles' => $this->getWidgetElements()['recentArticles'],
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

        return new ViewModel([
            'article'        => $article,
            'categories'     => $this->getWidgetElements()['categories'],
            'recentArticles' => $this->getWidgetElements()['recentArticles'],
        ]);
    }

    /**
     * Get all categories and the last 5 articles for the sidebar widget
     *
     * @return array
     */
    private function getWidgetElements()
    {
        $categories = $this->getEntityManager()->getRepository('Blog\Entity\Category')->findAll();

        $recentArticles = $this->getEntityManager()->getRepository('Blog\Entity\Article')
            ->findBy(
                ['state' => 1],
                ['date' => 'DESC'], 5
            );

        return [
            'categories'     => $categories,
            'recentArticles' => $recentArticles
        ];
    }
}