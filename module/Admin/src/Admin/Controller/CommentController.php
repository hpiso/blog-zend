<?php

namespace Admin\Controller;

use Zend\View\Model\ViewModel;


class CommentController extends BaseController
{

    public function indexAction()
    {
        return new ViewModel();
    }

}