<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;


class LogController extends BaseController
{

    public function indexAction()
    {
        $logs = $this->getEntityManager()->getRepository('Blog\Entity\Log')
            ->findBy([], ['date' => 'DESC']);

        return new ViewModel(
        [
            'logs' => $logs
        ]);
    }

}