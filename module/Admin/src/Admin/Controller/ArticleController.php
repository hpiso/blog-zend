<?php

namespace Admin\Controller;

use Admin\Form\ArticleForm;
use Blog\Entity\Article;
use Doctrine\ORM\EntityNotFoundException;
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
        $eventManager = $this->getEventManager();

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

                $eventManager->trigger('article.add', null, [
                    'article_id' => $article->getId(),
                    'article_title' => $article->getTitle(),
                    'user_id' => $this->zfcUserAuthentication()->getIdentity()->getId(),
                    'user_email' => $this->zfcUserAuthentication()->getIdentity()->getEmail()
                ]);

                //Add flash message
                $this->flashMessenger()->addMessage('Article ajouté');

                return $this->redirect()->toRoute('admin/articles');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    public function editAction()
    {
        $id = $this->params('id');
        $article = $this->getEntityManager()->getRepository('Blog\Entity\Article')->find($id);

        if (!$article) {
            throw new EntityNotFoundException('Entity Article not found');
        }

        $form = new ArticleForm();
        $form->setData(get_object_vars($article));
        $form->get('submit')->setAttribute('value', 'Modifier');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $article = $this->getHydrator()->hydrate($form->getData(), $article);

                //Persist and flush entity Article
                $em = $this->getEntityManager();
                $em->persist($article);
                $em->flush();

                $eventManager = $this->getEventManager();
                $eventManager->trigger('article.edit', null, [
                    'article_id' => $article->getId(),
                    'article_title' => $article->getTitle(),
                    'user_id' => $this->zfcUserAuthentication()->getIdentity()->getId(),
                    'user_email' => $this->zfcUserAuthentication()->getIdentity()->getEmail()
                ]);

                //Add flash message
                $this->flashMessenger()->addMessage('L\'article '. $form->getData()['title'].' a été modifié.');

                //Redirection
                return $this->redirect()->toRoute('admin/articles');
            }
        }
        $form->setData(['Slug'=>'okok']);
        return new ViewModel([
            'form'     => $form,
            'article' => $article
        ]);
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $article = $this->getEntityManager()->getRepository('Blog\Entity\Article')->find($id);
        if (!$article) {
            throw new EntityNotFoundException('Entity Article not found');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            //Remove Article entity
            $em = $this->getEntityManager();
            $em->remove($article);
            $em->flush();
            if(!empty($article->getImage())) {
                unlink($article->getImage());
            }

            $eventManager = $this->getEventManager();
            $eventManager->trigger('article.delete', null, [
                'article_id' => $article->getId(),
                'article_title' => $article->getTitle(),
                'user_id' => $this->zfcUserAuthentication()->getIdentity()->getId(),
                'user_email' => $this->zfcUserAuthentication()->getIdentity()->getEmail()
            ]);

            //Add flash message
            $this->flashMessenger()->addMessage('L\'article '. $article->getTitle().' a été supprimé.');
        }

        //Redirection
        return $this->redirect()->toRoute('admin/articles');
    }

}