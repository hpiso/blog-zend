<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;

class DashboardController extends BaseController
{

    public function indexAction()
    {
        //var_dump($this->getEntityManager()->getRepository('Blog\Entity\Article')->findAll());die;
        return new ViewModel();
    }

}