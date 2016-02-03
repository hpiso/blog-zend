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

        $request = $this->getRequest();

        if ($request->isPost()) {
            $commentForm->setData($request->getPost());
            if ($commentForm->isValid()) {
                
                $comment = $this->getHydrator()->hydrate($commentForm->getData(), $comment);

                //Persist and flush entity Category
                $em = $this->getEntityManager();
                $em->persist($comment);
                $em->flush();

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

        //Add flash message
        $this->flashMessenger()->addMessage('Le commentaire '. $comment->getName().' a été supprimé.');


        //Redirection
        return $this->redirect()->toRoute('admin/commentaires');
    }

}