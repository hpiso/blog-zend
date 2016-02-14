<?php

namespace Admin\Controller;

use Admin\Form\CategoryForm;
use Blog\Entity\Category;
use Doctrine\ORM\EntityNotFoundException;
use Zend\View\Model\ViewModel;


class CategoryController extends BaseController
{

    public function indexAction()
    {
        $categories = $this->getEntityManager()->getRepository('Blog\Entity\Category')->findAll();

        return new ViewModel([
            'categories' => $categories
        ]);
    }

    public function addAction()
    {
        $form = new CategoryForm();
        $form->get('submit')->setAttribute('value', 'Ajouter');
        $category = new Category();

        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $category = $this->getHydrator()->hydrate($form->getData(), $category);

                //Persist and flush entity Category
                $em = $this->getEntityManager();
                $em->persist($category);
                $em->flush();

                //Add flash message
                $this->flashMessenger()->addMessage('La catégorie '. $form->getData()['name'].' a été ajouté.');

                //Redirection
                return $this->redirect()->toRoute('admin/categories');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    public function editAction()
    {
        $id = $this->params('id');
        $category = $this->getEntityManager()->getRepository('Blog\Entity\Category')->find($id);

        if (!$category) {
            throw new EntityNotFoundException('Entity Category not found');
        }

        $form = new CategoryForm();
        $form->setData((array) $category);
        $form->get('submit')->setAttribute('value', 'Modifier');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $category = $this->getHydrator()->hydrate($form->getData(), $category);

                //Persist and flush entity Category
                $em = $this->getEntityManager();
                $em->persist($category);
                $em->flush();

                //Add flash message
                $this->flashMessenger()->addMessage('La catégorie '. $form->getData()['name'].' a été modifié.');

                //Redirection
                return $this->redirect()->toRoute('admin/categories');
            }
        }

        return new ViewModel([
            'form'     => $form,
            'category' => $category
        ]);
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $category = $this->getEntityManager()->getRepository('Blog\Entity\Category')->find($id);

        if (!$category) {
            throw new EntityNotFoundException('Entity Category not found');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            //Remove Category entity
            $em = $this->getEntityManager();
            $em->remove($category);
            $em->flush();

            //Add flash message
            $this->flashMessenger()->addMessage('La catégorie '. $category->getName().' a été supprimé.');
        }

        //Redirection
        return $this->redirect()->toRoute('admin/categories');
    }

}