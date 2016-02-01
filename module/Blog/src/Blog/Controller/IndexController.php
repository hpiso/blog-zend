<?php

namespace Blog\Controller;

use Admin\Controller\BaseController;
use Blog\Entity\Comment;
use Blog\Form\CommentForm;
use Doctrine\ORM\EntityNotFoundException;
use Zend\View\Model\ViewModel;

class IndexController extends BaseController
{

    public function indexAction()
    {
        $articles = $this->getEntityManager()->getRepository('Blog\Entity\Article')
            ->findBy(['state' => true], ['date' => 'DESC']);

        return new ViewModel([
            'articles' => $articles,
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
}