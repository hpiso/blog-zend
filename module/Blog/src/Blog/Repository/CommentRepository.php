<?php
 
namespace Blog\Repository;

use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
    public function getActiveByArticle($id)
    {
        $qb = $this->createQueryBuilder('c');

        $qb ->select('c')
            ->where('c.article = :id')
            ->andWhere('c.state = :state')
            ->orderBy('c.date', 'DESC')
            ->setParameter('id', $id)
            ->setParameter('state', true);

        return $qb->getQuery()->getResult();
    }

}
