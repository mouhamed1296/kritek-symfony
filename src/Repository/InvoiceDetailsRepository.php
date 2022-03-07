<?php

namespace App\Repository;

use App\Entity\InvoiceDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InvoiceDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method InvoiceDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method InvoiceDetails[]    findAll()
 * @method InvoiceDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvoiceDetails::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(InvoiceDetails $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(InvoiceDetails $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return InvoiceDetails[] Returns an array of InvoiceDetails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByInvoiceId(int $invoice_id): ?InvoiceDetails
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.invoice_id = :invoice_id')
            ->setParameter('invoice_id', $invoice_id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
