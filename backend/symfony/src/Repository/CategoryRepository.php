<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

// /**
//  * @extends ServiceEntityRepository<Category>
//  *
//  * @method Category|null find($id, $lockMode = null, $lockVersion = null)
//  * @method Category|null findOneBy(array $criteria, array $orderBy = null)
//  * @method Category[]    findAll()
//  * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
//  */
class CategoryRepository extends ServiceEntityRepository
{
    private $connection;

    public function __construct(ManagerRegistry $registry, \Doctrine\DBAL\Connection $connection)
    {
        parent::__construct($registry, Category::class);
        $this->connection = $connection;
    }

    public function findRestaurantsOfIdCategory(int $id): ?array
    {
        $sql = "SELECT r.*
                FROM categories c
                LEFT JOIN restaurant_category rc ON c.id = rc.category_id
                LEFT JOIN restaurant r ON rc.restaurant_id = r.id
                WHERE c.id = :id";

        $result = $this->connection->executeQuery($sql, ['id' => $id]);

        return $result->fetchAllAssociative();
    }
    
    public function categoriesNotInRest(int $id): ?array
    {
        $sql = "SELECT * FROM categories c where c.id not in (select rc.category_id from restaurant_category rc where rc.restaurant_id = :id);";

        $result = $this->connection->executeQuery($sql, ['id' => $id]);

        return $result->fetchAllAssociative();
    }
}
