<?php

namespace Blog\Controller;

use Admin\Controller\BaseController;
use Blog\Entity\Comment;
use Blog\Form\CommentForm;
use Doctrine\ORM\EntityNotFoundException;
use Zend\View\Model\ViewModel;

class IndexController extends BaseController
{
    const MAX_PER_PAGE = 5;

    public function indexAction()
    {
        // Récupère le paramètre dans l'URL. TODO : l'intercepter dans une route
        $currentPage = (int)$this->params()->fromQuery('page', 1);
        $currentPage = $currentPage <= 0 ? 1 : $currentPage;

        // Nombre d'article au total
        $nbArticles = (int)$this->getEntityManager()->getRepository('Blog\Entity\Article')->getArticleCount();

        $pagination = $this->getServiceLocator()->get('pagination')
            ->constructPagination($nbArticles, $currentPage, $this->getMaxPerPage());

        $articles = $this->getEntityManager()->getRepository('Blog\Entity\Article')
            ->getArticlePaginator($pagination['current'], $this->getMaxPerPage());

        return new ViewModel([
            'articles' => $articles,
            'pagination' => $pagination,
        ]);
    }

    public function showAction()
    {
        $slug = $this->params('slug');
        $article = $this->getEntityManager()->getRepository('Blog\Entity\Article')
            ->findOneBy(['slug' => $slug]);

        if (!$article)
        {
            throw new EntityNotFoundException('Entity Article not found');
        }

        $comments = $this->getEntityManager()->getRepository('Blog\Entity\Comment')
            ->getActiveByArticle($article->getId());

        $comment = new Comment();
        $commentForm = new CommentForm();
        $commentForm->get('submit')->setAttribute('value', 'Ajouter un commentaire');

        $request = $this->getRequest();

        if ($request->isPost())
        {
            $commentForm->setData($request->getPost());
            if ($commentForm->isValid())
            {

                $comment = $this->getHydrator()->hydrate($commentForm->getData(), $comment);

                //Persist and flush entity Comment
                $em = $this->getEntityManager();
                $em->persist($comment);
                $em->flush();

                $eventManager = $this->getEventManager();
                $eventManager->trigger('comment.add', null, [
                    'comment_id' => $comment->getId(),
                    'comment_name' => $comment->getName(),
                    'comment_email' => $comment->getEmail(),
                    'article_title' => $comment->getArticle()->getTitle(),
                    'article_id' => $comment->getArticle()->getId(),
                ]);

                //Envoie du mail
                $this->getServiceLocator()->get('mail')
                    ->sendMail($comment->getEmail(), $comment->getName(), $comment->getContent());

                //Add flash message
                $this->flashMessenger()->addMessage('Votre commentaire a été ajouté,
                il est en attente de validation par l\'administrateur');

                $eventManager = $this->getEventManager();
                $eventManager->trigger('comment.add', null, compact($comment));

                //Redirection
                return $this->redirect()->toRoute('article', ['slug' => $article->getSlug()]);
            }
        }

        return new ViewModel([
            'article' => $article,
            'comments' => $comments,
            'commentForm' => $commentForm,
        ]);
    }

    /**
     * Get all articles by category
     */
    public function categoryAction()
    {
        $slug = $this->params('slug');
        $category = $this->getEntityManager()->getRepository('Blog\Entity\Category')
            ->findOneBy(['slug' => $slug]);

        if (!$category)
        {
            throw new EntityNotFoundException('Entity Category not found');
        }

        $articles = $this->getEntityManager()->getRepository('Blog\Entity\Article')
            ->findBy(['category' => $category->getId()]);

        return new ViewModel([
            'articles' => $articles,
            'category' => $category,
        ]);
    }


    /**
     * Get the contact view
     */
    public function contactAction()
    {
        return new ViewModel();
    }

    private function getMaxPerPage() {
        $setting = $this->getEntityManager()->getRepository('Blog\Entity\Setting')->findOneByState(true);

        if (!$setting) {
            return self::MAX_PER_PAGE;
        }
        return $setting->getPagination();
    }
}