<?php

namespace Blog\View\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;

class BackgroundColor extends AbstractHelper implements ServiceLocatorAwareInterface
{
    const DEFAULT_BACKGROUND_COLOR = '#ffffff'; //white

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
            return self::DEFAULT_BACKGROUND_COLOR;
        }

        return $setting->getBackgroundColor();
    }
}