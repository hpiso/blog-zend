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
            ->constructPagination($nbArticles, $currentPage,$this::MAX_PER_PAGE);

        $articles = $this->getEntityManager()->getRepository('Blog\Entity\Article')
            ->getArticlePaginator($pagination['current'], $this::MAX_PER_PAGE);

        return new ViewModel([
            'articles'   => $articles,
            'pagination' => $pagination,
        ]);
    }

    public function showAction()
    {
        $slug = $this->params('slug');
        $article = $this->getEntityManager()->getRepository('Blog\Entity\Article')
            ->findOneBy(['slug' => $slug]);

        if (!$article) {
            throw new EntityNotFoundException('Entity Article not found');
        }

        $comments = $this->getEntityManager()->getRepository('Blog\Entity\Comment')
            ->getActiveByArticle($article->getId());

        $comment = new Comment();
        $commentForm = new CommentForm();
        $commentForm->get('submit')->setAttribute('value', 'Ajouter un commentaire');

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
                return $this->redirect()->toRoute('article', ['slug' => $article->getSlug()]);
            }
        }

        return new ViewModel([
            'article'     => $article,
            'comments'    => $comments,
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

        if (!$category) {
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


}