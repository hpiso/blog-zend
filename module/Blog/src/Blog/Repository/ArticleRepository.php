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
        return $this->createQueryBuilder('a')->select('count(a)')->getQuery()->getSingleScalarResult();
    }

}
