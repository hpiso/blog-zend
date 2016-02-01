<?php

namespace Blog\View\Helper;

use Blog\Service\CategoryService;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;

class RecentArticleWidget extends AbstractHelper implements ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function __invoke()
    {
        $em = $this->getServiceLocator()->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $recentArticles = $em->getRepository('Blog\Entity\Article')
            ->findBy(
                ['state' => 1],
                ['date' => 'DESC'], 5
            );

        return $this->getView()->render('blog/index/partials/recent-article', ['recentArticles' => $recentArticles]);

    }
}