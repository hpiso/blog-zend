<?php
namespace Blog\Factory;

use Zend\ServiceManager\FactoryInterface;
use Blog\Controller\IndexController;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $controller = new IndexController();
        return $controller;
    }
}