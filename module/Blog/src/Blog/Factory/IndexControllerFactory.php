<?php
namespace Blog\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Blog\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $controller = new IndexController();
        return $controller;
    }
}