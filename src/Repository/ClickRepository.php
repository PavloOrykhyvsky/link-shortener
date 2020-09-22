<?php

namespace App\Repository;

use App\Entity\Click;
use App\Entity\Link;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Click|null find($id, $lockMode = null, $lockVersion = null)
 * @method Click|null findOneBy(array $criteria, array $orderBy = null)
 * @method Click[]    findAll()
 * @method Click[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Click::class);
    }

    public function countTotalByLink(Link $link)
    {
        $qb = $this->createQueryBuilder('click');

        return $qb->select('COUNT(click.id) as cnt')
            ->where('click.linkId = :linkId')
            ->setParameter('linkId', $link->getId())
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function uniqueCountTotalByLink(Link $link)
    {
        $qb = $this->createQueryBuilder('click');

        return $qb->select('COUNT(DISTINCT(click.ip)) as cnt')
            ->where('click.linkId = :linkId')
            ->setParameter('linkId', $link->getId())
            ->getQuery()
            ->getSingleScalarResult();
    }
}
