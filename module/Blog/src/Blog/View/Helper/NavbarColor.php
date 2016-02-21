<?php

namespace Blog\View\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;

class NavbarColor extends AbstractHelper implements ServiceLocatorAwareInterface
{
    const DEFAULT_NAVBAR_COLOR = '#ffffff'; //white

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
        $setting = $em->getRepository('Blog\Entity\Setting')->findOneByState(true);

        if (!$setting) {
            return self::DEFAULT_NAVBAR_COLOR;
        }

        return $setting->getNavbarColor();
    }
}