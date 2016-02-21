<?php

namespace Admin\Controller;

use Admin\Form\CommentForm;
use Doctrine\ORM\EntityNotFoundException;
use Zend\View\Model\ViewModel;


class CommentController extends BaseController
{

    public function indexAction()
    {
        $comments = $this->getEntityManager()->getRepository('Blog\Entity\Comment')->findAll();

        return new ViewModel([
            'comments' => $comments
        ]);
    }

    public function showAction()
    {
        $id = $this->params('id');
        $comment = $this->getEntityManager()->getRepository('Blog\Entity\Comment')->find($id);

        if (!$comment) {
            throw new EntityNotFoundException('Entity Comment not found');
        }

        $commentForm = new CommentForm();
        $commentForm->get('submit')->setAttribute('value', 'Valider');

        if ($comment->isState() == 1) {
            $commentForm->get('state')->setAttribute('checked', 'checked');
        }
        $request = $this->getRequest();


        if ($request->isPost()) {

            $commentData = $request->getPost();

            if(isset($commentData->state)){
                $commentData->state = 1;
            } else {
                $commentData->state = 0;
            }

            $commentForm->setData($commentData);

            if ($commentForm->isValid()) {
                
                $comment = $this->getHydrator()->hydrate($commentForm->getData(), $comment);

                //Persist and flush entity Comment
                $em = $this->getEntityManager();
                $em->persist($comment);
                $em->flush();

                $eventManager = $this->getEventManager();
                $eventManager->trigger('comment.edit', null, [
                    'comment_id' => $comment->getId(),
                    'comment_email' => $comment->getEmail(),
                    'article_title' => $comment->getArticle()->getTitle(),
                    'article_id' => $comment->getArticle()->getId(),
                    'user_id' => $this->zfcUserAuthentication()->getIdentity()->getId(),
                    'user_email' => $this->zfcUserAuthentication()->getIdentity()->getEmail()
                ]);

                //Redirection
                return $this->redirect()->toRoute('admin/comment');
            }
        }

        return new ViewModel([
            'comment'     => $comment,
            'commentForm' => $commentForm
        ]);
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $comment = $this->getEntityManager()->getRepository('Blog\Entity\Comment')->find($id);

        if (!$comment) {
            throw new EntityNotFoundException('Entity Comment not found');
        }

        //Remove Category entity
        $em = $this->getEntityManager();
        $em->remove($comment);
        $em->flush();

        $eventManager = $this->getEventManager();
        $eventManager->trigger('comment.delete', null, [
            'comment_id' => $comment->getId(),
            'comment_email' => $comment->getEmail(),
            'user_id' => $this->zfcUserAuthentication()->getIdentity()->getId(),
            'user_email' => $this->zfcUserAuthentication()->getIdentity()->getEmail(),
            'article_title' => $comment->getArticle()->getTitle(),
            'article_id' => $comment->getArticle()->getId()
        ]);

        //Add flash message
        $this->flashMessenger()->addMessage('Le commentaire '. $comment->getName().' a été supprimé.');

        //Redirection
        return $this->redirect()->toRoute('admin/comment');
    }

}