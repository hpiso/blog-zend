<?php

namespace Blog\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ArticleRepository extends EntityRepository
{

    public function getArticlePaginator($offset = 0, $max = 5)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.state = :state')
            ->setParameter('state', true)
            ->orderBy('a.date', 'DESC')
            ->setFirstResult(($offset - 1) * $max)
            ->setMaxResults($max);

        $paginator = new Paginator($qb,false);

        return $paginator;
    }

    public function getArticleCount()
    {
        $qb = $this->createQueryBuilder('a');

        $qb->select('count(a)')
            ->where('a.state = :state')
            ->setParameter('state', true);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getArticleByCategoryPaginator($offset = 0, $max = 5, $categoryId)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.state = :state')
            ->andWhere('a.category = :category')
            ->setParameter('state', true)
            ->setParameter('category', $categoryId)
            ->orderBy('a.date', 'DESC')
            ->setFirstResult(($offset - 1) * $max)
            ->setMaxResults($max);

        $paginator = new Paginator($qb,false);

        return $paginator;
    }

    public function getArticleByCategoryCount($categoryId)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->select('count(a)')
            ->where('a.state = :state')
            ->andWhere('a.category = :category')
            ->setParameter('state', true)
            ->setParameter('category', $categoryId);

        return $qb->getQuery()->getSingleScalarResult();
    }

}
