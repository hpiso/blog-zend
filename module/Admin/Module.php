<?php

namespace Admin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        //Load Admin layout
        $eventManager->getSharedManager()->attach(__NAMESPACE__, 'dispatch', function($e) {
            $e->getTarget()->layout('admin/layout');
        });

        //Check authentification
//        $t = $e->getTarget();
//        $t->getEventManager()->attach(
//            $t->getServiceManager()->get('ZfcRbac\View\Strategy\RedirectStrategy')
//        );

//        $sm = $e->getApplication()->getServiceManager();
//        $auth = $sm->get('zfcuser_auth_service');
//        if (!$auth->hasIdentity()) {
//            //redirection
//        }
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
}