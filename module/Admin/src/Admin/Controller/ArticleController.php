<?php

namespace Admin\Controller;

use Admin\Form\ArticleForm;
use Blog\Entity\Article;
use Zend\View\Model\ViewModel;


class ArticleController extends BaseController
{

    public function indexAction()
    {
        $articles = $this->getEntityManager()->getRepository('Blog\Entity\Article')
            ->findBy([], ['date' => 'DESC']);

        return new ViewModel([
            'articles' => $articles
        ]);
    }

    public function addAction()
    {
        $form = new ArticleForm();
        $article = new Article();

        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $article = $this->getHydrator()->hydrate($form->getData(), $article);

                $em = $this->getEntityManager();
                $em->persist($article);
                $em->flush();

            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

}