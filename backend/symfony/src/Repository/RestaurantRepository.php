<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

// /**
//  * @extends ServiceEntityRepository<Restaurant>
//  *
//  * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
//  * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
//  * @method Restaurant[]    findAll()
//  * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
//  */
class RestaurantRepository extends ServiceEntityRepository
{
    private $connection;

    public function __construct(ManagerRegistry $registry, \Doctrine\DBAL\Connection $connection)
    {
        parent::__construct($registry, Restaurant::class);
        $this->connection = $connection;
    }

    public function findCategoriesOfIdRestaurant(int $id): ?array
    {
        $sql = "SELECT c.*, rc.desc_rest_cat
                FROM restaurant r
                INNER JOIN restaurant_category rc ON r.id = rc.restaurant_id
                INNER JOIN categories c ON rc.category_id = c.id
                WHERE r.id = :id";

        $result = $this->connection->executeQuery($sql, ['id' => $id]);

        return $result->fetchAllAssociative();
    }

    public function insertDescInRel(int $id_rest, int $id_cat, string $description)
    {
        $sql = "UPDATE restaurant_category SET desc_rest_cat = :desc_rest_cat WHERE restaurant_id = :id_rest AND category_id = :id_cat";
        $result = $this->connection->executeQuery($sql, ['id_rest' => $id_rest, 'id_cat' => $id_cat, 'desc_rest_cat' => $description]);

        return $result->fetchAllAssociative();
    }
    
    public function deleteRel(int $id_rest, int $id_cat)
    {
        $sql = "DELETE FROM restaurant_category WHERE restaurant_id = :id_rest AND category_id = :id_cat";
        $result = $this->connection->executeQuery($sql, ['id_rest' => $id_rest, 'id_cat' => $id_cat]);

        return $result->fetchAllAssociative();
    }

}






