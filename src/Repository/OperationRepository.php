<?php

namespace App\Repository;

use App\Entity\Operation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Operation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Operation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Operation[]    findAll()
 * @method Operation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operation::class);
    }

    public function findEndOperation()
    {
        return $this->createQueryBuilder('o')
                    ->where('o.endDate IS NOT NULL')
                    ->andWhere('o.idWorker IS NOT NULL')
                    ->getQuery()
                    ->getResult();
    }

    public function findNowOperation()
    {
        return $this->createQueryBuilder('o')
                    ->where('o.endDate IS NULL')
                    ->andWhere('o.idWorker IS NOT NULL')
                    ->getQuery()
                    ->getResult();
    }

    public function endOperation($id){
        return $this->createQueryBuilder('o')
                    ->update()
                    ->set('o.endDate', ':endDate')
                    ->where('o.id = :id')
                    ->setParameter('id', $id)
                    ->setParameter('endDate', new \DateTime(null, new \DateTimeZone('Europe/Paris')))
                    ->getQuery()
                    ->getResult();
    }

    public function takeOperation($idWorker, $idOp){
        return $this->createQueryBuilder('o')
                    ->update()
                    ->set('o.idWorker', ':idWorker')
                    ->where('o.id = :idOp')
                    ->setParameter('idWorker', $idWorker)
                    ->setParameter('idOp', $idOp)
                    ->getQuery()
                    ->getResult();
    }

    public function getNowOperationForWorker($id){
        return $this->createQueryBuilder('o')
                    ->where('o.endDate IS NULL')
                    ->andWhere('o.idWorker = :idWorker')
                    ->setParameter('idWorker', $id)
                    ->getQuery()
                    ->getResult();
    }

    public function getFreeOperation(){
        return $this->createQueryBuilder('o')
                    ->where('o.idWorker IS NULL')
                    ->getQuery()
                    ->getResult();
    }

    // /**
    //  * @return Operation[] Returns an array of Operation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Operation
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
