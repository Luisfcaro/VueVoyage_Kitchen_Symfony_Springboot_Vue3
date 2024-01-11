<?php

namespace App\Repository;

use App\Entity\Tables;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tables>
 *
 * @method Tables|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tables|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tables[]    findAll()
 * @method Tables[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TablesRepository extends ServiceEntityRepository
{
    private $connection;
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tables::class);
        $this->connection = $this->getEntityManager()->getConnection();
    }

    public function tablesOfRestNotInBooking(int $id_rest, string $fecha, int $id_turno): ?array
    {

        $sql = "SELECT t.*
                FROM tables t
                WHERE t.id_rest = :id_rest
                AND t.id_table NOT IN (
                    SELECT bt.id_table
                    FROM bookings_tables bt
                    JOIN bookings b ON bt.id_booking = b.id
                    WHERE b.id_rest = :id_rest
                        AND b.date = :fecha
                        AND b.id_turn = :id_turno
                ) 
        ";

        $result = $this->connection->executeQuery($sql, ['id_rest' => $id_rest, 'fecha' => $fecha, 'id_turno' => $id_turno]);

        return $result->fetchAllAssociative();
    }

//    /**
//     * @return Tables[] Returns an array of Tables objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Tables
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
