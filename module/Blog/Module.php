<?php

namespace Blog;

use Zend\Di\ServiceLocatorInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Blog\View\Helper\CategoryWidget;

class Module implements ViewHelperProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'categoryWidget'      => 'Blog\View\Helper\CategoryWidget',
                'recentArticleWidget' => 'Blog\View\Helper\RecentArticleWidget',
                'categoryFooter'      => 'Blog\View\Helper\CategoryFooter',
                'recentArticleFooter' => 'Blog\View\Helper\RecentArticleFooter',
                'navbarColor'         => 'Blog\View\Helper\NavbarColor',
                'backgroundColor'     => 'Blog\View\Helper\BackgroundColor',
            )
        );
    }
}