<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class BaseController extends AbstractActionController
{
    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

    public function getHydrator()
    {
        return new DoctrineHydrator($this->getEntityManager());
    }
}