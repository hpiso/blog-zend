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

            $post = $request->getPost();
            $post['image'] = '/upload/'.$request->getFiles()['image']['name'];

            $form->setData($post);


            if ($form->isValid()) {

                if( !empty($_FILES['image']) ) {
                    $picture_temp = $_FILES['image']['tmp_name'];
                    $picture = $_FILES['image']['name'];
                    move_uploaded_file($picture_temp,$_SERVER['DOCUMENT_ROOT'].'/upload/'.$picture);
                }
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