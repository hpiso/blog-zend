<?php

namespace Admin\Controller;

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

    public function editAction()
    {
        return new ViewModel();
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