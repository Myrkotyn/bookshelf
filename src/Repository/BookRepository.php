<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BookRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function search($search)
    {
        $qb = $this->createQueryBuilder('b');

        return $qb
            ->join('b.author', 'a')
            ->join('b.language', 'l')
            ->join('b.genre', 'g')
            ->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('a.name', ':search'),
                    $qb->expr()->like('l.name', ':search'),
                    $qb->expr()->like('g.name', ':search'),
                    $qb->expr()->like('b.title', ':search'),
                    $qb->expr()->like('b.ISBNNumber', ':search')
                ))
            ->setParameter('search', '%' . $search . '%')
            ->getQuery()
            ->getResult();
    }
}
