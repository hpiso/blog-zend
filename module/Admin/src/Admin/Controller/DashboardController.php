<?php

namespace Admin\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Zend\View\Model\ViewModel;

class DashboardController extends BaseController
{
    public function indexAction()
    {
        $articles   = $this->getEntityManager()->getRepository('Blog\Entity\Article')->findAll();
        $comments   = $this->getEntityManager()->getRepository('Blog\Entity\Comment')->findAll();
        $categories = $this->getEntityManager()->getRepository('Blog\Entity\Category')->findAll();

        $lastFiveComments = $this->getEntityManager()->getRepository('Blog\Entity\Comment')
            ->findBy([], ['date' => 'DESC'], 5);

        $lastFiveArticles = $this->getEntityManager()->getRepository('Blog\Entity\Article')
            ->findBy([], ['date' => 'DESC'], 5);

        return new ViewModel([
            'articles'         => $articles,
            'comments'         => $comments,
            'categories'       => $categories,
            'lastFiveComments' => $lastFiveComments,
            'lastFiveArticles' => $lastFiveArticles
        ]);
    }

    public function updateStateCommentAction()
    {
        $eventManager = $this->getEventManager();
        if ($this->getRequest()->isXmlHttpRequest()) {

            $em = $this->getEntityManager();

            $commentId = $this->getRequest()->getPost('commentId');
            $comment = $em->getRepository('Blog\Entity\Comment')->find($commentId);

            if (!$comment) {
                throw new EntityNotFoundException('Entity Comment not found');
            }

            if ($comment->isState()) {
                $comment->setState(false);
            } else{
                $comment->setState(true);
            }

            $em->persist($comment);
            $em->flush();

            $eventManager->trigger($comment->isState() ? 'comment.approve' : 'comment.reject', null, [
                'comment_id' => $comment->getId(),
                'article_id' => $comment->getArticle()->getId(),
                'article_title' => $comment->getArticle()->getTitle(),
                'user_id' => $this->zfcUserAuthentication()->getIdentity()->getId(),
                'user_email' => $this->zfcUserAuthentication()->getIdentity()->getEmail()
            ]);

            $view = new ViewModel(['comment' => $comment]);
            $view->setTemplate('admin/updateComment');
            $view->setTerminal(true); //turn off layout

            return $view;
        }

        return null;
    }

}